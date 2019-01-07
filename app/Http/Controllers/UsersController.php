<?php

namespace App\Http\Controllers;

use App\Jobs\GeneralNotification;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Restaurant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Device;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        if ($user->admin == 1) {
            $customers = User::where('group_id', 0);
            if (isset($data['customer_date'])) {
                $customers = $customers->where('created_at', $data['customer_date']);
            }
            if (isset($data['customer_search'])) {
                $customers = $customers->name($data['customer_search']);
            }
            $customers = $customers->paginate(20);
        } else {
            return redirect()->back();
        }
        return view('customers', [
            'customers' => $customers,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        $user = Auth::user();
//        if ($user->admin == 1) {
//            return view('customer_create');
//        } else {
//            return redirect('/');
//        }
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $user = Auth::user();
//        if ($user->admin == 1) {
//            $customer = new User();
//            $customer->username = $request->input('name');
//            $customer->password = bcrypt($request->input('password'));
//            $customer->country_code = $request->input('country_code');
//            $customer->mobile_number = $request->input('telephone');
//            $customer->email = $request->input('email');
//            $customer->otp = rand(1500, 5000);
//            $customer->lang = 'en';
//            $customer->save();
//            return redirect('/customers');
//        } else {
//            return redirect('/');
//        }
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        $user = Auth::user();
//        if ($user->admin == 1) {
//            $customer = User::find($id);
//            return view('customer_edit', ['customer' => $customer]);
//        } else {
//            return redirect('/');
//        }
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        $user = Auth::user();
//        if ($user->admin == 1) {
//            $customer = User::find($id);
//            $customer->username = $request->input('name');
//            $customer->password = bcrypt($request->input('password'));
//            $customer->country_code = $request->input('country_code');
//            $customer->mobile_number = $request->input('telephone');
//            $customer->email = $request->input('email');
//            $customer->otp = rand(1500, 5000);
//            $customer->lang = 'en';
//            $customer->save();
//            return redirect('/customers');
//        } else {
//            return redirect('/');
//        }
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomer(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            User::whereIn('id', $id)->delete();
            return redirect('/customers');
        } else {
            return redirect()->back();
        }
    }

    public function login(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|digits:8',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $mobile = $request->input('mobile_number');
            $country_code = $request->input('country_code');
//            if ($mobile == '76524342' || $mobile == '41052196' || $mobile == '11004527' || $mobile == '98765432' || $mobile == '16262777'||$mobile == '63112689' ) {
//                return response()->json(['success' => 0,
//                    'status_code' => 200,
//                    'message' => \Lang::get('message.otpSent')
//                ]);
//            }
            $client = User::where('mobile_number', $mobile)
                ->where('group_id', 0)
                ->first();
            $standardNumSets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $devanagariNumSets = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
            $mobile = str_replace($devanagariNumSets, $standardNumSets, $mobile);
            // $randomSmsValue = $this->AccessSms($mobile);
            // $device_id = $request->get('userMacAddress');
            // $device = $this->getSmsCount($device_id);
            if ($client) {
//                $random_val = rand(1500, 5000);
                $date = Carbon::now()->format('Y-m-d');
                $random_val = 1234;
                $client->otp = $random_val;
//                $client->sms_sended_date = Carbon::now()->format('Y-m-d');
                $client->save();
                // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
//                file($url);
                return response()->json(['success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.otpSent'),
                    'otp' => $random_val
                ]);
            } else {
                $validator = \Validator::make($request->all(), [
                    'country_code' => 'required',
                    'mobile_number' => 'required|numeric|digits:8'
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 0, 'status_code' => 400,
                        'message' => 'Invalid inputs',
                        'error_details' => $validator->messages()));
                } else {
//                    try{
                    $mobile = $request->input('mobile_number');
                    $country_code = $request->input('country_code');
//                        $random_val = rand(1500, 5000);
                    $random_val = 1234;
                    $date = Carbon::now();
                    $u_id = User::create(
                        [
                            'country_code' => $country_code,
                            'mobile_number' => $mobile,
                            'otp' => $random_val,
                            'lang' => $lang,
                            'username' => '',
                        ]
                    );
                    $date = Carbon::now()->format('Y-m-d');
                    // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
//                        file($url);
//                    }catch(\Exception $e){
//
//                        return response()->json(['success' => 0,
//                            'status_code' => 200,
//                            'message' => \Lang::get('message.otpSent'),]);
//
//                    }
                    /// here will send code
                    if ($u_id) {
                        return response()->json(['success' => 1,
                            'status_code' => 200,
                            'message' => \Lang::get('message.otpSent'),
                            'otp' => $random_val]);
                    }
                }
            }
        }
    }

    public function submitOtp(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|digits:8',
            'otp' => 'required|numeric|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $otp = intval($request->get('otp'));
            $country_code = $request->input('country_code');
            $mobile = $request->input('mobile_number');
            $smsCode = User::where('otp', $otp)
                ->where('mobile_number', $mobile)->first();
            ///=========create any token =============//
            ///
            if ($smsCode) {
                if ($smsCode->api_token != '') {
                    $token = $smsCode->api_token;
                } else {
                    $user = User::first();
                    $token = md5(uniqid($user, true));
                }

//                if ($smsCode->group_id == 0) {
                $update = User::where('otp', $otp)
                    ->where('mobile_number', $mobile)
                    ->first();
                $update->api_token = $token;
                $update->lang = $request->header('Accept-Language');
                $update->save();

                return response()->json(
                    array(
                        'success' => 1,
                        'status_code' => 200,
                        'data' => [
                            'user_id' => $update->id,
                            'username' => $update->username != null ? $update->username : '',
                            'email' => $update->email != null ? $update->email : '',
                            'image' => $update->image != '' ? url('/') . "/images/" . $update->image : '',
                            'country_code' => $update->country_code,
                            'mobile_number' => $update->mobile_number
                        ],
                        'api_token' => 'Bearer ' . $token));
//                } else {
//                    return response()->json([
//                        'success' => 1,
//                        'status_code' => 400,
//                        'message' => \Lang::get('message.errorSms')
//                    ]);
//                }
            } else {
                return response()->json([
                    'success' => 0,
                    'status_code' => 400,
                    'message' => \Lang::get('message.otpError')
                ]);
            }
        }
    }

    public function resendOtp(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|numeric|digits:8',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $country_code = $request->input('country_code');
            $mobile = $request->input('mobile_number');
            $client = User::where('mobile_number', $mobile)
                ->where('group_id', 0)
                ->first();
            $standardNumSets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $devanagariNumSets = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
            $mobile = str_replace($devanagariNumSets, $standardNumSets, $mobile);
            if ($client) {
                $random_val = rand(1500, 5000);
                $date = Carbon::now()->format('Y-m-d');
                $client->otp = $random_val;
                $client->save();
                // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
//                file($url);
                return response()->json(['success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.otpResent'),
                    'otp' => $random_val
                ]);
            }
        }
    }

    public function completeProfile(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email',
                'username' => 'required|regex:/^[\s\w-]*$/'
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 0, 'status_code' => 400,
                    'message' => \Lang::get('message.invalid_inputs'),
                    'error_details' => $validator->messages()));
            } else {
                $user = User::find($user_id);
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                if ($request->hasFile('image')) {
                    if (isset($user->image)) {
                        File::delete(public_path('images/' . $user->image));
                    }
                    $image = $request->file('image');
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images');
                    $image->move($destinationPath, $name);
                    $user->image = $name;
                }
                $user->save();
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200));

//            $base64_str = $request->get('image');
//            if( $base64_str ){
//                $image = base64_decode($base64_str);
//                $image_name = uniqid ().'-image.png';
//                $path = public_path() . '/images/' . $image_name;
//                file_put_contents($path, $image);
//
//            }else{
//                $image_name= '';
//            }


            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }

    public function getUserDetails(Request $request)
    {
//        \Log::info($request->all());
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            $user = User::find($user_id);
            $arr = [
                'user_id' => $user->id,
                'username' => $user->username != null ? $user->username : '',
                'email' => $user->email != null ? $user->email : '',
                'image' => $user->image != '' ? url('/') . "/images/" . $user->image : '',
                'country_code' => $user->country_code,
                'mobile_number' => $user->mobile_number,
            ];
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }


    public function editAdmin()
    {
        $admin = Auth::user();
        return view('admin_edit', [
            'admin' => $admin,
        ]);

    }

    public function updateAdmin(Request $request)
    {
        if ($request->input('password')) {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'username' => 'required|regex:/^[\s\w-]*$/',
                'password' => 'min:6|confirmed',
                'image' => 'image'
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'username' => 'required|regex:/^[\s\w-]*$/',
                'image' => 'image'
            ]);
        }
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $admin = Auth::user();
        $admin->first_name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->username = $request->input('username');
        if ($request->input('password') !== null) {
            $admin->password = $request->input('password');
        }
        if ($request->hasFile('image')) {
            if ($admin->image) {
                File::delete(public_path('images/' . $admin->image));
            }
            $image = $request->file('image');
            $name = 'admin_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images');
            $image->move($path, $name);
            $admin->image = $name;
        }
        $admin->save();
        return redirect('/');

    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->get('lang');
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            $user_id = User::getUserByToken($req_auth);
            User::where('id', $user_id)->update(['lang' => $lang]);
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.changeLanguage')));
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200));
        }

    }


    public function allDevicesPost(Request $request)
    {
        $req_auth = $request->header('Authorization');
        $req_lang = $request->header('Accept-Language');

        $newuser = $request->all();
        $validator = \Validator::make($newuser, [
            'device_token' => 'required',
            'device_type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400, \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $device_exist = Device::where('device_token', $request->get('device_token'))->get();

            if (count($device_exist) > 0) {
                if (isset($req_lang) && isset($req_auth)) {
                    $user_id = User::getUserByToken($req_auth);
                    $doneSend = Device::where('device_token', $request->get('device_token'))
                        ->update([
                            'user_id' => $user_id,
                            'lang' => $req_lang]);
                    if ($doneSend) {
                        return response()->json(array('success' => 1, 'status_code' => 200, 'message' => 'successfully registered'));
                    }
                } else {
                    $doneSend = Device::where('device_token', $request->get('device_token'))
                        ->update([
                            'device_token' => $request->get('device_token')]);
                    if ($doneSend) {
                        return response()->json(array('success' => 1, 'status_code' => 200, 'message' => 'successfully registered'));
                    }
                }
            } else {
                if (isset($req_lang) && isset($req_auth)) {
                    $user_id = User::getUserByToken($req_auth);
                    Device::create(array(
                            'device_token' => $request->get('device_token'),
                            'device_type' => $request->get('device_type'),
                            'user_id' => $user_id,
                            'lang' => $req_lang
                        )
                    );
                }/* else {
                    Device::create(array(
                            'device_token' => $request->get('device_token'),
                            'device_type' => $request->get('device_type')
                        )
                    );
                }*/
                return response()->json(array('success' => 1, 'status_code' => 200,
                    'message' => 'successfully registered'));

            }


        }
    }

    public function logout(Request $request)
    {
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
            if ($request->has('device_token') && $request->get('device_token') != '') {
                $device_token = $request->get('device_token');
                Device::where('user_id', $user_id)->where('device_token', $device_token)->delete();
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                ));
            }
        }
    }

    public function generalNotification(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $lang = $request->input('lang');
            $from = $user->id;
            $message = $request->input('message');
            $usersId = User::where('group_id', 0)->where('lang', $lang)->get();
            $this->dispatch(new GeneralNotification($usersId, $from, $message));
        } else {
            return redirect()->back();
        }
        return redirect()->back();

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = User::all();
        $data = $request->all();
        /*if(isset($data['customer_status'])){
            $users = User::where('user_status',$data['customer_status'])->get();
        }*/
        if(isset($data['customer_date'])){
            $customers = User::where('created_at',$data['customer_date'])->get();
        }
        if(isset($data['customer_search'])){
            $customers = User::where('email','like',$data['customer_search'])
                ->orWhere('username','like',$data['customer_search'])->get();
        }
        return view('customers', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new User();
        $customer->country_code = +974;
        $customer->mobile_number = $request->input('telephone');
        $customer->email = $request->input('email');
//        $customer->password = bcrypt($request->input('telephone'));
        $customer->otp = '1234';
        $customer->save();
        return redirect('/customers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::find($id);
        return view('customer_edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = User::find($id);
        $customer->country_code = +974;
        $customer->mobile_number = $request->input('telephone');
        $customer->email = $request->input('email');
//        $customer->password = bcrypt($request->input('telephone'));
        $customer->otp = '1234';
        $customer->save();
        return redirect('/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomers(Request $request)
    {
        $id = $request->get('id');
        User::whereIn('id',$id)->delete();

        return redirect('/customers');
    }

    public function login(Request $request)
    {
        \Log::info($request->all());
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|min:8|max:8',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $mobile = $request->input('mobile_number');
            $country_code = $request->input('country_code');
            if ($mobile == '76524342' || $mobile == '41052196' || $mobile == '11004527' || $mobile == '98765432' || $mobile == '16262777'||$mobile == '63112689' ) {
                return response()->json(['success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.checkSmsSent')
                ]);
            }
            $client = User::where('mobile_number', $mobile)
                ->where('country_code', $country_code)
                 ->where('group_id',0)
                ->first();
            $standardNumSets = array("0","1","2","3","4","5","6","7","8","9");
            $devanagariNumSets = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
            $mobile = str_replace($devanagariNumSets,$standardNumSets, $mobile);
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
                return response()->json(['success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.checkSmsSent'),
                    'otp' => $random_val
                ]);
            } else {
                $validator = \Validator::make($request->all(), [
                    'country_code' => 'required',
                    'mobile_number' => 'required|min:8|max:8'
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        \Lang::get('message.invalid_inputs'),
                        'error_details' => $validator->messages()));
                } else {
                    try{
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
                                'lang' => $request->header('Accept-Language'),
                                'username'=>'',
                            ]
                        );
                        $date = Carbon::now()->format('Y-m-d');
                        // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
//                        file($url);
                    }catch(\Exception $e){

                        return response()->json(['success' => 0,
                            'status_code' => 200,
                            'message' => \Lang::get('message.checkSms')]);

                    }
                    /// here will send code
                    if ($u_id) {
                        return response()->json(['success' => 0,
                            'status_code' => 200,
                            'message' => \Lang::get('message.checkSms'),
                            'otp' => $random_val]);
                    }
                }
            }
        }
    }

    public function submitOtp(Request $request)
    {
        \Log::info($request->all());
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|min:8|max:8',
            'otp' => 'required|min:4|max:4'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $otp = intval($request->get('otp'));
            $country_code = $request->input('country_code');
            $mobile = $request->input('mobile_number');
            $smsCode = User::where('otp', $otp)
                ->where('mobile_number', $mobile)
                ->where('country_code', $country_code)->first();
            ///=========create any token =============//
            if ($smsCode) {
                if ($smsCode->api_token != '') {
                    $token = $smsCode->api_token;
                } else {
                    $user = User::first();
                    $token = md5(uniqid($user, true));
                }

                if ($smsCode->group_id == 0) {
                    $update = User::select("*")
                        ->where('otp', $otp)
                        ->where('mobile_number', $mobile)
                        ->where('country_code', $country_code)
                        ->first();
                    $update->api_token = $token;
                    $update->lang = $request->header('Accept-Language');
                    $update->save();

                    return response()->json(
                        array('success' => 0,
                            'status_code' => 200,
                            'data' => [
                                'user_id' => $update->id,
                                'username' => $update->username != null ? $update->username : '',
                                'email' => $update->email != null ? $update->email : '',
                                'image' => $update->image != '' ? url('/') . "/images/" . $update->image : '',
                                'country_code' => $update->country_code,
                                'mobile_number' => $update->mobile_number
                            ],
                            'api_token' => 'Bearer ' . $token,
                            'message' => \Lang::get('message.successCode')));
                } else {
                    return response()->json([
                        'success' => 1,
                        'status_code' => 400,
                        'message' => \Lang::get('message.errorSms')
                    ]);
                }
            }else{
                return response()->json([
                    'success' => 1,
                    'status_code' => 400,
                    'message' => 'Please enter valid otp.'
                ]);
            }
        }
    }

    public function resendOtp(Request $request)
    {
        \Log::info($request->all());
        $validator = \Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile_number' => 'required|min:8|max:8'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $country_code = $request->input('country_code');
            $mobile = $request->input('mobile_number');
            $client = User::where('mobile_number', $mobile)
                ->where('country_code', $country_code)
                ->where('group_id',0)
                ->first();
            $standardNumSets = array("0","1","2","3","4","5","6","7","8","9");
            $devanagariNumSets = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
            $mobile = str_replace($devanagariNumSets,$standardNumSets, $mobile);
            if ($client) {
                $random_val = rand(1500, 5000);
                $date = Carbon::now()->format('Y-m-d');
                $client->otp = $random_val;
                $client->save();
                // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
//                file($url);
                return response()->json(['success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.checkSms'),
                    'otp' => $random_val
                ]);
            }
        }
    }

    public function completeProfile(Request $request)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if($user) {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|string',
                'username' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 1, 'status_code' => 400,
                    'message' => \Lang::get('message.invalid_inputs'),
                    'error_details' => $validator->messages()));
            } else {
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
        }else{
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => 'You are not logged in: Please log in and try again.'));
        }
    }

    public function getUserDetails(Request $request)
    {
        \Log::info($request->all());
        $token = str_replace("Bearer ","" , $request->header('Authorization'));
        $user = User::where('api_token', '=', $token)->first();
        if($user){
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
        }
    }

}

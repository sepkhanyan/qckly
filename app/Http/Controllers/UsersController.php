<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;


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
        /*if(isset($data['customer_date'])){
            $users = User::where('created_at',$data['customer_date'])->get();
        }*/
        if(isset($data['customer_search'])){
            $customers = User::where('email','like',$data['customer_search'])
                /*->orWhere('name','like',$data['customer_search'])*/->get();
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
        $customer->mobile = $request->input('telephone');
        $customer->email = $request->input('email');
        $customer->password = bcrypt($request->input('telephone'));
        $customer->sms_code = '123456';
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
        $customer->mobile = $request->input('telephone');
        $customer->email = $request->input('email');
        $customer->password = bcrypt($request->input('telephone'));
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
//        $password = $request->input('password');
        $country_key = $request->input('country_key');
        $mobile = $request->input('mobile_number');
//        $newuser['password'] = Hash::make($password);
//        $newuser['country_key'] = $mobile;
        // $newuser['gruop_id'] = 2;
        $newUser = $request->all();
        $newUser['lang'] = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), [
            'mobile_number' => 'required|min:8|max:8'
        ]);
        if ($mobile == '76524342' || $mobile == '41052196' || $mobile == '11004527' || $mobile == '98765432' || $mobile == '16262777'||$mobile == '63112689' ) {
            return response()->json(['success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.checkSmsSent')
            ]);
        }
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $client = User::where('mobile_number', $mobile)
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
                    'message' => \Lang::get('message.checkSmsSent')
                ]);
            } else {
                $validator = \Validator::make($request->all(), [
//                    'country_key' => 'required',
                    'mobile_number' => 'required|min:8|max:8'
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        \Lang::get('message.invalid_inputs'),
                        'error_details' => $validator->messages()));
                } else {

                    try{
                        $first = 0;
//                        $random_val = rand(1500, 5000);
                        $random_val = 1234;
                        $date = Carbon::now();
                        $u_id = User::create(
                            [
//                                'country_key' => $country_key,
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
                            'message' => \Lang::get('message.checkSms')]);
                    }
                }
            }
        }
    }

    public function submitOtp(Request $request)
    {
        $otp = intval($request->get('otp'));
        $smsCode = User::where('otp', $otp)
            ->where('mobile_number', $request->get('mobile_number'))->first();
        $newUser['lang'] = $request->header('Accept-Language');
        $newUser = $request->all();
        ///=========create any token =============//
        if ($smsCode) {
            if ($smsCode->api_token != '') {
                $token = $smsCode->api_token;
            } else {
                $user = User::first();
                $token = md5(uniqid($user, true));
            }
        }
        $validator = \Validator::make($newUser, [
            'mobile_number' => 'required|min:8|max:8'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            if ($smsCode) {
                if ($smsCode->group_id == 0) {
                    $update = User::select("*")
                        ->where('otp', $otp)
                        ->where('mobile_number', $request->get('mobile_number'))
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

            }
        }
    }

    public function resendOtp(Request $request)
    {

        $mobile = $request->input('mobile_number');
        $newUser = $request->all();
//        $newUser['lang'] = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), [
            'mobile_number' => 'required|min:8|max:8'
        ]);
        if ($mobile == '76524342' || $mobile == '41052196' || $mobile == '11004527' || $mobile == '98765432' || $mobile == '16262777'||$mobile == '63112689' ) {
            return response()->json(['success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.checkSmsSent')
            ]);
        }
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            $client = User::where('mobile_number', $mobile)
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
                    'message' => \Lang::get('message.checkSms')
                ]);
            }
        }
    }

}

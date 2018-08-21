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
        $mobile = $request->input('mobile');
//        $newuser['password'] = Hash::make($password);
//        $newuser['country_key'] = $mobile;
        // $newuser['gruop_id'] = 2;
        $newuser['lang'] = $request->header('Accept-Language');
        $newuser = $request->all();
        $validator = \Validator::make($request->all(), [
            'mobile' => 'required|min:8|max:8'
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
            $client = User::where('mobile', $mobile)
                 ->where('group_id',0)
                ->first();
            $standard_numsets = array("0","1","2","3","4","5","6","7","8","9");
            $devanagari_numsets = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
            $mobile = str_replace($devanagari_numsets,$standard_numsets, $mobile);
            // $randomSmsValue = $this->AccessSms($mobile);
            // $device_id = $request->get('userMacAddress');
            // $device = $this->getSmsCount($device_id);
            if ($client) {
//                $random_val = rand(1500, 5000);
                $date = Carbon::now()->format('Y-m-d');
                $random_val = 1234;
                $client->sms_code = $random_val;
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
                    'mobile' => 'required|min:8|max:8'
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
                                'country_key' => $country_key,
                                'mobile' => $mobile,
                                'sms_code' => $random_val,
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

    public function submitCode(Request $request)
    {
        $sms_code = intval($request->get('sms'));
        $smsccode = User::where('sms_code', $sms_code)
            ->where('mobile', $request->get('mobile'))->first();
        $newuser['lang'] = $request->header('Accept-Language');
        $newuser = $request->all();
        ///=========create any token =============//
        if ($smsccode) {
            if ($smsccode->api_token != '') {
                $token = $smsccode->api_token;
            } else {
                $user = User::first();
                $token = md5(uniqid($user, true));
            }
        }
        $validator = \Validator::make($newuser, [
            'mobile' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {
            if ($smsccode) {
                if ($smsccode->gruop_id == 0) {
                    $update = User::select("*")
                        ->where('sms_code', $sms_code)
                        ->where('mobile', $request->get('mobile'))
                        ->first();
                    $update->api_token = $token;
//                    $update->lang = $request->header('Accept-Language');
                    $update->save();
                    return response()->json(
                        array('success' => 0,
                            'status_code' => 200,
                            'data' => [
                                'user_id' => $update->id,
                                'username' => $update->username != null ? $update->username : '',
                                'email' => $update->email != null ? $update->email : '',
                                'image' => $update->image != '' ? url('/') . "/images/" . $update->image : '',
                                'phone_number' => $update->mobile,


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

}

<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|integer|max:8|min:8',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

//    public function login(Request $request)
//    {
////        $password = $request->input('password');
//        $country_key = $request->input('country_key');
//        $mobile = $request->input('mobile_number');
////        $newuser['password'] = Hash::make($password);
////        $newuser['country_key'] = $mobile;
//        // $newuser['gruop_id'] = 2;
//        $newUser = $request->all();
////        $newUser['lang'] = $request->header('Accept-Language');
//        $validator = \Validator::make($request->all(), [
//            'mobile_number' => 'required|min:8|max:8',
//        ]);
//        if ($mobile == '76524342' || $mobile == '41052196' || $mobile == '11004527' || $mobile == '98765432' || $mobile == '16262777'||$mobile == '63112689' ) {
//            return response()->json(['success' => 0,
//                'status_code' => 200,
//                'message' => \Lang::get('message.checkSmsSent')
//            ]);
//        }
//        if ($validator->fails()) {
//            return response()->json(array('success' => 1, 'status_code' => 400,
//                'message' => \Lang::get('message.invalid_inputs'),
//                'error_details' => $validator->messages()));
//        } else {
//            $client = User::where('mobile_number', $mobile)
//                ->where('group_id',0)
//                ->first();
//            $standardNumSets = array("0","1","2","3","4","5","6","7","8","9");
//            $devanagariNumSets = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
//            $mobile = str_replace($devanagariNumSets,$standardNumSets, $mobile);
//            // $randomSmsValue = $this->AccessSms($mobile);
//            // $device_id = $request->get('userMacAddress');
//            // $device = $this->getSmsCount($device_id);
//            if ($client) {
////                $random_val = rand(1500, 5000);
//                $date = Carbon::now()->format('Y-m-d');
//                $random_val = 1234;
//                $client->otp = $random_val;
////                $client->sms_sended_date = Carbon::now()->format('Y-m-d');
//                $client->save();
//                // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
////                file($url);
//                return response()->json(['success' => 0,
//                    'status_code' => 200,
//                    'message' => \Lang::get('message.checkSmsSent')
//                ]);
//            } else {
//                $validator = \Validator::make($request->all(), [
////                    'country_key' => 'required',
//                    'mobile_number' => 'required|min:8|max:8'
//                ]);
//                if ($validator->fails()) {
//                    return response()->json(array('success' => 1, 'status_code' => 400,
//                        \Lang::get('message.invalid_inputs'),
//                        'error_details' => $validator->messages()));
//                } else {
//
//                    try{
//                        $first = 0;
////                        $random_val = rand(1500, 5000);
//                        $random_val = 1234;
//                        $date = Carbon::now();
//                        $u_id = User::create(
//                            [
////                                'country_key' => $country_key,
//                                'mobile_number' => $mobile,
//                                'otp' => $random_val,
//                                'lang' => $request->header('Accept-Language'),
//                                'username'=>'',
//                            ]
//                        );
//                        $date = Carbon::now()->format('Y-m-d');
//                        // $url = "https://connectsms.vodafone.com.qa/SMSConnect/SendServlet?application=http_gw209&password=zpr885mi&content=Your%20Syaanh%20code%20is%20:%20$random_val&destination=00974$mobile&source=97772&mask=Syaanh";
////                        file($url);
//                    }catch(\Exception $e){
//
//                        return response()->json(['success' => 0,
//                            'status_code' => 200,
//                            'message' => \Lang::get('message.checkSms')]);
//
//                    }
//                    /// here will send code
//                    if ($u_id) {
//                        return response()->json(['success' => 0,
//                            'status_code' => 200,
//                            'message' => \Lang::get('message.checkSms')]);
//                    }
//                }
//            }
//        }
//    }
}

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

    public function registerAsUser(Request $request)
    {
        \Log::info($request->all());
        $password = $request->input('password');
        $country_key = $request->input('country_key');
        $mobile = $request->input('mobile');
        $newuser['password'] = Hash::make($password);
        $newuser['country_key'] = $mobile;
        $newuser['group_id'] = 2;
        $newuser['lang'] = $request->header('Accept-Language');
        $newuser = $request->all();
        $validator = \Validator::make($request->all(), [
            'mobile' => 'required|min:8|max:8'
        ]);

        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => \Lang::get('message.invalid_inputs'),
                'error_details' => $validator->messages()));
        } else {

            $client = User::where('mobile', $mobile)
                ->where('gruop_id', 2)
                ->first();
            $standard_numsets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
            $devanagari_numsets = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
            $mobile = str_replace($devanagari_numsets, $standard_numsets, $mobile);
            if ($client) {

                $random_val = rand(15000, 50000);
                $client->sms_code = $random_val;
                $client->sms_sended_date = Carbon::now()->format('Y-m-d');
                $client->save();
                return response()->json(['success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.checkSmsSent')
                ]);

            } else {
                $validator = \Validator::make($request->all(), [
                    'country_key' => 'required',
                    'mobile' => 'required|min:8|max:8'
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        \Lang::get('message.invalid_inputs'),
                        'error_details' => $validator->messages()));
                } else {
                    try {
                        $first = 0;
                        $random_val = rand(15000, 50000);
                        $date = Carbon::now();
                        $u_id = User::create(
                            [
                                'country_key' => $country_key,
                                'mobile' => $mobile,
                                'sms_code' => $random_val,
                                'sms_sended_date' => $date,
                                'sms_count' => 1,
                                'group_id' => 2,
                                'lang' => $request->header('Accept-Language'),
                                'username' => '',
                            ]
                        );

                    } catch (\Exception $e) {

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
}

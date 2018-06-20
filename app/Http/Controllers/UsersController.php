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
    public function index()
    {
        $users = User::all();
        return view('customers', ['users' => $users]);
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
        $user = new User();
        $user->mobile = $request->input('telephone');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('telephone'));
        $user->sms_code = '123456';
        $user->save();
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
        $user = User::find($id);
        return view('customer_edit', ['user' => $user]);
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
        $user = User::find($id);
        $user->mobile = $request->input('telephone');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('telephone'));
        $user->save();
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
        User::whereIn('user_id',$id)->delete();


        return redirect('/customers');
    }

    public function registerAsUser(Request $request)
    {

        \Log::info($request->all());
        $password = $request->input('password');
        $mobile = $request->input('mobile');
        $newuser['password'] = bcrypt($password);
        $newuser['staff_id'] = 2;
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
                ->where('staff_id', 2)
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

                    'mobile' => 'required|min:8|max:8'
                ]);
                if ($validator->fails()) {
                    return response()->json(array('success' => 1, 'status_code' => 400,
                        \Lang::get('message.invalid_inputs'),
                        'error_details' => $validator->messages()));
                } else {
                    $random_val = 123456;

                    $u_id = User::create(
                        [

                            'mobile' => $mobile,
                            'staff_id' => 2,
                            'salt' => '',
                            'sms_code' => $random_val,
//                          'sms_sended_date' => $date,
                            'sms_count' => 1,
                            'username'=>'',
                            'password' => bcrypt($password)

                        ]
                    );
                    try {
//                        $first = 0;
//                        $date = Carbon::now();


                    } catch (\Exception $e) {




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

    public function submitcode(Request $request)
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
            if (count($smsccode)) {
                $update=User::select("*")
                    ->where('sms_code', $sms_code)
                    ->where('mobile', $request->get('mobile'))
                    ->first();

                $update->active = 1;
                $update->api_token = $token;
                $update->lang = $request->header('Accept-Language');
                $update->save();
                return response()->json(
                    array('success' => 1,
                        'status_code'   => 200,
                        'data'          =>[
                            'userId'    => $update->id,
                            'username'  => $update->username!=null?$update->username:'',
                            'email'     => $update->email!=null?$update->email:'',
                            'image'     => $update->image!=''?url('/')."/images/" .$update->image:'',
                            'phone_number'=>$update->mobile,
                            'CompletedRequestsForClient' => $countofcompletedrequsts,

                        ],
                        'api_token'     => 'Bearer ' . $token,
                        'message'       => \Lang::get('message.successCode')));
            } else {
                return response()->json([
                    'success' => 0,
                    'status_code' => 400,
                    'message' => \Lang::get('message.errorsms')
                ]);
            }

        }
    }
}

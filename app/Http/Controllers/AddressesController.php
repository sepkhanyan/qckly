<?php

namespace App\Http\Controllers;

use App\Address;
use App\UserCart;
use App\User;
use App\Order;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addAddress(Request $request, $id = null)
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
            $DataRequests = $request->all();
            $validator = \Validator::make($DataRequests, [
                'name' => 'required|string',
                'mobile_number' => 'required|numeric|digits:8',
                'location' => 'required|string',
                'street_number' => 'required|string',
                'building_number' => 'required',
                'zone' => 'required|string',
                'apartment_number' => 'required',
                'is_apartment' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ]);
            if ($validator->fails()) {
                return response()->json(array('success' => 0, 'status_code' => 400,
                    'message' => 'Invalid inputs',
                    'error_details' => $validator->messages()));
            } else {
                if ($id) {
                    $address = Address::where('id', $id)->where('user_id', $user_id)->first();
                    $address->name = $DataRequests['name'];
                    $address->mobile_number = $DataRequests['mobile_number'];
                    $address->location = $DataRequests['location'];
                    $address->street_number = $DataRequests['street_number'];
                    $address->building_number = $DataRequests['building_number'];
                    $address->zone = $DataRequests['zone'];
                    $address->is_apartment = $DataRequests['is_apartment'];
                    $address->apartment_number = $DataRequests['apartment_number'];
                    $address->latitude = $DataRequests['latitude'];
                    $address->longitude = $DataRequests['longitude'];
                    $address->save();
                } else {
                    Address::where('user_id', $user_id)->where('is_default', 1)->update(['is_default' => 0]);
                    $address = new Address();
                    $address->user_id = $user_id;
                    $address->is_default = 1;
                    $address->name = $DataRequests['name'];
                    $address->mobile_number = $DataRequests['mobile_number'];
                    $address->location = $DataRequests['location'];
                    $address->street_number = $DataRequests['street_number'];
                    $address->building_number = $DataRequests['building_number'];
                    $address->zone = $DataRequests['zone'];
                    $address->is_apartment = $DataRequests['is_apartment'];
                    $address->apartment_number = $DataRequests['apartment_number'];
                    $address->latitude = $DataRequests['latitude'];
                    $address->longitude = $DataRequests['longitude'];
                    $address->save();
                    $deliveryAddress = Address::where('user_id', $user_id)->where('id','!=', $address->id)->first();
                    if(!$deliveryAddress){
                        UserCart::where('user_id', $user_id)->where('completed', 0)->update(['delivery_address_id' => $address->id]);
                    }
                }

                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'address_id' => $address->id));
            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getAddresses(Request $request)
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
            $addresses = Address::where('user_id', $user_id)->where('deleted', 0)->orderby('id', 'desc')->paginate(20);
            if (count($addresses) > 0) {
                foreach ($addresses as $address) {
                    if ($address->is_apartment == 1) {
                        $is_apartment = true;
                    } else {
                        $is_apartment = false;
                    }
                    if ($address->is_default == 1) {
                        $default = true;
                    } else {
                        $default = false;
                    }
                    $arr [] = [
                        'address_id' => $address->id,
                        'address_name' => $address->name,
                        'mobile_number' => $address->mobile_number,
                        'location' => $address->location,
                        'street_number' => $address->street_number,
                        'building_number' => $address->building_number,
                        'zone' => $address->zone,
                        'is_apartment' => $is_apartment,
                        'apartment_number' => $address->apartment_number,
                        'is_default' => $default,
                        'latitude' => $address->latitude,
                        'longitude' => $address->longitude,
                    ];
                }
                $wholeData = [
                    "total" => $addresses->total(),
                    "count" => $addresses->count(),
                    "per_page" => 20,
                    "current_page" => $addresses->currentPage(),
                    "next_page_url" => $addresses->nextPageUrl(),
                    "prev_page_url" => $addresses->previousPageUrl(),
                    "from" => $addresses->firstItem(),
                    "to" => $addresses->lastItem(),
                    "last_page" => $addresses->lastPage(),
                    'data' => $arr,
                ];
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'Accept-Language' => $lang,
                    'data' => $wholeData));

            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noAddress'),
                    'data' => []));
            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function changeDefaultAddress(Request $request, $id)
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
            $address = Address::where('id', $id)->where('user_id', $user_id)->where('deleted', 0)->first();
            if ($address) {
                Address::where('user_id', $user_id)->where('is_default', 1)->update(['is_default' => 0]);
                $address->is_default = 1;
                $address->save();
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200));
            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noAddress')));
            }
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAddress(Request $request, $id)
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
            $address = Address::where('id', $id)->where('user_id', $user_id)->where('deleted', 0)->first();
            if ($address) {
                Address::where('id', $id)->where('user_id', $user_id)->where('deleted', 0)->update(['deleted' => 1, 'is_default' => 0]);
            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noAddress')));
            }
            $default_address = Address::where('user_id', $user_id)->where('is_default', 1)->where('deleted', 0)->first();
            if (!$default_address) {
               $newDefaultAddress =  Address::where('user_id', $user_id)->where('deleted', 0)->orderBy('id', 'desc')->first();
               if($newDefaultAddress){
                   $newDefaultAddress->is_default = 1;
                   $newDefaultAddress->save();
               }
            }
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.addressDelete')));
        } else {
            return response()->json(array(
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.loginError')));
        }
    }
}

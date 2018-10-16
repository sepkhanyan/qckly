<?php

namespace App\Http\Controllers;

use App\CollectionMenu;
use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use App\Area;
use App\WorkingHour;
use App\Menu;
use App\Category;
use App\RestaurantCategory;
use App\CategoryRestaurant;
use DB;
use App\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class RestaurantsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $restaurants = Restaurant::paginate(20);
        $data = $request->all();
        if (isset($data['restaurant_search'])) {
            $restaurants = Restaurant::where('name_en', 'like', $data['restaurant_search'])
                ->orWhere('description_en', 'like', $data['restaurant_search'])->paginate(20);
        }
        if ($user->admin == 2) {
            $restaurants = Restaurant::where('user_id', $user->id)->paginate(20);

        }

        return view('restaurants', ['restaurants' => $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $areas = Area::all();
            $categories = RestaurantCategory::all();
            return view('restaurant_create', [
                'areas' => $areas,
                'categories' => $categories,
            ]);
        } else {
            return redirect('restaurants');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $request->validate([
                'manager_name' => 'required|string|max:255',
                'manager_email' => 'required|string|max:255',
                'manager_username' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
                'category' => 'required',
                'restaurant_name_en' => 'required|string|max:255',
                'restaurant_name_ar' => 'required|string|max:255',
                'restaurant_email' => 'required|string|max:255',
                'restaurant_telephone' => 'required|integer',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'address_en' => 'required|string|max:255',
                'address_ar' => 'required|string|max:255',
                'postcode' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'image' => 'required|image'
            ]);
            $manager = new User();
            $manager->first_name = $request->input('manager_name');
            $manager->username = $request->input('manager_username');
            $manager->password = bcrypt($request->input('password'));
            $manager->email = $request->input('manager_email');
            $manager->admin = 2;
            $manager->save();
            $restaurant = new Restaurant();
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $restaurant->image = $name;
            $restaurant->user_id = $manager->id;
            $restaurant->name_en = $request->input('restaurant_name_en');
            $restaurant->name_ar = $request->input('restaurant_name_ar');
            $restaurant->email = $request->input('restaurant_email');
            $restaurant->telephone = $request->input('restaurant_telephone');
            $restaurant->address_en = $request->input('address_en');
            $restaurant->address_ar = $request->input('address_ar');
//            $restaurant->city_en = $request->input('city_en');
//            $restaurant->city_ar = $request->input('city_ar');
            $restaurant->state_en = $request->input('state_en');
            $restaurant->state_ar = $request->input('state_ar');
            $restaurant->postcode = $request->input('postcode');
            $restaurant->area_id = $request->input('country');
            $restaurant->latitude = $request->input('latitude');
            $restaurant->longitude = $request->input('longitude');
            $restaurant->description_en = $request->input('description_en');
            $restaurant->description_ar = $request->input('description_ar');
//            $restaurant->status = $request->input('status');
            $restaurant->save();
            $categories = $request->input('category');
            foreach ($categories as $category) {
                $restaurantCategories = RestaurantCategory::where('id', $category)->get();
                foreach ($restaurantCategories as $restaurantCategory) {
                    $en = $restaurantCategory->name_en;
                    $ar = $restaurantCategory->name_ar;
                }
                $categoryRestaurant = new CategoryRestaurant();
                $categoryRestaurant->restaurant_id = $restaurant->id;
                $categoryRestaurant->category_id = $category;
                $categoryRestaurant->name_en = $en;
                $categoryRestaurant->name_ar = $ar;
                $categoryRestaurant->save();
            }

            $days = $request->input('daily_days');
            foreach ($days as $day) {
                $working = new WorkingHour();
                $working->type = $request->input('opening_type');
                $working->weekday = $day;
                $working->status = 1;
                $working->restaurant_id = $restaurant->id;
                if ($working->type == 'daily') {
                    $daily = $request->input('daily_hours');
                    if ($daily) {
                        $working->opening_time = Carbon::parse($daily['open']);
                        $working->closing_time = Carbon::parse($daily['close']);
                    };
                }
                if ($working->type == 'flexible') {
                    $flexible = $request->input('flexible_hours');
                    if ($flexible) {
                        $working->opening_time = Carbon::parse($flexible[$day]['open']);
                        $working->closing_time = Carbon::parse($flexible[$day]['close']);
                        $working->status = $flexible[$day]['status'];
                    };
                }
                $working->save();
            }


            if ($restaurant) {
                return redirect('/restaurants');
            }
        } else {
            return redirect('restaurants');
        }
    }

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
    public function edit($id)
    {
        $user = Auth::user();
        $restaurant = Restaurant::find($id);
        $areas = Area::all();
        $categories = RestaurantCategory::all();
        $category_restaurants = CategoryRestaurant::where('restaurant_id', $id)->get();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            if ($user->restaurant->id == $id) {
                $restaurant = Restaurant::find($id);
            } else {
                return redirect('/restaurants');
            }
        }
        $working = WorkingHour::where('restaurant_id', $restaurant->id)->first();
        return view('restaurant_edit', [
            'restaurant' => $restaurant,
            'working' => $working,
            'areas' => $areas,
            'categories' => $categories,
            'category_restaurants' => $category_restaurants
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
//            'category' => 'required',
            'restaurant_name_en' => 'required|string|max:255',
            'restaurant_name_ar' => 'required|string|max:255',
            'restaurant_email' => 'required|string|max:255',
            'restaurant_telephone' => 'required|integer',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'address_en' => 'required|string|max:255',
            'address_ar' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        $user = Auth::user();
        $restaurant = Restaurant::find($id);
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            if ($user->restaurant->id == $id) {
                $restaurant = Restaurant::find($id);
            } else {
                return redirect('/restaurants');
            }
        }
        $restaurant->name_en = $request->input('restaurant_name_en');
        $restaurant->name_ar = $request->input('restaurant_name_ar');
        $restaurant->email = $request->input('restaurant_email');
        $restaurant->telephone = $request->input('restaurant_telephone');
        $restaurant->address_en = $request->input('address_en');
        $restaurant->address_ar = $request->input('address_ar');
//        $restaurant->city_en = $request->input('city_en');
//        $restaurant->city_ar = $request->input('city_ar');
        $restaurant->state_en = $request->input('state_en');
        $restaurant->state_ar = $request->input('state_ar');
        $restaurant->postcode = $request->input('postcode');
        $restaurant->area_id = $request->input('country');
        $restaurant->latitude = $request->input('latitude');
        $restaurant->longitude = $request->input('longitude');
        $restaurant->description_en = $request->input('description_en');
        $restaurant->description_ar = $request->input('description_ar');
//        $restaurant->status = $request->input('status');
        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                File::delete(public_path('images/' . $restaurant->image));
            }
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $restaurant->image = $name;
        }
        $restaurant->save();
        $categories = $request->input('category');
        if ($categories) {
            CategoryRestaurant::where('restaurant_id', $id)->delete();
            foreach ($categories as $category) {
                $restaurantCategories = RestaurantCategory::where('id', $category)->get();
                foreach ($restaurantCategories as $restaurantCategory) {
                    $en = $restaurantCategory->name_en;
                    $ar = $restaurantCategory->name_ar;
                }
                $categoryRestaurant = new CategoryRestaurant();
                $categoryRestaurant->restaurant_id = $restaurant->id;
                $categoryRestaurant->category_id = $category;
                $categoryRestaurant->name_en = $en;
                $categoryRestaurant->name_ar = $ar;
                $categoryRestaurant->save();
            }
        }

        $days = $request->input('daily_days');
        $working = WorkingHour::where('restaurant_id', $id)->first();
        if ($working->type != $request->input('opening_type')) {
            WorkingHour::where('restaurant_id', $id)->delete();
            foreach ($days as $day) {
                $working = new WorkingHour();
                $working->type = $request->input('opening_type');
                $working->weekday = $day;
                $working->status = 1;
                $working->restaurant_id = $restaurant->id;
                if ($working->type == 'daily') {
                    $daily = $request->input('daily_hours');
                    if ($daily) {
                        $working->opening_time = Carbon::parse($daily['open']);
                        $working->closing_time = Carbon::parse($daily['close']);
                    };
                }
                if ($working->type == 'flexible') {
                    $flexible = $request->input('flexible_hours');
                    if ($flexible) {
                        $working->opening_time = Carbon::parse($flexible[$day]['open']);
                        $working->closing_time = Carbon::parse($flexible[$day]['close']);
                        $working->status = $flexible[$day]['status'];
                    };
                }
                $working->save();
            }
        }

        return redirect('/restaurants');
    }

    public function changeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $user = Auth::user();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            if ($user->restaurant->id == $id) {
                Restaurant::where('id', $id)->update(['status' => $status]);
            } else {
                return redirect('/restaurants');
            }
        } else {
            Restaurant::where('id', $id)->update(['status' => $status]);
        }
        return redirect('/restaurants');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRestaurant(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            $restaurants = Restaurant::with('menu')->where('id', $id)->get();
            $restaurant_images = [];
            $menu_images = [];
            foreach ($restaurants as $restaurant) {
                if ($restaurant->menu) {
                    foreach ($restaurant->menu as $menu) {
                        $menu_images[] = public_path('images/' . $menu->image);
                    }
                    File::delete($menu_images);
                }
                $restaurant_images[] = public_path('images/' . $restaurant->image);
            }
            File::delete($restaurant_images);
            $rest = Restaurant::whereIn('id', $id)->first();
            $rest->delete();
            User::where('id', $rest->user_id)->delete();
            return redirect('/restaurants');
        } else {
            return redirect('/restaurants');
        }
    }


    public function getRestaurants(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $restaurants = Restaurant::with(['menu', 'categoryRestaurant'])->paginate(20);
        if (count($restaurants) > 0) {
            foreach ($restaurants as $restaurant) {
                $famous = null;
                $famous = [];

                foreach ($restaurant->menu as $menu) {

                    if ($menu->famous == 1) {
                        $image = url('/') . '/images/' . $menu->image;
                        array_push($famous, $image);
                    }
                }
                $category = [];
                foreach ($restaurant->categoryRestaurant as $categoryRestaurant) {
                    if ($lang == 'ar') {
                        $ar = $categoryRestaurant->name_ar;
                        array_push($category, $ar);
                        $restaurant_name = $restaurant->name_ar;
                    } else {
                        $en = $categoryRestaurant->name_en;
                        array_push($category, $en);
                        $restaurant_name = $restaurant->name_en;
                    }
                }

                $arr [] = [
                    'restaurant_id' => $restaurant->id,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                    'famous_images' => $famous,
                    'restaurant_name' => $restaurant_name,
                    'category' => $category
                ];
            }

            $wholeData = [
                "total" => $restaurants->total(),
                "count" => $restaurants->count(),
                "per_page" => 20,
                "current_page" => $restaurants->currentPage(),
                "next_page_url" => $restaurants->nextPageUrl(),
                "prev_page_url" => $restaurants->previousPageUrl(),
                "from" => $restaurants->firstItem(),
                "to" => $restaurants->lastItem(),
                "last_page" => $restaurants->lastPage(),
                'data' => $arr,
            ];
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $wholeData));
        } else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.noRestaurant')));
        }

    }


    public function getRestaurantByCategory(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'category_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['category_id'];
            $restaurants = Restaurant::whereHas('categoryRestaurant', function ($query) use ($id) {
                $query->where('category_id', $id);
            })->with('menu')->paginate(20);

            if (count($restaurants) > 0) {
                foreach ($restaurants as $restaurant) {
                    $famous = null;
                    $famous = [];

                    foreach ($restaurant->menu as $menu) {

                        if ($menu->famous == 1) {
                            $image = url('/') . '/images/' . $menu->image;
                            array_push($famous, $image);
                        }
                    }

                    $category = [];
                    foreach ($restaurant->categoryRestaurant as $categoryRestaurant) {
                        if ($lang == 'ar') {
                            $ar = $categoryRestaurant->name_ar;
                            array_push($category, $ar);
                            $restaurant_name = $restaurant->name_ar;
                        } else {
                            $en = $categoryRestaurant->name_en;
                            array_push($category, $en);
                            $restaurant_name = $restaurant->name_en;
                        }
                    }
                    $arr[] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                        'famous_images' => $famous,
                        'restaurant_name' => $restaurant_name,
                        'category' => $category
                    ];
                }

                $wholeData = [
                    "total" => $restaurants->total(),
                    "count" => $restaurants->count(),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "last_page" => $restaurants->lastPage(),
                    'data' => $arr,
                ];

                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $wholeData));

            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noRestaurant')));
            }
        }
    }

    public function availableRestaurants(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'area_id' => 'required|integer',
            'working_day' => 'required',
            'working_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['area_id'];
            $working_day = Carbon::parse($DataRequests['working_day'])->dayOfWeek;
            $working_time = $DataRequests['working_time'];
            $working_time = Carbon::parse($working_time);
            $restaurants = Restaurant::
            where('area_id', $id)
                ->whereHas('workingHour', function ($query) use ($working_day, $working_time) {
                    $query->where('weekday', $working_day)
                        ->where('opening_time', '<=', $working_time)
                        ->where('closing_time', '>=', $working_time)
                        ->where('status', 1)
                        ->orWhere('type', '=', '24_7');
                })->with(['menu', 'categoryRestaurant']);

            if (isset($DataRequests['category_id'])) {
                $category = $DataRequests['category_id'];
                $restaurants = $restaurants->whereHas('categoryRestaurant', function ($query) use ($category) {
                    $query->where('category_id', $category);
                })->paginate(20);
            } else {
                $restaurants = $restaurants->paginate(20);
            }

            if (count($restaurants) > 0) {
                foreach ($restaurants as $restaurant) {
                    foreach ($restaurant->workingHour as $workingHour) {
                        $opening = $workingHour->opening_time;
                        $closing = $workingHour->closing_time;
                    }
                    if ($restaurant->status == 1) {
                        $status = \Lang::get('message.open');
                    } else {
                        $status = \Lang::get('message.busy');
                    }

                    $famous = null;
                    $famous = [];
                    foreach ($restaurant->menu as $menu) {

                        if ($menu->famous == 1) {
                            $image = url('/') . '/images/' . $menu->image;
                            array_push($famous, $image);
                        }
                    }

                    $category = [];
                    foreach ($restaurant->categoryRestaurant as $categoryRestaurant) {
                        $id = $categoryRestaurant->category_id;
                        if ($lang == 'ar') {
                            $name = $categoryRestaurant->name_ar;
                            $restaurant_name = $restaurant->name_ar;
                            $restaurant_description = $restaurant->description_ar;
                        } else {
                            $name = $categoryRestaurant->name_en;
                            $restaurant_name = $restaurant->name_en;
                            $restaurant_description = $restaurant->description_en;
                        }

                        $category [] = [
                            'category_id' => $id,
                            'category_name' => $name
                        ];

                    }

                    $rate_sum = 0;
                    $review_count = $restaurant->review->count();
                    foreach ($restaurant->review as $review) {
                        $rate_sum += $review->rate_value;
                    }
                    if ($review_count) {
                        $rating_count = $rate_sum / $review_count;
                    } else {
                        $rating_count = 0;
                    }

                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                        'famous_images' => $famous,
                        'ratings_count' => $rating_count,
                        'review_count' => $review_count,
                        'availability_hours' => date("g:i A", strtotime($opening)) . ' - ' . date("g:i A", strtotime($closing)),
                        'description' => $restaurant_description,
                        'status' => $status,
                        'category' => $category
                    ];

                }

                $wholeData = [
                    "total" => $restaurants->total(),
                    "count" => $restaurants->count(),
                    "per_page" => 20,
                    "current_page" => $restaurants->currentPage(),
                    "next_page_url" => $restaurants->nextPageUrl(),
                    "prev_page_url" => $restaurants->previousPageUrl(),
                    "from" => $restaurants->firstItem(),
                    "to" => $restaurants->lastItem(),
                    "last_page" => $restaurants->lastPage(),
                    'data' => $arr,
                ];
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'Accept-Language' => $lang,
                    'data' => $wholeData));

            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.selectAreaDateTime')));
            }
        }


    }

    public function getRestaurant(Request $request, $id)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $restaurants = Restaurant::where('id', $id)->with(['menu', 'menu.category'])->get();
        if (count($restaurants) > 0) {
            foreach ($restaurants as $restaurant) {
                if (count($restaurant->menu) > 0) {
                    foreach ($restaurant->menu as $menu) {
                        if ($lang == 'ar') {
                            $menu_name = $menu->name_ar;
                            $menu_category = $menu->category->name_ar;
                            $restaurant_name = $restaurant->name_ar;
                        } else {
                            $menu_name = $menu->name_en;
                            $menu_category = $menu->category->name_en;
                            $restaurant_name = $restaurant->name_en;
                        }
                        if ($menu->status == 1) {
                            $status = \Lang::get('message.enable');
                        } else {
                            $status = \Lang::get('message.disable');
                        }
                        $restaurant_menu [] = [
                            'menu_id' => $menu->id,
                            'menu_name' => $menu_name,
                            'menu_price' => $menu->price,
                            'menu_category' => $menu_category,
                            'menu_status' => $status,
                        ];
                    }

                } else {
                    $restaurant_menu = [];
                }
                $arr [] = [
                    'restaurant_id' => $restaurant->id,
                    'restaurant_name' => $restaurant_name,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                    'menu' => $restaurant_menu
                ];
            }

            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));

        } else {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'message' => \Lang::get('message.noRestaurant')));
        }

    }

    public function restaurantMenuItems(Request $request)
    {
        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'restaurant_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 1, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $restaurant_id = $DataRequests['restaurant_id'];

            $restaurants = Restaurant::where('id', $restaurant_id)
                ->with(['menu.category', 'collection.category', 'collection.collectionItem', 'collection.collectionMenu']);
            if (isset($DataRequests['category_id'])) {
                $category_id = $DataRequests['category_id'];
                $restaurants = $restaurants->whereHas('categoryRestaurant', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                })->get();
            } else {
                $restaurants = $restaurants->get();
            }

            if (count($restaurants) > 0) {
                foreach ($restaurants as $restaurant) {
                    if (count($restaurant->collection) > 0) {
                        $menu_collection = [];
                        foreach ($restaurant->collection as $collection) {
                            if ($collection->female_caterer_available == 1) {
                                $female_caterer_available = true;
                            } else {
                                $female_caterer_available = false;
                            }
                            $foodlist = [];
                            $foodlist_images = [];
                            if ($collection->is_available == 1) {
                                $is_available = true;
                            } else {
                                $is_available = false;
                            }
                            $setup = '';
                            $max = '';
                            $requirement = '';
                            $max_persons = -1;
                            $min_serve = -1;
                            $max_serve = -1;
                            $collection_max = -1;
                            $collection_min = -1;
                            $person_increase = false;
                            $collection_price = 0;
                            if ($collection->category_id != 4) {
                                $min_serve = $collection->min_serve_to_person;
                                $max_serve = $collection->max_serve_to_person;
                                $collection_price = $collection->price;
                            }
                            if ($collection->category_id != 2 && $collection->category_id != 4) {
                                $collection_min = $collection->min_qty;
                                $collection_max = $collection->max_qty;
                            }

                            if ($collection->category_id == 1) {
                                $items = [];
                                $menu = [];
                                foreach ($collection->collectionItem as $collection_item) {
                                    if ($lang == 'ar') {
                                        $foodlist [] = $collection_item->menu->name_ar;
                                        $item_name = $collection_item->menu->name_ar;
                                    } else {
                                        $foodlist [] = $collection_item->menu->name_en;
                                        $item_name = $collection_item->menu->name_en;
                                    }

                                    $image = url('/') . '/images/' . $collection_item->menu->image;
                                    array_push($foodlist_images, $image);
                                    if ($collection_item->menu->status == 1) {
                                        $status = true;
                                    } else {
                                        $status = false;
                                    }

                                    $items  [] = [
                                        'item_id' => $collection_item->item_id,
                                        'item_name' => $item_name,
                                        'item_image' => url('/') . '/images/' . $collection_item->menu->image,
                                        'item_qty' => $collection_item->quantity,
                                        'item_price' => $collection_item->menu->price,
                                        'item_price_unit' => \Lang::get('message.priceUnit'),
                                        'item_availability' => $status

                                    ];
                                }
                                $menu [] = [
                                    'menu_name' => \Lang::get('message.combo'),
                                    'items' => $items,
                                ];
                            } else {
                                $menu_min_qty = -1;
                                $menu_max_qty = -1;
                                $menu = [];
                                $collectionMenus = CollectionMenu::where('collection_id', $collection->id)->with(['collectionItem' => function ($query) use ($collection) {
                                    $query->where('collection_id', $collection->id);
                                }])->whereHas('collectionItem' , function ($q) use ($collection) {
                                    $q->where('collection_id', $collection->id);
                                })->get();
                                foreach ($collectionMenus as $collectionMenu) {
                                    $items = [];
                                    if ($collection->category_id != 4 && $collection->category_id != 1) {
                                        $menu_min_qty = $collectionMenu->min_qty;
                                        $menu_max_qty = $collectionMenu->max_qty;
                                    }
                                    foreach ($collectionMenu->collectionItem as $collection_item) {
                                        if ($lang == 'ar') {
                                            $foodlist [] = $collection_item->menu->name_ar;
                                            $item_name = $collection_item->menu->name_ar;
                                            $menu_name = $collectionMenu->category->name_en;
                                        } else {
                                            $foodlist [] = $collection_item->menu->name_en;
                                            $item_name = $collection_item->menu->name_en;
                                            $menu_name = $collectionMenu->category->name_en;
                                        }
                                        $image = url('/') . '/images/' . $collection_item->menu->image;
                                        array_push($foodlist_images, $image);
                                        if ($collection->category_id == 2) {
                                            if ($collection->allow_person_increase == 1) {
                                                $person_increase = true;
                                            } else {
                                                $person_increase = false;
                                            }
                                            $max_persons = $collection->persons_max_count;

                                            $setup_hours = $collection->setup_time / 60;
                                            $setup_minutes = $collection->setup_time % 60;
                                            if ($setup_minutes > 0) {
                                                $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($setup_minutes) . ' ' . \Lang::get('message.minute');
                                            } else {
                                                $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour');
                                            }
                                            $max_hours = $collection->max_time / 60;
                                            $max_minutes = $collection->max_time % 60;
                                            if ($max_minutes > 0) {
                                                $max = floor($max_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($max_minutes) . ' ' . \Lang::get('message.minute');
                                            } else {
                                                $max = floor($max_hours) . ' ' . \Lang::get('message.hour');
                                            }
                                            if ($lang == 'ar') {
                                                $requirement = $collection->requirements_ar;
                                            } else {
                                                $requirement = $collection->requirements_en;
                                            }

                                        }


                                        if ($collection_item->menu->status == 1) {
                                            $status = true;
                                        } else {
                                            $status = false;
                                        }
                                        $items [] = [
                                            'item_id' => $collection_item->menu->id,
                                            'item_name' => $item_name,
                                            'item_image' => url('/') . '/images/' . $collection_item->menu->image,
                                            'item_price' => $collection_item->menu->price,
                                            'item_price_unit' => \Lang::get('message.priceUnit'),
                                            'item_availability' => $status

                                        ];
                                    }

                                    usort($items, function ($item1, $item2) {
                                        return $item2['item_availability'] <=> $item1['item_availability'];
                                    });
                                    $menu [] = [
                                        'menu_id' => $collectionMenu->category->id,
                                        'menu_name' => $menu_name,
                                        'menu_min_qty' => $menu_min_qty,
                                        'menu_max_qty' => $menu_max_qty,
                                        'items' => $items,
                                    ];

                                }
//                                $categories = Category::with(['menu' => function ($query) use ($collection, $restaurant_id){
//                                    $query->where('restaurant_id', $restaurant_id)
//                                        ->whereHas('collectionItem', function ($x) use ($collection){
//                                        $x->where('collection_id', $collection->id);
//                                    });
//                                }])->get();

                            }

                            if ($lang == 'ar') {
                                $collection_name = $collection->name_ar;
                                $collection_description = $collection->description_ar;
                                $collection_type = $collection->category->name_ar;
                                $mealtime = $collection->mealtime->name_ar;
                                $service_provide = $collection->service_provide_ar;
                                $service_presentation = $collection->service_presentation_ar;
                            } else {
                                $collection_name = $collection->name_en;
                                $collection_description = $collection->description_en;
                                $collection_type = $collection->category->name_en;
                                $mealtime = $collection->mealtime->name_en;
                                $service_provide = $collection->service_provide_en;
                                $service_presentation = $collection->service_presentation_en;
                            }

                            $menu_collection [] = [
                                'collection_id' => $collection->id,
                                'collection_name' => $collection_name,
                                'collection_description' => $collection_description,
                                'collection_type_id' => $collection->category_id,
                                'collection_type' => $collection_type,
                                'female_caterer_available' => $female_caterer_available,
                                'mealtime_id' => $collection->mealtime_id,
                                'mealtime' => $mealtime,
                                'collection_min_qty' => $collection_min,
                                'collection_max_qty' => $collection_max,
                                'collection_price' => $collection_price,
                                'collection_price_unit' => \Lang::get('message.priceUnit'),
                                'is_available' => $is_available,
                                'min_serve_to_person' => $min_serve,
                                'max_serve_to_person' => $max_serve,
                                'allow_person_increase' => $person_increase,
                                'persons_max_count' => $max_persons,
                                'service_provide' => $service_provide,
                                'food_list' => $foodlist,
                                'service_presentation' => $service_presentation,
                                'special_instruction' => '',
                                'food_item_image' => url('/') . '/images/' . $collection_item->menu->image,
                                'food_list_images' => $foodlist_images,
                                'setup_time' => $setup,
                                'requirement' => $requirement,
                                'max_time' => $max,
                                'menu_items' => $menu
                            ];
                        }
                        usort($menu_collection, function ($menu1, $menu2) {
                            return $menu2['is_available'] <=> $menu1['is_available'];
                        });
                        $arr = [
                            'restaurant_id' => $restaurant->id,
                            'collections' => $menu_collection
                        ];
                    } else {
                        return response()->json(array(
                            'success' => 1,
                            'status_code' => 200,
                            'message' => \Lang::get('message.noCollection')));
                    }

                }

                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));

            } else {
                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noRestaurant')));
            }

        }

    }


}

<?php

namespace App\Http\Controllers;

use App\Collection;
use App\CollectionMenu;
use App\CollectionUnavailabilityHour;
use App\EditingCategoryRestaurant;
use App\EditingRestaurant;
use App\EditingRestaurantArea;
use App\EditingWorkingHour;
use App\Http\Requests\RestaurantRequest;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use App\Area;
use App\RestaurantArea;
use App\WorkingHour;
use App\Menu;
use App\MenuCategory;
use App\RestaurantCategory;
use App\CategoryRestaurant;
use DB;
use App\Quotation;
use Carbon\Carbon;
use App\Jobs\NewRestaurant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->all();

        $restaurants = Restaurant::where('deleted', 0)->with(['editingRestaurant', 'collection']);

        if (isset($data['restaurant_search'])) {
            $restaurants = $restaurants->where('name_en', 'like', '%' . $data['restaurant_search'] . '%')
                ->orWhere('description_en', 'like', $data['restaurant_search']);
        }

        if ($user->admin == 2) {
            $restaurants = Restaurant::where('id', $user->restaurant_id)->with(['editingRestaurant', 'collection']);
        }

        $restaurants = $restaurants->paginate(20);

        return view('restaurants.restaurants', ['restaurants' => $restaurants, 'user' => $user]);
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

            return view('restaurants.restaurant_create', ['areas' => $areas, 'categories' => $categories,]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantRequest $request)
    {
        $user = Auth::user();

        if ($user->admin == 1) {

            $restaurant = new Restaurant;

            $image = $request->file('image');
            $name = 'restaurant_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/images');
            $image->move($path, $name);

            $restaurant->image = $name;
            $restaurant->name_en = $request->input('restaurant_name_en');
            $restaurant->name_ar = $request->input('restaurant_name_ar');
            $restaurant->email = $request->input('restaurant_email');
            $restaurant->telephone = $request->input('restaurant_telephone');
            $restaurant->description_en = $request->input('description_en');
            $restaurant->description_ar = $request->input('description_ar');
            // $restaurant->address_en = $request->input('address_en');
            // $restaurant->address_ar = $request->input('address_ar');
            // $restaurant->city_en = $request->input('city_en');
            // $restaurant->city_ar = $request->input('city_ar');
            // $restaurant->state_en = $request->input('state_en');
            // $restaurant->state_ar = $request->input('state_ar');
            // $restaurant->postcode = $request->input('postcode');
            // $restaurant->area_id = $request->input('country');
            // $restaurant->latitude = $request->input('latitude');
            // $restaurant->longitude = $request->input('longitude');
            // $restaurant->status = $request->input('status');
            $restaurant->save();

            $manager = new User();
            $manager->first_name = $request->input('manager_name');
            $manager->username = $request->input('manager_username');
            $manager->password = bcrypt($request->input('password'));
            $manager->email = $request->input('manager_email');
            $manager->mobile_number = $request->input('manager_telephone');
            $manager->admin = 2;
            $manager->group_id = 2;
            $manager->restaurant_id = $restaurant->id;
            $manager->save();

            $categories = $request->input('category');

            foreach ($categories as $category) {
                $restaurantCategory = RestaurantCategory::where('id', $category)->first();
                $categoryRestaurant = new CategoryRestaurant();
                $categoryRestaurant->restaurant_id = $restaurant->id;
                $categoryRestaurant->category_id = $category;
                $categoryRestaurant->name_en = $restaurantCategory->name_en;
                $categoryRestaurant->name_ar = $restaurantCategory->name_ar;
                $categoryRestaurant->save();
            }

            $areas = $request->input('area');

            foreach ($areas as $areaId) {
                $area = Area::where('id', $areaId)->first();
                $restaurantArea = new RestaurantArea();
                $restaurantArea->restaurant_id = $restaurant->id;
                $restaurantArea->area_id = $areaId;
                $restaurantArea->name_en = $area->name_en;
                $restaurantArea->name_ar = $area->name_ar;
                $restaurantArea->save();
            }

            foreach ($request->input('flexible_hours') as $flexible) {
                $working = new WorkingHour();
                $working->restaurant_id = $restaurant->id;
                $working->type = $request->input('opening_type');
                $working->weekday = $flexible['day'];
                $working->opening_time = Carbon::parse($flexible['open']);
                $working->closing_time = Carbon::parse($flexible['close']);
                $working->status = $flexible['status'];
                $working->save();
            }

            if ($restaurant) {
                return redirect('/restaurants');
            }
        } else {
            return redirect()->back();
        }
    }

    public function activate($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $restaurant = Restaurant::find($id);
            $collections = Collection::where('restaurant_id', $id)->get();
            if (count($collections) > 0) {
                if ($restaurant->active == 0 && $restaurant->deleted == 0) {
                    $restaurant->active = 1;
                    $restaurant->save();
                }
            }
        } else {
            return redirect()->back();
        }
        return redirect()->back();
    }


    public function notification(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $validator = \Validator::make($request->all(), [
                'lang' => 'required',
                'message' => 'required|string'
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $restaurant = Restaurant::find($id);
            if ($restaurant->active == 1) {
                $lang = $request->input('lang');
                $from = $user->id;
                $msg = $request->input('message');
                $usersId = User::where('group_id', 0)->where('lang', $lang)->get();
                $this->dispatch(new NewRestaurant($usersId, $from, $restaurant->id, $msg));
            }
        } else {
            return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


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

        if ($user->admin == 2) {
            if ($user->restaurant_id == $id) {
                $restaurant = Restaurant::find($id);
            } else {
                return redirect()->back();
            }
        }

        if ($user->admin == 1 && $restaurant->editingRestaurant !== null) {

            $editingRestaurant = $restaurant->editingRestaurant;
            $restaurantAreas = RestaurantArea::where('restaurant_id', $id)->get();
            $editingRestaurantAreas = EditingRestaurantArea::where('editing_restaurant_id', $editingRestaurant->id)->get();
            // $editingAreas = $editingRestaurantAreas->pluck('area_id')->toArray();
            // $areas = $restaurantAreas->pluck('area_id')->toArray();
            // $areaFullDiff = array_merge(array_diff($editingAreas, $areas), array_diff($areas, $editingAreas));
            $categoryRestaurants = CategoryRestaurant::where('restaurant_id', $id)->get();
            $editingCategoryRestaurants = EditingCategoryRestaurant::where('editing_restaurant_id', $editingRestaurant->id)->get();
            // $editingCategories = $editingCategoryRestaurants->pluck('category_id')->toArray();
            // $categories = $categoryRestaurants->pluck('category_id')->toArray();
            // $categoryFullDiff = array_merge(array_diff($editingCategories, $categories), array_diff($categories, $editingCategories));

            return view('restaurants.restaurant_edit_approve', [
                'user' => $user,
                'restaurant' => $restaurant,
                'editingRestaurant' => $editingRestaurant,
                // 'areas' => $areas,
                'restaurantAreas' => $restaurantAreas,
                'editingRestaurantAreas' => $editingRestaurantAreas,
                // 'areaFullDiff' => $areaFullDiff,
                // 'categories' => $categories,
                'categoryRestaurants' => $categoryRestaurants,
                'editingCategoryRestaurants' => $editingCategoryRestaurants,
                // 'categoryFullDiff' => $categoryFullDiff
            ]);
        }

        $restaurantAreas = RestaurantArea::where('restaurant_id', $id)->get();

        $areas = Area::all();

        $selectedArea = [];
        if (count($restaurantAreas) > 0) {
            foreach ($restaurantAreas as $restaurantArea) {
                $selectedArea[$restaurantArea->area_id] = [];
            }
        }

        $categoryRestaurants = CategoryRestaurant::where('restaurant_id', $id)->get();

        $restaurantCategories = RestaurantCategory::all();

        $category = [];
        if (count($categoryRestaurants) > 0) {
            foreach ($categoryRestaurants as $categoryRestaurant) {
                $category[$categoryRestaurant->category_id] = [];
            }
        }

        return view('restaurants.restaurant_edit', [
            'user' => $user,
            'restaurant' => $restaurant,
            'areas' => $areas,
            'selectedArea' => collect($selectedArea),
            'restaurantCategories' => $restaurantCategories,
            'category' => collect($category)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RestaurantRequest $request, $id)
    {
        $user = Auth::user();
        $restaurant = Restaurant::find($id);

        if ($user->admin == 2) {

            if ($user->restaurant_id == $id) {

                $oldEditingRestaurant = EditingRestaurant::where('restaurant_id', $id)->first();

                if ($oldEditingRestaurant) {

                    if ($oldEditingRestaurant->image) {
                        File::delete(public_path('images/' . $oldEditingRestaurant->image));
                    }

                    EditingRestaurant::where('restaurant_id', $id)->delete();
                }

                $restaurant = new EditingRestaurant;

                $editingData = [
                    'name_en' => $request->input('restaurant_name_en'),
                    'name_ar' => $request->input('restaurant_name_ar'),
                    'email' => $request->input('restaurant_email'),
                    'telephone' => $request->input('restaurant_telephone'),
                    'description_en' => $request->input('description_en'),
                    'description_ar' => $request->input('description_ar'),
                    'restaurant_id' => $id
                ];

                if ($request->hasFile('image')) {

                    $image = $request->file('image');
                    $name = 'restaurant_' . time() . '.' . $image->getClientOriginalExtension();
                    $path = public_path('/images');
                    $image->move($path, $name);

                    $editingData['image'] = $name;
                }

                $restaurant->forceFill($editingData);
                $restaurant->save();

                $categories = $request->input('category');

                if ($categories) {

                    $restaurantCategories = RestaurantCategory::whereIn('id', $categories)->get();

                    if ($restaurantCategories->isNotEmpty()) {

                        $categoryRestaurantIds = CategoryRestaurant::where('restaurant_id', $id)->pluck('category_id')->toArray();

                        $categoryFullDiff = array_merge(array_diff($categoryRestaurantIds, $categories), array_diff($categories, $categoryRestaurantIds));

                        if (count($categoryFullDiff) > 0) {

                            foreach ($restaurantCategories as $category) {

                                $categoryRestaurant = new  EditingCategoryRestaurant;
                                $categoryRestaurant->editing_restaurant_id = $restaurant->id;
                                $categoryRestaurant->category_id = $category->id;
                                $categoryRestaurant->name_en = $category->name_en;
                                $categoryRestaurant->name_ar = $category->name_ar;
                                $categoryRestaurant->save();
                            }
                        }
                    }
                }

                $restaurantAreas = $request->input('area');
                if ($restaurantAreas) {

                    $areas = Area::whereIn('id', $restaurantAreas)->get();

                    if ($areas->isNotEmpty()) {

                        $restaurantAreasIds = RestaurantArea::where('restaurant_id', $id)->pluck('area_id')->toArray();

                        $areaFullDiff = array_merge(array_diff($restaurantAreasIds, $restaurantAreas), array_diff($restaurantAreas, $restaurantAreasIds));

                        if (count($areaFullDiff) > 0) {

                            foreach ($areas as $area) {

                                $restaurantArea = new EditingRestaurantArea();
                                $restaurantArea->editing_restaurant_id = $restaurant->id;
                                $restaurantArea->area_id = $area->id;
                                $restaurantArea->name_en = $area->name_en;
                                $restaurantArea->name_ar = $area->name_ar;
                                $restaurantArea->save();
                            }
                        }
                    }
                }

            } else {
                return redirect()->back();
            }
        } elseif ($user->admin == 1) {

            $data = [
                'name_en' => $request->input('restaurant_name_en'),
                'name_ar' => $request->input('restaurant_name_ar'),
                'email' => $request->input('restaurant_email'),
                'telephone' => $request->input('restaurant_telephone'),
                'description_en' => $request->input('description_en'),
                'description_ar' => $request->input('description_ar')
            ];

            if ($request->hasFile('image')) {

                if ($restaurant->image) {
                    File::delete(public_path('images/' . $restaurant->image));
                }

                $image = $request->file('image');
                $name = 'restaurant_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);

                $data['image'] = $name;
            }

            $restaurant->update($data);

            $categories = $request->input('category');
            if ($categories) {
                $restaurantCategories = RestaurantCategory::whereIn('id', $categories)->get();

                if ($restaurantCategories->isNotEmpty()) {

                    CategoryRestaurant::where('restaurant_id', $restaurant->id)->whereNotIn('category_id', $categories)->delete();

                    foreach ($restaurantCategories as $category) {
                        $categoryRestaurant = CategoryRestaurant::firstOrCreate(
                            ['category_id' => $category->id, 'restaurant_id' => $restaurant->id],
                            ['name_en' => $category->name_en, 'name_ar' => $category->name_ar]
                        );
                    }
                }
            }


            $restaurantAreas = $request->input('area');
            if ($restaurantAreas) {
                $areas = Area::whereIn('id', $restaurantAreas)->get();

                if ($areas->isNotEmpty()) {

                    RestaurantArea::where('restaurant_id', $restaurant->id)->whereNotIn('area_id', $restaurantAreas)->delete();

                    foreach ($areas as $area) {
                        $restaurantArea = RestaurantArea::firstOrCreate(
                            ['area_id' => $area->id, 'restaurant_id' => $restaurant->id],
                            ['name_en' => $area->name_en, 'name_ar' => $area->name_ar]
                        );
                    }
                }
            }
        }

        return redirect('/restaurants');
    }

    public function editAvailability($id)
    {
        $user = Auth::user();
        $restaurant = Restaurant::find($id);

        if ($user->admin == 2) {
            if ($user->restaurant_id != $id) {
                return redirect()->back();
            }
        }

        $working_hours = WorkingHour::where('restaurant_id', $restaurant->id)->get();

        return view('restaurants.restaurant_availability_edit', [
            'restaurant' => $restaurant,
            'user' => $user,
            'working_hours' => $working_hours
        ]);
    }

    public function updateAvailability(RestaurantRequest $request, $id)
    {
        $user = Auth::user();
        $restaurant = Restaurant::find($id);
        if ($user->admin == 2) {
            if ($user->restaurant_id != $id) {
                return redirect()->back();
            }
        }
        $opening_type = $request->input('opening_type');
        if ($opening_type) {
            if ($opening_type == 'flexible') {
                foreach ($request->input('flexible_hours') as $flexible) {
                    $working = WorkingHour::updateOrCreate(
                        [
                            'restaurant_id' => $restaurant->id,
                            'type' => $request->input('opening_type'),
                            'weekday' => $flexible['day']
                        ],
                        [
                            'opening_time' => Carbon::parse($flexible['open']),
                            'closing_time' => Carbon::parse($flexible['close']),
                            'status' => $flexible['status']
                        ]);
                }
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
                return redirect()->back();
            }
        } else {
            Restaurant::where('id', $id)->update(['status' => $status]);
        }
        return redirect('/restaurants');

    }

    public function editApprove(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->admin == 1) {

            $data = $request->except('_token', 'category', 'area');

            $restaurant = Restaurant::find($id);

            $editingRestaurant = EditingRestaurant::where('restaurant_id', $id)->first();

            if ($editingRestaurant->image) {

                if ($restaurant->image) {
                    File::delete(public_path('images/' . $restaurant->image));
                }

                $data['image'] = $editingRestaurant->image;
            }

            $restaurant->update($data);

            $categories = $request->input('category');
            if ($categories) {

                $restaurantCategories = RestaurantCategory::whereIn('id', $categories)->get();

                if ($restaurantCategories->isNotEmpty()) {

                    CategoryRestaurant::where('restaurant_id', $restaurant->id)->whereNotIn('category_id', $categories)->delete();

                    foreach ($restaurantCategories as $category) {

                        $categoryRestaurant = CategoryRestaurant::firstOrCreate(
                            ['category_id' => $category->id, 'restaurant_id' => $restaurant->id],
                            ['name_en' => $category->name_en, 'name_ar' => $category->name_ar]
                        );
                    }
                }
            }

            $restaurantAreas = $request->input('area');
            if ($restaurantAreas) {

                $areas = Area::whereIn('id', $restaurantAreas)->get();

                if ($areas->isNotEmpty()) {

                    RestaurantArea::where('restaurant_id', $restaurant->id)->whereNotIn('area_id', $restaurantAreas)->delete();

                    foreach ($areas as $area) {

                        $restaurantArea = RestaurantArea::firstOrCreate(
                            ['area_id' => $area->id, 'restaurant_id' => $restaurant->id],
                            ['name_en' => $area->name_en, 'name_ar' => $area->name_ar]
                        );
                    }
                }
            }

            EditingRestaurant::where('restaurant_id', $restaurant->id)->delete();

            return response()->json([ 'success' => true ]);

        } else {

            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $editingRestaurants = EditingRestaurant::where('restaurant_id', $id)->get();
            $restaurant_images = [];
            foreach ($editingRestaurants as $editingRestaurant) {
                $restaurant_images[] = public_path('images/' . $editingRestaurant->image);
            }
            File::delete($restaurant_images);
            EditingRestaurant::where('restaurant_id', $id)->delete();
            return redirect('/restaurants');
        } else {
            return redirect()->back();
        }
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
            Restaurant::whereIn('id', $id)->update(['deleted' => 1, 'active' => 0]);
            User::whereIn('restaurant_id', $id)->delete();
            return redirect('/restaurants');
        } else {
            return redirect()->back();
        }
    }

    public function getEditedFields(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        $restaurant = Restaurant::with('restaurantArea', 'categoryRestaurant')->find($id);

        if ($user->admin == 1 && !is_null($restaurant)) {

            $oldRestaurant = $restaurant->toArray();
            $oldRestaurant = array_except($oldRestaurant, [
                'id',
                'address_en',
                'address_ar',
                'city_en', 'city_ar',
                'state_en',
                'state_ar',
                'postcode',
                'latitude',
                'longitude',
                'category_id',
                'status',
                'active',
                'created_at',
                'updated_at',
                'deleted',
                'restaurant_area',
                'category_restaurant'
            ]);

            $editedRestaurant = EditingRestaurant::with('editingRestaurantArea', 'editingCategoryRestaurant')->where('restaurant_id', $restaurant->id)->first();

            $newRestaurant = $editedRestaurant->toArray();
            $newRestaurant = array_except($newRestaurant, [ 'id', 'restaurant_id', 'created_at', 'updated_at', 'editing_restaurant_area', 'editing_category_restaurant' ]);

            if (is_null($newRestaurant['image'])) {

                unset($newRestaurant['image']);
                unset($oldRestaurant['image']);
            }

            $oldFields = array_merge(array_diff($newRestaurant, $oldRestaurant), array_diff($oldRestaurant, $newRestaurant));
            $newFields = array_merge(array_diff($oldRestaurant, $newRestaurant), array_diff($newRestaurant, $oldRestaurant));

            if ($editedRestaurant->editingRestaurantArea->isNotEmpty()) {

                $oldAreas = $restaurant->restaurantArea;
                $newAreas = $editedRestaurant->editingRestaurantArea;
            }

            if ($editedRestaurant->editingCategoryRestaurant->isNotEmpty()) {

                $oldCategories = $restaurant->categoryRestaurant;
                $newCategories = $editedRestaurant->editingCategoryRestaurant;
            }

            $data = [
                'restaurant' => $restaurant,
                'oldFields' => $oldFields,
                'newFields' => $newFields,
                'oldAreas' => isset($oldAreas) ? $oldAreas : "",
                'newAreas' => isset($newAreas) ? $newAreas : "",
                'oldCategories' => isset($oldCategories) ? $oldCategories : "",
                'newCategories' => isset($newCategories) ? $newCategories : ""
            ];

            $html = view('restaurants.editing_restaurant', $data)->render();
            return response()->json([ 'success' => true, 'html' => $html ]);

        } else {

            return response()->json([ 'success' => false ]);
        }
    }

    public function getRestaurants(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $restaurants = Restaurant::with(['menu' => function ($query) {
            $query->where('approved', 1)->where('deleted', 0);
        }], 'categoryRestaurant')->where('active', 1)->where('deleted', 0)->paginate(20);
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
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.noRestaurant')));
        }

    }


    public function getRestaurantByCategory(Request $request)
    {
//        \Log::info($request->all());
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
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['category_id'];
            $restaurants = Restaurant::whereHas('categoryRestaurant', function ($query) use ($id) {
                $query->where('category_id', $id);
            })->with(['menu' => function ($query) {
                $query->where('approved', 1)->where('deleted', 0);
            }], 'categoryRestaurant')->where('active', 1)->where('deleted', 0)->paginate(20);

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
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noRestaurant')));
            }
        }
    }

    public function availableRestaurants(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'area_id' => 'required|integer',
            'working_day' => 'date|date_format:d-m-Y|required',
            'working_time' => 'date_format:h:i A|required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $id = $DataRequests['area_id'];
            $restaurants = Restaurant::where('deleted', 0)->where('active', 1)->
            whereHas('restaurantArea', function ($q) use ($id) {
                $q->where('area_id', $id);
            })
                ->with(['menu' => function ($query) {
                    $query->where('approved', 1)->where('deleted', 0);
                }], ['collection' => function ($query) {
                    $query->where('approved', 1)->where('deleted', 0);
                }], 'workingHour', 'categoryRestaurant', 'review');


            if (isset($DataRequests['category_id'])) {
                $category = $DataRequests['category_id'];
                $restaurants = $restaurants->whereHas('categoryRestaurant', function ($query) use ($category) {
                    $query->where('category_id', $category);
                })->with(['collection' => function ($query) use ($category) {
                    $query->where('approved', 1)->where('deleted', 0)->whereHas('serviceType', function ($x) use ($category) {
                        $x->where('deleted', 0)->where('service_type_id', $category);
                    });
                }]);
            }

            $restaurants = $restaurants->paginate(20);

            if (count($restaurants) > 0) {
                foreach ($restaurants as $restaurant) {
                    $working_day = Carbon::parse($DataRequests['working_day'])->dayOfWeek;
                    $working_time = $DataRequests['working_time'];
                    $working_time = date("H:i:s", strtotime($working_time));
                    $restaurantAvailability = $restaurant->workingHour->where('weekday', $working_day)
                        ->where('opening_time', '<=', $working_time)
                        ->where('closing_time', '>=', $working_time)
                        ->where('status', 1)->first();

                    if ($restaurantAvailability) {
                        if ($restaurant->status == 1) {
                            $status_id = 1;
                            $status = \Lang::get('message.open');
                        } else {
                            $status_id = 2;
                            $status = \Lang::get('message.busy');
                        }
                    } else {
                        $status_id = 3;
                        $status = \Lang::get('message.notAvailable');
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
                    if ($review_count > 0) {
                        $rate_sum = $rate_sum / $review_count;
                        $rating_count = ceil($rate_sum) - 0.5;
                        if ($rating_count < $rate_sum) {
                            $rating_count = ceil($rate_sum);
                        }
                    } else {
                        $rating_count = 0;
                    }


//                    $notice_hours = $notice / 60;
//                    $notice_minutes = $notice % 60;
//                    if ($notice_hours >= 1) {
//                        if ($notice_minutes > 0) {
//                            $notice_period = floor($notice_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($notice_minutes) . ' ' . \Lang::get('message.minute');
//                        } else {
//                            $notice_period = floor($notice_hours) . ' ' . \Lang::get('message.hour');
//                        }
//                    } else {
//                        $notice_period = floor($notice_minutes) . ' ' . \Lang::get('message.minute');
//                    }

                    $availability_hours = [];

                    foreach ($restaurant->workingHour as $workingHour) {
                        $availability_hours [] = [
                            'day' => $workingHour->weekday,
                            'open_hour' => $workingHour->opening_time,
                            'close_hour' => $workingHour->closing_time,
                            'day_status' => $workingHour->status
                        ];
                    }

                    $working = $restaurant->workingHour->first();
                    if ($working->type == 'flexible') {
                        $availability_status_id = 3;
                    }
                    $notice = $restaurant->collection->min('notice_period');

                    $arr [] = [
                        'restaurant_id' => $restaurant->id,
                        'restaurant_name' => $restaurant_name,
                        'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                        'famous_images' => $famous,
                        'ratings_count' => $rating_count,
                        'review_count' => $review_count,
                        'description' => $restaurant_description,
                        'status_id' => $status_id,
                        'status' => $status,
                        'availability_status_id' => $availability_status_id,
                        'availability' => $availability_hours,
                        'notice_period' => $notice,
                        'category' => $category
                    ];

                    usort($arr, function ($arr1, $arr2) {
                        return $arr1['status_id'] <=> $arr2['status_id'];
                    });

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
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.selectAreaDateTime')));
            }
        }


    }

    public function getRestaurant(Request $request, $id)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $restaurants = Restaurant::where('id', $id)->with(['menu' => function ($query) {
            $query->where('approved', 1)->where('deleted', 0);
        }])->where('active', 1)->where('deleted', 0)->get();
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
                'success' => 0,
                'status_code' => 200,
                'message' => \Lang::get('message.noRestaurant')));
        }

    }

    public function restaurantMenuItems(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $validator = \Validator::make($request->all(), []);
        if ($lang == 'ar') {
            $validator->getTranslator()->setLocale('ar');
        }
        $DataRequests = $request->all();
        $validator = \Validator::make($DataRequests, [
            'restaurant_id' => 'required|integer',
            'working_day' => 'date|date_format:d-m-Y|required',
            'working_time' => 'date_format:h:i A|required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('success' => 0, 'status_code' => 400,
                'message' => 'Invalid inputs',
                'error_details' => $validator->messages()));
        } else {
            $restaurant_id = $DataRequests['restaurant_id'];
            $restaurant = Restaurant::where('id', $restaurant_id)->where('active', 1)->where('deleted', 0)
                ->with(['collection' => function ($query) {
                    $query->where('approved', 1)->where('deleted', 0)->with(['serviceType' => function ($x) {
                        $x->where('deleted', 0);
                    }]);
                }], ['menu' => function ($query) {
                    $query->where('approved', 1)->where('deleted', 0);
                }], [
                    'workingHour',
                    'collection.collectionItem',
                    'collection.collectionMenu.category',
                    'collection.collectionMenu.collectionItem.menu',
                    'collection.category',
                    'collection.mealtime',
                    'collection.unavailabilityHour'
                ]);


            if (isset($DataRequests['category_id'])) {
                $category_id = $DataRequests['category_id'];

                $restaurant = $restaurant->with(['collection' => function ($query) use ($category_id) {
                    $query->whereHas('serviceType', function ($q) use ($category_id) {
                        $q->where('service_type_id', $category_id)->where('deleted', 0);
                    })->where('approved', 1)->where('deleted', 0);
                }]);


            }

            $restaurant = $restaurant->first();

            if ($restaurant) {

                $resNotice = $restaurant->collection->min('notice_period');

                $restaurant_details = [];
//                foreach ($restaurants as $restaurant) {
                $menu_collection = [];
                if (count($restaurant->collection) > 0) {
                    foreach ($restaurant->collection as $collection) {
                        if ($collection->female_caterer_available == 1) {
                            $female_caterer_available = true;
                        } else {
                            $female_caterer_available = false;
                        }
                        $foodlist = [];
                        $foodlist_images = [];
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

                            foreach ($collection->collectionMenu as $collectionMenu) {
                                $items = [];
                                if ($collection->category_id != 4 && $collection->category_id != 1) {
                                    $menu_min_qty = $collectionMenu->min_qty;
                                    $menu_max_qty = $collectionMenu->max_qty;
                                }
                                foreach ($collectionMenu->collectionItem as $collection_item) {
                                    if ($lang == 'ar') {
                                        $foodlist [] = $collection_item->menu->name_ar;
                                        $item_name = $collection_item->menu->name_ar;
                                        $menu_name = $collectionMenu->category->name_ar;
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
                                        if ($setup_hours >= 1) {
                                            if ($setup_minutes > 0) {
                                                $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($setup_minutes) . ' ' . \Lang::get('message.minute');
                                            } else {
                                                $setup = floor($setup_hours) . ' ' . \Lang::get('message.hour');
                                            }
                                        } else {
                                            $setup = floor($setup_minutes) . ' ' . \Lang::get('message.minute');
                                        }
                                        $max_hours = $collection->max_time / 60;
                                        $max_minutes = $collection->max_time % 60;
                                        if ($max_hours >= 1) {
                                            if ($max_minutes > 0) {
                                                $max = floor($max_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($max_minutes) . ' ' . \Lang::get('message.minute');
                                            } else {
                                                $max = floor($max_hours) . ' ' . \Lang::get('message.hour');
                                            }
                                        } else {
                                            $max = floor($max_minutes) . ' ' . \Lang::get('message.minute');
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

                                    if ($collection_item->is_mandatory == 1) {
                                        $item_price = 0;
                                    } else {
                                        $item_price = $collection_item->menu->price;
                                    }

                                    $items [] = [
                                        'item_id' => $collection_item->menu->id,
                                        'item_name' => $item_name,
                                        'item_image' => url('/') . '/images/' . $collection_item->menu->image,
                                        'item_price' => $item_price,
                                        'item_price_unit' => \Lang::get('message.priceUnit'),
                                        'item_availability' => $status,
                                        'is_mandatory' => $collection_item->is_mandatory

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

                        }

//                            $notice_hours = $collection->delivery_hours / 60;
//                            $notice_minutes = $collection->delivery_hours % 60;
//                            if ($notice_hours >= 1) {
//                                if ($notice_minutes > 0) {
//                                    $notice_period = floor($notice_hours) . ' ' . \Lang::get('message.hour') . ' ' . ($notice_minutes) . ' ' . \Lang::get('message.minute');
//                                } else {
//                                    $notice_period = floor($notice_hours) . ' ' . \Lang::get('message.hour');
//                                }
//                            } else {
//                                $notice_period = floor($notice_minutes) . ' ' . \Lang::get('message.minute');
//                            }


                        if ($lang == 'ar') {
                            $collection_name = $collection->name_ar;
                            $collection_description = $collection->description_ar;
                            $collection_type = $collection->category->name_ar;
                            $mealtime = $collection->mealtime->name_ar;
                            $service_provide = $collection->service_provide_ar;
                            $service_presentation = $collection->service_presentation_ar;
                            $service_type = $collection->serviceType->name_ar;
                        } else {
                            $collection_name = $collection->name_en;
                            $collection_description = $collection->description_en;
                            $collection_type = $collection->category->name_en;
                            $mealtime = $collection->mealtime->name_en;
                            $service_provide = $collection->service_provide_en;
                            $service_presentation = $collection->service_presentation_en;
                            $service_type = $collection->serviceType->name_en;
                        }

                        $service = [];
//                        foreach ($collection->serviceType as $serviceType) {

//                            if ($lang == 'ar') {
//                                $name = $collection->serviceType->name_ar;
//
//                            } else {
//                                $name = $collection->serviceType->name_en;
//                            }

                        $service [] = [
                            'service_type_id' => $collection->serviceType->service_type_id,
                            'service_type' => $service_type
                        ];

//                        }


                        $working_day = Carbon::parse($DataRequests['working_day'])->dayOfWeek;
                        $working_time = $DataRequests['working_time'];
                        $working_time = date("H:i:s", strtotime($working_time));
                        if ($collection->is_available == 1) {
                            if ($collection->unavailabilityHour->isEmpty()) {
                                $collectionStatus = 1;
                            } else {
                                $collectionAvailability = $collection->unavailabilityHour->where('weekday', $working_day)
                                    ->where('start_time', '<=', $working_time)
                                    ->where('end_time', '>=', $working_time)
                                    ->where('status', 1)->first();
                                if (!$collectionAvailability) {
                                    $collectionStatus = 0;
                                } else {
                                    $collectionStatus = 1;
                                }
                            }
                        } elseif ($collection->is_available == 0) {
                            $collectionStatus = 0;
                        }


                        if ($collection->unavailabilityHour->isEmpty()) {

                            $availability_status_id = -1;
                            $availability_hours = [];

                        } else {

                            $availability = $collection->unavailabilityHour->first();

                            $availability_hours = [];
                            if ($availability->type == 'flexible') {
                                $availability_status_id = 3;


                                foreach ($collection->unavailabilityHour as $unavailabilityHour) {
                                    $availability_hours [] = [
                                        'day' => $unavailabilityHour->weekday,
                                        'open_hour' => $unavailabilityHour->start_time,
                                        'close_hour' => $unavailabilityHour->end_time,
                                        'day_status' => $unavailabilityHour->status
                                    ];
                                }
                            } elseif ($availability->type == 'daily') {
                                $availability_status_id = 2;

                                foreach ($collection->unavailabilityHour as $unavailabilityHour) {
                                    $availability_hours [] = [
                                        'day' => $unavailabilityHour->weekday,
                                        'open_hour' => $unavailabilityHour->start_time,
                                        'close_hour' => $unavailabilityHour->end_time
                                    ];
                                }
                            } else {
                                $availability_status_id = 1;
                                $availability_hours = [];
                            }

                        }


                        $menu_collection [] = [
                            'collection_id' => $collection->id,
                            'collection_name' => $collection_name,
                            'collection_image' => url('/') . '/images/' . $collection->image,
                            'collection_description' => $collection_description,
                            'collection_category_id' => $collection->category_id,
                            'collection_category' => $collection_type,
                            'female_caterer_available' => $female_caterer_available,
                            'mealtime_id' => $collection->mealtime_id,
                            'mealtime' => $mealtime,
                            'collection_min_qty' => $collection_min,
                            'collection_max_qty' => $collection_max,
                            'collection_price' => $collection_price,
                            'collection_price_unit' => \Lang::get('message.priceUnit'),
                            'collection_status' => $collectionStatus,
                            'availability_status_id' => $availability_status_id,
                            'availability' => $availability_hours,
                            'min_serve_to_person' => $min_serve,
                            'max_serve_to_person' => $max_serve,
                            'allow_person_increase' => $person_increase,
                            'persons_max_count' => $max_persons,
                            'service_type' => $service,
                            'notice_period' => $collection->notice_period,
                            'service_provide' => $service_provide,
                            'service_presentation' => $service_presentation,
                            'food_list' => $foodlist,
                            'special_instruction' => '',
                            'food_item_image' => url('/') . '/images/' . $collection_item->menu->image,
                            'food_list_images' => $foodlist_images,
                            'setup_time' => $setup,
                            'requirement' => $requirement,
                            'max_time' => $max,
                            'menu_items' => $menu
                        ];
                    }


                }


                $working_day = Carbon::parse($DataRequests['working_day'])->dayOfWeek;
                $working_time = $DataRequests['working_time'];
                $working_time = date("H:i:s", strtotime($working_time));

                $restaurantAvailability = $restaurant->workingHour->where('weekday', $working_day)
                    ->where('opening_time', '<=', $working_time)
                    ->where('closing_time', '>=', $working_time)
                    ->where('status', 1)->first();

                if ($restaurantAvailability) {
                    if ($restaurant->status == 1) {
                        $status_id = 1;
                        $status = \Lang::get('message.open');
                    } else {
                        $status_id = 2;
                        $status = \Lang::get('message.busy');
                    }
                } else {
                    $status_id = 3;
                    $status = \Lang::get('message.notAvailable');
                }

                $famous = null;
                $famous = [];
                foreach ($restaurant->menu as $menu) {

                    if ($menu->famous == 1) {
                        $image = url('/') . '/images/' . $menu->image;
                        array_push($famous, $image);
                    }
                }


                $rate_sum = 0;
                $review_count = $restaurant->review->count();
                foreach ($restaurant->review as $review) {
                    $rate_sum += $review->rate_value;
                }
                if ($review_count > 0) {
                    $rate_sum = $rate_sum / $review_count;
                    $rating_count = ceil($rate_sum) - 0.5;
                    if ($rating_count < $rate_sum) {
                        $rating_count = ceil($rate_sum);
                    }
                } else {
                    $rating_count = 0;
                }

                $category = [];
                foreach ($restaurant->categoryRestaurant as $categoryRestaurant) {
                    $id = $categoryRestaurant->category_id;
                    if ($lang == 'ar') {
                        $name = $categoryRestaurant->name_ar;

                    } else {
                        $name = $categoryRestaurant->name_en;
                    }

                    $category [] = [
                        'category_id' => $id,
                        'category_name' => $name
                    ];

                }
                if ($lang == 'ar') {
                    $restaurant_name = $restaurant->name_ar;
                    $restaurant_description = $restaurant->description_ar;

                } else {
                    $restaurant_name = $restaurant->name_en;
                    $restaurant_description = $restaurant->description_en;
                }

//                $resNoticeHours = $resNotice / 60;
//                $resNoticeMinutes = $resNotice % 60;
//                if ($resNoticeHours >= 1) {
//                    if ($resNoticeMinutes > 0) {
//                        $resNoticePeriod = floor($resNoticeHours) . ' ' . \Lang::get('message.hour') . ' ' . ($resNoticeMinutes) . ' ' . \Lang::get('message.minute');
//                    } else {
//                        $resNoticePeriod = floor($resNoticeHours) . ' ' . \Lang::get('message.hour');
//                    }
//                } else {
//                    $resNoticePeriod = floor($resNoticeMinutes) . ' ' . \Lang::get('message.minute');
//                }

                $availability_hours = [];

                foreach ($restaurant->workingHour as $workingHour) {
                    $availability_hours [] = [
                        'day' => $workingHour->weekday,
                        'open_hour' => $workingHour->opening_time,
                        'close_hour' => $workingHour->closing_time,
                        'day_status' => $workingHour->status
                    ];
                }

                $working = $restaurant->workingHour->first();
                if ($working->type == 'flexible') {
                    $availability_status_id = 3;
                }

                $restaurant_details [] = [
                    'restaurant_id' => $restaurant->id,
                    'restaurant_name' => $restaurant_name,
                    'restaurant_image' => url('/') . '/images/' . $restaurant->image,
                    'famous_images' => $famous,
                    'ratings_count' => $rating_count,
                    'review_count' => $review_count,
                    'description' => $restaurant_description,
                    'status_id' => $status_id,
                    'status' => $status,
                    'availability_status_id' => $availability_status_id,
                    'availability' => $availability_hours,
                    'notice_period' => $resNotice,
                    'category' => $category
                ];

                $arr = [
                    'restaurant' => $restaurant_details,
                    'collections' => $menu_collection
                ];
//                }


                return response()->json(array(
                    'success' => 1,
                    'status_code' => 200,
                    'data' => $arr));

            } else {
                return response()->json(array(
                    'success' => 0,
                    'status_code' => 200,
                    'message' => \Lang::get('message.noRestaurant')));
            }

        }

    }


}

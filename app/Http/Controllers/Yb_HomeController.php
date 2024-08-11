<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\Property;
use App\Models\Pages;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\Purpose;
use App\Models\Distance;
use App\Models\Facility;
use App\Models\Packages;
use App\Models\UserContact;
use App\Models\FavouriteAdd;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Storage;


class Yb_HomeController extends Controller
{
    //
    public function index()
    {

        $category = Category::latest()
            ->select(['category.*', DB::raw("count(property.ads_id) as count")])
            ->leftJoin('property', 'property.category', '=', 'category.id')
            ->groupBy('category.id')
            ->where('category.status', '1')->get();

        $banner = DB::table('banner_settings')->first();

        $purpose = Purpose::latest()->where('status', '1')->get();

        $favourites = [];
        if (session()->has('user_id')) {
            $user = session()->get('user_id');
            $favourites = Users::select('favourites')->where('user_id', $user)->pluck('favourites');
        }
        // return $favourites; 
        $ads = Property::select('property.*', 'countries.country_name as country', 'states.state_name as state', 'cities.city_name as city', 'purpose.name as purpose_name', 'users.username', 'users.user_image')
            ->leftJoin('countries', 'property.country', '=', 'countries.country_id')
            ->leftJoin('purpose', 'property.purpose', '=', 'purpose.id')
            ->leftJoin('states', 'property.states', '=', 'states.state_id')
            ->leftJoin('cities', 'property.city', '=', 'cities.city_id')
            ->leftJoin('users', 'property.user_id', '=', 'users.user_id')
            ->where('property.status', '1')
            ->limit(8)->latest()->get();
        return view('public.index', ['banner' => $banner, 'favourites' => $favourites, 'category' => $category, 'purpose' => $purpose, 'ads' => $ads]);
    }

    // all properties page
    public function yb_all_listing(Request $request)
    {
        Paginator::useBootstrap();
        $where = 'property.status = 1';
        if ($request->location != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $location_id = City::where('city_name', $request->location)->pluck('city_id');
            $where .= 'city="' . $location_id[0] . '"';
            // $location = City::where('city_name','=',$request->loc)->pluck('city_name');
        }
        if ($request->type && $request->type != 'all') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $type_id = Category::where('cat_slug', $request->type)->pluck('id');
            $where .= 'category= "' . $type_id[0] . '"';
        }
        if ($request->status && $request->status != 'all') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $status = Purpose::where('name', $request->status)->pluck('id');
            $where .= 'purpose= "' . $status[0] . '"';
        }

        if ($request->price_min && $request->price_min != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= 'price>= ' . $request->price_min;
        }

        if ($request->price_max && $request->price_max != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= 'price<= ' . $request->price_max;
        }

        if ($request->facility != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            // asort($request->facility);
            $f = $request->facility;
            asort($f);
            $fac = implode(',', $f);
            $where .= 'FIND_IN_SET("' . $fac . '",property.facilities)';
        }
        // return $where;

        if ($request->sort == 'h-l') {
            $order = 'property.price DESC';
        } else if ($request->sort == 'l-h') {
            $order = 'property.price ASC';
        } elseif ($request->sort == 'oldest') {
            $order = 'property.ads_id ASC';
        } else {
            $order = 'property.ads_id DESC';
        }

        $ads = Property::select('property.*', 'countries.country_name as country', 'states.state_name as state', 'cities.city_name as city', 'purpose.name as purpose_name', 'users.username', 'users.user_image')
            ->leftJoin('countries', 'property.country', '=', 'countries.country_id')
            ->leftJoin('purpose', 'property.purpose', '=', 'purpose.id')
            ->leftJoin('states', 'property.states', '=', 'states.state_id')
            ->leftJoin('cities', 'property.city', '=', 'cities.city_id')
            ->leftJoin('users', 'property.user_id', '=', 'users.user_id')
            ->whereRaw($where)
            ->orderByRaw($order)
            ->orderBy('property.featured', 'DESC')
            ->paginate(9);
        // ->toSql();
        // return $ads;
        $category = Category::latest()->where('status', '1')->get();
        $purpose = Purpose::latest()->where('status', '1')->get();
        $facility = Facility::latest()->get();
        $locations = City::select(['cities.*', 'states.state_name'])->leftJoin('states', 'states.state_id', '=', 'cities.state_id')->get();
        $favourites = [];
        if (session()->has('user_id')) {
            $user = session()->get('user_id');
            $favourites = Users::select('favourites')->where('user_id', $user)->pluck('favourites');
        }

        return view('public.all', ['request' => $request, 'favourites' => $favourites, 'ads' => $ads, 'locations' => $locations, 'category' => $category, 'purpose' => $purpose, 'facility' => $facility]);
    }

    // create post page by user
    public function yb_create()
    {
        if (session()->has('user_id')) {

            $value = session()->get('user_id');
            $country = Country::all();
            $category = Category::where('status', '1')->get();
            $purpose = Purpose::where('status', '1')->get();
            $distance = Distance::all();
            $facility = Facility::all();
            return view('public.create', ['country' => $country, 'category' => $category, 'purpose' => $purpose, 'distance' => $distance, 'facility' => $facility]);
        } else {
            return redirect('login');
        }
    }

    // edit post page by user
    public function yb_edit($id)
    {
        $ads = Property::where(['ads_id' => $id])->first();

        $value = session()->get('user_id');
        $country = Country::all();
        $state = State::where('country_id', $ads->country)->get();
        $city = City::where('state_id', $ads->states)->get();
        $category = Category::where('status', '1')->get();
        $purpose = Purpose::where('status', '1')->get();
        $distance = Distance::all();
        $facility = Facility::all();

        return view('public.edit', ['ads' => $ads, 'value' => $value, 'country' => $country, 'state' => $state, 'city' => $city, 'category' => $category, 'purpose' => $purpose, 'distance' => $distance, 'facility' => $facility]);
    }

    // single property page
    public function yb_singlePage($slug)
    {
        $latest_ads = Property::Select('property.*', 'countries.country_name as country', 'states.state_name as state', 'cities.city_name as city', 'purpose.name as purpose_name')
            ->LeftJoin('countries', 'property.country', '=', 'countries.country_id')
            ->LeftJoin('states', 'property.states', '=', 'states.state_id')
            ->LeftJoin('cities', 'property.city', '=', 'cities.city_id')
            ->LeftJoin('purpose', 'property.purpose', '=', 'purpose.id')
            ->orderBy('property.ads_id', 'DESC')
            ->limit(5)->get();

        $single = Property::Select('property.*', 'category.category_name as cat_name', 'category.category_name as cat_slug', 'countries.country_name as country', 'states.state_name as state', 'cities.city_name as city_name', 'purpose.name as purpose_name', \DB::raw("GROUP_CONCAT(facilities.name) as facility"))
            ->LeftJoin('countries', 'property.country', '=', 'countries.country_id')
            ->LeftJoin('states', 'property.states', '=', 'states.state_id')
            ->LeftJoin('cities', 'property.city', '=', 'cities.city_id')
            ->LeftJoin('purpose', 'property.purpose', '=', 'purpose.id')
            ->LeftJoin('category', 'property.category', '=', 'category.id')
            ->leftjoin("facilities", \DB::raw("FIND_IN_SET(facilities.id,property.facilities)"), ">", \DB::raw("'0'"))
            ->where('property.slug', $slug)->first();

        $related = Property::select('property.*', 'countries.country_name as country', 'states.state_name as state', 'cities.city_name as city', 'purpose.name as purpose_name', 'users.username', 'users.user_image')
            ->leftJoin('countries', 'property.country', '=', 'countries.country_id')
            ->leftJoin('purpose', 'property.purpose', '=', 'purpose.id')
            ->leftJoin('states', 'property.states', '=', 'states.state_id')
            ->leftJoin('cities', 'property.city', '=', 'cities.city_id')
            ->leftJoin('users', 'property.user_id', '=', 'users.user_id')
            ->where('property.city', $single->city)->limit(5)
            ->get();

        $distance_list = Distance::all();

        if ($single->user_id == 'by admin') {
            $userInfo = [];
        } else {
            $userInfo = Users::select(['username', 'user_phone', 'user_email', 'user_image', 'user_country', 'user_state', 'user_city', 'users.created_at', 'users.favourites', 'countries.country_name'])
                ->leftJoin('countries', 'countries.country_id', '=', 'users.user_country')
                ->where('user_id', '=', $single->user_id)->first();
        }

        return view('public.single', ['single' => $single, 'latest' => $latest_ads, 'userInfo' => $userInfo, 'distance_list' => $distance_list, 'related' => $related]);
    }

    // contact page
    public function yb_contact()
    {
        $value = session()->get('user_id');
        if (session()->get('user_id') != '') {
            $users = Users::WHERE(['user_id' => $value])->get();
            return view('public.contact', ['user' => $users]);
        } else {
            return view('public.contact');
        }
    }

    // save contact page
    public function yb_contactStore(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'description' => 'required',
        ]);

        $userContact = new UserContact();
        $userContact->user_name = $request->input("user_name");
        $userContact->email = $request->input("email");
        $userContact->phone = $request->input("phone");
        $userContact->description = $request->input("description");
        $result = $userContact->save();
        return $result;
    }

    // search page
    // public function yb_search(Request $request){
    //     Paginator::useBootstrap();
    //     // return $request;
    //     $location = '';
    //     $where = '';
    //     if($request->loc){
    //         $location_id = City::where('city_name',$request->loc)->pluck('city_id');
    //         $where .= 'city= "'.$location_id[0].'"';
    //         $location = City::where('city_name','=',$request->loc)->pluck('city_name');
    //     }
    //     if($request->type){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'category= "'.$request->type.'"';
    //     }
    //     if($request->status){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'purpose= "'.$request->status.'"';
    //     }

    //     $ads = Property::Select('property.*','countries.country_name as country','states.state_name as state','cities.city_name as city')
    //     ->LeftJoin('countries','property.country','=','countries.country_id') 
    //     ->LeftJoin('states','property.states','=','states.state_id') 
    //     ->LeftJoin('cities','property.city','=','cities.city_id') 
    //     ->whereRaw($where)
    //     ->paginate(10);
    //     // return $ads;

    //     $category = Category::latest()->where('status','1')->get();
    //     $purpose = Purpose::latest()->where('status','1')->get();
    //     $facility = Facility::latest()->get();
    //     // return $location;
    //     return view('public.search',['ads'=>$ads,'category'=>$category,'purpose'=>$purpose,'facility'=>$facility,'request'=>$request,'location'=>$location]);
    //         // return view('public.search',['ads'=>$ads,'favouriteAdd'=>$favouriteAdd,'state'=> $state,'city'=>$city,'search_state'=> $search_state,'search_city'=>$search_city,'search'=>$search_title,'search_purpose'=>$search_purpose]);
    // }

    // search filter page
    // public function yb_search_filter(Request $request){
    //     // return $request;
    //     $siteInfo = DB::table('general_settings')->first();
    //     $location = '';
    //     $where = '';
    //     if($request->loc){
    //         $location_id = City::where('city_name',$request->loc)->pluck('city_id');
    //         $where .= 'city="'.$location_id[0].'"';
    //         $location = City::where('city_name','=',$request->loc)->pluck('city_name');
    //     }
    //     if($request->type && $request->type != 'all'){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'category= "'.$request->type.'"';
    //     }
    //     if($request->status && $request->status != 'all'){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'purpose= "'.$request->status.'"';
    //     }

    //     if($request->min_price && $request->min_price != ''){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'price>= "'.$request->min_price.'"';
    //     }

    //     if($request->max_price && $request->max_price != ''){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'price<= "'.$request->max_price.'"';
    //     }

    //     if($request->facility != ''){
    //         if($where != ''){ $where .= ' AND '; }
    //         $where .= 'FIND_IN_SET("'.$request->facility.'",property.facilities)';
    //     }
    //     // return $where;

    //     if($request->sort == 'h-l'){
    //         $order = 'property.price DESC';
    //     }else if($request->sort == 'l-h'){
    //         $order = 'property.price ASC';
    //     }else{
    //         $order = 'property.ads_id DESC';
    //     }
    //     // return $order;



    //     $ads = Property::Select('property.*','countries.country_name as country','states.state_name as state','cities.city_name as city','purpose.name as purpose_name')
    //     ->LeftJoin('countries','property.country','=','countries.country_id') 
    //     ->LeftJoin('states','property.states','=','states.state_id') 
    //     ->LeftJoin('cities','property.city','=','cities.city_id') 
    //     ->LeftJoin('purpose','property.purpose','=','purpose.id') 
    //     ->whereRaw($where)
    //     ->orderByRaw($order)
    //     ->get();
    //     // return $ads;
    //     $output= [];
    //     $output['data'] = '';
    //     $output['count'] = $ads->count();
    //     if(!empty($ads)){
    //         foreach($ads as $item){
    //         $output['data'] .= '<div class="col-md-4">
    //             <div href="property/single/'.$item->slug.'" class="list-grid">
    //                 <a href="'.url("property/single/".$item->slug).'" class="list-image">';
    //                 if($item->ads_image != ''){
    //                     $output['data'] .= '<img src="'.asset("public/ads/".$item->ads_image).'" alt="'.$item->property_name.'">';
    //                 }else{
    //                     $output['data'] .= '<img src="'.asset("public/ads/default.png").'" alt="'.$item->property_name.'">';
    //                 }
    //                 $output['data'] .= '<span class="list-label">For '.$item->purpose_name.'</span>
    //                 <span class="list-favourite"><i class="far fa-heart"></i></span>
    //                 </a>
    //                 <div class="list-content">
    //                     <h3><a href="'.url("property/single/".$item->slug).'">'.$item->property_name.'</a></h3>
    //                     <span class="list-address">'.$item->city.', '.$item->state.'</span>
    //                     <div class="list-price">'.$siteInfo->cur_format.$item->price.'</div>
    //                 </div>
    //             </div>
    //         </div>';
    //         }
    //     }
    //     return $output;

    // }

    // get cities name in search box (auto suggestion)
    public function yb_get_locations(Request $request)
    {
        $val = $request->input('val');

        $cities = City::select(['cities.*', 'states.state_name'])
            ->leftJoin('states', 'states.state_id', '=', 'cities.state_id')
            ->where('city_name', 'like', "{$request->val}%")
            ->get();
        // return $cities;
        if (!empty($cities)) {
            $output = '';
            foreach ($cities as $city) {
                $output .= '<span data-id="' . $city->city_name . '"><span class="res">' . $city->city_name . '</span>, ' . $city->state_name . '</span>';
            }
            return $output;
        }
    }

    // custom single page
    public function yb_single_pages($slug)
    {
        $content = Pages::where('slug', '=', $slug)->first();
        return view('public.custom', ['content' => $content]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Users;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\Purpose;
use App\Models\Distance;
use App\Models\Facility;
use App\Models\Packages;
use Yajra\DataTables\DataTables;
use Stripe;
use DB;
use Session;

class Yb_PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            //$data = Ads::orderBy('ads_id','desc')->get();
            $data = Property::select(['property.*','users.username','cities.city_name','category.category_name','purpose.name as purpose_name'])
                ->LeftJoin('users','property.user_id','=','users.user_id')
                ->LeftJoin('cities','property.city','=','cities.city_id')
                ->LeftJoin('category','property.category','=','category.id')
                ->LeftJoin('purpose','property.purpose','=','purpose.id')
                ->orderBy('property.ads_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('ads_image',function($row){
                if($row->ads_image != ''){
                    $img = '<img src="'.asset("public/ads/".$row->ads_image).'" width="70px">';
                }else{
                    $img = '<img src="'.asset("public/ads/default.png").'" width="70px">';
                }
                return $img;
            })
            ->editColumn('property_name',function($row){
                $name = $row->property_name;
                if($row->featured == '1'){
                    $name = $name.' <label class="badge badge-success">($)</span>';
                }
                return $name;
            })
            ->editColumn('username',function($row){
                if($row->username == ''){
                    return $row->username = 'By Admin';
                }else{
                    return $row->username;
                }
            })
            ->addColumn('action', function($row){
                $btn = '<a href="properties/'.$row->ads_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-ads btn btn-danger btn-sm" data-id="'.$row->ads_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['ads_image','property_name','action'])
            ->make(true);
        } 
        return view('admin.ads.index'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        $state = State::all();
        $city = City::all();
        $category = Category::all();
        $purpose = Purpose::all();
        $distance = Distance::all();
        $facility = Facility::all();
        return view('admin.ads.create',['country'=>$country,'state'=>$state,'city'=>$city,'category'=>$category,'purpose'=>$purpose,'distance'=>$distance,'facility'=>$facility]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    return $request->gallery;
    //    return $request->input();
        //
        $request->validate([ 
            'image'=>'image|mimes:jpeg,png,jpg|max:2048',
            'title'=>'required',
            'desc'=>'required',
            'type'=>'required',
            'status'=>'required',
            'area'=>'required',
            'price'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
        ]);

        if($request->image){
            $image = $request->image->getClientOriginalName();
            $request->image->move(public_path('ads'),$image);
        }else {
            $image = "";
        }

        $gallery = [];
        if($request->hasfile('gallery'))
         {
            foreach($request->file('gallery') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('ads'), $name);  
                $gallery[] = $name;  
            }
         }

        $ads = new Property();
        $ads->ads_image =$image;
        $ads->gallery =implode(',',$gallery);
        $ads->property_name = $request->input("title");
        $ads->slug = str_replace(' ','-',strtolower($request->input('title')));
        if($request->user_type == 'user'){
            $ads->user_id = session()->get('user_id');
            $property_status = '1';
        }else{
            $ads->user_id = 'by admin';
            $property_status = '1';
        }
        $floors = $bedrooms = $bathrooms = $parking = $face_side = '';
        if($request->floors){
            $floors = $request->floors;
        }
        if($request->bedrooms){
            $bedrooms = $request->bedrooms;
        }
        if($request->bathrooms){
            $bathrooms = $request->bathrooms;
        }
        if($request->parking){
            $parking = $request->parking;
        }
        if($request->face_side){
            $face_side = $request->face_side;
        }
        
        $ads->description = $request->input("desc");
        $ads->category = $request->input("type");
        $ads->purpose = $request->input("status");
        $ads->area = $request->input("area");
        $ads->bedrooms = $bedrooms;
        $ads->bathrooms = $bathrooms;
        $ads->floors = $floors;
        $ads->parking = $parking;
        $ads->property_face = $face_side;
        $ads->price = $request->input("price");
        $ads->facilities = $request->input("facility");
        $ads->country = $request->input("country");
        $ads->states = $request->input("state");
        $ads->city = $request->input("city");
        if($request->distance != ''){
            $ads->distances = http_build_query($request->input("distance"),'',',');
        }
        // $ads->status = $property_status;
        $result =  $ads->save();
        return $result;
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
        $property = Property::where(['ads_id'=>$id])->first();
        $country = Country::all();
        $state = State::where('country_id','=',$property->country)->get();
        $city = City::where('state_id','=',$property->states)->get();
        $category = Category::all();
        $purpose = Purpose::all();
        $distance = Distance::all();
        $facility = Facility::all();
        return view('admin.ads.edit',['property'=>$property,'country'=>$country,'state'=>$state,'city'=>$city,'category'=>$category,'purpose'=>$purpose,'distance'=>$distance,'facility'=>$facility]);
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
        // return $request->input();
        $request->validate([ 
            'image'=>'image|mimes:jpeg,png,jpg|max:2048',
            'title'=>'required',
            'desc'=>'required',
            'type'=>'required',
            'status'=>'required',
            'area'=>'required',
            'price'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
        ]);

        if($request->image != ''){        
            $path = public_path().'/ads/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->image;
            $image = $request->image->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }
        $distances = '';
        if($request->distance != ''){
            $distances = http_build_query($request->input("distance"),'',',');
        }
        // if($request->user_type == 'user'){
        //     $user = session()->get('user_id');
        // }else{
        //     $user = 'by admin';
        // }
        $floors = $bedrooms = $bathrooms = $parking = $face_side ='';
        if($request->floors){
            $floors = $request->floors;
        }
        if($request->bedrooms){
            $bedrooms = $request->bedrooms;
        }
        if($request->bathrooms){
            $bathrooms = $request->bathrooms;
        }
        if($request->parking){
            $parking = $request->parking;
        }
        if($request->face_side){
            $face_side = $request->face_side;
        }

        // $property_status = '1';
        // if($request->property_status){
        //     $property_status = $request->property_status;
        // }
        $gallery = array_filter(explode(',',$request->old_gallery));
        // return $gallery;
        if(!empty($request->old)){
            for($j=0;$j<count($gallery);$j++){
                if(!in_array($j+1,$request->old)){
                    $img = $gallery[$j];
                    if(file_exists(public_path('ads/'.$img))){
                            unlink(public_path('ads/').$img);
                    }
                    unset($gallery[$j]);
                }
            }
        }
        if($request->hasfile('gallery1'))
         {
            foreach($request->file('gallery1') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('ads'), $name);  
                $gallery[] = $name;
            }
         }
         
        //  return $gallery;
        $ads = Property::where(['ads_id'=>$id])->update([
            "ads_image" =>$image,
            "gallery" =>implode(',',$gallery),
            "property_name" => $request->input("title"),
            "slug" => str_replace(' ','-',strtolower($request->input('title'))),
            "description" => $request->input("desc"),
            // "user_id" => $user,
            "category" => $request->input("type"),
            "purpose" => $request->input("status"),
            "price" => $request->input("price"),
            "facilities" => $request->input("facility"),
            "distances" => $distances,
            "area" => $request->input("area"),
            "country" => $request->input("country"),
            "states" => $request->input("state"),
            "city" => $request->input("city"),
            "bedrooms" => $bedrooms,
            "bathrooms" => $bathrooms,
            "floors" => $floors,
            "parking" => $parking,
            "property_face" => $face_side,
            "status" => $request->input("property_status"),
        ]);
        return $ads;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroy = Property::where('ads_id',$id)->delete();
        return  $destroy;
    }


    // public function yb_edit($id){
    //     $ads = Ads::where(['ads_id'=>$id])->first();
    //     return $ads;
    // }

        public function yb_get_country_states(Request $request){
            if($request->input()){
                $country = $request->country_id;

                $states = State::where('country_id',$country)->get();
                $output = '<option disabled selected value="">Select State</option>';
                if(!empty($states)){
                    foreach($states as $row){
                        $output .= '<option value="'.$row['state_id'].'">'.$row['state_name'].'</option>';
                    }
                }else{
                    $output = '<option disabled selected value=">No States Found</option>';
                }
                return $output;
            }
        }


        public function yb_get_state_city(Request $request){
            if($request->input()){
                $state = $request->state_id;

                $cities = City::where('state_id',$state)->get();
                $output = '<option disabled selected value="">Select City</option>';
                if(!empty($cities)){
                    foreach($cities as $row){
                        $output .= '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
                    }
                }else{
                    $output = '<option disabled selected value=">No Cities Found</option>';
                }
                return $output;
            }
        }


        public function yb_change_status_byUser(Request $request){
            if($request->input()){
                if(session()->has('user_id')){
                    $id = $request->id;
                    $status = $request->status;
                    $user = session()->get('user_id');
                    $update = Property::where(['ads_id'=>$id,'user_id'=>$user])->update([
                        'status' => $status
                    ]);
                    return $update;
                }
            }
        }


        public function yb_make_featured(Request $request,$id){
            if($request->input()){
                // return $request->input();
                $package_detail = Packages::where('id',$request->package)->first();

                // return $package_detail;

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $res =  Stripe\Charge::create ([
                        "amount" => $package_detail->price * 100,
                        "currency" => "INR",
                        "source" => $request->stripeToken,
                        "description" => "Payment for Featured Post"
                ]);
                // return $res;

                if($res->captured == '1'){
                    $update_post = Property::where('ads_id',$id)->update([
                        'featured'=>'1'
                    ]);

                    $add_payment = DB::table('payment_details')->insert([
                        'pay_id' => $res->id,
                        'payment_method' => $res->payment_method,
                        'post' => $id,
                        'user' => session()->get('user_id'),
                        'start_date' => date('Y-m-d'),
                        'end_date' => date('Y-m-d',strtotime('+15 days')),
                        'payment_date' => date('Y-m-d'),
                        'status' => $res->captured
                    ]);

                    Session::flash('payment', 'Payment successful!');
                     return redirect('/my-listing');
           

                }else{
                    Session::flash('payment', 'Payment Unsuccessful!');
                    return back();
                }

            }else{
                $packages = Packages::where('status','1')->get();
                return view('public.make-featured',['packages'=>$packages,'id'=>$id]);
            }
        }

}

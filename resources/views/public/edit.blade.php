@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Edit Property</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Property</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div id="site-content">
    <div class="container">
        <div class="row">
            <div class="offset-1 col-md-10">
                <form id="editProperty" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="content-box row">
                        <h3 class="col-md-12 mb-4">Property Description</h3>
                        <div class="mb-4 col-md-12">
                            <label for="">Property Title</label>
                            <input type="text" class="form-control" name="title" value="{{$ads->property_name}}">
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="">Property Description</label>
                            <textarea name="desc" class="form-control">{{$ads->description}}</textarea>
                            <input type="text" hidden name="id" value="{{$ads->ads_id}}">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option disabled selected value="" >Any Type</option>
                                @if(!empty($category))
                                    @foreach($category as $type)
                                        @php $selected = ($type->id == $ads->category) ? 'selected' : '';  @endphp
                                        <option value="{{$type->id}}" {{$selected}}>{{$type->category_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Status</label>
                            <select class="form-control" name="status">
                                <option disabled selected value="" >Any Status</option>
                                @if(!empty($purpose))
                                    @foreach($purpose as $type)
                                    @php $selected = ($type->id == $ads->purpose) ? 'selected' : '';  @endphp
                                        <option value="{{$type->id}}" {{$selected}}>{{$type->name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Area</label>
                            <input type="text" class="form-control" name="area" value="{{$ads->area}}">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Bedrooms / Rooms</label>
                            <input type="number" class="form-control" name="bedrooms" value="{{$ads->bedrooms}}">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Bathrooms</label>
                            <input type="number" class="form-control" name="bathrooms" value="{{$ads->bathrooms}}">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Floors</label>
                            <input type="number" class="form-control" name="floors" value="{{$ads->floors}}">
                            <input type="text" hidden name="user_type" value="user">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Parking (Car Parking Space)</label>
                            <input type="number" class="form-control" name="parking" value="{{$ads->parking}}"  placeholder="e.g. 1">
                            <small>( Enter number of cars )</small>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Property Face Side</label>
                            <input type="text" class="form-control" name="face_side" value="{{$ads->property_face}}" placeholder="e.g. North Side">
                        </div>
                        <div class="mb-4 col-md-4">
                        <label for="">Price<small class="text-danger">*</small> ({{$siteInfo->cur_format}})</label>
                            <input type="text" class="form-control" name="price" value="{{$ads->price}}">
                            <input type="text" hidden name="property_status" value="{{$ads->status}}">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Image</label>
                            <input type="text" name="old_img" hidden value="{{$ads->ads_image}}">
                            <input type="file" class="form-control" onChange="readURL(this);" name="image">
                            <small>Image Size Must be ( 640px X 430px)</small>
                        </div>
                        <div class="mb-4 col-md-4"> 
                            @if($ads->ads_image != '')
                                <img id="image" src="{{asset('public/ads/'.$ads->ads_image)}}" alt="" height="100px">
                            @else
                                <img id="image" src="{{asset('public/ads/default.png')}}" alt="" height="100px">
                            @endif
                        </div>
                    </div>
                    <div class="content-box">
                        <h3 class="mb-4">Property Gallery</h3>
                        <div class="property-images1"></div>
                        <input type="text" hidden name="old_gallery" value="{{$ads->gallery}}">
                        <small>Image Size Must be ( 640px X 430px)</small>
                        @php
                        $gallery = array_filter(explode(',',$ads->gallery));
                        $gallery_array = [];
                        for($i=0;$i<count($gallery);$i++){
                            $g = (object) array('id'=>$i+1,'src'=>asset('public/ads/'.$gallery[$i]));
                            array_push($gallery_array,$g);
                        }
                        @endphp
                    </div>
                    @php $ads_facility = array_filter(explode(',',$ads->facilities))  @endphp
                    <div class="content-box row">
                        <h3 class="col-md-12 mb-4">Property Facilities</h3>
                        @if(!empty($facility))
                            @foreach($facility as $f)
                            @php $checked = '';  @endphp
                            @if(in_array($f->id,$ads_facility))
                                @php $checked = 'checked'; @endphp
                            @endif
                            <div class="mb-2 col-md-3">
                                <input type="checkbox" id="{{$f->id}}" class="facility" value="{{$f->id}}" {{$checked}}>
                                <label for="{{$f->id}}">{{$f->name}}</label> 
                            </div>
                            @endforeach
                        @endif 
                    </div>
                    <div class="content-box row">
                        <h3 class="col-md-12 mb-4">Property Location</h3>
                        <div class="mb-4 col-md-4">
                            <label>Country<small class="text-danger">*</small></label>
                            <select class="form-control" name="country">
                                <option disabled selected value="" >Select The Country</option>
                                @if(!empty($country))
                                    @foreach($country as $types)
                                    @php $selected = ($types->country_id == $ads->country) ? 'selected' : '';  @endphp
                                        <option value="{{$types->country_id}}" {{$selected}}>{{$types->country_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label>State <small class="text-danger">*</small></label>
                            <select class="form-control" name="state">
                                <option disabled selected value="" >Select The State</option>
                                @if(!empty($state))
                                    @foreach($state as $types)
                                    @php $selected = ($types->state_id == $ads->states) ? 'selected' : '';  @endphp
                                        <option value="{{$types->state_id}}" {{$selected}}>{{$types->state_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label>City <small class="text-danger">*</small></label>
                            <select class="form-control" name="city">
                                <option disabled selected value="" >Select The City</option>
                                @if(!empty($city))
                                    @foreach($city as $types)
                                    @php $selected = ($types->city_id == $ads->city) ? 'selected' : '';  @endphp
                                        <option value="{{$types->city_id}}" {{$selected}}>{{$types->city_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        @if(!empty($distance))
                            @php
                            $ad_distances = array_filter(explode(',',$ads->distances));
                            $dis_key = [];
                            $dis_list = [];
                            $count = count($ad_distances);
                            for($i=0;$i<$count;$i++){
                                $a = explode('=',$ad_distances[$i]);
                                array_push($dis_key,$a[0]);
                                $dis_list[$a[0]] = $a[1];
                            }
                            @endphp
                            @foreach($distance as $dist)
                                @php $value = '';  @endphp
                                @if(in_array($dist->distance_id,$dis_key))
                                    @php $value = $dis_list[$dist->distance_id]; @endphp
                                @endif
                                <div class="mb-4 col-md-4">
                                    <label>Distance From {{$dist->distance_name}}</label>
                                    <input type="text" class="form-control" name="distance[{{$dist->distance_id}}]" value="{{$value}}">
                                </div> 
                            @endforeach
                        @endif
                    </div>
                    <div class="content-box text-center">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
                <div class="message"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@include('public/layout/footer')

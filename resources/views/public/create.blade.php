@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Add Property</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Property</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div id="site-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="AddProperty" class="row" method="POST" data-cc-on-file="false" enctype="multipart/form-data">
                    @csrf
                    <div class="content-box row sidebar">
                        <h3 class="col-md-12 mb-4">Property Description</h3>
                        <div class="mb-4 col-md-12">
                            <label for="">Property Title<small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="">Property Description<small class="text-danger">*</small></label>
                            <textarea name="desc" class="form-control"></textarea>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Type<small class="text-danger">*</small></label>
                            <select class="form-control" name="type">
                                <option disabled selected value="" >Any Type</option>
                                @if(!empty($category))
                                    @foreach($category as $type)
                                        <option value="{{$type->id}}">{{$type->category_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Status<small class="text-danger">*</small></label>
                            <select class="form-control" name="status">
                                <option disabled selected value="" >Any Status</option>
                                @if(!empty($purpose))
                                    @foreach($purpose as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Area<small class="text-danger">*</small> (sq. ft.)</label>
                            <input type="text" class="form-control" name="area">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Bedrooms / Rooms</label>
                            <input type="number" class="form-control" name="bedrooms">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Bathrooms</label>
                            <input type="number" class="form-control" name="bathrooms">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Floors</label>
                            <input type="number" class="form-control" name="floors">
                            <input type="text" hidden name="user_type" value="user">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Parking (Car Parking Space)</label>
                            <input type="number" class="form-control" name="parking"  placeholder="e.g. 1">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Property Face Side</label>
                            <input type="text" class="form-control" name="face_side"  placeholder="e.g. North Side">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Price <small class="text-danger">*</small> ({{$siteInfo->cur_format}})</label>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="">Image<small class="text-danger">*</small></label>
                            <input type="file" class="form-control" onChange="readURL(this);" name="image">
                            <small>Image Size Must be ( 640px X 430px)</small>
                        </div>
                        <div class="mb-4 col-md-4">
                        <img id="image" src="{{asset('public/ads/default.png')}}" alt="" height="100px">
                        </div>
                    </div>
                    <div class="content-box">
                        <h3 class="mb-4">Property Gallery</h3>
                        <div class="property-images"></div>
                        <small>Image Size Must be ( 640px X 430px)</small>
                    </div>
                    <div class="content-box row">
                        <h3 class="col-md-12 mb-4">Property Facilities</h3>
                        @if(!empty($facility))
                            @foreach($facility as $f)
                            <div class="mb-2 col-md-3">
                                <input type="checkbox" id="{{$f->id}}" class="facility" value="{{$f->id}}">
                                <label for="{{$f->id}}">{{$f->name}}</label> 
                            </div>
                            @endforeach
                        @endif 
                    </div>
                    <div class="content-box row">
                        <h3 class="col-md-12 mb-4">Property Location</h3>
                        <div class="mb-4 col-md-4">
                            <label>Country<small class="text-danger">*</small></label>
                            <select class="form-control country-select" name="country">
                                <option disabled selected value="" >Select The Country</option>
                                @if(!empty($country))
                                    @foreach($country as $types)
                                        <option value="{{$types->country_id}}">{{$types->country_name}}</option> 
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label>State <small class="text-danger">*</small></label>
                            <select class="form-control state-select" name="state">
                                <option disabled selected value="" >First Select Country</option>
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label>City <small class="text-danger">*</small></label>
                            <select class="form-control city-select" name="city">
                                <option disabled selected value="" >First Select State</option>
                            </select>
                        </div>
                        @if(!empty($distance))
                            @foreach($distance as $dist)
                                <div class="mb-4 col-md-4">
                                    <label>Distance From {{$dist->distance_name}} (in km)</label>
                                    <input type="text" class="form-control" name="distance[{{$dist->distance_id}}]">
                                </div> 
                            @endforeach
                        @endif
                    </div>
                    <div class="content-box row text-center">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="Save" >
                        </div>
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
//     $(function () {

//         $('.property-images').imageUploader({
//             imagesInputName: 'gallery',
//             'label': 'Drag and Drop' 
//         });

// });
</script>
@include('public/layout/footer')

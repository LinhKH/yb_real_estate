@extends('admin.layout')
@section('title','Edit Property')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Properties'=>'admin/properties']])
    @slot('title') Edit Property @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateProperty"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Property Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Property Title<small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" name="title" value="{{$property->property_name}}" placeholder="Enter Title">
                                        <input type="text" hidden name="id" value="{{$property->ads_id}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Property Description<small class="text-danger">*</small></label>
                                        <textarea name="desc" class="form-control">{{$property->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                         <label>Category<small class="text-danger">*</small></label>
                                        <select class="form-control" name="type">
                                            <option disabled value="" >Select The Category</option>
                                            @if(!empty($category))
                                                @foreach($category as $types)
                                                    @php $selected = ($types->id == $property->categpry) ? 'selected' : '';  @endphp
                                                    <option value="{{$types->id}}" {{$selected}}>{{$types->category_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Purpose <small class="text-danger">*</small></label>
                                        <select class="form-control" name="status">
                                            <option disabled selected value="" >Select The Purpose</option>
                                            @if(!empty($purpose))
                                                @foreach($purpose as $types)
                                                @php $selected = ($types->id == $property->purpose) ? 'selected' : '';  @endphp
                                                    <option value="{{$types->id}}" {{$selected}}>{{$types->name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Area<small class="text-danger">*</small> (sq. ft.)</label>
                                        <input type="text" class="form-control" name="area" value="{{$property->area}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Bedrooms / Rooms</label>
                                        <input type="number" class="form-control" name="bedrooms" value="{{$property->bedrooms}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Bathrooms</label>
                                        <input type="number" class="form-control" name="bathrooms" value="{{$property->bathrooms}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Floor</label>
                                        <input type="number" class="form-control" name="floors" value="{{$property->floors}}">
                                        <input type="text" hidden name="user_type" value="admin">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Parking ( Available Parking Space)</label>
                                        <input type="number" class="form-control" name="parking" value="{{$property->parking}}" placeholder="e.g. 2">
                                        <small>( Enter number of cars )</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Property Face Side</label>
                                        <input type="text" class="form-control" name="face_side" value="{{$property->property_face}}" placeholder="e.g. North">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Price<small class="text-danger">*</small> ({{$siteInfo->cur_format}})</label>
                                        <input type="number" class="form-control" name="price" value="{{$property->price}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Featured Image<small class="text-danger">*</small></label>
                                        <input type="file" class="form-control" name="image" onChange="readURL(this);">
                                        <input type="text" hidden name="old_img" value="{{$property->ads_image}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                @if($property->ads_image != '')
                                <img id="image" src="{{asset('public/ads/'.$property->ads_image)}}" alt=""  width="100px">
                                @else
                                <img id="image" src="{{asset('public/ads/default.png')}}" alt=""  width="100px">
                                @endif  
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Property Show/Hide</label>
                                        <select name="property_status" class="form-control">
                                            <option value="1" @php echo ($property->status == '1') ? 'selected' : '';  @endphp>Show</option>
                                            <option value="0" @php echo ($property->status == '0') ? 'selected' : '';  @endphp>Hide</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Property Gallery</label>
                                        <div class="property-images1"></div>
                                        <input type="text" hidden name="old_gallery" value="{{$property->gallery}}">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Property Facilities</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            @php
                            $property_facility = array_filter(explode(',',$property->facilities));
                            @endphp
                            @if(!empty($facility))
                                @foreach($facility as $types)
                                @php $checked = in_array($types->id,$property_facility) ? 'checked' : '';  @endphp
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-2">
                                        <input type="radio" id="facility{{$types->id}}"  class="facility" {{$checked}} value="{{$types->id}}">
                                        <label for="facility{{$types->id}}">{{$types->name}}</label>
                                    </div>
                                </div>
                                @endforeach
                            @endif 
                            </div>
                        </div>
                    </div> <!-- /.card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Property Location</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Country<small class="text-danger">*</small></label>
                                        <select class="form-control country-select" name="country">
                                            <option disabled selected value="" >Select The Country</option>
                                            @if(!empty($country))
                                                @foreach($country as $types)
                                                @php $selected = ($types->country_id == $property->country) ? 'selected' : '';  @endphp
                                                    <option value="{{$types->country_id}}" {{$selected}}>{{$types->country_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>State <small class="text-danger">*</small></label>
                                        <select class="form-control state-select" name="state">
                                            @if(!empty($state))
                                                @foreach($state as $types)
                                                @php $selected = ($types->state_id == $property->states) ? 'selected' : '';  @endphp
                                                    <option value="{{$types->state_id}}" {{$selected}}>{{$types->state_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>City <small class="text-danger">*</small></label>
                                        <select class="form-control city-select" name="city">
                                            @if(!empty($city))
                                                @foreach($city as $types)
                                                @php $selected = ($types->city_id == $property->city) ? 'selected' : '';  @endphp
                                                    <option value="{{$types->city_id}}" {{$selected}}>{{$types->city_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                @if(!empty($distance))
                                @php
                                $ad_distances = array_filter(explode(',',$property->distances));
                                $dis_key = [];
                                $dis_list = [];
                                $count = count($ad_distances);
                                for($i=0;$i<$count;$i++){
                                    $a = explode('=',$ad_distances[$i]);
                                    array_push($dis_key,$a[0]);
                                    $dis_list[$a[0]] = $a[1];
                                }
                                @endphp
                                    @foreach($distance as $types)
                                    @php $value = '';  @endphp
                                    @if(in_array($types->distance_id,$dis_key))
                                        @php $value = $dis_list[$types->distance_id]; @endphp
                                    @endif
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label>Distance From {{$types->distance_name}} (in km)</label>
                                           <input type="number" class="form-control" name="distance[{{$types->distance_id}}]" value="{{$value}}">
                                        </div>
                                    </div>
                                    @endforeach
                                @endif 
                            </div>
                        </div>
                    </div> <!-- /.card -->
                </div>
                <!--/.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form> <!-- /.form end -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@php
$gallery = array_filter(explode(',',$property->gallery));
$gallery_array = [];
for($i=0;$i<count($gallery);$i++){
    $g = (object) array('id'=>$i+1,'src'=>asset('public/ads/'.$gallery[$i]));
    array_push($gallery_array,$g);
}

@endphp
@stop
@section('pageJsScripts')
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

    $(function () {

        var preloaded = <?php echo json_encode($gallery_array); ?>;

        $('.property-images1').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'gallery1',
            'label': 'Drag and Drop',
            preloadedInputName: 'old',
            maxFiles: 10,
            maxSize: 2 * 1024 * 1024,
        });

    });
</script>
@stop
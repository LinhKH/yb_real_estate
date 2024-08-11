@extends('admin.layout')
@section('title','Add New Property')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Properties'=>'admin/properties']])
    @slot('title') Add Property @endslot
    @slot('add_btn')  @endslot
    @slot('active') Add New @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="addProperty"  method="POST" enctype="multipart/form-data">
            @csrf
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
                                        <input type="text" class="form-control" name="title" value="" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Property Description<small class="text-danger">*</small></label>
                                        <textarea name="desc" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                         <label>Category<small class="text-danger">*</small></label>
                                        <select class="form-control" name="type">
                                            <option disabled selected value="" >Select The Category</option>
                                            @if(!empty($category))
                                                @foreach($category as $types)
                                                    <option value="{{$types->id}}">{{$types->category_name}}</option> 
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
                                                    <option value="{{$types->id}}">{{$types->name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Area<small class="text-danger">*</small> (sq. ft.)</label>
                                        <input type="text" class="form-control" name="area">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Bedrooms / Rooms</label>
                                        <input type="number" class="form-control" name="bedrooms">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Bathrooms</label>
                                        <input type="number" class="form-control" name="bathrooms">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Floor</label>
                                        <input type="number" class="form-control" name="floors">
                                        <input type="text" hidden name="user_type" value="admin">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Parking ( Available Parking Space)</label>
                                        <input type="number" class="form-control" name="parking" placeholder="e.g. 2">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Property Face Side</label>
                                        <input type="text" class="form-control" name="face_side" placeholder="e.g. North">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Price<small class="text-danger">*</small> ({{$siteInfo->cur_format}})</label>
                                        <input type="number" class="form-control" name="price">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Featured Image<small class="text-danger">*</small></label>
                                        <input type="file" class="form-control" name="image" onChange="readURL(this);">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                <img id="image" src="{{asset('public/ads/default.png')}}" alt=""  width="100px">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Property Gallery</label>
                                        <div class="property-images"></div>
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
                            @if(!empty($facility))
                                @foreach($facility as $types)
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-2">
                                        <input type="radio" id="facility{{$types->id}}"  class="facility" value="{{$types->id}}">
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
                                                    <option value="{{$types->country_id}}">{{$types->country_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>State <small class="text-danger">*</small></label>
                                        <select class="form-control state-select" name="state">
                                            <option disabled selected value="" >First Select Country</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                            <label>City <small class="text-danger">*</small></label>
                                        <select class="form-control city-select" name="city">
                                            <option disabled selected value="" >First Select State</option>
                                        </select>
                                    </div>
                                </div>
                                @if(!empty($distance))
                                    @foreach($distance as $types)
                                    <div class="col-md-4">
                                        <div class="form-group mb-4">
                                            <label>Distance From {{$types->distance_name}} (in km)</label>
                                           <input type="number" class="form-control" name="distance[{{$types->distance_id}}]">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> <!-- /.form end -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
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

   // $(function () {

        $('.property-images').imageUploader({
            imagesInputName: 'gallery',
            'label': 'Drag and Drop' 
        });

   // });
</script>
@stop
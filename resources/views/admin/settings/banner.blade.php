@extends('admin.layout')
@section('title','Banner Settings')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Banner Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Banner Settings @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateBannerSetting" method="POST">
            {{ csrf_field() }}
                @foreach($data as $item)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label class="col-md-3">Company Logo</label>
                                            <div class="col-md-9">
                                                <input type="hidden" class="custom-file-input" name="old_image" value="{{$item->image}}" />
                                                <input type="file" hidden class="change-com-img" name="image" onChange="readURL(this);">
                                                @if(empty($item->image))
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/company/default.png')}}" height="150px">
                                                @else
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/company/'.$item->image)}}" height="150px">
                                                @endif
                                                <button type="button" class="btn btn-info d-block mt-2 change-logo">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title" value="{{$item->title}}"  placeholder="Banner Title">
                                        </div>
                                        <div class="form-group">
                                            <label>Sub Title</label>
                                            <input type="text" class="form-control" name="sub_title"  value="{{$item->sub_title}}" placeholder="Banner Sub Title">
                                        </div>
                                    </div>
                                     <div class="form-group col-md-4 col-12">
                                        <input type="submit" class="btn btn-primary update-banner-settings" value="Update"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                @endforeach
            </form> <!-- /.form start -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
@stop
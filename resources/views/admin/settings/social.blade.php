@extends('admin.layout')
@section('title','Social Settings')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Social Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Social Settings @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateSocialSetting" method="POST">
            {{ csrf_field() }}
                @foreach($data as $item)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Social Links</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Facebook</label>
                                            <input type="text" class="form-control" name="facebook" value="{{$item->facebook}}"  placeholder="Enter Item Name">
                                            <small>Leave the field empty if you want to hide this link</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Twitter</label>
                                            <input type="text" class="form-control" name="twitter" value="{{$item->twitter}}"  placeholder="Enter Item Name">
                                            <small>Leave the field empty if you want to hide this link</small>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Linked In</label>
                                            <input type="text" class="form-control" name="linked_in" value="{{$item->linked_in}}" placeholder="Enter Item Name">
                                            <small>Leave the field empty if you want to hide this link</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-4">
                                            <label>You Tube</label>
                                            <input type="text" class="form-control" name="you_tube" value="{{$item->you_tube}}"  placeholder="Enter Item Name">
                                            <small>Leave the field empty if you want to hide this link</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-4">
                                            <label>Google Plus</label>
                                            <input type="text" class="form-control" name="google_plus" value="{{$item->google_plus}}"  placeholder="Enter Item Name">
                                            <small>Leave the field empty if you want to hide this link</small>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <input type="submit" class="btn btn-primary update-general-settings" value="Update"/>
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
@stop
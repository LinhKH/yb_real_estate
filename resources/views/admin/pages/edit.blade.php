@extends('admin.layout')
@section('title','Edit Page')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Pages'=>'admin/pages']])
    @slot('title') Edit Pages @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Pages @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updatePage"  method="POST">
            @csrf
            {{ method_field('PUT') }}
            @if($pages)
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <input type="hidden" class="url" value="{{url('admin/pages/'.$pages->page_id)}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Page Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Page Title <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="title" placeholder="Page Title" value="{{$pages->page_title}}">
                            </div>
                            <div class="form-group">
                                <label>Page Slug <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="slug" placeholder="Page Slug" value="{{$pages->slug}}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea  class="textarea" class="form-control" name="description" placeholder="Place some text here" style="width: 100%; height: 1500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{!!htmlspecialchars_decode($pages->description)!!}</textarea>
                            </div>
                            <div class="form-group ">
                                <label> Status </label>
                                <select name="status" class="form-control">
                                    <option value="" disabled>Select Status</option>    
                                    <option value="1" {{ ($pages->status == "1" ? "selected":"") }} >Active</option>
                                    <option value="0" {{ ($pages->status == "0" ? "selected":"") }} >Inactive</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            @endif
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop
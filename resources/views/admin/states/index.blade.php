@extends('admin.layout')
@section('title','States')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') States @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') States @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','States','Country Name','Action']
    ])
        @slot('table_id') state-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">States Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form  id="add_state" method="POST" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label>State Name</label>
                            <input type="text" name="state" class="form-control" placeholder="Enter State Name">
                        </div>
                        <div class="form-group ">
                            <label>Country Name </label>
                            <select name="country" class="form-control">
                                <option value="0" selected disabled>Select Country</option>    
                                @if(!empty($country))
                                    @foreach($country as $types)
                                        <option value="{{$types->country_id}}">{{$types->country_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">States Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form  id="edit_state" method="POST" >
                    <div class="modal-body">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label>State Name</label>
                            <input type="text" name="state" class="form-control"  placeholder="Enter State Name">
                            <input type="hidden" name="id">
                        </div>
                        <div class="form-group ">
                            <label> Country </label>
                            <select name="country" class="form-control">
                                <option value="0" selected disabled>Select Country</option>    
                                @if(!empty($country))
                                    @foreach($country as $types)
                                        <option value="{{$types->country_id}}">{{$types->country_name}}</option>
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#state-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "states",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'state_name', name: 'state'},
            {data: 'country', name: 'country'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });
</script>

@stop
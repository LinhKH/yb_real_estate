@extends('admin.layout')
@section('title','City')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') City @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') City  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','City Name','State Name','Action']
    ])
        @slot('table_id') city-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">City Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="add_city" method="POST" >
                        <div class="modal-body">
                            <div class="form-group">
                                <label>City Name</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter City Name">
                            </div>
                            <div class="form-group ">
                                <label>State Name </label>
                                <select name="state" class="form-control">
                                    <option value="0" selected disabled>Select State</option>    
                                    @if(!empty($state))
                                        @foreach($state as $types)
                                            <option value="{{$types->state_id}}">{{$types->state_name}}</option>
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
                        <h4 class="modal-title">City Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="edit_city" method="POST" >
                        <div class="modal-body">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label>City Name</label>
                                <input type="text" name="city" class="form-control"  placeholder="Enter City Name">
                                <input type="hidden" name="id" >
                            </div>
                            <div class="form-group ">
                                <label> State </label>
                                <select name="state" class="form-control">
                                    <option value="0" disabled>Select State</option>    
                                    @if(!empty($state))
                                        @foreach($state as $types)
                                            <option value="{{$types->state_id}}">{{$types->state_name}}</option>
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
    var table = $("#city-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "city",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'city_name', name: 'city'},
            {data: 'state', name: 'state'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop
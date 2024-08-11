@extends('admin.layout')
@section('title','Properties')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Properties @endslot
        @slot('add_btn') <a href="{{url('admin/properties/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Properties  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Image','Property Title','Purpose','Type','City','User','Action']
    ])
        @slot('table_id') ads-list @endslot
    @endcomponent
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#ads-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "properties",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'ads_image', name: 'image'},
            {data: 'property_name', name: 'name'},
            {data: 'purpose_name', name: 'purpose'},
            {data: 'category_name', name: 'category'},
            {data: 'city_name', name: 'city'},
            {data: 'username', name: 'user'},
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
@extends('admin.layout')
@section('title','Users')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Users @endslot
        @slot('add_btn') @endslot
        @slot('active') Users  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','User Image','User Name','Email','Phone No.','Location','Status','Action']
    ])
        @slot('table_id') user-list @endslot
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
    var table = $("#user-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "users",
        columns: [
            {data: 'user_id', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'user_image', name: 'image'},
            {data: 'username', name: 'username'},
            {data: 'user_email', name: 'email'},
            {data: 'user_phone', name: 'phone'},
            {data: 'location', name: 'location'},
            {data: 'status', name: 'status'},
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
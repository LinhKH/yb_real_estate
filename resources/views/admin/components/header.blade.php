

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>{{$siteInfo->com_name}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font Awesome -->
     <link rel="stylesheet" href="{{asset('public/assets/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('public/assets/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('public/assets/css/dataTables.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/assets/css/adminlte.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('public/assets/css/summernote-bs4.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('public/assets/css/sweetalert-bootstrap-4.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('public/assets/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
    <!-- Style.CSS -->
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .checkbox{
    width: 64px;
    height: 31px;
    margin: 0 auto;
    position: relative;
}
.checkbox input[type=checkbox]{
    margin: 0;
    visibility: hidden;
    position: absolute;
    left: 7px;
    top: 7px;
}
.checkbox label{
    height: 100%;
    border-radius: 4px;
    display: block;
    perspective: 100px; 
    position: relative;
    z-index: 1;
}
.checkbox label:before,
.checkbox label:after{
    content: 'Block';
    color: #fff;
    background: #fa8231;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    width: 100%;
    height: 100%;
    padding: 5px 5px;
    border-radius: 4px;
    transform: rotateY(0deg);
    position: absolute;
    top: 0;
    left: 0;
    transition: all 0.4s ease;
}
.checkbox label:after{
    content: 'Unblock';
    background: #20bf6b;
    transform: rotateY(-180deg);
    left: 0;
    z-index: -1;
}
.checkbox input[type=checkbox]:checked+label:before{ transform: rotateY(180deg); }
.checkbox input[type=checkbox]:checked+label:after{
    transform: rotateY(0deg);
    z-index: 1; 
}
@media only screen and (max-width:767px){
    .checkbox{ margin: 0 0 20px; }
}

.page-checkbox{
    display: inline-block;
    position: relative;
}
.page-checkbox input[type=checkbox]{
    margin: 0;
    visibility: hidden;
    position: absolute;
    left: 1px;
    top: 1px;
}
.page-checkbox label{
    width: 35px;
    height: 22px;
    margin: 0;
    border: 3px solid #555;
    border-radius: 100px;
    cursor: pointer;
    display: block;
    overflow: hidden;
    position: relative;
    transition: all 0.75s ease;
}
.page-checkbox label:before,
.page-checkbox label:after{
    content: '';
    background: #555;
    border-radius: 50px;
    width: 14px;
    height: 14px;
    position: absolute;
    top: 1px;
    left: 2px;
    opacity: 1;
    transition: 0.75s ease;
}
.page-checkbox label:after{
    left: auto;
    right: 2px;
    opacity: 0;
}
.page-checkbox input[type=checkbox]:checked+label{
    border-color: #a30d9e;
    box-shadow: 0 0 5px rgba(163,13,158,0.4);
}
.page-checkbox input[type=checkbox]:checked+label:before{ opacity: 0; }
.page-checkbox input[type=checkbox]:checked+label:after{
    background-color: #a30d9e;
    opacity: 1;
}
@media only screen and (max-width:767px){
    .page-checkbox{ margin: 0 0 20px; }
}
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper position-relative">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                      Hello,{{session()->get('admin_name')}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="width:180px;">
                        <li class="nav-item text-center"><a href="{{url('admin/profile-settings')}}" class="nav-link">My Profile</a></li>
                        <li class="nav-item text-center admin-logout"><a href="javascript:void(0)" class="nav-link">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

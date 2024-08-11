<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$siteInfo->com_name}}</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"> 
    <!-- <link rel="stylesheet" href="{{asset('public/assets/public/css/bootstrap.min.css')}}"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
    <!-- <link href="lib/animate/animate.min.css" rel="stylesheet"> -->
     <!-- Bootstrap Core Css -->
    <!-- <link rel="stylesheet" href="{{asset('public/assets/public/css/bootstrap.min.css')}}"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/public/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/public/lib/owlcarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">
    <!-- dropzone -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/assets/public/css/select2.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/public/css/flexslider.css')}}">

    <link rel="stylesheet" href="{{asset('public/assets/public/css/style.css')}}">
</head>
<body>

    <header id="header" class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="{{url('/')}}">
                            @if($siteInfo->com_logo != '')
                                <img src="{{asset('public/company/'.$siteInfo->com_logo)}}" alt="{{$siteInfo->com_name}}">
                            @else
                                {{$siteInfo->com_name}}
                            @endif
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{url('/')}}">Home</a>
                                    </li>
                                    @if(!empty($cat_list))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Properties
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            @foreach($cat_list as $row)
                                            @if($row->count > 0)
                                                <li><a class="dropdown-item" href="{{url('all-listing/?type='.$row->cat_slug)}}">{{$row->category_name}}</a></li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                    @if(!empty($head_pages))
                                        @foreach($head_pages as $pages)
                                        <li class="nav-item">
                                        <a class="nav-link" href="{{url('/'.$pages->slug)}}">{{$pages->page_title}}</a>
                                    </li>
                                        @endforeach
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('/contact')}}">Contact</a>
                                    </li>
                                    @if(session()->has('username'))
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{session('username')}}
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="{{url('my-profile')}}">My Profile</a></li>
                                            <li><a class="dropdown-item" href="{{url('my-listing')}}">My Listings</a></li>
                                            <li><a class="dropdown-item" href="{{url('my-favourites')}}">My Favourites</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="{{url('logout')}}">Logout</a></li>
                                        </ul>
                                    </li>
                                    @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('login')}}">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('signup')}}">Signup</a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{url('create')}}">Add Listing <i class="fas fa-laptop-house"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    


    
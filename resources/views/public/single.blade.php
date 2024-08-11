@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- <h2>Single Page</h2> -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/'.$single->cat_slug)}}">{{$single->category_name}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$single->property_name}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div id="site-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="content-box single-post">
                    <div class="list-grid d-flex flex-column h-100">
                        <h3>{{$single->property_name}}</h3>
                        <ul class="list-info">
                            <li><i class="fa fa-briefcase"></i> {{$single->cat_name}}</li>
                            <li><i class="fa fa-map-marker-alt"></i> {{$single->city}}</li>
                            <li><i class="far fa-calendar"></i> {{date('d M, Y',strtotime($single->created_at))}}</li>
                            @if($single->featured == '1')
                            <li><i class="fas fa-money-bill"></i> <b>Featured</b></li>
                            @endif
                        </ul>
                        <div class="list-image">
                            @php $gallery = array_filter(explode(',',$single->gallery)); @endphp
                            @if(empty($gallery))
                                @if($single->ads_image != '')
                                    <img src="{{asset('public/ads/'.$single->ads_image)}}" alt="{{$single->property_name}}">
                                @else
                                    <img src="{{asset('public/ads/default.png')}}" alt="">
                                @endif
                            @else
                            <div class="flexslider">
                                <ul class="slides">
                                    @if($single->ads_image != '')
                                        <li data-thumb="{{asset('public/ads/'.$single->ads_image)}}">
                                            <img src="{{asset('public/ads/'.$single->ads_image)}}" />
                                        </li>
                                    @endif
                                    @for($i=0;$i<count($gallery);$i++)
                                        <li data-thumb="{{asset('public/ads/'.$gallery[$i])}}">
                                        <img src="{{asset('public/ads/'.$gallery[$i])}}" />
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            @endif
                        
                        <span class="list-label">For {{$single->purpose_name}}</span>
                        @if(empty($userInfo) || $userInfo->favourites == '')
                            <span class="list-favourite add-favourite" data-id="{{$single->ads_id}}"><i class="far fa-heart"></i></span>
                        @else
                            @php $favourite_list = array_filter(explode(',',$userInfo->favourites)); @endphp
                            @php $active = '';  @endphp
                            @if(in_array($single->ads_id,$favourite_list))
                            @php $active = 'active';  @endphp
                            @endif
                            <span class="list-favourite add-favourite {{$active}}" data-id="{{$single->ads_id}}"><i class="far fa-heart"></i></span>
                        @endif
                        </div>
                        <div class="list-content px-0">
                            <div class="list-price">{{$siteInfo->cur_format}}{{$single->price}}</div>
                            <div class="inner-content">
                                <h3>Description</h3>
                                <p class="description">{{$single->description}}</p>
                            </div>
                            <div class="inner-content">
                                <h3>Specifications</h3>
                                <ul class="list-facilities">
                                    <li><i class="fa fa-arrows-alt"></i> {{$single->area}} sqft</li>
                                    <li><i class="fa fa-bed"></i> {{$single->bedrooms}} beds</li>
                                    <li><i class="fa fa-bath"></i> {{$single->bathrooms}} bath</li>
                                    @if($single->parking)
                                    <li><i class="fa fa-car"></i> {{$single->parking}} car</li>
                                    @endif
                                    @if($single->property_face)
                                        <li><i class="fas fa-swimming-pool"></i> {{$single->property_face}}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="inner-content">
                                <h3>Extra Facilities</h3>
                                @php 
                                    $facility = [];
                                    if($single->facility != ''){
                                        $facility = array_filter(explode(',',$single->facility));
                                    }
                                @endphp
                                <ul class="list-facilities">
                                    @for($i=0;$i<count($facility);$i++)
                                        <li><i class="fa fa-check"></i> {{$facility[$i]}}</li>
                                    @endfor
                                </ul>
                            </div>
                            @if($single->distances != '')
                                @php
                                $ad_distances = array_filter(explode(',',$single->distances));
                                $dis_key = [];
                                $dis_list = [];
                                $count = count($ad_distances);
                                for($i=0;$i<$count;$i++){
                                    $a = explode('=',$ad_distances[$i]);
                                    array_push($dis_key,$a[0]);
                                    $dis_list[$a[0]] = $a[1];
                                }
                                @endphp
                                <div class="inner-content">
                                    <h3>Distances (in Km.)</h3>
                                    <ul class="list-facilities">
                                @foreach($distance_list as $dist)
                                    @if(in_array($dist->distance_id,$dis_key))
                                    <li><i class="fa fa-road"></i> {{$dist->distance_name}} => {{$dis_list[$dist->distance_id]}} km.</li>
                                    @endif
                                @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="content-box sidebar">
                    <h3 class="mb-3">Related Properties</h3>
                    <div class="owl-carousel related-posts owl-theme position-relative">
                        @foreach($related as $row)
                        <div class="item">
                            <div href="property/single/{{$row->slug}}" class="list-grid d-flex flex-column h-100">
                                <a href="{{url('property/single/'.$row->slug)}}" class="list-image">
                                @if($row->ads_image != '')
                                    <img src="{{asset('public/ads/'.$row->ads_image)}}" alt="{{$row->property_name}}">
                                @else
                                    <img src="{{asset('public/ads/default.png')}}" alt="">
                                @endif
                                <span class="list-label">For {{$row->purpose_name}}</span>
                                @if(empty($favourites))
                                    <span class="list-favourite add-favourite" data-id="{{$row->ads_id}}"><i class="far fa-heart"></i></span>
                                @else
                                    @php $favourite_list = array_filter(explode(',',$favourites)); @endphp
                                    @php $active = '';  @endphp
                                    @if(in_array($row->ads_id,$favourite_list))
                                    @php $active = 'active';  @endphp
                                    @endif
                                    <span class="list-favourite add-favourite {{$active}}" data-id="{{$row->ads_id}}"><i class="far fa-heart"></i></span>
                                @endif
                                @if($row->featured == '1')
                                    <span class="featured">Featured</span>
                                @endif
                                </a>
                                <div class="list-content d-flex flex-column">
                                    <h3><a href="{{url('property/single/'.$row->slug)}}">{{$row->property_name}}</a></h3>
                                    <span class="list-address"><i class="fa fa-map-marker-alt"></i> {{$row->city}}, {{$row->state}}</span>
                                    <div class="list-price">{{$siteInfo->cur_format}}{{$row->price}}</div>
                                    <ul class="list-facilities">
                                        @if($row->area != '')
                                        <li><i class="fa fa-arrows-alt"></i> {{$row->area}} sqft</li>
                                        @endif
                                        @if($row->bedrooms != '' && $row->bedrooms != 0)
                                        <li><i class="fa fa-bed"></i> {{$row->bedrooms}} beds</li>
                                        @endif
                                        @if($row->bathrooms != '' && $row->bathrooms != 0)
                                        <li><i class="fa fa-bath"></i> {{$row->bathrooms}} bath</li>
                                        @endif
                                        @if($row->parking != '')
                                        <li><i class="fa fa-car"></i> {{$row->parking}} car</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="list-foot d-flex mt-auto">
                                    <div class="userimg me-2">
                                        @if($row->user_image == '')
                                            <img src="{{asset('public/users/default.png')}}" alt="">
                                        @else
                                            <img src="{{asset('public/users/'.$row->user_image)}}" alt="">
                                        @endif
                                    </div>
                                    @if($row->user_id == 'by admin')
                                    <h6 class="my-auto">Site Admin</h6>
                                    @else
                                    <h6 class="my-auto">{{$row->username}}</h6>
                                    @endif
                                    <span class="post-time ms-auto my-auto">{{date('d M, Y',strtotime($row->created_at))}}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="content-box sidebar post-user">
                    <h3 class="mb-3">Posted By</h3>
                    @if($userInfo)
                    <div class="post-user-info mb-5">
                        <div class="userimg">
                        @if($userInfo->user_image != '')
                        <img src="{{asset('public/users/'.$userInfo->user_image)}}" alt="">
                        @else
                        <img src="{{asset('public/users/default.png')}}" alt="">
                        @endif
                        </div>
                        <div class="content">
                            <h3>{{$userInfo->username}}</h3>
                            <span>Member Since {{date('M Y',strtotime($userInfo->created_at))}}</span>
                            <a href="{{url('user-listing/'.$userInfo->username)}}" class="btn btn-primary rounded">See All Ads</a>
                        </div>
                    </div>
                    <h3 class="mb-3">Contact Info</h3>
                    <div class="user-contact-info">
                        <ul>
                            <li><i class="fa fa-map-marker-alt"></i> {{$userInfo->country_name}}</li>
                            <li><i class="fa fa-envelope"></i> {{$userInfo->user_email}}</li>
                            <li><i class="fa fa-phone"></i> {{$userInfo->user_phone}}</li>
                        </ul>
                    </div>
                    @else
                    <div class="post-user-info mb-5">
                        <div class="userimg">
                            <img src="{{asset('public/users/default.png')}}" alt="">
                        </div>
                        <div class="content">
                            <h3>{{$siteInfo->com_name}}</h3>
                        </div>
                    </div>
                    <h3 class="mb-3">Contact Info</h3>
                    <div class="user-contact-info">
                        <ul>
                            <li><i class="fa fa-map-marker-alt"></i> {{$siteInfo->address}}</li>
                            <li><i class="fa fa-envelope"></i> {{$siteInfo->com_email}}</li>
                            <li><i class="fa fa-phone"></i> {{$siteInfo->com_phone}}</li>
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="content-box sidebar">
                    <h3 class="mb-3">Shares</h3>
                    <ul class="share-list">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{  Request::url() }}" target="_blank"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="http://twitter.com/share?url={{  Request::url() }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="http://pinterest.com/pin/create/button/?url={{  Request::url() }}" target="_blank"><i class="fab fa-pinterest"></i></a></li>
                    </ul>
                </div>
                <div class="content-box sidebar latest-post-sidebar">
                    <h3>Latest Properties</h3>
                    @foreach($latest as $item)
                        <div class="latest-post-box d-flex flex-row">
                            @if($item->ads_image != '')
                            <img  src="{{asset('public/ads/'.$item->ads_image)}}" alt="{{$item->ads_image}}">
                            @else
                            <img src="{{asset('public/ads/default.png')}}" alt="">
                            @endif
                            <div class="content flex-fill">
                                <h3>{{$item->property_name}}</h3>
                                <a href="{{url('property/single/'.$item->slug)}}" class="view-more">View Details</a>
                                <div class="price">{{$siteInfo->cur_format}}{{$item->price}}</div>
                            </div>
                        </div>
                        <!-- /.user-block -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@include('public/layout/footer')
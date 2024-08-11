@include('public/layout/header')
   
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>User Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
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
            <div class="col-md-3">
                <div class="content-box sidebar">
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
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                @if(!empty($ads))
                @foreach($ads as $row)
                <div class="col-md-4 mb-4">
                    <div href="property/single/{{$row->slug}}" class="list-grid d-flex flex-column h-100">
                        <a href="{{url('property/single/'.$row->slug)}}" class="list-image">
                        @if($row->ads_image != '')
                            <img src="{{asset('public/ads/'.$row->ads_image)}}" alt="{{$row->property_name}}">
                        @else
                            <img src="{{asset('public/ads/default.png')}}" alt="">
                        @endif
                        <span class="list-label">For {{$row->purpose_name}}</span>
                        <span class="list-favourite add-favourite" data-id="{{$row->ads_id}}"><i class="far fa-heart"></i></span>
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
                </div>
                @endforeach
            @endif
            @if($ads->total() > $ads->perPage())
            <div class="col-md-12">
                <div class="content-box">
                {{$ads->links()}}
                </div>
            </div>
            @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
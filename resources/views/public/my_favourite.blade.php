@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Favourites</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Favourites</li>
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
            @if(!$ads->isEmpty())
            @foreach($ads as $row) 
            <div class="col-xl-3 mb-4 col-lg-4 col-md-6 col-sm-6">
                <div href="property/single/{{$row->slug}}" class="list-grid d-flex flex-column h-100">
                    <a href="{{url('property/single/'.$row->slug)}}" class="list-image">
                    @if($row->ads_image != '')
                        <img src="{{asset('public/ads/'.$row->ads_image)}}" alt="{{$row->property_name}}">
                    @else
                        <img src="{{asset('public/ads/default.png')}}" alt="">
                    @endif
                    <span class="list-label">For {{$row->purpose_name}}</span>
                    @if(empty($favourites))
                        <span class="list-favourite add-favourite active" data-id="{{$row->ads_id}}"><i class="far fa-heart"></i></span>
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
            @else
            <div class="content-box text-center">
            <p class="m-0">No Favourites Found</p>
            </div>
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

@include('public/layout/footer')
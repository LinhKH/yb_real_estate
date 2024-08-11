@include('public/layout/header')
<!-- Banner Start -->
<div class="banner" style="background-image: url('public/company/{{$banner->image}}')">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="banner-desc">{{$banner->sub_title}}</span>
                <h1>{{$banner->title}}</h1>
            </div>
        </div>
        <form action="{{url('all-listing')}}" method="GET" class="search-form row">
            <!-- @csrf -->
            <div class="col-md-3 position-relative">
                <input type="text" class="form-control" id="location" placeholder="Any Location" required>
                <input type="text" hidden name="location" class="location-no">
                <div class="location-list">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="" selected>Any Type</option>
                    @if($category)
                        @foreach($category as $cat)
                        <option value="{{$cat->cat_slug}}">{{$cat->category_name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                <option value="" selected>Any Status</option>
                @if($purpose)
                    @foreach($purpose as $pur)
                    <option value="{{$pur->name}}">{{$pur->name}}</option>
                    @endforeach
                @endif
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </form>
    </div>
</div>
<!-- Banner End -->

<div id="site-content">
    <div class="category-section mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head">Available Category</h2>
                </div>
                <div class="owl-carousel category-carousel owl-theme position-relative">
                @if(!empty($category))
                    @foreach($category as $cat)
                        @if($cat->count > 0)
                        <div class="item">
                            <a href="{{url('all-listing/?type='.$cat->cat_slug)}}" class="category-box" style="background-image: url('public/category/{{$cat->cat_image}}');">
                                <!-- <img src="{{asset('public/category/'.$cat->cat_image)}}" alt="{{$cat->category_name}}"> -->
                                <div class="category-content">
                                    <h4>{{$cat->category_name}}</h4>
                                    <span class="post-count">{{$cat->count}}</span>
                                </div>
                            </a>
                        </div>
                        @endif
                    @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
    <div class="listing-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head">Latest Listing</h2>
                </div>
            </div>
            <div class="row listing position-relative">
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
            @if($ads->isNotEmpty())
            <div class="row">
                <div class="col-md-12 pt-2 text-center">
                    <a href="{{url('/all-listing?location=&type=')}}" class="btn btn-primary rounded">Show More</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@include('public/layout/footer')
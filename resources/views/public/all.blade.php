@include('public/layout/header')
   
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>All Listing</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div id="site-content">
<form action="{{url('/all-listing')}}">
    <div class="container-xl container-fluid">
        <div class="row">
            
            <div class="col-md-3">
                <div class="content-box filter-form sidebar">
                    <h3>Filter Search</h3>
                    <div class="mb-3">
                        <span>Location</span>
                        <select name="location" class="form-control select2" style="width:100%;">
                        <option value="">All</option>
                        @if($locations->isNotEmpty())
                            @foreach($locations as $location)
                            @php 
                            $selected = '';
                            if($request->location){
                                if($location->city_name == $request->location){
                                    $selected = 'selected';
                                }
                            }
                            @endphp
                            <option value="{{$location->city_name}}" {{$selected}} >{{$location->city_name}}, {{$location->state_name}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <span>Status</span>
                        <select name="status" class="form-control status-filter" onChange="this.form.submit()">
                            <option value="" selected>All</option>
                            @if($purpose->isNotEmpty())
                            @foreach($purpose as $p)
                            @php 
                            $selected = '';
                            if($request->status){
                                $selected = ($p->name == $request->status) ? 'selected' : '';
                            }
                            @endphp
                            <option value="{{$p->name}}" {{$selected}}>{{$p->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <span>Property Type</span>
                        <div>
                            <input type="radio" name="type" class="type-filter" value="" onChange="this.form.submit()" checked>
                            <label>All</label>
                        </div>
                        @if($category->isNotEmpty())
                            @foreach($category as $cat)
                            @php 
                            $checked = '';
                            if($request->type){
                                $checked = ($cat->cat_slug == $request->type) ? 'checked' : '';
                            }
                                @endphp
                            <div>
                                <input type="radio" name="type" class="type-filter" value="{{$cat->cat_slug}}" onChange="this.form.submit()" {{$checked}}>
                                <label>{{$cat->category_name}}</label>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <span>Select Facility</span>
                        <select name="facility[]" class="form-control select2" multiple style="width:100%;">
                            <!-- <option value="" selected disabled></option> -->
                        @if($facility->isNotEmpty())
                            @foreach($facility as $f)
                            
                            @php 
                            $selected = '';
                            if($request->facility){
                                echo '1';
                                if(in_array($f->id,$request->facility)){
                                    $selected =  'selected';
                                }
                            }
                            @endphp
                            <option value="{{$f->id}}" {{$selected}} >{{$f->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <span>Price (Min-Max)</span>
                        <input type="number" name="price_min" class="form-control mb-3" min='0' value="@if($request->price_min != ''){{$request->price_min}}@endif" placeholder="Min Price">
                        <input type="number" name="price_max" class="form-control" min='0' value="@if($request->price_max != ''){{$request->price_max}}@endif" placeholder="Max Price">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Filter</button>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content-box d-flex flex-row justify-content-between align-items-center p-3">
                    <span>Showing {{$ads->firstItem()}} to <span class="count">{{$ads->lastItem()}}</span> of <span class="total-count">{{$ads->total()}}</span> entries</span>
                    <!-- <button type="button" class="btn ms-auto me-2 list-layout"><i class="fa fa-list"></i></button> -->
                    <!-- <button type="button" class="btn me-2 grid-layout"><i class="fa fa-th"></i></button> -->
                    <div class="d-flex flex-row">
                        <label for="" class="text-nowrap my-auto me-2">Sort By</label>
                        <select name="sort" class="form-control" onChange="this.form.submit()">
                            <option value="latest" @php if($request->sort == 'latest') echo 'selected'; @endphp>Latest</option>
                            <option value="oldest" @php if($request->sort == 'oldest') echo 'selected'; @endphp>Oldest</option>
                            <option value="l-h" @php if($request->sort == 'l-h') echo 'selected'; @endphp>Price:Low to High</option>
                            <option value="h-l" @php if($request->sort == 'h-l') echo 'selected'; @endphp>Price:High to Low</option>
                        </select>
                    </div>
                </div>
                <div class="row search-res-list">
                    @if(!empty($ads))
                    @foreach($ads as $row)
                    <div class="col-xl-4 mb-4 col-lg-4 col-md-6 col-sm-6">
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
                                    @php $favourite_list = array_filter(explode(',',$favourites[0])); @endphp
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
                @endif
                @if($ads->total() > $ads->perPage())
                <div class="col-md-12">
                    <div class="content-box p-3">
                    {{ $ads->appends($_GET)->links() }}
                    </div>
                </div>
                @endif
                </div>
            </div>
            
        </div>
        
    </div>
    </form>
</div>
@include('public/layout/footer')
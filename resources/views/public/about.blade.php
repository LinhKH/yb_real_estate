@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>About</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div id="menu-list">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card text-center" style = "margin: 0 0 20px 0;">
                    @foreach($pages as $item)
                    <div class="card-header">{{$item->page_title}}</div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">@php echo htmlspecialchars_decode($item->description) @endphp</p>
                    </div>
                    <div class="card-footer text-muted">
                       {{date('d M, Y',strtotime($item->created_at))}}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style = "margin: 0 0 20px 0;">
                    <div class="card-header">Ads Fields </div>
                    @foreach($ads as $item)
                    <div class="post" style="margin: 20px 10px;">
                        <div class="user-block" style="display:inline-block;width: 100%;">
                            <a href="single/{{$item->slug}}">
                                @if($item->ads_image != '')
                                    <img class="img-circle img-bordered-sm" src="{{asset('public/ads/'.$item->ads_image)}}" alt="user image" width="100px" height="100px" style="float:left;margin: 0 10px 0 0;">
                                @else
                                <img class="img-circle img-bordered-sm" src="{{asset('public/ads/default.png')}}" alt="user image" width="100px" height="100px" style="float:left;margin: 0 10px 0 0;">
                                @endif
                            </a>
                            <span class="username"><a href="single/{{$item->slug}}">{{$item->property_name}}</a></span>
                            <span class="description" style="display: block;"><small><i class="fa fa-map-marker"></i> {{$item->country}},  <cite title="Source Title">{{$item->state}},</cite>  <cite title="Source Title">{{$item->city}}</cite></small></span>
                        </div>
                        <!-- /.user-block -->
                    </div>
                    @endforeach
                </a>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
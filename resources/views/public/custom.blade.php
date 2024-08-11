@include('public/layout/header')
   
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{{$content->page_title}}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$content->page_title}}</li>
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
            <div class="col-md-12">
                {!!htmlspecialchars_decode($content->description)!!}
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Contact Us</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
            <iframe src="https://maps.google.com/maps?q={{$siteInfo->latitude}},{{$siteInfo->longitude}}&z=18&output=embed" class="map-iframe" width="100%" height="250px"></iframe>
            </div>
            <div class="col-md-10 offset-md-1 col-sm-12">
                <div class="message"></div>
                <form class="pt-3" id="addContact" method="POST">
                    @csrf
                    <div class="content-box">
                        <h3 class="mb-3">Get In Touch</h3>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Full Name:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="user_name" value="">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-4">
                            <input type="email" class="form-control" name="email" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticphone" class="col-sm-2 col-form-label">Phone No:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="phone" value="">
                            </div>
                            <label for="staticEmail" class="col-sm-2 col-form-label">Message:</label>
                            <div class="col-sm-4">
                                <textarea type="text" class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Send Message">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
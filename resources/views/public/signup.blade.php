@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Signup</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
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
            <div class="offset-3 col-md-6">
                <div class="message"></div>
                <form id="user-signup" method="POST">
                    @csrf
                    <div class="content-box">
                        <div class="mb-3">
                            <label class="col-form-label">Full Name :</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email :</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Phone Number :</label>
                            <input type="number" class="form-control" name="phone">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password :</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Country :</label>
                            <select name="country" class="form-control country-select">
                                <option value="" selected disbaled>Select Country</option>
                                @if(!empty($country))
                                    @foreach($country as $row)
                                    <option value="{{$row->country_id}}">{{$row->country_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">State :</label>
                            <select name="state" class="form-control state-select">
                                <option value="" selected disbaled>First Select Country</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">City :</label>
                            <select name="city" class="form-control city-select">
                                <option value="" selected disbaled>First Select State</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary" value="Sign Up">
                            <span class="info-text">Already a User? <a href="{{url('login')}}">LOGIN</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
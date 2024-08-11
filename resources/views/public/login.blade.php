@include('public/layout/header')
   
<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Login</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div id="site-content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-4 col-md-4">
                <div class="message"></div>
                <form id="user-login">
                    @csrf
                    <div class="content-box">
                        <div class="mb-3">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="user_name" placeholder="Email Address">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password</label>
                            <input type="password" class="form-control" name="user_password" placeholder="Password">
                        </div>
                        <div class="d-grid">
                            <input type="submit" class="btn btn-primary" value="Login">
                            <span class="info-text">Need an Account? <a href="{{url('signup')}}">SIGN UP</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')
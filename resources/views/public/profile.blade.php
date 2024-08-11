@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Profile</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div id="site-content">
    <div class="container">
        <form class="row" id="EditProfile" method="POST">
            <div class="col-md-3">
                <div class="content-box text-center">
                    @if($user->user_image != '')
                    <img id="image" class="mb-4" src="{{asset('public/users/'.$user->user_image)}}" alt="" width="100%">
                    @else
                    <img id="image" class="mb-4" src="{{asset('public/users/default.png')}}" alt="" width="100%">
                    @endif
                    <div>
                        <input type="hidden" name="old_img" value="{{$user->user_image}}" />
                        <input type="file" class="form-control" name="img" onChange="readURL(this);">
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="content-box">
                    @csrf  
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-sm-5 col-form-label">Full Name : </label>
                        <div class="col-lg-5 col-sm-7">
                            <input type="text" class="form-control" name="username" value="{{$user->username}}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-sm-5 col-form-label">Email / Username : </label>
                        <div class="col-lg-5 col-sm-7">
                            <input type="email" class="form-control" disabled value="{{$user->user_email}}" >
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="staticphone" class="col-lg-3 col-sm-5 col-form-label">Phone No : </label>
                        <div class="col-lg-5 col-sm-7">
                            <input type="number" class="form-control" name="phone" value="{{$user->user_phone}}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="staticphone" class="col-lg-3 col-sm-5 col-form-label">Country : </label>
                        <div class="col-lg-5 col-sm-7">
                            <select name="country" class="form-control country-select">
                                <option value="" selected disabled>Select Country</option>
                                @foreach($country as $row)
                                @php $selected = ($row->country_id == $user->user_country) ? 'selected' : '';  @endphp
                                <option value="{{$row->country_id}}" {{$selected}}>{{$row->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="staticphone" class="col-lg-3 col-sm-5 col-form-label">State : </label>
                        <div class="col-lg-5 col-sm-7">
                            <select name="state" class="form-control state-select">
                                <option value="" selected disabled>Select State</option>
                                @foreach($state as $row)
                                @php $selected = ($row->state_id == $user->user_state) ? 'selected' : '';  @endphp
                                <option value="{{$row->state_id}}" {{$selected}}>{{$row->state_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="staticphone" class="col-lg-3 col-sm-5 col-form-label">City : </label>
                        <div class="col-lg-5 col-sm-7">
                            <select name="city" class="form-control state-select">
                                <option value="" selected disabled>Select City</option>
                                @foreach($city as $row)
                                @php $selected = ($row->city_id == $user->user_city) ? 'selected' : '';  @endphp
                                <option value="{{$row->city_id}}" {{$selected}}>{{$row->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label  class="col-lg-3 col-sm-5 col-form-label">About Me :</label>
                        <div class="col-lg-5 col-sm-7">
                            <textarea type="text" class="form-control" name="description">{{$user->description}}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">UPDATE</button> 
                </div>
                <div class="message"></div>
            </div>
        </form>
    </div>
</div>

@include('public/layout/footer')
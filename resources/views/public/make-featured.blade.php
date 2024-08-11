@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Available Packages</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Packages</li>
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
                <div class="message"></div>
                <form
                role="form"
                action="{{url('my-listing/'.$id.'/featured')}}"
                method="post"
                class="require-validation"
                data-cc-on-file="false"
                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                id="payment-form">
                @csrf
                @if(session()->has('payment'))
                    <div class="alert alert-danger">{{session()->get('payment')}}</div>
                @endif
                <div class="content-box">
                    <h3 class="mb-4">Available Packages</h3>
                    <div class="row">
                        @if(!empty($packages))
                            @php $i = 0; @endphp
                            @foreach($packages as $pack)
                            <div class="mb-2 col-md-3">
                                <input type="radio" id="p{{$pack->id}}" name="package" value="{{$pack->id}}" @if($i == 0) checked @endif>
                                <label for="p{{$pack->id}}"><b>{{$siteInfo->cur_format}}{{$pack->price}}</b>/{{$pack->duration}} days</label> 
                            </div>
                            @php $i++; @endphp
                            @endforeach
                        @endif 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="content-box">
                            <h3>Payment Details - Stripe Payment Gateway</h3>
                            
                            <div class="mb-4">
                                <label for="">Name on Card</label>
                                <input type="text" class="form-control name-card" required>
                            </div>
                            <div class="mb-4">
                                <label for="">Card Number</label>
                                <input type="number" class="form-control number-card" maxlength="16" size="16" required>
                                <input type="text" hidden name="skey" value="{{env('STRIPE_KEY')}}">
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-4">
                                    <label for="">CVC</label>
                                    <input type="number" class="form-control cvc-card" maxlength="3" size="3" required>
                                </div>
                                <div class="mb-4 col-md-4">
                                    <label for="">Expire Month</label>
                                    <input type="number" class="form-control month-card" maxlength="2" size="2" placeholder="MM" required>
                                </div>
                                <div class="mb-4 col-md-4">
                                    <label for="">Expire Year</label>
                                    <input type="number" class="form-control year-card" maxlength="4" size="4" placeholder="YYYY" required>
                                </div>
                                <div class="col-md-12 text-center">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now <span class="amount"></span></button>
                                </div>
                                <div class="error alert hide"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('public/layout/footer')

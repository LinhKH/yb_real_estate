@include('public/layout/header')
    
<!-- Page Header Start -->
<div class="page-header mb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>My Listing</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Listing</li>
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
                @if(session()->has('payment'))
                    <div class="alert alert-success">{{session()->get('payment')}}</div>
                @endif
                <div class="content-box">
                    @if($ads->isEmpty())
                    <div class="text-center">
                        <a href="" class="btn btn-primary">Add New +</a>
                    </div>
                    @else
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Property Name</th>
                                <th scope="col">Purpose</th>
                                <th scope="col">Type</th>
                                <th scope="col">City</th>
                                <th scope="col">Show/Hide</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        @php  $i=0;  @endphp
                        @foreach($ads as $item)
                        @php $i++; @endphp
                        <tbody>
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$item->property_name}}
                                    @if($item->featured != '1')
                                    </br><small><a href="{{url('my-listing/'.$item->ads_id.'/featured')}}">Featured This Post</a></small></td>
                                    @else
                                    <b class="text-success">($)</b>
                                    <br><small>This Post is Featured upto <b>{{date('d M,Y',strtotime($item->end_date))}}</b></small>
                                    @endif
                                <td> {{$item->purpose_name}}</td>
                                <td>{{$item->cat_name}}</td>
                                <td>{{$item->city}}</td>
                                <td>
                                    @php $checked = '';  @endphp
                                    @if($item->status == '1')
                                    @php $checked = 'checked'; @endphp
                                    @endif
                                    <div class="checkbox">
                                        <input type="checkbox" class="changeStatus" id="checkbox{{$item->ads_id}}" {{$checked}}>
                                        <label for="checkbox{{$item->ads_id}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <a href="property/edit/{{$item->ads_id}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a> 
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@include('public/layout/footer')

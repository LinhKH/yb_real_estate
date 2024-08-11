<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 footer-widget"> 
                <h5>{{$siteInfo->com_name}}</h5>
                <p>{{$siteInfo->description}}</p>
            </div>
            <div class="col-md-3 col-sm-6 footer-widget"> 
                <h5>Useful Links</h5>
                <ul class="contacts">
                    @foreach($foot_pages as $item)
                        <li><a href="{{url('/'.$item->slug)}}">{{$item->page_title}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 footer-widget"> 
                <h5>Contact Us</h5>
                <ul class="contacts">
                    <li><i class="fa fa-map-marker"></i>{{$siteInfo->address}}</li>
                    <li><i class="fa fa-envelope"></i>{{$siteInfo->com_email}}</li>
                    <li><i class="fa fa-phone"></i>{{$siteInfo->com_phone}}</li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 footer-widget"> 
                <h5>Get in Touch</h5>
                <ul class="icon">
                    @foreach($social_settings as $item)
                        @if($item->facebook != '')
                            <li><a href="facebook.com"><i class="fab fa-facebook"></i></a></li>
                        @endif
                        @if($item->twitter != '')
                            <li><a href="twitter.com"><i class="fab fa-twitter"></i></a></li>
                        @endif
                        @if($item->linked_in != '')  
                            <li><a href="linked_in"><i class="fab fa-linkedin"></i></a></li>
                        @endif
                        @if($item->you_tube != '')      
                            <li><a href="you_tube"><i class="fab fa-youtube"></i></a></li>
                        @endif
                        @if($item->google_plus != '')
                            <li><a href="google_plus"><i class="fab fa-google-plus"></i></a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12">
                <span class="footer-copyright">{{$siteInfo->copyright_text}}</span>
            </div>
        </div>
    </div>
</div>  
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="{{asset('public/assets/public/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/popper.min.js')}}"></script>
<script src="{{asset('public/assets/public/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<!-- <script src="{{asset('public/assets/public/js/bootstrap.min.js')}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('public/assets/public/js/plugins.js')}}"></script>
<script src="{{asset('public/assets/public/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/public/js/select2.full.min.js')}}"></script>
<script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
<script src="{{asset('public/assets/public/js/jquery.flexslider-min.js')}}"></script>
<script src="{{asset('public/assets/public/js/modernizr.js')}}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- dropzone -->
<script src="{{asset('public/assets/public/js/action.js')}}"></script>
<input type="hidden" class="demo" value="{{url('/')}}"></input>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }   

    $(document).ready(function(){
        $('.select2').select2();

        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });

        // for create page
        $('.property-images').imageUploader({
            imagesInputName: 'gallery',
            'label': 'Drag and Drop' 
        });

        // for edit page

        var preloaded = [];
        <?php if(!empty($gallery_array)){ ?>
        var preloaded = <?php echo json_encode($gallery_array); ?>;
        <?php  } ?>

        $('.property-images1').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'gallery1',
            'label': 'Drag and Drop',
            preloadedInputName: 'old',
            maxFiles: 10,
            maxSize: 2 * 1024 * 1024,
        });


        $('.category-carousel').owlCarousel({
            loop:false,
            margin:15,
            nav:true,
            responsive:{
                0:{ items:1 },
                600:{ items:3 },
                1000:{ items:4 }
            }
        })

        $('.related-posts').owlCarousel({
            loop:false,
            margin:25,
            nav:false,
            responsive:{
                0:{ items:1 },
                600:{ items:2 },
                1000:{ items:2 }
            }
        })
    });
</script>
</body>
</html>
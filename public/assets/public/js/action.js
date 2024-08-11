$(document).ready(function(){

    




    var uRL = $('.demo').val();
    //alert(uRL);

    var loader = `<div class="loader-container">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>`; 

    function show_formAjax_error(data){
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<label class="error">' + error[0] + '</label>'));
            });
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // function load_listing(page=1){
    //     $('.row.listing').append(loader);
    //     $.ajax({
    //         url: uRL+'/load-listing?page='+page,
    //         type: 'GET',
    //         success: function (dataResult) {
    //             console.log(dataResult);
    //             if(dataResult != ''){
    //                 page = parseInt(page) + 1;
    //                 $('.load-list-more').attr('data-page',page);
    //                 setTimeout(function(){
    //                     $('.loader-container').remove();
    //                     $('.row.listing').append(dataResult);
    //                 },1000);
    //             }else{
    //                 setTimeout(function(){
    //                     $('.loader-container').remove();
    //                     $('.load-list-more').hide();
    //                 },1000);
    //             }
    //         }
    //     });
    // }

    // load_listing(1);


    // $('.load-list-more').click(function(){
    //     var page = $(this).attr('data-page');
    //     load_listing(page);
        // $('.row.listing').append(loader);
        // $.ajax({
        //     url: uRL+'/load-listing?page='+page,
        //     type: 'GET',
        //     success: function (dataResult) {
        //         console.log(dataResult);
        //         if(dataResult != ''){
        //             page = parseInt(page) + 1;
        //             $('.load-list-more').attr('data-page',page);
        //             setTimeout(function(){
        //                 $('.loader-container').remove();
        //                 $('.row.listing').append(dataResult);
        //             },1000);
        //         }else{
        //             setTimeout(function(){
        //                 $('.loader-container').remove();
        //                 $('.load-list-more').hide();
        //             },1000);
        //         }
        //     }
        // });
    // })






    
    // ========================================
    // script for User Login module
    // ========================================

    $('#user-login').validate({
        rules: {
            user_name: { required: true },
            user_password: { required: true }
        },
        messages: {
            user_name: { required: "Email is required" },
            user_password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            $('.message').empty();
            $('form').append(loader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/login',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Logged In Succesfully.</div>');
                        setTimeout(function(){ window.location.href = uRL; }, 2000);
                    } else {
                        $('.loader-container').remove();
                       $('.message').append('<div class="alert alert-danger">'+dataResult+'</div>');
                    }
                },
                error: function(data){
                    $('.loader-container').remove();
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for User SignUp module
    // ========================================

    $('#user-signup').validate({
        rules: {
            username: { required: true },
            phone: { required: true,minlength:10,maxlength:10 },
            email: { required: true,email: true },
            password: { required: true }
        },
        messages: {
            username: { required: "Name is required" },
            phone: { required: "Phone is required" },
            email: { required: "Email is required" },
            password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            $('.message').empty();
            $('form').append(loader);
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/signup',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Signup Successfull Please Login with Email and Password.</div>');
                        setTimeout(function () { window.location.href = uRL + '/login'; }, 2000);
                    } else {
                        $('.loader-container').remove();
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (data) {
                    $('.loader-container').remove();
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for Update Profile module
    // ========================================

    $('#EditProfile').validate({
        rules: {
            username: { required: true },
            phone: { required: true },
        },
        messages: {
            username: { required: "User Name is required" },
            phone: { required: "Phone is required" },
        },
        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/update-user-profile',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult){
                    if(dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Profile Updated Succesfully..</div>');
                        setTimeout(function () { window.location.href = uRL + '/my-profile'; }, 3000);
                    }else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (dataResult){
                    show_formAjax_error(dataResult);
                }
            });
        }
    });

    // ========================================
    // script for Add Property module
    // ========================================
    
    // $(document).on('click', '.add_property', function () {
    //     $('#exampleModal').modal('show');
    // });
    $('.country-select').change(function(){
        var val = $(this).children('option:selected').val();
        $.ajax({
            url: uRL+'/get-country-states',
            type: 'POST',
            data: {country_id:val},
            success:function(response){
                $('.state-select').html(response);
            }
        })
    });

    $('.state-select').change(function(){
        var val = $(this).children('option:selected').val();
        $.ajax({
            url: uRL+'/get-state-city',
            type: 'POST',
            data: {state_id:val},
            success:function(response){
                console.log(response)
                $('.city-select').html(response);
            }
        })
    });


    $('#AddProperty').validate({ 
        rules: {
            title: { required: true },
            desc: { required: true },
            type: { required: true },
            status: { required: true },
            area: { required: true },
            price: { required: true },
            image: { required: true },
            country: { required: true },
            state: { required: true },
            city: { required: true },
            image: { required: true },
        },
        submitHandler: function (form) {
            $('form').append(loader);
            var formdata = new FormData(form);
            var facility = '';
            $('.facility').each(function(){
                if($(this).prop('checked') == true){
                    facility += $(this).val()+',';
                }
            })
            formdata.append('facility',facility);
            formdata.append('gallery', $('input[name^=gallery]').prop('files'));
            $.ajax({
                url: uRL + '/create',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success"> Your Property Added Successfully.</div>');
                        setTimeout(function () {
                            $('.loader-container').hide();
                            window.location.href = uRL + '/my-listing';
                        }, 5000);
                    } else {
                        $('.loader-container').hide();
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
            
        }
    });

    
   
    $('#editProperty').validate({
        rules: {
            title: { required: true },
            desc: { required: true },
            type: { required: true },
            status: { required: true },
            area: { required: true },
            price: { required: true },
            // image: { required: true },
            country: { required: true },
            state: { required: true },
            city: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var facility = '';
            $('.facility').each(function(){
                if($(this).prop('checked') == true){
                    facility += $(this).val()+',';
                }
            })
            formdata.append('facility',facility);
            formdata.append('gallery', $('input[name^=gallery]').prop('files'));
            var id = $('input[name=id]').val();
            $.ajax({
                url:  uRL+'/property/update/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success"> Updated Succesfully..</div>');
                        setTimeout(function () { window.location.href = uRL + '/my-listing'; }, 2000);
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });


    $('.changeStatus').change(function(){
        var id = $(this).attr('id');
        id = id.replace('checkbox','');
        var check = '0';
        if($(this).prop('checked') == true){
            check = '1';
        }
        $.ajax({
            url: uRL + '/property/change-status/' + id,
            type: "POST",
            data: {id:id,status:check},
            success: function (dataResult) {
                // console.log(dataResult);
                // if (dataResult == '1') {
                //     $('.message').append('<div class="alert alert-success">Deleted Succesfully.</div>');
                //     setTimeout(function () { window.location.reload(); }, 3000);
                // } else {
                //     $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                // }
            }
        });
    })




    // ========================================
    // script for User ContactUs module
    // ========================================

    $('#addContact').validate({
        rules: {
            user_name: { required: true },
            email: { required: true },
            phone: { required: true },
            description: { required: true }
        },
        messages: {
            user_name: { required: "Please Enter Your Name" },
            email: { required: "Please Enter Your Email address" },
            phone: { required: "Please Enter Your Phone" },
            description: { required: "Please Enter Your Description" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/contact',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success"> Your Contact Information Send Successfully.</div>');
                        setTimeout(function () { window.location.href = uRL + '/contact'; }, 3000);
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    $(document).on("click", ".add-favourite", function (e) { 
        e.preventDefault();
        var id = $(this).attr('data-id');
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
        $.ajax({
            url: uRL + '/add-user-favourite',
            type: "POST",
            data: {id:id},
            cache: false,
            success: function (dataResult) {
                console.log(dataResult);
               if (dataResult == 'false') {
                    setTimeout(function () { window.location.href = uRL + '/login'; }, 500);
                }
            }
        });
    });



    $('#location').keyup(function(){
        var val = $(this).val();
        if(val != ''){
            $.ajax({
                url: uRL + '/get-locations',
                type: "POST",
                data: {val:val},
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    $('.location-list').html(dataResult);
                    $('.location-list').show();
                
                }
            });
        }else{
            $('.location-list').hide();
        }
    })

    // $('#location').focusout(function(){
    //     $('.location-list').empty();
    //     $('.location-list').hide();
    // })
    // $('.location-list span').click(function(){
    $(document).on('click','.location-list span',function(){
        var val = $(this).children('').text();
        var id = $(this).attr('data-id');
        // alert(id);
        $('#location').val(val);
        $('.location-no').val(id);
        $('.location-list').hide();
    })


    function search_filter(){
        // alert(1);
        var loc = $('.location-no').val();
        var status = $('select[name=status] option:selected').val();
        var type = $('input[name=type]:checked').val();
        var facility = $('select[name=facility] option:selected').val();
        var sort = $('select[name=sort] option:selected').val();
        var min_price = $('input[name=price_min]').val();
        var max_price = $('input[name=price_max]').val();

        if(max_price < min_price){
            alert('Please Enter Correct Min - Max Price');
        }else{
            $('.search-res-list').append(loader);
            $.ajax({
                url: uRL + '/search-filter',
                type: "POST",
                data: {loc:loc,status:status,type:type,facility:facility,sort:sort,min_price:min_price,max_price:max_price},
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult['count']);
                    setTimeout(function(){
                        $('.search-res-list').html(dataResult['data']);
                        // $('.count').html(dataResult['count']);
                    },2000)
                }
            });
        }
    }


    
    $('.list-layout').click(function(){
        $('.search-res-list .col-md-4').addClass('list-box');
        
        $('.search-res-list .col-md-4').addClass('col-md-12');
        $('.search-res-list .col-md-4 .list-grid').addClass('flex-row');
        $('.search-res-list .col-md-4 .list-grid').removeClass('flex-column');
        $('.search-res-list .col-md-4 .list-grid .list-image').css('width','362px');
        $('.search-res-list .col-md-4 .list-grid .list-content').addClass('flex-fill');
        $('.search-res-list .col-md-4').removeClass('col-md-4');
    })

    $('.grid-layout').click(function(){
        // alert(1);
        $('.search-res-list .col-md-12').removeClass('list-box');
        
        $('.search-res-list .col-md-12').addClass('col-md-4');
        $('.search-res-list .col-md-12 .list-grid').removeClass('flex-row');
        $('.search-res-list .col-md-12 .list-grid').addClass('flex-column');
        $('.search-res-list .col-md-12 .list-grid .list-image').css('width','100%');
        $('.search-res-list .col-md-12 .list-grid .list-content').removeClass('flex-fill');
        $('.search-res-list .col-md-12').removeClass('col-md-12');
    })



    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
        'input[type=text]', 'input[type=file]',
        'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.number-card').val(),
                cvc: $('.cvc-card').val(),
                exp_month: $('.month-card').val(),
                exp_year: $('.year-card').val()
                }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $form.append('<div class="alert alert-danger">'+response.error.message+'</div>');
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.append(loader);
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
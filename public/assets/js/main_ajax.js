$(function () {

    var uRL = $('.demo').val();
    //alert(uRL);

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function(e) {
        $(this).find('form')[0].reset();
      });

    $('.change-logo').click(function () {
        $('.change-com-img').click();
    });

    // delete data common function
    function destroy_data(name, url) {
        var el = name;
        var id = el.attr('data-id');
        var dltUrl = url + id;
        if (confirm('Are you Sure Want to Delete This')) {
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted Successfully'
                        })
                    } else {
                        Toast.fire({
                            icon: 'danger',
                            title: dataResult
                        })
                    }
                }
            });
        }
    }

    function show_formAjax_error(data) {
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

    $('.admin-logout').click(function () {
        $.ajax({
            url: uRL + '/admin/logout',
            type: "GET",
            cache: false,
            success: function (dataResult) {
                if (dataResult == '1') {
                    setTimeout(function () {
                        window.location.href = uRL+'/admin';
                    }, 500);
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged Out Succesfully.'
                    })
                }
            }
        });
    });

    // ========================================
    // script for Users module
    // ========================================
    // $('.status-user').click(function(){
    $(document).on('click','.status-user',function(){
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $.ajax({
            url: uRL + '/admin/userChange_status',
            type: "POST",
            data:{id:id,status:status},
            success: function (dataResult) {
                setTimeout(function () { window.location.reload(); }, 1000);
            }
        });
    })


    // ========================================
    // script for Ads module
    // ========================================
    // Dropzone.options.gallery = {
    //     autoProcessQueue: false,
    //     url: 'upload_files.php',
    //     init: function () {

    //         var myDropzone = this;

    //         // Update selector to match your button
    //         $("#button").click(function (e) {
    //             e.preventDefault();
    //             myDropzone.processQueue();
    //         });

    //         this.on('sending', function(file, xhr, formData) {
    //             // Append all form inputs to the formData Dropzone will POST
    //             var data = $('#frmTarget').serializeArray();
    //             $.each(data, function(key, el) {
    //                 formData.append(el.name, el.value);
    //             });
    //         });
    //     }
    // }

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


    $('#addProperty').validate({
        rules: {
            image: { required: true },
            title: { required: true },
            desc: { required: true },
            type: { required: true },
            country: { required: true },
            state: { required: true },
            city: { required: true },
            type: { required: true },
            status: { required: true },
            area: { required: true },
            price: { required: true },
            "gallery[]": { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var facility = '';
            // alert($('input[name=gallery[]]').val());
            $('.facility').each(function(){
                if($(this).prop('checked') == true){
                    facility += $(this).val()+',';
                }
            })
            
            formdata.append('facility',facility);
            formdata.append('gallery', $('input[name^=gallery]').prop('files'));
            // console.log($('input[name^=gallery]').prop('files'));
            $.ajax({
                url: uRL + '/admin/properties',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/properties'; }, 1000);
                    }
                }, 
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateProperty').validate({
        rules: {
            title: { required: true },
            desc: { required: true },
            type: { required: true },
            country: { required: true },
            state: { required: true },
            city: { required: true },
            type: { required: true },
            status: { required: true },
            area: { required: true },
            price: { required: true },
        },
        submitHandler: function (form) {
            var id = $('input[name=id]').val();
            var formdata = new FormData(form);
            var facility = '';
            $('.facility').each(function(){
                if($(this).prop('checked') == true){
                    facility += $(this).val()+',';
                }
            })
            formdata.append('facility',facility);
            formdata.append('gallery', $('input[name^=gallery1]').prop('files'));
            $.ajax({
                url: uRL+'/admin/properties/'+id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/properties'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-ads", function (){
        destroy_data($(this), 'properties/')
    });
    
    // ========================================
    // script for Pages module
    // ========================================
    $('#addPage').validate({
        rules: { title: { required: true }, },
        messages: { title: { required: "Please Enter Title Name" },},

        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/pages',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000)
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updatePage').validate({
        rules: { title: { required: true }, },
        messages: { title: { required: "Please Enter Title Name" }, },

        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-page", function () {
        destroy_data($(this), 'pages/')
    });

    $(document).on('click','.show-in-header',function(){
        var id = $(this).attr('id');
        if($('#'+id).is(':checked')){
           var status = 1;
        }else{
            var status = 0;
        }
        id = id.replace('head','');
        $.ajax({
            url: uRL + '/admin/page_showIn_header',
            type: 'POST',
            data: {id:id,status:status},
            success: function (dataResult) {
            }
        });
    })

    $(document).on('click','.show-in-footer',function(){
        var id = $(this).attr('id');
        if($('#'+id).is(':checked')){
           var status = 1;
        }else{
            var status = 0;
        }
        id = id.replace('foot','');
        $.ajax({
            url: uRL + '/admin/page_showIn_footer',
            type: 'POST',
            data: {id:id,status:status},
            success: function (dataResult) {
            }
        });
    })


    // ========================================
    // script for Facilities module
    // ========================================
    
    $('#add_facility').validate({
        rules: { 
            facility: { required: true },
            type: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/facilities',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_facility', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'facilities/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=facility]').val(dataResult[0].name);
                $('#modal-info input[name=type]').val(dataResult[0].status);
                $("#modal-info select[name=type] option").each(function () {
                    if ($(this).val() == dataResult[0].type) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#update_facility").validate({
        rules: {
            facility: { required: true },
            type: { required: true }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/facilities/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-facility", function () {
        destroy_data($(this), 'facilities/')
    });

    // ========================================
    // script for Packages module
    // ========================================
    
    $('#add_package').validate({
        rules: { 
            duration: { required: true },
            price: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/packages',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_package', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'packages/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                console.log(dataResult);
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=duration]').val(dataResult[0].duration);
                $('#modal-info input[name=price]').val(dataResult[0].price);
                $("#modal-info select[name=status] option").each(function () {
                    if ($(this).val() == dataResult[0].status) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#update_package").validate({
        rules: {
            duration: { required: true },
            price: { required: true }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/packages/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-package", function () {
        destroy_data($(this), 'packages/')
    });

    // ========================================
    // script for Distance module
    // ========================================

    $('#add_distance').validate({
        rules: { distance: { required: true } },
        messages: { distance: { required: "Please Enter Distance Name" } },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/distance',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_distance', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'distance/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].distance_id);
                $('#modal-info input[name=distance]').val(dataResult[0].distance_name);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].distance_id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_distance").validate({
        rules: { distance: { required: true } },
        messages: { distance: { required: "Please Enter Distance Name" } },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/distance/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-distance", function () {
        destroy_data($(this), 'distance/')
    });

    // ========================================
    // script for Purpose module
    // ========================================

    $('#add_purpose').validate({
        rules: { purpose: { required: true } },
        messages: { purpose: { required: "Please Enter Purpose Name" } },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/purpose',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_purpose', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'purpose/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=purpose]').val(dataResult[0].name);
                $('#modal-info input[name=status]').val(dataResult[0].status);
                $("#modal-info select[name=status] option").each(function () {
                    if ($(this).val() == dataResult[0].status) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#update_purpose").validate({
        rules: {
            purpose: { required: true },
            status: { required: true }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/purpose/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-purpose", function () {
        destroy_data($(this), 'purpose/')
    });

    // ========================================
    // script for Category module
    // ========================================

    $('#add_category').validate({
        rules: {
            category: { required: true },
            image: { required: true }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/category',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_category', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'category/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult.id);
                $('#modal-info input[name=category]').val(dataResult.category_name);
                $('#modal-info input[name=slug]').val(dataResult.cat_slug);
                $('#modal-info input[name=old_image]').val(dataResult.cat_image);
                if(dataResult.cat_image != ''){
                    $('#modal-info #image1').attr('src',uRL+'/public/category/'+dataResult.cat_image);
                }
                $('#modal-info input[name=status]').val(dataResult.status);
                $("#modal-info select[name=status] option").each(function () {
                    if ($(this).val() == dataResult.status) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult.id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_category").validate({
        rules: {
            category: { required: true },
            status: { required: true }
        },
        messages: {
            category: { required: "Please Enter Category Name" },
            status: { required: "Please Enter Status" }
        },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/category/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-category", function () {
        destroy_data($(this), 'category/')
    });

    // ========================================
    // script for Country module
    // ========================================

    $('#add_country').validate({
        rules: { country: { required: true } },
        messages: { country: { required: "Please Enter Country Name" } },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+'/admin/country',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_country', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'country/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].country_id);
                $('#modal-info input[name=country]').val(dataResult[0].country_name);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].country_id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_country").validate({
        rules: { country: { required: true } },
        messages: { country: { required: "Please Enter Country Name" } },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            var id = $('#modal-info input[name=id]').val();
            $.ajax({
                url: uRL + '/admin/country/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-country", function () {
        destroy_data($(this), 'country/')
    });

     // ========================================
    // script for State module
    // ========================================

    $('#add_state').validate({
        rules: {
            state: { required: true },
            country: { required: true }
        },
        messages: {
            state: { required: "Please Enter State Name" },
            country: { required: "Please Enter Country Name" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL+ '/admin/states',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_state', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'states/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                //console.log(dataResult);
                $('#modal-info input[name=id]').val(dataResult[0].state_id);
                $('#modal-info input[name=state]').val(dataResult[0].state_name);
                $('#modal-info input[name=country]').val(dataResult[0].country_id);
                $("#modal-info select[name=country] option").each(function () {
                    if ($(this).val() == dataResult[0].country_id) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].state_id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_state").validate({
        rules: {
            state: { required: true },
            country: { required: true }
        },
        messages: {
            state: { required: "Please Enter State Name" },
            country: { required: "Please Enter Country Name" }
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/states' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-state", function () {
        destroy_data($(this), ' states/')
    });

    // ========================================
    // script for City module
    // ========================================

    $('#add_city').validate({
        rules: {
            city: { required: true },
            state: { required: true }
        },
        messages: {
            city: { required: "Please Enter City Name" },
            state: { required: "Please Enter State Name" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/city',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.edit_city', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'city/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].city_id);
                $('#modal-info input[name=city]').val(dataResult[0].city_name);
                $('#modal-info input[name=state]').val(dataResult[0].state_id);
                $("#modal-info select[name=state] option").each(function () {
                    if ($(this).val() == dataResult[0].state_id) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].city_id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#edit_city").validate({
        rules: {
            city: { required: true },
            state: { required: true }
        },
        messages: {
            city: { required: "Please Enter City Name" },
            state: { required: "Please Enter State Name" }
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/city' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                }
            });
        },
        error: function (error) {
            show_formAjax_error(error);
        }
    });

    $(document).on("click", ".delete-city", function () {
        destroy_data($(this), ' city/')
    });

    // ========================================
    // script for Banner Settings
    // ========================================

    $('#updateBannerSetting').validate({
        rules: {
            title: { required: true },
            sub_title: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/banner-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    // console.log(dataResult);
                    if (dataResult == '1' || dataResult == '0') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/banner-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for General Setting module
    // ========================================

    $('#updateGeneralSetting').validate({
        rules: {
            com_name: { required: true },
            com_email: { required: true },
            address: { required: true },
            phone: { required: true },
            currency: { required: true },
            f_address: { required: true },
           
        },
        messages: {
            com_name: { required: "Company Name is Required" },
            com_email: { required: "Company Email is Required" },
            address: { required: "Company Address is Required" },
            phone: { required: "Company Phone is Required" },
            currency: { required: "Currency Format is Required" },
            f_address: { required: "Company Footer Address is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/general-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    // console.log(dataResult);
                    if (dataResult == '1' || dataResult == '0') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/general-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Admin  module
    // ========================================

    $('#updateProfileSetting').validate({
        rules: {
            username: { required: true },
            email: { required: true },
            username: { required: true },
        },
        messages: {
            admin_name: { required: "Please Enter Your Username" },
            admin_email: { required: "Please Enter Email Address" },
            username: { required: "Please Enter Email Address" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/profile-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1' || dataResult == '0') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateAdminPassword').validate({
        rules: {
            password: { required: true },
            new_pass: { required: true },
            con_pass: { required: true,equalTo:"#new-pass" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/profile/change-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1' || dataResult == '0') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }else{
                        var el = $(document).find('[name="password"]');
                        el.after($('<span class="error">' + dataResult.false + '</span>'));
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Social Links  module
    // ========================================

    $('#updateSocialSetting').validate({
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/social-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1' || dataResult == '0') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/social-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

     // ========================================
    // script for User Contacts  module
    // ========================================

    $(document).on('click', '.viewContact', function () {
        $('#modal-info').modal('show');
        var id = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/admin/contact/'  + id,
            type: 'POST',
            success: function (dataResult) {
                $('#modal-info .table').html(dataResult);
            },
        });
    });

});
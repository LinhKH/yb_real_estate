<div class="modal fade" id="view-application"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Leaves Application View</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="id"></span>
                        <strong>Date :</strong>
                        <span id="date"></span>
                        <hr>
                        <strong>Leave Type:</strong>
                        <span id="leave_type"></span>
                        <hr>
                        <strong>Reason:</strong>
                        <span id="reason"></span>
                        <hr>
                        <strong>Status:</strong>
                        <span id="status"></span>
                        <hr>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal --> 
        
<!-- /.content-wrapper -->
    
        <footer class="main-footer">
            <strong>Copyright © <a href="https://www.yahoobaba.net" target="_blank">YahooBaba</a></strong>
        </footer>
        <input type="hidden" class="demo" value="{{url('/')}}"></input>
    <!-- ./wrapper -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('public/assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('public/assets/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- InputMask -->
     <script src="{{asset('public/assets/js/jquery.inputmask.bundle.min.js')}}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset('public/assets/js/bs-custom-file-input.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('public/assets/js/daterangepicker.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('public/assets/js/adminlte.js')}}"></script>
    
    <!-- jquery-validation -->
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('public/assets/js/summernote-bs4.min.js')}}"></script>
    <!-- SweetAlert -->
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
    <!-- Main_ajax.js -->
    <script src="{{asset('public/assets/js/main_ajax.js')}}"></script>
    <script>
        // Dropzone.options.gallery = {
        //     autoProcessQueue: false,
        //     addRemoveLinks: true,
        //     url: 'upload_files.php',
        //     init: function () {

        //         // var myDropzone = this;

        //         // // Update selector to match your button
        //         // $("#button").click(function (e) {
        //         //     e.preventDefault();
        //         //     myDropzone.processQueue();
        //         // });

        //         // this.on('sending', function(file, xhr, formData) {
        //         //     // Append all form inputs to the formData Dropzone will POST
        //         //     var data = $('#frmTarget').serializeArray();
        //         //     $.each(data, function(key, el) {
        //         //         formData.append(el.name, el.value);
        //         //     });
        //         // });
        //     }
        // }


        $(function () {

            // $('.property-images').imageUploader({
            //     imagesInputName: 'gallery',
            //     'label': 'Drag and Drop'
            // });

            // $('.property-images1').imageUploader({
            //     imagesInputName: 'gallery',
            //     'label': 'Drag and Drop'
            // });

            

            
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_1').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_2').datetimepicker({
                format: 'L'
            });

            $('#reservationdate_3').datetimepicker({
                format: 'L'
            });


            //Money Euro
            $('[data-mask]').inputmask()
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote()
        })
    </script>
    <!-- <script>
        document.getElementByClass("demo").innerHTML = uRL;
    </script> -->
    @yield('pageJsScripts')
</body>
</html>
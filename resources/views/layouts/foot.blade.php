<!-- plugins:js -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>
<!-- endinject -->

{{-- jquery select --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Select 2 --}}
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/file-upload.js') }}"></script>
{{-- <script src="{{ asset('assets/js/typeahead.js') }}"></script> --}}
<script src="{{ asset('assets/js/select2.js') }}"></script>
{{-- <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- <script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script> --}}

{{-- Chart Js --}}
{{-- <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.js') }}"></script> --}}
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- End Chart --}}

{{-- data tables --}}
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
{{-- Cdn Autonumeric --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js" integrity="sha512-6j+LxzZ7EO1Kr7H5yfJ8VYCVZufCBMNFhSMMzb2JRhlwQ/Ri7Zv8VfJ7YI//cg9H5uXT2lQpb14YMvqUAdGlcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- Date Picker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- End Date Picker --}}
{{-- Toastify --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

{{-- Cdn ummer Note --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> --}}

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>

{{-- Cdn EChart --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.3/echarts.min.js" integrity="sha512-EmNxF3E6bM0Xg1zvmkeYD3HDBeGxtsG92IxFt1myNZhXdCav9MzvuH/zNMBU1DmIPN6njrhX1VTbqdJxQ2wHDg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    $(document).ready(function() {
        // var socket = io('http://localhost:3000',{ transports: ["websocket"] });

        // socket.on('notif-order', (msg) => {
        //     console.log('DATA::',msg);
        // })
        // setInterval(() => {
        //     socket.emit('message', 'datas');
        // }, 1000);
    // Fakes the loading setting a timeout
    setTimeout(function() {
        $('body').addClass('loaded');
    }, 1000);

    });

    $(document).ready(function () {
        // $('#example').DataTable(
        //     responsive: true
        // );
        var table = $('#mytable').DataTable( {
            responsive: true,
            "lengthMenu": [[100, 50, 25], [100, 50, 25]]
    });

    });

    function detailModal(title, url, width) {
        $.confirm({
            title: title,
            theme : 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'URL:'+url,
            animation: 'zoom',
            closeAnimation: 'scale',
            animationSpeed: 400,
            closeIcon: true,
            columnClass: width,
            buttons: {
                close: {
                    btnClass: 'btn-dark font-bold',
                }
            },
        });
    }

    function createForm(title,url) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
                buttons: {
                    // confirm: function () {
                    //     $.alert('Confirmed!');
                    // },
                    cancel: function () {
                        $.alert('Canceled!');
                    },
                    // somethingElse: {
                    //     text: 'Something else',
                    //     btnClass: 'btn-blue',
                    //     keys: ['enter', 'shift'],
                    //     action: function(){
                    //         $.alert('Something else?');
                    //     }
                    // }
                }
        });
    }

    function editForm(title,url) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
                buttons: {
                    // confirm: function () {
                    //     $.alert('Confirmed!');
                    // },
                    cancel: function () {
                        $.alert('Canceled!');
                    },
                    // somethingElse: {
                    //     text: 'Something else',
                    //     btnClass: 'btn-blue',
                    //     keys: ['enter', 'shift'],
                    //     action: function(){
                    //         $.alert('Something else?');
                    //     }
                    // }
                }
        });
    }

    function modalDelete(title, name, url, link) {
        $.confirm({
            title: `Delete ${title}?`,
            content: `Are you sure want to delete ${name}`,
            autoClose: 'cancel|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_method": 'delete',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                window.location.href = link
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });

    }
</script>

<script>
    function logout() {
        $.confirm({
            icon: 'fas fa-sign-out-alt',
            title: 'Logout',
            theme: 'supervan',
            content: 'Are you sure want to logout?',
            autoClose: 'cancel|800000',
            buttons: {
                logout: {
                    text: 'logout',
                    btnClass: 'btn-danger',

                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('logout') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                location.reload();
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });
    }
</script>

@if(session()->has('success'))
    <script>
            Toastify({
                text: "{{ session()->get('success') }}",
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#D5F3E9",
                    color: "#1f7556"
                },
                duration: 3000
            }).showToast();
    </script>
@endif

@if(session()->has('warning'))
<script>
        Toastify({
            text: "{{ session()->get('warning') }}",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "#FBEFDB",
                color: "#916c2e"
            },
            duration: 3000
        }).showToast();
</script>
@endif

@if(session()->has('failed'))
<script>
    Toastify({
        text: "🚨 {{ session()->get('failed') }}",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        theme: "dark",
        style: {
            background: "#fde1e1",
            color: "#924040"
        },
        duration: 4000
    }).showToast();
</script>

<script>
    function phoneMask() {
        var num = $(this).val().replace(/\D/g,'');
        $(this).val(num.substring(0,13));
    }
    $('[type="tel"]').keyup(phoneMask);
</script>

@endif

<script>
    function downloadImage(id) {
    // Get the barcode image element
    const barcodeImage = document.getElementById('barcode-image');
    
    // Create a canvas element
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    
    // Set the canvas dimensions to match the image
    canvas.width = barcodeImage.width;
    canvas.height = barcodeImage.height;
    
    // Draw the image onto the canvas
    context.drawImage(barcodeImage, 0, 0);
    
    // Convert the canvas content to a data URL
    const dataUrl = canvas.toDataURL('image/jpeg');
    
    // Create a temporary anchor element for downloading
    const downloadLink = document.createElement('a');
    downloadLink.href = dataUrl;
    downloadLink.download = 'barcode.jpg';
    
    // Trigger the download
    downloadLink.click();
}
</script>

@yield('javascript')
@stack('script_bot')






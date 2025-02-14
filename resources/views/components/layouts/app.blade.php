<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP</title>
    <link rel="icon" href="{{ asset('erp.webp') }}" type="image/x-icon">
    @livewireStyles
    <!-- Add Select2 CSS in the <head> section -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- FontAwesome Ikonalarini qo'shish -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('erp.webp') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text">EPR</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="d-flex">
                    <div class="image">
                        @if (auth()->check() && auth()->user()->image)
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-dashboard"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if (auth()->user()->role_id == 1)
                            <li
                                class="nav-item has-treeview {{ request()->is('users*') || request()->is('roles*') || request()->is('permissions*') || request()->is('groups*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('users*') || request()->is('roles*') || request()->is('permissions*') || request()->is('groups*') ? 'active' : '' }}">
                                    <i class="fas fa-cogs"></i>
                                    <p>
                                        Auth
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}"
                                            class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                                            <i class="fas fa-user"></i>
                                            <p>Users</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}"
                                            class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                            <i class="fas fa-user-shield"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.index') }}"
                                            class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                                            <i class="fas fa-lock"></i>
                                            <p>Permissions</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('groups.index') }}"
                                            class="nav-link {{ request()->is('groups*') ? 'active' : '' }}">
                                            <i class="fas fa-users"></i>
                                            <p>Groups</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->role_id == 5 || auth()->user()->role_id == 1)
                            <li
                                class="nav-item has-treeview {{ request()->is('salary_types*') || request()->is('sections*') || request()->is('workers*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('salary_types*') || request()->is('sections*') || request()->is('workers*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i>
                                    <p>
                                        HR
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('salary_types.index') }}"
                                            class="nav-link {{ request()->is('salary_types*') ? 'active' : '' }}">
                                            <i class="fas fa-calculator"></i>
                                            <p>Salary Types</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('sections.index') }}"
                                            class="nav-link {{ request()->is('sections*') ? 'active' : '' }}">
                                            <i class="fas fa-layer-group"></i>
                                            <p>Sections</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('workers.index') }}"
                                            class="nav-link {{ request()->is('workers*') ? 'active' : '' }}">
                                            <i class="fas fa-users-cog"></i>
                                            <p>Workers</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 7)
                            <li
                                class="nav-item has-treeview {{ request()->is('warehouses*') || request()->is('revenues*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('warehouses*') || request()->is('revenues*') ? 'active' : '' }}">
                                    <i class="fas fa-warehouse"></i>
                                    <p>
                                        Warehouse Manager
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('warehouses.index') }}"
                                            class="nav-link {{ request()->is('warehouses*') ? 'active' : '' }}">
                                            <i class="fas fa-boxes"></i>
                                            <p>Warehouses</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('revenues.index') }}"
                                            class="nav-link {{ request()->is('revenues*') ? 'active' : '' }}">
                                            <i class="fas fa-chart-line"></i>
                                            <p>Revenues</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 4)
                            <li
                                class="nav-item has-treeview {{ request()->is('products*') || request()->is('machines*') || request()->is('produces*') || request()->is('manufactures*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('products*') || request()->is('machines*') || request()->is('produces*') || request()->is('manufactures*') ? 'active' : '' }}">
                                    <i class="fas fa-cogs"></i>
                                    <p>
                                        Manufacturer
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}"
                                            class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                                            <i class="fas fa-tags"></i>
                                            <p>Products</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('machines.index') }}"
                                            class="nav-link {{ request()->is('machines*') ? 'active' : '' }}">
                                            <i class="fas fa-tractor"></i>
                                            <p>Machines</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('produces.index') }}"
                                            class="nav-link {{ request()->is('produces*') ? 'active' : '' }}">
                                            <i class="fas fa-industry"></i>
                                            <p>Production</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('manufactures.index') }}"
                                            class="nav-link {{ request()->is('manufactures*') ? 'active' : '' }}">
                                            <i class="fas fa-tools"></i>
                                            <p>Manufacture</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="list-group-item">
                            <form action="{{ route('logout') }}" method="POST"
                                class="d-flex align-items-center w-100">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link text-danger w-100 text-start d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        @if (request()->route()->getName() == 'manufactures.index')
            {{ $slot }}
        @endif
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if (request()->route()->getName() == 'products.index' || request()->route()->getName() == 'produces.index')
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </section>
        </div>
    </div>
    @livewireScripts
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
</body>

</html>

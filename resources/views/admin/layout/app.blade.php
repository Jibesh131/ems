<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset('mix/image/logo.png') }}" type="image/x-icon">
    <title>
        {{ config('app.name') ?? '' }}
        {{ empty($title) ? '' : ' | ' . $title }}
    </title>
    <script src="{{ asset('admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}?v={{ time() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('admin/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/kaiadmin.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    
    @livewireStyles

    <script src="{{ asset('admin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('mix/js/main.js') }}"></script>
    <script src="{{ asset('admin/js/kaiadmin.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    @stack('cdn')
    
    <style>
        label.required::after {
            content: " *";
            color: red;
        }

        .alert .close {
            border: 0;
            font-size: 25px;
            opacity: 0.6;
        }

        .alert .close:hover {
            opacity: 1;
        }
    </style>
    @stack('css')

</head>

<body>
    @include('admin.layout.inc.alert')
    <div class="wrapper">
        @include('admin.layout.inc.sidebar')
        <div class="main-panel">
            @include('admin.layout.inc.navbar')
            <div class="container">
                <div class="page-inner">
                    @include('admin.layout.inc.breadcrumbs')
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-3">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('modal')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#logoutBtn').on('click', function() {
                Swal.fire({
                    title: 'Are you sure you want to logout?',
                    // text: "You will be logged out of the admin panel.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{  }}";
                    }
                });
            })

            $('button[data-dismiss="modal"]').on('click', function() {
                const modalId = $(this).data('modal');
                const $modal = $('#' + modalId);

                if ($modal.length) {
                    $modal.modal('hide');
                    $modal.hide();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                }
            });

            $(".datepicker").datepicker();
            $(".select2").select2();
        })

        function showNotify(type, message, title = '', delay = 4500) {
            const icons = {
                primary: 'fas fa-star',
                secondary: 'fas fa-circle',     
                success: 'fas fa-check',        
                info: 'fas fa-info-circle',
                warning: 'fas fa-exclamation-triangle',
                danger: 'fa-solid fa-circle-exclamation',
                black: 'fas fa-moon',
                default: 'fas fa-bell'
            };

            const iconClass = icons[type] || icons.default;
            const titleHtml = title ? `<strong>${title}</strong><br>` : '';

            $.notify({
                icon: iconClass,
                title: titleHtml,
                message: message
            }, {
                type: type,
                allow_dismiss: true,
                delay: delay,
                placement: {
                    from: "top",
                    align: "right"
                },
                mouse_over: 'pause',
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    @livewireScripts
    @stack('js')
</body>

</html>

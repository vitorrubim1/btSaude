<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>BT Profissionais | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://kit.fontawesome.com/b3844e478c.js" crossorigin="anonymous"></script>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
      OneSignal.init({
        appId: "f817af76-e425-4437-a861-fdbbc3410d7c",
        autoResubscribe: true,
        notifyButton: {
          enable: true,
        },
      });
      OneSignal.showNativePrompt();
    });
  </script>
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Datatables css -->
        <link href="{{url("assets/css/vendor/dataTables.bootstrap4.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{url("assets/css/vendor/responsive.bootstrap4.css")}}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{url("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{url("assets/css/app-modern.min.css")}}" rel="stylesheet" type="text/css" id="light-style" />
        <link href="{{url("assets/css/app-modern-dark.min.css")}}" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body data-layout="detached" class="loading">

        <!-- Topbar Start -->
        <div class="navbar-custom topnav-navbar topnav-navbar-dark">
            <div class="container-fluid">

                <!-- LOGO -->
                <a href="index.html" class="topnav-logo">
                    <span class="topnav-logo-lg">
                        <img src="https://brasiltelemedicina.com.br/wp-content/uploads/2016/07/brasiltelemedicina.png" alt="" height="50">
                    </span>
                    <span class="topnav-logo-sm">
                        <img src="https://brasiltelemedicina.com.br/wp-content/uploads/2016/07/brasiltelemedicina.png" alt="" height="16">
                    </span>
                </a>

                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link right-bar-toggle" href="javascript: void(0);">
                            <i class="dripicons-gear noti-icon"></i>
                        </a>
                    </li>
                    
            
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop"
                            href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="{{url("assets/images/avatar.svg")}}" alt="user-image" class="rounded-circle">
                            </span>
                            <span>
                                <span class="account-user-name">{{Auth::user()->name}}</span>
                                {{-- <span class="account-position">Founder</span> --}}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                            aria-labelledby="topbar-userdrop">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bem-vindo !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-circle mr-1"></i>
                                <span>Minha conta</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-edit mr-1"></i>
                                <span>Configurações</span>
                            </a>
                            <!-- item-->
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                <i class="mdi mdi-logout"></i>
                                <span>Sair</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </li>

                </ul>
                <a class="button-menu-mobile disable-btn">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                
            </div>
        </div>
        <!-- end Topbar -->
        
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- Begin page -->
            <div class="wrapper">

                <!-- ========== Left Sidebar Start ========== -->
                <div class="left-side-menu left-side-menu-detached">

                    <div class="leftbar-user">
                        <a href="javascript: void(0);">
                            <img src="{{url("assets/images/avatar.svg")}}" alt="user-image" height="42" class="rounded-circle shadow-sm">
                            <span class="leftbar-user-name">{{Auth::user()->name}}</span>
                        </a>
                    </div>

                    <!--- Sidemenu -->
                    <ul class="metismenu side-nav">

                        <li class="side-nav-item">
                            <a href="{{url("dashboard")}}" class="side-nav-link">
                                <i class="uil-calender"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        @if(Auth::user()->type == 0)
                        <li class="side-nav-item">
                            <a href="{{url("attendance")}}" class="side-nav-link">
                                <i class="fas fa-headset"></i>
                                <span> Atendimentos </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{url("doctor")}}" class="side-nav-link">
                                <i class="fas fa-user-md"></i>
                                <span> Médicos </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{url("specialtie")}}" class="side-nav-link">
                                <i class="fas fa-stethoscope"></i>
                                <span> Especialidades </span>
                            </a>
                        </li>

                        {{-- <li class="side-nav-item">
                            <a href="#{{url("billing")}}" class="side-nav-link">
                                <i class="fas fa-dollar-sign"></i>
                                <span> Faturamento </span>
                            </a>
                        </li> --}}
                        @else
                        <li class="side-nav-item">
                            <a href="#{{url("attendance")}}" class="side-nav-link">
                                <i class="uil-calender"></i>
                                <span> Atendimentos </span>
                            </a>
                        </li>
                        
                        @endif
        
                    </ul>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>
                    <!-- Sidebar -left -->

                </div>
                <!-- Left Sidebar End -->

                <div class="content-page">
                    <div class="content">
                        
                        <!-- start page title -->
                        {{-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">                                    
                                    <h4 class="page-title">Dash</h4>
                                </div>
                            </div>
                        </div>      --}}
                        <!-- end page title --> 

                        @yield("content")
                    </div> <!-- End Content -->

                    <!-- Footer Start -->
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    {{date("Y")}} © BrasilTelemedicina - MobiAplicativos.com.br
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-right footer-links d-none d-md-block">
                                        <a target="_blank" href="https://brasiltelemedicina.com.br/">Contato</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- end Footer -->

                </div> <!-- content-page -->

            </div> <!-- end wrapper-->
        </div>
        <!-- END Container -->


        <!-- Right Sidebar -->
        <div class="right-bar">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0">Configurações</h5>
            </div>

            <div class="slimscroll-menu rightbar-content">

                <div class="p-3">

                    <!-- Settings -->
                    <h5 class="mt-3">Modo Layout</h5>
                    <hr class="mt-1" />

                    <div class="custom-control custom-switch mb-1">
                        <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light"
                            id="light-mode-check" checked />
                        <label class="custom-control-label" for="light-mode-check">Modo Claro</label>
                    </div>

                    <div class="custom-control custom-switch mb-1">
                        <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark"
                            id="dark-mode-check" />
                        <label class="custom-control-label" for="dark-mode-check">Modo Escuro</label>
                    </div>

                    <!-- Left Sidebar-->
                    <h5 class="mt-4">Menu</h5>
                    <hr class="mt-1" />

                    <div class="custom-control custom-switch mb-1">
                        <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check"
                            checked />
                        <label class="custom-control-label" for="fixed-check">Expandido</label>
                    </div>

                    <div class="custom-control custom-switch mb-1">
                        <input type="radio" class="custom-control-input" name="compact" value="condensed"
                            id="condensed-check" />
                        <label class="custom-control-label" for="condensed-check">Escondido</label>
                    </div>
                </div> <!-- end padding-->

            </div>
        </div>

        <div class="rightbar-overlay"></div>
        <!-- /Right-bar -->
        
        


        <!-- bundle -->
        <script src="{{url("assets/js/vendor.min.js")}}"></script>
        <script src="{{url("assets/js/app.js")}}"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/soundmanager2/2.97a.20170601/script/soundmanager2-jsmin.js"></script>
        <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
        <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
        {{-- @auth
        <script src="{{ asset('js/enable-push.js') }}" defer></script>
        @endauth --}}
        <!-- Datatables js -->
        <script src="{{url("assets/js/vendor/jquery.dataTables.min.js")}}"></script>
        <script src="{{url("assets/js/vendor/dataTables.bootstrap4.js")}}"></script>
        <script src="{{url("assets/js/vendor/dataTables.responsive.min.js")}}"></script>
        <script src="{{url("assets/js/vendor/responsive.bootstrap4.min.js")}}"></script>

        <!-- Datatable Init js -->
        <script src="{{url("assets/js/pages/demo.datatable-init.js")}}"></script>
        @yield('myscript')
        <script>
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('c0cb12802c8c3a241ed1', {
            cluster: 'us2',
            forceTLS: true
            });

            var channel = pusher.subscribe('alert');
            channel.bind('alert', function(data) {
            // var info = JSON.stringify(data);
            $("#ot_session_id_doctor").val(data.session_id);
            $("#ot_token_doctor").val(data.token_id);
            });
          </script>
          
        <!-- Apex js -->
        {{-- <script src="assets/js/vendor/apexcharts.min.js"></script> --}}

        <!-- Todo js -->
        {{-- <script src="assets/js/ui/component.todo.js"></script> --}}

        <!-- demo app -->
        {{-- <script src="assets/js/pages/demo.dashboard-crm.js"></script> --}}
        <!-- end demo js-->
        
    </body>
</html>

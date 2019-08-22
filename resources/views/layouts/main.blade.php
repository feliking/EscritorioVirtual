<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('title-browser')
    <title>Escritorio Virtual MDRyT</title>
    @show
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{asset('css/lib/normalize.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/themify-icons.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/pe-icon-7-stroke.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/lib/print.min.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/chosen/chosen.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>
</head>

<body class="open">
    <div id="app">
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('/') }}"><i class="menu-icon fa fa-laptop"></i>Inicio </a>
                    </li>
                    @auth
                    <li class="menu-title">Publicaciones</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Administración</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="fa fa-id-card-o"></i><a href="{{ route('notice.main') }}">Últimas Noticias</a></li>
                            <li><i class="fa fa-id-card-o"></i><a href="{{ route('option.main') }}">Opciones</a></li>
                            <li><i class="fa fa-id-card-o"></i><a href="{{ route('item.main') }}">Items</a></li>
                        </ul>
                    </li>
                    @endauth
                    <li class="active">
                        <a href="{{ url('/home') }}"><i class="menu-icon fa fa-sign-in"></i>Iniciar sesión </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    <a class="navbar-brand hidden" href="./"><img src="{{ asset('images/logo2.png') }}" alt="Logo"></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form" method="GET" action="http://www.google.es/search" target="_blank">
                                <input class="form-control mr-sm-2" type="text" name="q" placeholder="Buscar en Google" aria-label="Search">
                                <input style="display: none" type="submit">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                        {{-- <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                                <span class="count bg-danger">3</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="notification">
                                <p class="red">You have 3 Notification</p>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-check"></i>
                                    <p>Server #1 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-info"></i>
                                    <p>Server #2 overloaded.</p>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <i class="fa fa-warning"></i>
                                    <p>Server #3 overloaded.</p>
                                </a>
                            </div>
                        </div> --}}

                        {{-- <div class="dropdown for-message">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-envelope"></i>
                                <span class="count bg-primary">4</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="message">
                                <p class="red">You have 4 Mails</p>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/1.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jonathan Smith</span>
                                        <span class="time float-right">Just now</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/2.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Jack Sanders</span>
                                        <span class="time float-right">5 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/3.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Cheryl Wheeler</span>
                                        <span class="time float-right">10 minutes ago</span>
                                        <p>Hello, this is an example msg</p>
                                    </div>
                                </a>
                                <a class="dropdown-item media" href="#">
                                    <span class="photo media-left"><img alt="avatar" src="images/avatar/4.jpg"></span>
                                    <div class="message media-body">
                                        <span class="name float-left">Rachel Santos</span>
                                        <span class="time float-right">15 minutes ago</span>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                    @auth
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Mi perfil</a>

                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Notificaciones <span class="count">13</span></a>

                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Configuración</a>

                            <a class="nav-link" href="#" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();"><i class="fa fa-power -off"></i>Cerrar sesión</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    @else
                    <div class="dropdown float-right">
                            <img class="user-avatar rounded-circle" src="{{ asset('images/escudo_bolivia.png') }}" alt="User Avatar" width="75px">
                    </div>
                    @endauth
                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                @yield('content')
            </div>
            <!-- .animated -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        Ministerio de Desarrollo Rural y Tierras - 2019
                    </div>
                    <div class="col-sm-6 text-right">
                        La Paz - Bolivia
                    </div>
                </div>
            </div>
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->
</div>
    <!-- Scripts -->
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script>
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        let token = document.head.querySelector('meta[name="csrf-token"]');
        
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    </script>
    
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.matchHeight.min.js') }}"></script>
    <script src="{{ asset('js/lib/toastr.min.js') }}"></script>
    <script src="{{ asset('js/lib/print.min.js') }}"></script>
    
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/lib/chosen/chosen.jquery.min.js') }}"></script>
    @yield('scripts')
</body>
</html>

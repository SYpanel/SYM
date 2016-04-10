<!DOCTYPE html>
<html>

<head>
    <meta name="bob" content="{{csrf_token()}}">
    <title>@yield('title', 'SYpanel') | SYpanel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/bootstrap-switch.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/checkbox3.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/css/sweetalert2.css')}}">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/flat-blue.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>

<body class="flat-blue">
<div class="app-container expanded">
    <div class="row content-container">
        <nav class="navbar navbar-default navbar-fixed-top navbar-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-expand-toggle">
                        <i class="fa fa-bars icon"></i>
                    </button>
                    <ol class="breadcrumb navbar-breadcrumb">
                        @yield('breadcrumbs', '<li class="active">Dashboard</li>')
                    </ol>
                    <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                        <i class="fa fa-th icon"></i>
                    </button>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                        <i class="fa fa-times icon"></i>
                    </button>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-comments-o"></i></a>
                        <ul class="dropdown-menu animated fadeInDown">
                            <li class="title">
                                Notification <span class="badge pull-right">0</span>
                            </li>
                            <li class="message">
                                No new notification
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown danger">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-star-half-o"></i> 4</a>
                        <ul class="dropdown-menu danger  animated fadeInDown">
                            <li class="title">
                                Notification <span class="badge pull-right">4</span>
                            </li>
                            <li>
                                <ul class="list-group notifications">
                                    <a href="#">
                                        <li class="list-group-item">
                                            <span class="badge">1</span> <i class="fa fa-exclamation-circle icon"></i>
                                            new registration
                                        </li>
                                    </a>
                                    <a href="#">
                                        <li class="list-group-item">
                                            <span class="badge success">1</span> <i class="fa fa-check icon"></i> new
                                            orders
                                        </li>
                                    </a>
                                    <a href="#">
                                        <li class="list-group-item">
                                            <span class="badge danger">2</span> <i class="fa fa-comments icon"></i>
                                            customers messages
                                        </li>
                                    </a>
                                    <a href="#">
                                        <li class="list-group-item message">
                                            view all
                                        </li>
                                    </a>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown profile">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{session('user_login')}}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu animated fadeInDown">
                            <li class="profile-img">
                                <img src="{{asset('img/profile/picjumbo.com_HNCK4153_resize.jpg')}}" class="profile-img">
                            </li>
                            <li>
                                <div class="profile-info">
                                    <h4 class="username">Emily Hart</h4>
                                    <p>{{session('user_login')}}</p>
                                    <div class="btn-group margin-bottom-2x" role="group">
                                        <button type="button" class="btn btn-default"><i class="fa fa-user"></i> Profile
                                        </button>
                                        <button type="button" class="btn btn-default">
                                            <a href="{{action('AuthController@logout')}}">
                                                <i class="fa fa-sign-out"></i>
                                                Logout
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="side-menu sidebar-inverse">
            <nav class="navbar navbar-default" role="navigation">
                <div class="side-menu-container">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{action('HomeController@index')}}">
                            <div class="icon fa fa-paper-plane"></div>
                            <div class="title">SYpanel V.0.1</div>
                        </a>
                        <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                    </div>
                    <div id="menu_search">
                        <input type="text" placeholder="Search menu item" class="form-control">
                        <div id="menu_search_results">
                            <ul class="nav navbar-nav">

                            </ul>
                        </div>
                    </div>
                    <ul id="side_menu" class="nav navbar-nav">
                        <li class="">
                            <a href="{{action('HomeController@index')}}">
                                <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="panel panel-default dropdown">
                            <a data-toggle="collapse" href="#dropdown-accounts">
                                <span class="icon fa fa-users"></span><span class="title">Accounts</span>
                            </a>
                            <!-- Dropdown level 1 -->
                            <div id="dropdown-accounts" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li class=""><a href="{{action('AccountsController@index')}}">List Accounts</a></li>
                                        <li><a href="{{action('AccountsController@create')}}">Create New Account</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel panel-default dropdown">
                            <a data-toggle="collapse" href="#dropdown-packages">
                                <span class="icon fa fa-square"></span><span class="title">Packages</span>
                            </a>
                            <!-- Dropdown level 1 -->
                            <div id="dropdown-packages" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="{{action('PackagesController@index')}}">List Packages</a></li>
                                        <li><a href="{{action('PackagesController@create')}}">Create New Package</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel panel-default dropdown">
                            <a data-toggle="collapse" href="#dropdown-backup">
                                <span class="icon fa fa-hdd-o"></span><span class="title">Backup / Restore</span>
                            </a>
                            <!-- Dropdown level 1 -->
                            <div id="dropdown-backup" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="{{action('PackagesController@index')}}">Schedule A Backup</a></li>
                                        <li><a href="{{action('PackagesController@index')}}">Restore</a></li>
                                        <li><a href="{{action('PackagesController@index')}}">Backup Storage</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel panel-default dropdown">
                            <a data-toggle="collapse" href="#dropdown-server">
                                <span class="icon fa fa-server"></span><span class="title">Server</span>
                            </a>
                            <!-- Dropdown level 1 -->
                            <div id="dropdown-server" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="{{action('ServerController@services')}}">Services</a></li>
                                        <li><a href="{{action('ServerController@updates')}}">Updates</a></li>
                                        <li><a href="{{action('PackagesController@create')}}">Reboot / Halt</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a target="_blank" href="{{url('/pma')}}">
                                <span class="icon fa fa-database"></span><span class="title">phpMyAdmin</span>
                            </a>
                        </li>
                        <li>
                            <a href="license.html">
                                <span class="icon fa fa-thumbs-o-up"></span><span class="title">License</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
        </div>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                <div class="page-title">
                    <span class="title">@yield('title')</span>
                    <div class="description">@yield('subtitle')</div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    <footer class="app-footer">
        <div class="wrapper">
            <span class="pull-right">2.1 <a href="#"><i class="fa fa-long-arrow-up"></i></a></span> © 2015 Copyright.
        </div>
    </footer>
    <div>
        <!-- Javascript Libs -->
        <script type="text/javascript" src="{{asset('lib/js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/Chart.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/bootstrap-switch.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/jquery.matchHeight-min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/dataTables.bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/select2.full.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/pGenerator.jquery.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/jquery.complexify.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/sweetalert2.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/ace/ace.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/ace/mode-html.js')}}"></script>
        <script type="text/javascript" src="{{asset('lib/js/ace/theme-github.js')}}"></script>

        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="bob"]').attr('content')
                }
            });
        </script>

        <!-- Javascript -->
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
{{--        <script type="text/javascript" src="{{asset('js/index.js')}}"></script>--}}

        <script type="text/javascript">
            $.expr[":"].contains = $.expr.createPseudo(function(arg) {
                return function( elem ) {
                    return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });

            $('#menu_search input').on('keyup change', function () {
                $('#menu_search_results ul').html('');
                if($('#menu_search input').val() == ''){
                    return;
                }
                $('#side_menu li a:contains(' + this.value + ')').each(function (k,v) {
                    $('#menu_search_results ul').append('<li></li>');
                    $(v).clone().appendTo('#menu_search_results ul li:last-child');
                });
            });
        </script>
        @yield('script')
    </div>
</div>
</body>

</html>

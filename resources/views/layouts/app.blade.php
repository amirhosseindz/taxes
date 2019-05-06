<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="{{ url('/') }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dist/css/font-awesome.min.css') }}">

    <!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="{{ asset('dist/css/ionicons.min.css') }}">

    @yield('required-stylesheets-top')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/flat/blue.css') }}">

    <link type="text/css" href="{{ asset('plugins/data-tables/dataTables.bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/fonts/fonts-fa.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/common-styles.css') }}">

    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var appName = '{{ config('app.name') }}';
    </script>
    @yield('required-scripts-top')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>J</b>T</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Jobleads</b> Taxes</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="dist/img/user2-160x160.jpg" class="auth-avatar user-image" alt="User Image">
                            <span class="hidden-xs">{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu">

                            <!-- User image -->
                            <li class="user-header">
                                <img src="dist/img/user2-160x160.jpg" class="auth-avatar img-circle" alt="User Image">
                                <p>
                                    {{ $user->name }}
                                    <small>{{ $user->email }}</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="profile" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-lefttt">
                                    <a href="{{ url('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                       class="btn btn-default btn-flat">Exit</a>

                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li {{ Request::is('home') ? 'class=active' : '' }}>
                    <a href="./home">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                @include('partials.side-menu')
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       {{--<section class="content-header">
                <h1>
                    Dashboard
                    <small>Admin Panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
        </section>--}}

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-lefttt hidden-xs">
            <b>Version</b> 2.2.0
        </div>
        <strong>Copy Right &copy; 2019 <a href="http://jobleads.com">Jobleads</a>.</strong> All Rights Received.
    </footer>

    <!-- Add the sidebar's background. -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jQueryUI/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.4 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('plugins/moment.min.js') }}"></script>

<script src="{{ asset('dist/js/jquery.livequery.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('dist/js/dynamic-table.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/bloodhound.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/typeahead.jquery.min.js') }}"></script>

<script> var CSRF_TOKEN = '{{ csrf_token() }}'; </script>
<script src="{{ asset('dist/js/common-scripts.js') }}"></script>

@yield('required-scripts-bottom')

<script>
    @yield('inline-javascript')
</script>

@yield('script')

</body>
</html>

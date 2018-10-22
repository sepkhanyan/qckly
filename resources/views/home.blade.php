<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @isset($title)
            {{ $title }} |
        @endisset Administrator Panel | {{ config('app.name') }}
    </title>
    <link rel="icon" href="{{ asset('admin/favicon.ico') }}"/>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


    <script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-sortable.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.raty.js') }}"></script>
    <script src="{{ asset('js/datepicker/timepicki.js') }}"></script>
    <script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/datepicker/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('js/js.cookie.js')}}"></script>
    <script src="{{ asset('js/qckly.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.raty.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('js/datepicker/datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('js/datepicker/bootstrap-timepicker.css') }}" rel="stylesheet">
    <script>
        var js_site_url = function (str) {
            var strTmp = "{{url('/')}}" + str;
            return strTmp;
        };

        var js_base_url = function (str) {
            var strTmp = "{{url('/')}}" + str;
            return strTmp;
        };

        var active_menu = 'menus';
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('a[title], span[title], button[title]').tooltip({placement: 'bottom'});
            $('select.form-control').select2({minimumResultsForSearch: 10});

            $('.alert').alert();
            $('.dropdown-toggle').dropdown();

            $("#list-form td:contains('Disabled')").addClass('red');
        });
    </script>
    <style>
        #map {
            /*height: 100%;*/
            /*margin-left: 30em;*/
            border: 2px solid black;
            margin-top: 1em;
            height: 500px;
            width: 650px;
        }
        /* Optional: Makes the sample page fill the window. */
        /*html, body {*/
            /*height: 100%;*/
            /*margin: 0;*/
            /*padding: 0;*/
        /*}*/
        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        /*#lat {*/
            /*margin-left: 1em;*/
            /*margin-top: 2em;*/
            /*height: 25px;*/
            /*width: 150px;*/
            /*font-size: 13px;*/
            /*padding: 0;*/
            /*padding-left: 0.5em;*/
            /*border: 3px solid #cccccc;*/
            /*border-radius: 5px;*/

        /*}*/

        /*#long {*/
            /*margin-top: 2em;*/
            /*height: 25px;*/
            /*width: 150px;*/
            /*font-size: 13px;*/
            /*padding: 0;*/
            /*padding-left: 0.5em;*/
            /*border: 3px solid #cccccc;*/
            /*border-radius: 5px;*/
        /*}*/
    </style>
    <style>
        /* The container */
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom checkbox */
        .checkmark {
            border: solid 1px;
            border-radius: 5px;
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .checked {
            color: orange;
        }
    </style>
    <style>
        article, aside, figure, footer, header, hgroup,
        menu, nav, section {
            display: block;
        }
    </style>
</head>
<body>
<div id="wrapper" class="">
    <nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom:0 ">
        <div class="navbar-header ">
            <div class="navbar-brand">
                <div class="navbar-logo col-xs-3">
                    {{--<img class="logo-image" alt="Qckly" title="Qckly"--}}
                    {{--src="{{url('/') . '/admin/qckly_logo.png'}}"/>--}}
                </div>
                <div class="navbar-logo col-xs-9">
                    <img class="logo-image" alt="Qckly" title="Qckly"
                         src="{{url('/') . '/admin/qckly_logo.png'}}"/>
                </div>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="icon-bar"></span>
        </div>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa fa-dashboard fa-fw"></i>
                            <span class="content">Dashboard</span>
                        </a>
                    </li>
                    @if(Auth::user()->admin == 1)
                        <li>
                            <a class="area">
                                <i class="fa fa-map-marker fa-fw"></i>
                                <span class="content ">Areas</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="{{ url('/areas') }}" class=menus"">
                                        <i class="fa fa-square-o fa-fw "></i>
                                        Areas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="restaurant">
                                <i class="fa fa-glass fa-fw"></i>
                                <span class="content">Restaurants</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="{{ url('/restaurants') }}" class="locations">
                                        <i class="fa fa-square-o fa-fw"></i>
                                        Restaurants
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/restaurant_categories') }}" class="locations">
                                        <i class="fa fa-square-o fa-fw"></i>
                                        Categories
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a class="kitchen">
                            <i class="fa fa-cutlery fa-fw"></i>
                            <span class="content ">Kitchen</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{url('/mealtimes')}}" class=menus"">
                                    <i class="fa fa-square-o fa-fw "></i>
                                    Mealtimes
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/menus')}}" class=menus"">
                                    <i class="fa fa-square-o fa-fw "></i>
                                    Menus
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/collections')}}" class="menu_collections">
                                    <i class="fa fa-square-o fa-fw "></i>
                                    Collections
                                </a>
                            </li>
                            {{--<li>--}}
                            {{--<a href="#" class="menu_options">--}}
                            {{--<i class="fa fa-square-o fa-fw"></i>--}}
                            {{--Options--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="{{ url('/menu_categories') }}" class="menu-categories">
                                    <i class="fa fa-square-o fa-fw"></i>
                                    Menu Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/collection_categories') }}" class="collection-categories">
                                    <i class="fa fa-square-o fa-fw"></i>
                                    Collection Categories
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="sales">
                            <i class="fa fa-bar-chart-o fa-fw"></i>
                            <span class="content">Sales</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{ url('/orders') }}" class="orders">
                                    <i class="fa fa-square-o fa-fw"></i>
                                    Orders
                                </a>
                            </li>
                            {{--<li>--}}
                            {{--<a href="#" class="reservations">--}}
                            {{--<i class="fa fa-square-o fa-fw"></i>--}}
                            {{--Reservations--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="#" class="coupons">--}}
                            {{--<i class="fa fa-square-o fa-fw"></i>--}}
                            {{--Coupons--}}
                            {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                    </li>
                    <li>
                        <a class="marketing">
                            <i class="fa fa-line-chart fa-fw"></i>
                            <span class="content">Marketing</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{url('/reviews')}}" class="reviews">
                                    <i class="fa fa-square-o fa-fw"></i>
                                    Reviews
                                </a>
                            </li>
                            {{--<li>--}}
                            {{--<a href="#" class="messages">--}}
                            {{--<i class="fa fa-square-o fa-fw"></i>--}}
                            {{--Messages--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="#" class="banners">--}}
                            {{--<i class="fa fa-square-o fa-fw"></i>--}}
                            {{--Banners--}}
                            {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                    </li>
                    @if(Auth::user()->admin == 1)
                        <li>
                            <a class="users">
                                <i class="fa fa-users fa-fw"></i>
                                <span class="content">Users</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="{{ url('/customers') }}" class="customers">
                                        <i class="fa fa-square-o fa-fw"></i>
                                        Customers
                                    </a>
                                </li>
                                {{--<li>--}}
                                {{--<a href="#" class="customer_groups">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Customer Groups--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                {{--<a href="#" class="activities">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Activities--}}
                                {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                        {{--<li>--}}
                        {{--<a href="#" class="extensions">--}}
                        {{--<i class="fa fa-puzzle-piece fa-fw"></i>--}}
                        {{--<span class="content">Extensions</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a class="design">--}}
                        {{--<i class="fa fa-paint-brush fa-fw"></i>--}}
                        {{--<span class="content">Design</span>--}}
                        {{--<span class="fa arrow"></span>--}}
                        {{--</a>--}}
                        {{--<ul class="nav nav-second-level collapse">--}}
                        {{--<li>--}}
                        {{--<a href="#" class="pages">--}}
                        {{--<i class="fa fa-square-o fa-fw"></i>--}}
                        {{--Pages--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#" class="layouts">--}}
                        {{--<i class="fa fa-square-o fa-fw"></i>--}}
                        {{--Layouts--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#" class="mail_templates">--}}
                        {{--<i class="fa fa-square-o fa-fw"></i>--}}
                        {{--Mail Templates--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--</li>--}}
                        <li>
                            <a class="locations">
                                <i class="fa fa-globe fa-fw"></i>
                                <span class="content">Localisation</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="{{url('/languages')}}" class="languages">
                                        <i class="fa fa-square-o fa-fw"></i>
                                        Languages
                                    </a>
                                </li>
                                {{--<li>--}}
                                {{--<a href="#" class="currencies">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Currencies--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                {{--<a href="#" class="countries">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Countries--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                {{--<a href="#" class="security_questions">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Security Questions--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                {{--<a href="#" class="ratings">--}}
                                {{--<i class="fa fa-square-o fa-fw"></i>--}}
                                {{--Ratings--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                @if(Auth::user()->admin == 1)
                                    <li>
                                        <a href="{{ url('/statuses') }}" class="statuses">
                                            <i class="fa fa-square-o fa-fw"></i>
                                            Statuses
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{--<li>--}}
                    {{--<a class="system">--}}
                    {{--<i class="fa fa-cog fa-fw"></i>--}}
                    {{--<span class="content">System</span>--}}
                    {{--<span class="fa arrow"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-second-level collapse">--}}
                    {{--<li>--}}
                    {{--<a href="#" class="settings">--}}
                    {{--<i class="fa fa-square-o fa-fw"></i>--}}
                    {{--Settings--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="#" class="permissions">--}}
                    {{--<i class="fa fa-square-o fa-fw"></i>--}}
                    {{--Permissions--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a class="tools">--}}
                    {{--<i class="fa fa-square-o fa-fw"></i>--}}
                    {{--Tools--}}
                    {{--<span class="fa arrow"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-third-level collapse">--}}
                    {{--<li>--}}
                    {{--<a href="#" class="image_manager">--}}
                    {{--<i class="fa fa-square-o fa-fw"></i>--}}
                    {{--Image Manager--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                    <li>
                        <a class="hidden-xs sidebar-toggle">
                            <i class="fa fa-chevron-circle-left fa-fw"></i>
                            <span class="content">Collapse Menu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle alerts" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                </a>
                <ul class="dropdown-menu dropdown-activities">
                    <li class="menu-header">Recent activities</li>
                    <li class="menu-body">
                        <ul class="menu activities-list">
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body">
                                        <i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <span class="activity-time text-muted small">
                                            <span class="small"></span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body">
                                        <i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <span class="activity-time text-muted small">
                                            <span class="small"></span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="activity-body">
                                    <i class="fa fa-tasks fa-fw bg-primary"></i>
                                    <a>
                                        <b></b>
                                    </a>
                                    <span class="activity-time text-muted small">
                                        <span class="small"></span>
                                    </span>
                                </div>
                            </li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                    <li class="menu-footer">
                        <a class="text-center">See all activities</a>
                    </li>
                </ul>
            </li>
            {{--<li class="dropdown">--}}
            {{--<a class="dropdown-toggle settings" data-toggle="dropdown">--}}
            {{--<i class="fa fa-cog"></i>--}}
            {{--</a>--}}
            {{--<ul class="dropdown-menu dropdown-settings">--}}
            {{--<li><a>Pages</a></li>--}}
            {{--<li><a >Banners</a></li>--}}
            {{--<li><a>Layouts</a></li>--}}
            {{--<li><a >Error Logs</a></li>--}}
            {{--<li><a >Settings</a></li>--}}
            {{--<li class="menu-footer"></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                </a>
                <ul class="dropdown-menu  dropdown-user">
                    <li>
                        <div class="row wrap-vertical text-center">
                            <div class="col-xs-12 wrap-top">
                                @if(isset(Auth::user()->image))
                                    <img src="/images/{{Auth::user()->image}}" width="30px" height="30px">
                                @endif
                            </div>
                            <div class="col-xs-12 wrap-none wrap-top wrap-right">
                                <span>
                                    <strong>{{Auth::user()->first_name}}</strong>
                                </span>
                                <br>
                                <span>
                                    <i>{{Auth::user()->username}}</i>
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{url('/admin/edit/' . Auth::user()->id)}}">
                            <i class="fa fa-user fa-fw"></i>
                            &nbsp;&nbsp;Edit Details
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <br>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    @yield('content')
    <div id="footer" class="">
        <div class="row navbar-footer">
            <div class="col-sm-12 text-version">
                <p class="col-xs-9 wrap-none">Thank you for using Qckly</p>
                <p class="col-xs-3 text-right wrap-none"></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function filterList() {
        $('#filter-form').submit();
    }

    $(document).ready(function () {
        if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
            $('#side-menu .' + active_menu).addClass('active');
            $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
            $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
            $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
        }

        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
            $('#nav-tabs a[href="#' + hash + '"]').tab('show');
        }

        $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
    });

    function confirmDelete(form) {
        if ($('input[name="delete[]"]:checked').length && confirm('This cannot be undone! Are you sure you want to do this?')) {
            form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
            $('#' + form).submit();
        } else {
            return false;
        }
    }

    function saveClose() {
        $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
        $('#edit-form').submit();
    }
</script>
{{--<script>--}}
    {{--// Initialize and add the map--}}
    {{--function initMap() {--}}
        {{--// The location of Uluru--}}
        {{--var uluru = {lat: -25.344, lng: 131.036};--}}
        {{--// The map, centered at Uluru--}}
        {{--var map = new google.maps.Map(--}}
            {{--document.getElementById('map'), {zoom: 4, center: uluru});--}}
        {{--// The marker, positioned at Uluru--}}
        {{--var marker = new google.maps.Marker({position: uluru, map: map});--}}
    {{--}--}}
{{--</script>--}}
{{--<!--Load the API from the specified URL--}}
{{--* The async attribute allows the browser to render the page while the API loads--}}
{{--* The key parameter will contain your own API key (which is not needed for this tutorial)--}}
{{--* The callback parameter executes the initMap() function--}}
{{---->--}}
{{--<script async defer--}}
        {{--src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8kDz25qFYhy1UYiPyrzvcOpkiwZz9C4o&callback=initMap">--}}
{{--</script>--}}
</body>
</html>



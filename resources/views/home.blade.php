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
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
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
    {{--<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.raty.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">
    <link href="{{ asset('js/datepicker/datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('js/datepicker/bootstrap-timepicker.css') }}" rel="stylesheet">


    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--$('a[title], span[title], button[title]').tooltip({placement: 'bottom'});--}}
            {{--$('select.form-control').select2({minimumResultsForSearch: 10});--}}

            {{--$('.alert').alert();--}}
            {{--$('.dropdown-toggle').dropdown();--}}

            {{--// $("#list-form td:contains('Disabled')").addClass('red');--}}
        {{--});--}}
    {{--</script>--}}

    {{--<script src="https://js.pusher.com/4.3/pusher.min.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>--}}
    {{--<script>--}}

        {{--// Enable pusher logging - don't include this in production--}}
        {{--Pusher.logToConsole = true;--}}

        {{--var pusher = new Pusher('6dba162777e691fc6a70', {--}}
            {{--cluster: 'eu',--}}
            {{--forceTLS: true--}}
        {{--});--}}

        {{--var channel = pusher.subscribe('messages');--}}
        {{--channel.bind('.newMessage', function(data) {--}}
            {{--alert(JSON.stringify(data));--}}
        {{--});--}}

    {{--</script>--}}
    <style>
        #map {
            border: 2px solid black;
            margin-top: 1em;
            height: 500px;
            width: 650px;
        }

        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
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

        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

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

        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container input:checked ~ .checkmark:after {
            display: block;
        }

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
    {{--<script src="https://js.pusher.com/4.3/pusher.min.js"></script>--}}
    {{--<script>--}}

        {{--Echo.channel('messages.' + self.user_id)--}}
            {{--.listen('NewMessage', (e) => {--}}
                {{--console.log(e);--}}
            {{--});--}}
    {{--</script>--}}
</head>
<body>
<div id="wrapper" class="">
    <nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom:0 ">
        <div class="navbar-header ">
            <div class="navbar-brand">
                <div class="navbar-logo col-xs-1">
                </div>
                <div class="navbar-logo col-xs-7">
                    <img class="logo-text" alt="Qckly" title="Qckly"
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
                    @if(auth()->user()->admin == 1)
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
                            @if(auth()->user()->admin == 2)
                                @if(auth()->user()->restaurant->orderRestaurant->where('status_id', 1)->count() > 0)
                                    <span class="badge">{{auth()->user()->restaurant->orderRestaurant->where('status_id', 1)->count()}}</span>
                                @endif
                            @endif
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="{{ url('/orders') }}" class="orders">
                                    <i class="fa fa-square-o fa-fw"></i>
                                    Orders
                                    @if(auth()->user()->admin == 2)
                                        @if(auth()->user()->restaurant->orderRestaurant->where('status_id', 1)->count() > 0)
                                            <span class="badge">{{auth()->user()->restaurant->orderRestaurant->where('status_id', 1)->count()}}</span>
                                        @endif
                                    @endif
                                </a>
                            </li>
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
                        </ul>
                    </li>
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
                        </ul>
                    </li>
                    @if(auth()->user()->admin == 1)
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
                                <li>
                                    <a href="{{ url('/statuses') }}" class="statuses">
                                        <i class="fa fa-square-o fa-fw"></i>
                                        Statuses
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
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
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                </a>
                <ul class="dropdown-menu  dropdown-user">
                    <li>
                        <div class="row wrap-vertical text-center">
                            <div class="col-xs-12 wrap-top">
                                @if(isset(auth()->user()->image))
                                    <img src="/images/{{auth()->user()->image}}" width="30px" height="30px">
                                @endif
                            </div>
                            <div class="col-xs-12 wrap-none wrap-top wrap-right">
                                <span>
                                    <strong>{{auth()->user()->first_name}}</strong>
                                </span>
                                <br>
                                <span>
                                    <i>{{auth()->user()->username}}</i>
                                </span>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{url('/admin/edit/' . auth()->user()->id)}}">
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
        <h1 class="navbar-heading">
            @isset($title)
                @php
                    $s = ':';
                    $pos = strpos($title,$s);
                @endphp
                @if($pos === false)
                    {{$title}}
                @else
                    @php($title = explode(':', $title))
                    {{$title[0]}}&nbsp;&nbsp;
                    <small>{{$title[1]}}</small>
                @endif
            @endisset
        </h1>
    </nav>
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Dashboard</div>--}}

                    {{--<div class="panel-body">--}}
                        {{--<example></example>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
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
<script type="text/javascript"><!--
    $(document).ready(function () {
        $('.timepicker').timepicker({
            // defaultTime: '11:45 AM'
        });

        $('input[name="auto_lat_lng"]').on('change', function () {
            $('#lat-lng').slideDown('fast');

            if (this.value == '1') {
                $('#lat-lng').slideUp('fast');
            }
        });


        $('input[name="opening_type"]').on('change', function () {
            if (this.value == '24_7') {
                $('#opening-daily').slideUp('fast');
                $('#opening-flexible').slideUp('fast');
            }

            if (this.value == 'daily') {
                $('#opening-flexible').slideUp('fast');
                $('#opening-daily').slideDown('fast');
            }

            if (this.value == 'flexible') {
                $('#opening-daily').slideUp('fast');
                $('#opening-flexible').slideDown('fast');
            }
        });


        $('input[name="is_available"]').on('change', function () {
            if (this.value == '1') {
                $('#unavailability_hours').slideUp();
            }
            if (this.value == '0') {
                $('#unavailability_hours').slideDown();
            }
        });
        $('input[name="type"]').on('change', function () {
            if (this.value == '24_7') {
                $('#daily').slideUp('fast');
                $('#flexible').slideUp('fast');
            }

            if (this.value == 'daily') {
                $('#flexible').slideUp('fast');
                $('#daily').slideDown('fast');
            }

            if (this.value == 'flexible') {
                $('#daily').slideUp('fast');
                $('#flexible').slideDown('fast');
            }
        });

    });
    //--></script>
<script type="text/javascript">
    $(document).ready(function () {

        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
            $('#nav-tabs a[href="#' + hash + '"]').tab('show');
        }

        $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
    });

    function saveClose() {
        $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
        $('#edit-form').submit();
    }
</script>
<script type="text/javascript"><!--
    function filterList() {
        $('#filter-form').submit();
    }
    //--></script>
</body>
</html>



@extends('home')
@section('content')
    <div class="page-header clearfix">

    </div>
    <div class="row content">
        <div class="col-md-12">
            <div id="image-manager" style="padding: 3px 0px 0px 0px;">
                <iframe src="https://demo.tastyigniter.com/admin/image_manager?popup=iframe" width="100%" height="550" frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endsection
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/images/favicon.ico" rel="shortcut icon" type="image/ico">
    <title>Media Manager ‹ Administrator Panel ‹ TastyIgniter Demo — TastyIgniter</title>
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/bootstrap.min.css?ver=2.1.1" rel="stylesheet" type="text/css" id="bootstrap-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/font-awesome.min.css?ver=2.1.1" rel="stylesheet" type="text/css" id="font-awesome-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/metisMenu.min.css?ver=2.1.1" rel="stylesheet" type="text/css" id="metis-menu-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/select2.css?ver=2.1.1" rel="stylesheet" type="text/css" id="select2-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/select2-bootstrap.css?ver=2.1.1" rel="stylesheet" type="text/css" id="select2-bootstrap-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/jquery.raty.css?ver=2.1.1" rel="stylesheet" type="text/css" id="jquery-raty-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/fonts.css?ver=2.1.1" rel="stylesheet" type="text/css" id="fonts-css">
    <link href="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/css/stylesheet.css?ver=2.1.1" rel="stylesheet" type="text/css" id="stylesheet-css">
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/jquery-1.11.2.min.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="jquery-js"></script>
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/bootstrap.min.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="bootstrap-js"></script>
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/metisMenu.min.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="metis-menu-js"></script>
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/select2.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="select-2-js"></script>
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/jquery.raty.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="jquery-raty-js"></script>
    <script src="https://demo.tastyigniter.com/assets/js/js.cookie.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="js-cookie-js"></script>
    <script src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/js/common.js?ver=2.1.1" charset="utf-8" type="text/javascript" id="common-js"></script>	<script type="text/javascript">
        var js_site_url = function(str) {
            var strTmp = "https://demo.tastyigniter.com/admin/" + str;
            return strTmp;
        };

        var js_base_url = function(str) {
            var strTmp = "https://demo.tastyigniter.com/admin/" + str;
            return strTmp;
        };

        var active_menu = 'image_manager';
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('a[title], span[title], button[title]').tooltip({placement: 'bottom'});
            $('select.form-control').select2({minimumResultsForSearch: 10});

            $('.alert').alert();
            $('.dropdown-toggle').dropdown();

            $("#list-form td:contains('Disabled')").addClass('red');
        });
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper" class="">
    <nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <div class="navbar-brand">
                <div class="navbar-logo col-xs-3">
                    <img class="logo-image" alt="TastyIgniter" title="TastyIgniter" src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/images/tastyigniter-logo.png">
                </div>
                <div class="navbar-logo col-xs-9">
                    <img class="logo-text" alt="TastyIgniter" title="TastyIgniter" src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/images/tastyigniter-logo-text.png">
                    <!--						<a class="logo-text" href="--><!--">--><!--</a>-->
                </div>
            </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu"><li><a class="dashboard admin" href="https://demo.tastyigniter.com/admin/dashboard"><i class="fa fa-dashboard fa-fw"></i><span class="content">Dashboard</span></a></li><li><a class="kitchen"><i class="fa fa-cutlery fa-fw"></i><span class="content">Kitchen</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="menus" href="https://demo.tastyigniter.com/admin/menus"><i class="fa fa-square-o fa-fw"></i>Menus</a></li><li><a class="menu_options" href="https://demo.tastyigniter.com/admin/menu_options"><i class="fa fa-square-o fa-fw"></i>Options</a></li><li><a class="categories" href="https://demo.tastyigniter.com/admin/categories"><i class="fa fa-square-o fa-fw"></i>Categories</a></li></ul></li><li><a class="sales"><i class="fa fa-bar-chart-o fa-fw"></i><span class="content">Sales</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="orders" href="https://demo.tastyigniter.com/admin/orders"><i class="fa fa-square-o fa-fw"></i>Orders</a></li><li><a class="reservations" href="https://demo.tastyigniter.com/admin/reservations"><i class="fa fa-square-o fa-fw"></i>Reservations</a></li><li><a class="coupons" href="https://demo.tastyigniter.com/admin/coupons"><i class="fa fa-square-o fa-fw"></i>Coupons</a></li></ul></li><li><a class="marketing"><i class="fa fa-line-chart fa-fw"></i><span class="content">Marketing</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="reviews" href="https://demo.tastyigniter.com/admin/reviews"><i class="fa fa-square-o fa-fw"></i>Reviews</a></li><li><a class="messages" href="https://demo.tastyigniter.com/admin/messages"><i class="fa fa-square-o fa-fw"></i>Messages</a></li><li><a class="banners" href="https://demo.tastyigniter.com/admin/banners"><i class="fa fa-square-o fa-fw"></i>Banners</a></li></ul></li><li><a class="restaurant"><i class="fa fa-map-marker fa-fw"></i><span class="content">Restaurant</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="locations" href="https://demo.tastyigniter.com/admin/locations"><i class="fa fa-square-o fa-fw"></i>Locations</a></li><li><a class="tables" href="https://demo.tastyigniter.com/admin/tables"><i class="fa fa-square-o fa-fw"></i>Tables</a></li></ul></li><li><a class="users"><i class="fa fa-user fa-fw"></i><span class="content">Users</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="customers" href="https://demo.tastyigniter.com/admin/customers"><i class="fa fa-square-o fa-fw"></i>Customers</a></li><li><a class="customer_groups" href="https://demo.tastyigniter.com/admin/customer_groups"><i class="fa fa-square-o fa-fw"></i>Customer Groups</a></li><li><a class="activities" href="https://demo.tastyigniter.com/admin/activities"><i class="fa fa-square-o fa-fw"></i>Activities</a></li></ul></li><li><a class="extensions" href="https://demo.tastyigniter.com/admin/extensions"><i class="fa fa-puzzle-piece fa-fw"></i><span class="content">Extensions</span></a></li><li><a class="design"><i class="fa fa-paint-brush fa-fw"></i><span class="content">Design</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="pages" href="https://demo.tastyigniter.com/admin/pages"><i class="fa fa-square-o fa-fw"></i>Pages</a></li><li><a class="layouts" href="https://demo.tastyigniter.com/admin/layouts"><i class="fa fa-square-o fa-fw"></i>Layouts</a></li><li><a class="mail_templates" href="https://demo.tastyigniter.com/admin/mail_templates"><i class="fa fa-square-o fa-fw"></i>Mail Templates</a></li></ul></li><li><a class="localisation"><i class="fa fa-globe fa-fw"></i><span class="content">Localisation</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse"><li><a class="languages" href="https://demo.tastyigniter.com/admin/languages"><i class="fa fa-square-o fa-fw"></i>Languages</a></li><li><a class="currencies" href="https://demo.tastyigniter.com/admin/currencies"><i class="fa fa-square-o fa-fw"></i>Currencies</a></li><li><a class="countries" href="https://demo.tastyigniter.com/admin/countries"><i class="fa fa-square-o fa-fw"></i>Countries</a></li><li><a class="security_questions" href="https://demo.tastyigniter.com/admin/security_questions"><i class="fa fa-square-o fa-fw"></i>Security Questions</a></li><li><a class="ratings" href="https://demo.tastyigniter.com/admin/ratings"><i class="fa fa-square-o fa-fw"></i>Ratings</a></li><li><a class="statuses" href="https://demo.tastyigniter.com/admin/statuses"><i class="fa fa-square-o fa-fw"></i>Statuses</a></li></ul></li><li class="active"><a class="system"><i class="fa fa-cog fa-fw"></i><span class="content">System</span><span class="fa arrow"></span></a><ul class="nav nav-second-level collapse in" aria-expanded="true" style=""><li><a class="settings" href="https://demo.tastyigniter.com/admin/settings"><i class="fa fa-square-o fa-fw"></i>Settings</a></li><li><a class="permissions" href="https://demo.tastyigniter.com/admin/permissions"><i class="fa fa-square-o fa-fw"></i>Permissions</a></li><li class="active"><a class="tools"><i class="fa fa-square-o fa-fw"></i>Tools<span class="fa arrow"></span></a><ul class="nav nav-third-level collapse in" aria-expanded="true" style=""><li><a class="image_manager active" href="https://demo.tastyigniter.com/admin/image_manager"><i class="fa fa-square-o fa-fw"></i>Image Manager</a></li></ul></li></ul></li><li><a class="hidden-xs sidebar-toggle"><i class="fa fa-chevron-circle-left fa-fw"></i><span class="content">Collapse Menu</span></a></li></ul>					</div>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="front-end" title="" href="https://demo.tastyigniter.com/" target="_blank" data-original-title="Storefront">
                    <i class="fa fa-home"></i>
                </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle messages" data-toggle="dropdown">
                    <i class="fa fa-envelope"></i>
                    <span class="label label-danger"></span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li class="menu-header">You have  messages</li>
                    <li class="menu-body"><ul class="menu message-list">
                            <li>There are no messages available in this folder.</li>
                            <li class="divider"></li>
                        </ul></li>
                    <li class="menu-footer">
                        <a class="text-center" href="https://demo.tastyigniter.com/admin/messages">See all messages</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle alerts" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                </a>
                <ul class="dropdown-menu dropdown-activities">
                    <li class="menu-header">Recent activities</li>
                    <li class="menu-body"><ul class="menu activities-list">
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">09:06 AM&nbsp;-&nbsp;5 minutes ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        Demo Adminm <b>updated</b> order <a href="https://demo.tastyigniter.com/admin/orders/edit?id=21091"><b>#21091.</b></a>                        <span class="activity-time text-muted small">
                            <span class="small">07:07 AM&nbsp;-&nbsp;2 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">07:05 AM&nbsp;-&nbsp;2 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">06:58 AM&nbsp;-&nbsp;2 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">06:23 AM&nbsp;-&nbsp;2 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">02:51 AM&nbsp;-&nbsp;6 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">01:11 AM&nbsp;-&nbsp;8 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">08:43 PM&nbsp;-&nbsp;12 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">08:27 PM&nbsp;-&nbsp;12 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li class="unread">
                                <div class="clearfix">
                                    <div class="activity-body"><i class="fa fa-tasks fa-fw bg-primary"></i>
                                        <a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12">Demo Adminm</a> <b>logged</b> in.                        <span class="activity-time text-muted small">
                            <span class="small">07:50 PM&nbsp;-&nbsp;13 hours ago</span>
                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                        </ul>
                    </li>
                    <li class="menu-footer">
                        <a class="text-center" href="https://demo.tastyigniter.com/admin/activities">See all activities</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle settings" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu dropdown-settings">
                    <li><a href="https://demo.tastyigniter.com/admin/pages">Pages</a></li>
                    <li><a href="https://demo.tastyigniter.com/admin/banners">Banners</a></li>
                    <li><a href="https://demo.tastyigniter.com/admin/layouts">Layouts</a></li>
                    <!--							<li><a href="--><!--">--><!--</a></li>-->
                    <li><a href="https://demo.tastyigniter.com/admin/error_logs">Error Logs</a></li>
                    <li><a href="https://demo.tastyigniter.com/admin/settings">Settings</a></li>
                    <li class="menu-footer"></li>
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
                                <img class="img-rounded" src="https://www.gravatar.com/avatar/7c4ff521986b4ff8d29440beec01972d.png?s=48&amp;d=mm">
                            </div>
                            <div class="col-xs-12 wrap-none wrap-top wrap-right">
                                <span><strong>Demo Adminm</strong></span>
                                <span class="small"><i>(demo)</i></span><br>
                                <span class="small text-uppercase">Demo</span>
                                <span></span>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li><a href="https://demo.tastyigniter.com/admin/staffs/edit?id=12"><i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;Edit Details</a></li>
                    <li><a class="list-group-item-danger" href="https://demo.tastyigniter.com/admin/logout"><i class="fa fa-power-off fa-fw"></i>&nbsp;&nbsp;Logout</a></li>
                    <li class="divider"></li>
                    <li><a href="http://tastyigniter.com/about/" target="_blank"><i class="fa fa-info-circle fa-fw"></i>&nbsp;&nbsp;About TastyIgniter</a></li>
                    <li><a href="http://docs.tastyigniter.com" target="_blank"><i class="fa fa-book fa-fw"></i>&nbsp;&nbsp;Documentation</a></li>
                    <li><a href="http://forum.tastyigniter.com" target="_blank"><i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;Community Support</a></li>
                    <li class="menu-footer"></li>
                </ul>
            </li>
        </ul>

        <h1 class="navbar-heading">
            Media Manager
        </h1>
    </nav>

    <div id="page-wrapper" style="min-height: 261px; height: 100%;">
        <div class="page-header clearfix">

        </div>


        <div id="notification">
        </div>

        <div class="row content">
            <div class="col-md-12">
                <div id="image-manager" style="padding: 3px 0px 0px 0px;">
                    <iframe src="https://demo.tastyigniter.com/admin/image_manager?popup=iframe" width="100%" height="550" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div id="footer" class="">
        <div class="row navbar-footer">
            <div class="col-sm-12 text-version">
                <p class="col-xs-9 wrap-none">Thank you for using <a target="_blank" href="http://tastyigniter.com">TastyIgniter</a></p>
                <p class="col-xs-3 text-right wrap-none">Version 2.1.1</p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
            $('#side-menu .' + active_menu).addClass('active');
            $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
            $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
            $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
        }

        if (window.location.hash) {
            var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
            $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
            $('#nav-tabs a[href="#'+hash+'"]').tab('show');
        }

        $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
    });

    function confirmDelete(form) {
        if ($('input[name="delete[]"]:checked').length && confirm('This cannot be undone! Are you sure you want to do this?')) {
            form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
            $('#'+form).submit();
        } else {
            return false;
        }
    }

    function saveClose() {
        $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
        $('#edit-form').submit();
    }
</script>

</body></html>
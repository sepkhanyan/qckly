<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Header</title>


		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

		<script src="{{ asset('js/jquery-1.11.2.min.js') }}" ></script>
		<script src="{{ asset('js/jquery.js') }}" ></script>
		<script src="{{ asset('js/jquery-sortable.js') }}" ></script>
		<script src="{{ asset('js/jquery-ui.js') }}" ></script>
		<script src="{{ asset('js/jquery.raty.js') }}" ></script>
		<script src="{{ asset('js/datepicker/timepicki.js') }}" ></script>
		<script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}" ></script>
		<script src="{{ asset('js/datepicker/bootstrap-timepicker.js') }}" ></script>
		<script src="{{ asset('js/js.cookie.js')}}" ></script>
		<script src="{{ asset('js/qckly.js') }}" ></script>
		<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
		<script src="{{ asset('js/metisMenu.min.js') }}" ></script>
		<script src="{{ asset('js/select2.js') }}" ></script>
		<script src="{{ asset('js/common.js') }}" ></script>




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
		{{--<script>
		var js_site_url = function(str) {
		var strTmp = "qckly.loc/" + str;
		return strTmp;
		};

		var js_base_url = function(str) {
		var strTmp = "qckly.loc/" + str;
		return strTmp;
		};

		var active_menu = 'menus';
        </script>--}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('a[title], span[title], button[title]').tooltip({placement: 'bottom'});
                $('select.form-control').select2({minimumResultsForSearch: 10});

                $('.alert').alert();
                $('.dropdown-toggle').dropdown();

                $("#list-form td:contains('Disabled')").addClass('red');
            });
		</script>
</head>
<body>
    <div id="wrapper" class="">
		<nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<div class="navbar-brand">
					<div class="navbar-logo col-xs-3">
						<img class="logo-image" alt="TastyIgniter" title="TastyIgniter" src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/images/tastyigniter-logo.png"/>
					</div>
					<div class="navbar-logo col-xs-9">
						<img class="logo-text" alt="TastyIgniter" title="TastyIgniter" src="https://demo.tastyigniter.com/admin/views/themes/tastyigniter-blue/images/tastyigniter-logo-text.png"/>
						<!--						<a class="logo-text" href="--><!--">--><!--</a>-->
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
									<a class="dashboard admin active" href="#">
									<i class="fa fa-dashboard fa-fw"></i>
									<span class="content">Dashboard</span>
									</a>
								</li>
								<li>
									<a class="kitchen">
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
									<a class="kitchen">
										<i class="fa fa-cutlery fa-fw"></i>
										<span class="content ">Kitchen</span>
										<span class="fa arrow"></span>
									</a>
									<ul class="nav nav-second-level collapse">
										<li>
											<a href="{{url('/menus')}}" class=menus"">
												<i class="fa fa-square-o fa-fw "></i>
												Menus
											</a>
										</li>
										<li>
											<a href="{{url('/collections')}}" class=menu_collections"">
												<i class="fa fa-square-o fa-fw "></i>
												Collections
											</a>
										</li>
										<li>
											<a href="#" class="menu_options">
												<i class="fa fa-square-o fa-fw"></i>
												Options
											</a>
										</li>
										<li>
											<a href="{{ url('/categories') }}" class="categories">
												<i class="fa fa-square-o fa-fw"></i>
												Categories
											</a>
										</li>
										<li>
											<a href="{{ url('/menu_subcategories') }}" class="subcategories">
												<i class="fa fa-square-o fa-fw"></i>
												Subcategories
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
											<a href="#" class="orders">
												<i class="fa fa-square-o fa-fw"></i>
												Orders
											</a>
										</li>
										<li>
											<a href="#" class="reservations">
												<i class="fa fa-square-o fa-fw"></i>
												Reservations
											</a>
										</li>
										<li>
											<a href="#" class="coupons">
												<i class="fa fa-square-o fa-fw"></i>
												Coupons
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
											<a href="#" class="reviews">
												<i class="fa fa-square-o fa-fw"></i>
												Reviews
											</a>
										</li>
										<li>
											<a href="#" class="messages">
												<i class="fa fa-square-o fa-fw"></i>
												Messages
											</a>
										</li>
										<li>
											<a href="#" class="banners">
												<i class="fa fa-square-o fa-fw"></i>
												Banners
											</a>
										</li>
									</ul>

								</li>
								<li>
									<a class="restaurant">
										<i class="fa fa-map-marker fa-fw"></i>
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
								<li>
									<a class="users">
										<i class="fa fa-user fa-fw"></i>
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
										<li>
											<a href="#" class="customer_groups">
												<i class="fa fa-square-o fa-fw"></i>
												Customer Groups
											</a>
										</li>
										<li>
											<a href="#" class="activities">
												<i class="fa fa-square-o fa-fw"></i>
												Activities
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="extensions">
										<i class="fa fa-puzzle-piece fa-fw"></i>
										<span class="content">Extensions</span>
									</a>
								</li>
								<li>
									<a class="design">
										<i class="fa fa-paint-brush fa-fw"></i>
										<span class="content">Design</span>
										<span class="fa arrow"></span>
									</a>
									<ul class="nav nav-second-level collapse">
										<li>
											<a href="#" class="pages">
												<i class="fa fa-square-o fa-fw"></i>
												Pages
											</a>
										</li>
										<li>
											<a href="#" class="layouts">
												<i class="fa fa-square-o fa-fw"></i>
												Layouts
											</a>
										</li>
										<li>
											<a href="#" class="mail_templates">
												<i class="fa fa-square-o fa-fw"></i>
												Mail Templates
											</a>
										</li>
									</ul>
								</li>
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
											<a href="#" class="currencies">
												<i class="fa fa-square-o fa-fw"></i>
												Currencies
											</a>
										</li>
										<li>
											<a href="#" class="countries">
												<i class="fa fa-square-o fa-fw"></i>
												Countries
											</a>
										</li>
										<li>
											<a href="#" class="security_questions">
												<i class="fa fa-square-o fa-fw"></i>
												Security Questions
											</a>
										</li>
										<li>
											<a href="#" class="ratings">
												<i class="fa fa-square-o fa-fw"></i>
												Ratings
											</a>
										</li>
										<li>
											<a href="#" class="statuses">
												<i class="fa fa-square-o fa-fw"></i>
												Statuses
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a class="system">
										<i class="fa fa-cog fa-fw"></i>
										<span class="content">System</span>
										<span class="fa arrow"></span>
									</a>
									<ul class="nav nav-second-level collapse">
										<li>
											<a href="#" class="settings">
												<i class="fa fa-square-o fa-fw"></i>
												Settings
											</a>
										</li>
										<li>
											<a href="#" class="permissions">
												<i class="fa fa-square-o fa-fw"></i>
												Permissions
											</a>
										</li>
										<li>
											<a class="tools">
												<i class="fa fa-square-o fa-fw"></i>
												Tools
												<span class="fa arrow"></span>
											</a>
											<ul class="nav nav-third-level collapse">
												<li>
													<a href="#" class="image_manager">
														<i class="fa fa-square-o fa-fw"></i>
														Image Manager
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
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
						<a class="front-end" title href="#"  data-original-title="Storefront">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle messages" data-toggle="dropdown">
							<i class="fa fa-envelope"></i>
                            <span class="label label-danger"></span>
						</a>
						<ul class="dropdown-menu dropdown-messages">
                            <li class="menu-header">You have messages</li>
                            <li class="menu-body">
								<ul class="menu message-list">
									<li>Ther are no messages available in this folder.</li>
									<li class="divider"></li>
								</ul>
							</li>
                            <li class="menu-footer">
                                <a class="text-center" href="#">See all messages</a>
                            </li>
                        </ul>
                    </li>
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

											<a >
												<b>#20992.</b>
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
                                <a class="text-center" >See all activities</a>
                            </li>
                        </ul>
                    </li>
					<li class="dropdown">
						<a class="dropdown-toggle settings" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-settings">
							<li><a>Pages</a></li>
							<li><a >Banners</a></li>
							<li><a>Layouts</a></li>
							<li><a >Error Logs</a></li>
							<li><a >Settings</a></li>
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
										<img class="img-rounded" src="https://www.gravatar.com/avatar/7c4ff521986b4ff8d29440beec01972d.png?s=48&d=mm">
									</div>
									<div class="col-xs-12 wrap-none wrap-top wrap-right">
										<span>
											<strong>Demo Adminm</strong>
										</span>
										<span class="small">
											<i>(demo)</i>
										</span>
										<br>
										<span class="small text-uppercase">Demo</span>
										<span></span>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#">
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
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" >
									<i class="fa fa-info-circle fa-fw"></i>
									&nbsp;&nbsp;About TastyIgniter
								</a>
							</li>
							<li>
								<a href="#" >
									<i class="fa fa-book fa-fw"></i>
									&nbsp;&nbsp;Documentation
								</a>
							</li>
							<li>
								<a href="#" >
									<i class="fa fa-users fa-fw"></i>
									&nbsp;Community Support
								</a>
							</li>
							<li class="menu-footer"></li>
						</ul>
					</li>
				</ul>
				{{--<h1 class="navbar-heading">Dashboard</h1>--}}
		</nav>
		<div id="page-wrapper" style="height: 100%;">

				{{--<div class="page-header clearfix">--}}
						{{--<div class="page-action">--}}
							{{--<a href="#" class="btn btn-default">--}}
								{{--<i class="fa fa-refresh"></i>--}}
								{{--Chek Updates--}}
							{{--</a>--}}
				{{--</div>--}}
				{{--</div>--}}
			@yield('content')
	</div>

	</div>

				{{--<div id="notification"></div>
				<div class="row content dashboard">
					<div class="col-md-12">
						<div class="row mini-statistics">


						</div>
						<div class="row statistics"></div>
						<div></div>
						<div class="panel panel-default panel-orders"></div>
					</div>
				</div>


					<div class="collapse" id="context-help-wrap">
						<div class="well"></div>
					</div>


				<div id="notification">
				</div>
		</div>

	</div>--}}

            </body>
</html>



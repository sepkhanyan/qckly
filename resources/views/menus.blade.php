@extends('header')
@section('content')
  <div class="page-header">
        <div class="page-action">
            <a href="{{ url('/new/menus') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                New
            </a>
            <a class="btn btn-danger " id="delete_menu">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div>
    <div class="form-group">
        <label for="input-name" class="col-sm-3 control-label">Restaurants</label>
        <div class="col-sm-5">
            <select name="restaurant_name" id="menus" class="form-control" tabindex="-1" title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                <option value>Select Restaurant</option>
                @foreach($restaurants as $restaurant)
                    <option value="{{url('/menus/' . $restaurant->id)}}">{{$restaurant->restaurant_name}},{{$restaurant->restaurant_city}},{{$restaurant->restaurant_address_1}}</option>
                @endforeach
            </select>
        </div>
       @if(count($menus)>0)
  </div>

    <div class="row content" >
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h2>
                        <img src="/images/{{$selectedRestaurant->restaurant_image}}" width="50px" height="50px">
                        {{$selectedRestaurant->restaurant_name}},
                        {{$selectedRestaurant->restaurant_city}},
                        {{$selectedRestaurant->restaurant_address_1}}
                    </h2>
                    <h3 class="panel-title">Menu Item List</h3>
                    <div class="pull-right">
                        <button class="btn btn-filter btn-xs">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-body panel-filter" style="display: none;">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="{{url('/menus/' . $id )}}">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-3 pull-right text-right">
                                        <div class="form-group">
                                            <input type="text" name="menu_search" class="form-control input-sm" value="" placeholder="Search name, price or stock qty."/>&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <select name="menu_category" class="form-control input-sm">
                                                <option value="">View all categories</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>&nbsp;
                                        </div>
                                        <div class="form-group">
                                            <select name="menu_status" class="form-control input-sm">
                                                <option value="">View all status</option>
                                                    <option value="1"  >Enabled</option>
                                                    <option value="0"  >Disabled</option>
                                            </select>
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                            <i class="fa fa-filter"></i>
                                        </a>&nbsp;
                                        <a class="btn btn-grey" href="{{url('/menus/' . $id )}}" title="Clear">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                </div>
                <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="">
                    <div class="table-responsive">
                        <table border="0" class="table table-striped table-border">
                            <thead>
                            <tr>
                                <th class="action action-three">
                                    <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Name
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Price
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Category
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Stock Qty
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Status
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        ID
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($menus as $menu)
                                <tr>
                                    <td class="action">
                                        <input type="checkbox" value="{{ $menu->id }}" name="delete" />
                                        <a class="btn btn-edit" title="" href="{{ url('menu/edit/' . $menu->id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$menu->menu_name}}</td>
                                    <td>£{{$menu->menu_price}}</td>
                                    <td>{{$menu->category['name']}}</td>
                                    <td>{{$menu->stock_qty}}</td>
                                    @if($menu->menu_status == 1)
                                        <td>Enable</td>
                                    @else
                                        <td>Disable</td>
                                    @endif
                                    <td>{{$menu->id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $menus->links() }}
                </form>
            </div>
        </div>
    </div>
       @endif
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
        </script>
    {{--<div id="footer" class="">
        <div class="row navbar-footer">
            <div class="col-sm-12 text-version">
                <p class="col-xs-9 wrap-none">Thank you for using <a target="_blank" href="http://tastyigniter.com">TastyIgniter</a></p>
                <p class="col-xs-3 text-right wrap-none">Version 2.1.1</p>
            </div>
        </div>
    </div>--}}
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
    <script type="text/javascript">
        $('#menus ').select2();
    </script>
@endsection
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
            <select name="location_name" id="menus" class="form-control" tabindex="-1" title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                <option value>Select Restaurant</option>
                @foreach($locations as $location)
                    <option value="{{url('/menus/' . $location->location_id)}}">{{$location->location_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
       @if(count($menus)>0)
    <div class="row content" >
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Menu Item List</h3>

                    {{--<div class="pull-right">
                        <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                    </div>--}}
                </div>
                <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="">
                    <div class="table-responsive">
                        <table border="0" class="table table-striped table-border">
                            <thead>
                            <tr>
                                <th class="action action-three"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
                                <th><a class="sort" href="">Name<i class="fa fa-sort"></i></a></th>
                                <th><a class="sort" href="">Price<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">Category<i class="fa fa-sort"></i></a></th>
                                <th><a class="sort" href="">Stock Qty<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">Status<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">ID<i class="fa fa-sort>"></i></a></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($menus as $menu)
                                <tr>
                                    <td class="action"><input type="checkbox" value="{{ $menu->menu_id }}" name="delete" />
                                        <a class="btn btn-edit" title="" href="{{ url('menu/edit/' . $menu->menu_id )}}"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$menu->menu_name}}</td>
                                    <td>{{$menu->menu_price}}</td>
                                    <td>{{$menu->menu_category_id}}</td>
                                    <td>{{$menu->stock_qty}}</td>
                                    <td>{{$menu->menu_status}}</td>
                                    <td>{{$menu->menu_id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
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
    </script>--}}
    <script type="text/javascript">
        $('#menus ').select2();
    </script>
@endsection
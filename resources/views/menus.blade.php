@extends('home')
@section('content')
  @if(Auth::user()->admin == 1)
      <div class="col-md-12">
          <div class="col-sm-5">
              <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1" title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                  <option value>Select Restaurant</option>
                  @foreach($restaurants as $restaurant)
                      <option value="{{url('/menus/' . $restaurant->id)}}">{{$restaurant->name_en}},{{$restaurant->area->area_en}},{{$restaurant->city_en}},{{$restaurant->address_en}}</option>
                  @endforeach
              </select>
          </div>
      </div>
  @endif
  @if(count($menus)>0)
    <div class="row content" >
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h2>
                        <img src="/images/{{$selectedRestaurant->image}}" width="50px" height="50px">
                        {{$selectedRestaurant->name_en}},
                        {{$selectedRestaurant->city_en}},
                        {{$selectedRestaurant->address_en}}
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
                                            <input type="text" name="menu_search" class="form-control input-sm" value="" placeholder="Search name, price or description."/>&nbsp;&nbsp;&nbsp;
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
                                                    <option value="{{$category->id}}">{{$category->name_en}}</option>
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
            <div class="page-header">
                <div class="page-action">
                    @if(Auth::user()->admin == 1)
                        <a  class="btn btn-primary"  href="{{ url('/menu/create/' . $selectedRestaurant->id) }}">
                            <i class="fa fa-plus"></i>
                            New
                        </a>
                    @else
                        <a  class="btn btn-primary"  href="{{ url('/menu/create') }}">
                            <i class="fa fa-plus"></i>
                            New
                        </a>
                    @endif
                    <a class="btn btn-danger " id="delete_menu">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
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
                                        Description
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
                                        <a class="btn btn-edit" title="" href="{{ url('/menu/edit/' . $menu->id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$menu->name_en}}</td>
                                    <td>{{$menu->description_en}}</td>
                                    <td>{{$menu->price}}</td>
                                    <td>{{$menu->category->name_en}}</td>
                                    <td>
                                    @if($menu->status == 1)
                                        Enable
                                    @else
                                        Disable
                                        @endif
                                    </td>
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
  @else
      @if($selectedRestaurant)
          <div class="page-header">
              <div class="page-action">
                  <h2>No Menus</h2>
                  @if(Auth::user()->admin == 1)
                      <a  class="btn btn-primary"  href="{{ url('/menu/create/' . $selectedRestaurant->id) }}">
                          <i class="fa fa-plus"></i>
                          New
                      </a>
                  @else
                      <a  class="btn btn-primary"  href="{{ url('/menu/create') }}">
                          <i class="fa fa-plus"></i>
                          New
                      </a>
              </div>
          </div>
      @endif
  @endif
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
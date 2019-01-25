@extends('home', ['title' => 'Menus'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            @if($user->admin == 1)
                                <a class="btn btn-primary"
                                   href="{{ url('/menu/create/' . $selectedRestaurant->id ) }}">
                                    <i class="fa fa-plus"></i>
                                    New
                                </a>
                            @else
                                <a class="btn btn-primary" href="{{ url('/menu/create') }}">
                                    <i class="fa fa-plus"></i>
                                    New
                                </a>
                            @endif
                            <a class="btn btn-danger " id="delete_menu">
                                <i class="fa fa-trash-o"></i>
                                Delete
                            </a>
                        @endif
                            @if($user->admin == 1)
                                <div class="form-group col-md-4">
                                    <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                            title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                        @if (!$id)
                                            <option value>Select Restaurant</option>
                                        @endif

                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/menus/' . $restaurant->id)}}" {{ $restaurant->id == $id ? 'selected' : '' }} >
                                                {{ $restaurant->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Menu Item List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none;">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/menus/' . $id )}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="menu_search" class="form-control input-sm"
                                                       value="" placeholder="Search name or price."/>&nbsp;&nbsp;&nbsp;
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
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Disabled</option>
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
                    <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="">
                        <div class="table-responsive">
                             <table border="0" class="table table-striped table-border">
                                <thead>
                                <tr>
                                    <th class="action action-three">
                                        <input type="checkbox"
                                               onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    </th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($selectedRestaurant)
                                    @if(count($menus) > 0)
                                        @foreach($menus as $menu)
                                            <tr class="{{($menu->editingMenu || $menu->approved == 0) ? 'info' : ''}}">
                                                <td class="action">
                                                    <input type="checkbox" value="{{ $menu->id }}" name="delete"/>
                                                    <a class="btn btn-edit" title=""
                                                       href="{{ url('/menu/edit/' . $menu->id )}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>&nbsp;&nbsp;
                                                    @if($user->admin == 1)
                                                        @if($menu->approved == 0)
                                                            <a class="btn btn-edit" title=""
                                                               href="{{ url('menu/approve/' . $menu->id )}}">
                                                                <i class="fa fa-check"></i>
                                                                Approve
                                                            </a>&nbsp;&nbsp;
                                                            <a class="btn btn-danger" title=""
                                                               href="{{ url('menu/reject/' . $menu->id )}}">
                                                                <i class="fa fa-ban"></i>
                                                                Reject
                                                            </a>&nbsp;
                                                        @endif
                                                    @endif
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
                                                <td>  @if($menu->approved == 0)
                                                        <span class="label label-default">Pending Approval</span>
                                                    @elseif($menu->approved == 2)
                                                        <span class="label label-danger">Rejected</span>
                                                    @endif
                                                    @if($menu->editingMenu)
                                                        <span class="label label-default">Pending Edit Approval</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="center">There are no menu items available.</td>
                                        </tr>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($menus) > 0)
                        {{ $menus->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#restaurant').select2();
        });
    </script>
@endsection
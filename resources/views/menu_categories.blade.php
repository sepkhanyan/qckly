@extends('home', ['title' => 'Menu Categories'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            @if(Auth::user()->admin == 1)
                                <a class="btn btn-primary"
                                   href="{{ url('/menu_category/create/' . $selectedRestaurant->id ) }}">
                                    <i class="fa fa-plus"></i>
                                    New
                                </a>
                            @else
                                <a class="btn btn-primary" href="{{ url('/menu_category/create') }}">
                                    <i class="fa fa-plus"></i>
                                    New
                                </a>
                            @endif
                            <a class="btn btn-danger " id="delete_menu_category">
                                <i class="fa fa-trash-o"></i>
                                Delete
                            </a>
                        @endif
                        @if(Auth::user()->admin == 1)
                            <div class="form-group col-md-4">
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                        title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if($selectedRestaurant)
                                        <option value>{{$selectedRestaurant->name_en . ', ' . $selectedRestaurant->area->name_en . ', ' . $selectedRestaurant->address_en}}</option>
                                        @foreach($restaurants as $restaurant)
                                            @if($selectedRestaurant->id != $restaurant->id)
                                                <option value="{{url('/menu_categories/' . $restaurant->id)}}">{{$restaurant->name_en . ', ' . $restaurant->area->name_en . ', ' . $restaurant->address_en}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value>Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/menu_categories/' . $restaurant->id)}}">{{$restaurant->name_en . ', ' . $restaurant->area->name_en . ', ' . $restaurant->address_en}}</option>
                                        @endforeach
                                    @endif
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
                        <h3 class="panel-title">Category List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/menu_categories/' . $id)}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="category_search" class="form-control input-sm"
                                                       value=""
                                                       placeholder="Search category name or description."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/menu_categories/' . $id)}}" title="Clear">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>&nbsp;
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
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($selectedRestaurant)
                                    @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                            <tr>
                                                <td class="action">
                                                    <input type="checkbox" value="{{ $category->id }}" name="delete"/>
                                                    <a class="btn btn-edit" title=""
                                                       href="{{ url('menu_category/edit/' . $category->id )}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>&nbsp;&nbsp;
                                                </td>
                                                <td>{{$category->name_en}}</td>
                                                <td>{{$category->description_en}}</td>
                                                <td>{{$category->id}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="center">There are no categories available.</td>
                                        </tr>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if(count($categories) > 0)
                            {{ $categories->links() }}
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
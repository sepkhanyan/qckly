@extends('home', ['title' => 'Menu Categories'])
@section('content')

    <script src="{{ asset('js/menus.js') }}"></script>

    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            @if($user->admin == 1)
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
                        @if($user->admin == 1)
                            <div class="form-group col-md-4">
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                        title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if (!$id)
                                        <option value>Select Restaurant</option>
                                    @endif

                                    @foreach($restaurants as $restaurant)
                                        <option value="{{url('/menu_categories/' . $restaurant->id)}}" {{ $restaurant->id == $id ? 'selected' : '' }} >
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
                                            <a class="btn btn-grey" href="{{url('/menu_categories/' . $id)}}"
                                               title="Clear">
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
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @if($selectedRestaurant)
                                    @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                            <tr class="{{($category->editingMenuCategory || $category->approved == 0) ? 'info' : ''}}" id="mainTr{{ $category->id }}">
                                                <td class="action">
                                                    <input type="checkbox" value="{{ $category->id }}" name="delete"/>
                                                    <a class="btn btn-edit" title=""
                                                       href="{{ url('menu_category/edit/' . $category->id )}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>&nbsp;&nbsp;
                                                    @if($user->admin == 1)
                                                        @if($category->approved == 0)
                                                            <a class="btn btn-edit" title=""
                                                               href="{{ url('menu_category/approve/' . $category->id )}}">
                                                                <i class="fa fa-check"></i>
                                                                Approve
                                                            </a>&nbsp;&nbsp;
                                                            <a class="btn btn-danger" title=""
                                                               href="{{ url('menu_category/reject/' . $category->id )}}">
                                                                <i class="fa fa-ban"></i>
                                                                Reject
                                                            </a>&nbsp;
                                                        @endif
                                                    @endif
                                                </td>
                                                <td id="name{{ $category->id }}">{{$category->name_en}}</td>
                                                <td id="description{{ $category->id }}">{{$category->description_en}}</td>
                                                <td>{{$category->id}}</td>
                                                <td>
                                                    @if($category->approved == 0)
                                                        <span class="label label-default">Pending Approval</span>
                                                    @elseif($category->approved == 2)
                                                        <span class="label label-danger">Rejected</span>
                                                    @endif

                                                        @if($category->editingMenuCategory)
                                                            <div id="statusAndBtn{{ $category->id }}">
                                                                @if ($user->admin == 1)
                                                                    <button type="button" class="btn btn-info" id="view_edited"
                                                                            data-id="{{ $category->id }}"
                                                                            data-toggle="modal"
                                                                            data-target="#edited_category">
                                                                        View edited fields
                                                                    </button><br>
                                                                @endif
                                                                <span class="label label-default">Pending Edit Approval</span>
                                                            </div>
                                                        @endif
                                                </td>
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



    <!-- view edited fields modal -->
    <div class="modal fade" id="edited_category">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">View edited fields</h4>
                </div>

                <div class="modal-body" id="show_fields">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-top: 10px;">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /view edited fields modal -->

    <script type="text/javascript">
        $(document).ready(function () {
            $('select.form-control').select2();
        });
    </script>
@endsection
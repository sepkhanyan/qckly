@extends('home', ['title' => 'Restaurant Categories'])
@section('content')

    <script src="{{ asset('js/restaurants.js') }}"></script>

    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalCreateRestaurantCategory">
                    <i class="fa fa-plus"></i>
                    New
                </a>
                <a class="btn btn-danger" id="delete_restaurant_category">
                    <i class="fa fa-trash-o"></i>
                    Delete
                </a>
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
                              action="{{url('/restaurant_categories')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="restaurant_category_search"
                                                       class="form-control input-sm" value=""
                                                       placeholder="Search category name."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <div class="form-group">
                                                <a class="btn btn-grey" href="{{url('/restaurant_categories')}}"
                                                   title="Clear">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
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
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="action">
                                            <input type="checkbox" value="{{ $category->id }}" name="delete"/>
                                            <button  class="edit-restaurant-category-modal btn btn-edit"
                                                     type="button"
                                                     data-id ="{{$category->id}}"
                                                     data-name-en ="{{$category->name_en}}"
                                                     data-name-ar ="{{$category->name_ar}}">
                                                <i class="fa fa-pencil"></i>
                                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </td>
                                        <td>{{$category->name_en}}</td>
                                        <td>{{$category->id}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="pagination-bar clearfix">
                        <div class="links"></div>
                        <div class="info"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalCreateRestaurantCategory" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Add Category</h4>
                        </div>
                        <div class="modal-body">
                            <div id="en" class="form-group row add{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label" >Name En</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text"  name="name_en">
                                    <span   class="help-block hidden">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div id="ar" class="form-group row add{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label" >Name Ar</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text"  name="name_ar">
                                    <span  class="help-block hidden">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="addRestaurantCategory" type="button" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal fade" id="modalEditRestaurantCategory" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Edit Category</h4>
                            <input type="hidden" name="restaurant_category_id" class="form-control" value="">
                        </div>
                        <div class="modal-body">
                            <div id="editEn" class="form-group row add{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label" for="category_en">Name En</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="category_en" name="name_en" value="">
                                    <span  class="help-block hidden">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div id="editAr" class="form-group row add{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label class="col-sm-3 control-label" for="category_ar">Name Ar</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="category_ar" name="name_ar" value="">
                                    <span  class="help-block hidden">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="editRestaurantCategory" type="button" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
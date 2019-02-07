@extends('home', ['title' => 'Collection Categories'])
@section('content')

    <script src="{{ asset('js/collections.js') }}"></script>

    <div id="page-wrapper">
        @if($user->admin == 1)
            <div class="page-header">
                <div class="page-action">
                    <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalCreateCollectionCategory">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_collection_category">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                </div>
            </div>
        @endif
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
                              action="{{url('/collection_categories')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="collection_category_search"
                                                       class="form-control input-sm" value=""
                                                       placeholder="Search category."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/collection_categories')}}"
                                               title="Clear">
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
                                    @if($user->admin == 1)
                                        <th class="action action-three">
                                            <input type="checkbox"
                                                   onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                        </th>
                                    @endif
                                    <th>Name</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($categories) > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            @if($user->admin == 1)
                                                <td class="action">
                                                    <input type="checkbox" value="{{ $category->id }}" name="delete"/>
                                                    <button class="edit-collection-category-modal btn btn-edit"
                                                            type="button"
                                                            data-id="{{$category->id}}"
                                                            data-name-en="{{$category->name_en}}"
                                                            data-name-ar="{{$category->name_ar}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>&nbsp;&nbsp;
                                                </td>
                                            @endif
                                            <td>{{$category->name_en}}</td>
                                            <td>{{$category->id}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no categories available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($user->admin == 1)
        <div class="modal fade" id="modalCreateCollectionCategory" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <div id="en" class="form-group row add{{ $errors->has('name_en') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="en">Name En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="name_en">
                                <span class="help-block hidden">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="ar" class="form-group row add{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="ar">Name Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="name_ar">
                                <span class="help-block hidden">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="addCollectionCategory" type="button" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditCollectionCategory" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Edit Category</h4>
                        <input type="hidden" name="collection_category_id" class="form-control" value="">
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
                        <button id="editCollectionCategory" type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

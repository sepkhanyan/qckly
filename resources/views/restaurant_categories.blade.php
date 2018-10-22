@extends('home', ['title' => 'Restaurant Categories'])
@section('content')
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
                                            <a class="btn btn-edit" href="#" data-toggle="modal"
                                               data-target="#modalEditRestaurantCategory" type="button"
                                               onclick="myFunction('{{$category->id}}', '{{$category->name_en}}', '{{$category->name_ar}}')">
                                                <i class="fa fa-pencil"></i>
                                            </a>&nbsp;&nbsp;&nbsp;
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
            <form role="form" id="create-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                  action="{{ url('/restaurant_category/store') }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Add Category</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="en">Name En</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="en" name="name_en">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="ar">Name Ar</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="ar" name="name_ar">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="modalEditRestaurantCategory" role="dialog" tabindex="-1">
            <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                  action="{{ url('/restaurant_category/update/' . $category->id ) }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Edit Category</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="en">Name En</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="en" name="name_en" value="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="ar">Name Ar</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" id="ar" name="name_ar" value="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function myFunction(id,en,ar) {
            $('input[name=name_en]').val(en);
            $('input[name=name_ar]').val(ar);
            $("#edit-form").attr('action', 'restaurant_category/update/' + id);
        }
    </script>
@endsection
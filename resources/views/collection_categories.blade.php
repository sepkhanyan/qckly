@extends('home')
@section('content')
    @if(Auth::user()->admin == 1)
    <div class="page-header">
        <div class="page-action">
            <a  href="" class="btn btn-primary"  data-toggle="modal" data-target="#modalCreateCollectionCategory">
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
                    <h3 class="panel-title">Collection Categories</h3>
                    <div class="pull-right">
                        <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
                <div class="panel-body panel-filter" style="display: none">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <input type="text" name="collection_category_search" class="form-control input-sm" value="" placeholder="Search category." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a class="btn btn-grey" href="{{url('/collection_categories')}}" title="Clear">
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
                                @if(Auth::user()->admin == 1)
                                <th class="action action-three">
                                    <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                </th>
                                @endif
                                <th>
                                    <a class="sort" href="">
                                        Category En
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Category Ar
                                        <i class="fa fa-sort"></i>
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
                            @foreach($categories as $category)
                                <tr>
                                    @if(Auth::user()->admin == 1)
                                    <td class="action">
                                        <input type="checkbox" value="{{ $category->id }}" name="delete" />
                                        <a class="btn btn-edit"  href="#" data-toggle="modal" data-target="#modalEditCollectionCategory" type="button" onclick="myFunction({{$category->id}})" >
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                    @endif
                                    <td>{{$category->name_en}}</td>
                                    <td>{{$category->name_ar}}</td>
                                    <td>{{$category->id}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
               </form>
            </div>
        </div>
    </div>
    @if(Auth::user()->admin == 1)
    <div class="modal fade" id="modalCreateCollectionCategory" role="dialog" tabindex="-1" >
        <form role="form" id="create-form" class="form-horizontal"  accept-charset="utf-8" method="GET" action="{{ url('/collection_category/store') }}">
            {{ csrf_field() }}
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="modal-title"> Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="en">Category En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="en" name="category_en">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="ar">Category Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="ar" name="category_ar">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if(isset($category->id))
    <div class="modal fade" id="modalEditCollectionCategory" role="dialog" tabindex="-1" >
        <form role="form" id="edit-form" class="form-horizontal"  accept-charset="utf-8" method="POST">
            {{ csrf_field() }}
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="modal-title"> Edit Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="en">Category En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="en" name="category_en" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="ar">Category Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="ar" name="category_ar" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit"  class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
        @endif
    @endif
    <script type="text/javascript">
        function myFunction(id){
            $("#edit-form").attr('action', 'collection_category/update/' + id);
        }
        function filterList() {
            $('#filter-form').submit();
        }
    </script>
@endsection

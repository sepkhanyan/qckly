@extends('home')
@section('content')
    <div class="page-header">
        <div class="page-action">
            <a  href="" class="btn btn-primary"  data-toggle="modal" data-target="#modalCreateSubcategory">
                <i class="fa fa-plus"></i>
                New
            </a>
            <a class="btn btn-danger " id="delete_menu_subcategory">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Menu Subcategories</h3>
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
                                            <input type="text" name="menu_subcategory_search" class="form-control input-sm" value="" placeholder="Search subcategory." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a class="btn btn-grey" href="}}" title="Clear">
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
                                    <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Subcategory En
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Subcategory Ar
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
                            @foreach($subcategories as $subcategory)
                                <tr>
                                    <td class="action">
                                        <input type="checkbox" value="{{ $subcategory->id }}" name="delete" />
                                        <a class="btn btn-edit"  href="#" data-toggle="modal" data-target="#modalEditSubcategory" type="button"  data-item-id="{{$subcategory->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td>{{$subcategory->name_en}}</td>
                                    <td>{{$subcategory->name_ar}}</td>
                                    <td>{{$subcategory->id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
               </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCreateSubcategory" role="dialog" tabindex="-1" >
        <form role="form" id="edit-form" class="form-horizontal"  accept-charset="utf-8" method="GET" action="{{ url('/menu_subcategory/store') }}">
            {{ csrf_field() }}
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="modal-title"> Add Subcategory</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="en">Sub En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="en" name="subcategory_en">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="ar">Sub Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="ar" name="subcategory_ar">
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
    <div class="modal fade" id="modalEditSubcategory" role="dialog" tabindex="-1" >
        <form role="form" id="edit-form" class="form-horizontal"  accept-charset="utf-8" method="POST" action="{{ url('/menu_subcategory/update/' . $subcategory->id ) }}">
            {{ csrf_field() }}
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="modal-title"> Edit Subcategory</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="en">Sub En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="en" name="subcategory_en" value="{{$subcategory->name_en}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="margin: 5px">
                            <label class="control-label col-sm-2" for="ar">Sub Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="ar" name="subcategory_ar" value="{{$subcategory->name_ar}}">
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

    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
    </script>
@endsection

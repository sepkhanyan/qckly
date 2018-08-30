@extends('home')
@section('content')
    <div class="page-header">
        <div class="page-action">
            <a  href="" class="btn btn-primary"  data-toggle="modal" data-target="#myModal">
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
                                        <a class="btn btn-edit" title="" href="{{ url('/menu_subcategory/edit/' . $subcategory->id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$subcategory->subcategory_en}}</td>
                                    <td>{{$subcategory->subcategory_ar}}</td>
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
    <div class="modal fade" id="myModal" role="dialog">
        <form role="form" id="edit-form" class="form-horizontal"  accept-charset="utf-8" method="GET" action="{{ url('/menu_subcategory/store') }}">
            {{ csrf_field() }}
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                        <h4 class="modal-title"> Add Subcategory</h4>
                    </div>
                    <div class="modal-body">
                        <div class="md-form mb-5" style="width: 400px">
                            <label class="control-label" for="en">Subcategory En</label>
                            <input type="text" id="en" name="subcategory_en">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="md-form mb-5" style="width: 400px">
                            <label class="control-label" for="ar">Subcategory Ar</label>
                            <input type="text" id="ar" name="subcategory_ar">
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

    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
    </script>
@endsection

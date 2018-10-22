@extends('home', ['title' => 'Areas'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                <a data-toggle="modal" data-target="#modalCreateArea" href="" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    New
                </a>
                <a class="btn btn-danger " id="delete_area">
                    <i class="fa fa-trash-o"></i>
                    Delete
                </a>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Area List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/areas')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="area_search" class="form-control input-sm"
                                                       value="" placeholder="Search area name."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/areas')}}" title="Clear">
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
                                               onclick="$('input[name*=\'delete\']').prop('checked', this.checked)">
                                    </th>
                                    <th>Name</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($areas) > 0)
                                    @foreach($areas as $area)
                                        <tr>
                                            <td class="action">
                                                <input type="checkbox" value="{{ $area->id }}" name="delete"/>&nbsp;&nbsp;&nbsp;
                                                <a class="btn btn-edit" data-toggle="modal" data-target="#modalEditArea"
                                                   type="button"
                                                   onclick="myFunction('{{$area->id}}', '{{$area->name_en}}', '{{$area->name_ar}}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;&nbsp;
                                            </td>
                                            <td>{{$area->name_en}}</td>
                                            <td>{{$area->id}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no areas available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($areas) > 0)
                        {{ $areas->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCreateArea" role="dialog" tabindex="-1">
        <form role="form" id="create-form" class="form-horizontal" accept-charset="utf-8" method="GET"
              action="{{ url('/area/store') }}">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Add Area</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="area-en">Name En</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_en" class="form-control" value="" id="area-en">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name_en') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" for="area-en">Name Ar</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_ar" class="form-control" value="" id="area-ar">
                                @if ($errors->has('name_ar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                @endif
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
    <div class="modal fade" id="modalEditArea" role="dialog" tabindex="-1">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Edit Area</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="area-en">Name En</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_en" class="form-control" value="" id="area-en">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="area-en">Name Ar</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_ar" class="form-control" value="" id="area-ar">
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
    <script type="text/javascript">
        function myFunction(id, en, ar) {
            $('input[name=name_en]').val(en);
            $('input[name=name_ar]').val(ar);
            $("#edit-form").attr('action', 'area/update/' + id);
        }

    </script>
@endsection

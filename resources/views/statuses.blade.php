@extends('home', ['title' => 'Statuses'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                <a data-toggle="modal" data-target="#modalCreateStatus" href="" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    New
                </a>
                <a class="btn btn-danger " id="delete_status">
                    <i class="fa fa-trash-o"></i>
                    Delete
                </a>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Statuses</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/statuses')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-8 pull-left">
                                            <div class="form-group">
                                                <input type="text" name="status_search" class="form-control input-sm"
                                                       value="" placeholder="Search status."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/statuses')}}" title="Clear">
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
                                    <th>
                                        Name En
                                    </th>
                                    <th>
                                        Name Ar
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statuses as $status)
                                    <tr>
                                        <td class="action">
                                            <input type="checkbox" value="{{ $status->id }}" name="delete"/>&nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-edit" data-toggle="modal" data-target="#modalEditStatus"
                                               type="button" onclick="myFunction({{$status->id}})">
                                                <i class="fa fa-pencil"></i>
                                            </a>&nbsp;&nbsp;
                                        </td>
                                        <td>{{$status->name_en}}</td>
                                        <td>{{$status->name_ar}}</td>
                                        <td>{{$status->id}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $statuses->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalCreateStatus" role="dialog" tabindex="-1">
            <form role="form" id="create-form" class="form-horizontal" accept-charset="utf-8" method="GET"
                  action="{{ url('/status/store') }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Add Status</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}"
                                 style="margin: 5px">
                                <label class="control-label col-sm-2" for="status-en">Name En</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_en" class="form-control" value="" id="status-en">
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }}"
                                 style="margin: 5px">
                                <label class="control-label col-sm-2" for="status-ar">Name Ar</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_ar" class="form-control" value="" id="status-ar">
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
        <div class="modal fade" id="modalEditStatus" role="dialog" tabindex="-1">
            <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Edit Status</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="margin: 5px">
                                <label class="control-label col-sm-2" for="status-en">Name En</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_en" class="form-control" value="" id="status-en">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="margin: 5px">
                                <label class="control-label col-sm-2" for="status-ar">Name Ar</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name_ar" class="form-control" value="" id="status-ar">
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
        function myFunction(id) {
            $("#edit-form").attr('action', 'status/update/' + id);
        }
    </script>
@endsection
@extends('home', ['title' => 'Mealtimes'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                @if($user->admin == 1)
                    <a data-toggle="modal" data-target="#modalCreateMealtime" href="" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_mealtime">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                @endif
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mealtime List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/mealtimes')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="mealtime_search" class="form-control input-sm"
                                                       value="" placeholder="Search mealtime."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/mealtimes')}}" title="Clear">
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
                                    <th>Time</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($mealtimes) > 0)
                                    @foreach($mealtimes as $mealtime)
                                        <tr>
                                            @if($user->admin == 1)
                                                <td class="action">
                                                    <input type="checkbox" value="{{ $mealtime->id }}" name="delete"/>&nbsp;&nbsp;&nbsp;
                                                    <button  class="edit-mealtime-modal btn btn-edit"
                                                             type="button"
                                                             data-id ="{{$mealtime->id}}"
                                                             data-name-en ="{{$mealtime->name_en}}"
                                                             data-name-ar ="{{$mealtime->name_ar}}"
                                                             data-start-time ="{{$mealtime->start_time}}"
                                                             data-end-time ="{{$mealtime->end_time}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>&nbsp;&nbsp;
                                                </td>
                                            @endif
                                            <td>{{$mealtime->name_en}}</td>
                                            <td>{{date("g:i A", strtotime($mealtime->start_time)) . ' - ' . date("g:i A", strtotime($mealtime->end_time))}}</td>
                                            <td>{{$mealtime->id}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no mealtimes available.</td>
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
        <div class="modal fade" id="modalCreateMealtime" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Add Mealtime</h4>
                    </div>
                    <div class="modal-body">
                        <div id="en" class="form-group row add{{ $errors->has('name_en') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">Name En</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_en" class="form-control" value="">
                                <span class="help-block hidden">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="ar" class="form-group row add{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">Name Ar</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_ar" class="form-control" value="">
                                <span class="help-block hidden">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="start"
                             class="form-group row add{{ $errors->has('start_time') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">Start Time</label>
                            <div class="col-sm-3">
                                <input type="time" name="start_time" class="form-control" >
                                <span class="help-block hidden">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>

                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="end" class="form-group row add{{ $errors->has('end_time') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">End Time</label>
                            <div class="col-sm-3">
                                <input type="time" name="end_time" class="form-control">
                                <span class="help-block hidden">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="addMealtime" type="button" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditMealtime" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Edit Mealtime</h4>
                        <input type="hidden" name="mealtime_id" class="form-control" value="">
                    </div>
                    <div class="modal-body">
                        <div id="editEn" class="form-group row add{{ $errors->has('name_en') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" >Name En</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_en" class="form-control" value=""
                                       id="mealtime_en">
                                <span  class="help-block hidden">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="editAr" class="form-group row add{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label" >Name Ar</label>
                            <div class="col-sm-8">
                                <input type="text" name="name_ar" class="form-control" value=""
                                       id="mealtime_ar">
                                <span  class="help-block hidden">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="editStart"
                             class="form-group row add{{ $errors->has('start_time') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">Start Time</label>
                            <div class="col-sm-3">
                                <input type="time" name="start_time" class="form-control" id="start_time">
                                <span class="help-block hidden">
                                            <strong>{{ $errors->first('start_time') }}</strong>
                                        </span>

                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="editEnd" class="form-group row add{{ $errors->has('end_time') ? ' has-error' : '' }}">
                            <label class="col-sm-3 control-label">End Time</label>
                            <div class="col-sm-3">
                                <input type="time" name="end_time" class="form-control" id="end_time">
                                <span class="help-block hidden">
                                            <strong>{{ $errors->first('end_time') }}</strong>
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="editMealtime" type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
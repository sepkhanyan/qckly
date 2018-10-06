@extends('home', ['title' => 'Mealtimes'])
@section('content')
    <div id="page-wrapper">
        @if(Auth::user()->admin == 1)
            <div class="page-header">
                <div class="page-action">
                    <a data-toggle="modal" data-target="#modalCreateMealtime" href="" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_mealtime">
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
                        <h3 class="panel-title">Mealtimes</h3>
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
                                    @if(Auth::user()->admin == 1)
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
                                @foreach($mealtimes as $mealtime)
                                    <tr>
                                        @if(Auth::user()->admin == 1)
                                            <td class="action">
                                                <input type="checkbox" value="{{ $mealtime->id }}" name="delete"/>&nbsp;&nbsp;&nbsp;
                                                <a class="btn btn-edit" href="#" data-toggle="modal"
                                                   data-target="#modalEditMealtime" type="button"
                                                   onclick="myFunction({{$mealtime->id}})">
                                                    <i class="fa fa-pencil"></i>
                                                </a>&nbsp;&nbsp;
                                            </td>
                                        @endif
                                        <td>{{$mealtime->name_en}}</td>
                                        <td>{{date("g:i A", strtotime($mealtime->start_time)) . ' - ' . date("g:i A", strtotime($mealtime->end_time))}}</td>
                                        <td>{{$mealtime->id}}</td>
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
            <div class="modal fade" id="modalCreateMealtime" role="dialog" tabindex="-1">
                <form role="form" id="create-form" class="form-horizontal" accept-charset="utf-8" method="GET"
                      action="{{ url('/mealtime/store') }}">
                    {{ csrf_field() }}
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Add Mealtime</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-en">Mealtime En</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mealtime_en" class="form-control" value=""
                                               id="mealtime-en">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-ar">Mealtime Ar</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mealtime_ar" class="form-control" value=""
                                               id="mealtime-ar">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-ar">Time</label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="time" name="start_time" class="form-control">
                                            </div>
                                            <div class="input-group">
                                                <input type="time" name="end_time" class="form-control">
                                            </div>
                                        </div>
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
            <div class="modal fade" id="modalEditMealtime" role="dialog" tabindex="-1">
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Edit Mealtime</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-en">Mealtime En</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mealtime_en" class="form-control" value=""
                                               id="mealtime-en">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-ar">Mealtime Ar</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mealtime_ar" class="form-control" value=""
                                               id="mealtime-ar">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="margin: 5px">
                                    <label class="control-label col-sm-2" for="mealtime-ar">Time</label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="time" name="start_time" class="form-control">
                                            </div>
                                            <div class="input-group">
                                                <input type="time" name="end_time" class="form-control">
                                            </div>
                                        </div>
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
        @endif
    </div>
    <script type="text/javascript">
        function myFunction(id) {
            $("#edit-form").attr('action', 'mealtime/update/' + id);
        }
    </script>
@endsection
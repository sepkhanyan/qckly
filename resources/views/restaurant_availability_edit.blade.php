@extends('home', ['title' => 'Restaurant: ' . $restaurant->name_en])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-save"></i>
                    Save
                </a>
                <a class="btn btn-default" onclick="saveClose();">
                    <i class="fa fa-save"></i>
                    Save & Close
                </a>
                <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li  class="active">
                            <a href="#general" data-toggle="tab">Working Hours</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8"
                      method="POST" action="{{ url('restaurant/availability/update/' . $restaurant->id ) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <input type="hidden" name="opening_type"
                                   value="flexible">
                            <div id="opening-flexible">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <div class="control-group control-group-2">
                                            <div class="input-group">
                                                <b>Open hour</b>
                                            </div>
                                            <div class="input-group">
                                                <b>Close hour</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @foreach($working_hours as $working_hour)
                                        <div class="form-group{{ $errors->has('flexible_hours.' . $working_hour->weekday . '.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.' . $working_hour->weekday . '.close') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">
                                                    @if($working_hour->weekday == 1)
                                                        Monday
                                                    @elseif($working_hour->weekday == 2)
                                                        Tuesday
                                                    @elseif($working_hour->weekday == 3)
                                                        Wednesday
                                                    @elseif($working_hour->weekday == 4)
                                                        Thursday
                                                    @elseif($working_hour->weekday == 5)
                                                        Friday
                                                    @elseif($working_hour->weekday == 6)
                                                        Saturday
                                                    @elseif($working_hour->weekday == 0)
                                                        Sunday
                                                    @endif
                                                </span>
                                                <input type="hidden"
                                                       name="flexible_hours[{{$working_hour->weekday}}][day]"
                                                       value="{{$working_hour->weekday}}"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text"
                                                               name="flexible_hours[{{$working_hour->weekday}}][open]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.' . $working_hour->weekday . '.open') ?? date("g:i A", strtotime($working_hour->opening_time)) }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                               name="flexible_hours[{{$working_hour->weekday}}][close]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.' . $working_hour->weekday . '.close') ?? date("g:i A", strtotime($working_hour->closing_time)) }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                        @if(old('flexible_hours'))
                                                            <label class="btn btn-success{{ (old('flexible_hours.' . $working_hour->weekday . '.status') == '1') ? ' active' : '' }}">
                                                                <input type="radio"
                                                                       name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                       value="1" {{ (old('flexible_hours.' . $working_hour->weekday . '.status') == '1') ? 'checked' : '' }} >
                                                                Open
                                                            </label>
                                                            <label class="btn btn-danger{{ (old('flexible_hours.' . $working_hour->weekday . '.status') == '0') ? ' active' : '' }}">
                                                                <input type="radio"
                                                                       name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                       value="0" {{ (old('flexible_hours.' . $working_hour->weekday . '.status') == '0') ? 'checked' : '' }}>
                                                                Closed
                                                            </label>
                                                        @else
                                                            <label class="btn btn-success{{$working_hour->status == 1 ? ' active' : ''}}">
                                                                <input type="radio"
                                                                       name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                       value="1" {{$working_hour->status == 1 ? 'checked' : ''}}>
                                                                Open
                                                            </label>
                                                            <label class="btn btn-danger{{$working_hour->status == 0 ? ' active' : ''}} ">
                                                                <input type="radio"
                                                                       name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                       value="0" {{$working_hour->status == 0 ? 'checked' : ''}}>
                                                                Closed
                                                            </label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.' . $working_hour->weekday . '.open'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.' . $working_hour->weekday . '.open') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.' . $working_hour->weekday . '.close'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.' . $working_hour->weekday . '.close') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
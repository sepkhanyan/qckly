@extends('home', ['title' => 'Collection: ' . $collection->name_en])
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
                        <li class="active"><a href="#general" data-toggle="tab">Collection Availability</a></li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      action="{{ url('/collection/availability/update/' . $collection->id) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if($user->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$collection->restaurant_id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$collection->name_en}}</h4>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Availability</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        <label class="btn btn-default{{(count($hours) == 0) ? ' active' : ''}}{{ (old('is_available') == '0') ? 'btn btn-default' : '' }}">
                                            <input type="radio" name="is_available"
                                                   value="1" {{(count($hours) == 0) ? 'checked' : ''}} {{ (old('is_available') == '1') ? 'checked' : '' }}>
                                            Is Available
                                        </label>
                                        <label class="btn btn-default{{(count($hours) > 0) ? ' active' : ''}}{{ (old('is_available') == '0') ? ' active' : '' }} ">
                                            <input type="radio" name="is_available"
                                                   value="0" {{(count($hours) > 0) ? 'checked' : ''}}{{ (old('is_available') == '0') ? 'checked' : '' }} >
                                            Not Available
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="unavailability_hours" style="display: none">
                                <div id="type" class="form-group">
                                    <label for="" class="col-sm-3 control-label">Type</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                    <label @if(old('type'))class="btn btn-success{{ (old('type') == '24_7') ? ' active' : '' }}" @elseif($unavailability !== null) class="btn btn-success{{($unavailability->type == '24_7') ? ' active' : ''}}" @else class="btn btn-success active" @endif>
                                                        <input type="radio" name="type" value="24_7"
                                                               @if(old('type')){{ (old('type') == '24_7') ? 'checked' : '' }} @elseif($unavailability !== null) {{($unavailability->type == '24_7') ? 'checked' : ''}} @else checked="checked" @endif>
                                                        24/7
                                                    </label>
                                                    <label @if(old('type'))class="btn btn-success{{ (old('type') == 'daily') ? ' active' : '' }}" @else class="btn btn-success{{($unavailability !== null && $unavailability->type == 'daily') ? ' active' : ''}}"@endif>
                                                        <input type="radio" name="type"
                                                               value="daily" @if(old('type')) {{ (old('type') == 'daily') ? 'checked' : '' }} @else {{($unavailability !== null && $unavailability->type == 'daily') ? 'checked' : ''}}@endif>
                                                        Daily
                                                    </label>
                                                    <label @if(old('type'))class="btn btn-success{{ (old('type') == 'flexible') ? ' active' : '' }}" @else class="btn btn-success{{($unavailability !== null && $unavailability->type == 'flexible') ? ' active' : ''}}"@endif>
                                                        <input type="radio" name="type"
                                                               value="flexible" @if(old('type')) {{ (old('type') == 'flexible') ? 'checked' : '' }} @else {{($unavailability !== null && $unavailability->type == 'flexible') ? 'checked' : ''}}@endif>
                                                        Flexible
                                                    </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="daily" style="display: none;">
                                    <div class="form-group">
                                        <label for="input-opening-days" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5{{ $errors->has('daily_days') ? ' has-error' : '' }}">
                                            <div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(1)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('1') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="1" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(1)) ? 'checked':'' }}  @else {{ $week->has('1') ? 'checked' : '' }} @endif >
                                                    Mon
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(2)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('2') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="2" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(2)) ? 'checked':'' }}  @else {{ $week->has('2') ? 'checked' : '' }} @endif>
                                                    Tue
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(3)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('3') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="3" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(3)) ? 'checked':'' }}  @else {{ $week->has('3') ? 'checked' : '' }} @endif>
                                                    Wed
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(4)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('4') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="4" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(4)) ? 'checked':'' }}  @else {{ $week->has('4') ? 'checked' : '' }} @endif>
                                                    Thu
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(5)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('5') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="5" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(5)) ? 'checked':'' }}  @else {{ $week->has('5') ? 'checked' : '' }} @endif>
                                                    Fri
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(6)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('6') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="6" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(6)) ? 'checked':'' }}  @else {{ $week->has('6') ? 'checked' : '' }} @endif>
                                                    Sat
                                                </label>
                                                <label @if(old('daily_days') )  class="btn btn-default{{ (collect(old('daily_days'))->contains(0)) ? ' active':'' }}"
                                                       @else class="btn btn-default {{ $week->has('0') ? ' active' : '' }}" @endif >
                                                    <input type="checkbox" name="daily_days[]"
                                                           value="0" @if(old('daily_days') )  {{ (collect(old('daily_days'))->contains(0)) ? 'checked':'' }}  @else {{ $week->has('0') ? 'checked' : '' }} @endif>
                                                    Sun
                                                </label>
                                            </div>
                                            @if ($errors->has('daily_days'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('daily_days') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('daily_hours.start') ? ' has-error' : '' }}{{ $errors->has('daily_hours.end') ? ' has-error' : '' }}">
                                        <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                        <div class="col-sm-5">
                                            <div class="control-group control-group-2">
                                                <div class="input-group">
                                                    <input id="clock-show" type="text" name="daily_hours[start]"
                                                           class="form-control timepicker"
                                                           value="@if($unavailability !== null && $unavailability->type == 'daily'){{ old('daily_hours.start') ?? date("g:i A", strtotime($unavailability->start_time)) }}@else{{ old('daily_hours.start') ?? '09:00 AM' }}@endif"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="daily_hours[end]"
                                                           class="form-control timepicker"
                                                           value="@if($unavailability !== null && $unavailability->type == 'daily'){{ old('daily_hours.end') ?? date("g:i A", strtotime($unavailability->end_time))   }}@else{{ old('daily_hours.end') ??  '11:59 PM'   }}@endif"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('daily_hours.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('daily_hours.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('daily_hours.end'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('daily_hours.end') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="flexible" style="display: none;">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5">
                                            <div class="control-group control-group-2">
                                                <div class="input-group">
                                                    <b>Start Time</b>
                                                </div>
                                                <div class="input-group">
                                                    <b>End Time</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($unavailability !== null && $unavailability->type == 'flexible')
                                        @foreach($hours as $hour)
                                            <div class="form-group{{ $errors->has('flexible_hours.' . $hour->weekday . '.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.' . $hour->weekday . '.end') ? ' has-error' : '' }}">
                                                <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">
                                                    @if($hour->weekday == 1)
                                                        Monday
                                                    @elseif($hour->weekday == 2)
                                                        Tuesday
                                                    @elseif($hour->weekday == 3)
                                                        Wednesday
                                                    @elseif($hour->weekday == 4)
                                                        Thursday
                                                    @elseif($hour->weekday == 5)
                                                        Friday
                                                    @elseif($hour->weekday == 6)
                                                        Saturday
                                                    @elseif($hour->weekday == 0)
                                                        Sunday
                                                    @endif
                                                </span>
                                                    <input type="hidden"
                                                           name="flexible_hours[{{$hour->weekday}}][day]"
                                                           value="{{$hour->weekday}}"/>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="control-group control-group-3">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   name="flexible_hours[{{$hour->weekday}}][start]"
                                                                   class="form-control timepicker"
                                                                   value="{{ old('flexible_hours.' . $hour->weekday . '.start') ?? date("g:i A", strtotime($hour->start_time)) }}"/>
                                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                        </div>
                                                        <div class="input-group">
                                                            <input type="text"
                                                                   name="flexible_hours[{{$hour->weekday}}][end]"
                                                                   class="form-control timepicker"
                                                                   value="{{ old('flexible_hours.' . $hour->weekday . '.end') ?? date("g:i A", strtotime($hour->end_time)) }}"/>
                                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                        </div>
                                                        <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                            @if(old('flexible_hours'))
                                                                <label class="btn btn-danger{{ (old('flexible_hours.' . $hour->weekday . '.status') == '0') ? ' active' : '' }}">
                                                                    <input type="hidden" name="flexible_hours[{{$hour->weekday}}][status]" value="1" />
                                                                    <input type="checkbox"
                                                                           name="flexible_hours[{{$hour->weekday}}][status]"
                                                                           value="0" {{ (old('flexible_hours.' . $hour->weekday . '.status') == '0') ? 'checked' : '' }}>
                                                                    Busy
                                                                </label>
                                                            @else
                                                                <label class="btn btn-danger{{$hour->status == 0 ? ' active' : ''}} ">
                                                                    <input type="hidden" name="flexible_hours[{{$hour->weekday}}][status]" value="1" />
                                                                    <input type="checkbox"
                                                                           name="flexible_hours[{{$hour->weekday}}][status]"
                                                                           value="0" {{$hour->status == 0 ? 'checked' : ''}}>
                                                                    Busy
                                                                </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('flexible_hours.' . $hour->weekday . '.start'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.' . $hour->weekday . '.start') }}</strong>
                                            </span>
                                                @endif
                                                @if ($errors->has('flexible_hours.' . $hour->weekday . '.end'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.' . $hour->weekday . '.end') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="form-group{{ $errors->has('flexible_hours.1.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.1.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Monday</span>
                                                <input type="hidden" name="flexible_hours[1][day]" value="1"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[1][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.1.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[1][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.1.end') ?? '11:59 PM'}}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.1.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[1][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[1][status]"
                                                                   value="0" {{ (old('flexible_hours.1.status') == '0') ? 'checked' : '' }}>
                                                          Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.1.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.1.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.1.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.1.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.2.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.2.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Tuesday</span>
                                                <input type="hidden" name="flexible_hours[2][day]" value="2"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[2][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.2.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[2][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.2.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.2.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[2][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[2][status]"
                                                                   value="0" {{ (old('flexible_hours.2.status') == '0') ? 'checked' : '' }}>
                                                            Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.2.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.2.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.2.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.2.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.3.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.3.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Wednesday</span>
                                                <input type="hidden" name="flexible_hours[3][day]" value="3"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[3][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.3.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[3][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.3.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.3.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[3][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[3][status]"
                                                                   value="0" {{ (old('flexible_hours.3.status') == '0') ? 'checked' : '' }}>
                                                            Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.3.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.3.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.3.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.3.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.4.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.4.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Thursday</span>
                                                <input type="hidden" name="flexible_hours[4][day]" value="4"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[4][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.4.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[4][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.4.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.4.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[4][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[4][status]"
                                                                   value="0" {{ (old('flexible_hours.4.status') == '0') ? 'checked' : '' }}>
                                                           Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.4.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.4.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.4.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.4.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.5.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.5.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Friday</span>
                                                <input type="hidden" name="flexible_hours[5][day]" value="5"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[5][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.5.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[5][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.5.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.5.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[5][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[5][status]"
                                                                   value="0" {{ (old('flexible_hours.5.status') == '0') ? 'checked' : '' }}>
                                                          Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.5.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.5.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.5.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.5.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.6.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.6.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Saturday</span>
                                                <input type="hidden" name="flexible_hours[6][day]" value="6"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[6][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.6.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[6][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.6.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.6.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[6][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[6][status]"
                                                                   value="0" {{ (old('flexible_hours.6.status') == '0') ? 'checked' : '' }}>
                                                          Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.6.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.6.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.6.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.6.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('flexible_hours.0.start') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.0.end') ? ' has-error' : '' }}">
                                            <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right">Sunday</span>
                                                <input type="hidden" name="flexible_hours[0][day]" value="0"/>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="control-group control-group-3">
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[0][start]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.0.start') ?? '09:00 AM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text" name="flexible_hours[0][end]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.0.end') ?? '11:59 PM' }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                                        <label class="btn btn-danger{{ (old('flexible_hours.0.status') == '0') ? ' active' : '' }}">
                                                            <input type="hidden" name="flexible_hours[0][status]" value="1" />
                                                            <input type="checkbox" name="flexible_hours[0][status]"
                                                                   value="0" {{ (old('flexible_hours.0.status') == '0') ? 'checked' : '' }}>
                                                            Busy
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('flexible_hours.0.start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.0.start') }}</strong>
                                            </span>
                                            @endif
                                            @if ($errors->has('flexible_hours.0.end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.0.end') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
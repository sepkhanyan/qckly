@extends('home', ['title' => 'Restaurant: ' . $restaurant->name_en])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-check"></i>
                    Approve
                </a>
                <a class="btn btn-danger" title=""
                   href="{{ url('restaurant/edit_reject/' . $restaurant->id )}}">
                    <i class="fa fa-ban"></i>
                    Reject
                </a>&nbsp;
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li class="active">
                            <a href="#general" data-toggle="tab">Restaurant</a>
                        </li>
                        <li>
                            <a href="#data" data-toggle="tab">Data</a>
                        </li>
                        <li>
                            <a href="#opening-hours" data-toggle="tab">Working Hours</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8"
                      method="POST" action="{{ url('/restaurant/edit_approve/' . $restaurant->id ) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <h4 class="tab-pane-title">Basic</h4>
                            <div class="form-group">
                                <label for="category" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    <select name="category[]" id="category" class="form-control"
                                            placeholder="Select Categories"
                                            multiple>
                                        @foreach($editingCategoryRestaurants as $editingCategoryRestaurant)
                                            <option
                                                    value="{{$editingCategoryRestaurant->category_id}}"
                                                    @if(old('category')) {{ (collect(old('category'))->contains($editingCategoryRestaurant->category_id)) ? 'selected':'' }} @else selected @endif>{{$editingCategoryRestaurant->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if (count($categoryFullDiff) > 0)
                                    <span class="help-block">
                                            <strong class="text-danger">Edited</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_name_en') ? ' has-error' : '' }}">
                                <label for="input_restaurant_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_name_en" id="input_restaurant_name_en"
                                           class="form-control"
                                           value="{{old('restaurant_name_en') ?? $editingRestaurant->name_en }}"/>
                                </div>
                                @if ($restaurant->name_en != $editingRestaurant->name_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_name_ar') ? ' has-error' : '' }}">
                                <label for="input_restaurant_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_name_ar" id="input_restaurant_name_ar"
                                           class="form-control"
                                           value="{{old('restaurant_name_ar') ?? $editingRestaurant->name_ar }}"/>
                                </div>
                                @if ($restaurant->name_ar != $editingRestaurant->name_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_email') ? ' has-error' : '' }}">
                                <label for="input_restaurant_email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_email" id="input_restaurant_email"
                                           class="form-control"
                                           value="{{old('restaurant_email') ?? $editingRestaurant->email }}"/>
                                </div>
                                @if ($restaurant->email != $editingRestaurant->email)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_telephone') ? ' has-error' : '' }}">
                                <label for="input_restaurant_telephone" class="col-sm-3 control-label">Telephone</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_telephone" id="input_restaurant_telephone"
                                           class="form-control"
                                           value="{{old('restaurant_telephone') ?? $editingRestaurant->telephone }}"/>
                                </div>
                                @if ($restaurant->telephone != $editingRestaurant->telephone)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                <label for="input-country" class="col-sm-3 control-label">City</label>
                                <div class="col-sm-5">
                                    <select name="area[]" id="area" class="form-control" multiple
                                            placeholder="Select Cities">
                                        @foreach($editingRestaurantAreas as $restaurantArea)
                                            <option
                                                    value="{{$restaurantArea->area_id}}"
                                                    @if(old('area')) {{ (collect(old('area'))->contains($restaurantArea->area_id)) ? 'selected':'' }} @else selected @endif>{{$restaurantArea->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if (count($areaFullDiff) > 0)
                                    <span class="help-block">
                                            <strong class="text-danger">Edited</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div id="data" class="tab-pane row wrap-all">
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{old('description_en') ?? $editingRestaurant->description_en }}</textarea>
                                </div>
                                @if ($restaurant->description_en != $editingRestaurant->description_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                                <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="description_ar" id="input_description_ar" class="form-control"
                                              rows="5">{{old('description_ar') ?? $editingRestaurant->description_ar }}</textarea>
                                </div>
                                @if ($restaurant->description_ar != $editingRestaurant->description_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select an image to use as the restaurant logo, this image is displayed in the restaurant list.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            @if(isset($editingRestaurant->image))
                                                <img src="{{url('/') . '/images/' . $editingRestaurant->image}}"
                                                     class="thumb img-responsive" id="thumb">
                                            @else
                                                <img src="{{url('/') . '/admin/no_photo.png'}}"
                                                     class="thumb img-responsive" id="thumb">
                                            @endif
                                        </div>
                                        <div class="caption">
                                            <span class="name text-center"></span>
                                            <p>
                                                <label class=" btn btn-primary btn-file ">
                                                    <i class="fa fa-picture-o"></i>
                                                    Select
                                                    <input type="file" name="image" style="display: none;"
                                                           onchange="readURL(this);" value="{{$restaurant->image}}">
                                                </label>
                                                <label class="btn btn-danger " onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>
                                                    &nbsp;&nbsp;Remove
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                    @if ($editingRestaurant->image)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="opening-hours" class="tab-pane row wrap-all">
                            <div id="opening-type" class="form-group">
                                <label for="" class="col-sm-3 control-label">Opening Type</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        @if(old('opening_type'))
                                            <label class="btn btn-success{{ (old('opening_type') == '24_7') ? ' active' : '' }}"
                                                   id="daily-flexible-hide">
                                                <input type="radio" name="opening_type" id="24_7"
                                                       value="24_7" {{ (old('opening_type') == '24_7') ? 'checked' : '' }}>
                                                24/7
                                            </label>
                                            <label class="btn btn-success{{ (old('opening_type') == 'daily') ? ' active' : '' }}"
                                                   id="opening-daily-show">
                                                <input type="radio" name="opening_type" id="daily"
                                                       value="daily" {{ (old('opening_type') == 'daily') ? 'checked' : '' }}>
                                                Daily
                                            </label>
                                            <label class="btn btn-success{{ (old('opening_type') == 'flexible') ? ' active' : '' }}"
                                                   id="opening-flexible-show">
                                                <input type="radio" name="opening_type" id="flexible"
                                                       value="flexible" {{ (old('opening_type') == 'flexible') ? 'checked' : '' }}>
                                                Flexible
                                            </label>
                                        @elseif($editingWorking->type == '24_7')
                                            <label class="btn btn-success active" id="daily-flexible-hide">
                                                <input type="radio" name="opening_type" value="24_7" checked="checked">
                                                24/7
                                            </label>
                                            <label class="btn btn-success" id="opening-daily-show">
                                                <input type="radio" name="opening_type" value="daily">
                                                Daily
                                            </label>
                                            <label class="btn btn-success" id="opening-flexible-show">
                                                <input type="radio" name="opening_type" value="flexible">
                                                Flexible
                                            </label>
                                        @elseif($editingWorking->type == 'daily')
                                            <label class="btn btn-success " id="daily-flexible-hide">
                                                <input type="radio" name="opening_type" value="24_7">
                                                24/7
                                            </label>
                                            <label class="btn btn-success active" id="opening-daily-show">
                                                <input type="radio" name="opening_type" value="daily" checked="checked">
                                                Daily
                                            </label>
                                            <label class="btn btn-success" id="opening-flexible-show">
                                                <input type="radio" name="opening_type" value="flexible">
                                                Flexible
                                            </label>
                                        @else
                                            <label class="btn btn-success " id="daily-flexible-hide">
                                                <input type="radio" name="opening_type" value="24_7">
                                                24/7
                                            </label>
                                            <label class="btn btn-success " id="opening-daily-show">
                                                <input type="radio" name="opening_type" value="daily">
                                                Daily
                                            </label>
                                            <label class="btn btn-success active" id="opening-flexible-show">
                                                <input type="radio" name="opening_type" value="flexible"
                                                       checked="checked">
                                                Flexible
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="opening-daily" style="display: none;">
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
                                <div class="form-group{{ $errors->has('daily_hours.open') ? ' has-error' : '' }}{{ $errors->has('daily_hours.close') ? ' has-error' : '' }}">
                                    <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                    <div class="col-sm-5">
                                        <div class="control-group control-group-2">
                                            <div class="input-group">
                                                <input id="clock-show" type="text" name="daily_hours[open]"
                                                       class="form-control timepicker"
                                                       value="@if($editingWorking->type == 'daily'){{ old('daily_hours.open') ?? date("g:i A", strtotime($editingWorking->opening_time)) }}@else{{ old('daily_hours.open') ?? '09:00 AM' }}@endif"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="daily_hours[close]"
                                                       class="form-control timepicker"
                                                       value="@if($editingWorking->type == 'daily'){{ old('daily_hours.close') ?? date("g:i A", strtotime($editingWorking->closing_time))   }}@else{{ old('daily_hours.close') ??  '11:59 PM'   }}@endif"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('daily_hours.open'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('daily_hours.open') }}</strong>
                                            </span>
                                    @endif
                                    @if ($errors->has('daily_hours.close'))
                                        <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div id="opening-flexible" style="display: none;">
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
                                @if($editingWorking->type == 'flexible')
                                    @foreach($editingWorkingHours as $working_hour)
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
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group{{ $errors->has('flexible_hours.1.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.1.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Monday</span>
                                            <input type="hidden" name="flexible_hours[1][day]" value="1"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[1][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.1.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[1][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.1.close') ?? '11:59 PM'}}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.1.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[1][status]" value="1"
                                                               {{ (old('flexible_hours.1.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.1.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[1][status]"
                                                               value="0" {{ (old('flexible_hours.1.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.1.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.1.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.1.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.2.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.2.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Tuesday</span>
                                            <input type="hidden" name="flexible_hours[2][day]" value="2"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[2][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.2.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[2][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.2.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.2.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[2][status]" value="1"
                                                               {{ (old('flexible_hours.2.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.2.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[2][status]"
                                                               value="0" {{ (old('flexible_hours.2.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.2.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.2.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.2.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.3.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.3.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Wednesday</span>
                                            <input type="hidden" name="flexible_hours[3][day]" value="3"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[3][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.3.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[3][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.3.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.3.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[3][status]" value="1"
                                                               {{ (old('flexible_hours.3.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.3.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[3][status]"
                                                               value="0" {{ (old('flexible_hours.3.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.3.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.3.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.3.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.4.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.4.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Thursday</span>
                                            <input type="hidden" name="flexible_hours[4][day]" value="4"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[4][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.4.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[4][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.4.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.4.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[4][status]" value="1"
                                                               {{ (old('flexible_hours.4.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.4.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[4][status]"
                                                               value="0" {{ (old('flexible_hours.4.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.4.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.4.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.4.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.5.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.5.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Friday</span>
                                            <input type="hidden" name="flexible_hours[5][day]" value="5"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[5][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.5.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[5][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.5.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.5.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[5][status]" value="1"
                                                               {{ (old('flexible_hours.5.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.5.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[5][status]"
                                                               value="0" {{ (old('flexible_hours.5.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.5.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.5.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.5.close'))
                                            <span class="help-block">
                                               <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.6.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.6.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Saturday</span>
                                            <input type="hidden" name="flexible_hours[6][day]" value="6"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[6][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.6.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[6][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.6.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.6.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[6][status]" value="1"
                                                               {{ (old('flexible_hours.6.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.6.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[6][status]"
                                                               value="0" {{ (old('flexible_hours.6.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.6.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.6.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.6.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('flexible_hours.0.open') ? ' has-error' : '' }}{{ $errors->has('flexible_hours.0.close') ? ' has-error' : '' }}">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Sunday</span>
                                            <input type="hidden" name="flexible_hours[0][day]" value="0"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[0][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.0.open') ?? '12:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[0][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.0.close') ?? '11:59 PM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active{{ (old('flexible_hours.0.status') == '0') ? 'btn btn-success' : '' }}">
                                                        <input type="radio" name="flexible_hours[0][status]" value="1"
                                                               {{ (old('flexible_hours.0.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger{{ (old('flexible_hours.0.status') == '0') ? ' active' : '' }}">
                                                        <input type="radio" name="flexible_hours[0][status]"
                                                               value="0" {{ (old('flexible_hours.0.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('flexible_hours.0.open'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.0.open') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.0.close'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    @if (count($dayFullDiff) > 0 || count($openingFullDiff) > 0 || count($closingFullDiff) > 0 || count($statusFullDiff) > 0)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#thumb')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function removeFile() {
            $('#thumb').attr('src', '/admin/no_photo.png');
            $('input[name=image]').val("");
        }
    </script>
    <script type="text/javascript">
        $('#category').select2();
        $('#area').select2();
    </script>
@endsection
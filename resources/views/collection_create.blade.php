@extends('home', ['title' => 'Collection: New'])
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
                        <li class="active">
                            <a href="#general" data-toggle="tab">
                                Collection Details
                            </a>
                        </li>
                        <li>
                            <a href="#opening-hours" data-toggle="tab">Availability</a>
                        </li>
                        <li>
                            <a href="#menus" data-toggle="tab">Collection Items</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" enctype="multipart/form-data"
                      action="{{ url('/collection/store') }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if($user->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$collection_category->name_en}}</h4>
                            <input type="hidden" name="category" value="{{$collection_category->id}}">
                                {{--<div class="form-group{{ $errors->has('service_type') ? ' has-error' : '' }}">--}}
                                    {{--<label for="service_type" class="col-sm-3 control-label">Service Type</label>--}}
                                    {{--<div class="col-sm-5">--}}
                                        {{--<select name="service_type[]" id="service_type" class="form-control" multiple--}}
                                                {{--placeholder="Select Categories">--}}
                                            {{--@foreach($categoryRestaurants as $categoryRestaurant)--}}
                                                {{--<option value="{{$categoryRestaurant->id}}" {{ (collect(old('service_type'))->contains($categoryRestaurant->id)) ? 'selected':'' }}>{{$categoryRestaurant->name_en}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--@if ($errors->has('service_type'))--}}
                                            {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('service_type') }}</strong>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{ old('name_en') }}">
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name_en') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_ar" id="input_name_ar" class="form-control"
                                           value="{{ old('name_ar') }}">
                                    @if ($errors->has('name_ar'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name_ar') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{ old('description_en') }}</textarea>
                                    @if ($errors->has('description_en'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('description_en') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                                <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="description_ar" id="input_description_ar" class="form-control"
                                              rows="5">{{ old('description_ar') }}</textarea>
                                    @if ($errors->has('description_ar'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('description_ar') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update menu image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            <img src="{{url('/') . '/admin/no_photo.png'}}"
                                                 class="thumb img-responsive" id="thumb">
                                        </div>
                                        <div class="caption">
                                            <span class="name text-center"></span>
                                            <p>
                                                <label class=" btn btn-primary btn-file ">
                                                    <i class="fa fa-picture-o"></i>
                                                    Select
                                                    <input type="file" name="image" style="display: none;"
                                                           onchange="readURL(this);">
                                                </label>
                                                <label class="btn btn-danger " onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>
                                                    &nbsp;&nbsp;Remove
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_mealtime" class="col-sm-3 control-label">Mealtime</label>
                                <div class="col-sm-5">
                                    <select name="mealtime" id="mealtime" class="form-control">
                                        @foreach ($mealtimes as $mealtime)
                                            <option value="{{$mealtime->id}}"{{ old('mealtime') == $mealtime->id ? 'selected':'' }}>{{$mealtime->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="female_caterer_available" class="col-sm-3 control-label">Female Caterer
                                    Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-success active{{ (old('female_caterer_available') == '0') ? 'btn btn-success' : '' }}">
                                            <input type="radio" name="female_caterer_available" value="1"
                                                   {{ (old('female_caterer_available') == '1') ? 'checked' : '' }} checked="checked">
                                            Yes
                                        </label>
                                        <label class="btn btn-danger{{ (old('female_caterer_available') == '0') ? ' active' : '' }}">
                                            <input type="radio" name="female_caterer_available"
                                                   value="0" {{ (old('female_caterer_available') == '0') ? 'checked' : '' }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_en') ? ' has-error' : '' }}">
                                <label for="service_provide_en" class="col-sm-3 control-label">Service Provide
                                    En</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_en" class="form-control"
                                              id="service_provide_en">{{ old('service_provide_en') }}</textarea>
                                    @if ($errors->has('service_provide_en'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('service_provide_en') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_ar') ? ' has-error' : '' }}">
                                <label for="service_provide_ar" class="col-sm-3 control-label">
                                    Service Provide Ar
                                </label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_ar" class="form-control"
                                              id="service_provide_ar">{{ old('service_provide_ar') }}</textarea>
                                    @if ($errors->has('service_provide_ar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('service_provide_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_presentation_en') ? ' has-error' : '' }}">
                                <label for="service_presentation_en" class="col-sm-3 control-label">
                                    Service Presentation En
                                </label>
                                <div class="col-sm-5">
                                    <textarea name="service_presentation_en" class="form-control"
                                              id="service_presentation_en">{{ old('service_presentation_en') }}</textarea>
                                    @if ($errors->has('service_presentation_en'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('service_presentation_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_presentation_ar') ? ' has-error' : '' }}">
                                <label for="service_presentation_ar" class="col-sm-3 control-label">
                                    Service Presentation Ar
                                </label>
                                <div class="col-sm-5">
                                    <textarea name="service_presentation_ar" class="form-control"
                                              id="service_presentation_ar">{{ old('service_presentation_ar') }}</textarea>
                                    @if ($errors->has('service_presentation_ar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('service_presentation_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($collection_category->id != 4)
                                <div class="form-group{{ $errors->has('collection_price') ? ' has-error' : '' }}">
                                    <label for="input-price" class="col-sm-3 control-label">Price</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="collection_price" id="input-price"
                                                   class="form-control" value="{{old('collection_price')}}"/>
                                            <span class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('collection_price'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('collection_price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($collection_category->id != 2)
                                    <div class="form-group{{ $errors->has('min_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection min quantity</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="1" name="min_quantity" class="form-control"
                                                   value="{{old('min_quantity') ?? 1}}">
                                            @if ($errors->has('min_quantity'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('min_quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('max_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection max quantity</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="1" name="max_quantity" class="form-control"
                                                   value="{{old('max_quantity') ?? 1}}">
                                            @if ($errors->has('max_quantity'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('max_quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group{{ $errors->has('min_serve_to_person') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Min serve to person</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" name="min_serve_to_person" class="form-control"
                                               value="{{old('min_serve_to_person') ?? 1}}">
                                        @if ($errors->has('min_serve_to_person'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('min_serve_to_person') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('max_serve_to_person') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Max serve to person</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" name="max_serve_to_person" class="form-control"
                                               value="{{old('max_serve_to_person') ?? 1}}">
                                        @if ($errors->has('max_serve_to_person'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('max_serve_to_person') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            @endif
                            @if($collection_category->id == 2)
                                {{--<div class="form-group{{ $errors->has('persons_max_count') ? ' has-error' : '' }}">--}}
                                {{--<label class="col-sm-3 control-label">Persons max count</label>--}}
                                {{--<div class="col-sm-5">--}}
                                {{--<input type="number" min="1" name="persons_max_count" class="form-control"--}}
                                {{--value="1">--}}
                                {{--@if ($errors->has('persons_max_count'))--}}
                                {{--<span class="help-block">--}}
                                {{--<strong>{{ $errors->first('persons_max_count') }}</strong>--}}
                                {{--</span>--}}
                                {{--@endif--}}

                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Allow Person
                                        Increase</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active{{ (old('allow_person_increase') == '0') ? 'btn btn-success' : '' }}">
                                                <input type="radio" name="allow_person_increase" value="1"
                                                       {{ (old('allow_person_increase') == '1') ? 'checked' : '' }} checked="checked">
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{ (old('allow_person_increase') == '0') ? ' active' : '' }}">
                                                <input type="radio" name="allow_person_increase"
                                                       value="0" {{ (old('allow_person_increase') == '0') ? 'checked' : '' }}>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('setup_time') ? ' has-error' : '' }}">
                                    <label for="input-setup" class="col-sm-3 control-label">
                                        Setup Time
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="number" name="setup_time" id="input-setup"
                                                   class="form-control" min="0" value="{{old('setup_time') ?? 0}}"/>
                                            <span class="input-group-addon">minutes</span>
                                        </div>
                                        @if ($errors->has('setup_time'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('setup_time') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('requirements_en') ? ' has-error' : '' }}">
                                    <label for="input_requirements_en" class="col-sm-3 control-label">Requirements
                                        En</label>
                                    <div class="col-sm-5">
                                            <textarea name="requirements_en" id="input_requirements_en"
                                                      class="form-control">{{ old('requirements_en') }}</textarea>
                                        @if ($errors->has('requirements_en'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('requirements_en') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('requirements_ar') ? ' has-error' : '' }}">
                                    <label for="input_requirements_ar" class="col-sm-3 control-label">Requirements
                                        Ar</label>
                                    <div class="col-sm-5">
                                            <textarea name="requirements_ar" id="input_requirements_ar"
                                                      class="form-control">{{ old('requirements_ar') }}</textarea>
                                        @if ($errors->has('requirements_ar'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('requirements_ar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('max_time') ? ' has-error' : '' }}">
                                    <label for="input-max" class="col-sm-3 control-label">
                                        Max Time
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="number" name="max_time" id="input-max" class="form-control"
                                                   min="0" value="{{old('max_time') ?? 0}}"/>
                                            <span class="input-group-addon">minutes</span>
                                        </div>
                                        @if ($errors->has('max_time'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('max_time') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="opening-hours" class="tab-pane row wrap-all">
                            <div class="form-group">
                                <label for="is_available" class="col-sm-3 control-label">Is Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-success active{{ (old('is_available') == '0') ? 'btn btn-success' : '' }}">
                                            <input type="radio" name="is_available" value="1"
                                                   {{ (old('is_available') == '1') ? 'checked' : '' }} checked="checked">
                                            Yes
                                        </label>
                                        <label class="btn btn-danger{{ (old('is_available') == '0') ? ' active' : '' }}">
                                            <input type="radio" name="is_available"
                                                   value="0" {{ (old('is_available') == '0') ? 'checked' : '' }}>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Availability</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        <label id="available" class="btn btn-default active{{ (old('is_available') == '0') ? 'btn btn-default' : '' }}">
                                            <input type="radio" name="is_available" value="1" {{ (old('is_available') == '1') ? 'checked' : '' }} checked="checked">
                                            Is Available
                                        </label>
                                        <label class="btn btn-default{{ (old('is_available') == '0') ? ' active' : '' }}" id="not_available">
                                            <input type="radio" name="is_available" value="0" {{ (old('is_available') == '0') ? 'checked' : '' }}>
                                            Not Available
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="unavailability_hours">
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Type</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                            <label @if(old('type')) class="btn btn-success{{ (old('type') == '24_7') ? ' active' : '' }}"
                                                   @else class="btn btn-success active" @endif >
                                                <input type="radio" name="type" value="24_7"
                                                       {{ (old('type') == '24_7') ? 'checked' : '' }} checked="checked">
                                                24/7
                                            </label>
                                            <label class="btn btn-success{{ (old('type') == 'daily') ? ' active' : '' }}">
                                                <input type="radio" name="type"
                                                       value="daily" {{ (old('type') == 'daily') ? 'checked' : '' }}>
                                                Daily
                                            </label>
                                            <label class="btn btn-success{{ (old('type') == 'flexible') ? ' active' : '' }}">
                                                <input type="radio" name="type"
                                                       value="flexible" {{ (old('type') == 'flexible') ? 'checked' : '' }}>
                                                Flexible
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="daily" style="display: none;">
                                    <div class="form-group">
                                        <label for="input-days" class="col-sm-3 control-label">Days</label>
                                        <div class="col-sm-5{{ $errors->has('days') ? ' has-error' : '' }}">
                                            <div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(1)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif >
                                                    <input type="checkbox" name="days[]" id="mon" value="1"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(1)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Mon
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(2)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="tue" value="2"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(2)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Tue
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(3)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="wed" value="3"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(3)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Wed
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(4)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="thu" value="4"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(4)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Thu
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(5)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="fri" value="5"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(5)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Fri
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(6)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="sat" value="6"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(6)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Sat
                                                </label>
                                                <label @if(old('days'))  class="btn btn-default{{ (collect(old('days'))->contains(0)) ? ' active':'' }}"
                                                       @else class="btn btn-default active" @endif>
                                                    <input type="checkbox" name="days[]" id="sun" value="0"
                                                           @if(old('days'))   {{ (collect(old('days'))->contains(0)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Sun
                                                </label>
                                            </div>
                                            @if ($errors->has('days'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('days') }}</strong>
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
                                                           value="{{ old('daily_hours.start') ??  '09:00 AM' }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="daily_hours[end]"
                                                           class="form-control timepicker"
                                                           value="{{ old('daily_hours.end') ?? '11:59 PM' }}"/>
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
                                                <strong>End time must be after start time.</strong>
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
                                                           value="{{ old('flexible_hours.1.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.1.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.1.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.1.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.2.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.2.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.2.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.2.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.3.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.3.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.3.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.3.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.4.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.4.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.4.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.4.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.5.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.5.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.5.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.5.end'))
                                            <span class="help-block">
                                               <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.6.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.6.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.6.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.6.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
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
                                                           value="{{ old('flexible_hours.0.start') ?? '12:00 AM' }}"/>
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
                                        @if ($errors->has('flexible_hours.0.start'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('flexible_hours.0.start') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('flexible_hours.0.end'))
                                            <span class="help-block">
                                                <strong>Close hour must be after open hour.</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menus"
                             class="tab-pane row wrap-all{{ $errors->has('menu_item') ? ' has-error' : '' }}">
                            @if($collection_category->id == 2 || $collection_category->id == 3)
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <div class="control-group control-group-2">
                                            <div class="input-group" style="font-size: medium">
                                                <b>Menu min quantity</b>
                                            </div>
                                            <div class="input-group" style="font-size: medium">
                                                <b>Menu max quantity</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach($menu_categories as $menu_category)
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right"
                                                      style="font-size: large">{{$menu_category->name_en}}</span>
                                        @if($collection_category->id != 1)
                                            <input type="hidden" name="menu[{{$menu_category->id}}][id]"
                                                   value="{{$menu_category->id}}">
                                        @endif
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            @if($collection_category->id == 2 || $collection_category->id == 3)
                                                <div class="input-group">
                                                    <input type="number"
                                                           name="menu[{{$menu_category->id}}][min_qty]"
                                                           class="form-control" min="1"
                                                           value="{{old('menu.' . $menu_category->id . '.min_qty') ?? 1}}">
                                                </div>
                                                <div class="input-group">
                                                    <input type="number"
                                                           name="menu[{{$menu_category->id}}][max_qty]"
                                                           class="form-control" min="1"
                                                           value="{{old('menu.' . $menu_category->id . '.max_qty') ?? 1}}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($collection_category->id == 1)
                                    @foreach($menu_category->menu as $menu)
                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label"></label>
                                            <div class="col-xs-3">
                                                <div class="checkbox" id="{{$menu->id}}">
                                                    <label style="font-size: medium">
                                                        <input id="item{{$menu->id}}" type="checkbox"
                                                               name="menu_item[{{$menu->id}}][id]"
                                                               value="{{$menu->id}}"
                                                               {{ (collect(old('menu_item.' . $menu->id . '.id'))->contains($menu->id)) ? 'checked':'' }} onclick="myFunction('{{$menu->id}}')">{{$menu->name_en}}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xs-5">
                                                <div class="control-group control-group-3">
                                                    <div class="col-xs-2">
                                                        <input type="number"
                                                               name="menu_item[{{$menu->id}}][qty]"
                                                               id="qty{{$menu->id}}"
                                                               style="display: none{{ (collect(old('menu_item.' . $menu->id . '.id'))->contains($menu->id)) ? 'block':'' }}"
                                                               {{(!old('menu_item.' . $menu->id . '.id')) ? 'disabled': '' }}
                                                               class="form-control" min="1"
                                                               value="{{old('menu_item.' . $menu->id . '.qty') ?? 1}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-xs-3">
                                            <select id="items{{$menu_category->id}}" name="menu_item[]"
                                                    class="form-control" multiple
                                                    placeholder="Select Items">
                                                @foreach($menu_category->menu as $menu)
                                                    <option value="{{$menu->id}}" {{ (collect(old('menu_item'))->contains($menu->id)) ? 'selected':'' }}>{{$menu->name_en}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var id = '<?php echo $menu_category->id; ?>';
                                            $('#items' + id).select2();
                                        });
                                    </script>
                                @endif
                            @endforeach
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"></label>
                                <div class="col-xs-3">
                                    @if ($errors->has('menu_item'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('menu_item') }}</strong>
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
    <script>
        function myFunction(id) {
            console.log(id);
            var item = document.getElementById("item" + id);
            if (item.checked == true) {
                $('#qty' + id).slideDown('fast');
                $('#qty' + id).removeAttr('disabled');
            } else {
                $('#qty' + id).slideUp('fast');
                $('#qty' + id).attr('disabled', true);
            }
        }
    </script>
    <script type="text/javascript">
        $('#service_type').select2();
    </script>
@endsection
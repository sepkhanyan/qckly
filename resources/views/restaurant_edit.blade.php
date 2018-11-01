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
                      method="POST" action="{{ url('/restaurant/update/' . $restaurant->id ) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <h4 class="tab-pane-title">Basic</h4>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="category" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    <select name="category[]" class="form-control" multiple>
                                        @foreach($category_restaurants as $category_restaurant)
                                            <option selected
                                                    value="{{$category_restaurant->category_id}}">{{$category_restaurant->name_en}}</option>
                                        @endforeach
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_name_en') ? ' has-error' : '' }}">
                                <label for="input_restaurant_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_name_en" id="input_restaurant_name_en"
                                           class="form-control" value="{{ $restaurant->name_en }}"/>
                                    @if ($errors->has('restaurant_name_en'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('restaurant_name_en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_name_ar') ? ' has-error' : '' }}">
                                <label for="input_restaurant_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_name_ar" id="input_restaurant_name_ar"
                                           class="form-control" value="{{ $restaurant->name_ar }}"/>
                                    @if ($errors->has('restaurant_name_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('restaurant_name_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_email') ? ' has-error' : '' }}">
                                <label for="input_restaurant_email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_email" id="input_restaurant_email"
                                           class="form-control" value="{{ $restaurant->email }}"/>
                                    @if ($errors->has('restaurant_email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('restaurant_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('restaurant_telephone') ? ' has-error' : '' }}">
                                <label for="input_restaurant_telephone" class="col-sm-3 control-label">Telephone</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_telephone" id="input_restaurant_telephone"
                                           class="form-control" value="{{ $restaurant->telephone }}"/>
                                    @if ($errors->has('restaurant_telephone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('restaurant_telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <h4 class="tab-pane-title">Address</h4>
                            <div class="form-group{{ $errors->has('address_en') ? ' has-error' : '' }}">
                                <label for="input_address_en" class="col-sm-3 control-label">Address En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="address_en" id="input_address_en" class="form-control"
                                           value="{{ $restaurant->address_en }}"/>
                                    @if ($errors->has('address_en'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_en') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('address_ar') ? ' has-error' : '' }}">
                                <label for="input_address_ar" class="col-sm-3 control-label">Address Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="address_ar" id="input_address_en" class="form-control"
                                           value="{{ $restaurant->address_ar }}"/>
                                    @if ($errors->has('address_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_state_en" class="col-sm-3 control-label">State En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="state_en" id="input_state_en" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_state_ar" class="col-sm-3 control-label">State Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="state_ar" id="input_state_ar" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label for="input-postcode" class="col-sm-3 control-label">Postcode</label>
                                <div class="col-sm-5">
                                    <input type="text" name="postcode" id="input-postcode" class="form-control"
                                           value="{{ $restaurant->postcode }}"/>
                                    @if ($errors->has('postcode'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-country" class="col-sm-3 control-label">City</label>
                                <div class="col-sm-5">
                                    <select name="country" id="input-country" class="form-control">
                                        <option value="{{$restaurant->area_id}}">{{$restaurant->area->name_en}}</option>
                                        @foreach($areas as $area)
                                            @if($restaurant->area_id != $area->id)
                                                <option value="{{$area->id}}">{{$area->name_en}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">Automatically fetch lat/lng</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">--}}
                            {{--<label id="lat-lng-yes" class="btn btn-default active">--}}
                            {{--<input type="radio" name="auto_lat_lng" value="1" checked="checked">--}}
                            {{--YES--}}
                            {{--</label>--}}
                            {{--<label class="btn btn-default" id="lat-lng-no">--}}
                            {{--<input type="radio" name="auto_lat_lng" value="0">--}}
                            {{--NO--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<br/>--}}

                            <div id="lat-lng">
                                <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                    <label for="lat" class="col-sm-3 control-label">Latitude</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="latitude" id="lat"
                                               class="form-control" value="{{ $restaurant->latitude}}"/>
                                        @if ($errors->has('latitude'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                    <label for="long"
                                           class="col-sm-3 control-label">Longitude</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="longitude" id="long"
                                               class="form-control" value="{{ $restaurant->longitude}}"/>
                                        @if ($errors->has('longitude'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lat" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <div id="map"></div>
                                    </div>
                                </div>
                                <script async defer
                                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAU2aEUn440lIbc-dt9swUPO-jB0HMmCl8&callback=initMap">
                                </script>
                            </div>
                        </div>

                        <div id="data" class="tab-pane row wrap-all">
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{ $restaurant->description_en }}</textarea>
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
                                              rows="5">{{ $restaurant->description_ar }}</textarea>
                                    @if ($errors->has('description_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">Image--}}
                            {{--<span class="help-block">Select an image to use as the location logo, this image is displayed in the restaurant list.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="thumbnail imagebox" id="selectImage">--}}
                            {{--<div class="preview">--}}
                            {{--<img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png"--}}
                            {{--class="thumb img-responsive" id="thumb">--}}
                            {{--</div>--}}
                            {{--<div class="caption">--}}
                            {{--<span class="name text-center"></span>--}}
                            {{--<input type="hidden" name="location_image" value="" id="field">--}}
                            {{--<input type="file" name="image" class="form-control">--}}
                            {{--<p>--}}
                            {{--<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>--}}
                            {{--<a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>--}}
                            {{--</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select an image to use as the restaurant logo, this image is displayed in the restaurant list.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            @if(isset($restaurant->image))
                                                <img src="{{url('/') . '/images/' . $restaurant->image}}"
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
                                                           onchange="readURL(this);">
                                                </label>
                                                <label class="btn btn-danger " onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>
                                                    &nbsp;&nbsp;Remove
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="opening-hours" class="tab-pane row wrap-all">
                            <div id="opening-type" class="form-group">
                                <label for="" class="col-sm-3 control-label">Opening Type</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        @if($working->type == '24_7')
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
                                        @elseif($working->type == 'daily')
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
                                    <label for="input-opening-days" class="col-sm-3 control-label">Days</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="1" checked="checked">
                                                Mon
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="2" checked="checked">
                                                Tue
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="3" checked="checked">
                                                Wed
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="4" checked="checked">
                                                Thu
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="5" checked="checked">
                                                Fri
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="6" checked="checked">
                                                Sat
                                            </label>
                                            <label class="btn btn-default active">
                                                <input type="checkbox" name="daily_days[]" value="0" checked="checked">
                                                Sun
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                    <div class="col-sm-5">
                                        <div class="control-group control-group-2">
                                            <div class="input-group">
                                                <input id="clock-show" type="text" name="daily_hours[open]"
                                                       class="form-control timepicker" value="11:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="daily_hours[close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
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
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Monday</span>
                                        <input type="hidden" name="flexible_hours[1][day]" value="1"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[1][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[1][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[1][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[1][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Tuesday</span>
                                        <input type="hidden" name="flexible_hours[2][day]" value="2"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[2][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[2][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[2][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[2][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Wednesday</span>
                                        <input type="hidden" name="flexible_hours[3][day]" value="3"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[3][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[3][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[3][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[3][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Thursday</span>
                                        <input type="hidden" name="flexible_hours[4][day]" value="4"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[4][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[4][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[4][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[4][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Friday</span>
                                        <input type="hidden" name="flexible_hours[5][day]" value="5"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[5][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[5][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[5][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[5][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Saturday</span>
                                        <input type="hidden" name="flexible_hours[6][day]" value="6"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[6][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[6][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[6][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[6][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label text-right">
                                        <span class="text-right">Sunday</span>
                                        <input type="hidden" name="flexible_hours[0][day]" value="0"/>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="control-group control-group-3">
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[0][open]"
                                                       class="form-control timepicker" value="12:00 AM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="input-group">
                                                <input type="text" name="flexible_hours[0][close]"
                                                       class="form-control timepicker" value="11:59 PM"/>
                                                <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                            </div>
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success active">
                                                    <input type="radio" name="flexible_hours[0][status]" value="1"
                                                           checked="checked">
                                                    Open
                                                </label>
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="flexible_hours[0][status]" value="0">
                                                    Closed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var map;
        var markers = [];
        var lat = parseFloat(document.getElementById('lat').value);
        var lng = parseFloat(document.getElementById('long').value);

        function initMap() {
            var haightAshbury = {lat: lat, lng: lng};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                overviewMapControl: true,
                rotateControl: true,
                center: haightAshbury,
                mapTypeId: 'terrain'
            });

            map.addListener('click', function (event) {
                if (markers.length >= 1) {
                    deleteMarkers();
                }

                addMarker(event.latLng);
                document.getElementById('lat').value = event.latLng.lat();
                document.getElementById('long').value = event.latLng.lng();
            });
        }

        function addMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }


        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }


        function clearMarkers() {
            setMapOnAll(null);
        }


        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

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
        }
    </script>
@endsection
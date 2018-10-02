@extends('home', ['title' => 'Restaurant: New'])
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
                            <a href="#general" data-toggle="tab">Manager</a>
                        </li>
                        <li>
                            <a href="#location" data-toggle="tab">Restaurant</a>
                        </li>
                        <li>
                            <a href="#data" data-toggle="tab">Data</a>
                        </li>
                        <li>
                            <a href="#opening-hours" data-toggle="tab">Working Hours</a>
                        </li>
                        {{--<li>--}}
                        {{--<a href="#order" data-toggle="tab">Order</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#reservation" data-toggle="tab">Reservation</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a id="open-map" href="#delivery" data-toggle="tab" >Delivery</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#gallery" data-toggle="tab">Gallery</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
                <form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8"
                      method="POST" action="{{ url('/restaurant/store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <div class="form-group{{ $errors->has('manager_name') ? ' has-error' : '' }}">
                                <label for="input_manager_name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" name="manager_name" id="input_manager_name" class="form-control"
                                           value="{{ old('manager_name') }}"/>
                                    @if ($errors->has('manager_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('manager_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('manager_email') ? ' has-error' : '' }}">
                                <label for="input_manager_email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="manager_email" id="input_manager_email"
                                           class="form-control" value="{{ old('manager_email') }}"/>
                                    @if ($errors->has('manager_email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('manager_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('manager_username') ? ' has-error' : '' }}">
                                <label for="input_manager_username" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" name="manager_username" id="input_manager_username"
                                           class="form-control" value="{{ old('manager_username') }}"/>
                                    @if ($errors->has('manager_username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('manager_username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="input_password" class="col-sm-3 control-label">
                                    Password
                                </label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" id="input_password" class="form-control"
                                           value="" autocomplete="off"/>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-sm-3 control-label">Confirm Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password_confirmation" id="password-confirm"
                                           class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                        <div id="location" class="tab-pane row wrap-all">
                            <h4 class="tab-pane-title">Basic</h4>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    @foreach($categories as $category)
                                        <label class="container">
                                            {{$category->name_en}}
                                            <input type="checkbox" name="category[]" value="{{$category->id}}">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endforeach
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
                                           class="form-control" value="{{ old('restaurant_name_en') }}"/>
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
                                           class="form-control" value="{{ old('restaurant_name_ar') }}"/>
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
                                           class="form-control" value="{{ old('restaurant_email') }}"/>
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
                                           class="form-control" value="{{ old('restaurant_telephone') }}"/>
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
                                           value="{{ old('address_en') }}"/>
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
                                    <input type="text" name="address_ar" id="input_address_ar" class="form-control"
                                           value="{{ old('address_ar') }}"/>
                                    @if ($errors->has('address_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="form-group{{ $errors->has('city_en') ? ' has-error' : '' }}">--}}
                            {{--<label for="input_city_en" class="col-sm-3 control-label">City En</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<input type="text" name="city_en" id="input_city_en" class="form-control"--}}
                            {{--value="{{ old('city_en') }}"/>--}}
                            {{--@if ($errors->has('city_en'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('city_en') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group{{ $errors->has('city_ar') ? ' has-error' : '' }}">--}}
                            {{--<label for="input_city_ar" class="col-sm-3 control-label">City Ar</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<input type="text" name="city_ar" id="input_city_ar" class="form-control"--}}
                            {{--value="{{ old('city_ar') }}"/>--}}
                            {{--@if ($errors->has('city_ar'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('city_ar') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
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
                                           value="{{ old('postcode') }}"/>
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
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}">{{$area->area_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Automatically fetch lat/lng</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        <label id="lat-lng-yes" class="btn btn-default active">
                                            <input type="radio" name="auto_lat_lng" value="1" checked="checked">
                                            YES
                                        </label>
                                        <label class="btn btn-default" id="lat-lng-no">
                                            <input type="radio" name="auto_lat_lng" value="0">
                                            NO
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div id="map"></div>
                            {{--<div>--}}
                            {{--<div id="map" style="width:500px;height:500px;background:yellow"></div>--}}
                            {{--<script type="text/javascript">--}}
                            {{--function myMap() {--}}
                            {{--var mapOptions = {--}}
                            {{--center: new google.maps.LatLng(51.5, -0.12),--}}
                            {{--zoom: 10,--}}
                            {{--mapTypeId: google.maps.MapTypeId.HYBRID--}}
                            {{--}--}}
                            {{--var map = new google.maps.Map(document.getElementById("map"), mapOptions);--}}

                            {{--}--}}
                            {{--</script>--}}
                            {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf3Mvs_VUn36k8PLKIaSKY9QW17cg_18k&callback=myMap"></script>--}}
                            {{--</div>--}}

                            <div id="lat-lng" style="display: none;">
                                <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                    <label for="input-address-latitude" class="col-sm-3 control-label">Latitude</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="latitude" id="input-address-latitude"
                                               class="form-control" value="{{ old('latitude') }}"/>
                                        @if ($errors->has('latitude'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                    <label for="input-address-longitude"
                                           class="col-sm-3 control-label">Longitude</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="longitude" id="input-address-longitude"
                                               class="form-control" value="{{ old('longitude') }}"/>
                                        @if ($errors->has('longitude'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="data" class="tab-pane row wrap-all">
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
                            {{--<div class="form-group">--}}
                            {{--<label for="input-slug" class="col-sm-3 control-label">--}}
                            {{--Permalink Slug--}}
                            {{--<span class="help-block">Use ONLY alpha-numeric lowercase characters, underscores or dashes and make sure it is unique GLOBALLY.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="input-group">--}}
                            {{--<span class="input-group-addon text-sm">https://demo.tastyigniter.com/local/</span>--}}
                            {{--<input type="hidden" name="permalink[permalink_id]" value="0"/>--}}
                            {{--<input type="text" name="permalink[slug]" id="input-slug" class="form-control" value=""/>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Image
                                    <span class="help-block">Select an image to use as the location logo, this image is displayed in the restaurant list.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox" id="selectImage">
                                        <div class="preview">
                                            <img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png"
                                                 class="thumb img-responsive" id="thumb">
                                        </div>
                                        <div class="caption">
                                            <span class="name text-center"></span>
                                            {{--<input type="hidden" name="location_image" value="" id="field">--}}
                                            <input type="file" name="image" class="form-control">
                                            {{--<p>
                                                <a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
                                                <a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>
                                            </p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="input-status" class="col-sm-3 control-label">Status</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="btn-group btn-group-switch" data-toggle="buttons">--}}
                            {{--<label class="btn btn-danger">--}}
                            {{--<input type="radio" name="status" value="0">--}}
                            {{--Disabled--}}
                            {{--</label>--}}
                            {{--<label class="btn btn-success active">--}}
                            {{--<input type="radio" name="status" value="1" checked="checked">--}}
                            {{--Enabled--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>

                        <div id="opening-hours" class="tab-pane row wrap-all">
                            <div id="opening-type" class="form-group">
                                <label for="" class="col-sm-3 control-label">Working Type</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
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
    <script>
        $('input[name=\'table\']').select2({
            placeholder: 'Start typing...',
            minimumInputLength: 2,
            ajax: {
                url: 'https://demo.tastyigniter.com/admin/tables/autocomplete',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) {
                    return {
                        term: term, //search term
                        page_limit: 10 // page size
                    };
                },
                results: function (data, page, query) {
                    return {results: data.results};
                }
            }
        });

        $('input[name=\'table\']').on('select2-selecting', function (e) {
            $('#table-box' + e.choice.id).remove();
            $('#table-box table tbody').append('<tr id="table-box' + e.choice.id + '"><td class="name">' + e.choice.text + '</td><td>' + e.choice.min + '</td><td>' + e.choice.max + '</td><td class="img">' + '<a class="btn btn-danger btn-xs" onclick="confirm(\'This cannot be undone! Are you sure you want to do this?\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="tables[]" value="' + e.choice.id + '" /></td></tr>');
        });
    </script>
    <script type="text/javascript">

        $(function () {
            $('.table-sortable').sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                placeholder: '<tr class="placeholder"><td colspan="5"></td></tr>',
                handle: '.handle'
            })
        });

        var gallery_image_row = 1;

        function addImageToGallery(image_row = null) {
            var height = (this.window.innerHeight > 0) ? this.window.innerHeight - 100 : this.screen.height - 100;
            $(window).bind("load resize", function () {
                var height = (this.window.innerHeight > 0) ? this.window.innerHeight - 100 : this.screen.height - 100;
                $('#media-manager > iframe').css("height", (height) + "px");
            });

            if (null == image_row) {
                image_row = gallery_image_row;

                html = '<tr id="gallery-image' + image_row + '">';
                html += '	<td class="action action-one"><i class="fa fa-sort handle"></i>&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" onclick="confirm(\'This cannot be undone! Are you sure you want to do this?\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
                html += '	<td><img src="" class="image-thumb img-responsive" />'
                    + '<input type="hidden" id="image-thumb' + image_row + '" name="gallery[images][' + image_row + '][path]" value=""></td>';
                html += '	<td><span class="name"></span><input type="hidden" class="image-name" id="image-name' + image_row + '" name="gallery[images][' + image_row + '][name]" value=""></td>';
                html += '	<td><input type="text" name="gallery[images][' + image_row + '][alt_text]" class="form-control" value="" /></td>';
                html += '	<td class="text-center"><div class="btn-group btn-group-switch" data-toggle="buttons">';
                html += '		<label class="btn btn-default active"><input type="radio" name="gallery[images][' + image_row + '][status]" checked="checked"value="0">Included</label>';
                html += '		<label class="btn btn-danger"><input type="radio" name="gallery[images][' + image_row + '][status]" value="1">Excluded</label>';
                html += '	</div></td>';
                html += '</tr>';

                $('#gallery-images .table-sortable tbody').append(html);
                $('#gallery-image' + image_row + ' select.form-control').select2();

                gallery_image_row++;
            }

            var field = 'image-thumb' + image_row;
            $('#media-manager').remove();
            // var iframe_url = js_site_url('image_manager?popup=iframe&field_id=' + field);
            var iframe_url = 'https://demo.tastyigniter.com/admin/image_manager?popup=iframe&field_id=field&sub_folder= '
            $('body').append('<div id="media-manager" class="modal" tabindex="-1" data-parent="note-editor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
                + '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">'
                + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
                + '<h4 class="modal-title">Image Manager</h4>'
                + '</div><div class="modal-body wrap-none">'
                + '<iframe name="media_manager" src="' + iframe_url + '" width="100%" height="' + height + 'px" frameborder="0"></iframe>'
                + '</div></div></div></div>');

            $('#media-manager').modal('show');

            $('#media-manager').on('hide.bs.modal', function (e) {
                if ($('#' + field).attr('value')) {
                    $.ajax({
                        url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=120&height=120',
                        dataType: 'json',
                        success: function (json) {
                            var parent = $('#' + field).parent().parent();
                            parent.find('.image-thumb').attr('src', json);
                            parent.find('.image-name').attr('value', parent.find('.name').html());
                        }
                    });
                }
            });
        }
    </script>
    <div id="media-manager" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Image Manager</h4>
                </div>
                <div class="modal-body wrap-none">
                    {{--<iframe name="media_manager" src="qckly.loc/image_manager?popup=iframe&field_id=field&sub_folder=" width="100%" height="241px" frameborder="0"></iframe>--}}
                </div>

            </div>
        </div>
    </div>
@endsection
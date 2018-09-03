@extends('home')
@section('content')
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
            <a href="{{ url('/restaurants') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="row wrap-vertical">
                <ul id="nav-tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#general" data-toggle="tab" >Location</a>
                    </li>
                    <li>
                        <a href="#data" data-toggle="tab" >Data</a>
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
            <form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{ url('/restaurant/update/' . $restaurant->id ) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <h4 class="tab-pane-title">Basic</h4>
                        <div class="form-group">
                            <label for="restaurant_category" class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-5">
                                <select name="category[]" id="category[]" class="form-control" tabindex="-1" multiple="multiple">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="input-name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ $restaurant->name }}" />
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="input-email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-5">
                                <input type="text" name="email" id="input-email" class="form-control" value="{{ $restaurant->email }}" />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                            <label for="input-telephone" class="col-sm-3 control-label">Telephone</label>
                            <div class="col-sm-5">
                                <input type="text" name="telephone" id="input-telephone" class="form-control" value="{{ $restaurant->telephone }}" />
                                @if ($errors->has('telephone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h4 class="tab-pane-title">Address</h4>
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="input-address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-5">
                                <input type="text" name="address" id="input-address" class="form-control" value="{{ $restaurant->address }}" />
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="input-city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-5">
                                <input type="text" name="city" id="input-city" class="form-control" value=" {{ $restaurant->city }}" />
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-state" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-5">
                                <input type="text" name="state" id="input-state" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                            <label for="input-postcode" class="col-sm-3 control-label">Postcode</label>
                            <div class="col-sm-5">
                                <input type="text" name="postcode" id="input-postcode" class="form-control" value="{{ $restaurant->postcode }}" />
                                @if ($errors->has('postcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-country" class="col-sm-3 control-label">Country</label>
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
                                        <input type="radio" name="auto_lat_lng" value="1"  checked="checked">
                                        YES
                                    </label>
                                    <label class="btn btn-default" id="lat-lng-no">
                                        <input type="radio" name="auto_lat_lng" value="0" >
                                        NO
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div id="lat-lng" style="display: none;">
                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                <label for="input-address-latitude" class="col-sm-3 control-label">Latitude</label>
                                <div class="col-sm-5">
                                    <input type="text" name="latitude" id="input-address-latitude" class="form-control" value="{{ $restaurant->latitude}}" />
                                    @if ($errors->has('latitude'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                <label for="input-address-longitude" class="col-sm-3 control-label">Longitude</label>
                                <div class="col-sm-5">
                                    <input type="text" name="longitude" id="input-address-longitude" class="form-control" value="{{ $restaurant->longitude}}" />
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
                        <div class="form-group{{ $errors->has('description]') ? ' has-error' : '' }}">
                            <label for="input-description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-5">
                                <textarea name="description" id="input-description" class="form-control" rows="5">{{ $restaurant->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-slug" class="col-sm-3 control-label">
                                Permalink Slug
                                <span class="help-block">Use ONLY alpha-numeric lowercase characters, underscores or dashes and make sure it is unique GLOBALLY.</span>
                            </label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon text-sm">https://demo.tastyigniter.com/local/</span>
                                    <input type="hidden" name="permalink[permalink_id]" value="0"/>
                                    <input type="text" name="permalink[slug]" id="input-slug" class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Image
                                <span class="help-block">Select an image to use as the location logo, this image is displayed in the restaurant list.</span>
                            </label>
                            <div class="col-sm-5">
                                <div class="thumbnail imagebox" id="selectImage">
                                    <div class="preview">
                                        <img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png" class="thumb img-responsive" id="thumb">
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
                            </div>-
                        </div>
                        <div class="form-group">
                            <label for="input-status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-danger">
                                        <input type="radio" name="status" value="0" >
                                        Disabled
                                    </label>
                                    <label class="btn btn-success active">
                                        <input type="radio" name="status" value="1"  checked="checked">
                                        Enabled
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="opening-hours" class="tab-pane row wrap-all">
                        <div id="opening-type" class="form-group">
                            <label for="" class="col-sm-3 control-label">Opening Type</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                    <label class="btn btn-success active" id="daily-flexible-hide">
                                        <input type="radio" name="opening_type" value="24_7"  checked="checked">
                                        24/7
                                    </label>
                                    <label class="btn btn-success" id="opening-daily-show">
                                        <input type="radio" name="opening_type" value="daily" >
                                        Daily
                                    </label>
                                    <label class="btn btn-success" id="opening-flexible-show">
                                        <input type="radio" name="opening_type" value="flexible" >
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
                                            <input type="checkbox" name="daily_days[]" value="1"  checked="checked">
                                            Mon
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="2"  checked="checked">
                                            Tue
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="3"  checked="checked">
                                            Wed
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="4"  checked="checked">
                                            Thu
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="5"  checked="checked">
                                            Fri
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="6"  checked="checked">
                                            Sat
                                        </label>
                                        <label class="btn btn-default active">
                                            <input type="checkbox" name="daily_days[]" value="0"  checked="checked">
                                            Sun
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                <div class="col-sm-5">
                                    <div class="control-group control-group-2">
                                        <div class="input-group" >
                                            <input id="clock-show" type="text" name="daily_hours[open]" class="form-control timepicker" value="11:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="daily_hours[close]" class="form-control timepicker" value="11:59 PM" />
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
                                    <input type="hidden" name="flexible_hours[1][day]" value="1" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[1][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[1][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[1][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[1][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Tuesday</span>
                                    <input type="hidden" name="flexible_hours[2][day]" value="2" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[2][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[2][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[2][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[2][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Wednesday</span>
                                    <input type="hidden" name="flexible_hours[3][day]" value="3" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[3][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[3][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[3][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[3][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Thursday</span>
                                    <input type="hidden" name="flexible_hours[4][day]" value="4" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[4][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[4][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[4][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[4][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Friday</span>
                                    <input type="hidden" name="flexible_hours[5][day]" value="5" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[5][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[5][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[5][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[5][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Saturday</span>
                                    <input type="hidden" name="flexible_hours[6][day]" value="6" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[6][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[6][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[6][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[6][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label text-right">
                                    <span class="text-right">Sunday</span>
                                    <input type="hidden" name="flexible_hours[0][day]" value="0" />
                                </label>
                                <div class="col-sm-7">
                                    <div class="control-group control-group-3">
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[0][open]" class="form-control timepicker" value="12:00 AM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="flexible_hours[0][close]" class="form-control timepicker" value="11:59 PM" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-success active">
                                                <input type="radio" name="flexible_hours[0][status]" value="1"  checked="checked">
                                                Open
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="flexible_hours[0][status]" value="0" >
                                                Closed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="female_caterer_available" class="col-sm-3 control-label">Female Caterer Available</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-danger active">
                                        <input type="radio" name="female_caterer_available" value="0"  checked="checked">
                                        NO
                                    </label>
                                    <label class="btn btn-success">
                                        <input type="radio" name="female_caterer_available" value="1" >
                                        YES
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{--<hr>--}}

                        {{--<div id="delivery-type" class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">Delivery Hours</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-default active" id="delivery-hours-daily-hide">--}}
                                        {{--<input type="radio" name="delivery_type" value="0"  checked="checked">--}}
                                        {{--Same As Opening--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-default" id="delivery-hours-daily-show">--}}
                                        {{--<input type="radio" name="delivery_type" value="1" >--}}
                                        {{--Custom--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div id="delivery-hours-daily" style="display: none;">--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-delivery-days" class="col-sm-3 control-label">Days</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="0"  checked="checked">--}}
                                            {{--Mon--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="1"  checked="checked">--}}
                                            {{--Tue--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="2"  checked="checked">--}}
                                            {{--Wed--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="3"  checked="checked">--}}
                                            {{--Thu--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="4"  checked="checked">--}}
                                            {{--Fri--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="5"  checked="checked">--}}
                                            {{--Sat--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="delivery_days[]" value="6"  checked="checked">--}}
                                            {{--Sun--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-delivery-hours" class="col-sm-3 control-label">Hours</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="control-group control-group-2">--}}
                                        {{--<div class="input-group">--}}
                                            {{--<input type="text" name="delivery_hours[open]" class="form-control timepicker" value="12:00 AM" />--}}
                                            {{--<span class="input-group-addon">--}}
                                                {{--<i class="fa fa-clock-o"></i>--}}
                                            {{--</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<input type="text" name="delivery_hours[close]" class="form-control timepicker" value="11:59 PM" />--}}
                                            {{--<span class="input-group-addon">--}}
                                                {{--<i class="fa fa-clock-o"></i>--}}
                                            {{--</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<hr>--}}

                        {{--<div id="collection-type" class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">Pick-up Hours</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-default active" id="collection-hours-daily-hide">--}}
                                        {{--<input type="radio" name="collection_type" value="0"  checked="checked">--}}
                                        {{--Same As Opening--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-default" id="collection-hours-daily-show">--}}
                                        {{--<input type="radio" name="collection_type" value="1" >--}}
                                        {{--Custom--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div id="collection-hours-daily" style="display: none;">--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-collection-days" class="col-sm-3 control-label">Days</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="0"  checked="checked">--}}
                                            {{--Mon--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="1"  checked="checked">--}}
                                            {{--Tue--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="2"  checked="checked">--}}
                                            {{--Wed--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="3"  checked="checked">--}}
                                            {{--Thu--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="4"  checked="checked">--}}
                                            {{--Fri--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="5"  checked="checked">--}}
                                            {{--Sat--}}
                                        {{--</label>--}}
                                        {{--<label class="btn btn-default active">--}}
                                            {{--<input type="checkbox" name="collection_days[]" value="6"  checked="checked">--}}
                                            {{--Sun--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-collection-hours" class="col-sm-3 control-label">Hours</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="control-group control-group-2">--}}
                                        {{--<div class="input-group">--}}
                                            {{--<input type="text" name="collection_hours[open]" class="form-control timepicker" value="12:00 AM" />--}}
                                            {{--<span class="input-group-addon">--}}
                                                {{--<i class="fa fa-clock-o"></i>--}}
                                            {{--</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<input type="text" name="collection_hours[close]" class="form-control timepicker" value="11:59 PM" />--}}
                                            {{--<span class="input-group-addon">--}}
                                                {{--<i class="fa fa-clock-o"></i>--}}
                                            {{--</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    {{--<div id="order" class="tab-pane row wrap-all">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-offer-delivery" class="col-sm-3 control-label">Offer Delivery</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div id="input-offer-delivery" class="btn-group btn-group-switch" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-danger active">--}}
                                        {{--<input type="radio" name="offer_delivery" value="0"  checked="checked">--}}
                                        {{--NO--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-success"><input type="radio" name="offer_delivery" value="1" >--}}
                                        {{--YES--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-offer-collection" class="col-sm-3 control-label">Offer Pick-up</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div id="input-offer-collection" class="btn-group btn-group-switch" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-danger active">--}}
                                        {{--<input type="radio" name="offer_collection" value="0"  checked="checked">--}}
                                        {{--NO--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-success">--}}
                                        {{--<input type="radio" name="offer_collection" value="1" >--}}
                                        {{--YES--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-delivery-time" class="col-sm-3 control-label">--}}
                                {{--Delivery Time--}}
                                {{--<span class="help-block">Set number of minutes an order will be delivered after being placed, or set to 0 to use default</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="text" name="delivery_time" id="input-delivery-time" class="form-control" value="0" />--}}
                                    {{--<span class="input-group-addon">minutes</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-collection-time" class="col-sm-3 control-label">--}}
                                {{--Pick-up Time--}}
                                {{--<span class="help-block">Set number of minutes an order will be ready for pick-up after being placed, or set to 0 to use default</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="text" name="collection_time" id="input-collection-time" class="form-control" value="0" />--}}
                                    {{--<span class="input-group-addon">minutes</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-last-order-time" class="col-sm-3 control-label">--}}
                                {{--Last Order Time--}}
                                {{--<span class="help-block">Set number of minutes before closing time for last order, or set to 0 to use closing hour.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="text" name="last_order_time" id="input-last-order-time" class="form-control" value="0" />--}}
                                    {{--<span class="input-group-addon">minutes</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-future-orders" class="col-sm-3 control-label">--}}
                                {{--Accept Future Orders--}}
                                {{--<span class="help-block">Allow customer to place order for a later time when restaurant is closed for delivery or pick-up during opening hours</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="btn-group btn-group-switch" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-danger active" id="future-orders-days-hide">--}}
                                        {{--<input type="radio" name="future_orders" value="0"  checked="checked">--}}
                                        {{--NO--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-success" id="future-orders-days-show">--}}
                                        {{--<input type="radio" name="future_orders" value="1" >--}}
                                        {{--YES--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div id="future-orders-days" style="display: none;">--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-delivery-days" class="col-sm-3 control-label">Future Order Days In Advance								<span class="help-block">Set the number of days in advance to allow customer to place a delivery or pick-up order for a later time.</span>--}}
                                {{--</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="control-group control-group-2">--}}
                                        {{--<div class="input-group">--}}
                                            {{--<span class="input-group-addon"><b>Delivery:</b></span>--}}
                                            {{--<input type="text" name="future_order_days[delivery]" class="form-control" value="5" />--}}
                                            {{--<span class="input-group-addon">days</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="input-group">--}}
                                            {{--<span class="input-group-addon"><b>Pick-up:</b></span>--}}
                                            {{--<input type="text" name="future_order_days[collection]" class="form-control" value="5" />--}}
                                            {{--<span class="input-group-addon">days</span>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label for="input-payments" class="col-sm-3 control-label">--}}
                                {{--Payments--}}
                                {{--<span class="help-block">Select the payment(s) available at this location. Leave blank to use all enabled payments</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-7">--}}
                                {{--<div class="col-xs-12 col-sm-5 wrap-none wrap-horizontal">--}}
                                    {{--<div class="input-group button-checkbox">--}}
                                        {{--<button type="button" class="btn btn-default" data-color="default">--}}
                                            {{--&nbsp;&nbsp;&nbsp;Cash On Delivery--}}
                                        {{--</button>--}}
                                        {{--<input name="payments[]" type="checkbox" class="hidden" value="cod" />--}}
                                        {{--<a href="#" class="btn btn-default">--}}
                                            {{--<i class="fa fa-cog"></i>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div id="reservation" class="tab-pane row wrap-all">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-reserve-interval" class="col-sm-3 control-label">--}}
                                {{--Time Interval--}}
                                {{--<span class="help-block">Set the number of minutes between each reservation time, Leave as 0 to use system setting value</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="text" name="reservation_time_interval" id="input-reserve-interval" class="form-control" value="0" />--}}
                                    {{--<span class="input-group-addon">minutes</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-reserve-turn" class="col-sm-3 control-label">--}}
                                {{--Stay Time--}}
                                {{--<span class="help-block">Set in minutes the average time a guest will stay at a table, Leave as 0 to use system setting value</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="input-group">--}}
                                    {{--<input type="text" name="reservation_stay_time" id="input-reserve-turn" class="form-control" value="0" />--}}
                                    {{--<span class="input-group-addon">minutes</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-table" class="col-sm-3 control-label">Tables</label>--}}
                            {{--<div class="col-sm-5">--}}

                                {{--<label for="s2id_autogen1" class="select2-offscreen">Tables</label>--}}
                                {{--<input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1">--}}

                                {{--<input type="text" name="table" value="" id="input-table" class="form-control select2-offscreen" tabindex="-1" title="Tables"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div id="table-box" class="col-sm-12 wrap-top">--}}
                                {{--<div class="table-responsive">--}}
                                    {{--<table class="table table-striped">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th width="40%">Name</th>--}}
                                            {{--<th>Minimum</th>--}}
                                            {{--<th>Capacity</th>--}}
                                            {{--<th>Remove</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div id="delivery" class="tab-pane row wrap-none">--}}
                        {{--<p class="alert text-danger">Delivery area map will be visible after location has been added.</p>--}}
                    {{--</div>--}}

                    {{--<div id="gallery" class="tab-pane row wrap-all">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-gallery-title" class="col-sm-3 control-label">Title</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<input type="text" name="gallery[title]" id="input-gallery-title" class="form-control" value="" />--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-gallery-description" class="col-sm-3 control-label">Description</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<textarea name="gallery[description]" id="input-gallery-description" class="form-control" rows="5"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<br />--}}

                        {{--<div id="gallery-images" class="row">--}}
                            {{--<div class="panel panel-default panel-table">--}}
                                {{--<div class="table-responsive">--}}
                                    {{--<table class="table table-striped table-border table-sortable">--}}
                                        {{--<thead>--}}
                                        {{--<tr>--}}
                                            {{--<th class="action"></th>--}}
                                            {{--<th>Thumbnail</th>--}}
                                            {{--<th class="col-sm-3">Filename</th>--}}
                                            {{--<th class="col-sm-4">Alt Text</th>--}}
                                            {{--<th class="col-sm-4 text-center">Status</th>--}}
                                        {{--</tr>--}}
                                        {{--</thead>--}}
                                        {{--<tbody>--}}
                                        {{--</tbody>--}}
                                        {{--<tfoot>--}}
                                        {{--<tr id="tfoot">--}}
                                            {{--<td class="action action-one">--}}
                                                {{--<a class="btn btn-primary btn-lg" onclick="addImageToGallery();">--}}
                                                    {{--<i class="fa fa-plus"></i>--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                            {{--<td colspan="4"></td>--}}
                                        {{--</tr>--}}
                                        {{--</tfoot>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript"><!--
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
                    return { results: data.results };
                }
            }
        });

        $('input[name=\'table\']').on('select2-selecting', function(e) {
            $('#table-box' + e.choice.id).remove();
            $('#table-box table tbody').append('<tr id="table-box' + e.choice.id + '"><td class="name">' + e.choice.text + '</td><td>' + e.choice.min + '</td><td>' + e.choice.max + '</td><td class="img">' + '<a class="btn btn-danger btn-xs" onclick="confirm(\'This cannot be undone! Are you sure you want to do this?\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="tables[]" value="' + e.choice.id + '" /></td></tr>');
        });
        //--></script>
    <script type="text/javascript">
        <!--
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
            var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
            $(window).bind("load resize", function() {
                var height = (this.window.innerHeight > 0) ? this.window.innerHeight-100 : this.screen.height-100;
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
            var iframe_url = js_site_url('image_manager?popup=iframe&field_id=' + field);

            $('body').append('<div id="media-manager" class="modal" tabindex="-1" data-parent="note-editor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'
                + '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">'
                + '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
                + '<h4 class="modal-title">Image Manager</h4>'
                + '</div><div class="modal-body wrap-none">'
                + '<iframe name="media_manager" src="'+ iframe_url +'" width="100%" height="' + height + 'px" frameborder="0"></iframe>'
                + '</div></div></div></div>');

            $('#media-manager').modal('show');

            $('#media-manager').on('hide.bs.modal', function (e) {
                if ($('#' + field).attr('value')) {
                    $.ajax({
                        url: js_site_url('image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')) + '&width=120&height=120',
                        dataType: 'json',
                        success: function(json) {
                            var parent = $('#' + field).parent().parent();
                            parent.find('.image-thumb').attr('src', json);
                            parent.find('.image-name').attr('value', parent.find('.name').html());
                        }
                    });
                }
            });
        }
        //--></script>
    </div>
    <div id="footer" class="">
        <div class="row navbar-footer">
            <div class="col-sm-12 text-version">
                <p class="col-xs-9 wrap-none">Thank you for using <a target="_blank" href="http://tastyigniter.com">TastyIgniter</a></p>
                <p class="col-xs-3 text-right wrap-none">Version 2.1.1</p>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
                $('#side-menu .' + active_menu).addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
            }

            if (window.location.hash) {
                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
                $('#nav-tabs a[href="#'+hash+'"]').tab('show');
            }

            $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
        });

        function confirmDelete(form) {
            if ($('input[name="delete[]"]:checked').length && confirm('This cannot be undone! Are you sure you want to do this?')) {
                form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
                $('#'+form).submit();
            } else {
                return false;
            }
        }

        function saveClose() {
            $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
            $('#edit-form').submit();
        }
    </script>
    </div>
    </div>

@endsection
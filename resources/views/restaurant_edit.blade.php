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
                                    <select name="category[]" class="form-control" placeholder="Select Category"
                                            multiple>
                                        @foreach($restaurant->categoryRestaurant as $category_restaurant)
                                            <option
                                                    value="{{$category_restaurant->category_id}}"
                                                    @if(old('category')) {{ (collect(old('category'))->contains($category_restaurant->category_id)) ? 'selected':'' }} @else selected @endif>{{$category_restaurant->name_en}}</option>
                                        @endforeach
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}"{{ (collect(old('category'))->contains($category->id)) ? 'selected':'' }}>{{$category->name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('a[title], span[title], button[title]').tooltip({placement: 'bottom'});
                                        $('select.form-control').select2({minimumResultsForSearch: 10});

                                        $('.alert').alert();
                                        $('.dropdown-toggle').dropdown();

                                    });
                                </script>
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
                                        @if(old('opening_type'))
                                            <label class="btn btn-success active" id="daily-flexible-hide">
                                                <input type="radio" name="opening_type" id="24_7"
                                                       value="24_7" {{ (old('opening_type') == '24_7') ? 'checked' : '' }}>
                                                24/7
                                            </label>
                                            <label class="btn btn-success" id="opening-daily-show">
                                                <input type="radio" name="opening_type" id="daily"
                                                       value="daily" {{ (old('opening_type') == 'daily') ? 'checked' : '' }}>
                                                Daily
                                            </label>
                                            <label class="btn btn-success" id="opening-flexible-show">
                                                <input type="radio" name="opening_type" id="flexible"
                                                       value="flexible" {{ (old('opening_type') == 'flexible') ? 'checked' : '' }}>
                                                Flexible
                                            </label>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    var input = document.getElementById("24_7");
                                                    var daily = document.getElementById("daily");
                                                    var flexible = document.getElementById("flexible");
                                                    if (input.checked == true) {
                                                        $('#daily-flexible-hide').attr('class', 'btn btn-success active');
                                                    } else if (daily.checked == true) {
                                                        $('#opening-daily-show').attr('class', 'btn btn-success active');
                                                        $('#daily-flexible-hide').attr('class', 'btn btn-success');
                                                    } else if (flexible.checked == true) {
                                                        $('#opening-flexible-show').attr('class', 'btn btn-success active');
                                                        $('#daily-flexible-hide').attr('class', 'btn btn-success');
                                                    }
                                                });
                                            </script>
                                        @elseif($working->type == '24_7')
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
                                @if($working->type == 'daily')
                                    <div class="form-group">
                                        <label for="input-opening-days" class="col-sm-3 control-label">Days</label>
                                        <div class="col-xs-5">
                                            <div class="btn-group btn-group-toggle btn-group-7"   id="old_days">
                                                @foreach($restaurant->workingHour as $working_hour)
                                                    <label style="cursor: default" class="btn btn-default"
                                                           id="mon_active">
                                                        @if($working_hour->weekday == 1)
                                                            Mon
                                                        @elseif($working_hour->weekday == 2)
                                                            Tue
                                                        @elseif($working_hour->weekday == 3)
                                                            Wed
                                                        @elseif($working_hour->weekday == 4)
                                                            Thu
                                                        @elseif($working_hour->weekday == 5)
                                                            Fri
                                                        @elseif($working_hour->weekday == 6)
                                                            Sat
                                                        @elseif($working_hour->weekday == 0)
                                                            Sun
                                                        @endif
                                                    </label>
                                                @endforeach
                                                    <label class="btn btn-default active" onclick="editDays(this)">
                                                        <i class="fa fa-pencil"></i>
                                                    </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none" id="edit_days">
                                        <label for="input-opening-days" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5">
                                            <div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
                                                <label class="btn btn-default" id="mon_active">
                                                    <input type="checkbox" name="daily_days[]" id="mon"
                                                           value="1" {{ (collect(old('daily_days'))->contains(1)) ? 'checked':'' }}>
                                                    Mon
                                                </label>
                                                <label class="btn btn-default " id="tue_active">
                                                    <input type="checkbox" name="daily_days[]" id="tue"
                                                           value="2" {{ (collect(old('daily_days'))->contains(2)) ? 'checked':'' }} >
                                                    Tue
                                                </label>
                                                <label class="btn btn-default " id="wed_active">
                                                    <input type="checkbox" name="daily_days[]" id="wed"
                                                           value="3" {{ (collect(old('daily_days'))->contains(3)) ? 'checked':'' }} >
                                                    Wed
                                                </label>
                                                <label class="btn btn-default" id="thu_active">
                                                    <input type="checkbox" name="daily_days[]" id="thu"
                                                           value="4" {{ (collect(old('daily_days'))->contains(4)) ? 'checked':'' }}>
                                                    Thu
                                                </label>
                                                <label class="btn btn-default" id="fri_active">
                                                    <input type="checkbox" name="daily_days[]" id="fri"
                                                           value="5" {{ (collect(old('daily_days'))->contains(5)) ? 'checked':'' }}>
                                                    Fri
                                                </label>
                                                <label class="btn btn-default " id="sat_active">
                                                    <input type="checkbox" name="daily_days[]" id="sat"
                                                           value="6" {{ (collect(old('daily_days'))->contains(6)) ? 'checked':'' }}>
                                                    Sat
                                                </label>
                                                <label class="btn btn-default " id="sun_active">
                                                    <input type="checkbox" name="daily_days[]" id="sun"
                                                           value="0" {{ (collect(old('daily_days'))->contains(0)) ? 'checked':'' }}>
                                                    Sun
                                                </label>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            function editDays(){
                                                $('#edit_days').slideToggle();
                                            }
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                        <div class="col-sm-5">
                                            <div class="control-group control-group-2">
                                                <div class="input-group">
                                                    <input id="clock-show" type="text" name="daily_hours[open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('daily_hours.open') ?? $working->opening_time }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="daily_hours[close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('daily_hours.close') ?? $working->closing_time  }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="input-opening-days" class="col-sm-3 control-label">Days</label>
                                        <div class="col-sm-5{{ $errors->has('daily_days') ? ' has-error' : '' }}">
                                            <div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
                                                <label class="btn btn-default" id="mon_active">
                                                    <input type="checkbox" name="daily_days[]" id="mon" value="1"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(1)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Mon
                                                </label>
                                                <label class="btn btn-default " id="tue_active">
                                                    <input type="checkbox" name="daily_days[]" id="tue" value="2"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(2)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Tue
                                                </label>
                                                <label class="btn btn-default " id="wed_active">
                                                    <input type="checkbox" name="daily_days[]" id="wed" value="3"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(3)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Wed
                                                </label>
                                                <label class="btn btn-default" id="thu_active">
                                                    <input type="checkbox" name="daily_days[]" id="thu" value="4"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(4)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Thu
                                                </label>
                                                <label class="btn btn-default" id="fri_active">
                                                    <input type="checkbox" name="daily_days[]" id="fri" value="5"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(5)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Fri
                                                </label>
                                                <label class="btn btn-default " id="sat_active">
                                                    <input type="checkbox" name="daily_days[]" id="sat" value="6"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(6)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Sat
                                                </label>
                                                <label class="btn btn-default " id="sun_active">
                                                    <input type="checkbox" name="daily_days[]" id="sun" value="0"
                                                           @if(old('daily_days'))   {{ (collect(old('daily_days'))->contains(0)) ? 'checked':'' }} @else checked="checked" @endif >
                                                    Sun
                                                </label>
                                                <script>
                                                    $(document).ready(function () {
                                                        var mon = document.getElementById("mon");
                                                        var tue = document.getElementById("tue");
                                                        var wed = document.getElementById("wed");
                                                        var thu = document.getElementById("thu");
                                                        var fri = document.getElementById("fri");
                                                        var sat = document.getElementById("sat");
                                                        var sun = document.getElementById("sun");
                                                        if (mon.checked == true) {
                                                            $('#mon_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#mon_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (tue.checked == true) {
                                                            $('#tue_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#tue_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (wed.checked == true) {
                                                            $('#wed_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#wed_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (thu.checked == true) {
                                                            $('#thu_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#thu_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (fri.checked == true) {
                                                            $('#fri_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#fri_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (sat.checked == true) {
                                                            $('#sat_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#sat_active').attr('class', 'btn btn-default');
                                                        }
                                                        if (sun.checked == true) {
                                                            $('#sun_active').attr('class', 'btn btn-default active');
                                                        } else {
                                                            $('#sun_active').attr('class', 'btn btn-default');
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            @if ($errors->has('daily_days'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('daily_days') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-opening-hours" class="col-sm-3 control-label">Hours</label>
                                        <div class="col-sm-5">
                                            <div class="control-group control-group-2">
                                                <div class="input-group">
                                                    <input id="clock-show" type="text" name="daily_hours[open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('daily_hours.open', '09:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="daily_hours[close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('daily_hours.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                @if($working->type == 'flexible')
                                    @foreach($restaurant->workingHour as $working_hour)
                                        <div class="form-group">
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
                                                               value="{{ old('flexible_hours.' . $working_hour->weekday . '.open', '12:00 AM') }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="text"
                                                               name="flexible_hours[{{$working_hour->weekday}}][close]"
                                                               class="form-control timepicker"
                                                               value="{{ old('flexible_hours.' . $working_hour->weekday . '.close', '11:59 PM') }}"/>
                                                        <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                    </div>
                                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                        <label class="btn btn-success active"
                                                               id="open_active{{$working_hour->weekday}}">
                                                            <input type="radio"
                                                                   name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                   id="open{{$working_hour->weekday}}" value="1"
                                                                   {{ (old('flexible_hours.' . $working_hour->weekday .'.status') == '1') ? 'checked' : '' }} checked="checked">
                                                            Open
                                                        </label>
                                                        <label class="btn btn-danger"
                                                               id="close_active{{$working_hour->weekday}}">
                                                            <input type="radio"
                                                                   name="flexible_hours[{{$working_hour->weekday}}][status]"
                                                                   id="close{{$working_hour->weekday}}"
                                                                   value="0" {{ (old('flexible_hours.' . $working_hour->weekday .'.status') == '0') ? 'checked' : '' }}>
                                                            Closed
                                                        </label>
                                                        <script type="text/javascript">
                                                            $(document).ready(function () {
                                                                var id = '<?php echo $working_hour->weekday; ?>';
                                                                var open = document.getElementById("open" + id);
                                                                var close = document.getElementById("close" + id);
                                                                if (open.checked == true) {
                                                                    $('#open_active' + id).attr('class', 'btn btn-success active');
                                                                } else if (close.checked == true) {
                                                                    $('#close_active' + id).attr('class', 'btn btn-danger active');
                                                                    $('#open_active' + id).attr('class', 'btn btn-success');
                                                                }
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                            <span class="text-right">Monday</span>
                                            <input type="hidden" name="flexible_hours[1][day]" value="1"/>
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[1][open]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.1.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[1][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.1.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="mon_open_active">
                                                        <input type="radio" name="flexible_hours[1][status]"
                                                               id="mon_open" value="1"
                                                               {{ (old('flexible_hours.1.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="mon_close_active">
                                                        <input type="radio" name="flexible_hours[1][status]"
                                                               id="mon_close"
                                                               value="0" {{ (old('flexible_hours.1.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("mon_open");
                                                            var close = document.getElementById("mon_close");
                                                            if (open.checked == true) {
                                                                $('#mon_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#mon_close_active').attr('class', 'btn btn-danger active');
                                                                $('#mon_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.2.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[2][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.2.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="tue_open_active">
                                                        <input type="radio" name="flexible_hours[2][status]"
                                                               id="tue_open" value="1"
                                                               {{ (old('flexible_hours.2.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="tue_close_active">
                                                        <input type="radio" name="flexible_hours[2][status]"
                                                               id="tue_close"
                                                               value="0" {{ (old('flexible_hours.2.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("tue_open");
                                                            var close = document.getElementById("tue_close");
                                                            if (open.checked == true) {
                                                                $('#tue_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#tue_close_active').attr('class', 'btn btn-danger active');
                                                                $('#tue_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.3.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[3][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.3.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="wed_open_active">
                                                        <input type="radio" name="flexible_hours[3][status]"
                                                               id="wed_open" value="1"
                                                               {{ (old('flexible_hours.3.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="wed_close_active">
                                                        <input type="radio" name="flexible_hours[3][status]"
                                                               id="wed_close"
                                                               value="0" {{ (old('flexible_hours.3.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("wed_open");
                                                            var close = document.getElementById("wed_close");
                                                            if (open.checked == true) {
                                                                $('#wed_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#wed_close_active').attr('class', 'btn btn-danger active');
                                                                $('#wed_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.4.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[4][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.4.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="thu_open_active">
                                                        <input type="radio" name="flexible_hours[4][status]"
                                                               id="thu_open" value="1"
                                                               {{ (old('flexible_hours.4.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="thu_close_active">
                                                        <input type="radio" name="flexible_hours[4][status]"
                                                               id="thu_close"
                                                               value="0" {{ (old('flexible_hours.4.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("thu_open");
                                                            var close = document.getElementById("thu_close");
                                                            if (open.checked == true) {
                                                                $('#thu_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#thu_close_active').attr('class', 'btn btn-danger active');
                                                                $('#thu_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.5.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[5][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.5.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="fri_open_active">
                                                        <input type="radio" name="flexible_hours[5][status]"
                                                               id="fri_open" value="1"
                                                               {{ (old('flexible_hours.5.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="fri_close_active">
                                                        <input type="radio" name="flexible_hours[5][status]"
                                                               id="fri_close"
                                                               value="0" {{ (old('flexible_hours.5.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("fri_open");
                                                            var close = document.getElementById("fri_close");
                                                            if (open.checked == true) {
                                                                $('#fri_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#fri_close_active').attr('class', 'btn btn-danger active');
                                                                $('#fri_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.6.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[6][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.6.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="sat_open_active">
                                                        <input type="radio" name="flexible_hours[6][status]"
                                                               id="sat_open" value="1"
                                                               {{ (old('flexible_hours.6.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="sat_close_active">
                                                        <input type="radio" name="flexible_hours[6][status]"
                                                               id="sat_close"
                                                               value="0" {{ (old('flexible_hours.6.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("sat_open");
                                                            var close = document.getElementById("sat_close");
                                                            if (open.checked == true) {
                                                                $('#sat_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#sat_close_active').attr('class', 'btn btn-danger active');
                                                                $('#sat_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
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
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.0.open', '12:00 AM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="flexible_hours[0][close]"
                                                           class="form-control timepicker"
                                                           value="{{ old('flexible_hours.0.close', '11:59 PM') }}"/>
                                                    <span class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                                </div>
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <label class="btn btn-success active" id="sun_open_active">
                                                        <input type="radio" name="flexible_hours[0][status]"
                                                               id="sun_open" value="1"
                                                               {{ (old('flexible_hours.0.status') == '1') ? 'checked' : '' }} checked="checked">
                                                        Open
                                                    </label>
                                                    <label class="btn btn-danger" id="sun_close_active">
                                                        <input type="radio" name="flexible_hours[0][status]"
                                                               id="sun_close"
                                                               value="0" {{ (old('flexible_hours.0.status') == '0') ? 'checked' : '' }}>
                                                        Closed
                                                    </label>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            var open = document.getElementById("sun_open");
                                                            var close = document.getElementById("sun_close");
                                                            if (open.checked == true) {
                                                                $('#sun_open_active').attr('class', 'btn btn-success active');
                                                            } else if (close.checked == true) {
                                                                $('#sun_close_active').attr('class', 'btn btn-danger active');
                                                                $('#sun_open_active').attr('class', 'btn btn-success');
                                                            }
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
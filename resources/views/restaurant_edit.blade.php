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
                        <li id="generalTab" class="active">
                            <a href="#general" data-toggle="tab">Restaurant</a>
                        </li>
                        <li id="dataTab">
                            <a href="#data" data-toggle="tab">Data</a>
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
                            {{--<div class="form-group">--}}
                            {{--<label for="category" class="col-sm-3 control-label">Category</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="table-responsive">--}}
                            {{--<table border="0" class="table table-striped table-border">--}}
                            {{--<tbody>--}}
                            {{--@foreach($category_restaurants as $category_restaurant)--}}
                            {{--<tr>--}}
                            {{--<td>{{$category_restaurant->name_en}}</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                            {{--<td class="action">--}}
                            {{--<label class=" btn btn-primary " id="editCategory">--}}
                            {{--<i class="fa fa-pencil"></i>--}}
                            {{--</label>--}}
                            {{--</td>--}}
                            {{--</table>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div id="editing_category" style="display: none">--}}
                            <div class="form-group">
                                <label for="category" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    <select name="category[]" id="category" class="form-control"
                                            placeholder="Select Categories"
                                            multiple>
                                        @foreach($category_restaurants as $category_restaurant)
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
                            </div>
                            {{--<div class="form-group" >--}}
                            {{--<label  class="col-sm-3 control-label text-right"></label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<label class=" btn btn-danger action" id="editCategoryCancel">--}}
                            {{--Cancel--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group{{ $errors->has('restaurant_name_en') ? ' has-error' : '' }}">
                                <label for="input_restaurant_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="restaurant_name_en" id="input_restaurant_name_en"
                                           class="form-control"
                                           value="{{old('restaurant_name_en') ?? $restaurant->name_en }}"/>
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
                                           class="form-control"
                                           value="{{old('restaurant_name_ar') ?? $restaurant->name_ar }}"/>
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
                                           class="form-control"
                                           value="{{old('restaurant_email') ?? $restaurant->email }}"/>
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
                                           class="form-control"
                                           value="{{old('restaurant_telephone') ?? $restaurant->telephone }}"/>
                                    @if ($errors->has('restaurant_telephone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('restaurant_telephone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category" class="col-sm-3 control-label">City</label>
                                <div class="col-sm-5">
                                    <select name="area[]" id="area" class="form-control" multiple
                                            placeholder="Select Cities">
                                        @foreach($restaurantAreas as $restaurantArea)
                                            <option
                                                    value="{{$restaurantArea->area_id}}"
                                                    @if(old('area')) {{ (collect(old('area'))->contains($restaurantArea->area_id)) ? 'selected':'' }} @else selected @endif>{{$restaurantArea->name_en}}</option>
                                        @endforeach
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}"{{ (collect(old('area'))->contains($area->id)) ? 'selected':'' }}>{{$area->name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('area'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('area') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="data" class="tab-pane row wrap-all">
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{old('description_en') ?? $restaurant->description_en }}</textarea>
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
                                              rows="5">{{old('description_ar') ?? $restaurant->description_ar }}</textarea>
                                    @if ($errors->has('description_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
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
                                                           onchange="readURL(this);" value="{{$restaurant->image}}">
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
                    </div>
            </form>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            var errorGeneral = $("#general .form-group .help-block").length;
            var errorData = $("#data .form-group .help-block").length;
            if(errorData > 0){
                $('#dataTab').addClass('active');
                $('#data').addClass('active');
                $('#generalTab').removeClass('active');
                $('#general').removeClass('active');
            }
            if(errorGeneral > 0){
                $('#generalTab').addClass('active');
                $('#general').addClass('active');
                $('#dataTab').removeClass('active');
                $('#data').removeClass('active');
            }
        });
        // var map;
        // var markers = [];
        // var lat = parseFloat(document.getElementById('lat').value);
        // var lng = parseFloat(document.getElementById('long').value);
        //
        // function initMap() {
        //     var haightAshbury = {lat: lat, lng: lng};
        //     map = new google.maps.Map(document.getElementById('map'), {
        //         zoom: 11,
        //         panControl: true,
        //         zoomControl: true,
        //         mapTypeControl: true,
        //         scaleControl: true,
        //         streetViewControl: true,
        //         overviewMapControl: true,
        //         rotateControl: true,
        //         center: haightAshbury,
        //         mapTypeId: 'terrain'
        //     });
        //
        //     map.addListener('click', function (event) {
        //         if (markers.length >= 1) {
        //             deleteMarkers();
        //         }
        //
        //         addMarker(event.latLng);
        //         document.getElementById('lat').value = event.latLng.lat();
        //         document.getElementById('long').value = event.latLng.lng();
        //     });
        // }
        //
        // function addMarker(location) {
        //     var marker = new google.maps.Marker({
        //         position: location,
        //         map: map
        //     });
        //     markers.push(marker);
        // }
        //
        //
        // function setMapOnAll(map) {
        //     for (var i = 0; i < markers.length; i++) {
        //         markers[i].setMap(map);
        //     }
        // }
        //
        //
        // function clearMarkers() {
        //     setMapOnAll(null);
        // }
        //
        //
        // function deleteMarkers() {
        //     clearMarkers();
        //     markers = [];
        // }

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
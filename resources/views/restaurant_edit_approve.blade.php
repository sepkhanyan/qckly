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
                            @if(count($editingCategoryRestaurants) > 0)
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                @foreach($editingCategoryRestaurants as $editingCategoryRestaurant)
                                                    <tr>
                                                        <td>{{$editingCategoryRestaurant->name_en}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Category</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                @foreach($categoryRestaurants as $categoryRestaurant)
                                                    <tr>
                                                        <td>{{$categoryRestaurant->name_en}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                            @if(count($editingRestaurantAreas) > 0)
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                @foreach($editingRestaurantAreas as $editingRestaurantArea)
                                                    <tr>
                                                        <td>{{$editingRestaurantArea->name_en}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                @foreach($restaurantAreas as $restaurantArea)
                                                    <tr>
                                                        <td>{{$restaurantArea->name_en}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                            @if(count( $editingWorkingHours) > 0)
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Working Hours</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                @if($editingWorking->type == '24_7')
                                                    <tbody>
                                                    <tr>
                                                        <td>24/7</td>
                                                    </tr>
                                                    </tbody>
                                                @else
                                                    <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Opening Time</th>
                                                        <th>Closing Time</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($editingWorkingHours as $editingWorkingHour)
                                                        <tr>
                                                            <td>
                                                                @if($editingWorkingHour->weekday == 1)
                                                                    Monday
                                                                @elseif($editingWorkingHour->weekday == 2)
                                                                    Tuesday
                                                                @elseif($editingWorkingHour->weekday == 3)
                                                                    Wednesday
                                                                @elseif($editingWorkingHour->weekday == 4)
                                                                    Thursday
                                                                @elseif($editingWorkingHour->weekday == 5)
                                                                    Friday
                                                                @elseif($editingWorkingHour->weekday == 6)
                                                                    Saturday
                                                                @elseif($editingWorkingHour->weekday == 0)
                                                                    Sunday
                                                                @endif
                                                            </td>
                                                            <td>{{$editingWorkingHour->opening_time}}</td>
                                                            <td>{{$editingWorkingHour->closing_time}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Working Hours</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                @if($working->type == '24_7')
                                                    <tbody>
                                                    <tr>
                                                        <td>24/7</td>
                                                    </tr>
                                                    </tbody>
                                                @else
                                                    <thead>
                                                    <tr>
                                                        <th>Day</th>
                                                        <th>Opening Time</th>
                                                        <th>Closing Time</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($workingHours as $workingHour)
                                                        <tr>
                                                            <td>
                                                                @if($workingHour->weekday == 1)
                                                                    Monday
                                                                @elseif($workingHour->weekday == 2)
                                                                    Tuesday
                                                                @elseif($workingHour->weekday == 3)
                                                                    Wednesday
                                                                @elseif($workingHour->weekday == 4)
                                                                    Thursday
                                                                @elseif($workingHour->weekday == 5)
                                                                    Friday
                                                                @elseif($workingHour->weekday == 6)
                                                                    Saturday
                                                                @elseif($workingHour                    ->weekday == 0)
                                                                    Sunday
                                                                @endif
                                                            </td>
                                                            <td>{{$workingHour->opening_time}}</td>
                                                            <td>{{$workingHour->closing_time}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        @endif
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
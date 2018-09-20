@extends('home')
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
                <a href="{{ url('/collections') }}" class="btn btn-default">
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
                                Collection
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="GET"
                              action="{{ url('/collection/store') }}">
                            {{ csrf_field() }}
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
                            @endif
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
                            <div class="form-group">
                                <label for="input_mealtime" class="col-sm-3 control-label">Mealtime</label>
                                <div class="col-sm-5">
                                    <select name="mealtime" id="mealtime" class="form-control">
                                        @foreach ($mealtimes as $mealtime)
                                            <option value="{{$mealtime->id}}">{{$mealtime->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="female_caterer_available" class="col-sm-3 control-label">Female Caterer
                                    Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-danger active">
                                            <input type="radio" name="female_caterer_available" value="0"
                                                   checked="checked">
                                            NO
                                        </label>
                                        <label class="btn btn-success">
                                            <input type="radio" name="female_caterer_available" value="1">
                                            YES
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
                                <label for="service_provide_ar" class="col-sm-3 control-label">Service Provide
                                    Ar</label>
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
                                <label for="service_presentation_en" class="col-sm-3 control-label">Service Presentation
                                    En</label>
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
                                <label for="service_presentation_ar" class="col-sm-3 control-label">Service Presentation
                                    Ar</label>
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
                            <div class="form-group">
                                <label for="is_available" class="col-sm-3 control-label">Is Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-danger active">
                                            <input type="radio" name="is_available" value="0" checked="checked">
                                            NO
                                        </label>
                                        <label class="btn btn-success">
                                            <input type="radio" name="is_available" value="1">
                                            YES
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="input-name" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
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
                            <div style="display: none" id="items">
                                <div id="selection">
                                    <div class="form-group" id="price">
                                        <label for="input-price" class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="collection_price" id="input-price"
                                                       class="form-control" value="{{ old('collection_price') }}"/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-money"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Quantity</label>
                                        <div class="col-sm-5">
                                            <div class="input-group" id="collection_qty"
                                                 style="width: 200px; display: none">
                                                <input type="text" name="min_quantity" class="form-control"
                                                       placeholder="Collection min quantity"
                                                       value="{{ old('min_quantity') }}">
                                                <input type="text" name="max_quantity" class="form-control"
                                                       placeholder="Collection max quantity"
                                                       value="{{ old('max_quantity') }}">
                                            </div>
                                            <div class="input-group" id="persons_qty"
                                                 style="display: none; width: 200px;">
                                                <input type="text" name="min_serve_to_person" class="form-control"
                                                       placeholder="Serve to person(min)"
                                                       value="{{ old('min_serve_to_person') }}">
                                                <input type="text" name="max_serve_to_person" class="form-control"
                                                       placeholder="Serve to person(max)"
                                                       value="{{ old('max_serve_to_person') }}">
                                                <input type="text" name="persons_max_count" id="max_person"
                                                       class="form-control" placeholder="Persons max count"
                                                       value="{{ old('persons_max_count') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="person_increase" style="display: none">
                                        <label for="is_available" class="col-sm-3 control-label">Allow Person
                                            Increase</label>
                                        <div class="col-sm-5">
                                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-danger active">
                                                    <input type="radio" name="allow_person_increase" value="0"
                                                           checked="checked">
                                                    NO
                                                </label>
                                                <label class="btn btn-success">
                                                    <input type="radio" name="allow_person_increase" value="1">
                                                    YES
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Menu Items</label>
                                        <div class="col-sm-5">
                                            <div class="page-header clearfix" id="all">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"
                                                               onclick="$('input[name*=\'menu\']').prop('checked', this.checked);">
                                                        <b>Select All</b>
                                                    </label>
                                                </div>
                                            </div>
                                            @foreach($menu_categories as $menu_category)
                                                <label for="">
                                                    <h4>{{$menu_category->name_en}}</h4>
                                                    <input type="hidden" name="menu[]" value="{{$menu_category->id}}">
                                                </label>
                                                <span class="help-block">Needed for "Fixed quantity by person" and "Customised platter" collections.</span>
                                                <label for="menu_min_qty">
                                                    <input type="number" class="form-control" name="menu_min_qty[]"
                                                           id="menu_min_qty" placeholder="Menu Min Quantity" min="1">
                                                </label>
                                                <label for="menu_max_qty">
                                                    <input type="number" class="form-control" name="menu_max_qty[]"
                                                           id="menu_max_qty" placeholder="Menu Max Quantity" min="1">
                                                </label>
                                                @foreach($menu_category->menu as $menu)
                                                    <div class="checkbox" id="menu_items">
                                                        <label>
                                                            <input type="checkbox" name="menu_item[]"
                                                                   value="{{$menu->id}}">
                                                            {{$menu->name_en}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" id="setup">
                                    <div class="form-group">
                                        <label for="input-setup" class="col-sm-3 control-label">Setup Time</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="setup_time" id="input-setup"
                                                       class="form-control" value="{{ old('setup_time') }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_requirements_en" class="col-sm-3 control-label">Requirements
                                            En</label>
                                        <div class="col-sm-5">
                                            <textarea name="requirements_en" id="input_requirements_en"
                                                      class="form-control">{{ old('requirements_en') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_requirements_ar" class="col-sm-3 control-label">Requirements
                                            Ar</label>
                                        <div class="col-sm-5">
                                            <textarea name="requirements_ar" id="input_requirements_ar"
                                                      class="form-control">{{ old('requirements_ar') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input-max" class="col-sm-3 control-label">Max Time</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <input type="text" name="max_time" id="input-max" class="form-control"
                                                       value="{{ old('max_time') }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
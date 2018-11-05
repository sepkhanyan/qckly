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
                            <a href="#menus" data-toggle="tab">Collection Items</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="GET"
                      action="{{ url('/collection/store') }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$collection_category->name_en}}</h4>
                            <input type="hidden" name="category" value="{{$collection_category->id}}">
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
                        <div id="menus" class="tab-pane row wrap-all">
                            @if($collection_category->id != 1)
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-xs-2">
                                        <div class="checkbox" style="font-size: medium;">
                                            <label>
                                                <input type="checkbox"
                                                       onclick="$('input[name*=\'menu\']').prop('checked', this.checked);">
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="{{ $errors->has('menu') ? ' has-error' : '' }}{{ $errors->has('menu_item') ? ' has-error' : '' }}{{ $errors->has('menu_min_qty') ? ' has-error' : '' }}{{ $errors->has('menu_max_qty') ? ' has-error' : '' }}">
                                @foreach($menu_categories as $menu_category)
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label" style="font-size: medium;">
                                            <div class="col-xs-2">
                                                <div class="checkbox" style="font-size: medium;">
                                                    @if($collection_category->id != 1)
                                                        <label>
                                                            <input type="checkbox" name="menu[]"
                                                                   value="{{$menu_category->id}}" {{ (collect(old('menu'))->contains($menu_category->id)) ? 'checked':'' }}>
                                                            {{$menu_category->name_en}}
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                        @if($collection_category->id == 2 || $collection_category->id == 3)
                                            <div class="col-xs-2">
                                                <input type="number" name="menu_min_qty[]" min="1"
                                                       class="form-control" placeholder="Menu min quantity" required>
                                            </div>
                                            <div class="col-xs-2">
                                                <input type="number" name="menu_max_qty[]" min="1"
                                                       class="form-control" placeholder="Menu max quantity" required>
                                            </div>
                                        @else
                                            <div class="col-xs-2">
                                            </div>
                                        @endif
                                    </div>
                                    @foreach($menu_category->menu as $menu)
                                        <div class="form-group">
                                            <label for="" class="col-sm-3 control-label"></label>
                                            <div class="col-xs-2">
                                                <div class="checkbox" style="font-size: medium;">
                                                    <label>
                                                        <input type="checkbox" name="menu_item[]"
                                                               value="{{$menu->id}}" {{ (collect(old('menu_item'))->contains($menu->id)) ? 'checked':'' }}>
                                                        {{$menu->name_en}}
                                                    </label>
                                                </div>
                                            </div>
                                            @if($collection_category->id == 1)
                                                <div class="col-xs-2">
                                                    <input type="number"
                                                           min="1"
                                                           class="form-control"
                                                           name="menu_item_qty[]"
                                                           placeholder="Quantity"
                                                           value="">
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                                @if ($errors->has('menu'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('menu') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label"></label>
                                    <div class="col-xs-2">
                                        @if ($errors->has('menu_item'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('menu_item') }}</strong>
                                            </span>
                                        @endif
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

    </script>
@endsection
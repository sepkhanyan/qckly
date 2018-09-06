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
            <a href="{{ url('/collections') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
    <div class="row content">
        {{--@if($user = Auth::user()->admin == 1)--}}

            {{--<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="">--}}
                {{--<div class="filter-bar">--}}
                        {{--<div class="row">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="restaurant" class="col-sm-3 control-label">Restaurant</label>--}}
                                    {{--<div class="col-sm-5">--}}
                                        {{--<select name="restaurant_name" id="restaurant" class="form-control" tabindex="-1" title=""  >--}}
                                            {{--<option value=" ">Select Restaurant</option>--}}
                                            {{--@foreach($restaurants as $restaurant)--}}
                                                {{--<option value="{{$restaurant->id}}">{{$restaurant->name}},{{$restaurant->city}},{{$restaurant->address}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                        {{--</div>--}}
                    {{--<div>--}}
                        {{--<div class="form-group">--}}
                                {{--<label for="input-name" class="col-sm-3 control-label">Menu Category</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<select name="menu_category_name" id="menu_category" class="form-control">--}}
                                        {{--<option value=" ">Select Category</option>--}}
                                        {{--@foreach ($menu_categories as $menu_category)--}}
                                            {{--<option value="{{$menu_category->id}}" >{{$menu_category->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                    {{--</div>--}}
                    {{--<a class="btn btn-grey" onclick="filterList();" title="Filter">--}}
                        {{--Choose--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--@endif--}}
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
                        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="GET" action="{{ url('/collection/store') }}">
                            {{ csrf_field() }}
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
                            {{--<div class="form-group">--}}
                                {{--<label for="restaurant" class="col-sm-3 control-label">Restaurant</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<select name="restaurant" id="restaurant" class="form-control" tabindex="-1" title=""  >--}}
                                        {{--@foreach($restaurants as $restaurant)--}}
                                            {{--<option value="{{$restaurant->id}}">{{$restaurant->name}},{{$restaurant->city}},{{$restaurant->address}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            @endif
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="input-name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="input-description" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-5">
                                    <textarea name="description" id="input-description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-mealtime" class="col-sm-3 control-label">
                                    Mealtime
                                </label>
                                <div class="col-sm-5">
                                    <select name="mealtime" id="mealtime" class="form-control">
                                        <option value="Available all day">Available all day</option>
                                        <option value="Breakfast"  >Breakfast (07:00 - 10:00)</option>
                                        <option value="Lunch"  >Lunch (12:00 - 14:30)</option>
                                        <option value="Dinner"  >Dinner (18:00 - 20:00)</option>
                                    </select>
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
                            <div class="form-group">
                                <label for="service" class="col-sm-3 control-label">Service Provide</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide"  class="form-control" id="service">{{ old('service_provide') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="presentation" class="col-sm-3 control-label">Service Presentation</label>
                                <div class="col-sm-5">
                                    <textarea name="service_presentation"  class="form-control" id="presentation">{{ old('service_presentation') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="is_available" class="col-sm-3 control-label">Is Available</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    <label class="btn btn-danger active">
                                        <input type="radio" name="is_available" value="0"  checked="checked">
                                        NO
                                    </label>
                                    <label class="btn btn-success">
                                        <input type="radio" name="is_available" value="1" >
                                        YES
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="collection_price" id="input-price" class="form-control" value="{{ old('collection_price') }}" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-name" class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-5">
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" >{{$category->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="display: none" id="items">
                            <div id="selection">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Quantity</label>
                                    <div class="col-sm-5">
                                        <div class="input-group" id="collection_qty" style="width: 200px; display: none">
                                            <input type="text" name="min_quantity" class="form-control"  placeholder="Collection min quantity" value="{{ old('min_quantity') }}">
                                            <input type="text" name="max_quantity" class="form-control"  placeholder="Collection max quantity" value="{{ old('max_quantity') }}">
                                        </div>
                                        <div class="input-group" id="persons_qty" style="display: none; width: 200px;">
                                            <input type="text" name="min_serve_to_person" class="form-control"  placeholder="Serve to person(min)" value="{{ old('min_serve_to_person') }}">
                                            <input type="text" name="max_serve_to_person" class="form-control"  placeholder="Serve to person(max)" value="{{ old('max_serve_to_person') }}">
                                            <input type="text" name="persons_max_count" id="max_person" class="form-control"  placeholder="Persons max count" value="{{ old('persons_max_count') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="person_increase" style="display: none">
                                    <label for="is_available" class="col-sm-3 control-label">Allow Person Increase</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label class="btn btn-danger active">
                                                <input type="radio" name="allow_person_increase" value="0"  checked="checked">
                                                NO
                                            </label>
                                            <label class="btn btn-success">
                                                <input type="radio" name="allow_person_increase" value="1" >
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
                                                    <input type="checkbox" onclick="$('input[name*=\'menu\']').prop('checked', this.checked);">
                                                    <b>Select All</b>
                                                </label>
                                            </div>
                                        </div>
                                    @foreach($menu_categories as $menu_category)
                                            {{--<label class="container">--}}
                                            <label for="">
                                                {{$menu_category->name}}
                                                <input type="hidden" name="menu[]" value="{{$menu_category->id}}">
                                            </label>
                                            <label for="menu_min_qty">
                                                <input type="text" class="form-control" name="menu_min_qty[]" id="menu_min_qty" placeholder="Menu Min Quantity">
                                            </label>
                                            <label for="menu_max_qty">
                                                <input type="text" class="form-control" name="menu_max_qty[]" id="menu_max_qty" placeholder="Menu Max Quantity">
                                            </label>
                                                @foreach($menu_category->menu as $menu)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="menu_item[]" value="{{$menu->id}}">
                                                            {{$menu->name}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                                    <br>
                                        @endforeach
                                    </div>
                                </div>
                                {{--<div class="form-group" id="items_container">--}}
                                    {{--<label for="menu_item" class="col-sm-3 control-label">Menu Item</label>--}}
                                        {{--<select  name="menu_item[]" id="menu_item"  tabindex="-1" >--}}
                                            {{--<option value="">Select menu item</option>--}}
                                            {{--@foreach ($menu_categories as $menu_category)--}}
                                                {{--<option value="{{$menu_category->id}}">--}}
                                                    {{--{{$menu_category->name}}--}}
                                                {{--</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--<span  id="item_count" style="display: none">--}}
                                           {{--<input type="text" name="item_qty"  placeholder="Quantity" value="{{ old('item_qty') }}">--}}
                                        {{--</span>--}}
                                {{--</div>--}}
                            </div>
                            <div style="display: none" id="setup">
                                <div class="form-group">
                                    <label for="input-setup" class="col-sm-3 control-label">Setup Time</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="setup_time" id="input-setup" class="form-control" value="{{ old('setup_time') }}" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-requirements" class="col-sm-3 control-label">Requirements</label>
                                    <div class="col-sm-5">
                                        <textarea name="requirements" id="input-requirements" class="form-control">{{ old('requirements') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-max" class="col-sm-3 control-label">Max Time</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="max_time" id="input-max" class="form-control" value="{{ old('max_time') }}" />
                                            </span>
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

    {{--<script type="text/javascript">--}}
        {{--window.onload = () => {--}}
            {{--//add event listener to prevent the default behavior--}}
            {{--const mouseOnlyNumberInputField = document.getElementById("mouse-only-number-input");--}}
            {{--mouseOnlyNumberInputField.addEventListener("keypress", (event) => {--}}
                {{--event.preventDefault();--}}
            {{--});--}}
        {{--}--}}
    {{--</script>--}}

@endsection
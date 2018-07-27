@extends('header')
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
        {{--<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="">--}}
            {{--<div class="filter-bar">--}}
                {{--<div class="row">--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="restaurant" class="col-sm-3 control-label">Restaurant</label>--}}
                        {{--<div class="col-sm-5">--}}
                            {{--<select name="restaurant_name" id="restaurant" class="form-control" tabindex="-1" title=""  >--}}
                                {{--@foreach($restaurants as $restaurant)--}}
                                    {{--<option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}},{{$restaurant->restaurant_city}},{{$restaurant->restaurant_address_1}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="input-name" class="col-sm-3 control-label">Category</label>--}}
                        {{--<div class="col-sm-5">--}}
                            {{--<select name="category_name" id="category" class="form-control">--}}
                                {{--@foreach ($categories as $category)--}}
                                    {{--<option value="{{$category->id}}" >{{$category->name}}</option>--}}
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
                    <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{ url('/collection/update/' . $collection->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{--<div class="form-group">--}}
                            {{--<label for="restaurant" class="col-sm-3 control-label">Restaurant</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<select name="restaurant_name" id="restaurant" class="form-control" tabindex="-1" title=""  >--}}
                                    {{--@foreach($restaurants as $restaurant)--}}
                                        {{--<option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}},{{$restaurant->restaurant_city}},{{$restaurant->restaurant_address_1}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="input-name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control" value="{{$collection->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-5">
                                <textarea name="description" id="input-description" class="form-control" rows="5">{{$collection->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-mealtime" class="col-sm-3 control-label">Mealtime</label>
                            <div class="col-sm-5">
                                <input type="text" name="mealtime" id="input-mealtime" class="form-control" value="{{$collection->mealtime}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="service" class="col-sm-3 control-label">Service Provide</label>
                            <div class="col-sm-5">
                                <textarea name="service_provide"  class="form-control" id="service">{{$collection->service_provide}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="presentation" class="col-sm-3 control-label">Service Presentation</label>
                            <div class="col-sm-5">
                                <textarea name="service_presentation"  class="form-control" id="presentation">{{$collection->service_presentation}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="instructions" class="col-sm-3 control-label">Instruction</label>
                            <div class="col-sm-5">
                                <textarea name="instructions" id="notes" class="form-control" >{{$collection->instruction}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-setup" class="col-sm-3 control-label">Setup Time</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="setup_time" id="input-setup" class="form-control" value="{{$collection->setup_time}}" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-requirements" class="col-sm-3 control-label">Requirements</label>
                            <div class="col-sm-5">
                                <textarea name="requirements" id="input-requirements" class="form-control">{{$collection->requirements}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-max" class="col-sm-3 control-label">Max Time</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="max_time" id="input-max" class="form-control" value="{{$collection->max_time}}" />
                                    </span>
                                </div>
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
                            <label for="notes" class="col-sm-3 control-label">Notes</label>
                            <div class="col-sm-5">
                                <textarea name="notes" id="notes" class="form-control" rows="5">{{$collection->notes}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="collection_price" id="input-price" class="form-control" value="{{$collection->price}}" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-name" class="col-sm-3 control-label">Subcategory</label>
                            <div class="col-sm-5">
                                <select name="subcategory" id="subcategory" class="form-control">
                                    <option value="">Select subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{$subcategory->id}}" >{{$subcategory->subcategory_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="display: none" id="items">
                            <div id="selection">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Quantity</label>
                                    <div class="col-sm-5">
                                        <div class="input-group" >
                                            <input type="text" name="max_quantity" class="form-control" id="max_qty" placeholder="Max quantity" style="width: 100px; display: none">
                                            <input type="text" name="min_quantity" class="form-control" id="min_qty" placeholder=" Min quantity" style="width: 100px; display: none">
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="persons_min_count" class="form-control" id="person_min_qty" placeholder="Min Persons" style="width: 100px; display: none">
                                            <input type="text" name="persons_max_count" class="form-control" id="person_max_qty" placeholder="Max Persons" style="width: 100px; display: none">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="items_container">
                                    <label for="menu_item" class="col-sm-3 control-label">Menu Item</label>
                                    <div class="col-sm-5" id="item">
                                        <select  name="menu_item[]" id="menu_item"  tabindex="-1" >
                                            <option value="">Select menu item</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{$menu->id}}">
                                                    {{$menu->menu_name}}/
                                                    <span id="item_price" style="display: none">{{$menu->menu_price}}</span>
                                                </option>
                                            @endforeach
                                            <span  id="item_count" style="display: none">
                                                <input type="text" name="item_qty"  placeholder="Quantity">
                                            </span>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <span class="input-group" id="add_item" style="display: none">
                                        <button class="btn btn-primary"  type="button" >Add</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
    </script>
@endsection
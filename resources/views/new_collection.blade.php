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
            <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="GET" action="{{ url('/collection/store') }}">
                {{ csrf_field() }}
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <div class="form-group">
                            <label for="restaurant" class="col-sm-3 control-label">Restaurant</label>
                            <div class="col-sm-5">
                                <select name="restaurant_name" id="restaurant" class="form-control" tabindex="-1" title="">
                                    @foreach($restaurants as $restaurant)
                                        <option value="{{$restaurant->id}}">{{$restaurant->restaurant_name}},{{$restaurant->restaurant_city}},{{$restaurant->restaurant_address_1}}</option>
                                    @endforeach
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
                                <textarea name="notes" id="notes" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="collection_price" id="input-price" class="form-control" value="" />
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
                                        <option value="{{$subcategory->id}}" >{{$subcategory->subcategory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="display: none" id="items">
                            <div id="items_container">
                                <div class="form-group" id="item">
                                    <label for="menu_item" class="col-sm-3 control-label">Menu Item</label>
                                    <div class="col-sm-5">
                                        <select  name="menu_item" id="menu_item" class="" tabindex="-1">
                                            <option value="">Select menu item</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="input-group" >
                                        <input type="text" name="menu_item_quantity" class="form-control" id="by_item" placeholder="Quantity" style="width: 100px; display: none">
                                        <input type="text" name="persons" class="form-control" id="by_person" placeholder="Persons" style="width: 100px; display: none">
                                    </span>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
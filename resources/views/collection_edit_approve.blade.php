@extends('home', ['title' => 'Collection: ' . $collection->name_en])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-check"></i>
                    Approve
                </a>
                <a class="btn btn-danger" title=""
                   href="{{ url('collection/edit_reject/' . $collection->id )}}">
                    <i class="fa fa-ban"></i>
                    Reject
                </a>&nbsp;
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li id="generalTab" class="active">
                            <a href="#general" data-toggle="tab">
                                Collection Details
                            </a>
                        </li>
                        <li id="menuTab">
                            <a href="#menus" data-toggle="tab">Collection Items</a>
                        </li>
                        <li id="dataTab">
                            <a href="#data" data-toggle="tab">Service</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      action="{{ url('/collection/edit_approve/' . $collection->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if($user->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$collection->restaurant_id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$collection->category->name_en}}</h4>
                                <input type="hidden" name="category" value="{{$collection->category_id}}">
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{old('name_en') ?? $editingCollection->name_en}}">
                                </div>
                                @if ($collection->name_en != $editingCollection->name_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_ar" id="input_name_ar" class="form-control"
                                           value="{{old('name_ar') ?? $editingCollection->name_ar}}">
                                </div>
                                @if ($collection->name_ar != $editingCollection->name_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{old('description_en') ?? $editingCollection->description_en}}</textarea>
                                </div>
                                @if ($collection->description_en != $editingCollection->description_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                                <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="description_ar" id="input_description_ar" class="form-control"
                                              rows="5">{{old('description_ar') ?? $editingCollection->description_ar}}</textarea>
                                </div>
                                @if ($collection->description_ar != $editingCollection->description_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                                <div class="form-group">
                                    <label for="input-image" class="col-sm-3 control-label">
                                        Image
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="thumbnail imagebox">
                                            <div class="preview">
                                                @if(isset($editingCollection->image))
                                                    <img src="{{url('/') . '/images/' . $editingCollection->image}}"
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
                                        @if ($editingCollection->image)
                                            <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            <div class="form-group">
                                <label for="input_mealtime" class="col-sm-3 control-label">Mealtime</label>
                                <div class="col-sm-5">
                                    <select name="mealtime" id="mealtime" class="form-control">
                                        @foreach ($mealtimes as $mealtime)
                                            <option value="{{$mealtime->id}}"  @if(old('mealtime')){{ old('mealtime') == $mealtime->id ? 'selected':'' }} @else {{$editingCollection->mealtime_id == $mealtime->id ? 'selected' : ''}} @endif>{{$mealtime->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($collection->mealtime_id != $editingCollection->mealtime_id)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="female_caterer_available" class="col-sm-3 control-label">Female Caterer
                                    Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        @if(old('female_caterer_available') !== null)
                                            <label class="btn btn-success{{ (old('female_caterer_available') == '1') ? ' active' : '' }}">
                                                <input type="radio" name="female_caterer_available"
                                                       value="1" {{ (old('female_caterer_available') == '1') ? 'checked' : '' }}>
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{ (old('female_caterer_available') == '0') ? ' active' : '' }}">
                                                <input type="radio" name="female_caterer_available"
                                                       value="0" {{ (old('female_caterer_available') == '0') ? 'checked' : '' }}>
                                                No
                                            </label>
                                        @else
                                            <label class="btn btn-success{{$editingCollection->female_caterer_available == 1 ? ' active' : ''}}">
                                                <input type="radio"
                                                       name="female_caterer_available" value="1" {{$editingCollection->female_caterer_available == 1 ? 'checked' : ''}} >
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{$editingCollection->female_caterer_available == 0 ? ' active' : ''}} ">
                                                <input type="radio"
                                                       name="female_caterer_available"
                                                       value="0" {{$editingCollection->female_caterer_available == 0 ? 'checked' : ''}} >
                                                No
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                @if ($collection->female_caterer_available != $editingCollection->female_caterer_available)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            @if($collection->category_id != 4)
                                <div class="form-group{{ $errors->has('collection_price') ? ' has-error' : '' }}">
                                    <label for="input-price" class="col-sm-3 control-label">Price</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="collection_price" id="input-price"
                                                   class="form-control" value="{{old('collection_price') ?? $editingCollection->price}}"/>
                                            <span class="input-group-addon">
                                                    <i class="fa fa-money"></i>
                                                </span>
                                        </div>
                                    </div>
                                    @if ($collection->price != $editingCollection->price)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                @if($collection->category_id != 2)
                                    <div class="form-group{{ $errors->has('min_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection min quantity</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="1" name="min_quantity" class="form-control"
                                                   value="{{old('min_quantity') ?? $editingCollection->min_qty}}">
                                        </div>
                                        @if ($collection->min_qty != $editingCollection->min_qty)
                                            <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('max_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection max quantity</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="1" name="max_quantity" class="form-control"
                                                   value="{{old('max_quantity') ?? $editingCollection->max_qty}}">
                                        </div>
                                        @if ($collection->max_qty != $editingCollection->max_qty)
                                            <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                        @endif
                                    </div>
                                @endif
                                <div class="form-group{{ $errors->has('min_serve_to_person') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Min serve to person</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" name="min_serve_to_person" class="form-control"
                                               value="{{old('min_serve_to_person') ?? $editingCollection->min_serve_to_person}}">

                                    </div>
                                    @if ($collection->min_serve_to_person != $editingCollection->min_serve_to_person)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('max_serve_to_person') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Max serve to person</label>
                                    <div class="col-sm-5">
                                        <input type="number" min="1" name="max_serve_to_person" class="form-control"
                                               value="{{old('max_serve_to_person') ?? $editingCollection->max_serve_to_person}}">
                                    </div>
                                    @if ($collection->max_serve_to_person != $editingCollection->max_serve_to_person)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif
                            @if($collection->category_id == 2)
                                <div class="form-group">
                                    <label for="is_available" class="col-sm-3 control-label">Allow Person
                                        Increase</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            @if(old('allow_person_increase') !== null)
                                                <label class="btn btn-success{{ (old('allow_person_increase') == '1') ? ' active' : '' }}">
                                                    <input type="radio" name="allow_person_increase"
                                                           value="1" {{ (old('allow_person_increase') == '1') ? 'checked' : '' }}>
                                                    Yes
                                                </label>
                                                <label class="btn btn-danger{{ (old('allow_person_increase') == '0') ? ' active' : '' }}">
                                                    <input type="radio" name="allow_person_increase"
                                                           value="0" {{ (old('allow_person_increase') == '0') ? 'checked' : '' }}>
                                                    No
                                                </label>
                                            @else
                                                <label class="btn btn-success{{$editingCollection->allow_person_increase == 1 ? ' active' : ''}}">
                                                    <input type="radio"
                                                           name="allow_person_increase" value="1" {{$editingCollection->allow_person_increase == 1 ? 'checked' : ''}} >
                                                    Yes
                                                </label>
                                                <label class="btn btn-danger{{$editingCollection->is_available == 0 ? ' active' : ''}} ">
                                                    <input type="radio"
                                                           name="allow_person_increase"
                                                           value="0" {{$editingCollection->allow_person_increase == 0 ? 'checked' : ''}} >
                                                    No
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($collection->allow_person_increase != $editingCollection->allow_person_increase)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('setup_time') ? ' has-error' : '' }}">
                                    <label for="input-setup" class="col-sm-3 control-label">
                                        Setup Time
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="number" name="setup_time" id="input-setup"
                                                   class="form-control" min="1" value="{{old('setup_time') ?? $editingCollection->setup_time}}"/>
                                            <span class="input-group-addon">minutes</span>
                                        </div>
                                    </div>
                                    @if ($collection->setup_time != $editingCollection->setup_time)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('requirements_en') ? ' has-error' : '' }}">
                                    <label for="input_requirements_en" class="col-sm-3 control-label">Requirements
                                        En</label>
                                    <div class="col-sm-5">
                                            <textarea name="requirements_en" id="input_requirements_en"
                                                      class="form-control">{{old('requirements_en') ?? $editingCollection->requirements_en}}</textarea>
                                    </div>
                                    @if ($collection->requirements_en != $editingCollection->requirements_en)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('requirements_ar') ? ' has-error' : '' }}">
                                    <label for="input_requirements_ar" class="col-sm-3 control-label">Requirements
                                        Ar</label>
                                    <div class="col-sm-5">
                                            <textarea name="requirements_ar" id="input_requirements_ar"
                                                      class="form-control">{{old('requirements_ar') ?? $editingCollection->requirements_ar}}</textarea>
                                    </div>
                                    @if ($collection->requirements_ar != $editingCollection->requirements_ar)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('max_time') ? ' has-error' : '' }}">
                                    <label for="input-max" class="col-sm-3 control-label">
                                        Max Time
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="number" name="max_time" id="input-max" class="form-control"
                                                   min="1" value="{{old('max_time') ?? $editingCollection->max_time}}"/>
                                            <span class="input-group-addon">minutes</span>
                                        </div>
                                    </div>
                                    @if ($collection->max_time != $editingCollection->max_time)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div id="menus" class="tab-pane row wrap-all">
                            <div class="panel panel-default panel-table">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Collection Items</h3>
                                </div>
                                @if($editingCollection->editingCollectionItem->count() > 0)
                                <div class="table-responsive">
                                    <table border="0" class="table table-striped table-border">
                                        @if($collection->category_id == 1)
                                            <thead>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item</th>
                                                <th>Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($editingCollection->editingCollectionItem as $collectionItem)
                                                <tr>
                                                    <td style="font-size: medium">{{$collectionItem->item_id}}</td>
                                                    <td>
                                                        {{$collectionItem->quantity}}x
                                                        <sppan style="font-size: medium">{{$collectionItem->menu->name_en}}</sppan>
                                                    </td>
                                                    <td style="font-size: medium">{{$collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit')}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @else
                                            <thead>
                                            <tr>
                                                <th>Menu ID</th>
                                                <th>Menu</th>
                                                <th>Menu Min/Max Quantity</th>
                                                <th>Items(Id/Name - Price)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($editingCollectionMenus as $collectionMenu)
                                                <tr>
                                                    <td style="font-size: medium">
                                                        {{$collectionMenu->menu_id}}
                                                    </td>
                                                    <td>
                                                        <h3>{{$collectionMenu->category->name_en}}</h3>
                                                    </td>
                                                    <td style="font-size: medium">
                                                        @if($collection->category_id != 4)
                                                            {{$collectionMenu->min_qty . '/' . $collectionMenu->max_qty}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach($collectionMenu->editingCollectionItem->sortBy('collection_menu_id') as $collectionItem)
                                                            <div>
                                                                #{{$collectionItem->item_id}}
                                                                <span style="font-size: medium">/ {{$collectionItem->menu->name_en}}
                                                                    -</span>
                                                                @if($collectionItem->is_mandatory == 1)
                                                                    Mandatory
                                                                @else
                                                                    <span style="font-style: oblique">{{$collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit')}}</span>
                                                                @endif
                                                            </div>

                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                </div>
                                    @else
                                    <div class="table-responsive">
                                        <table border="0" class="table table-striped table-border">
                                            @if($collection->category_id == 1)
                                                <thead>
                                                <tr>
                                                    <th>Item ID</th>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($collection->collectionItem as $collectionItem)
                                                    <tr>
                                                        <td style="font-size: medium">{{$collectionItem->item_id}}</td>
                                                        <td>
                                                            {{$collectionItem->quantity}}x
                                                            <sppan style="font-size: medium">{{$collectionItem->menu->name_en}}</sppan>
                                                        </td>
                                                        <td style="font-size: medium">{{$collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit')}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @else
                                                <thead>
                                                <tr>
                                                    <th>Menu ID</th>
                                                    <th>Menu</th>
                                                    <th>Menu Min/Max Quantity</th>
                                                    <th>Items(Id/Name - Price)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($collection_menus as $collectionMenu)
                                                    <tr>
                                                        <td style="font-size: medium">
                                                            {{$collectionMenu->menu_id}}
                                                        </td>
                                                        <td>
                                                            <h3>{{$collectionMenu->category->name_en}}</h3>
                                                        </td>
                                                        <td style="font-size: medium">
                                                            @if($collection->category_id != 4)
                                                                {{$collectionMenu->min_qty . '/' . $collectionMenu->max_qty}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($collectionMenu->collectionItem->sortBy('collection_menu_id') as $collectionItem)
                                                                <div>
                                                                    #{{$collectionItem->item_id}}
                                                                    <span style="font-size: medium">/ {{$collectionItem->menu->name_en}}
                                                                        -</span>
                                                                    <span style="font-style: oblique">{{$collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit')}}</span>
                                                                </div>

                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="data" class="tab-pane row wrap-all">
                            <div id="type" class="form-group">
                                <label for="" class="col-sm-3 control-label">Service Type</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        @foreach ($categoryRestaurants as $categoryRestaurant)
                                            @if(old('service_type'))
                                                <label  class="btn btn-success {{(old('service_type') == $categoryRestaurant->name_en) ? ' active' : ''}}" >
                                                    <input type="radio" name="service_type" value="{{$categoryRestaurant->name_en}}" {{(old('service_type') == $categoryRestaurant->name_en) ? 'checked' : ''}}>
                                                    {{$categoryRestaurant->name_en}}
                                                </label>
                                            @else
                                                <label  class="btn btn-success {{($editingCollection->serviceType->name_en == $categoryRestaurant->name_en) ? ' active' : ''}}" >
                                                    <input type="radio" name="service_type" value="{{$categoryRestaurant->name_en}}" {{($editingCollection->serviceType->name_en == $categoryRestaurant->name_en) ? 'checked' : ''}}>
                                                    {{$categoryRestaurant->name_en}}
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @if ($collection->service_type_id != $editingCollection->service_type_id)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('delivery_time') ? ' has-error' : '' }}" id="delivery_hours" style="display: none">
                                <label for="input-max" class="col-sm-3 control-label">
                                    Delivery Time
                                </label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="number" name="delivery_time"  class="form-control"
                                               min="0" value="{{old('delivery_time') ?? $editingCollection->delivery_hours}}"/>
                                        <span class="input-group-addon">minutes</span>
                                    </div>
                                    @if ($collection->delivery_hours != $editingCollection->delivery_hours)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_en') ? ' has-error' : '' }}">
                                <label for="service_provide_en" class="col-sm-3 control-label">Service Provide
                                    En</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_en" class="form-control"
                                              id="service_provide_en">{{old('service_provide_en') ?? $editingCollection->service_provide_en}}</textarea>
                                </div>
                                @if ($collection->service_provide_en != $editingCollection->service_provide_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_ar') ? ' has-error' : '' }}">
                                <label for="service_provide_ar" class="col-sm-3 control-label">Service Provide
                                    Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_ar" class="form-control"
                                              id="service_provide_ar">{{old('service_provide_ar') ?? $editingCollection->service_provide_ar}}</textarea>
                                </div>
                                @if ($collection->service_provide_ar != $editingCollection->service_provide_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('service_presentation_en') ? ' has-error' : '' }}">
                                <label for="service_presentation_en" class="col-sm-3 control-label">Service Presentation
                                    En</label>
                                <div class="col-sm-5">
                                    <textarea name="service_presentation_en" class="form-control"
                                              id="service_presentation_en">{{old('service_presentation_en') ?? $editingCollection->service_presentation_en}}</textarea>
                                </div>
                                @if ($collection->service_presentation_en != $editingCollection->service_presentation_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('service_presentation_ar') ? ' has-error' : '' }}">
                                <label for="service_presentation_ar" class="col-sm-3 control-label">Service Presentation
                                    Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="service_presentation_ar" class="form-control"
                                              id="service_presentation_ar">{{old('service_presentation_ar') ?? $editingCollection->service_presentation_ar}}</textarea>
                                </div>
                                @if ($collection->service_presentation_ar != $editingCollection->service_presentation_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#collectionItems select').select2();

            var errorGeneral = $("#general .form-group .help-block").length;
            var errorMenu = $("#menus .form-group .help-block").length;
            var errorData = $("#data .form-group .help-block").length;
            if(errorData > 0){
                $('#dataTab').addClass('active');
                $('#data').addClass('active');
                $('#menuTab').removeClass('active');
                $('#menus').removeClass('active');
                $('#generalTab').removeClass('active');
                $('#general').removeClass('active');
            }
            if(errorMenu > 0){
                $('#menuTab').addClass('active');
                $('#menus').addClass('active');
                $('#dataTab').removeClass('active');
                $('#data').removeClass('active');
                $('#generalTab').removeClass('active');
                $('#general').removeClass('active');
            }
            if(errorGeneral > 0){
                $('#generalTab').addClass('active');
                $('#general').addClass('active');
                $('#dataTab').removeClass('active');
                $('#data').removeClass('active');
                $('#menuTab').removeClass('active');
                $('#menus').removeClass('active');
            }
        });
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
@endsection
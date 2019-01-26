@extends('home', ['title' => 'Collection: ' . $collection->name_en])
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
                      action="{{ url('/collection/update/' . $collection->id) }}" enctype="multipart/form-data">
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
                                           value="{{old('name_en') ?? $collection->name_en}}">
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_ar" id="input_name_ar" class="form-control"
                                           value="{{old('name_ar') ?? $collection->name_ar}}">
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
                                              rows="5">{{old('description_en') ?? $collection->description_en}}</textarea>
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
                                              rows="5">{{old('description_ar') ?? $collection->description_ar}}</textarea>
                                    @if ($errors->has('description_ar'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="input-image" class="col-sm-3 control-label">
                                        Image
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="thumbnail imagebox">
                                            <div class="preview">
                                                @if(isset($collection->image))
                                                    <img src="{{url('/') . '/images/' . $collection->image}}"
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
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            <div class="form-group">
                                <label for="input_mealtime" class="col-sm-3 control-label">Mealtime</label>
                                <div class="col-sm-5">
                                    <select name="mealtime" id="mealtime" class="form-control">
                                        @foreach ($mealtimes as $mealtime)
                                                <option value="{{$mealtime->id}}"  @if(old('mealtime')){{ old('mealtime') == $mealtime->id ? 'selected':'' }} @else {{$collection->mealtime_id == $mealtime->id ? 'selected' : ''}} @endif>{{$mealtime->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                            <label class="btn btn-success{{$collection->female_caterer_available == 1 ? ' active' : ''}}">
                                                <input type="radio"
                                                       name="female_caterer_available" value="1" {{$collection->female_caterer_available == 1 ? 'checked' : ''}} >
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{$collection->female_caterer_available == 0 ? ' active' : ''}} ">
                                                <input type="radio"
                                                       name="female_caterer_available"
                                                       value="0" {{$collection->female_caterer_available == 0 ? 'checked' : ''}} >
                                                No
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($collection->category_id != 4)
                                <div class="form-group{{ $errors->has('collection_price') ? ' has-error' : '' }}">
                                    <label for="input-price" class="col-sm-3 control-label">Price</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="collection_price" id="input-price"
                                                   class="form-control" value="{{old('collection_price') ?? $collection->price}}"/>
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
                                @if($collection->category_id != 2)
                                    <div class="form-group{{ $errors->has('min_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection min quantity</label>
                                        <div class="col-sm-5">
                                            <input type="number" min="1" name="min_quantity" class="form-control"
                                                   value="{{old('min_quantity') ?? $collection->min_qty}}">
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
                                                   value="{{old('max_quantity') ?? $collection->max_qty}}">
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
                                               value="{{old('min_serve_to_person') ?? $collection->min_serve_to_person}}">
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
                                               value="{{old('max_serve_to_person') ?? $collection->max_serve_to_person}}">
                                        @if ($errors->has('max_serve_to_person'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('max_serve_to_person') }}</strong>
                                            </span>
                                        @endif

                                    </div>
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
                                                    <label class="btn btn-success{{$collection->allow_person_increase == 1 ? ' active' : ''}}">
                                                        <input type="radio"
                                                               name="allow_person_increase" value="1" {{$collection->allow_person_increase == 1 ? 'checked' : ''}} >
                                                        Yes
                                                    </label>
                                                    <label class="btn btn-danger{{$collection->allow_person_increase == 0 ? ' active' : ''}} ">
                                                        <input type="radio"
                                                               name="allow_person_increase"
                                                               value="0" {{$collection->allow_person_increase == 0 ? 'checked' : ''}} >
                                                        No
                                                    </label>
                                                @endif
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
                                                   class="form-control" min="1" value="{{old('setup_time') ?? $collection->setup_time}}"/>
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
                                                      class="form-control">{{old('requirements_en') ?? $collection->requirements_en}}</textarea>
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
                                                      class="form-control">{{old('requirements_ar') ?? $collection->requirements_ar}}</textarea>
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
                                                   min="1" value="{{old('max_time') ?? $collection->max_time}}"/>
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
                        <div id="menus" class="tab-pane row wrap-all{{ $errors->has('menu_item') ? ' has-error' : '' }}">
                            <div class="form-group">
                                <label for="input_requirements_ar" class="col-sm-3 control-label">Collection Items</label>
                                <div class="col-sm-5">
                                    <div class="panel panel-default panel-table">
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
                                                                        @if($collection->category_id != 1)
                                                                            /
                                                                            @if($collectionItem->is_mandatory == 1)
                                                                                Mandatory
                                                                            @else
                                                                                <span style="font-style: oblique">{{$collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit')}}</span>
                                                                            @endif
                                                                        @endif

                                                                    </div>

                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_requirements_ar" class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <label class="action">
                                        <a class="btn btn-primary" type="button"  id="itemsEdit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </label>
                                </div>
                            </div>
                            <div id="menuItems" style="display: none{{(old('menu_item')) ? 'block' : ''}}">
                                @if($collection->category_id == 2 || $collection->category_id == 3)
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5">
                                            <div class="control-group control-group-2">
                                                <div class="input-group" style="font-size: medium">
                                                    <b>Menu min quantity</b>
                                                </div>
                                                <div class="input-group" style="font-size: medium">
                                                    <b>Menu max quantity</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @foreach($menu_categories as $menu_category)
                                    <div class="form-group" id="collectionMenus">
                                        <label for="input-status" class="col-sm-3 control-label text-right">
                                                <span class="text-right"
                                                      style="font-size: large">{{$menu_category->name_en}}</span>
                                            @if($collection->category_id != 1)
                                                <input type="hidden" name="menu[{{$menu_category->id}}][menu_id]"
                                                       value="{{$menu_category->id}}">
                                            @endif
                                        </label>
                                        <div class="col-sm-7">
                                            <div class="control-group control-group-3">
                                                @if($collection->category_id == 2 || $collection->category_id == 3)
                                                    <div class="input-group">
                                                        <input type="number"
                                                               name="menu[{{$menu_category->id}}][min_qty]"
                                                               class="form-control" min="1"
                                                               value="{{old('menu.' . $menu_category->id . '.min_qty') ?? 1}}">
                                                    </div>
                                                    <div class="input-group">
                                                        <input type="number"
                                                               name="menu[{{$menu_category->id}}][max_qty]"
                                                               class="form-control" min="1"
                                                               value="{{old('menu.' . $menu_category->id . '.max_qty') ?? 1}}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($collection->category_id == 1)
                                        @foreach($menu_category->menu as $menu)
                                            <div class="form-group" id="collectionItems">
                                                <label for="" class="col-sm-3 control-label"></label>
                                                <div class="col-xs-3">
                                                    <div class="checkbox" id="{{$menu->id}}">
                                                        <label style="font-size: medium">
                                                            <input id="item{{$menu->id}}" type="checkbox"
                                                                   name="menu[{{$menu->id}}][id]"
                                                                   value="{{$menu->id}}"
                                                                   {{ (collect(old('menu.' . $menu->id . '.id'))->contains($menu->id)) ? 'checked':'' }} onclick="myFunction('{{$menu->id}}')">{{$menu->name_en}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-5">
                                                    <div class="control-group control-group-3">
                                                        <div class="col-xs-3">
                                                            <input type="number"
                                                                   name="menu[{{$menu->id}}][qty]" id="qty{{$menu->id}}"
                                                                   style="display: none{{ (collect(old('menu_item.' . $menu->id . '.id'))->contains($menu->id)) ? 'block':'' }}" {{(!old('menu.' . $menu->id . '.id')) ? 'disabled': '' }}
                                                                   class="form-control" min="1" value="{{old('menu.' . $menu->id . '.qty') ?? 1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                            @foreach($menu_category->menu as $menu)
                                                <div class="form-group">
                                                    <label for="" class="col-sm-3 control-label"></label>
                                                    <div class="col-xs-2">
                                                        <div class="checkbox" id="{{$menu->id}}">
                                                            <label style="font-size: medium">
                                                                <input multiple id="item{{$menu->id}}" type="checkbox"
                                                                       name="menu[{{$menu_category->id}}][item][{{$menu->id}}][item_id]"
                                                                       value="{{$menu->id}}"
                                                                       {{ (collect(old('menu.' . $menu_category->id . '.item.' . $menu->id . '.item_id'))->contains($menu->id)) ? 'checked':'' }} onclick="myFunction('{{$menu->id}}')">{{$menu->name_en}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @if($collection->category_id != 4)
                                                        <div class="col-xs-2">
                                                            <select name="menu[{{$menu_category->id}}][item][{{$menu->id}}][is_mandatory]"
                                                                    id="option{{$menu->id}}" class="form-control"
                                                                    style="display: none{{ (collect(old('menu.' . $menu_category->id . '.item.' . $menu->id . '.item_id'))->contains($menu->id)) ? 'block':'' }}" {{(!old('menu.' . $menu_category->id . '.item.' . $menu->id . '.item_id')) ? 'disabled': '' }}>
                                                                <option value="1" {{(old('menu.' . $menu_category->id . '.item.' . $menu->id . '.is_mandatory') == 1 ) ? 'selected':''}}>
                                                                    Mandatory
                                                                </option>
                                                                <option value="0" {{(old('menu.' . $menu_category->id . '.item.' . $menu->id . '.is_mandatory') == 0 ) ? 'selected':''}}>
                                                                    Optional
                                                                </option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                    @endif
                                @endforeach
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-5">
                                            <label class="action">
                                                <a class="btn btn-danger" type="button" id="editCancel">
                                                   Cancel
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label"></label>
                                <div class="col-xs-3">
                                    @if ($errors->has('menu'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('menu') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="data" class="tab-pane row wrap-all">
                            <div id="type" class="form-group{{ $errors->has('service_type') ? ' has-error' : '' }}">
                                <label for="" class="col-sm-3 control-label">Service Type</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                        @foreach ($categoryRestaurants as $categoryRestaurant)
                                            @if(old('service_type'))
                                                <label  class="btn btn-success {{(old('service_type') == $categoryRestaurant->id) ? ' active' : ''}}" >
                                                    <input type="radio" name="service_type" value="{{$categoryRestaurant->id}}" {{(old('service_type') == $categoryRestaurant->id) ? 'checked' : ''}}>
                                                    {{$categoryRestaurant->name_en}}
                                                </label>
                                                @else
                                            <label  class="btn btn-success {{($collection->service_type_id == $categoryRestaurant->id) ? ' active' : ''}}" >
                                                <input type="radio" name="service_type" value="{{$categoryRestaurant->id}}" {{($collection->service_type_id  == $categoryRestaurant->id) ? 'checked' : ''}}>
                                                {{$categoryRestaurant->name_en}}
                                            </label>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if ($errors->has('service_type'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('service_type') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('notice_period') ? ' has-error' : '' }}" >
                                <label for="input-max" class="col-sm-3 control-label">
                                    Notice Period
                                </label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="number" name="notice_period"  class="form-control"
                                               min="1" value="{{old('notice_period') ?? $collection->delivery_hours}}"/>
                                        <span class="input-group-addon">minutes</span>
                                    </div>
                                    @if ($errors->has('notice_period'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('notice_period') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_en') ? ' has-error' : '' }}">
                                <label for="service_provide_en" class="col-sm-3 control-label">Service Provide
                                    En</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_en" class="form-control"
                                              id="service_provide_en">{{old('service_provide_en') ?? $collection->service_provide_en}}</textarea>
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
                                              id="service_provide_ar">{{old('service_provide_ar') ?? $collection->service_provide_ar}}</textarea>
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
                                              id="service_presentation_en">{{old('service_presentation_en') ?? $collection->service_presentation_en}}</textarea>
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
                                              id="service_presentation_ar">{{old('service_presentation_ar') ?? $collection->service_presentation_ar}}</textarea>
                                    @if ($errors->has('service_presentation_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('service_presentation_ar') }}</strong>
                                    </span>
                                    @endif
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
        $('#itemsEdit').click(function () {
            $('#menuItems').slideDown('fast');
        });
        $('#editCancel').click(function () {
            $('#menuItems').slideUp('fast');
            $('#collectionItems input[type=checkbox]').prop('checked', false);
            $('#collectionItems input[type=number]').slideUp('fast');
            $('#collectionItems input[type=number]').val(1);
            $('#collectionItems input[type=number]').attr('disabled', true);
            $("#collectionItems select").each(function () {
                $(this).select2('val', '')
            });
            $('#collectionMenus input[type=number]').val(1);
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
    <script>
        function myFunction(id) {
            var item = document.getElementById("item" + id);
            if (item.checked == true) {
                $('#qty' + id).slideDown('fast');
                $('#qty' + id).removeAttr('disabled');
                $('#option' + id).slideDown('fast');
                $('#option' + id).removeAttr('disabled');
            } else {
                $('#qty' + id).slideUp('fast');
                $('#qty' + id).attr('disabled', true);
                $('#option' + id).slideUp('fast');
                $('#option' + id).attr('disabled', true);
            }
        }
    </script>
@endsection
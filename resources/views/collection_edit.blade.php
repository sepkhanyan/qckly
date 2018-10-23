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
                        <li class="active"><a href="#general" data-toggle="tab">Collection Details</a></li>
                        <li><a href="#menus" data-toggle="tab">Collection Items</a></li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      action="{{ url('/collection/update/' . $collection->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$collection->restaurant_id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$collection->category->name_en}}</h4>
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{$collection->name_en}}">
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
                                           value="{{$collection->name_ar}}">
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
                                              rows="5">{{$collection->description_en}}</textarea>
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
                                              rows="5">{{$collection->description_ar}}</textarea>
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
                                        <option value="{{$collection->mealtime_id}}">{{$collection->mealtime->name_en}}</option>
                                        @foreach ($mealtimes as $mealtime)
                                            @if($collection->mealtime_id != $mealtime->id)
                                                <option value="{{$mealtime->id}}">{{$mealtime->name_en}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="female_caterer_available" class="col-sm-3 control-label">Female Caterer
                                    Available</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        @if($collection->female_caterer_available == 0)
                                            <label class="btn btn-danger active">
                                                <input type="radio" name="female_caterer_available" value="0"
                                                       checked="checked">
                                                NO
                                            </label>
                                            <label class="btn btn-success">
                                                <input type="radio" name="female_caterer_available" value="1">
                                                YES
                                            </label>
                                        @else
                                            <label class="btn btn-danger ">
                                                <input type="radio" name="female_caterer_available" value="0">
                                                NO
                                            </label>
                                            <label class="btn btn-success active">
                                                <input type="radio" name="female_caterer_available" value="1"
                                                       checked="checked">
                                                YES
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('service_provide_en') ? ' has-error' : '' }}">
                                <label for="service_provide_en" class="col-sm-3 control-label">Service Provide
                                    En</label>
                                <div class="col-sm-5">
                                    <textarea name="service_provide_en" class="form-control"
                                              id="service_provide_en">{{$collection->service_provide_en}}</textarea>
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
                                              id="service_provide_ar">{{$collection->service_provide_ar}}</textarea>
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
                                              id="service_presentation_en">{{$collection->service_presentation_en}}</textarea>
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
                                              id="service_presentation_ar">{{$collection->service_presentation_ar}}</textarea>
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
                                        @if($collection->is_available == 0)
                                            <label class="btn btn-danger active">
                                                <input type="radio" name="is_available" value="0" checked="checked">
                                                NO
                                            </label>
                                            <label class="btn btn-success">
                                                <input type="radio" name="is_available" value="1">
                                                YES
                                            </label>
                                        @else
                                            <label class="btn btn-danger ">
                                                <input type="radio" name="is_available" value="0">
                                                NO
                                            </label>
                                            <label class="btn btn-success active">
                                                <input type="radio" name="is_available" value="1" checked="checked">
                                                YES
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
                                                   class="form-control" value="{{$collection->price}}"/>
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
                                        <div class="col-xs-2">
                                            <input type="number" min="1" name="min_quantity" class="form-control"
                                                   value="{{$collection->min_qty}}">
                                            @if ($errors->has('min_quantity'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('min_quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('max_quantity') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">Collection max quantity</label>
                                        <div class="col-xs-2">
                                            <input type="number" min="1" name="max_quantity" class="form-control"
                                                   value="{{$collection->max_qty}}">
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
                                    <div class="col-xs-2">
                                        <input type="number" min="1" name="min_serve_to_person" class="form-control"
                                               value="{{$collection->min_serve_to_person}}">
                                        @if ($errors->has('min_serve_to_person'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('min_serve_to_person') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('max_serve_to_person') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Max serve to person</label>
                                    <div class="col-xs-2">
                                        <input type="number" min="1" name="max_serve_to_person" class="form-control"
                                               value="{{$collection->max_serve_to_person}}">
                                        @if ($errors->has('max_serve_to_person'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('max_serve_to_person') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            @endif
                            @if($collection->category_id == 2)
                                <div class="form-group{{ $errors->has('persons_max_count') ? ' has-error' : '' }}">
                                    <label class="col-sm-3 control-label">Persons max count</label>
                                    <div class="col-xs-2">
                                        <input type="number" min="1" name="persons_max_count" class="form-control"
                                               value="{{$collection->persons_max_count}}">
                                        @if ($errors->has('persons_max_count'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('persons_max_count') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="is_available" class="col-sm-3 control-label">Allow Person
                                        Increase</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            @if($collection->allow_person_increase == 0)
                                                <label class="btn btn-danger active">
                                                    <input type="radio" name="allow_person_increase" value="0"
                                                           checked="checked">
                                                    NO
                                                </label>
                                                <label class="btn btn-success">
                                                    <input type="radio" name="allow_person_increase" value="1">
                                                    YES
                                                </label>
                                            @else
                                                <label class="btn btn-danger">
                                                    <input type="radio" name="allow_person_increase" value="0">
                                                    NO
                                                </label>
                                                <label class="btn btn-success  active">
                                                    <input type="radio" name="allow_person_increase" value="1"
                                                           checked="checked">
                                                    YES
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
                                                   class="form-control" min="0" value="{{$collection->setup_time}}"/>
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
                                                      class="form-control">{{$collection->requirements_en}}</textarea>
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
                                                      class="form-control">{{$collection->requirements_ar}}</textarea>
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
                                                   min="0" value="{{$collection->max_time}}"/>
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
                            <div class="panel panel-default panel-table">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Collection Items</h3>
                                </div>
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
                                            <tr>
                                                <td class="thick-line text-left" style="font-size: 20px">
                                                    <a class="btn btn-primary" type="button" class="btn btn-info btn-lg"
                                                       data-toggle="modal" data-target="#myModal">Edit</a>
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td class="thick-line text-left" style="font-size: 20px">
                                                    <a class="btn btn-primary" type="button" class="btn btn-info btn-lg"
                                                       data-toggle="modal" data-target="#myModal">Edit</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="modal fade" id="myModal" role="dialog">
                                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8"
                                      method="POST"
                                      action="{{ url('/collection/update/' . $collection->id) }}"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title">Menu Items</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="" class="col-sm-3 control-label"></label>
                                                    <div class="col-xs-2">
                                                        <div class="checkbox" style="font-size: medium;">
                                                            <label>
                                                                <input type="checkbox"
                                                                       onclick="$('input[name*=\'menu_item\']').prop('checked', this.checked);">
                                                                Select All
                                                            </label>
                                                            @if ($errors->has('menu_item_qty'))
                                                                <span class="help-block">
                                                    <strong>{{ $errors->first('menu_item_qty') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach($menu_categories as $menu_category)
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"
                                                               style="font-size: medium;">
                                                            {{$menu_category->name_en}}
                                                            <input type="hidden" name="menu[]"
                                                                   value="{{$menu_category->id}}">
                                                        </label>
                                                        @if($collection->category_id == 2 || $collection->category_id == 3)
                                                            <div class="col-xs-2">
                                                                <input type="number" name="menu_min_qty[]" min="1"
                                                                       value=""
                                                                       class="form-control"
                                                                       placeholder="Menu min quantity">
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <input type="number" name="menu_max_qty[]" min="1"
                                                                       value=""
                                                                       class="form-control"
                                                                       placeholder="Menu max quantity">
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
                                                                               value="{{$menu->id}}">
                                                                        {{$menu->name_en}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if($collection->category_id == 1)
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
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
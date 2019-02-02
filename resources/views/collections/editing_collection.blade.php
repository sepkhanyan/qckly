<div id="page-wrapper" style="margin: 0; padding: 20px 20px">
    <div class="row content">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">

                <li class="active">
                    <a href="#old" data-toggle="tab">Old Details</a>
                </li>

                <li>
                    <a href="#new" data-toggle="tab">New Details</a>
                </li>

            </ul>
        </div>
        <div class="tab-content">
            <div id="old" class="tab-pane row wrap-all active">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Collection Old Fields</h3>
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form-horizontal">
                            <fieldset class="content-group">
                                
                                @if (isset($oldFields['name_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name En </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['name_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['name_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['name_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['price']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Price </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['price'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['description_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['description_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['description_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['service_provide_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Provide En </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['service_provide_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['service_provide_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Provide Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['service_provide_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['setup_time']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Setup Time </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['setup_time'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['max_time']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max Time </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['max_time'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['requirements_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Requirements En </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['requirements_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['requirements_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Requirements Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['requirements_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['service_presentation_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Presentation En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['service_presentation_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['service_presentation_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Presentation Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['service_presentation_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['min_serve_to_person']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Min serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['min_serve_to_person'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['max_serve_to_person']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['max_serve_to_person'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['female_caterer_available']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Female Caterer Available </label>
                                        <div class="col-lg-5">
                                            <input type="radio" {{ $oldFields['female_caterer_available'] == 1 ? 'checked' : '' }} readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['notice_period']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Notice Period </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['notice_period'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['min_qty']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Collection min quantity </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['min_qty'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['max_qty']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Collection max quantity </label>
                                        <div class="col-lg-5">
                                            <input type="number" class="form-control" value="{{ $oldFields['max_qty'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['mealtime_id']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldMealTime }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['allow_person_increase']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Allow Person Increase </label>
                                        <div class="col-lg-5">
                                            <input type="radio" {{ $oldFields['allow_person_increase'] == 1 ? 'checked' : '' }} readonly>
                                        </div>
                                    </div>
                                @endif
                                
                                @if ($editedCollection->editingCollectionItem->isNotEmpty() || $editedCollection->editingCollectionMenu->isNotEmpty())
                                    <table border="0" class="table table-striped table-border">
                                        <label for="">Collection Items</label>
                                        @if($collection->category_id == 1)
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($collection->approvedCollectionItem as $collectionItem)
                                                    <tr>
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
                                                    <th>Menu</th>
                                                    <th>Menu Min/Max Quantity</th>
                                                    <th>Item(Name - Price)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($collection->approvedCollectionMenu as $menu)
                                                    <tr>
                                                        <td>
                                                            <h3>{{ $menu->category->name_en }}</h3>
                                                        </td>
                                                        <td style="font-size: medium">
                                                            @if($collection->category_id != 4)
                                                                {{ $menu->min_qty . '/' . $menu->max_qty }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($menu->approvedCollectionItem->sortBy('collection_menu_id') as $collectionItem)
                                                                <div>
                                                                    <span style="font-size: medium">{{ $collectionItem->menu->name_en }} </span>
                                                                    @if($collection->category_id != 1)
                                                                        /
                                                                        @if($collectionItem->is_mandatory == 1)
                                                                            Mandatory
                                                                        @else
                                                                            <span style="font-style: oblique">{{ $collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit') }}</span>
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
                                @endif

                                @if (isset($oldFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Allow Person Increase </label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $oldFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <div id="new" class="tab-pane row wrap-all">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Collection New Fields</h3>
                    </div>

                    <div class="panel-body">
                        <form role="form" id="editForm" class="form-horizontal" method="POST" action="{{ url('/collection/edit_approve/' . $collection->id) }}" data-id="{{ $collection->id }}" enctype="multipart/form-data">
                            <fieldset class="content-group">
                                {{ csrf_field() }}

                                @if (isset($newFields['name_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name En </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="name_en" class="form-control" value="{{ $newFields['name_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['name_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="name_ar" class="form-control" value="{{ $newFields['name_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['price']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Price </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="price" class="form-control" value="{{ $newFields['price'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="description_en" rows="5" readonly>{{ $newFields['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="description_ar" rows="5" readonly>{{ $newFields['description_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['service_provide_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Provide En </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="service_provide_en" class="form-control" value="{{ $newFields['service_provide_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['service_provide_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Provide Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="service_provide_ar" class="form-control" value="{{ $newFields['service_provide_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['setup_time']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Setup Time </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="setup_time" class="form-control" value="{{ $newFields['setup_time'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['max_time']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max Time </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="" class="form-control" value="{{ $newFields['max_time'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['requirements_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Requirements En </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="requirements_en" class="form-control" value="{{ $newFields['requirements_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['requirements_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Requirements Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="requirements_ar" class="form-control" value="{{ $newFields['requirements_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['service_presentation_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Presentation En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="service_presentation_en" rows="5" readonly>{{ $newFields['service_presentation_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['service_presentation_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Service Presentation Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="service_presentation_ar" rows="5" readonly>{{ $newFields['service_presentation_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['min_serve_to_person']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Min serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="min_serve_to_person" class="form-control" value="{{ $newFields['min_serve_to_person'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['max_serve_to_person']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="max_serve_to_person" class="form-control" value="{{ $newFields['max_serve_to_person'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['female_caterer_available']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Female Caterer Available </label>
                                        <div class="col-lg-5">
                                            <input type="radio" name="female_caterer_available" {{ $newFields['female_caterer_available'] == 1 ? 'checked' : '' }} readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['notice_period']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Notice Period </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="notice_period" class="form-control" value="{{ $newFields['notice_period'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['min_qty']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Collection min quantity </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="min_qty" class="form-control" value="{{ $newFields['min_qty'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['max_qty']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Collection max quantity </label>
                                        <div class="col-lg-5">
                                            <input type="number" name="max_qty" class="form-control" value="{{ $newFields['max_qty'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['mealtime_id']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Max serve to person </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $newMealTime->name_en }}" readonly>
                                            <input type="hidden" name="mealtime_id" class="form-control" value="{{ $newFields['mealtime_id'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['allow_person_increase']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Allow Person Increase </label>
                                        <div class="col-lg-5">
                                            <input type="radio" name="allow_person_increase" {{ $newFields['allow_person_increase'] == 1 ? 'checked' : '' }} readonly>
                                        </div>
                                    </div>
                                @endif
                                
                                @if ($editedCollection->editingCollectionItem->isNotEmpty() || $editedCollection->editingCollectionMenu->isNotEmpty())
                                    <table border="0" class="table table-striped table-border">
                                        <label for="">Collection Items</label>
                                        @if($collection->category_id == 1)
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($editedCollection->editingCollectionItem as $collectionItem)
                                                    <tr>
                                                        <td>
                                                            {{ $collectionItem->quantity }}x
                                                            <sppan style="font-size: medium">{{ $collectionItem->menu->name_en }}</sppan>
                                                        </td>
                                                        <td style="font-size: medium">{{ $collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th>Menu</th>
                                                    <th>Menu Min/Max Quantity</th>
                                                    <th>Items(Id/Name - Price)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($editedCollection->editingCollectionMenu as $menu)
                                                    <tr>
                                                        <td>
                                                            <h3>{{ $menu->category->name_en }}</h3>
                                                        </td>
                                                        <td style="font-size: medium">
                                                            @if($editedCollection->category_id != 4)
                                                                {{ $menu->min_qty . '/' . $menu->max_qty }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @foreach($menu->editingCollectionItem->sortBy('collection_menu_id') as $collectionItem)
                                                                <div>
                                                                    <span style="font-size: medium">{{ $collectionItem->menu->name_en }} </span>
                                                                    @if($editedCollection->category_id != 1)
                                                                        /
                                                                        @if($collectionItem->is_mandatory == 1)
                                                                            Mandatory
                                                                        @else
                                                                            <span style="font-style: oblique">{{ $collectionItem->menu->price . ' ' . \Lang::get('message.priceUnit') }}</span>
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
                                @endif

                                @if (isset($newFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Allow Person Increase </label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $newFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success" style="margin-top: 10px;">Approve</button>
                                    <button type="button" class="btn btn-danger" id="reject" data-id="{{ $collection->id }}" style="margin-top: 10px;">Reject</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
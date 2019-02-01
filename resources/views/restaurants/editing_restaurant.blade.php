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
                        <h3 class="panel-title">Restaurant Old Fields</h3>
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

                                @if (isset($oldFields['email']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Email </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['email'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['telephone']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Telephone </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['telephone'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Image </label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $oldFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif

                                @if ($oldAreas)
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">City</label>
                                        <div class="col-lg-5">
                                            <select name="area[]" id="oldAreas" class="form-control select2" multiple disabled>
                                            @foreach($oldAreas as $oldArea)
                                                <option value="{{ $oldArea->area_id }}" @if(old('area')) {{ (collect(old('area'))->contains($oldArea->area_id)) ? 'selected':'' }} @else selected @endif>
                                                    {{ $oldArea->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                @endif

                                @if ($oldCategories)
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-5">
                                            <select name="category[]" id="oldCategories" class="form-control select2" multiple disabled>
                                            @foreach($oldCategories as $oldCategory)
                                                <option value="{{ $oldCategory->category_id }}" @if(old('category')) {{ (collect(old('category'))->contains($oldCategory->category_id)) ? 'selected':'' }} @else selected @endif>
                                                    {{ $oldCategory->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
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
                        <h3 class="panel-title">Restaurant Edited Fields</h3>
                    </div>

                    <div class="panel-body">
                        <form role="form" id="editForm" class="form-horizontal" method="POST" action="{{ url('/restaurant/edit_approve/' . $restaurant->id ) }}" data-id="{{ $restaurant->id }}" enctype="multipart/form-data">
                            <fieldset class="content-group">
                                {{ csrf_field() }}

                                @if (isset($newFields['name_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name En </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="restaurant_name_en" class="form-control" value="{{ $newFields['name_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['name_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="restaurant_name_ar" class="form-control" value="{{ $newFields['name_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description En </label>
                                        <div class="col-lg-5">
                                            <textarea name="description_en" class="form-control" rows="5" readonly>{{ $newFields['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description Ar </label>
                                        <div class="col-lg-5">
                                            <textarea name="description_ar" class="form-control" rows="5" readonly>{{ $newFields['description_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['email']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Email </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="restaurant_email" class="form-control" value="{{ $newFields['email'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['telephone']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Telephone </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="restaurant_telephone" class="form-control" value="{{ $newFields['telephone'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Image </label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $newFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif

                                @if ($newAreas)
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">City</label>
                                        <div class="col-lg-5">
                                            <select name="area[]" id="newAreas" class="form-control select2" multiple disabled>
                                            @foreach($newAreas as $newArea)
                                                <option value="{{ $newArea->area_id }}" {{ old('area') ? (collect(old('area'))->contains($newArea->area_id) ? 'selected' : '') : 'selected' }}>
                                                    {{ $newArea->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                @endif

                                @if ($newCategories)
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-5">
                                            <select name="category[]" id="newCategories" class="form-control select2" multiple disabled>
                                            @foreach($newCategories as $newCategory)
                                                <option value="{{ $newCategory->category_id }}" {{ old('category') ? (collect(old('category'))->contains($newCategory->category_id) ? 'selected' : '') : 'selected' }}>
                                                    {{ $newCategory->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                @endif

                                @if ($newAreas)
                                    <div class="form-group" hidden>
                                        <label class="control-label col-lg-3">City</label>
                                        <div class="col-lg-5">
                                            <select name="area[]" id="newAreas" class="form-control select2" multiple>
                                            @foreach($newAreas as $newArea)
                                                <option value="{{ $newArea->area_id }}" {{ old('area') ? (collect(old('area'))->contains($newArea->area_id) ? 'selected' : '') : 'selected' }}>
                                                    {{ $newArea->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                @endif

                                @if ($newCategories)
                                    <div class="form-group" hidden>
                                        <label class="control-label col-lg-3">Category</label>
                                        <div class="col-lg-5">
                                            <select name="category[]" id="newCategories" class="form-control select2" multiple>
                                            @foreach($newCategories as $newCategory)
                                                <option value="{{ $newCategory->category_id }}" {{ old('category') ? (collect(old('category'))->contains($newCategory->category_id) ? 'selected' : '') : 'selected' }}>
                                                    {{ $newCategory->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success" style="margin-top: 10px;">Approve</button>
                                    <button type="button" class="btn btn-danger" style="margin-top: 10px;">Reject</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.select2').select2()
</script>
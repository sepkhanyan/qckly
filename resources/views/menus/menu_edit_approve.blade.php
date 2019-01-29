@extends('home', ['title' => 'Menu: ' . $menu->name_en])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-check"></i>
                    Approve
                </a>
                <a class="btn btn-danger" title=""
                   href="{{ url('menu/edit_reject/' . $menu->id )}}">
                    <i class="fa fa-ban"></i>
                    Reject
                </a>&nbsp;
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li class="active"><a href="#general" data-toggle="tab">Menu</a></li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data"
                      accept-charset="utf-8" method="POST" action="{{ url('/menu/edit_approve/' . $menu->id) }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if($user->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$menu->restaurant_id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$menu->category->name_en}}</h4>
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{ old('name_en') ?? $editingMenu->name_en }}">
                                </div>
                                @if ($menu->name_en != $editingMenu->name_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_ar" id="input_name_ar" class="form-control"
                                           value="{{ old('name_ar') ?? $editingMenu->name_ar }}">
                                </div>
                                @if ($menu->name_ar != $editingMenu->name_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="5">{{ old('description_en') ?? $editingMenu->description_en }}</textarea>
                                </div>
                                @if ($menu->description_en != $editingMenu->description_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                                <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="description_ar" id="input_description_ar" class="form-control"
                                              rows="5">{{ old('description_ar') ?? $editingMenu->description_ar }}</textarea>
                                </div>
                                @if ($menu->description_ar != $editingMenu->description_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="input_price" class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="price" id="input_price" class="form-control"
                                               value="{{ old('price') ?? $editingMenu->price }}"/>
                                        <span class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                    </div>
                                </div>
                                @if ($menu->price != $editingMenu->price)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="famous" class="col-sm-3 control-label">Famous</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        @if(old('famous') !== null)
                                            <label class="btn btn-success{{ (old('famous') == '1') ? ' active' : '' }}">
                                                <input type="radio" name="famous"
                                                       value="1" {{ (old('famous') == '1') ? 'checked' : '' }}>
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{ (old('famous') == '0') ? ' active' : '' }}">
                                                <input type="radio" name="famous"
                                                       value="0" {{ (old('famous') == '0') ? 'checked' : '' }}>
                                                No
                                            </label>
                                        @else
                                            <label class="btn btn-success{{$editingMenu->famous == 1 ? ' active' : ''}}">
                                                <input type="radio"
                                                       name="famous" value="1" {{$editingMenu->famous == 1 ? 'checked' : ''}} >
                                                Yes
                                            </label>
                                            <label class="btn btn-danger{{$editingMenu->famous == 0 ? ' active' : ''}} ">
                                                <input type="radio"
                                                       name="famous"
                                                       value="0" {{$editingMenu->famous == 0 ? 'checked' : ''}} >
                                                No
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                @if ($menu->famous != $editingMenu->famous)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update menu image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            @if(isset($editingMenu->image))
                                                <img src="{{url('/') . '/images/' . $editingMenu->image}}"
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
                                    @if ($editingMenu->image)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-5">
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                <label class="btn btn-success{{$editingMenu->status == 1 ? ' active' : ''}}">
                                                    <input type="radio"
                                                           name="status" value="1" {{$editingMenu->status == 1 ? 'checked' : ''}} >
                                                    Enabled
                                                </label>
                                                <label class="btn btn-danger{{$editingMenu->status == 0 ? ' active' : ''}} ">
                                                    <input type="radio"
                                                           name="status"
                                                           value="0" {{$editingMenu->status == 0 ? 'checked' : ''}} >
                                                    Disabled
                                                </label>
                                        </div>
                                    </div>
                                    @if ($menu->status != $editingMenu->status)
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
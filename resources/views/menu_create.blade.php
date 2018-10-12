@extends('home', ['title' => 'Menu: New'])
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
                        <li class="active"><a href="#general" data-toggle="tab">Menu</a></li>
                    </ul>
                </div>

                <form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data"
                      accept-charset="utf-8" method="POST" action="{{ url('/menu/store') }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$restaurant->id}}">
                            @endif
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
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
                            <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
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
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="input_price" class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="price" id="input_price" class="form-control"
                                               value="{{ old('price') }}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-money"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                <label for="input_category" class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-5">
                                    <select name="category" id="input_category" class="form-control">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name_en}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="famous" class="col-sm-3 control-label">Famous</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-danger">
                                            <input type="radio" name="famous" value="0">
                                            No
                                        </label>
                                        <label class="btn btn-success active">
                                            <input type="radio" name="famous" value="1" checked="checked">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">Image <span class="help-block">Select an image to use as the location logo, this image is displayed in the restaurant list.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="thumbnail imagebox" id="selectImage">--}}
                            {{--<div class="preview">--}}
                            {{--<img src="{{url('/') . '/admin/no_photo.png'}}"--}}
                            {{--class="thumb img-responsive" id="thumb">--}}
                            {{--</div>--}}
                            {{--<div class="caption">--}}
                            {{--<span class="name text-center"></span>--}}
                            {{--<input type="hidden" name="image" value="" id="field" >--}}
                            {{--<p>--}}
                            {{--<a id="select-image" class="btn btn-primary">--}}
                            {{--<i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>--}}
                            {{--<a class="btn btn-danger"--}}
                            {{--onclick="$('#thumb').attr('src', {{url('/') . '/admin/no_photo.png'}}); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i--}}
                            {{--class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>--}}
                            {{--</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update menu image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            <img src="{{url('/') . '/admin/no_photo.png'}}"
                                                 class="thumb img-responsive" id="thumb">
                                        </div>
                                        <div class="caption">
                                            <span class="name text-center"></span>
                                            <p>
                                                <label class=" btn btn-primary btn-file ">
                                                    <i class="fa fa-picture-o"></i> Select <input type="file"
                                                                                                  name="image"
                                                                                                  style="display: none;"
                                                                                                  onchange="readURL(this);">

                                                </label>
                                                <label class="btn btn-danger "
                                                       onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label class="btn btn-danger">
                                            <input type="radio" name="status" value="0">
                                            Disabled
                                        </label>
                                        <label class="btn btn-success active">
                                            <input type="radio" name="status" value="1" checked="checked">
                                            Enabled
                                        </label>
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
        }
    </script>
    <script type="text/javascript">
        $('#restaurant ').select2();
    </script>
    {{--<div id="media-manager" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"--}}
    {{--style="display: none;">--}}
    {{--<div class="modal-dialog modal-lg">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
    {{--<h4 class="modal-title">Image Manager</h4></div>--}}
    {{--<div class="modal-body wrap-none">--}}
    {{--<iframe  name="media_manager"--}}
    {{--src="{{url('/image_manager?popup=iframe')}}"--}}
    {{--width="100%" height="869px" frameborder="0" style="height: 558px;"></iframe>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection
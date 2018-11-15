@extends('home', ['title' => 'Menu: ' . $menu->name_en])
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
                      accept-charset="utf-8" method="POST" action="{{ url('/menu/update/' . $menu->id) }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if(Auth::user()->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$menu->restaurant_id}}">
                            @endif
                            <h4 class="tab-pane-title">{{$menu->category->name_en}}</h4>
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{ old('name_en') ?? $menu->name_en }}">
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
                                           value="{{ old('name_ar') ?? $menu->name_ar }}">
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
                                              rows="5">{{ old('description_en') ?? $menu->description_en }}</textarea>
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
                                              rows="5">{{ old('description_ar') ?? $menu->description_ar }}</textarea>
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
                                               value="{{ old('price') ?? $menu->price }}"/>
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
                            <div class="form-group">
                                <label for="famous" class="col-sm-3 control-label">Famous</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <label @if(old('famous')) class="btn btn-danger{{ (old('famous') == '0') ? ' active' : '' }}" @else class="btn btn-danger{{$menu->famous == 0 ? ' active' : ''}} " @endif>
                                                <input type="radio" name="famous" value="0"  @if(old('famous')) {{ (old('famous') == '0') ? 'checked' : '' }} @else {{$menu->famous == 0 ? 'checked' : ''}} @endif>
                                                No
                                            </label>
                                            <label @if(old('famous')) class="btn btn-success{{(old('famous') == '1') ? ' active' : '' }}" @else class="btn btn-success{{$menu->famous == 1 ? ' active' : ''}} " @endif>
                                                <input type="radio" name="famous" value="1" @if(old('famous')) {{ (old('famous') == '1') ? 'checked' : '' }} @else {{$menu->famous == 1 ? 'checked' : ''}} @endif>
                                                Yes
                                            </label>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">--}}
                            {{--<label for="" class="col-sm-3 control-label">--}}
                            {{--Image--}}
                            {{--<span class="help-block">Select a file to update menu image, otherwise leave blank.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="thumbnail imagebox" id="selectImage">--}}
                            {{--<div class="preview">--}}
                            {{--<img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png"--}}
                            {{--class="thumb img-responsive" id="thumb">--}}
                            {{--</div>--}}
                            {{--<div class="caption">--}}
                            {{--<span class="name text-center"></span>--}}
                            {{--<input type="file" name="image" class="form-control">--}}
                            {{--@if ($errors->has('image'))--}}
                            {{--<span class="help-block">--}}
                            {{--<strong>{{ $errors->first('image') }}</strong>--}}
                            {{--</span>--}}
                            {{--@endif--}}
                            {{--<input type="hidden" name="menu_photo" value="" id="field" />--}}
                            {{--<p>--}}
                            {{--<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>--}}
                            {{--<a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>--}}
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
                                            @if(isset($menu->image))
                                                <img src="{{url('/') . '/images/' . $menu->image}}"
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
                                                    <input type="file" name="image" style="display: none;" onchange="readURL(this);">

                                                </label>
                                                <label class="btn btn-danger " onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>
                                                    &nbsp;&nbsp;Remove
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-status" class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-5">
                                    <div class="btn-group btn-group-switch" data-toggle="buttons">
                                        <label @if(old('status')) class="btn btn-danger{{ (old('status') == '0') ? ' active' : '' }}" @else class="btn btn-danger{{$menu->status == 0 ? ' active' : ''}} " @endif>
                                            <input type="radio" name="status" value="0"  @if(old('status')) {{ (old('status') == '0') ? 'checked' : '' }} @else {{$menu->status == 0 ? 'checked' : ''}} @endif>
                                            Disabled
                                        </label>
                                        <label @if(old('status')) class="btn btn-success{{(old('status') == '1') ? ' active' : '' }}" @else class="btn btn-success{{$menu->status == 1 ? ' active' : ''}} " @endif>
                                            <input type="radio" name="status" value="1" @if(old('status')) {{ (old('status') == '1') ? 'checked' : '' }} @else {{$menu->status == 1 ? 'checked' : ''}} @endif>
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
            $('input[name=image]').val("");
        }
    </script>
@endsection
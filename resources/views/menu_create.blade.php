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
                                            Disabled
                                        </label>
                                        <label class="btn btn-success active">
                                            <input type="radio" name="famous" value="1" checked="checked">
                                            Enabled
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update menu image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox" id="selectImage">
                                        <div class="preview">
                                            <img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png"
                                                 class="thumb img-responsive" id="thumb">
                                        </div>
                                        <div class="caption">
                                            <span class="name text-center"></span>
                                            <input type="file" name="image" class="form-control">
                                            @if ($errors->has('image'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                            {{--<input type="hidden" name="menu_photo" value="" id="field" />
                                            <p>
                                                <a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
                                                <a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>
                                            </p>--}}
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
        $('#restaurant ').select2();
    </script>
@endsection
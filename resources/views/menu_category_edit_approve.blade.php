@extends('home', ['title' => 'Menu Category: ' . $category->name_en])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-check"></i>
                    Approve
                </a>
                <a class="btn btn-danger" title=""
                   href="{{ url('menu_category/edit_reject/' . $category->id )}}">
                    <i class="fa fa-ban"></i>
                    Reject
                </a>&nbsp;
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li class="active">
                            <a href="#general" data-toggle="tab">
                                Category Details
                            </a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" enctype="multipart/form-data"
                      action="{{ url('/menu_category/edit_approve/' . $category->id ) }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            @if($user->admin == 1)
                                <input type="hidden" name="restaurant" value="{{$category->restaurant_id}}">
                            @endif
                            <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                                <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_en" id="input_name_en" class="form-control"
                                           value="{{old('name_en') ?? $editingMenuCategory->name_en }}">
                                </div>
                                @if ($category->name_en != $editingMenuCategory->name_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name_ar" id="input_name_ar" class="form-control"
                                           value="{{old('name_ar') ?? $editingMenuCategory->name_ar }}">
                                </div>
                                @if ($category->name_ar != $editingMenuCategory->name_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                                <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                                <div class="col-sm-5">
                                    <textarea name="description_en" id="input_description_en" class="form-control"
                                              rows="7">{{old('description_en') ?? $editingMenuCategory->description_en }}</textarea>
                                </div>
                                @if ($category->description_en != $editingMenuCategory->description_en)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                                <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                <div class="col-sm-5">
                                    <textarea name="description_ar" id="input_description_ar" class="form-control"
                                              rows="7">{{old('description_en') ?? $editingMenuCategory->description_en }}</textarea>
                                </div>
                                @if ($category->description_ar != $editingMenuCategory->description_ar)
                                    <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
                                    </span>
                                @endif
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="" class="col-sm-3 control-label">--}}
                            {{--Image--}}
                            {{--<span class="help-block">Select a file to update category image, otherwise leave blank.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                            {{--<div class="thumbnail imagebox imagebox-sm" id="selectImage">--}}
                            {{--<div class="preview">--}}
                            {{--<img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png"--}}
                            {{--class="thumb img-responsive" id="thumb">--}}
                            {{--</div>--}}
                            {{--<div class="caption">--}}
                            {{--<span class="name text-center"></span>--}}
                            {{--<input type="file" name="image" class="form-control">--}}
                            {{--<input type="hidden" name="image" value="" id="field">--}}
                            {{--<p>--}}
                            {{--<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i></a>--}}
                            {{--<a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i></a>--}}
                            {{--</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update category image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            @if(isset($editingMenuCategory->image))
                                                <img src="{{url('/') . '/images/' . $editingMenuCategory->image}}"
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
                                    @if ($editingMenuCategory->image)
                                        <span class="help-block">
                                        <strong class="text-danger">Edited</strong>
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
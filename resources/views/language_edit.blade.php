@extends('home', ['title' => 'Language: ' . $language->name])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();"><i class="fa fa-save"></i> Save</a>
                <a class="btn btn-default" onclick="saveClose();">
                    <i class="fa fa-save"></i>
                    Save &amp; Close
                </a>
                <a class="btn btn-default" href="{{ redirect()->back()->getTargetUrl() }}">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li class="active"><a href="#general" data-toggle="tab">Details</a></li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      enctype="multipart/form-data"
                      action="{{url('/language/update/' . $language->id)}}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="input-name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" id="input-name" class="form-control"
                                           value="{{$language->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="input-code" class="col-sm-3 control-label">
                                    Language Code
                                    <span class="help-block">Language url prefix</span>
                                </label>

                                <div class="col-sm-5">
                                    <input type="text" name="code" id="input-code" class="form-control"
                                           value="{{$language->code}}">
                                    @if ($errors->has('code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="input-image" class="col-sm-3 control-label">Icon</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        @if(isset($language->image))
                                            <span class="input-group-addon lg-addon" title="" data-original-title="">
                                                <i>
                                                    <img src="{{url('/') . '/images/' . $language->image}}"
                                                         class="thumb img-responsive" id="thumb">
                                                </i>
                                            </span>
                                            <input type="text" class="form-control" id="image_name"
                                                   value="{{'flags/' . $language->image}}" name="image">
                                        @else
                                            <span class="input-group-addon lg-addon" title="" data-original-title="">
                                                <i>
                                                    <img src="{{url('/') . '/admin/flags/no_flag.png'}}"
                                                         class="thumb img-responsive" id="thumb">
                                                </i>
                                            </span>
                                            <input type="text" class="form-control" id="image_name" name="image">
                                        @endif
                                        <span class="input-group-btn">
                                                <label class=" btn btn-primary btn-file ">
                                                    <i class="fa fa-picture-o"></i>
                                                    <input type="file" name="image" style="display: none;"
                                                           onchange="readURL(this);" id="image_file">
                                                </label>
                                                <label class="btn btn-danger " onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i>
                                                </label>
                                            </span>
                                    </div>
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('idiom') ? ' has-error' : '' }}">
                                <label for="input-idiom" class="col-sm-3 control-label">Idiom
                                    <span class="help-block">Language idiom, must be same as the language directory name.</span>
                                </label>
                                <div class="col-sm-5">
                                    <input type="text" name="idiom" id="input-idiom" class="form-control"
                                           value="{{$language->idiom}}">
                                    @if ($errors->has('idiom'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('idiom') }}</strong>
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
                var fileInput = document.getElementById('image_file');
                var fileName = fileInput.files[0].name;
                $('input[id=image_name]').attr('value', 'flags/' + fileName);
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeFile() {
            $('#thumb').attr('src', '/admin/flags/no_flag.png');
            $('input[id=image_name]').attr('value', '');
            $('input[name=image]').val("");
        }
    </script>
@endsection
@extends('home', ['title' => 'Staff: ' . Auth::user()->first_name])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                    <i class="fa fa-save"></i>
                    Save
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
                        <li class="active">
                            <a href="#staff-details" data-toggle="tab">
                                Details
                            </a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      enctype="multipart/form-data"
                      action="{{url('/admin/update/' . Auth::user()->id)}}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="staff-details" class="tab-pane row wrap-all active">
                            <div class="form-group">
                                <label for="input-name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" id="input-name" class="form-control"
                                           value="{{Auth::user()->first_name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="email" id="input-email" class="form-control"
                                           value="{{Auth::user()->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-username" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-5">
                                    <input type="text" name="username" id="input-username" class="form-control"
                                           value="{{Auth::user()->username}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-image" class="col-sm-3 control-label">
                                    Image
                                    <span class="help-block">Select a file to update category image, otherwise leave blank.</span>
                                </label>
                                <div class="col-sm-5">
                                    <div class="thumbnail imagebox">
                                        <div class="preview">
                                            @if(isset(Auth::user()->image))
                                                <img src="{{url('/') . '/images/' . Auth::user()->image}}"
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
                                                    <i class="fa fa-times-circle"></i>&nbsp;
                                                    &nbsp;Remove
                                                </label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-password" class="col-sm-3 control-label">
                                    Password
                                    <span class="help-block">Leave blank to leave password unchanged</span>
                                </label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" id="input-password" class="form-control"
                                           value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input-name" class="col-sm-3 control-label">Password Confirm</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password_confirm" id="" class="form-control"
                                           autocomplete="off">
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
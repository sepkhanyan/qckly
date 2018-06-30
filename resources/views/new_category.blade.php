@extends('header')
@section('content')
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
            <a href="{{ url('/categories') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
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

        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="GET" action="{{ url('/store/categories') }}">
            {{ csrf_field() }}
            <div class="tab-content">
                <div id="general" class="tab-pane row wrap-all active">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="input-name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="name" id="input-name" class="form-control" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-slug" class="col-sm-3 control-label">
                            Permalink Slug
                            <span class="help-block">Use ONLY alpha-numeric lowercase characters, underscores or dashes and make sure it is unique GLOBALLY.</span>
                        </label>
                        <div class="col-sm-5">
                            <input type="hidden" name="permalink[permalink_id]" value="0">
                            <input type="text" name="permalink[slug]" id="input-slug" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label">Parent</label>
                        <div class="col-sm-5">
                            {{--<div class="select2-container form-control" id="s2id_category">--}}
                                {{--<a href="javascript:void(0)" class="select2-choice" tabindex="-1">--}}
                                    {{--<span class="select2-chosen" id="select2-chosen-1">None</span>--}}
                                    {{--<abbr class="select2-search-choice-close"></abbr>--}}
                                    {{--<span class="select2-arrow" role="presentation">--}}
                                        {{--<b role="presentation"></b>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                                {{--<label for="s2id_autogen1" class="select2-offscreen"></label>--}}
                                {{--<input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1">--}}
                            {{--</div>--}}
                            <select name="parent_id" id="category" class="form-control" tabindex="-1" title="">
                                <option value="">None</option>
                                <option value="16">Main Course</option>
                                <option value="15">Appetizer</option>
                                <option value="17">Salads</option>
                                <option value="18">Seafoods</option>
                                <option value="19">Traditional</option>
                                <option value="20">Vegetarian</option>
                                <option value="21">Soups</option>
                                <option value="22">Desserts</option>
                                <option value="23">Drinks</option>
                                <option value="24">Specials</option>
                                <option value="26">Rice Dishes</option>
                                <option value="44">Pizza</option>
                                <option value="46">Lanches</option>
                                <option value="48">burger</option>
                                <option value="49">Chicken</option>
                                <option value="50">Chinese food</option>
                                <option value="51">Biryani</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="input-description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-5">
                            <textarea name="description" id="input-description" class="form-control" rows="7">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">
                            Image
                            <span class="help-block">Select a file to update category image, otherwise leave blank.</span>
                        </label>
                        <div class="col-sm-5">
                            <div class="thumbnail imagebox imagebox-sm" id="selectImage">
                                <div class="preview">
                                    <img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png" class="thumb img-responsive" id="thumb">
                                </div>
                                <div class="caption">
                                    <span class="name text-center"></span>
                                    <input type="file" name="image" class="form-control">
                                    {{--<input type="hidden" name="image" value="" id="field">--}}
                                    {{--<p>--}}
                                        {{--<a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i></a>--}}
                                        {{--<a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i></a>--}}
                                    {{--</p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                        <label for="input-priority" class="col-sm-3 control-label">Priority</label>
                        <div class="col-sm-5">
                            <input type="text" name="priority" id="input-priority" class="form-control" value="{{ old('priority') }}">
                            @if ($errors->has('priority'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <label class="btn btn-danger active">
                                    <input type="radio" name="status" value="0" checked="checked">
                                    Disabled
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="status" value="1">
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
    <script type="text/javascript">
        $(document).ready(function() {
            if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
                $('#side-menu .' + active_menu).addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
            }

            if (window.location.hash) {
                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
                $('#nav-tabs a[href="#'+hash+'"]').tab('show');
            }

            $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
        });

        function confirmDelete(form) {
            if ($('input[name="delete[]"]:checked').length && confirm('This cannot be undone! Are you sure you want to do this?')) {
                form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
                $('#'+form).submit();
            } else {
                return false;
            }
        }

        function saveClose() {
            $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
            $('#edit-form').submit();
        }
    </script>
    <script type="text/javascript">
        $('#category ').select2();
    </script>
@endsection
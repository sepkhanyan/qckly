@extends('home', ['title' => 'Languages'])
@section('content')
    <div id="page-wrapper">
        @if(Auth::user()->admin == 1)
            <div class="page-header">
                <div class="page-action">
                    <a data-toggle="modal" data-target="#modalCreateLanguage" href="" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_language">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                </div>
            </div>
        @endif

        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Language List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/languages')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="filter_search" class="form-control input-sm"
                                                       value="" placeholder="Search name.">
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title=""
                                               data-original-title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/languages')}}"
                                               title="" data-original-title="Clear">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form role="form" id="list-form" accept-charset="utf-8" method="POST">
                        <div class="table-responsive">
                            <table border="0" class="table table-striped table-border">
                                <thead>
                                <tr>
                                    <th class="action">
                                        <input type="checkbox"
                                               onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    </th>
                                    <th width="55%">Name</th>
                                    <th>Code</th>
                                    <th class="text-center">Icon</th>
                                    <th>Idiom</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($languages) > 0)
                                    @foreach($languages as $language)
                                        <tr>
                                            <td class="action">
                                                <input type="checkbox" value="{{$language->id}}" name="delete">
                                                <a class="btn btn-edit" data-toggle="modal"
                                                   data-target="#modalEditLanguage"
                                                   type="button" onclick="myFunction('{{$language->id}}', '{{$language->name}}', '{{$language->code}}', '{{$language->image}}', '{{$language->idiom}}')">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </td>
                                            <td width="55%">{{$language->name}}</td>
                                            <td>{{$language->code}}</td>
                                            <td class="text-center">
                                                <img src="/images/{{$language->image}}">
                                            </td>
                                            <td>{{$language->idiom}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no languages available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($languages) > 0)
                        {{$languages->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCreateLanguage" role="dialog" tabindex="-1">
        <form role="form" id="create-form" class="form-horizontal" accept-charset="utf-8" method="POST" enctype="multipart/form-data"
              action="{{ url('/language/store') }}">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Add Language</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="input-name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control"
                                       value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label for="input-code" class="col-sm-3 control-label">Language Code <span
                                        class="help-block">Language url prefix</span>
                            </label>

                            <div class="col-sm-5">
                                <input type="text" name="code" id="input-code" class="form-control"
                                       value="{{old('code')}}">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="input-image" class="col-sm-3 control-label">Icon</label>

                            <div class="col-sm-5">
                                <div class="input-group">
                            <span class="input-group-addon lg-addon" title="" data-original-title="">
                                <i>
                                    <img src="{{url('/') . '/admin/flags/no_flag.png'}}"
                                         class="thumb img-responsive" id="thumb">
                                </i>
                            </span>
                                    <input type="text" class="form-control" id="image_name"
                                           value="flags/no_flag.png" name="image">
                                    <span class="input-group-btn">
                              <label class=" btn btn-primary btn-file ">
                                                    <i class="fa fa-picture-o"></i><input type="file"
                                                                                          name="image"
                                                                                          style="display: none;"
                                                                                          onchange="readURL(this);"
                                                                                          id="image_file">

                                                </label>
                                <label class="btn btn-danger "
                                       onclick="removeFile()">
                                                    <i class="fa fa-times-circle"></i></label>
                            </span>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('idiom') ? ' has-error' : '' }}">
                            <label for="input-idiom" class="col-sm-3 control-label">Idiom
                                <span class="help-block">Language idiom, must be same as the language directory name.</span>
                            </label>

                            <div class="col-sm-5">
                                <input type="text" name="idiom" id="input-idiom" class="form-control" value="{{old('idiom')}}">
                                @if ($errors->has('idiom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('idiom') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="modalEditLanguage" role="dialog" tabindex="-1">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Edit Language</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="input-name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control"
                                       value="">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label for="input-code" class="col-sm-3 control-label">Language Code <span
                                        class="help-block">Language url prefix</span>
                            </label>

                            <div class="col-sm-5">
                                <input type="text" name="code" id="input-code" class="form-control"
                                       value="">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="input-image" class="col-sm-3 control-label">Icon</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                        <span class="input-group-addon lg-addon" title=""
                                              data-original-title="">
                                                <i>
                                                    <img class="thumb img-responsive" id="thumb">
                                                </i>
                                            </span>
                                        <input type="text" class="form-control" id="image_name"
                                               value="" name="image">
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
                        <div class="modal-body">
                            <div class="form-group{{ $errors->has('idiom') ? ' has-error' : '' }}">
                                <label for="input-idiom" class="col-sm-3 control-label">Idiom
                                    <span class="help-block">Language idiom, must be same as the language directory name.</span>
                                </label>

                                <div class="col-sm-5">
                                    <input type="text" name="idiom" id="input-idiom" class="form-control" value="">
                                    @if ($errors->has('idiom'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('idiom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
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
                $('input[id=image_name]').attr('value', fileName);
                reader.readAsDataURL(input.files[0]);
            }
        }

        // function removeFile() {
        //     $('#thumb').attr('src', '/admin/flags/no_flag.png');
        //     $('input[id=image_name]').attr('value', 'flags/no_flag.png');
        // }
        function myFunction(id,name,code,image,idiom) {
            $('#thumb').attr('src', img_url);
            $('input[name=idiom]').val(idiom);
            $('input[name=name]').val(name);
            $('input[name=code]').val(code);
            $('input[name=image]').val(image);
            $("#edit-form").attr('action', 'language/update/' + id);
        }
    </script>
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }

    </script>
@endsection
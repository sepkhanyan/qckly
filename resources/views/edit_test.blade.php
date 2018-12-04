@extends('home', ['title' => 'Restaurant: ' . $restaurant->name_en])
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
                        <li class="active">
                            <a href="#general" data-toggle="tab">Restaurant</a>
                        </li>
                        <li>
                            <a href="#data" data-toggle="tab">Data</a>
                        </li>
                        <li>
                            <a href="#opening-hours" data-toggle="tab">Working Hours</a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" name="edit_form" class="form-horizontal" accept-charset="utf-8"
                      method="POST" action="{{ url('/restaurant/update/' . $restaurant->id ) }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <div class="form-group">
                                <label  class="col-sm-3 control-label"></label>
                                <div class="col-sm-5">
                                    <div class="table-responsive">
                                        <table border="0" class="table table-striped table-border">
                                            <thead>
                                            <tr>
                                                <th>From</th>
                                                <th>To</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if($editingRestaurant->description_en)
                                <div class="form-group">
                                    <label for="input_description_en" class="col-sm-3 control-label">Description
                                        En</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                <tr>
                                                    <td width="50%">{{$restaurant->description_en }}</td>
                                                    <td width="50%">{{$editingRestaurant->description_en }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($editingRestaurant->description_ar)
                                <div class="form-group">
                                    <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                                    <div class="col-sm-5">
                                        <div class="table-responsive">
                                            <table border="0" class="table table-striped table-border">
                                                <tbody>
                                                <tr>
                                                    <td width="50%">{{$restaurant->description_ar }}</td>
                                                    <td width="50%">{{$editingRestaurant->description_ar }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
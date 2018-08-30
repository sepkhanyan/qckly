@extends('home')
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
            <a href="{{ url('/menu_subcategories') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="row wrap-vertical">
                <ul id="nav-tabs" class="nav nav-tabs">
                    <li class="active">
                        <a href="#general" data-toggle="tab">Subcategory</a>
                    </li>
                </ul>
            </div>
            <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{ url('/menu_subcategory/update/' . $subcategory->id) }}">
                {{ csrf_field() }}
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="en">Subcategory En</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="en" name="subcategory_en" style="width: 50%" value="{{$subcategory->subcategory_en}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="ar">Subcategory Ar</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" id="ar" name="subcategory_ar" style="width: 50%" value="{{$subcategory->subcategory_ar}}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
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
            <a href="{{ url('/areas') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="row wrap-vertical">
                <ul id="nav-tabs" class="nav nav-tabs">
                    <li class="active"><a href="#general" data-toggle="tab">Area</a></li>
                </ul>
            </div>
            <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{ url('/area/update/' . $area->id) }}">
                {{ csrf_field() }}
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <div class="form-group{{ $errors->has('area_en') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-2" for="area-en">Area En</label>
                            <div class="col-sm-8">
                                <input type="text" name="area_en" class="form-control" value="{{ $area->area_en }}" id="area-en" style="width: 50%" required autofocus>
                                @if ($errors->has('area_en'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('area_ar') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-2" for="area-ar">Area Ar</label>
                            <div class="col-sm-8">
                                <input type="text" name="area_ar" class="form-control" value="{{ $area->area_ar }}" id="area-en" style="width: 50%" required autofocus>
                                @if ($errors->has('area_ar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_ar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
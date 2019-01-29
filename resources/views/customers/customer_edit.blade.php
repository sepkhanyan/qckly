@extends('home', ['title' => 'Customer: ' . $customer->username])
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
                            <a href="#general" data-toggle="tab">
                                Customer
                            </a>
                        </li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      action="{{ url('/customer/update/' . $customer->id ) }}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <div class="form-group">
                                <label for="input_name" class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" id="input_name" class="form-control"
                                           value="{{$customer->username}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-5">
                                    <input type="text" name="email" id="input_email" class="form-control"
                                           value="{{$customer->email}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_country_code" class="col-sm-3 control-label">Country Code</label>
                                <div class="col-sm-5">
                                    <input type="text" name="country_code" id="input_country_code" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_telephone" class="col-sm-3 control-label">Telephone</label>
                                <div class="col-sm-5">
                                    <input type="text" name="telephone" id="input_telephone" class="form-control"
                                           value="{{$customer->mobile_number}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_password" class="col-sm-3 control-label">
                                    Password
                                    <span class="help-block">Leave blank to leave password unchanged</span>
                                </label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" id="input_password" class="form-control"
                                           value="" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_confirm_password" class="col-sm-3 control-label">Confirm
                                    Password</label>
                                <div class="col-sm-5">
                                    <input type="password" name="confirm_password" id="input_confirm_password"
                                           class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
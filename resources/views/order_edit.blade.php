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
        <a href="{{ url('/orders') }}" class="btn btn-default">
            <i class="fa fa-angle-double-left"></i>
        </a>
    </div>
</div>
<div class="row content">
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab" aria-expanded="true">Order</a></li>
            </ul>
        </div>

        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{url('/order/update/' . $order->id)}}">
            {{ csrf_field() }}
            <div class="tab-content">
                <div id="general" class="tab-pane row wrap-all active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Order Details</h3></div>
                                <div class="panel-body">
                                    <div class="form-group col-xs-12">
                                        <label for="" class="control-label">Order ID</label>
                                        <div class="">
                                            #{{$order->id}}										</div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="input-name" class="control-label">Order Date and Time</label>
                                        <div class="">
                                            {{date("j M Y", strtotime($order->created_at)) . ', ' . date("g:i A", strtotime($order->created_at))}}
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="input-status" class="control-label">Order Status</label>
                                        <div class="">
                                            {{$order->status->name_en}}										</div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="input-name" class="control-label">Payment Method</label>
                                        <div class="">
                                            @if($order->payment_type == 1)
                                                {{\Lang::get('message.cash')}}
                                            @elseif($order->payment_type == 2)
                                                {{\Lang::get('message.card')}}
                                            @else
                                                {{\Lang::get('message.debit')}}
                                            @endif																				</div>
                                    </div>
                                    <div class="paypal_details" style="display:none">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Customer Details</h3></div>
                                <div class="panel-body">
                                    <div class="form-group col-xs-12">
                                        <label for="input-name" class="control-label">Name</label>
                                        <div class="">
                                            <a href="#">{{$order->user->username}}</a>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="input-name" class="control-label">Email</label>
                                        <div class="">
                                            {{$order->user->email}}									</div>
                                    </div>
                                    <div class="form-group col-xs-12">
                                        <label for="input-name" class="control-label">Telephone</label>
                                        <div class="">
                                            {{$order->user->mobile_number}}										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Delivery Address</h3></div>
                                <div class="panel-body">
                                    {{$order->cart->address->name}}
                                    <br>
                                    {{$order->cart->address->location}}
                                    <br>
                                    {{$order->cart->address->building_number}}
                                    <br>
                                    {{$order->cart->address->zone}}
                                    <br>
                                    {{$order->cart->address->apartment_number}}
                                    <br>
                                    {{$order->cart->area->area_en}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Status</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-sm-5">
                                            <select name="order_status" class="form-control ">
                                                <option value="">{{$order->status->name_en}}</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{$status->id}}">{{$status->name_en}}</option>
                                            @endforeach
                                            </select>&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
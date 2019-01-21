@extends('home', ['title' => 'Order: ' . $order->order_id])
@section('content')
    <div id="page-wrapper" style="min-height: 261px; height: 100%;">
        <div class="page-header clearfix">
            <div class="page-action">
                <a class="btn btn-primary" onclick="$('#edit-form').submit();"><i class="fa fa-save"></i> Save</a>
                <a class="btn btn-default" onclick="saveClose();"><i class="fa fa-save"></i> Save &amp; Close</a>
                <a class="btn btn-default" href="{{ redirect()->back()->getTargetUrl() }}"><i
                            class="fa fa-angle-double-left"></i></a></div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="row wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <li class="active"><a href="#general" data-toggle="tab">Order</a></li>
                        <li><a href="#menus" data-toggle="tab">Collections
                                <span class="badge">{{$order->orderCollection->count()}}</span></a></li>
                    </ul>
                </div>
                <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST"
                      action="{{url('/order/update/' . $order->id)}}">
                    {{ csrf_field() }}
                    <div class="tab-content">
                        <div id="general" class="tab-pane row wrap-all active">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3 class="panel-title">Order Details</h3></div>
                                        <div class="panel-body">
                                            <div class="form-group col-xs-12">
                                                <label for="" class="control-label">Order #</label>
                                                <div class="">
                                                    #{{$order->id}}                                        </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="input-name" class="control-label">Delivery Time</label>
                                                <div class="">
                                                    {{date("g:i A", strtotime( $order->cart->delivery_order_time))}}
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="input-status" class="control-label">Order Status</label>
                                                <div class="">
                                                    {{$order->status->name_en}}
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="input-name" class="control-label">Payment Method</label>
                                                <div class="">
                                                    @if($order->payment_type == 1)
                                                        {{\Lang::get('message.cash')}}
                                                    @elseif($order->payment_type == 2)
                                                        {{\Lang::get('message.credit')}}
                                                    @else
                                                        {{\Lang::get('message.debit')}}
                                                    @endif
                                                </div>
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
                                                    {{$order->user->username}}
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="input-name" class="control-label">Email</label>
                                                <div class="">
                                                    {{$order->user->email}}
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="input-name" class="control-label">Telephone</label>
                                                <div class="">
                                                    {{$order->user->mobile_number}}
                                                </div>
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
                                            <b>Name:</b>
                                            {{$order->deliveryAddress->name}}
                                            <br>
                                            <b>Mobile Number:</b>
                                            {{$order->deliveryAddress->mobile_number}}
                                            <br>
                                            <b>Location:</b>
                                            {{$order->deliveryAddress->location}}
                                            <br>
                                            <b>Street Number:</b>
                                            {{$order->deliveryAddress->street_number}}
                                            <br>
                                            <b>Building Number:</b>
                                            {{$order->deliveryAddress->building_number}}
                                            <br>
                                            <b>Apartment Number:</b>
                                            {{$order->deliveryAddress->apartment_number}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($restaurantOrder->status_id != 3 && $restaurantOrder->status_id != 1)
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><h3 class="panel-title">Status</h3></div>
                                            <div class="panel-body">
                                                <div class="col-xs-12 col-sm-3">
                                                    <label for="input-name" class="control-label">Order Status</label>
                                                    <div class="">
                                                        <select name="status" id="status" class="form-control">
                                                            @foreach ($statuses as $status)
                                                                    <option value="{{$status->id}}" {{$restaurantOrder->status_id == $status->id ? 'selected' : ''}}>{{$status->name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div id="menus" class="tab-pane row wrap-all">
                            <div class="panel panel-default panel-table">
                                <div class="table-responsive">
                                    <table height="auto" class="table table-condensed table-border">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Collection Type</th>
                                            <th class="text-left">Female Caterer</th>
                                            <th class="text-left">Special Instruction</th>
                                            <th class="text-left">Service Type</th>
                                            <th class="text-left">Price</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($price = 0)
                                        @foreach($order->orderCollection as $orderCollection)
                                            <tr>
                                                <td style="width: 100px; font-style: oblique; font-size: 15px">
                                                    @if($orderCollection->collection_category_id == 2)
                                                        <b>For {{$orderCollection->persons_count}} persons</b>
                                                    @else
                                                        <b>{{$orderCollection->quantity}}x</b>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h4><b>{{$orderCollection->collection_en}}</b></h4>
                                                    @foreach($orderCollection->orderCollectionItem as $orderCollectionItem)
                                                        <div>
                                                            <span style="font-style: oblique">{{$orderCollectionItem->quantity}}
                                                                x</span>
                                                            {{$orderCollectionItem->item_en}}
                                                            @if($orderCollection->collection_category_id != 1)
                                                                /
                                                                @if($orderCollectionItem->is_mandatory == 1)
                                                                    Mandatory
                                                                @else
                                                                    <span style="font-style: oblique">{{$orderCollectionItem->item_price . ' ' . \Lang::get('message.priceUnit')}}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>{{$orderCollection->collection_category_en}}</td>
                                                <td>
                                                    @if($orderCollection->female_caterer == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>{{$orderCollection->special_instruction}}</td>
                                                <td>{{$orderCollection->service_type_en}}</td>
                                                <td class="text-left">
                                                    @if($orderCollection->collection_category_id != 4)
                                                        {{$orderCollection->collection_price}} {{\Lang::get('message.priceUnit')}}
                                                    @endif
                                                </td>
                                                <td class="text-right">{{$orderCollection->subtotal}} {{\Lang::get('message.priceUnit')}}</td>
                                            </tr>
                                            @php($price += $orderCollection->subtotal)
                                        @endforeach
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="thick-line text-left" style="font-size: 20px"><b>Order Total</b>
                                            </td>
                                            <td class="thick-line text-right" style="font-size: 20px">
                                                <b>{{$price}} {{\Lang::get('message.priceUnit')}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
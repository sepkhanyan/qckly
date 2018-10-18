@extends('home', ['title' => 'Orders'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            {{--<a class="btn btn-danger " id="delete_order">--}}
                            {{--<i class="fa fa-trash-o"></i>--}}
                            {{--Delete--}}
                            {{--</a>--}}
                        @endif
                        @if(Auth::user()->admin == 1)
                            <div class="form-group col-md-4">
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                        title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if($selectedRestaurant)
                                        <option value>{{$selectedRestaurant->name_en . ', ' . $selectedRestaurant->area->area_en . ', ' . $selectedRestaurant->address_en}}</option>
                                        @foreach($restaurants as $restaurant)
                                            @if($selectedRestaurant->id != $restaurant->id)
                                                <option value="{{url('/orders/' . $restaurant->id)}}">{{$restaurant->name_en . ', ' . $restaurant->area->area_en . ', ' . $restaurant->address_en}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value>Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/orders/' . $restaurant->id)}}">{{$restaurant->name_en . ', ' . $restaurant->area->area_en . ', ' . $restaurant->address_en}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Order List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none;">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/orders/' . $id )}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="order_search" class="form-control input-sm"
                                                       value="" placeholder="Search order_id or price."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-8 pull-left">
                                            <div class="form-group">
                                                <select name="order_status" class="form-control input-sm">
                                                    <option value="">View all status</option>
                                                    @foreach ($statuses as $status)
                                                        <option value="{{$status->id}}">{{$status->name_en}}</option>
                                                    @endforeach
                                                </select>&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                                <i class="fa fa-filter"></i>
                                            </a>&nbsp;
                                            <a class="btn btn-grey" href="{{url('/orders/' . $id )}}" title="Clear">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="">
                        <div class="table-responsive">
                            <table border="0" class="table table-striped table-border">
                                <thead>
                                <tr>
                                    @if(Auth::user()->admin == 2)
                                        <th class="action action-three">
                                            {{--<input type="checkbox"--}}
                                            {{--onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">--}}
                                        </th>
                                    @endif
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Time - Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($selectedRestaurant)
                                    @if(count($orders) > 0)
                                        @foreach($orders as $order)
                                            <tr>
                                                @if(Auth::user()->admin == 2)
                                                    <td class="action">
                                                        {{--<input type="checkbox" value="{{ $order->order_id }}"--}}
                                                        {{--name="delete"/>--}}
                                                        <a class="btn btn-edit" title=""
                                                           href="{{ url('/order/edit/' . $order->order_id )}}">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>&nbsp;&nbsp;
                                                    </td>
                                                @endif
                                                <td>{{$order->order_id}}</td>
                                                <td>{{$order->order->user->username}}</td>
                                                <td>
                                                    @if($order->order->payment_type == 1)
                                                        {{\Lang::get('message.cash')}}
                                                    @elseif($order->payment_type == 2)
                                                        {{\Lang::get('message.credit')}}
                                                    @else
                                                        {{\Lang::get('message.debit')}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$order->total_price . \Lang::get('message.priceUnit')}}
                                                </td>
                                                <td>
                                                    @if($order->status_id == 1)
                                                        <span class="label label-default"
                                                              style="background-color: #00c0ef;">{{$order->status->name_en}}</span>
                                                    @elseif($order->status_id == 2)
                                                        <span class="label label-default"
                                                              style="background-color: #00a65a;">{{$order->status->name_en}}</span>
                                                    @else
                                                        <span class="label label-default"
                                                              style="background-color: #ea0b29;">{{$order->status->name_en}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{date("g:i A", strtotime($order->created_at)) . ', ' . date("j M Y", strtotime($order->created_at))}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="center">There are no orders right now.</td>
                                        </tr>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($orders) > 0)
                        {{ $orders->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
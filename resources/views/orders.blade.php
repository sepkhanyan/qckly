@extends('home')
@section('content')
    @if(Auth::user()->admin == 1)
        <div class="col-md-12">
            <div class="col-sm-5">
                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1" title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                    <option value>Select Restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{url('/orders/' . $restaurant->id)}}">{{$restaurant->name_en}},{{$restaurant->area->area_en}},{{$restaurant->city_en}},{{$restaurant->address_en}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @if(count($orders)>0)
        <div class="row content" >
            <div class="col-md-12">
                    <div class="panel-heading">
                        <h2>
                            <img src="/images/{{$selectedRestaurant->image}}" width="50px" height="50px">
                            {{$selectedRestaurant->name_en}},
                            {{$selectedRestaurant->city_en}},
                            {{$selectedRestaurant->address_en}}
                        </h2>
                    </div>
                <div class="page-header">
                    <div class="page-action">
                        <a class="btn btn-danger " id="delete_order">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                    </div>
                </div>
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h2 >Order List</h2>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none;">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="{{url('/orders/' . $id )}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="order_search" class="form-control input-sm" value="" placeholder="Search order_id or price."/>&nbsp;&nbsp;&nbsp;
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
                                    <th class="action action-three">
                                        <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    </th>
                                    <th>
                                        Customer Name
                                    </th>
                                    <th>
                                        Payment
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Time - Date
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($orders as $order)
                                    <tr>
                                        <td class="action">
                                            <input type="checkbox" value="{{ $order->id }}" name="delete" />
                                            <a class="btn btn-edit" title="" href="{{ url('/order/edit/' . $order->id )}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>&nbsp;&nbsp;
                                        </td>
                                        <td>{{$order->user->username}}</td>
                                        <td>
                                            @if($order->payment_type == 1)
                                                {{\Lang::get('message.cash')}}
                                            @elseif($order->payment_type == 2)
                                                {{\Lang::get('message.card')}}
                                            @else
                                                {{\Lang::get('message.debit')}}
                                            @endif
                                        </td>
                                        <td>{{$order->total_price . \Lang::get('message.priceUnit')}}</td>
                                        <td>
                                            @if($order->status_id == 1)
                                                <span class="label label-default" style="background-color: #00c0ef;">{{$order->status->name_en}}</span>
                                            @elseif($order->status_id == 2)
                                                <span class="label label-default" style="background-color: #00a65a;">{{$order->status->name_en}}</span>
                                            @else
                                                <span class="label label-default" style="background-color: #ea0b29;">{{$order->status->name_en}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{date("g:i A", strtotime($order->created_at)) . '-' . date("j M Y", strtotime($order->created_at))}}
                                        </td>
                                        <td>{{$order->id}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        {{ $orders->links() }}
                    </form>
                </div>
            </div>
        </div>
    @else
        @if($selectedRestaurant)
            <div class="page-header">
                <div class="page-action">
                    <h2>No Order</h2>
                </div>
            </div>
            @endif
            @endif
                </div>
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
    </script>
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
        $('#orders ').select2();
    </script>
@endsection
@extends('home', ['title' => 'Customers'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                {{--<a href="{{ url('/customer/create') }}" class="btn btn-primary">--}}
                {{--<i class="fa fa-plus"></i>--}}
                {{--New--}}
                {{--</a>--}}
                @if($user->admin == 1)
                    <a class="btn btn-danger " id="delete_customer">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                @endif
            </div>
        </div>
        <div class="page-header">
            <div class="page-action">
                @if($user->admin == 1)
                    <a data-toggle="modal" data-target="#modalSendNotification" href="" class="btn btn-success">
                        Send Notification
                    </a>
                @endif
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/customers')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="customer_search" class="form-control input-sm"
                                                       value="" placeholder="Search customer name or email."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-8 pull-left">
                                            <div class="form-group">
                                                <select name="customer_date" class="form-control input-sm">
                                                    <option value="">View all dates</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{$customer->created_at}}">{{date("jS F, Y", strtotime($customer->created_at))}}</option>
                                                    @endforeach
                                                </select>&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                                <i class="fa fa-filter"></i>
                                            </a>&nbsp;
                                            <a class="btn btn-grey" href="{{url('/customers')}}" title="Clear">
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
                                    @if($user->admin == 1)
                                        <th class="action action-three">
                                            <input type="checkbox"
                                                   onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                        </th>
                                    @endif
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Country Code</th>
                                    <th>Telephone</th>
                                    <th>Date Registered
                                    </th>
                                    <th class="id">ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($customers) > 0)
                                    @foreach($customers as $customer)
                                        <tr>
                                            @if($user->admin == 1)
                                                <td class="action">
                                                    <input type="checkbox" value="{{$customer->id}}"
                                                           name="delete"/>&nbsp;&nbsp;&nbsp;
                                                    {{--<a class="btn btn-edit" title=""--}}
                                                    {{--href="{{ url('/customer/edit/' . $customer->id )}}">--}}
                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                    {{--</a>&nbsp;&nbsp;--}}
                                                </td>
                                            @endif
                                            <td>{{$customer->username}}</td>
                                            <td>{{$customer->email}}</td>
                                            <td>{{$customer->country_code}}</td>
                                            <td>{{$customer->mobile_number}}</td>
                                            <td>{{date("j M, Y", strtotime($customer->created_at))}}</td>
                                            <td>{{$customer->id}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no customers right now.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if(count($customers) > 0)
                            {{ $customers->links() }}
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSendNotification" role="dialog" tabindex="-1">
        <form role="form" id="edit-form" class="form-horizontal"  accept-charset="utf-8" method="POST" enctype="multipart/form-data" action="{{ url('/general/notification') }}">
            {{ csrf_field() }}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Send Notification</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="message">Message</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" name="message" id="message" cols="50" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="area-en">Language</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-toggle btn-group-3" data-toggle="buttons">
                                    <label class="btn btn-success active">
                                        <input type="radio" name="lang"
                                               value="en" checked>
                                        En
                                    </label>
                                    <label class="btn btn-success">
                                        <input type="radio" name="lang"
                                               value="ar">
                                        Ar
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

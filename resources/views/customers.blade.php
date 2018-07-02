@extends('header')
@section('content')
<div class="page-header">
    <div class="page-action">
        <a href="{{ url('/new/customers') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i>
            New
        </a>
        <a class="btn btn-danger " id="delete_customer">
            <i class="fa fa-trash-o"></i>
            Delete
        </a>
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
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="{{url('/customers')}}">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-3 pull-right text-right">
                                        <div class="form-group">
                                            <input type="text" name="customer_search" class="form-control input-sm" value="" placeholder="Search customer name or email." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>

                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <select name="customer_date" class="form-control input-sm">
                                                <option value="">View all dates</option>
                                                @foreach($users as $user)
                                                <option value="{{$user->created_at}}">{{date("jS F, Y", strtotime($user->created_at))}}</option>
                                                @endforeach
                                            </select>&nbsp;
                                        </div>
                                        <div class="form-group">
                                            <select name="customer_status" class="form-control input-sm">
                                                <option value="">View all status</option>
                                                <option value="1"  >Enabled</option>
                                                <option value="0"  >Disabled</option>
                                            </select>
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
                                <th class="action action-three">
                                    <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        First Name
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Last Name
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Email
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>Telephone</th>
                                <th>
                                    <a class="sort" href="">
                                        Date Registered
                                        <i class="fa fa-sort-"></i>
                                    </a>
                                </th>
                                <th class="text-center">Status</th>
                                <th class="id">
                                    <a class="sort" href="">
                                        ID
                                        <i class="fa fa-sort-"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td class="action"><input type="checkbox" value="{{$user->user_id}}" name="delete" />&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-edit" title="" href="{{ url('customer/edit/' . $user->user_id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                        <a class="btn btn-info " title=""  >
                                            <i class="fa fa-user"></i>&nbsp;
                                            &nbsp;<i class="fa fa-arrow-right"></i>
                                        </a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->mobile}}</td>
                                    <td>{{date("jS F, Y", strtotime($user->created_at))}}</td>
                                    <td class="text-center"></td>
                                    <td>{{$user->user_id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="pagination-bar clearfix">
                    <div class="links"></div>
                    <div class="info"></div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function filterList() {
        $('#filter-form').submit();
    }
</script>
    @endsection

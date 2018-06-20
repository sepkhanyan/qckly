@extends('header')
@section('content')
    <div class="page-header">
        <div class="page-action">
            <a href="{{ url('/new/restaurants') }}"  class="btn btn-primary">
                <i class="fa fa-plus"></i>
                New
            </a>
            <a class="btn btn-danger " id="delete_restaurant">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Restaurants</h3>
                </div>
                <div class="panel-body panel-filter" style="display: none;">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-3 pull-right text-right">
                                        <div class="form-group">
                                            <input type="text" name="filter_search" class="form-control input-sm" value="" placeholder="Search customer name or email." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title=""><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <select name="filter_date" class="form-control input-sm">
                                            </select>&nbsp;
                                        </div>
                                        <div class="form-group">
                                            <select name="filter_status" class="form-control input-sm">
                                            </select>
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title=""><i class="fa fa-filter"></i></a>&nbsp;
                                        <a class="btn btn-grey" href="" title=""><i class="fa fa-times"></i></a>
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
                                <th class="action action-three"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
                                <th><a class="sort" href="">Name<i class="fa fa-sort"></i></a></th>
                                <th><a class="sort" href="">City<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">State<i class="fa fa-sort"></i></a></th>
                                <th><a class="sort" href="">Postcode<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">Telephone<i class="fa fa-sort"></i></a></th>
                                <th><a class="sort" href="">Status<i class="fa fa-sort>"></i></a></th>
                                <th><a class="sort" href="">ID<i class="fa fa-sort>"></i></a></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($locations as $location)
                                <tr>
                                    <td class="action"><input type="checkbox" value="{{ $location->location_id }}" name="delete" />&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-edit" title="" href="{{ url('restaurant/edit/' . $location->location_id )}}"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$location->location_name}}</td>
                                    <td>{{$location->location_city}}</td>
                                    <td>{{$location->location_state}}</td>
                                    <td>{{$location->location_postcode}}</td>
                                    <td>{{$location->location_telephone}}</td>
                                    <td>{{$location->location_status}}</td>
                                    <td>{{$location->location_id}}</td>
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
    </form>
    </div>
@endsection
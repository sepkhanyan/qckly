@extends('home')
@section('content')
    <div id="page-wrapper">
        @if(Auth::user()->admin == 1)
            <div class="page-header">
                <div class="page-action">
                    <a href="{{ url('/restaurant/create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_restaurant">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                </div>
            </div>
        @endif
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Restaurants</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="" enctype="">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="restaurant_search"
                                                       class="form-control input-sm" value=""
                                                       placeholder="Search name or description."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-8 pull-left">
                                            <div class="form-group">
                                                <select name="restaurant_status" class="form-control input-sm">
                                                    <option value="">View all status</option>
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Disabled</option>
                                                </select>
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                                <i class="fa fa-filter"></i>
                                            </a>&nbsp;
                                            <a class="btn btn-grey" href="{{url('/restaurants')}}" title="Clear">
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
                                    @if(Auth::user()->admin == 1)
                                        <th class="action action-three">
                                            <input type="checkbox"
                                                   onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                        </th>
                                    @else
                                        <th class="action action-three"></th>
                                    @endif
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Telephone</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurants as $restaurant)
                                    <tr>
                                        <td class="action">
                                            @if(Auth::user()->admin == 1)
                                                <input type="checkbox" value="{{ $restaurant->id }}" name="delete"/>
                                                &nbsp;&nbsp;&nbsp;
                                            @endif
                                            <a class="btn btn-edit" title=""
                                               href="{{ url('/restaurant/edit/' . $restaurant->id )}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>&nbsp;&nbsp;
                                        </td>
                                        <td>
                                            <img src="/images/{{$restaurant->image}}" width="30px" height="30px">
                                            {{$restaurant->name_en}}
                                        </td>
                                        <td>{{$restaurant->description_en}}</td>
                                        <td>{{$restaurant->area->area_en}}</td>
                                        <td>{{$restaurant->address_en}}</td>
                                        <td>{{$restaurant->telephone}}</td>
                                        <td data-toggle="modal" data-target="#changeStatus"  onclick="myFunction({{$restaurant->id}})"
                                            style="font-size: 20px; cursor: pointer">
                                            @if($restaurant->status == 1)
                                                <span class="label label-default"
                                                      style="background-color: #00a65a; ">{{\Lang::get('message.open')}}</span>
                                            @elseif($restaurant->status == 0)
                                                <span class="label label-default"
                                                      style="background-color: #ea0b29 ;">{{\Lang::get('message.busy')}}</span>
                                            @endif
                                        </td>
                                        <td>{{$restaurant->id}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </form>
                    {{ $restaurants->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeStatus" role="dialog" tabindex="-1">
        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST">
            {{ csrf_field() }}
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Change Status</h4>
                    </div>
                    <div class="modal-body">
                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                            <label class="btn btn-success active">
                                <input type="radio" name="status" value="1"
                                       checked="checked">
                                Open
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" name="status" value="0">
                                Busy
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        function myFunction(id) {
            $("#edit-form").attr('action', 'restaurant/status/update/' + id);
        }
    </script>
@endsection
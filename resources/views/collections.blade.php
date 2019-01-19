@extends('home', ['title' => 'Collections'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header clearfix">
            <div class="page-action">
                <div class="form-inline">
                    <div class="row">
                        @if($selectedRestaurant)
                            <a class="btn btn-primary" href="{{--{{ url('/collection/create') }}--}}"
                               data-toggle="modal"
                               data-target="#modalNewCollection">
                                <i class="fa fa-plus"></i>
                                New
                            </a>
                            <a class="btn btn-danger " id="delete_collection">
                                <i class="fa fa-trash-o"></i>
                                Delete
                            </a>
                        @endif
                        @if($user->admin == 1)
                            <div class="form-group col-md-4">
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1"
                                        title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if($selectedRestaurant)
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/collections/' . $restaurant->id)}}" {{($restaurant->id == $selectedRestaurant->id) ? 'selected' : ''}}>{{$restaurant->name_en}}</option>
                                        @endforeach
                                    @else
                                        <option value>Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/collections/' . $restaurant->id)}}">{{$restaurant->name_en}}</option>
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
                        <h3 class="panel-title">Collection List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter" style="display: none;">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/collections/' . $id)}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="collection_search"
                                                       class="form-control input-sm" value=""
                                                       placeholder="Search name or price."/>&nbsp;&nbsp;&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-8 pull-left">
                                            <div class="form-group">
                                                <select name="collection_type" class="form-control input-sm">
                                                    <option value="">View all types</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name_en}}</option>
                                                    @endforeach
                                                </select>&nbsp;
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                                <i class="fa fa-filter"></i>
                                            </a>&nbsp;
                                            <a class="btn btn-grey" href="{{url('/collections/' . $id )}}"
                                               title="Clear">
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
                                        <input type="checkbox"
                                               onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    </th>
                                    <th>Collection Name</th>
                                    <th>Description</th>
                                    <th>Collection Category</th>
                                    <th>Service Type</th>
                                    <th>Price</th>
                                    <th>Mealtime</th>
                                    <th>Status</th>
                                    <th>ID</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($selectedRestaurant)
                                    @if(count($collections) > 0)
                                        @foreach($collections as $collection)
                                            <tr class="{{($collection->editingCollection || $collection->approved == 0) ? 'info' : ''}}">
                                                <td class="action">
                                                    <input type="checkbox" value="{{$collection->id}}" name="delete"/>
                                                    <a class="btn btn-edit" title=""
                                                       href="{{ url('/collection/edit/' . $collection->id )}}">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>&nbsp;&nbsp;

                                                    <a class="btn btn-edit" title=""
                                                       href="{{ url('/collection/copy/' . $collection->id )}}">
                                                        Copy Collection
                                                        <i class="fa fa-copy"></i>
                                                    </a>&nbsp;

                                                    @if($user->admin == 1)
                                                        @if($collection->approved == 0)
                                                            <a class="btn btn-edit" title=""
                                                               href="{{ url('collection/approve/' . $collection->id )}}">
                                                                <i class="fa fa-check"></i>
                                                                Approve
                                                            </a>&nbsp;&nbsp;
                                                            <a class="btn btn-danger" title=""
                                                               href="{{ url('collection/reject/' . $collection->id )}}">
                                                                <i class="fa fa-ban"></i>
                                                                Reject
                                                            </a>&nbsp;
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{$collection->name_en}}</td>
                                                <td>{{$collection->description_en}}</td>
                                                <td>{{$collection->category->name_en}}</td>
                                                <td>{{$collection->serviceType->name_en}}</td>
                                                <td>{{$collection->price}}</td>
                                                <td>{{$collection->mealtime->name_en}}</td>
                                                <td>
                                                    @if($collection->is_available == 1)
                                                        @php
                                                            $unavailability = $collection->unavailabilityHour->where('collection_id', $collection->id)->where('weekday', $requestDay)
                                                         ->where('start_time', '<=', $requestTime)
                                                         ->where('end_time', '>=', $requestTime)
                                                         ->where('status', 0)->first();
                                                        @endphp
                                                        <a href="{{ url('/collection/availability/edit/' . $collection->id )}}"
                                                           class="{{($unavailability) ? 'btn btn-danger' : 'btn btn-success'}}">
                                                            {{($unavailability) ? 'Not Available' : 'Is Available'}}
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @elseif($collection->is_available == 0)
                                                        <a href="{{ url('/collection/availability/edit/' . $collection->id )}}"
                                                           class="btn btn-danger">
                                                            Not Available
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{$collection->id}}</td>
                                                <td>
                                                    @if($collection->approved == 0)
                                                        <span class="label label-default">Pending Approval</span>
                                                    @elseif($collection->approved == 2)
                                                        <span class="label label-danger">Rejected</span>
                                                    @endif
                                                    @if($collection->editingCollection)
                                                        <span class="label label-default">Pending Edit Approval</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="center">There are no collections available.</td>
                                        </tr>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($collections) > 0)
                        {{ $collections->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($selectedRestaurant)
        <div class="modal fade" id="modalNewCollection" role="dialog" tabindex="-1">
            <form role="form" class="form-horizontal" accept-charset="utf-8" method="GET"
                  action="{{ url('/collection/create') }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Select Collection Category</h4>
                            <input type="hidden" name="restaurant_id" class="form-control"
                                   value="{{$selectedRestaurant->id}}">
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-8">
                                    <select name="collection_category" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name_en}}</option>
                                        @endforeach
                                    </select>&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button  type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <script type="text/javascript">
        $(document).ready(function () {
            $('select.form-control').select2();
        });
    </script>
@endsection
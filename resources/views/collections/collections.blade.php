@extends('home', ['title' => 'Collections'])
@section('content')

    <script src="{{ asset('js/collections.js') }}"></script>

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
                                <select name="restaurant_name" id="input-name" class="form-control" tabindex="-1" title="" onchange="top.location.href = this.options[this.selectedIndex].value">
                                    @if (!$id)
                                        <option value>Select Restaurant</option>
                                    @endif

                                    @foreach($restaurants as $restaurant)
                                        <option value="{{ url('/collections/' . $restaurant->id) }}" {{ $restaurant->id == $id ? 'selected' : '' }} >
                                            {{ $restaurant->name_en }}
                                        </option>
                                    @endforeach
                                    {{-- @if($selectedRestaurant)
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/collections/' . $restaurant->id)}}" {{($restaurant->id == $selectedRestaurant->id) ? 'selected' : ''}}>{{$restaurant->name_en}}</option>
                                        @endforeach
                                    @else
                                        <option value>Select Restaurant</option>
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{url('/collections/' . $restaurant->id)}}">{{$restaurant->name_en}}</option>
                                        @endforeach
                                    @endif --}}
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
                                        <th>Extra Images</th>
                                        <th>Availability</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Service Type</th>
                                        <th>Price</th>
                                        <th>Mealtime</th>
                                        <th>ID</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($selectedRestaurant)
                                        @if(count($collections) > 0)
                                            @foreach($collections as $collection)
                                                <tr class="{{ ($collection->editingCollection || $collection->approved == 0) ? 'info' : '' }}" id="mainTr{{ $collection->id }}">
                                                    <td class="action">
                                                        <input type="checkbox" value="{{ $collection->id }}" name="delete"/>

                                                        <a class="btn btn-edit" title="" href="{{ url('/collection/edit/' . $collection->id) }}">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>&nbsp;&nbsp;

                                                        @if($user->admin == 1)
                                                            @if($collection->approved == 0)
                                                                <a class="btn btn-edit" title=""
                                                                   href="{{ url('collection/approve/' . $collection->id) }}">
                                                                    <i class="fa fa-check"></i>
                                                                    Approve
                                                                </a>&nbsp;&nbsp;
                                                                <a class="btn btn-danger" title=""
                                                                   href="{{ url('collection/reject/' . $collection->id) }}">
                                                                    <i class="fa fa-ban"></i>
                                                                    Reject
                                                                </a>&nbsp;
                                                            @endif
                                                        @endif

                                                    </td>
                                                    <td class="action">
                                                        <a  class="btn btn-edit" id="add_images"
                                                            data-id="{{ $collection->id }}"
                                                            data-toggle="modal"
                                                            data-target="#extra_images">
                                                            <i class="fa fa-image"></i>
                                                        </a>
                                                    </td>
                                                    <td class="action">

                                                        @if($collection->is_available == 1)
                                                            @if($collection->unavailabilityHour->isEmpty())
                                                                <a href="{{ url('/collection/availability/edit/' . $collection->id) }}" class="btn btn-success">
                                                                    Is Available
                                                                    <i class="fa fa-clock-o"></i>
                                                                </a>
                                                            @else
                                                                @php
                                                                    $collectionAvailability = $collection->unavailabilityHour->where('weekday', $day)
                                                                        ->where('start_time', '<=', $time)
                                                                        ->where('end_time', '>=', $time)
                                                                        ->where('status', 1)
                                                                        ->first();
                                                                @endphp
                                                                <a href="{{ url('/collection/availability/edit/' . $collection->id) }}" class="{{ ($collectionAvailability) ? 'btn btn-success' : 'btn btn-danger' }}">
                                                                    {{ ($collectionAvailability) ? 'Is Available' : 'Not Available' }}
                                                                    <i class="fa fa-clock-o"></i>
                                                                </a>
                                                            @endif

                                                        @elseif($collection->is_available == 0)
                                                            <a href="{{ url('/collection/availability/edit/' . $collection->id) }}"
                                                               class="btn btn-danger">
                                                                Not Available
                                                                <i class="fa fa-clock-o"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td id="name{{ $collection->id }}">
                                                        {{ $collection->name_en }}
                                                    </td>
                                                    <td id="description{{ $collection->id }}">
                                                        {{ $collection->description_en }}
                                                    </td>
                                                    <td id="categoryName{{ $collection->id }}">
                                                        {{ $collection->category->name_en }}
                                                    </td>
                                                    <td id="serviceTypeName{{ $collection->id }}">
                                                        {{ $collection->serviceType->name_en }}
                                                    </td>
                                                    <td id="price{{ $collection->id }}">
                                                        {{ $collection->price }}
                                                    </td>
                                                    <td id="mealtimeName{{ $collection->id }}">
                                                        {{ $collection->mealtime->name_en }}
                                                    </td>
                                                    <td>{{ $collection->id }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($collection->approved == 0)
                                                            <span class="label label-default">Pending Approval</span>
                                                        @elseif($collection->approved == 2)
                                                            <span class="label label-danger">Rejected</span>
                                                        @endif
                                                        @if($collection->editingCollection)
                                                            <div id="statusAndBtn{{ $collection->id }}">
                                                                @if ($user->admin == 1)
                                                                    <button type="button" class="btn btn-info" id="view_edited"
                                                                            data-id="{{ $collection->id }}"
                                                                            data-toggle="modal"
                                                                            data-target="#edited_collection">
                                                                        View edited fields
                                                                    </button><br>
                                                                @endif
                                                                <span class="label label-default">Pending Edit Approval</span>
                                                            </div>
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
                                   value="{{ $selectedRestaurant->id }}">
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-8">
                                    <select name="collection_category" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id}}">{{$category->name_en }}</option>
                                        @endforeach
                                    </select>&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <!-- view edited fields modal -->
        <div class="modal fade" id="edited_collection">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">View edited fields</h4>
                    </div>

                    <div class="modal-body" id="show_fields">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-top: 10px;">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- /view edited fields modal -->



    <div class="modal fade" id="extra_images">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Extra Images</h4>
                </div>

                <div class="modal-body" id="show_images">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-top: 10px;">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $('select.form-control').select2();
        });
    </script>
@endsection
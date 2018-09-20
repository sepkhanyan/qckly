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
                                                       placeholder="Search name, description or city."/>&nbsp;&nbsp;&nbsp;
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
                                    <th>Area</th>
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
                                        <td>{{$restaurant->city_en}}</td>
                                        <td>{{$restaurant->address_en}}</td>
                                        <td>{{$restaurant->telephone}}</td>
                                        @if($restaurant->status == 1)
                                            <td>Enable</td>
                                        @else
                                            <td>Disable</td>
                                        @endif
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
@endsection
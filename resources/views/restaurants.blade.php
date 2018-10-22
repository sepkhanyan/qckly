@extends('home', ['title' => 'Restaurants'])
@section('content')
    <div id="page-wrapper">
        <div class="page-header">
            <div class="page-action">
                @if(Auth::user()->admin == 1)
                    <a href="{{ url('/restaurant/create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_restaurant">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                @endif
            </div>
        </div>
        <div class="row content">
            <div class="col-md-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        @if(Auth::user()->admin == 1)
                            <h3 class="panel-title">Restaurant List</h3>
                        @else
                            <h3 class="panel-title">Restaurant</h3>
                        @endif
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
                                @if(count($restaurants) > 0)
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
                                            <td>{{$restaurant->area->name_en}}</td>
                                            <td>{{$restaurant->address_en}}</td>
                                            <td>{{$restaurant->telephone}}</td>
                                            <td data-toggle="modal" data-target="#changeStatus"
                                                onclick="myFunction('{{$restaurant->id}}','{{$restaurant->status}}')"
                                                style="font-size: 20px; cursor: pointer">
                                                @if($restaurant->status == 1)
                                                    <a class="btn btn-success">{{\Lang::get('message.open')}}</a>
                                                @elseif($restaurant->status == 0)
                                                    <a class="btn btn-danger">{{\Lang::get('message.busy')}}</a>
                                                @endif
                                            </td>
                                            <td>{{$restaurant->id}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no restaurants available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($restaurants) > 0)
                        {{ $restaurants->links() }}
                    @endif
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
                            <label id="open">
                                <input type="radio" name="status" value="1" id="input_open">
                                Open
                            </label>
                            <label id="busy">
                                <input type="radio" name="status" value="0" id="input_busy">
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
        function myFunction(id, status) {
            console.log(status);
            if (status == 1) {
                $('#open').attr('class', 'btn btn-success active');
                $('#busy').attr('class', 'btn btn-danger');
                $('#input_open').attr('checked', 'checked');
            } else {
                $('#busy').attr('class', 'btn btn-danger active');
                $('#open').attr('class', 'btn btn-success');
                $('#input_busy').attr('checked', 'checked');
            }
            $("#edit-form").attr('action', 'restaurant/status/update/' + id);
        }
    </script>
@endsection
@extends('header')
@section('content')
    <div class="page-header">
        <div class="page-action">
            <a {{--data-toggle="modal" data-target="#addCost"--}} href="{{ url('/new/areas') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                New
            </a>
            <a class="btn btn-danger " id="delete_area">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Areas</h3>
                    <div class="pull-right">
                        <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
                <div class="panel-body panel-filter" style="display: none">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="{{url('/areas')}}">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <input type="text" name="area_search" class="form-control input-sm" value="" placeholder="Search area." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a class="btn btn-grey" href="{{url('/areas')}}" title="Clear">
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
                                        Area En
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Area Ar
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        ID
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($areas as $area)
                                <tr>
                                    <td class="action">
                                        <input type="checkbox" value="{{ $area->id }}" name="delete" />&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-edit" title="" href="{{ url('area/edit/' . $area->id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$area->area_en}}</td>
                                    <td>{{$area->area_ar}}</td>
                                    <td>{{$area->id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $areas->links() }}
                    </div>
                </form>
               {{-- <div class="pagination-bar clearfix">
                    <div class="links"></div>
                    <div class="info"></div>
                </div>--}}
            </div>
        </div>
    </div>
    {{--<div class="modal fade myeditform in " id="addCost" tabindex="-1"  >--}}
        {{--<form class="form-horizontal ng-pristine ng-valid" accept-charset="utf-8" method="GET" action="{{ url('/areas/store') }}">--}}
            {{--<div class="modal-dialog" >--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                        {{--<h4 class="modal-title" id=""> Add Area </h4>--}}
                    {{--</div>--}}

                        {{--<div class="form-group" style="margin-left: 3px">--}}
                            {{--<label class="control-label col-sm-2" for="area-en">Area En</label>--}}
                            {{--<div class="col-sm-8">--}}
                                {{--<input type="text" name="area_en" class="form-control" id="area-en">--}}
                                {{--<span class="help-block" >--}}

                                       {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--<div class="form-group" style="margin-left: 3px">--}}
                        {{--<label class="control-label col-sm-2" for="area-ar">Area Ar</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text" name="area_ar" class="form-control" id="area-ar">--}}
                            {{--<span class="help-block" >--}}

                                       {{--</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                        {{--<button type="submit"  class="btn btn-primary">Add Area</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}

        {{--</form>--}}
    {{--</div>--}}

    </form>
    </div>
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
        </script>
@endsection

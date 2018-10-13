@extends('home', ['title' => 'Languages'])
@section('content')
    <div id="page-wrapper">
        @if(Auth::user()->admin == 1)
            <div class="page-header">
                <div class="page-action">
                    <a href="{{ url('/language/create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New
                    </a>
                    <a class="btn btn-danger " id="delete_language">
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
                        <h3 class="panel-title">Language List</h3>
                        <div class="pull-right">
                            <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="panel-body panel-filter">
                        <form role="form" id="filter-form" accept-charset="utf-8" method="GET"
                              action="{{url('/languages')}}">
                            <div class="filter-bar">
                                <div class="form-inline">
                                    <div class="row">
                                        <div class="col-md-3 pull-right text-right">
                                            <div class="form-group">
                                                <input type="text" name="filter_search" class="form-control input-sm"
                                                       value="" placeholder="Search name.">
                                            </div>
                                            <a class="btn btn-grey" onclick="filterList();" title=""
                                               data-original-title="Search">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a class="btn btn-grey" href="{{url('/languages')}}"
                                               title="" data-original-title="Clear">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form role="form" id="list-form" accept-charset="utf-8" method="POST">
                        <div class="table-responsive">
                            <table border="0" class="table table-striped table-border">
                                <thead>
                                <tr>
                                    <th class="action">
                                        <input type="checkbox"
                                               onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    </th>
                                    <th width="55%">Name</th>
                                    <th>Code</th>
                                    <th class="text-center">Icon</th>
                                    <th>Idiom</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($languages) > 0)
                                    @foreach($languages as $language)
                                        <tr>
                                            <td class="action">
                                                <input type="checkbox" value="{{$language->id}}" name="delete">
                                                <a class="btn btn-edit" title=""
                                                   href="{{url('/language/edit/' . $language->id)}}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </td>
                                            <td width="55%">{{$language->name}}</td>
                                            <td>{{$language->code}}</td>
                                            <td class="text-center">
                                                <img src="/images/{{$language->image}}">
                                            </td>
                                            <td>{{$language->idiom}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="center">There are no languages available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @if(count($languages) > 0)
                        {{$languages->links()}}
                    @endif
                </div>
            </div>
        </div>
        <script type="text/javascript"><!--
            function filterList() {
                $('#filter-form').submit();
            }

            //--></script>
    </div>
@endsection
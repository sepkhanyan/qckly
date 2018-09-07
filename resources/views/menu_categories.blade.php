@extends('home')
@section('content')
    <div class="page-header">
        <div class="page-action">
            <a href="{{ url('/category/create') }}"  class="btn btn-primary">
                <i class="fa fa-plus"></i>
                New
            </a>
            <a class="btn btn-danger" id="delete_category">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title">Category List</h3>
                    <div class="pull-right">
                        <button class="btn btn-filter btn-xs">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                </div>
                <div class="panel-body panel-filter" style="display: none">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="{{url('/categories')}}">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-3 pull-right text-right">
                                        <div class="form-group">
                                            <input type="text" name="category_search" class="form-control input-sm" value="" placeholder="Search category name, description or status." />&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <select name="category_status" class="form-control input-sm">
                                                <option value="">View all status</option>
                                                <option value="1"  >Enabled</option>
                                                <option value="0"  >Disabled</option>
                                            </select>
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="Filter">
                                            <i class="fa fa-filter"></i>
                                        </a>&nbsp;
                                        <a class="btn btn-grey" href="{{url('/categories')}}" title="Clear">
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
                                        Name
                                        <i class="fa fa-sort"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Description
                                        <i class="fa fa-sort>"></i>
                                    </a>
                                </th>
                                <th>
                                    <a class="sort" href="">
                                        Status
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

                            @foreach($categories as $category)
                                <tr>
                                    <td class="action">
                                        <input type="checkbox" value="{{ $category->id }}" name="delete" />
                                        <a class="btn btn-edit" title="" href="{{ url('category/edit/' . $category->id )}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>&nbsp;&nbsp;
                                    </td>
                                    <td>{{$category->name_en}}</td>
                                    <td>{{$category->description_en}}</td>
                                    @if($category->status == 1)
                                        <td>Enable</td>
                                    @else
                                        <td>Disable</td>
                                    @endif
                                    <td>{{$category->id}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $categories->links() }}
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
    <script type="text/javascript">
        function filterList() {
            $('#filter-form').submit();
        }
        //--></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
                $('#side-menu .' + active_menu).addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').parent().addClass('active');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
                $('#side-menu .' + active_menu).parents('.collapse').collapse('show');
            }

            if (window.location.hash) {
                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                $('html,body').animate({scrollTop: $('#wrapper').offset().top - 45}, 800);
                $('#nav-tabs a[href="#'+hash+'"]').tab('show');
            }

            $('.btn-group input[type="radio"]:checked, .btn-group .active input[type="radio"]').trigger('change');
        });

        function confirmDelete(form) {
            if ($('input[name="delete[]"]:checked').length && confirm('This cannot be undone! Are you sure you want to do this?')) {
                form = (typeof form === 'undefined' || form === null) ? 'list-form' : form;
                $('#'+form).submit();
            } else {
                return false;
            }
        }

        function saveClose() {
            $('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
            $('#edit-form').submit();
        }
    </script>
@endsection
<div id="page-wrapper" style="margin: 0; padding: 20px 20px">
    <div class="row content">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">

                <li class="active">
                    <a href="#old" data-toggle="tab">Old Details</a>
                </li>

                <li>
                    <a href="#new" data-toggle="tab">New Details</a>
                </li>

            </ul>
        </div>
        <div class="tab-content">
            <div id="old" class="tab-pane row wrap-all active">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Category Old Fields</h3>
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form-horizontal">
                            <fieldset class="content-group">

                                @if (isset($oldFields['name_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name En </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['name_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['name_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" value="{{ $oldFields['name_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['description_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($oldFields['description_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" rows="5" readonly>{{ $oldFields['description_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif


                                @if (isset($oldFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Image</label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $oldFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <div id="new" class="tab-pane row wrap-all">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <h3 class="panel-title">Category New Fields</h3>
                    </div>

                    <div class="panel-body">
                        <form role="form" id="editForm" class="form-horizontal" method="POST" action="{{ url('/menu_category/edit_approve/' . $category->id) }}" data-id="{{ $category->id }}" enctype="multipart/form-data">
                            <fieldset class="content-group">
                                {{ csrf_field() }}

                                @if (isset($newFields['name_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name En </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="name_en" class="form-control" value="{{ $newFields['name_en'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['name_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Name Ar </label>
                                        <div class="col-lg-5">
                                            <input type="text" name="name_ar" class="form-control" value="{{ $newFields['name_ar'] }}" readonly>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_en']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description En </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="description_en" rows="5" readonly>{{ $newFields['description_en'] }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($newFields['description_ar']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Description Ar </label>
                                        <div class="col-lg-5">
                                            <textarea class="form-control" name="description_ar" rows="5" readonly>{{ $newFields['description_ar'] }}</textarea>
                                        </div>
                                    </div>
                                @endif


                                @if (isset($newFields['image']))
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">Image</label>
                                        <div class="col-lg-5">
                                            <img src="{{ url('/images') . '/' . $newFields['image'] }}" height="50%" width="50%">
                                        </div>
                                    </div>
                                @endif

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success" style="margin-top: 10px;">Approve</button>
                                    <button type="button" class="btn btn-danger" id="reject" data-id="{{ $category->id }}" style="margin-top: 10px;">Reject</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
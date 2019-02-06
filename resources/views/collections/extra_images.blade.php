<style>
    input[type=file] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background: #EEE;
        background: linear-gradient(to top, #FFF, #DDD);
        border: thin solid rgba(0, 0, 0, .5);
        border-radius: .25em;
        box-shadow: inset .25em .25em .25em rgba(255, 255, 255, .5), inset -.1em -.1em .1em rgba(0, 0, 0, 0.1);
        cursor: text;
        padding: .25em;
    }

    .imageThumb {
        max-height: 100px;
        border: 1px solid;
        padding: 0px;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        /*background: #444;*/
        /*border: 1px solid black;*/
        /*color: white;*/
        text-align: center;
        cursor: pointer;
    }

    /*.remove:hover {*/
    /*background: white;*/
    /*color: black;*/
    /*}*/
</style>
{{--<div id="page-wrapper" style="margin: 0; padding: 20px 20px">--}}
{{--<div class="row content">--}}
{{--<div class="row wrap-vertical">--}}
{{--<ul id="nav-tabs" class="nav nav-tabs">--}}

{{--<li class="active">--}}
{{--<a href="#images" data-toggle="tab">Collection Extra Images</a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="tab-content">--}}
{{--<div id="images" class="tab-pane row wrap-all active">--}}
{{--<div class="panel panel-default panel-table">--}}
{{--<div class="panel-heading">--}}
{{--<h3 class="panel-title">Collection Extra Images</h3>--}}
{{--</div>--}}

{{--<div class="panel-body">--}}
<form role="form" class="form-horizontal">
    <fieldset class="content-group">
        @if ($collectionImages->isNotEmpty())

            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-7">
                    <div class="thumbnail">
                        <div>
                            @foreach($collectionImages as $collectionImage)
                                <span class="pip">
                                    <img src="{{ url('/images') . '/' . $collectionImage['image'] }}" class="imageThumb" style="height: 100px">
                                    <br/>
                                    <span class="remove" id="removeImage" data-id="{{ $collectionImage->id }}">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </span>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>


        @endif
    </fieldset>
</form>

<form role="form" id="uploadImages" class="form-horizontal" method="POST" enctype="multipart/form-data"
      action="{{ url('/addExtraImages/' . $collection->id) }}" data-id="{{ $collection->id }}">
    {{ csrf_field() }}
    <fieldset class="content-group">
        <div id="imageForm" class="form-group">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-7">
                <div class="control-group control-group-3">
                    <div class="input-group">
                        <input type="file" name="image[]" multiple>
                    </div>
                    <div class="input-group">
                        <button type="submit" id="uploadButton" class="btn btn-primary"><i class="fa fa-picture-o"></i>Upload</button>
                        {{--<button type="button" class="btn btn-danger" id="reject" data-id="{{ $collection->id }}" style="margin-top: 10px;">Reject</button>--}}
                    </div>
                    <div class="input-group">
                        <span   class="help-block hidden">
                                        <strong></strong>
                                    </span>
                    </div>
                </div>
            </div>
        </div>

    </fieldset>
</form>
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
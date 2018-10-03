<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Media Manager</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.raty.css') }}" rel="stylesheet">
    <link href="{{ asset('css/imagemanager/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/imagemanager/image-manager.css') }}" rel="stylesheet">


    <script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/js.cookie.js')}}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/imagemanager/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/imagemanager/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/imagemanager/selectonic.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>


    <script type="text/javascript">
        var js_site_url = function (str) {
            var strTmp = "{{url('/')}}" + str + "";
            return strTmp;
        };

        var js_base_url = function (str) {
            var strTmp = "{{url('/')}}" + str + "";
            return strTmp;
        };

        var allowed_ext = new Array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico');
        var maxSizeUpload = 0.29;
    </script>
</head>
<body>
<div class="notification alert alert-info" style="display:none;"><span data-original-title="" title=""></span></div>
<input type="hidden" id="current_url" value="{{url('/image_manager?popup=iframe')}}">
<input type="hidden" id="new_gallery" value="New Folder">
<input type="hidden" id="total_files" value="54">
<input type="hidden" id="total_selected" value="">
<input type="hidden" id="field_id" value="">
<input type="hidden" id="sub_folder" value="">
<input type="hidden" id="current_folder" value="">
<input type="hidden" id="sort_order" value="ascending">
<div id="folders_list" style="display:none;">
    <select class="form-control">
        <option value="/">/</option>
        <option value="flags/">flags/</option>
        <option value="gallery/">gallery/</option>
        <option value="gallery/lewisham/">gallery/lewisham/</option>
        <option value="newtest/">newtest/</option>
        <option value="newtest/testfolder/">newtest/testfolder/</option>
    </select>
    <span class="help-block small" data-original-title="" title="">Existing file/folder will NOT be replaced</span>
</div>

<nav class="navbar navbar-default navbar-menu" role="navigation">
    <div class="container-fluid navbar-fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" data-original-title="" title="">
                <span class="sr-only" data-original-title="" title="">Toggle navigation</span>
                <span class="icon-bar" data-original-title="" title=""></span>
                <span class="icon-bar" data-original-title="" title=""></span>
                <span class="icon-bar" data-original-title="" title=""></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="btn-toolbar" role="toolbar">
                <div class="col-xs-12 col-sm-2 wrap-none">
                    <div class="btn-group">
                        <a class="btn btn-default navbar-btn btn-back Disabled" title="" href=""
                           data-original-title="Back"><i class="fa fa-arrow-left"></i></a>
                        <a id="refresh" title="" class="btn btn-default navbar-btn btn-refresh"
                           href="{{url('/image_manager?popup=iframe')}}"
                           data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 wrap-none">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default navbar-btn btn-upload" data-original-title=""
                                title=""><i class="fa fa-upload"></i>&nbsp;&nbsp;
                            <small>Upload</small>
                        </button>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-1 wrap-none">
                    <div class="btn-group">
                        <a class="btn btn-default navbar-btn btn-options" title=""
                           href="{{url('/image_manager?popup=iframe')}}" target="_parent"
                           data-original-title="Options"><i class="fa fa-gear"></i></a>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-1 wrap-none">
                    <div class="btn-group">
                        <div class="dropdown">
                            <a class="btn btn-default navbar-btn btn-sort dropdown-toggle" data-toggle="dropdown"
                               title="" data-original-title="Sort">
                                <i class="fa fa-sort-amount-asc"></i> <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-sorter" role="menu">
                                <li><span data-original-title="" title=""><strong>Sort By:</strong></span></li>
                                <li class="divider"></li>
                                <li>
                                    <a class="sorter" data-sort="name" data-original-title="" title=""><i
                                                class="fa fa-caret-up"></i>Name</a>
                                </li>
                                <li>
                                    <a class="sorter" data-sort="date" data-original-title="" title="">Date</a>
                                </li>
                                <li>
                                    <a class="sorter" data-sort="size" data-original-title="" title="">Size</a>
                                </li>
                                <li>
                                    <a class="sorter" data-sort="extension" data-original-title="" title="">Type</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-4 wrap-none">
                    <div class="btn-group btn-block">
                        <div class="navbar-form input-group">
                            <span id="btn-clear" class="input-group-addon" title="" data-original-title="Clear"><i
                                        id="filter-clear" class="fa fa-times"></i></span>
                            <input type="text" name="filter_search" id="filter-search" class="form-control" value=""
                                   placeholder="Search files and folders...">
                            <span id="btn-search" class="input-group-addon" title="" data-original-title="Search"><i
                                        class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ol class="breadcrumb">
            <li id="folderPopover">
                <button type="button" class="btn btn-folders" data-container="body" data-placement="bottom"
                        data-toggle="popover" data-original-title="" title="">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
            </li>
            <li class="active"><i class="fa fa-home"></i></li>
            <li>
                <a class="btn btn-new-folder" title="" href="#" data-original-title="New Folder"><i
                            class="fa fa-folder"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-rename" title="" data-name="" data-path="/" href="#"
                   data-original-title="Rename Folder"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="btn btn-delete" title="" data-name="" data-path="/" href="#"
                   data-original-title="Delete Folder"><i class="fa fa-trash"></i></a>
            </li>
        </ol>
    </div>
</nav>

<div class="media-content container-fluid">
    <div class="row-fluid">
        <div id="notification"></div>

        <div class="uploader-box">
            <div class="tabbable upload-tabbable"> <!-- Only required for left/right tabs -->
                <form role="form" method="POST" enctype="multipart/form-data" id="my-awesome-dropzone"
                      class="dropzone dz-clickable">
                    <input type="hidden" name="sub_folder" value="">

                    <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
                </form>
            </div>
        </div>

        <div class="grid-box">
            <div id="selectable" class="col-xs-9 wrap-none">
                <div class="media-preview row"></div>
                <div class="media-list row selectable">
                    <div class="thumbnail-each col-xs-6 col-sm-4 ff-item-type-2 file">
                        <figure class="thumbnail" data-type="img" data-name="DSCF3711.JPG" data-path="DSCF3711.JPG">
                            <a class="link" title="" data-original-title="29 KB">
                                <div class="img-container">
                                    <img alt="DSCF3711.JPG" class="img-responsive thumb"
                                         src="https://demo.tastyigniter.com/assets/images/thumbs/DSCF3711-320x220.JPG">
                                </div>
                                <figcaption class="caption">
                                    <h4 class="ellipsis">
                                        <span class="" data-original-title="" title="">DSCF3711</span>
                                    </h4>
                                </figcaption>
                            </a>
                            <div class="info">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-preview" title=""
                                            data-url="https://demo.tastyigniter.com/assets/images/data/DSCF3711.JPG"
                                            data-original-title="Preview"><i class="fa fa-eye"></i></button>
                                    <button type="button" class="btn btn-default btn-rename" title=""
                                            data-name="DSCF3711.JPG" data-path="" data-original-title="Rename"><i
                                                class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-default btn-move" title=""
                                            data-original-title="Move"><i class="fa fa-folder-open"></i></button>
                                    <button type="button" class="btn btn-default btn-copy" title=""
                                            data-original-title="Copy"><i class="fa fa-clipboard"></i></button>
                                    <button type="button" class="btn btn-default btn-delete" title=""
                                            data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                </div>
                                <ul class="get_info">
                                    <li class="file-name">
                                        <span data-original-title="" title="">Name :</span>DSCF3711.JPG
                                    </li>
                                    <li class="file-size">
                                        <span data-original-title="" title="">Size :</span> 29 KB
                                    </li>
                                    <li class="file-path">
                                        <span data-original-title="" title="">Path :</span> /
                                    </li>
                                    <li class="file-url"><span data-original-title="" title="">URL :</span>
                                        <input type="text" class="form-control url-control" readonly="readonly"
                                               value="https://demo.tastyigniter.com/assets/images/data/DSCF3711.JPG">
                                    </li>
                                    <li class="img-dimension">
                                        <span data-original-title="" title="">Dimension :</span> 400 x 266
                                    </li>
                                    <li class="file-date">
                                        <span data-original-title="" title="">Modified Date :</span> 10 Mar 17
                                    </li>
                                    <li class="file-extension">
                                        <span data-original-title="" title="">Extension :</span><em
                                                class="text-uppercase">JPG</em>
                                    </li>
                                    <li class="file-permission">
                                        <span data-original-title="" title="">Permission :</span>
                                        Read &amp; Write
                                    </li>
                                </ul>
                            </div>
                        </figure>
                    </div>


                    <div class="thumbnail-each col-xs-6 col-sm-4 ff-item-type-2 file">
                        <figure class="thumbnail" data-type="img" data-name="yam_porridge.jpg"
                                data-path="yam_porridge.jpg">
                            <a class="link" title="" data-original-title="52 KB">
                                <div class="img-container">
                                    <img alt="yam_porridge.jpg" class="img-responsive thumb"
                                         src="https://demo.tastyigniter.com/assets/images/thumbs/yam_porridge-320x220.jpg">
                                </div>
                                <figcaption class="caption">
                                    <h4 class="ellipsis">
                                        <span class="" data-original-title="" title="">yam_porridge</span>
                                    </h4>
                                </figcaption>
                            </a>
                            <div class="info">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-preview" title=""
                                            data-url="https://demo.tastyigniter.com/assets/images/data/yam_porridge.jpg"
                                            data-original-title="Preview"><i class="fa fa-eye"></i></button>
                                    <button type="button" class="btn btn-default btn-rename" title=""
                                            data-name="yam_porridge.jpg" data-path="" data-original-title="Rename"><i
                                                class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-default btn-move" title=""
                                            data-original-title="Move"><i class="fa fa-folder-open"></i></button>
                                    <button type="button" class="btn btn-default btn-copy" title=""
                                            data-original-title="Copy"><i class="fa fa-clipboard"></i></button>
                                    <button type="button" class="btn btn-default btn-delete" title=""
                                            data-original-title="Delete"><i class="fa fa-trash"></i></button>
                                </div>
                                <ul class="get_info">
                                    <li class="file-name">
                                        <span data-original-title="" title="">Name :</span>yam_porridge.jpg
                                    </li>
                                    <li class="file-size">
                                        <span data-original-title="" title="">Size :</span> 52 KB
                                    </li>
                                    <li class="file-path">
                                        <span data-original-title="" title="">Path :</span> /
                                    </li>
                                    <li class="file-url"><span data-original-title="" title="">URL :</span>
                                        <input type="text" class="form-control url-control" readonly="readonly"
                                               value="https://demo.tastyigniter.com/assets/images/data/yam_porridge.jpg">
                                    </li>
                                    <li class="img-dimension">
                                        <span data-original-title="" title="">Dimension :</span> 604 x 453
                                    </li>
                                    <li class="file-date">
                                        <span data-original-title="" title="">Modified Date :</span> 10 Mar 17
                                    </li>
                                    <li class="file-extension">
                                        <span data-original-title="" title="">Extension :</span><em
                                                class="text-uppercase">jpg</em>
                                    </li>
                                    <li class="file-permission">
                                        <span data-original-title="" title="">Permission :</span>
                                        Read &amp; Write
                                    </li>
                                </ul>
                            </div>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="media-sidebar col-xs-3">
                <div id="media-details"></div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-default navbar-statusbar navbar-fixed-bottom" role="navigation">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <p class="navbar-text">
                    <span class="total-selected" data-original-title="" title="">0</span><span
                            class="total-selected-text" data-original-title="" title=""> of </span>54 items selected, 6
                    MB </p>
            </div>
            <div class="col-sm-4 text-right">
            </div>
        </div>
    </div>
</nav>

<div id="previewBox" style="display:none;"></div>
<script type="text/javascript"><!--
    $(document).ready(function () {
        $('a, button, span').tooltip({container: 'body', placement: 'bottom'});

        var folder_tree = '<nav class="nav">' +
            '<ul class="metisFolder" role="menu"><li class="directory"><a href="#"><i class="fa fa-folder-open"></i> flags</a><ul></ul></li><li class="directory"><a href="#"><i class="fa fa-folder-open"></i> gallery</a><ul><li class="directory"><a href="#"><i class="fa fa-folder-open"></i> lewisham</a><ul></ul></li></ul></li><li class="directory"><a href="#"><i class="fa fa-folder-open"></i> newtest</a><ul><li class="directory"><a href="#"><i class="fa fa-folder-open"></i> testfolder</a><ul></ul></li></ul></li></ul></nav>';
        $('#folderPopover .btn-folders').popover({
            container: '#folderPopover',
            html: true,
            title: 'Folders',
            content: '<span class="help-block">Double click to go</span>' + folder_tree
        });

        $('#folderPopover').on('shown.bs.popover', function () {
            $('.metisFolder').metisMenu({
                toggle: false,
                doubleTapToGo: true
            });
        });

        $('.media-list').on('click', function () {
            $('#folderPopover .btn-folders').popover('hide');
        });

        var mediaList = $('.media-list');
        mediaList.selectonic({
            listClass: 'selectable',
            selectedClass: 'selected',
            focusClass: 'focused',
            disabledClass: 'disabled',
            keyboard: true,
            select: function (event, ui) {
                $('#media-details').html($(ui.target).find('.info').html());
                $('.btn-copy, .btn-move, .btn-choose').removeClass('disabled');
            },
            unselect: function (event, ui) {
                $('#media-details').html('');
            },
            unselectAll: function (event, ui) {
                $('#media-details').html('');
                $('.btn-copy, .btn-move, .btn-choose').addClass('disabled');
            },
            stop: function () {
                var totalSelected = mediaList.selectonic('getSelected').length;
                $('.total-selected').html(totalSelected);
            }
        });

        if ($(".selected-on-open")[0]) {
            mediaList.selectonic('select', $(".selected-on-open"));
            mediaList.selectonic('focus', $(".selected-on-open"));
            mediaList.selectonic('scroll');
        }

        $('#btn-search').on('click', function () {
            if ($('#filter-search').val().length > 1) {
                var input = fixFilename($('#filter-search').val());
                window.location.href = $('#refresh').attr('href') + '&filter=' + input;
            }
        });

        $('#filter-search').keypress(function (e) {
            if (e.which == 13) {
                if ($('#filter-search').val().length > 1) {
                    var input = fixFilename($('#filter-search').val());
                    window.location.href = $('#refresh').attr('href') + '&filter=' + input;
                }
            }
        });

        $('#btn-clear').on('click', function () {
            window.location.href = $('#refresh').attr('href');
        });

        $('.media-list .file').on('dblclick', '.link', function () {
            chooseSelected($(this).parent());
        });

        $(document).on('click', '.btn-choose', function () {
            var selected = mediaList.selectonic('getSelected');
            if (selected.length == 1) {
                chooseSelected($(selected).find('figure'));
            }
        });
    });

    //upload open
    $(document).on('click', '.btn-upload', function () {
        if ($(this).hasClass('active')) {
            $('.uploader-box').slideUp();
            $('.btn-upload').removeClass('active');
            window.location.href = $('#refresh').attr('href') + '&' + new Date().getTime();
        } else {
            $('.uploader-box').slideDown();
            $('.btn-upload').addClass('active');
            $('.btn-toolbar .btn:not(.btn-upload)').addClass('disabled');
        }
    });

    //sort by
    $(document).on('click', '.sorter', function () {
        var _this = $(this);
        $('.dropdown-toggle').trigger('click');
        var sortOrder = $('#sort_order').val();

        if (sortOrder == 'ascending') {
            sortOrder = 'descending';
        } else {
            sortOrder = 'ascending';
        }

        window.location.href = $('#refresh').attr('href') + "&sort_by=" + _this.attr('data-sort') + "&sort_order=" + sortOrder;
    });

    //new folder
    $(document).on('click', '.btn-new-folder', function () {
        bootbox.prompt('New Folder', function (result) {
            if (result === null) {
                Notification.show('Action canceled');
            } else {
                var new_name = $('.bootbox-input').val();
                new_name = fixFilename(new_name);
                var sub_folder = $.trim($('#sub_folder').val());
                if (new_name != '') {
                    var data = {name: new_name, sub_folder: sub_folder};
                    modalAjax('new_folder', data);
                } else {
                    Notification.show('Folder name can not be blank');
                }
            }
        });
    });

    //preview
    $(document).on('click', '.btn-preview', function () {
        var image_url = decodeURIComponent($(this).attr('data-url'));
        if (image_url != '') {
            bootbox.dialog({
                title: "Preview",
                size: "large",
                message: '<img src="' + image_url + '" width="100%"/>'
            });
        }
    });

    //rename
    $(document).on('click', '.btn-rename', function () {
        var file_name = $.trim($(this).attr('data-name'));
        var file_path = $.trim($(this).attr('data-path'));
        var title = 'Rename:';
        var message = '<input type="text" id="new-name" class="form-control" value="' + file_name + '" />';
        var main_callback = function () {
            var new_name = $('#new-name').val();
            new_name = fixFilename(new_name);
            if (new_name !== null && new_name != file_name) {
                var data = {file_path: file_path, file_name: file_name, new_name: new_name};
                modalAjax('rename', data);
            }
        };

        customModal(message, title, main_callback);
    });

    // copy
    $(document).on('click', '.btn-copy', function () {
        var copy_files = $('.media-list .selected figure').map(function () {
            return $(this).attr('data-name');
        }).get();
        if (copy_files != '') {
            var title = 'Copy selected items to:';
            var message = '<div id="folder-path">' + $('#folders_list').html() + '</div>';
            var main_callback = function () {
                var to_folder = $('#folder-path select').val();
                var from_folder = $.trim($('#sub_folder').val());
                if (to_folder !== null && to_folder != from_folder) {
                    var data = {
                        from_folder: from_folder,
                        to_folder: to_folder,
                        copy_files: JSON.stringify(copy_files)
                    };
                    modalAjax('copy', data);
                }
            };

            customModal(message, title, main_callback);
        } else {
            Notification.show('Please select the file(s) to copy');
        }
    });

    // move
    $(document).on('click', '.btn-move', function () {
        var move_files = $('.media-list .selected figure').map(function () {
            return $(this).attr('data-name');
        }).get();
        if (move_files != '') {
            var title = 'Move selected items to:';
            var message = '<div id="folder-path">' + $('#folders_list').html() + '</div>';
            var main_callback = function () {
                var from_folder = $.trim($('#sub_folder').val());
                var to_folder = $('#folder-path select').val();
                if (to_folder !== null && to_folder != from_folder) {
                    var data = {
                        from_folder: from_folder,
                        to_folder: to_folder,
                        move_files: JSON.stringify(move_files)
                    };
                    modalAjax('move', data);
                }
            };

            customModal(message, title, main_callback);
        } else {
            Notification.show('Please select the file(s) to move');
        }
    });

    //delete
    $(document).on('click', '.btn-delete', function () {
        var sub_folder = $.trim($('#sub_folder').val());
        var file_path = $.trim($(this).attr('data-path'));
        var file_name = $.trim($(this).attr('data-name'));
        var delete_files = $('.media-list .selected figure').map(function () {
            return $(this).attr('data-name');
        }).get();

        if (delete_files == '' && file_name != '' && file_path != '/') {
            bootbox.confirm('Are you sure you want to delete the opened folder and its contents?', function (result) {
                if (result === false) {
                    Notification.show('Action canceled');
                } else {
                    var data = {file_path: file_path, file_name: file_name};
                    modalAjax('delete', data);
                }
            });
        } else if (delete_files != '') {
            bootbox.confirm('Are you sure you want to delete the selected file (s)?', function (result) {
                if (result === false) {
                    Notification.show('Action canceled');
                } else {
                    var data = {file_path: sub_folder, file_names: JSON.stringify(delete_files)};
                    modalAjax('delete', data);
                }
            });
        } else {
            Notification.show('Please select the file(s) to delete');
        }
    });

    // choose
    function chooseSelected(figure) {
        var field = parent.$('#' + $('#field_id').val());
        var file_path = 'data/' + figure.attr('data-path');

        if ($('#field_id').attr('value').length) {
            var file_name = figure.attr('data-name');
            var thumb_name = field.parent().parent().find('.name');

            field.attr('value', file_path);
            thumb_name.html(file_name);
            parent.$('#media-manager').modal('hide');
        }

        if (parent.$('#media-manager.modal[data-parent="note-editor"]').is(':visible')) {
            // Get the current selection
            var range = parent.window.getSelection().getRangeAt(0);
            var node = range.startContainer;
            var startOffset = range.startOffset;  // where the range starts
            var endOffset = range.endOffset;      // where the range ends

            $.ajax({
                url: js_site_url('image_manager/resize?image=' + encodeURIComponent(file_path)),
                dataType: 'json',
                success: function (url) {
                    // Create a new range from the orginal selection
                    var range = document.createRange();
                    range.setStart(node, startOffset);
                    range.setEnd(node, endOffset);

                    var img = document.createElement('img');
                    img.src = url;

                    range.insertNode(img);

                    parent.$('#media-manager').modal('hide');
                }
            });
        }
    }

    function customModal(message, title, main_callback) {
        bootbox.dialog({
            message: message,
            title: title,
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: "btn-default",
                    callback: function () {
                        Notification.show('Action canceled');
                    }
                },
                main: {
                    label: "OK",
                    className: "btn-primary",
                    callback: main_callback
                }
            }
        });
    }

    function modalAjax(action, data) {
        var redirect = '';

        if (action === 'new_folder') {
            redirect = data.sub_folder + data.name + '/';
        } else if (action === 'create_gallery') {
            redirect = 'gallery/' + data.name + '/';
        } else if (action === 'delete') {
            redirect = data.file_path;
        } else if (action === 'rename') {
            redirect = data.file_path + data.new_name;
        } else if (action === 'copy' || action === 'move') {
            redirect = data.to_folder;
        }

        $.ajax({
            type: 'POST',
            url: js_site_url('image_manager/' + action),
            data: data,
            dataType: 'json',
            success: function (json) {
                showSuccess(json, redirect)
            }
        });
    }

    function showSuccess(json, redirect) {
        $('.error, .success').remove();

        var refresh_url = $('#refresh').attr('href');
        var cpos = refresh_url.indexOf("&sub_folder=") + "&sub_folder=".length,
            spos = refresh_url.indexOf("/&");
        if (typeof redirect != 'undefined' && redirect != '' && cpos > -1 && spos > cpos)
            var refreshUrl = refresh_url.substr(0, cpos) + redirect + refresh_url.substr(spos + 1);

        if (typeof refreshUrl == 'undefined') refreshUrl = refresh_url;

        var message = '';
        if (json['alert']) {
            message = json['alert'];
        }

        if (json['success']) {
            message = json['success'];
        }

        if (message != '') {
            Notification.show(message);
            setTimeout(function () {
                window.location.href = refreshUrl;
            }, 2000);
        }
    }

    function fixFilename(stri) {
        if (stri != null) {
            stri = stri.replace('"', '');
            stri = stri.replace("'", '');
            stri = stri.replace("/", '');
            stri = stri.replace("\\", '');
            stri = stri.replace(/<\/?[^>]+(>|$)/g, "");
            return $.trim(stri);
        }

        return null;
    }

    //--></script>

<script type="text/javascript"><!--
    //dropzone config
    window.Dropzone.options.myAwesomeDropzone = {
        dictInvalidFileType: 'File extension is not allowed.',
        dictFileTooBig: 'The uploaded file exceeds the max size allowed.',
        paramName: 'file', // The name that will be used to transfer the file
        maxFilesize: maxSizeUpload, // MB
        addRemoveLinks: false,
        url: js_site_url('image_manager/upload'),
        init: function () {
            this.on("addedfile", function (file) {
                var removeButton = Dropzone.createElement("<a class='dz-remove'>Delete file</a>");
                var _this = this;

                removeButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var sub_folder = $.trim($('#sub_folder').val());
                    var delete_file = file.name;
                    if (delete_file != '') {
                        $.ajax({
                            type: 'POST',
                            url: js_site_url('image_manager/delete'),
                            data: {file_path: sub_folder, file_name: delete_file},
                            dataType: 'json',
                            success: function (json) {
                                showSuccess(json);
                                _this.removeFile(file);
                            }
                        });
                    }
                });

                file.previewElement.appendChild(removeButton);
            });
        },
        accept: function (file, done) {
            var extension = file.name.split('.').pop();
            extension = extension.toLowerCase();

            if ($.inArray(extension, allowed_ext) == -1) {
                done('File extension is not allowed.');
            } else {
                done();
            }
        }
    };

    //--></script>
<script type="text/javascript"><!--
    var Notification = (function () {
        "use strict";

        var elem,
            hideHandler,
            that = {};

        that.init = function (options) {
            elem = $(options.selector);
        };

        that.show = function (text) {
            clearTimeout(hideHandler);

            elem.find("span").html(text);
            elem.delay(200).fadeIn().delay(4000).fadeOut();
        };

        return that;
    }());

    //--></script>

<script>
    $(function () {
        Notification.init({
            "selector": ".notification"
        });
    });
</script>


<input type="file" multiple="multiple" class="dz-hidden-input"
       style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;"></body>
</html>
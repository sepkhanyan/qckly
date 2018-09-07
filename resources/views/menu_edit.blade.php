@extends('home')
@section('content')
    <div class="page-header clearfix">
        <div class="page-action">
            <a class="btn btn-primary" onclick="$('#edit-form').submit();">
                <i class="fa fa-save"></i>
                Save
            </a>
            <a class="btn btn-default" onclick="saveClose();">
                <i class="fa fa-save"></i>
                Save & Close
            </a>
            <a href="{{ url('/menus') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
    <div class="row content">
        <div class="col-md-12">
            <div class="row wrap-vertical">
                <ul id="nav-tabs" class="nav nav-tabs">
                    <li class="active"><a href="#general" data-toggle="tab">Menu</a></li>
                    {{--<li><a href="#menu-details" data-toggle="tab">Details </a></li>--}}
                    {{--<li><a href="#menu-options" data-toggle="tab">Menu Option </a></li>--}}
                    {{--<li><a href="#specials" data-toggle="tab">Specials </a></li>--}}
                </ul>
            </div>
            <form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="{{ url('/menu/update/' . $menu->id) }}" >
                {{ csrf_field() }}
                <div class="tab-content">
                    <div id="general" class="tab-pane row wrap-all active">
                        <div class="form-group{{ $errors->has('name_en') ? ' has-error' : '' }}">
                            <label for="input_name_en" class="col-sm-3 control-label">Name En</label>
                            <div class="col-sm-5">
                                <input type="text" name="name_en" id="input_name_en" class="form-control" value="{{ $menu->name_en }}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description_en') ? ' has-error' : '' }}">
                            <label for="input_description_en" class="col-sm-3 control-label">Description En</label>
                            <div class="col-sm-5">
                                <textarea name="description_en" id="input_description_en" class="form-control" rows="5">{{ $menu->description_en }}</textarea>
                                @if ($errors->has('description_en'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name_ar') ? ' has-error' : '' }}">
                            <label for="input_name_ar" class="col-sm-3 control-label">Name Ar</label>
                            <div class="col-sm-5">
                                <input type="text" name="name_ar" id="input_name_ar" class="form-control" value="{{ $menu->name_ar }}">
                                @if ($errors->has('name_ar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('description_ar') ? ' has-error' : '' }}">
                            <label for="input_description_ar" class="col-sm-3 control-label">Description Ar</label>
                            <div class="col-sm-5">
                                <textarea name="description_ar" id="input_description_ar" class="form-control" rows="5">{{ $menu->description_ar }}</textarea>
                                @if ($errors->has('description_ar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description_ar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="input_price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="price" id="input_price" class="form-control" value="{{ $menu->price }}" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-money"></i>
                                    </span>
                                </div>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="input-name" class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-5">
                                <select name="category" id="category" class="form-control">
                                    <option value="{{$menu->category->id}}">{{$menu->category->name_en}}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name_en}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="famous" class="col-sm-3 control-label">Famous</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    @if($menu->famous == 1)
                                    <label class="btn btn-danger">
                                        <input type="radio" name="famous" value="0"  >
                                        Disabled
                                    </label>
                                    <label class="btn btn-success active">
                                        <input type="radio" name="famous" value="1"  checked="checked">
                                        Enabled
                                    </label>
                                        @else
                                        <label class="btn btn-danger  active">
                                            <input type="radio" name="famous" value="0"  checked="checked" >
                                            Disabled
                                        </label>
                                        <label class="btn btn-success">
                                            <input type="radio" name="famous" value="1" >
                                            Enabled
                                        </label>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="" class="col-sm-3 control-label">
                                Image
                                <span class="help-block">Select a file to update menu image, otherwise leave blank.</span>
                            </label>
                            <div class="col-sm-5">
                                <div class="thumbnail imagebox" id="selectImage">
                                    <div class="preview">
                                        <img src="https://demo.tastyigniter.com/assets/images/data/no_photo.png" class="thumb img-responsive" id="thumb">
                                    </div>
                                    <div class="caption">
                                        <span class="name text-center"></span>
                                        <input type="file" name="image" class="form-control">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                        @endif
                                        {{--<input type="hidden" name="menu_photo" value="" id="field" />
                                        <p>
                                            <a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
                                            <a class="btn btn-danger" onclick="$('#thumb').attr('src', 'https://demo.tastyigniter.com/assets/images/data/no_photo.png'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove </a>
                                        </p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                    @if($menu->status == 1)
                                    <label class="btn btn-danger">
                                        <input type="radio" name="status" value="0" >
                                        Disabled
                                    </label>
                                    <label class="btn btn-success active">
                                        <input type="radio" name="status" value="1"  checked="checked">
                                        Enabled
                                    </label>
                                        @else
                                        <label class="btn btn-danger active">
                                            <input type="radio" name="status" value="0" checked="checked">
                                            Disabled
                                        </label>
                                        <label class="btn btn-success ">
                                            <input type="radio" name="status" value="1"  >
                                            Enabled
                                        </label>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu-details" class="tab-pane row wrap-all">
                        {{--<div class="form-group">--}}
                            {{--<label for="input-mealtime" class="col-sm-3 control-label">--}}
                                {{--Mealtime--}}
                                {{--<span class="help-block">Set what mealtime of day your customers can order this menu. Mealtimes can be managed under Localisation -> Mealtimes</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<select name="mealtime" id="mealtime" class="form-control">--}}
                                    {{--<option value="0">Available all day</option>--}}
                                    {{--<option value="1"  >Breakfast (07:00 - 10:00)</option>--}}
                                    {{--<option value="2"  >Lunch (12:00 - 14:30)</option>--}}
                                    {{--<option value="3"  >Dinner (18:00 - 20:00)</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group{{ $errors->has('stock_qty') ? ' has-error' : '' }}">--}}
                            {{--<label for="input-stock" class="col-sm-3 control-label">--}}
                                {{--Stock Quantity--}}
                                {{--<span class="help-block">Set to 0 for unlimited stock quantity.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<input type="text" name="stock_qty" id="input-stock" class="form-control" value="{{ $menu->stock_qty }}" />--}}
                                {{--@if ($errors->has('stock_qty'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('stock_qty') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group{{ $errors->has('minimum_qty') ? ' has-error' : '' }}">--}}
                            {{--<label for="input-minimum" class="col-sm-3 control-label">--}}
                                {{--Minimum Quantity--}}
                                {{--<span class="help-block">The minimum quantity that can be ordered. Default is 1, unless set otherwise.</span>--}}
                            {{--</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<input type="text" name="minimum_qty" id="input-minimum" class="form-control" value="1" />--}}
                                {{--@if ($errors->has('minimum_qty'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('minimum_qty') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-subtract-stock" class="col-sm-3 control-label">Subtract Stock</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="btn-group btn-group-switch" data-toggle="buttons">--}}
                                    {{--<label class="btn btn-danger active">--}}
                                        {{--<input type="radio" name="subtract_stock" value="0"  checked="checked">--}}
                                        {{--NO--}}
                                    {{--</label>--}}
                                    {{--<label class="btn btn-success">--}}
                                        {{--<input type="radio" name="subtract_stock" value="1" >--}}
                                        {{--YES--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">--}}
                            {{--<label for="input-menu-priority" class="col-sm-3 control-label">Priority</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<input type="text" name="menu_priority" id="input-menu-priority" class="form-control" value="{{ $menu->priority }}" />--}}
                                {{--@if ($errors->has('priority'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('priority') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div id="menu-options" class="tab-pane row wrap-all">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-name" class="col-sm-3 control-label">Menu Item Option</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<input type="text" name="menu_option" id="input-status" class="form-control" value="" />--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-3">--}}
                                {{--<a class="btn btn-default" href="https://demo.tastyigniter.com/admin/menu_options/edit">Add New Menu Option</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<br />--}}
                        {{--<div id="menu-option" class="hide">--}}
                            {{--<ul id="sub-tabs" class="nav nav-tabs">--}}
                                {{--<li id="last-tab"></li>--}}
                            {{--</ul>--}}
                            {{--<div id="option-content" class="tab-content">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div id="specials" class="tab-pane row wrap-all">--}}
                        {{--<div class="form-group">--}}
                            {{--<label for="input-special-status" class="col-sm-3 control-label">Special</label>--}}
                            {{--<div class="col-sm-5">--}}
                                {{--<div class="btn-group btn-group-switch" data-toggle="buttons">--}}
                                    {{--<label id="special_toggle_hide" class="btn btn-danger active">--}}
                                        {{--<input type="radio" name="special_status" value="0" checked>--}}
                                        {{--Disabled--}}
                                    {{--</label>--}}
                                    {{--<label id="special_toggle_show" class="btn btn-success">--}}
                                        {{--<input type="radio" name="special_status" value="1">--}}
                                        {{--Enabled--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<input type="hidden" name="special_id" value="" />--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div id="special-toggle" style="display: none">--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="start-date" class="col-sm-3 control-label">Start Date</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" name="start_date" id="start-date" class="form-control" value="" />--}}
                                        {{--<span class="input-group-addon">--}}
                                            {{--<i class="fa fa-calendar"></i>--}}
                                        {{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="end-date" class="col-sm-3 control-label">End Date</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" name="end_date" id="end-date" class="form-control" value="" />--}}
                                        {{--<span class="input-group-addon">--}}
                                            {{--<i class="fa fa-calendar"></i>--}}
                                        {{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label for="input-special-price" class="col-sm-3 control-label">Special Price</label>--}}
                                {{--<div class="col-sm-5">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" name="special_price" id="input-special-price" class="form-control" value="" />--}}
                                        {{--<span class="input-group-addon">.00</span>--}}
                                        {{--<span class="input-group-addon">--}}
                                            {{--<i class="fa fa-money"></i>--}}
                                        {{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript"><!--
        $(document).ready(function() {
            $('#start-date, #end-date').datepicker({
                format: 'dd-mm-yyyy',
            });

            $('input[name="special_status"]').on('change', function() {
                if (this.value == '1') {
                    $('#special-toggle').slideDown(300);
                } else {
                    $('#special-toggle').slideUp(300);
                }
            });
        });
        //--></script>
    <script type="text/javascript"><!--
        $('input[name=\'menu_option\']').select2({
            placeholder: 'Start typing...',
            minimumInputLength: 2,
            ajax: {
                url: 'https://demo.tastyigniter.com/admin/menu_options/autocomplete',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) {
                    return {
                        term: term, //search term
                        page_limit: 10 // page size
                    };
                },
                results: function (data, page, query) {
                    return { results: data.results };
                }
            }
        });

        $('input[name=\'menu_option\']').on('select2-selecting', function(e) {
            if ($('#menu-option').hasClass('hide')) {
                $('#menu-option').removeClass('hide');
            }
            addOption(e.choice);
        });
        $('#sub-tabs a:first').tab('show');
        //--></script>
    <script type="text/javascript"><!--
        var option_row = 1;
        var option_value_row = 1;

        function addOption(data) {
            html  = '<div id="option' + option_row + '" class="tab-pane row wrap-all">';
            html += '	<input type="hidden" name="menu_options[' + option_row + '][menu_option_id]" id="" value="" />';
            html += '	<input type="hidden" name="menu_options[' + option_row + '][option_id]" id="" value="' + data.id + '" />';
            html += '	<input type="hidden" name="menu_options[' + option_row + '][option_name]" id="" value="' + data.text + '" />';
            html += '	<input type="hidden" name="menu_options[' + option_row + '][display_type]" id="" value="' + data.display + '" />';
            html += '	<input type="hidden" name="menu_options[' + option_row + '][priority]" id="" value="' + data.priority + '" />';
            html += '	<div class="form-group">';
            html += '		<label for="input-required" class="col-sm-3 control-label">Option Required';
            html += '			<span class="help-block">Enable/Disable if customers must choose option.</span>';
            html += '		</label>';
            html += '		<div class="col-sm-5">';
            html += '			<div class="btn-group btn-group-switch" data-toggle="buttons">';
            html += '				<label class="btn btn-danger active"><input type="radio" name="menu_options[' + option_row + '][required]" checked="checked"value="0">Disabled</label>';
            html += '				<label class="btn btn-success"><input type="radio" name="menu_options[' + option_row + '][required]" value="1">Enabled</label>';
            html += '			</div>';
            html += '		</div>';
            html += '	</div>';
            html += '	<div class="panel panel-default panel-table"><div class="table-responsive">';
            html += '	<table class="table table-striped table-border table-sortable">';
            html += '		<thead><tr>';
            html += '			<th class="action action-one"></th>';
            html += '			<th class="col-sm-4">Option Value</th>';
            html += '			<th>Option Price</th>';
            html += '			<th>Option Stock Quantity</th>';
            html += '			<th class="col-sm-3 text-center">Option Subtract Stock</th>';
            html += '			<th>ID</th>';
            html += '		</tr></thead>';
            html += '		<tbody></tbody>';
            html += '		<tfoot><tr id="tfoot">';
            html += '			<td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addOptionValue(' + option_row + ');"><i class="fa fa-plus"></i></a></td>';
            html += '			<td colspan="5"></td>';
            html += '		</tr></tfoot>';
            html += '	</table>';
            html += '	</div></div>';
            html += '  <select id="option-values' + option_row + '" style="display: none;">';
            for (i = 0; i < data.option_values.length; i++) {
                html += '  <option value="' + data.option_values[i]['option_value_id'] + '">' + data.option_values[i]['value'] + '</option>';
            }
            html += '  </select>';
            html += '</div>';

            $('#option-content').append(html);
            $('#last-tab').before('<li><a href="#option' + option_row + '" data-toggle="tab">' + data.text + '&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm(\'This cannot be undone! Are you sure you want to do this?\')) { $(\'#sub-tabs a[rel=#option1]\').trigger(\'click\'); $(\'#option' + option_row + '\').remove(); $(this).parent().parent().remove(); return false;} else {return false;}"></i></a></li>');
            $('#sub-tabs a[href="#option' + option_row + '"]').tab('show');

            addOptionValue(option_row);
            option_row++;
        }

        function addOptionValue(option_row) {
            html  = '<tr id="option-value' + option_value_row + '">';
            html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'This cannot be undone! Are you sure you want to do this?\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
            html += '	<td><select name="menu_options[' + option_row + '][option_values][' + option_value_row + '][option_value_id]" class="form-control">';
            html += $('#option-values' + option_row).html();
            html += '	</select></td>';
            html += '	<td><input type="text" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][price]" class="form-control" value="" /></td>';
            html += '	<td><input type="text" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][quantity]" class="form-control" value="" /></td>';
            html += '	<td class="text-center"><div class="btn-group btn-group-switch" data-toggle="buttons">';
            html += '		<label class="btn btn-default active"><input type="radio" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][subtract_stock]" checked="checked"value="0">NO</label>';
            html += '		<label class="btn btn-default"><input type="radio" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][subtract_stock]" value="1">YES</label>';
            html += '	</div></td>';
            html += '	<td class="text-center">-</td>';
            html += '	<td class="id"><input type="hidden" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][menu_option_value_id]" class="form-control" value="" />-</td>';
            html += '</tr>';

            $('#option' + option_row + ' .table-sortable tbody').append(html);
            $('#option-value' + option_value_row + ' select.form-control').select2();

            option_value_row++;
        }
        //--></script>
    </div>
    <div id="footer" class="">
        <div class="row navbar-footer">
            <div class="col-sm-12 text-version">
                <p class="col-xs-9 wrap-none">Thank you for using <a target="_blank" href="http://tastyigniter.com">TastyIgniter</a></p>
                <p class="col-xs-3 text-right wrap-none">Version 2.1.1</p>
            </div>
        </div>
    </div>
    </div>
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
    <script type="text/javascript">
        $('#restaurant ').select2();
    </script>
@endsection
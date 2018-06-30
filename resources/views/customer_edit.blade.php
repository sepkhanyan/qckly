@extends('header')
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
            <a href="{{ url('/categories') }}" class="btn btn-default">
                <i class="fa fa-angle-double-left"></i>
            </a>
        </div>
    </div>
<div class="row content">
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <li class="active">
                    <a href="#general" data-toggle="tab">
                        Customer
                    </a>
                </li>
                <li>
                    <a href="#addresses" data-toggle="tab">
                        Address
                    </a>
                </li>
            </ul>
        </div>

        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="{{ url('/customer/update/' . $user->user_id ) }}" >
            {{ csrf_field() }}
            <div class="tab-content">
                <div id="general" class="tab-pane row wrap-all active">
                    <div class="form-group">
                        <label for="input-first-name" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="first_name" id="input-first-name" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-last-name" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="last_name" id="input-last-name" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="text" name="email" id="input-email" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-telephone" class="col-sm-3 control-label">Telephone</label>
                        <div class="col-sm-5">
                            <input type="text" name="telephone" id="input-telephone" class="form-control" value="{{$user->mobile}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-password" class="col-sm-3 control-label">
                            Password
                            <span class="help-block">Leave blank to leave password unchanged</span>
                        </label>
                        <div class="col-sm-5">
                            <input type="password" name="password" id="input-password" class="form-control" value="" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-confirm-password" class="col-sm-3 control-label">Confirm Password</label>
                        <div class="col-sm-5">
                            <input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-security-question" class="col-sm-3 control-label">Security Question</label>
                        <div class="col-sm-5">
                            <select name="security_question_id" id="input-security-question" class="form-control">
                                <option value="">— Select —</option>
                                <option value="11" selected="selected">Whats your pets name?</option>
                                <option value="12">What high school did you attend?</option>
                                <option value="14">What is your mother's name?</option>
                                <option value="15">What is your place of birth?</option>
                                <option value="16">Whats your favourite teacher's name?</option>
                                <option value="13">What is your father's middle name?</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-security-answer" class="col-sm-3 control-label">Security Answer</label>
                        <div class="col-sm-5">
                            <input type="text" name="security_answer" id="input-security-answer" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-customer-group-id" class="col-sm-3 control-label">Customer Group</label>
                        <div class="col-sm-5">
                            <select name="customer_group_id" id="input-customer-group-id" class="form-control">
                                <option value="11"  selected="selected" >Default</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-newsletter" class="col-sm-3 control-label">Newsletter</label>
                        <div class="col-sm-5">
                            <div id="input-newsletter" class="btn-group btn-group-switch" data-toggle="buttons">
                                <label class="btn btn-danger active">
                                    <input type="radio" name="newsletter" value="0"  checked="checked">
                                    Un-subscribe
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="newsletter" value="1" >
                                    Subscribe
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-status" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <label class="btn btn-danger">
                                    <input type="radio" name="status" value="0" >
                                    Disabled
                                </label>
                                <label class="btn btn-success active">
                                    <input type="radio" name="status" value="1"  checked="checked">
                                    Enabled
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="addresses" class="tab-pane row wrap-all">
                    <ul id="sub-tabs" class="nav nav-tabs">
                        <li class="add_address">
                            <a onclick="addAddress();">
                                <i class="fa fa-book"></i>
                                &nbsp;<i class="fa fa-plus"></i>
                            </a>
                        </li>
                    </ul>

                    <div id="new-address" class="tab-content">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
    var table_row = 1;

    function addAddress() {
        html  = '<div id="address' + table_row + '" class="tab-pane row wrap-all">';
        html += '<input type="hidden" name="address[' + table_row + '][address_id]" id="" class="form-control" value="" />';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">Address 1</label>';
        html += '	<div class="col-sm-5">';
        html += '		<input type="text" name="address[' + table_row + '][address_1]" id="" class="form-control" value="" />';
        html += '	</div>';
        html += '</div>';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">Address 2</label>';
        html += '	<div class="col-sm-5">';
        html += '		<input type="text" name="address[' + table_row + '][address_2]" id="" class="form-control" value="" />';
        html += '	</div>';
        html += '</div>';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">City</label>';
        html += '	<div class="col-sm-5">';
        html += '		<input type="text" name="address[' + table_row + '][city]" id="" class="form-control" value="" />';
        html += '	</div>';
        html += '</div>';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">State</label>';
        html += '	<div class="col-sm-5">';
        html += '		<input type="text" name="address[' + table_row + '][state]" id="" class="form-control" value="" />';
        html += '	</div>';
        html += '</div>';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">Postcode</label>';
        html += '	<div class="col-sm-5">';
        html += '		<input type="text" name="address[' + table_row + '][postcode]" id="" class="form-control" value="" />';
        html += '	</div>';
        html += '</div>';
        html += '<div class="form-group">';
        html += '	<label for="" class="col-sm-3 control-label">Country</label>';
        html += '	<div class="col-sm-5">';
        html += '		<select name="address[' + table_row + '][country_id]" id="" class="form-control">';
        html += '			<option value="1">Afghanistan</option>';
        html += '			<option value="2">Albania</option>';
        html += '			<option value="3">Algeria</option>';
        html += '			<option value="4">American Samoa</option>';
        html += '			<option value="5">Andorra</option>';
        html += '			<option value="6">Angola</option>';
        html += '			<option value="7">Anguilla</option>';
        html += '			<option value="8">Antarctica</option>';
        html += '			<option value="9">Antigua and Barbuda</option>';
        html += '			<option value="10">Argentina</option>';
        html += '			<option value="11">Armenia</option>';
        html += '			<option value="12">Aruba</option>';
        html += '			<option value="13">Australia</option>';
        html += '			<option value="14">Austria</option>';
        html += '			<option value="15">Azerbaijan</option>';
        html += '			<option value="16">Bahamas</option>';
        html += '			<option value="17">Bahrain</option>';
        html += '			<option value="18">Bangladesh</option>';
        html += '			<option value="19">Barbados</option>';
        html += '			<option value="20">Belarus</option>';
        html += '			<option value="21">Belgium</option>';
        html += '			<option value="22">Belize</option>';
        html += '			<option value="23">Benin</option>';
        html += '			<option value="24">Bermuda</option>';
        html += '			<option value="25">Bhutan</option>';
        html += '			<option value="26">Bolivia</option>';
        html += '			<option value="27">Bosnia and Herzegowina</option>';
        html += '			<option value="28">Botswana</option>';
        html += '			<option value="29">Bouvet Island</option>';
        html += '			<option value="30">Brazil</option>';
        html += '			<option value="31">British Indian Ocean Territory</option>';
        html += '			<option value="32">Brunei Darussalam</option>';
        html += '			<option value="33">Bulgaria</option>';
        html += '			<option value="34">Burkina Faso</option>';
        html += '			<option value="35">Burundi</option>';
        html += '			<option value="36">Cambodia</option>';
        html += '			<option value="37">Cameroon</option>';
        html += '			<option value="38">Canada</option>';
        html += '			<option value="39">Cape Verde</option>';
        html += '			<option value="40">Cayman Islands</option>';
        html += '			<option value="41">Central African Republic</option>';
        html += '			<option value="42">Chad</option>';
        html += '			<option value="43">Chile</option>';
        html += '			<option value="44">China</option>';
        html += '			<option value="45">Christmas Island</option>';
        html += '			<option value="46">Cocos (Keeling) Islands</option>';
        html += '			<option value="47">Colombia</option>';
        html += '			<option value="48">Comoros</option>';
        html += '			<option value="49">Congo</option>';
        html += '			<option value="50">Cook Islands</option>';
        html += '			<option value="51">Costa Rica</option>';
        html += '			<option value="52">Cote D\'Ivoire</option>';
        html += '			<option value="53">Croatia</option>';
        html += '			<option value="54">Cuba</option>';
        html += '			<option value="55">Cyprus</option>';
        html += '			<option value="56">Czech Republic</option>';
        html += '			<option value="237">Democratic Republic of Congo</option>';
        html += '			<option value="57">Denmark</option>';
        html += '			<option value="58">Djibouti</option>';
        html += '			<option value="59">Dominica</option>';
        html += '			<option value="60">Dominican Republic</option>';
        html += '			<option value="61">East Timor</option>';
        html += '			<option value="62">Ecuador</option>';
        html += '			<option value="63">Egypt</option>';
        html += '			<option value="64">El Salvador</option>';
        html += '			<option value="65">Equatorial Guinea</option>';
        html += '			<option value="66">Eritrea</option>';
        html += '			<option value="67">Estonia</option>';
        html += '			<option value="68">Ethiopia</option>';
        html += '			<option value="69">Falkland Islands (Malvinas)</option>';
        html += '			<option value="70">Faroe Islands</option>';
        html += '			<option value="71">Fiji</option>';
        html += '			<option value="72">Finland</option>';
        html += '			<option value="73">France</option>';
        html += '			<option value="74">France, Metropolitan</option>';
        html += '			<option value="75">French Guiana</option>';
        html += '			<option value="76">French Polynesia</option>';
        html += '			<option value="77">French Southern Territories</option>';
        html += '			<option value="126">FYROM</option>';
        html += '			<option value="78">Gabon</option>';
        html += '			<option value="79">Gambia</option>';
        html += '			<option value="80">Georgia</option>';
        html += '			<option value="81">Germany</option>';
        html += '			<option value="82">Ghana</option>';
        html += '			<option value="83">Gibraltar</option>';
        html += '			<option value="84">Greece</option>';
        html += '			<option value="85">Greenland</option>';
        html += '			<option value="86">Grenada</option>';
        html += '			<option value="87">Guadeloupe</option>';
        html += '			<option value="88">Guam</option>';
        html += '			<option value="89">Guatemala</option>';
        html += '			<option value="90">Guinea</option>';
        html += '			<option value="91">Guinea-bissau</option>';
        html += '			<option value="92">Guyana</option>';
        html += '			<option value="93">Haiti</option>';
        html += '			<option value="94">Heard and Mc Donald Islands</option>';
        html += '			<option value="95">Honduras</option>';
        html += '			<option value="96">Hong Kong</option>';
        html += '			<option value="97">Hungary</option>';
        html += '			<option value="98">Iceland</option>';
        html += '			<option value="99">India</option>';
        html += '			<option value="100">Indonesia</option>';
        html += '			<option value="101">Iran (Islamic Republic of)</option>';
        html += '			<option value="102">Iraq</option>';
        html += '			<option value="103">Ireland</option>';
        html += '			<option value="104">Israel</option>';
        html += '			<option value="105">Italy</option>';
        html += '			<option value="106">Jamaica</option>';
        html += '			<option value="107">Japan</option>';
        html += '			<option value="108">Jordan</option>';
        html += '			<option value="109">Kazakhstan</option>';
        html += '			<option value="110">Kenya</option>';
        html += '			<option value="111">Kiribati</option>';
        html += '			<option value="113">Korea, Republic of</option>';
        html += '			<option value="114">Kuwait</option>';
        html += '			<option value="115">Kyrgyzstan</option>';
        html += '			<option value="116">Lao People\'s Democratic Republic</option>';
        html += '			<option value="117">Latvia</option>';
        html += '			<option value="118">Lebanon</option>';
        html += '			<option value="119">Lesotho</option>';
        html += '			<option value="120">Liberia</option>';
        html += '			<option value="121">Libyan Arab Jamahiriya</option>';
        html += '			<option value="122">Liechtenstein</option>';
        html += '			<option value="123">Lithuania</option>';
        html += '			<option value="124">Luxembourg</option>';
        html += '			<option value="125">Macau</option>';
        html += '			<option value="127">Madagascar</option>';
        html += '			<option value="128">Malawi</option>';
        html += '			<option value="129">Malaysia</option>';
        html += '			<option value="130">Maldives</option>';
        html += '			<option value="131">Mali</option>';
        html += '			<option value="132">Malta</option>';
        html += '			<option value="133">Marshall Islands</option>';
        html += '			<option value="134">Martinique</option>';
        html += '			<option value="135">Mauritania</option>';
        html += '			<option value="136">Mauritius</option>';
        html += '			<option value="137">Mayotte</option>';
        html += '			<option value="138">Mexico</option>';
        html += '			<option value="139">Micronesia, Federated States of</option>';
        html += '			<option value="140">Moldova, Republic of</option>';
        html += '			<option value="141">Monaco</option>';
        html += '			<option value="142">Mongolia</option>';
        html += '			<option value="143">Montserrat</option>';
        html += '			<option value="144">Morocco</option>';
        html += '			<option value="145">Mozambique</option>';
        html += '			<option value="146">Myanmar</option>';
        html += '			<option value="147">Namibia</option>';
        html += '			<option value="148">Nauru</option>';
        html += '			<option value="149">Nepal</option>';
        html += '			<option value="150">Netherlands</option>';
        html += '			<option value="151">Netherlands Antilles</option>';
        html += '			<option value="152">New Caledonia</option>';
        html += '			<option value="153">New Zealand</option>';
        html += '			<option value="154">Nicaragua</option>';
        html += '			<option value="155">Niger</option>';
        html += '			<option value="156">Nigeria</option>';
        html += '			<option value="157">Niue</option>';
        html += '			<option value="158">Norfolk Island</option>';
        html += '			<option value="112">North Korea</option>';
        html += '			<option value="159">Northern Mariana Islands</option>';
        html += '			<option value="160">Norway</option>';
        html += '			<option value="161">Oman</option>';
        html += '			<option value="162">Pakistan</option>';
        html += '			<option value="163">Palau</option>';
        html += '			<option value="164">Panama</option>';
        html += '			<option value="165">Papua New Guinea</option>';
        html += '			<option value="166">Paraguay</option>';
        html += '			<option value="167">Peru</option>';
        html += '			<option value="168">Philippines</option>';
        html += '			<option value="169">Pitcairn</option>';
        html += '			<option value="170">Poland</option>';
        html += '			<option value="171">Portugal</option>';
        html += '			<option value="172">Puerto Rico</option>';
        html += '			<option value="173">Qatar</option>';
        html += '			<option value="174">Reunion</option>';
        html += '			<option value="175">Romania</option>';
        html += '			<option value="176">Russian Federation</option>';
        html += '			<option value="177">Rwanda</option>';
        html += '			<option value="178">Saint Kitts and Nevis</option>';
        html += '			<option value="179">Saint Lucia</option>';
        html += '			<option value="180">Saint Vincent and the Grenadines</option>';
        html += '			<option value="181">Samoa</option>';
        html += '			<option value="182">San Marino</option>';
        html += '			<option value="183">Sao Tome and Principe</option>';
        html += '			<option value="184">Saudi Arabia</option>';
        html += '			<option value="185">Senegal</option>';
        html += '			<option value="186">Seychelles</option>';
        html += '			<option value="187">Sierra Leone</option>';
        html += '			<option value="188">Singapore</option>';
        html += '			<option value="189">Slovak Republic</option>';
        html += '			<option value="190">Slovenia</option>';
        html += '			<option value="191">Solomon Islands</option>';
        html += '			<option value="192">Somalia</option>';
        html += '			<option value="193">South Africa</option>';
        html += '			<option value="194">South Georgia &amp; South Sandwich Islands</option>';
        html += '			<option value="195">Spain</option>';
        html += '			<option value="196">Sri Lanka</option>';
        html += '			<option value="197">St. Helena</option>';
        html += '			<option value="198">St. Pierre and Miquelon</option>';
        html += '			<option value="199">Sudan</option>';
        html += '			<option value="200">Suriname</option>';
        html += '			<option value="201">Svalbard and Jan Mayen Islands</option>';
        html += '			<option value="202">Swaziland</option>';
        html += '			<option value="203">Sweden</option>';
        html += '			<option value="204">Switzerland</option>';
        html += '			<option value="205">Syrian Arab Republic</option>';
        html += '			<option value="206">Taiwan</option>';
        html += '			<option value="207">Tajikistan</option>';
        html += '			<option value="208">Tanzania, United Republic of</option>';
        html += '			<option value="209">Thailand</option>';
        html += '			<option value="210">Togo</option>';
        html += '			<option value="211">Tokelau</option>';
        html += '			<option value="212">Tonga</option>';
        html += '			<option value="213">Trinidad and Tobago</option>';
        html += '			<option value="214">Tunisia</option>';
        html += '			<option value="215">Turkey</option>';
        html += '			<option value="216">Turkmenistan</option>';
        html += '			<option value="217">Turks and Caicos Islands</option>';
        html += '			<option value="218">Tuvalu</option>';
        html += '			<option value="219">Uganda</option>';
        html += '			<option value="220">Ukraine</option>';
        html += '			<option value="221">United Arab Emirates</option>';
        html += '			<option value="222" selected="selected">United Kingdom</option>';
        html += '			<option value="223">United States</option>';
        html += '			<option value="224">United States Minor Outlying Islands</option>';
        html += '			<option value="225">Uruguay</option>';
        html += '			<option value="226">Uzbekistan</option>';
        html += '			<option value="227">Vanuatu</option>';
        html += '			<option value="228">Vatican City State (Holy See)</option>';
        html += '			<option value="229">Venezuela</option>';
        html += '			<option value="230">Viet Nam</option>';
        html += '			<option value="231">Virgin Islands (British)</option>';
        html += '			<option value="232">Virgin Islands (U.S.)</option>';
        html += '			<option value="233">Wallis and Futuna Islands</option>';
        html += '			<option value="234">Western Sahara</option>';
        html += '			<option value="235">Yemen</option>';
        html += '			<option value="236">Yugoslavia</option>';
        html += '			<option value="238">Zambia</option>';
        html += '			<option value="239">Zimbabwe</option>';
        html += '		</select>';
        html += '	</div>';
        html += '</div>';
        html += '</div>';

        $('#new-address').append(html);

        $('.add_address').before('<li><a href="#address' + table_row + '" data-toggle="tab">Address ' + table_row + '&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm(\'This cannot be undone! Are you sure you want to do this?\')){ $(\'#sub-tabs a[rel=#address1]\').trigger(\'click\'); $(\'#address' + table_row + '\').remove(); $(this).parent().parent().remove(); return false } else { return false;}"></i></a></li>');

        $('#sub-tabs a[href="#address' + table_row + '"]').tab('show');
        $('select.form-control').select2();

        table_row++;
    }

    $('#sub-tabs a:first').tab('show');
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
@endsection
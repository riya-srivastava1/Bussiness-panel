@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/bs-select/bs-select.css') }}" />
    <style>
        .form-row .form-group {
            margin-bottom: 25px;
        }
    </style>
@endsection

@section('content')
    @php $data = Auth::guard('business')->user();
    @endphp
    <!--breadcrumbs-->


    <!-- BEGIN .main-content -->
    <div class="main-content">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card bg-white">
                    <div class="card-header">Manage Branches <span class="float-right">
                            <a href="{{ route('vendor.branch') }}" class="btn btn-success">Back</a>
                        </span></div>

                    <div class="card-body">

                        <form method="post" action="{{ route('vendor.add.branch.store') }}" method="post"
                            id="form-signin" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $data->vendor_id ?? '' }}">
                            <h4 class="intor-tital">Business Information</h4>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="business_name" class="col-form-label">Name of Your Brand <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="business_name" name="business_name"
                                        value="{{ $data->vendor_profile->business_name ?? '' }}" class="form-control"
                                        placeholder="Name of Your Brand" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4" class="col-form-label">Owner/Manager's Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="owner_name" value="{{ $data->vendor_profile->owner_name }}"
                                        name="owner_name" class="form-control" placeholder="Owner/Manager's Name" required>
                                    @error('owner_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span><br>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="owner_contact" class="col-form-label">Primary Contact Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="owner_contact" minlength="10" maxlength="10"
                                        name="owner_contact" class="form-control number"
                                        value="{{ $data->owner_contact }}" placeholder="Owner/Manager's Mobile Number"
                                        required>
                                    @error('owner_contact')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span><br>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="landline_number" class="col-form-label">Alternate Contact Number</label>
                                    <input type="text" id="landline_number" minlength="10" maxlength="10"
                                        name="landline_number" value="{{ old('landline_number') }}"
                                        class="form-control number" placeholder="Optional Mobile Number">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email" class="col-form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="email" minlength="6" name="email"
                                        value="{{ old('email') }}" class="form-control" autocomplete="off"
                                        placeholder="Email " required>

                                    <small class="float-right" id="email_error"></small>

                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span><br>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4" class="col-form-label">Gender Served<span
                                            class="text-danger">*</span></label>
                                    <select name="vendor_type" id="" style="padding:.4rem;"
                                        class="form-control h-80  rounded-0 outline-none"
                                        value="{{ old('vendor_type') }}" required>
                                        <option value="">Gender Served <span class="text-danger">*</span></option>
                                        <option value="Unisex" {{ old('vendor_type') == 'Unisex' ? 'selected' : '' }}>
                                            Unisex</option>
                                        <option value="Male" {{ old('vendor_type') == 'Male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="Female" {{ old('vendor_type') == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    @error('vendor_type')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span><br>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="password" class="col-form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" id="password" minlength="6" name="password"
                                        class="form-control " placeholder="Minimun 6 characters" required>
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span><br>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="confirm_password" class="col-form-label">Confirm Password <span
                                            class="text-danger">*</span> </label>
                                    <input type="password" id="confirm_password" minlength="6"
                                        name="password_confirmation" class="form-control " placeholder="Confirm Password"
                                        required>
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="exampleFormControlSelect2" class="col-form-label">Select Categories
                                    </label>
                                    <select class="form-control selectpicker" multiple name="category_type[]"
                                        id="exampleFormControlSelect2">
                                        @if ($category)
                                            @foreach ($category as $item)
                                                @if ($item->category_name != 'Packages')
                                                    <option value="{{ $item->category_name }}"
                                                        {{ Str::contains($data->vendor_profile->category_type ?? '', $item->category_name) ? 'selected' : '' }}>
                                                        {{ $item->category_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="permission" class="col-form-label">Editing permisssion<span
                                            class="text-danger">*</span> </label>
                                    <select class="form-control" id="permission" name="edit_permission" required>
                                        <option value="">Select Editing permisssion</option>
                                        <option value="Read">Read</option>
                                        <option value="Write">Write</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="partner_size" class="col-form-label">Select Partner Size<span
                                            class="text-danger">*</span> </label>
                                    <select class="form-control" id="partner_size" name="partner_size">
                                        <option value="indivisual_single">Indivisual Single</option>
                                        <option value="indivisual_chain">Indivisual Chain</option>
                                        <option selected value="coco">COCO (Company owned Company operated)</option>
                                        <option value="franchise">Franchise</option>
                                        <option value="joint_venture">Joint Venture</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="notify_to" class="col-form-label">Notify to<span
                                            class="text-danger">*</span> </label>
                                    <select class="form-control" id="notify_to" name="notify_to">
                                        <option value="same">Same branch</option>
                                        <option value="parent">Parent branch</option>
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <div class="line">
                                        <hr>
                                    </div>
                                    <h4 class="intor-tital">Address</h4>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="locality" class="col-form-label">Locality <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="locality" name="locality"
                                        value="{{ old('locality') }}" class="form-control" placeholder="Locality"
                                        required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4" class="col-form-label">City <span
                                            class="text-danger">*</span></label>
                                    <select name="city" id="profile-city" class="form-control" required>
                                        <option value="">Select City </option>
                                        <optgroup label="Popular Cities">
                                            @if ($cities && $cities->count())
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->city_name }}"
                                                        {{ old('city') == $city->city_name ? 'selected' : '' }}>
                                                        {{ $city->city_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="zipcode" class="col-form-label">Zipcode <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="zipcode" value="{{ old('zipcode') }}" name="zipcode"
                                        class="form-control number" maxlength="6" minlength="6" placeholder="Zipcode"
                                        required>
                                </div>


                                <div class="form-group col-md-12">
                                    <input type="hidden" name="lat" value="null" id="lat_txt" />
                                    <input type="hidden" name="lng" value="null" id="lng_txt">
                                    <input type="hidden" name="map_place_id" value="null" id="map_place_id">

                                    <label for="inputPassword4" class="col-form-label">Full Address </label>
                                    <input style="height: 80px" name="full_address" id="searchbox" class="form-control"
                                        placeholder="Full Address"
                                        value="{{ $data->vendor_profile->full_address ?? '' }}" />
                                    <button type="button" class="btn btn-outline-info py-0 rounded-0 locate-me-btn">
                                        Auto Locate
                                    </button>
                                </div>
                                <div class="form-group col-12">
                                    <div class="line">
                                        <hr>
                                    </div>
                                    <h4 class="intor-tital">Working Hours</h4>
                                </div>

                                <div class="col-md-12 py-4">
                                    <label> Working days :</label><br>

                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Monday"
                                            name="days[]" value="Mon">
                                        <label class="custom-control-label" for="Monday">Monday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Tuesday"
                                            name="days[]" value="Tue">
                                        <label class="custom-control-label" for="Tuesday">Tuesday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Wednesday"
                                            name="days[]" value="Wed">
                                        <label class="custom-control-label" for="Wednesday">Wednesday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Thursday"
                                            name="days[]" value="Thu">
                                        <label class="custom-control-label" for="Thursday">Thursday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Friday"
                                            name="days[]" value="Fri">
                                        <label class="custom-control-label" for="Friday">Friday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Saturday"
                                            name="days[]" value="Sat">
                                        <label class="custom-control-label" for="Saturday">Saturday</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="Sunday"
                                            name="days[]" value="Sun">
                                        <label class="custom-control-label" for="Sunday">Sunday</label>
                                    </div>
                                </div>


                                <div class="form-group col-md-3">
                                    <label class="col-form-label">Opening Time <span class="text-danger">*</span></label>
                                    <select name="opening_time" id="opening_time" data-placeholder="FROM"
                                        class="form-control schedule-start h-20" required="">
                                        <option>Select Time</option>
                                        <option value="01:00">01:00 AM</option>
                                        <option value="02:00">02:00 AM</option>
                                        <option value="03:00">03:00 AM</option>
                                        <option value="04:00">04:00 AM</option>
                                        <option value="05:00">05:00 AM</option>
                                        <option value="06:00">06:00 AM</option>
                                        <option value="07:00">07:00 AM</option>
                                        <option value="08:00">08:00 AM</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="13:00">01:00 PM</option>
                                        <option value="14:00">02:00 PM</option>
                                        <option value="15:00">03:00 PM</option>
                                        <option value="16:00">04:00 PM</option>
                                        <option value="17:00">05:00 PM</option>
                                        <option value="18:00">06:00 PM</option>
                                        <option value="19:00">07:00 PM</option>
                                        <option value="20:00">08:00 PM</option>
                                        <option value="21:00">09:00 PM</option>
                                        <option value="22:00">10:00 PM</option>
                                        <option value="23:00">11:00 PM</option>
                                        <option value="24:00">12:00 AM</option>

                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputPassword4" class="col-form-label">Closing Time </label>
                                    <select name="closing_time" id="closing_time" data-placeholder="TO"
                                        class="form-control schedule-end h-20" required="">
                                        <option>Select Time</option>
                                        <option value="01:00">01:00 AM</option>
                                        <option value="02:00">02:00 AM</option>
                                        <option value="03:00">03:00 AM</option>
                                        <option value="04:00">04:00 AM</option>
                                        <option value="05:00">05:00 AM</option>
                                        <option value="06:00">06:00 AM</option>
                                        <option value="07:00">07:00 AM</option>
                                        <option value="08:00">08:00 AM</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="13:00">01:00 PM</option>
                                        <option value="14:00">02:00 PM</option>
                                        <option value="15:00">03:00 PM</option>
                                        <option value="16:00">04:00 PM</option>
                                        <option value="17:00">05:00 PM</option>
                                        <option value="18:00">06:00 PM</option>
                                        <option value="19:00">07:00 PM</option>
                                        <option value="20:00">08:00 PM</option>
                                        <option value="21:00">09:00 PM</option>
                                        <option value="22:00">10:00 PM</option>
                                        <option value="23:00">11:00 PM</option>
                                        <option value="24:00">12:00 AM</option>

                                    </select>
                                </div>

                                <div class="form-group col-md-3 offset-md-4">
                                    <div class="form-actions text-center">
                                        <button type="submit" class="btn btn-success"
                                            style="margin-top: 34px;">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        <!-- Row end -->



    </div>
    <!-- END: .main-content -->

    @endsection @section('scripts')
    <script src="{{ asset('zoy-asset/vendor/bs-select/bs-select.min.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko&libraries=places&callback=initMap"
        async defer></script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        $('#profile-city').val('{{ $data->vendor_profile->city }}');
        $('#opening_time').val('{{ $data->vendor_profile->opening_time }}');
        $('#closing_time').val('{{ $data->vendor_profile->closing_time }}');
        //setup before functions
        var typingTimer; //timer identifier
        var doneTypingInterval = 900; //time in ms, 5 second for example
        var $input = $('#email');

        //on keyup, start the countdown
        $input.on('blur', function() {
            $('#email_error').html('');
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });
        $input.on('keyup', function() {
            $('#email_error').html('');
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });


        //on keydown, clear the countdown
        // $input.on('keydown', function() {
        //     clearTimeout(typingTimer);
        // });

        //user is "finished typing," do something
        function doneTyping() {
            var email = $('#email').val();
            if (email.length < 6) {
                return false;
            }
            $('#email_error').removeClass('text-danger');
            $('#email_error').removeClass('text-success');
            $('#email_error').html('Validating...');
            $.ajax({
                url: "{{ route('validate.email') }}",
                method: 'GET',
                data: {
                    email: email
                },
                success: function(data) {
                    if (data.status) {
                        $('#email_error').removeClass('text-danger');
                        $('#email_error').addClass('text-success');
                        $('#email_error').html('Available');
                    } else {
                        $('#email').val('');
                        $('#email_error').removeClass('text-success');
                        $('#email_error').addClass('text-danger');
                        $('#email_error').html(data.message);
                    }
                },
                error: function(error) {
                    // $('#email_error').addClass('text-danger');
                    // $('#email_error').html("Something went ");
                    console.error(error);
                }
            });
        }
    </script>
@endsection

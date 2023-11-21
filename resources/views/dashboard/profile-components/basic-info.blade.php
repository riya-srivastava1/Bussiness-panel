<form action="{{ route('vendor.profile.update', ['id' => $vendor->id]) }}" method="post" id="profile_form"
    name="profile_form">
    @csrf
    @method('PATCH')

    <div class="form-row pt-3">
        <div class="form-group col-md-3">
            <label for="inputEmail4" class="col-form-label">Name of Your Brand <span class="text-danger">*</span></label>
            <input type="text" id="business_name" name="business_name"
                value="{{ $data->vendor_profile->business_name ?? '' }}" class="form-control"
                placeholder="Name of Your Brand" required>
        </div>
        <div class="form-group col-md-3">
            <label for="inputPassword4" class="col-form-label">Owner's Name <span class="text-danger">*</span></label>
            <input type="type" id="owner_name" name="owner_name"
                value="{{ $data->vendor_profile->owner_name ?? '' }}" class="form-control" placeholder="Owner name"
                required>
        </div>
        <div class="form-group col-md-3">
            <label for="owner_contact" class="col-form-label">Primary contact number </label>
            <input type="text" id="owner_contact" value="{{ $vendor->owner_contact ?? '' }}" readonly
                minlength="10" maxlength="10" name="owner_contact" class="form-control schedule-start h-60 rounded-0">
        </div>
        <div class="form-group col-md-3">
            <label for="vendor_type" class="col-form-label">Gender served </label>
            <select name="vendor_type" id="" style="padding:.4rem;"
                class="form-control h-80  rounded-0 outline-none" value="{{ $vendor->vendor_type }}">
                <option value="">Gender Served <span class="text-danger">*</span></option>
                <option value="Unisex" {{ $vendor->vendor_type == 'Unisex' ? 'selected' : '' }}>
                    Unisex</option>
                <option value="Male" {{ $vendor->vendor_type == 'Male' ? 'selected' : '' }}>
                    Male</option>
                <option value="Female" {{ $vendor->vendor_type == 'Female' ? 'selected' : '' }}>
                    Female</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md pt-3">
            <label for="landline_number" class="col-form-label">Alternate Phone : </label>
            <input type="text" name="landline_number" id="landline_number"
                class="form-control schedule-start h-60 rounded-0" value="{{ $vendor->landline_number }}" />
        </div>

        <div class="col-md  pt-3">
            <label for="services" class="col-form-label">Your Services : <span class="text-danger">*</span> </label>
            <select multiple required class="form-control selectpicker" name="service_type[]" id="serviceType">
                @if ($serviceType)
                    @foreach ($serviceType as $item)
                        <option value="{{ $item }}"
                            {{ $currentServiceType ? (in_array($item, $currentServiceType) ? 'selected=true' : '') : '' }}>
                            {{ $item }}</option>
                    @endforeach
                @endif
            </select>
            <small class="text-danger" id="select_services_err"></small>
        </div>
        <div class="pt-3 col-md">
            <label for="category_type" class="col-form-label">Select Categories </label>
            <select class="form-control selectpicker" required multiple name="category_type[]"
                id="exampleFormControlSelect2">
                @if ($category)
                    @foreach ($category as $item)
                        @if ($item->category_name !== 'Packages')
                            <option value="{{ $item->category_name }}"
                                {{ Str::contains($vendor->category_type ?? '', $item->category_name) ? 'selected' : '' }}>
                                {{ $item->category_name }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>


    </div>

    <div class="form-row py-4">
        <div class="col-md">
            <label> Working days :</label><br>
            @php
                $working_day = (array) $vendor->working_day;
            @endphp
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Mon', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Monday" name="days[]" value="Mon">
                <label class="custom-control-label" for="Monday">Monday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Tue', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Tuesday" name="days[]" value="Tue">
                <label class="custom-control-label" for="Tuesday">Tuesday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Wed', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Wednesday" name="days[]" value="Wed">
                <label class="custom-control-label" for="Wednesday">Wednesday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Thu', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Thursday" name="days[]" value="Thu">
                <label class="custom-control-label" for="Thursday">Thursday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Fri', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Friday" name="days[]" value="Fri">
                <label class="custom-control-label" for="Friday">Friday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Sat', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Saturday" name="days[]" value="Sat">
                <label class="custom-control-label" for="Saturday">Saturday</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" {{ in_array('Sun', $working_day) ? 'checked' : '' }}
                    class="custom-control-input" id="Sunday" name="days[]" value="Sun">
                <label class="custom-control-label" for="Sunday">Sunday</label>
            </div>
        </div>




    </div>
    <div class="form-row">



        <div class="col-md  pt-3">
            <label for="opening_time"> Opening time : <span class="text-danger">*</span></label>
            <select name="opening_time" id="opening_time" data-placeholder="FROM"
                class="form-control schedule-start h-60 rounded-0" required>
                <option value="">Select Time</option>
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
            <small class="text-danger" id="opening_time"></small>
        </div>

        <div class="col-md  pt-3">
            <label for="closing_time">Closing time : <span class="text-danger">*</span></label>
            <select name="closing_time" id="closing_time" data-placeholder="TO"
                class="form-control schedule-end h-60 rounded-0" required>
                <option value="">Select time</option>
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
            <small class="text-danger" id="closing_time"></small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 pt-3">
            <label for="facebook">Facebook Profile Link : </label>
            <input type="url" name="facebook_profile" id="facebook"
                class="h-59 outline-none rounded-0 form-control form-control-sm"
                value="{{ $vendor->facebook_profile }}" />
            <small class="text-danger" id="facebook_err"></small>
        </div>
        <div class="col-md-4 pt-3">
            <label for="instagram">Instagram Profile Link : </label>
            <input type="url" name="instagram_profile" id="instagram"
                class="h-59 outline-none rounded-0 form-control form-control-sm"
                value="{{ $vendor->instagram_profile }}" />
            <small class="text-danger" id="instagram_err"></small>
        </div>
        <div class="col-md-4 pt-3">
            <label for="website">Your Website Link: </label>
            <input type="url" name="website_url" id="website"
                class="h-59 outline-none rounded-0 form-control form-control-sm"
                value="{{ $vendor->website_url }}" />
            <small class="text-danger" id="web_error"></small>
        </div>
    </div>

    <div class="form-row pt-3">
        <div class="form-group col-md-12">
            <label for="inputEmail4" class="col-form-label">About your Brand <span
                    class="text-danger">*</span></label>
            <textarea name="about" cols="30" rows="3" class="form-control" placeholder="About your brand">{{ $data->vendor_profile->about ?? '' }}</textarea>
        </div>
    </div>

    <div class="form-group py-4 text-right">
        <input type="submit" class="btn btn-info rounded-0 btn-submit" value="Save" />
    </div>
</form>

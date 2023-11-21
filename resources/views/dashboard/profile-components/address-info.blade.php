<form action="{{ route('vendor.profile.update.address', $vendor->id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-row">
        <div class="form-group col-12">
            <h4 class="intor-tital">Address</h4>
        </div>

        <div class="form-group col-md-4">
            <input type="hidden" name="lat" value="{{ $vendor->lat ?? '' }}" id="lat_txt" />
            <input type="hidden" name="lng" value="{{ $vendor->lng ?? '' }}" id="lng_txt">
            <input type="hidden" name="map_place_id" value="{{ $vendor->map_place_id ?? '' }}" id="map_place_id">

            <label for="inputEmail4" class="col-form-label">Locality <span class="text-danger">*</span></label>
            <input type="text" id="locality" name="locality" value="{{ $vendor->locality ?? '' }}"
                class="form-control" placeholder="Locality" required>
        </div>

        <div class="form-group col-md-4">
            <label for="inputPassword4" class="col-form-label">City </label>
            <select name="city" id="profile-city" class="form-control" required>
                <option value="">Select City <span class="text-danger">*</span></option>
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

        <input type="hidden" id="state" name="state">

        <div class="form-group col-md-4">
            <label for="zipcode" class="col-form-label">Zipcode <span class="text-danger">*</span></label>
            <input type="text" id="zipcode" value="{{ $vendor->zipcode ?? '' }}" name="zipcode"
                class="form-control number" maxlength="6" minlength="6" placeholder="zipcode" required>
        </div>

        <div class="form-group col-md-6">
            <label for="inputPassword4" class="col-form-label">Full Address </label>
            <textarea style="height: 80px" name="full_address" id="searchbox" class="form-control"
                placeholder="Full Address">{{ $vendor->full_address ?? '' }}</textarea>
            <button type="button" class="btn btn-outline-info py-0 rounded-0 locate-me-btn">
                Auto Locate
            </button>
        </div>

        <div class="form-group col-md-6 p-5">
            <a href="https://www.google.com/maps/search/?api=1&query={{ $vendor->lat }}%2C{{ $vendor->lng }}&query_place_id={{ $vendor->map_place_id }}"
                target="blank" class="btn btn-success" >
                Show on Map
            </a>
        </div>

    </div>
    <div class="form-group py-4 text-right">
        <button type="submit" class="btn btn-info rounded-0 btn-submit" value="save">Save</button>
    </div>
</form>

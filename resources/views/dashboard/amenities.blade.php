@extends('layouts.app')
{{-- @section('dashboard-myAccount-tab', 'selected')
 @php $data = Auth::guard('business')->user();
@endphp --}}

@section('content')
    <!--breadcrumbs-->
    <!-- BEGIN .main-content -->
    <div class="main-content">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card bg-white">
                    <div class="card-header">Amenities</div>
                    <div class="card-body">
                        <form method="post"
                            action="{{ route('vendor.profile.update.amenity', ['id' => $data->vendor_id]) }}">
                            @csrf
                            @method('patch')
                            <div class="form-row">
                                @if ($amenity)
                                    @foreach ($amenity as $result)
                                        <div class="form-group px-2">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" name="aminity[]"
                                                    value="{{ $result }}" id="checkbox{{ $loop->iteration }}"
                                                    {{ $vendorAmenity ? (in_array($result->name, $vendorAmenity) ? 'checked' : '') : '' }}>
                                                <label class="custom-control-label"
                                                    for="checkbox{{ $loop->iteration }}">{{ $result->name }}
                                                    {{-- <img src="{{$result->icon}}" alt="" height="45" width="45" class="text-right"> --}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="form-group col text-right py-5">
                                    <button type="submit" class="btn btn-info">Save</button>
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
@endsection

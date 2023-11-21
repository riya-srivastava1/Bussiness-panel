@extends('layouts.app')
{{-- @section('dashboard-user-booking-tab', 'selected') --}}
{{-- @php $data = Auth::guard('business')->user();
@endphp --}}

@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/bs-select/bs-select.css') }}" />

    <style>
        .booking-list-cancelled {
            width: 100%;
            display: inline;
            box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0.2), 0 0px 6px 0 rgba(0, 0, 0, 0.19);
            padding: 10px;
            border-left: 4px solid red;
            margin-bottom: 5px;
        }

        .booking-list-pending {
            width: 100%;
            display: inline;
            box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0.2), 0 0px 6px 0 rgba(0, 0, 0, 0.19);
            padding: 10px;
            border-left: 4px solid orange;
            margin-bottom: 5px;
        }

    </style>
@endsection

@section('content')
    <!-- BEGIN .main-content -->
    <div class="main-content">
        <div class="row gutters text-center">
            <div class="col-md-4"><a href="?type=complete">
                    <h5 class=" badge-pill badge-light py-2">Completed Booking &mdash;
                        {{ $completeBooking }} </h5>
                </a></div>
            <div class="col-md-4"><a href="?type=pending">
                    <h5 class="badge-pill badge-success py-2">Pending Booking &mdash;
                        {{ $pendingBooking ? $pendingBooking->total() : 0 }}</h5>
                </a></div>
            <div class="col-md-4"><a href="?type=cancelled">
                    <h5 class="badge-pill badge-light py-2">Cancelled Booking &mdash; {{ $canclledBooking }}</h5>
                </a></div>
        </div>
        <!-- Row start -->
        <div class="row gutters">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($notifyBranchs && $notifyBranchs->count())
                            <div class="bg-warning my-3 px-3 pt-3 pb-2 text-center rounded" style="max-width: 350px">
                                <select class="form-control selectpicker" data-live-search="true" id="notifyBranch">
                                    @foreach ($notifyBranchs as $item)
                                        <option id="" value="">Select vendor</option>
                                        <option id="{{ $item->vendor_id }}"
                                            {{ session()->get('notify_branch_vendor_id') == $item->vendor_id ? 'selected' : '' }}
                                            data-tokens="{{ $item->vendor_profile->business_name ?? '' }}">
                                            {{ $item->vendor_profile->business_name ?? '' }} >
                                            <small>
                                                {{ $item->vendor_profile->locality ?? '' }},
                                                {{ $item->vendor_profile->city ?? '' }}
                                            </small>
                                        </option>
                                    @endforeach
                                    <option
                                        {{ Auth::guard('business')->user()->vendor_id == session()->get('notify_branch_vendor_id') ? 'selected' : '' }}
                                        id="{{ Auth::guard('business')->user()->vendor_id ?? '' }}"
                                        data-tokens="{{ Auth::guard('business')->user()->vendor_profile->business_name ?? '' }}">
                                        {{ Auth::guard('business')->user()->vendor_profile->business_name ?? '' }} >
                                        <small>
                                            {{ Auth::guard('business')->user()->vendor_profile->locality ?? '' }},
                                            {{ Auth::guard('business')->user()->vendor_profile->city ?? '' }}
                                        </small>
                                    </option>
                                </select>
                            </div>
                        @endif
                        @if ($pendingBooking->appends($_GET))
                            <div class="form-row">
                                <div class="booking-list"
                                    style="background: linear-gradient(45deg, #e8eef2 0%, #6a8b9f 100%);">
                                    <h4>{{ $vendor_profile->business_name }}</h4>
                                    <small>{{ $vendor_profile->locality }},
                                        {{ $vendor_profile->city }}</small>
                                </div>
                                @foreach ($pendingBooking as $item)
                                    @if ($item->services)
                                        @php
                                            $itemServices = is_array($item->services) ? $item->services : json_decode($item->services);
                                            $itemServices = is_array($itemServices) ? $itemServices : [];
                                            $htmlData = '';
                                            $subServicesData = '';
                                        @endphp
                                        @foreach ($itemServices as $service)
                                            @php
                                                $amount = 0;
                                                if (is_array($service)) {
                                                    $amount = Arr::exists($service, 'amount') ? $service['amount'] : $service['discount_price'];
                                                    $sub_service_name = empty($service['sub_service_name']) ? $service['service_name'] : $service['sub_service_name'];
                                                } else {
                                                    $amount = property_exists($service, 'amount') ? $service->amount : $service->discount_price;
                                                    $sub_service_name = empty($service->sub_service_name) ? $service->service_name : $service->sub_service_name;
                                                }
                                                $htmlData .= "  <tr><td class='text-left'>$sub_service_name</td>
                                                    <td class='text-right'> ₹ $amount  </td></tr>";
                                                $subServicesData .= $sub_service_name . ', ';
                                            @endphp

                                        @endforeach
                                    @endif
                                    <div class="booking-list-completed">
                                        <a
                                            href="{{ route('business.dashboard.user.booking.details', ['order_id' => $item->order_id, 'type' => 'Pending']) }}">
                                            <div class="float-left col-8">
                                                {{ Str::limit(substr(trim($subServicesData), 0, -1), 50) }}
                                                <small class="text-muted">
                                                    <br />{{ $item->updated_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="float-right col-4">
                                                <span class="badge badge-bdr-pill badge-info">{{ $item->booking_date }}
                                                    <br />
                                                    {{ $item->booking_time }}</span>
                                            </div>
                                        </a>
                                    </div>


                                @endforeach
                            </div>
                            <div class="form-row">
                                {{ $pendingBooking->appends($_GET)->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>


        </div>
        <!-- Row end -->
        <!-- The Modal -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('zoy-asset/vendor/bs-select/bs-select.min.js') }}"></script>
    <script>
        $('#notifyBranch').change(function() {
            var vendor_id = $('option:selected', this).attr('id');
            var base_url = $('meta[name="base_url"]').attr('content');
            if (vendor_id) {
                $("#loading-wrapper").show();
                $.ajax({
                    method: 'GET',
                    url: base_url + "/update/notify/branch/" + vendor_id,
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function(err) {
                        $("#loading-wrapper").fadeOut();
                        console.log(err);
                    }
                });
            }
        });
    </script>
@endsection

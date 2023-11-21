@extends('layouts.app')
@section('styles')
    <style>
        .clock {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            color: #2e323c;
            font-size: 20px;
            letter-spacing: 7px;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                    <div class="page-icon">
                        <i class="icon-laptop_windows"></i>
                    </div>
                    <div class="page-title">
                        <h5>Dashboard</h5>
                        <h6 class="sub-heading">Welcome to Zoylee Business Dashboard</h6>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 d-none d-md-block">
                    <div id="MyClockDisplay" class="clock border border-info rounded  p-1 px-2" onload="showTime()"></div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->

    <!-- BEGIN .main-content -->
    <div class="main-content">
        <!-- Row start -->
        <div class="row gutters pt-3">
            <div class="col-md col-sm-6">
                <a href="{{ route('user.total.booking', $vendor_id) }}">
                    <div class="box">
                        <span class="icon-equalizer3" style="font-size: 30px;"></span>
                        <h6>Total Bookings</h6>
                    </div>
                </a>
            </div>
            @if ($gst_vendor)
                <div class="col-md col-sm-6">
                    <a href="{{ route('user.online.booking', $vendor_id) }}">
                        <div class="box">
                            <span class="icon-equalizer3" style="font-size: 30px;"></span>
                            <h6>Online Payment</h6>
                        </div>
                    </a>
                </div>
            @endif
            <div class="col-md col-sm-6">
                <a href="{{ route('user.cash.booking', $vendor_id) }}">
                    <div class="box">
                        <span class="icon-equalizer3" style="font-size: 30px;"></span>
                        <h6>Cash Payment</h6>
                    </div>
                </a>
            </div>

            {{-- <div class="col-md col-sm-6">
                <a href="{{ route('user.booking.transaction', $vendor_id) }}">
                    <div class="box">
                        <span class="icon-equalizer3" style="font-size: 30px;"></span>
                        <h6>Transaction</h6>
                    </div>
                </a>
            </div>
            <div class=" col-md col-sm-6">
                <a href="javascript:void()">
                    <div class="box">
                        <span class="icon-equalizer3" style="font-size: 30px;"></span>
                        <h6>Settlement</h6>
                    </div>
                </a>
            </div> --}}
            <div class="col-md-1 col-sm-6">
                <a href="https://zoylee.com/zoylee-crm/?crm={{ $vendor_id }}" target="_blank">
                    <div class="box">
                        <span class="icon-equalizer3" style="font-size: 30px;"></span>
                        <h6>CRM</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Row end -->
        {{-- dashraththakur9999@gmail.com --}}
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">Today's Bookings &mdash;
                        {{ $totalRecent }}</div>
                    <div class="card-body">
                        <div class="form-row">
                            @if ($recentBooking)
                                @foreach ($recentBooking as $items)
                                    <div class="booking-list {{ $loop->iteration > 1 ? 'mt-4' : '' }}"
                                        style="background: linear-gradient(45deg, #e8eef2 0%, #6a8b9f 100%);">
                                        <strong>{{ $items[0]['vendorProfile']['business_name'] ?? '' }}</strong>
                                        <small>{{ $items[0]['vendorProfile']['locality'] ?? '' }},
                                            {{ $items[0]['vendorProfile']['city'] ?? '' }}</small>
                                        <strong
                                            class="badge badge-pill badge-info float-right">{{ $items->count() }}</strong>
                                    </div>
                                    @foreach ($items as $item)
                                        @if ($item->services)
                                            @php
                                                $itemServices = is_array($item->services) ? $item->services : json_decode($item->services);
                                                $itemServices = is_array($itemServices) ? $itemServices : [];
                                                $htmlData = '';
                                                $subServicesData = '';
                                            @endphp
                                            @foreach ($itemServices as $service)
                                                @php
                                                    if (is_array($service)) {
                                                        $sub_service_name = empty($service['sub_service_name']) ? $service['service_name'] : $service['sub_service_name'];
                                                        $amount = $service['amount'];
                                                    } else {
                                                        $sub_service_name = empty($service->sub_service_name) ? $service->service_name : $service->sub_service_name;
                                                        $amount = $service->amount;
                                                    }
                                                    $htmlData .= "  <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td class='text-left'>$sub_service_name</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td class='text-right'> ₹ $amount  </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>";
                                                    $subServicesData .= $sub_service_name . ', ';
                                                @endphp
                                            @endforeach
                                        @endif
                                        <div class="booking-list">
                                            <a href="{{ route('business.dashboard.user.booking.details', ['order_id' => $item->order_id, 'type' => 'Today']) }}"
                                                class="float-left">
                                                {{-- Str::limit($subServicesData,30) --}}
                                                <span>{{ Str::limit(substr(trim($subServicesData), 0, -1), 30) }}</span>
                                                <span class="float-right ml-5">
                                                    <span class="badge badge-bdr-pill badge-info">{{ $item->booking_date }}
                                                        at
                                                        {{ $item->booking_time }} </span>
                                                </span>
                                            </a>
                                        </div>
                                    @endforeach
                                @endforeach

                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-header">Upcoming Bookings &mdash; {{ $totalUpcoming }}</div>
                    <div class="card-body">
                        <div class="form-row">
                            @if ($upcoming)
                                @foreach ($upcoming as $items)
                                    <div class="booking-list {{ $loop->iteration > 1 ? 'mt-4' : '' }}"
                                        style="background: linear-gradient(45deg, #e8eef2 0%, #6a8b9f 100%);">
                                        <strong>{{ $items[0]['vendorProfile']['business_name'] ?? '' }}</strong>
                                        <small>{{ $items[0]['vendorProfile']['locality'] ?? '' }},
                                            {{ $items[0]['vendorProfile']['city'] ?? '' }}</small>

                                        <strong
                                            class="badge badge-pill badge-info float-right">{{ $items->count() }}</strong>
                                    </div>
                                    @foreach ($items as $item)
                                        @if ($item->services)
                                            @php
                                                $itemServices = is_array($item->services) ? $item->services : json_decode($item->services);
                                                $htmlData = '';
                                                $subServicesData = '';
                                                $itemServices = is_array($itemServices) ? $itemServices : [];
                                            @endphp

                                            @foreach ($itemServices as $service)
                                                @php
                                                    if (is_array($service)) {
                                                        $sub_service_name = empty($service['sub_service_name']) ? $service['service_name'] : $service['sub_service_name'];
                                                        $amount = $service['amount'];
                                                    } else {
                                                        $sub_service_name = empty($service->sub_service_name) ? $service->service_name : $service->sub_service_name;
                                                        $amount = $service->amount;
                                                    }
                                                    $htmlData .= "  <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td class='text-left'>$sub_service_name</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <td class='text-right'> ₹ $amount  </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>";
                                                    $subServicesData .= $sub_service_name . ', ';
                                                @endphp
                                            @endforeach
                                        @endif
                                        <div class="booking-list">
                                            <a href="#" class="float-left" data-toggle="modal"
                                                data-target="#myModal{{ $item->id }}">
                                                <span>{{ Str::limit(substr(trim($subServicesData), 0, -1), 30) }}</span>
                                            </a>
                                            <span class="float-right ml-5">
                                                <span class="badge badge-bdr-pill badge-info">{{ $item->booking_date }}
                                                    {{ $item->booking_time }}</span>
                                            </span>
                                            @if ($item->is_canceled)
                                                <span class="badge badge-pill badge-danger float-right">Cancelled</span>
                                            @endif

                                            <a href="#" data-toggle="modal" data-target="#cancel{{ $item->id }}"
                                                class="btn btn-danger btn-sm float-right py-0">cancel</a>
                                            <div class="modal" id="cancel{{ $item->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header custom-heading">
                                                            <h4 class="modal-title text-white">Update your reason</h4>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body text-dark mx-auto">

                                                            <div class="canceled-reason-parent pt-2 ">
                                                                <h5 class=" border-bottom py-2">Check Cancelled Reason</h5>
                                                            </div>

                                                            <div
                                                                class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent ">
                                                                <input type="radio"
                                                                    id="canceled-reason{{ $item->id }}1"
                                                                    name="canceled-reason-up"
                                                                    class="custom-control-input canceled-reason-up"
                                                                    value="Artist Unavailability">
                                                                <label class="custom-control-label"
                                                                    for="canceled-reason{{ $item->id }}1">Artist
                                                                    Unavailability </label>
                                                            </div>
                                                            <div
                                                                class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent ">
                                                                <input type="radio"
                                                                    id="canceled-reason{{ $item->id }}2"
                                                                    name="canceled-reason-up"
                                                                    class="custom-control-input canceled-reason-up"
                                                                    value="Waiting Time" />
                                                                <label class="custom-control-label"
                                                                    for="canceled-reason{{ $item->id }}2">Waiting Time
                                                                </label>
                                                            </div>
                                                            <div
                                                                class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent ">
                                                                <input type="radio"
                                                                    id="canceled-reason{{ $item->id }}3"
                                                                    name="canceled-reason-up"
                                                                    class="custom-control-input canceled-reason-up"
                                                                    value="Others" />
                                                                <label class="custom-control-label"
                                                                    for="canceled-reason{{ $item->id }}3">Others
                                                                </label>
                                                            </div>

                                                            <div class="pt-3">
                                                                <textarea class="form-control display-none others_reason_textarea_up" placeholder="Please specify a reason..."
                                                                    style="max-width:400px" id="others_reason_textarea_up{{ $item->id }}"></textarea>
                                                            </div>
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer text-center">
                                                            <form action="{{ route('update.cancel.service') }}"
                                                                class="mx-auto" method="post"
                                                                id="update_served_status_up{{ $item->id }}">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}" />
                                                                <input type="hidden" value="" name="cancel_reason"
                                                                    id="cancel_reason_up{{ $item->id }}" />
                                                                <button type="button"
                                                                    class="btn btn-success btn-rounded btn-sm mr-1 btn-submit-up"
                                                                    id="btn-submit-up{{ $item->id }}">Ok</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal" id="myModal{{ $item->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header custom-heading">
                                                        <h4 class="modal-title text-white">Booking Details</h4>
                                                        <button type="button" class="close text-white"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <p><strong>Customer
                                                                                    Name</strong><br>{{ $item->user->name ?? 'Unnamed' }}
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <p><strong>Booking
                                                                                    ID</strong><br>{{ $item->order_id }}
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <p><strong>Date:
                                                                                </strong>{{ $item->booking_date }}
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <p><strong>Timing: </strong>
                                                                                {{ $item->booking_time }}</p>
                                                                        </td>

                                                                        <td>

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Service(s)</th>
                                                                        <th>Rate</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    {!! $htmlData !!}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td>
                                                                            <div class="float-left">
                                                                                <strong>Total</strong>
                                                                            </div>
                                                                            <div class="float-right">
                                                                                ₹ {{ $item->net_amount }}
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach

                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row end -->

    </div>
    <!-- END: .main-content -->



@endsection

@section('scripts')
    <script>
        function showTime() {
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "";
            // AM
            if (h == 0) {
                h = 12;
            }
            if (h > 12) {
                h = h - 12;
                session = "";
                // PM
            }
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;
            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;
            setTimeout(showTime, 1000);
        }
        showTime();




        // Upcoming Handling
        // Handle cancle reason
        $('.canceled-reason-up').click(function() {
            var vendor_id = $(this).attr('id');
            vendor_id = vendor_id.replace('canceled-reason', '')
            vendor_id = vendor_id.slice(0, -1);
            var radioValue = $("input[name='canceled-reason-up']:checked").val();
            if (radioValue) {
                if (radioValue === "Others") {
                    $("#others_reason_textarea_up" + vendor_id).show();
                    $("#cancel_reason_up" + vendor_id).val('');
                } else {
                    $("#cancel_reason_up" + vendor_id).val(radioValue);
                    $("#others_reason_textarea_up" + vendor_id).hide();
                }
            }
        });
        // Handle custom reason
        $('.others_reason_textarea_up').keyup(function() {
            var vendor_id = $(this).attr('id');
            vendor_id = vendor_id.replace('others_reason_textarea_up', '')
            $("#cancel_reason_up" + vendor_id).val($(this).val());
        });
        // Handle form
        $('.btn-submit-up').click(function() {
            var vendor_id = $(this).attr('id');
            vendor_id = vendor_id.replace('btn-submit-up', '')
            var status = false;
            if (!$("#cancel_reason_up" + vendor_id).val())
                alert("Please check or enter cancel reason");
            else
                status = true;
            if (status)
                $("#update_served_status_up" + vendor_id).submit();
        });
    </script>

@endsection

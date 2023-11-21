@extends('layouts.app')

@php
    $data = Auth::guard('business')->user();
@endphp

@section('styles')
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
        <!-- Row start -->
        <div class="row gutters">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $type }} Booking &mdash;
                        {{ $booking->vendorProfile->business_name ?? '' }},
                        <span class="text-muted">
                            {{ $booking->vendorProfile->locality ?? '' }},
                            {{ $booking->vendorProfile->city ?? '' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="form-row">

                            @if ($booking->services)
                                @php
                                    $itemServices = is_array($booking->services) ? $booking->services : json_decode($booking->services);
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
                                        $htmlData .= "  <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <td class='text-left'>$sub_service_name</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <td class='text-right'> ₹ $amount  </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </tr>";
                                        $subServicesData .= $sub_service_name . ', ';

                                    @endphp
                                @endforeach
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p><strong>Customer
                                                        Name</strong><br>{{ $booking->user->name ?? 'Unnamed' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p><strong>Booking
                                                        ID</strong><br>{{ $booking->order_id }}</p>
                                            </td>
                                            <td>
                                                <p><strong>Date:
                                                    </strong>{{ $booking->booking_date }}
                                                    at </p>
                                            </td>
                                            <td>
                                                <p><strong>Timing: </strong>
                                                    {{ $booking->booking_time }}</p>
                                            </td>

                                            @if ($type != 'Today' && $booking->service_status != true && $booking->is_canceled != true)
                                                <td>
                                                    <button type="button" id="{{ $booking->id }}" data-toggle="modal"
                                                        data-target="#actionPanel{{ $booking->id }}"
                                                        class="btn btn-info btn-sm float-right py-0"
                                                        data-dismiss="modal">Action</button>
                                                </td>
                                            @elseif ($booking->service_status)
                                                <td class="text-success">Completed</td>
                                            @elseif ($booking->is_canceled)
                                                <td class="text-error">Cancelled</td>
                                            @endif

                                            @if ($type == 'Today' && $booking->service_status != true && $booking->is_canceled != true)
                                                {{-- @php
                                                    $datetime1 = date('H', strtotime($booking->booking_time));
                                                    $datetime2 = date('H');

                                                @endphp --}}
                                                </a>

                                                {{-- @if ($datetime1 >= $datetime2) --}}
                                                <td>
                                                    <button type="button" id="{{ $booking->id }}" data-toggle="modal"
                                                        data-target="#actionPanel{{ $booking->id }}"
                                                        class="btn btn-info btn-sm float-right py-0"
                                                        data-dismiss="modal">Action</button>
                                                </td>
                                                {{-- @endif --}}
                                            @endif
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
                                                    ₹ {{ $booking->net_amount }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                            @if ($type == 'Pending' || $type == 'Today')

                                <div class="modal" id="actionPanel{{ $booking->id }}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header custom-heading">
                                                <h4 class="modal-title text-white">Action panel</h4>
                                                <button type="button" class="close text-white"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            @php
                                                $datetime1 = date('H', strtotime($booking->booking_time));
                                                $datetime2 = date('H');
                                                $todyadate = date(DATE_ATOM);
                                            @endphp
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row">
                                                    {{-- service status --}}
                                                    <div class="col-12 text-center py-2">
                                                        <div class="pb-3">
                                                            <h5 class=" border-bottom py-2">Service Status</h5>
                                                            <button type="button" value="Completed"
                                                                class="service_status_btn btn btn-outline-info btn-rounded btn-sm mr-1">Completed</button>

                                                            <button type="button" value="No show"
                                                                class="service_status_btn btn btn-outline-warning btn-rounded btn-sm mr-1">No
                                                                show</button>

                                                            <button type="button" value="Canceled"
                                                                class="service_status_btn btn btn-outline-danger btn-rounded btn-sm mr-1">Cancelled
                                                            </button>
                                                        </div>


                                                        <div class="canceled-reason-parent pt-2 display-none">
                                                            <h5 class=" border-bottom py-2">Check Cancelled Reason</h5>
                                                        </div>

                                                        <div
                                                            class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent display-none">
                                                            <input type="radio" id="canceled-reason{{ $booking->id }}1"
                                                                name="canceled-reason"
                                                                class="custom-control-input canceled-reason "
                                                                value="Artist Unavailability">
                                                            <label class="custom-control-label"
                                                                for="canceled-reason{{ $booking->id }}1">Artist
                                                                Unavailability </label>
                                                        </div>
                                                        <div
                                                            class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent display-none">
                                                            <input type="radio" id="canceled-reason{{ $booking->id }}2"
                                                                name="canceled-reason"
                                                                class="custom-control-input canceled-reason"
                                                                value="Waiting Time" />
                                                            <label class="custom-control-label"
                                                                for="canceled-reason{{ $booking->id }}2">Waiting Time
                                                            </label>
                                                        </div>
                                                        <div
                                                            class="custom-control custom-radio custom-control-inline pt-2 canceled-reason-parent display-none">
                                                            <input type="radio" id="canceled-reason{{ $booking->id }}3"
                                                                name="canceled-reason"
                                                                class="custom-control-input canceled-reason"
                                                                value="Others" />
                                                            <label class="custom-control-label"
                                                                for="canceled-reason{{ $booking->id }}3">Others
                                                            </label>
                                                        </div>

                                                        <div class="pt-3">
                                                            <textarea class="form-control display-none" placeholder="Please specify a reason..." style="max-width:400px"
                                                                id="others_reason_textarea"></textarea>
                                                        </div>
                                                    </div>
                                                    {{-- end service status --}}
                                                    {{-- Payment status --}}
                                                    <div class="col-12 text-center py-2 payment_status_parent">
                                                        <h5 class=" border-bottom py-2">Payment Status </h5>
                                                        @if ($booking->pay_with === 'online')
                                                            <button type="button"
                                                                class="btn btn-success btn-rounded btn-sm mr-1">Online</button>
                                                            <button type="button" disabled
                                                                class="btn btn-outline-info btn-rounded btn-sm mr-1">Cash</button>
                                                            <button type="button" disabled
                                                                class="btn btn-outline-info btn-rounded btn-sm mr-1">Card/Paytm</button>
                                                        @endif
                                                        @if ($booking->pay_with === 'pay_at_counter')
                                                            <button type="button" disabled
                                                                class="btn btn-outline-info btn-rounded btn-sm mr-1">Online</button>
                                                            <button type="button" value="Cash"
                                                                class="payment_status_btn btn btn-outline-info btn-rounded btn-sm mr-1">Cash</button>
                                                            <button type="button" value="Card/Paytm"
                                                                class="payment_status_btn btn btn-outline-info btn-rounded btn-sm mr-1">Card/Paytm/Others</button>
                                                        @endif

                                                    </div>
                                                    {{-- end payment status --}}
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer text-center mx-auto">
                                                <form action="{{ route('update.served') }}" method="post"
                                                    id="update_served_status_{{ $booking->id }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $booking->id }}" />
                                                    <input type="hidden"
                                                        value="{{ $booking->pay_with === 'online' ? 'online' : '' }}"
                                                        name="user_payment_mode" id="pay_confirmation_via_vendor" />
                                                    <input type="hidden" value="" name="vendor_service_status"
                                                        id="vendor_status" />
                                                    <input type="hidden" value="" name="canceled_reason"
                                                        id="cancel_reason" />
                                                    <button type="button"
                                                        class="btn btn-success btn-rounded btn-sm mr-1 btn-submit">Ok</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
        <!-- The Modal -->
    </div>
@endsection

@section('scripts')
    <script>
        // Handle service status
        $('.service_status_btn').click(function() {
            // alert($(this).val());
            $('.service_status_btn').removeClass('btn-success text-white');
            $(this).addClass('btn-success text-white');
            $('#vendor_status').val($(this).val());
            if ($(this).val() === "Canceled") {
                $('.canceled-reason-parent').css({
                    'display': 'inline'
                });
                $('.payment_status_parent').hide();
                var getCancelReasonVal = $("input[name='canceled-reason']:checked").val();
                if (getCancelReasonVal && getCancelReasonVal === "Others")
                    $('#others_reason_textarea').show();
            } else if ($(this).val() === "Completed") {
                $('.payment_status_parent').show();
                $('.canceled-reason-parent').hide();
                $('#others_reason_textarea').hide();
            } else {
                $('.payment_status_parent').hide();
                $('.canceled-reason-parent').hide();
                $('#others_reason_textarea').hide();
            }
        });
        // Handle payment status
        $('.payment_status_btn').click(function() {
            // alert($(this).val());
            $('.payment_status_btn').removeClass('btn-success');
            $('.payment_status_btn').addClass('btn-outline-info');
            $(this).removeClass('btn-outline-info');
            $(this).addClass('btn-success');
            $('#pay_confirmation_via_vendor').val($(this).val());
        });
        // Handle cancle reason
        $('.canceled-reason').click(function() {
            var radioValue = $("input[name='canceled-reason']:checked").val();
            if (radioValue) {
                if (radioValue === "Others") {
                    $('#others_reason_textarea').show();
                    $('#cancel_reason').val('');
                } else {
                    $('#cancel_reason').val(radioValue);
                    $('#others_reason_textarea').hide();
                }
            }
        });
        // Handle custom reason
        $('#others_reason_textarea').keyup(function() {
            $('#cancel_reason').val($(this).val());
        });
        // Handle form
        $('.btn-submit').click(function() {

            // alert($(this).siblings('#pay_confirmation_via_vendor').val());
            var status = false;
            if ($('#vendor_status').val() == "")
                alert("Please select service status");
            else if ($('#pay_confirmation_via_vendor').val() == "") {
                if ($('#vendor_status').val() === "Completed")
                    alert("Please select payment status");
                else if ($('#vendor_status').val() == "Canceled") {
                    if (!$('#cancel_reason').val())
                        alert("Please check or enter cancel reason");
                    else
                        status = true;
                } else
                    status = true;
            } else if ($('#vendor_status').val() == "Canceled") {
                if (!$('#cancel_reason').val())
                    alert("Please check or enter cancel reason");
                else
                    status = true;
            } else
                status = true;

            if (status) {
                $(this).removeClass('btn-submit');
                $(this).html('Wait...');
                // $('#update_served_status').submit();
                $(this).parent().submit();
            }
        });


        // Upcoming Handling
        // Handle cancle reason
        $('.canceled-reason-up').click(function() {
            var radioValue = $("input[name='canceled-reason-up']:checked").val();
            if (radioValue) {
                if (radioValue === "Others") {
                    $('#others_reason_textarea_up').show();
                    $('#cancel_reason_up').val('');
                } else {
                    $('#cancel_reason_up').val(radioValue);
                    $('#others_reason_textarea_up').hide();
                }
            }
        });
        // Handle custom reason
        $('#others_reason_textarea_up').keyup(function() {
            $('#cancel_reason_up').val($(this).val());
        });
        // Handle form
        $('.btn-submit-up').click(function() {
            var status = false;
            if (!$('#cancel_reason_up').val())
                alert("Please check or enter cancel reason");
            else
                status = true;
            if (status)
                $('#update_served_status_up').submit();
        });
    </script>
@endsection



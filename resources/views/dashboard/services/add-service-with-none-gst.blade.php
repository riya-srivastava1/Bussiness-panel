@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/bs-select/bs-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/dataTables.bs4.css') }}">
    <style>
        input:focus,
        select:focus {
            outline: none !important;
            border: 0;
        }

        .display-none {
            display: none;
        }

        .pricing_panel_row input,
        .pricing_panel_row select {
            height: 30px;
            text-align: center;
        }

        .pricing_panel_row select {
            font-size: 100%;
        }

        .disable_pricing_panel_row input {
            border: 0px;
            text-align: center;
        }
    </style>
@endsection

@php
    $data = Auth::guard('business')->user();
@endphp
@section('content')

    <div id="content" class="app-content">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

            <div class="card bg-white">
                <div class="card-header">Add None GST Services </div>

                <div class="card-body">
                    <form class="form-signin-services small" method="post" id="form-signin"
                        action="{{ route('vendor.service.store') }}">
                        @csrf
                        <input type="hidden" name="vendor_id" value="{{ $vendor_id }}" />
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="select_service_type" class="col-form-label">Select Service Type</label>
                                <select name="type" id="select_service_type" class="form-control rounded-0">
                                    <option value="service">Service</option>
                                    <option value="package">Package</option>
                                </select>
                            </div>
                            <div class="col-md-4 package_section display-none">
                                <label for="inputEmail4" class="col-form-label">Select Service</label>
                                <select name="service_type_name" id="service_type_name" class="form-select"
                                    data-live-search="true">
                                    <option value="">Select Service</option>
                                    @if ($serviceType)
                                        @foreach ($serviceType as $item)
                                            <option value="{{ $item->service_type_name }}">
                                                {{ $item->service_type_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 package_section display-none">
                                <label for="inputEmail4" class="col-form-label">Package Category</label>
                                <select name="package_category" id="package_category" class="form-select"
                                    data-live-search="true">
                                    <option value="">Select Package Category</option>
                                    <option value="Bridal">Bridal</option>
                                    <option value="Trending">Trending</option>
                                    <option value="Traditional">Traditional</option>
                                    <option value="Formal">Formal</option>
                                </select>
                            </div>
                            <div class="col-md-4 package_section display-none">
                                <label for="package_name" class="col-form-label ">Package Name</label>
                                <input type="text" alt="package_name" name="package_name" class="form-control rounded-0"
                                    placeholder="Package Name" />
                            </div>

                            <div class="col-md-4 package_section display-none">
                                <label for="package_description" class="col-form-label">Package Description</label>
                                <textarea name="package_description" placeholder="Package Description" id="package_description" style="height: 38px"
                                    class="form-control rounded-0" cols="30" rows="1"></textarea>
                            </div>

                            <div class="col-md-4 service_section">
                                <label for="inputEmail4" class="col-form-label">Select Service</label>
                                <select name="service_id" id="service_id" class="form-select" data-live-search="true">
                                    <option value="">Select Service</option>
                                    @if ($serviceType)
                                        @foreach ($serviceType as $ser)
                                            @if ($ser->service && count($ser->service) > 0)
                                                <optgroup
                                                    label="{{ $ser->category ? $ser->category->category_name : 'Unnamed' }} - {{ $ser->service_type_name }}">
                                                    @foreach ($ser->service as $item)
                                                        <option value="{{ $item->id }}">{{ $item->service_name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 service_section">
                                <label for="text_sub_service_name" class="col-form-label">Select sub Service</label>
                                <input type="text" name="sub_service_name" class="rounded-0 custom-select form-control"
                                    id="text_sub_service_name" placeholder="Enter Sub Service" list="sub_service_name" />
                                <datalist id="sub_service_name">
                                </datalist>
                            </div>

                            <div class="col-md-4">
                                <label for="inputPassword4" class="col-form-label">SERVICE DURATION (in min) </label>
                                <input type="text" id="duration" class="form-control rounded-0" name="duration"
                                    placeholder="Duration" required />
                            </div>
                            <div class="col-md-4">
                                <label for="inputEmail4" class="col-form-label">AVAILABLE FOR </label>
                                <select name="available_for" id="available_for"
                                    class="form-control schedule-days h-80 f-90 rounded-0" required>
                                    <!-- <option value="Unisex" selected="selected">Unisex </option> -->
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Kids">Kids</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputEmail4" class="col-form-label">Status</label>
                                <select name="status" id="status"
                                    class="form-control schedule-days h-80 f-90 rounded-0" required>
                                    <option value="true" selected="selected">Available</option>
                                    <option value="false">Not Available</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin:10px 0px; background:#f1f1f1; padding:10px 10px;">
                            <strong>Pricing Panel<span> None GST Vendor</span></strong>
                        </div>


                        <div class="col-md-12 pricing_panel_row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">Your Section</div>
                                        <div class="card-body">
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="price" class="col-sm-4 col-form-label"><strong>Service
                                                        Price</strong></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="actual_price" id="service_price"
                                                        class="form-control rounded-0 number calculate_price"
                                                        style="border:1px solid #65e717;">
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount_type"
                                                    class="col-sm-4 col-form-label"><strong>Discount
                                                        Type</strong></label>
                                                <div class="col-sm-8">
                                                    <select name="discount_type" id="discount_type"
                                                        class="form-control rounded-0 calculate_price_change"
                                                        style="border:1px solid #65e717;">
                                                        <option value="2">Percentage</option>
                                                        <option value="1">Flat</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount" class="col-sm-4 col-form-label"><strong>Vendor
                                                        Discount for User</strong></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="discount" placeholder="in %"
                                                        id="discount" class="form-control number calculate_price"
                                                        style="border:1px solid #65e717;">
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount_valid"
                                                    class="col-sm-4 col-form-label"><strong>Discount valid
                                                        (days)</strong></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="discount_valid" id="discount_valid"
                                                        class="form-control number calculate_price" value="0"
                                                        style="border:1px solid #65e717;">
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row gutters px-3 mb-2">
                                            <div class="col-12">
                                                <hr />
                                            </div>
                                        </div> --}}



                                            {{-- <div class="form-group row gutters px-3 mb-2">
                                            <label for="zoylee_net_income" class="col-sm-4 col-form-label"><strong>Commission Pass-on (%)</strong></label>
                                            <div class="col-sm-8">
                                            <input type="hidden" name="commission_pass_on" id="commission_pass_on" class="form-control rounded-0 number calculate_price" value="0" style="border:1px solid #65e717;">
                                            </div>
                                        </div> --}}


                                        </div>
                                    </div>
                                    <div class="card py-3">
                                        <div class="form-group row gutters px-3 mb-2">
                                            <label for="commission_on" class="col-sm-4 col-form-label"><strong>Commission
                                                    On</strong></label>
                                            <div class="col-sm-8">
                                                <select name="commission_on" id="commission_on"
                                                    class="form-control calculate_price_change"
                                                    style="border:1px solid #65e717;">
                                                    <option value="1">With GST</option>
                                                    <option value="2">Without GST</option>
                                                    {{-- <option value="3" selected>None GST</option> --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row gutters px-3 mb-2">
                                            <label for="commission_type" class="col-sm-4 col-form-label"><strong>Zoylee
                                                    Commission Type
                                                </strong></label>
                                            <div class="col-sm-8">
                                                <select name="commission_type" id="commission_type"
                                                    class="form-control calculate_price_change" aria-readonly="false"
                                                    style="border:1px solid #65e717;">
                                                    {{-- <option value="1">Flat</option> --}}
                                                    <option value="2" selected>Percentage</option>
                                                </select>
                                            </div>
                                        </div>

                                        <input type="hidden" name="commission" id="commission"
                                            class="calculate_price form-control rounded-0 number" value="5"
                                            style="border:1px solid #65e717;">


                                        <input type="hidden" name="commission_pass_on" id="commission_pass_on"
                                            class="form-control rounded-0 number calculate_price" value="0"
                                            style="border:1px solid #65e717;">

                                        {{-- <div class="form-group col-md-8 text-right">
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-danger margin-top-33" id="btnCalculate">Calculate</button>
                                        </div>
                                    </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">Final Calculations</div>
                                        <div class="card-body">
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount_amount"
                                                    class="col-sm-6 col-form-label"><strong>Discount
                                                        Amount</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="actual_discount_amount"
                                                        id="discount_amount" class="form-control number" value="0"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="after_dicount_price"
                                                    class="col-sm-6 col-form-label"><strong>After Discount
                                                        Price</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="after_discount_price"
                                                        id="after_discount_price" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="gst"
                                                    class="col-sm-6 col-form-label"><strong>GST(18%)</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="gst" id="gst"
                                                        class="form-control rounded-0" value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="pre_gst_amount" class="col-sm-6 col-form-label"><strong>Pre
                                                        GST
                                                        Amount</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="pre_gst_amount" id="pre_gst_amount"
                                                        class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="list_price" class="col-sm-6 col-form-label"><strong>List
                                                        Price</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="list_price" id="list_price"
                                                        class="form-control rounded-0" readonly>
                                                </div>
                                            </div>



                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="zoylee_commission_in_rs"
                                                    class="col-sm-6 col-form-label"><strong>Zoylee Commission in
                                                        RS.</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="commission_amount"
                                                        id="zoylee_commission_in_rs" class="form-control rounded-0"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="gst_on_zoylee_commission"
                                                    class="col-sm-6 col-form-label"><strong>18% GST On Zoylee
                                                        Commission</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="gst_on_zoylee_commission"
                                                        id="gst_on_zoylee_commission" class="form-control rounded-0"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="vendor_earning" class="col-sm-6 col-form-label"><strong>Final
                                                        Vendor
                                                        Collection</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="final_vendor_collection"
                                                        id="final_vendor_collaction" class="form-control rounded-0"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="vendor_earning" class="col-sm-6 col-form-label"><strong>Vendor
                                                        Earning</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="vendor_earning" id="vendor_earning"
                                                        class="form-control rounded-0" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="internet_charge"
                                                    class="col-sm-6 col-form-label"><strong>Internet Charge
                                                        (2%)</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="internet_charge" id="internet_charge"
                                                        class="form-control rounded-0" value="2" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="internet_charge_in_rs"
                                                    class="col-sm-6 col-form-label"><strong>Internet Charge in
                                                        Rs.</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="internet_charge_amount"
                                                        id="internet_charge_in_rs" class="form-control rounded-0"
                                                        readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="setttlement_amount"
                                                    class="col-sm-6 col-form-label"><strong>Settlement
                                                        Amount</strong></label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="settlement_amount" id="settlement_amount"
                                                        class="form-control rounded-0"
                                                        style="color:green; font-weight:bold;" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" name="zoylee_net_income" id="zoylee_net_income"
                                                class="form-control rounded-0" style="color:green; font-weight:bold;"
                                                readonly>
                                            <input type="hidden" name="zoylee_user_discount" id="user_discount"
                                                class="form-control rounded-0" readonly>
                                            <input type="hidden" name="final_zoylee_income" id="final_zoylee_income"
                                                class="form-control rounded-0" style="color:green; font-weight:bold;"
                                                readonly>



                                            <div class="form-group col-md-8 text-right">
                                                <div class="form-actions">
                                                    <button type="submit"
                                                        class="btn btn-success margin-top-33">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('zoy-asset/vendor/bs-select/bs-select.min.js') }}"></script>
    <script>
        $(".number").keypress(function(event) {
            var keycode = event.which;
            if (
                !(
                    event.shiftKey == false &&
                    (keycode == 46 ||
                        keycode == 8 ||
                        keycode == 37 ||
                        keycode == 39 ||
                        (keycode >= 48 && keycode <= 57))
                )
            ) {
                event.preventDefault();
            }
        });


        function calculate() {
            var servicePrice = $('#service_price').val();
            var discount = $('#discount').val();
            var discount_type = $('#discount_type').val();
            var discount_amount = $('#discount_amount').val();
            var commission_type = $('#commission_type').val();
            var commission = $('#commission').val();
            var commission_pass_on = $('#commission_pass_on').val();
            var commission_on = $('#commission_on').val();
            var pre_gst_amount = $('#pre_gst_amount').val();
            var totalCal = 0;

            var discAmount, listPrice, commissionValue, gst_on_commision, gst_amount;

            if (discount < 0 || discount > 100 || discount == "") {
                // alert('Vendor discount field can not be less then 0, not greater then 100 and not blank!')
                // $('#discount').val(0);
                discount = 0;
                $('#discount').focus();
            }
            // if(discount_amount=="") {
            //     // alert('Discount amount field can not be blank!')
            //     $('#discount_amount').val(0);
            //     $('#discount_amount').focus();
            // }

            if (commission == "") {
                // alert('Zoylee Commission field can not be blank!')
                $('#commission').val(0);
                $('#commission').focus();
            }

            if (commission_pass_on == "" || commission_pass_on > 100) {
                // alert('Commission pass-on field can not be blank or not greater then 100')
                $('#commission_pass_on').val(0);
                $('#commission_pass_on').focus();
            }

            //Calculate after discount price
            if (discount_type == 1) {
                $('#discount_amount').val(discount);
                $('#after_discount_price').val((servicePrice - discount).toFixed(2));
            } else if (discount_type == 2) {
                discAmount = servicePrice * discount / 100;
                $('#discount_amount').val(discAmount);
                $('#after_discount_price').val((servicePrice - discAmount).toFixed(2));
                //
            }

            //Calculate Gst

            $('#pre_gst_amount').val($('#after_discount_price').val() - $('#gst').val());

            listPrice = $('#after_discount_price').val();
            $('#list_price').val(listPrice);

            // if(commission==0) {
            //     $('#zoylee_commission_in_rs').val('0');
            //     $('#vendor_earning').val($('#pre_gst_amount').val());
            // }

            if (commission_type == 2) {
                if (commission != 0 && commission_on == 1) {
                    gst_amount = listPrice * 18 / 118;
                    $("#gst").val(gst_amount.toFixed(2));
                    $('#pre_gst_amount').val((listPrice - gst_amount).toFixed(2));
                    commissionValue = listPrice * commission / 100;
                    gst_on_commision = commissionValue * 18 / 100;
                    $('#gst_on_zoylee_commission').val(gst_on_commision.toFixed(2));
                    $('#zoylee_commission_in_rs').val(commissionValue);
                    totalCal = commissionValue + gst_amount + gst_on_commision;
                    // var afterGstAmount = (listPrice-commissionValue)-(listPrice-commissionValue)*18/118;
                    $('#vendor_earning').val((listPrice - totalCal).toFixed(2));
                    // $('#gst_on_zoylee_commission').val(commissionValue);


                } else {
                    gst_amount = listPrice * 18 / 118;
                    commissionValue = $('#pre_gst_amount').val() * commission / 100;
                    $('#zoylee_commission_in_rs').val(commissionValue.toFixed(2));
                    var afterGstAmount = (listPrice - commissionValue) - (listPrice - commissionValue) * 18 / 118;
                    // $('#vendor_earning').val(afterGstAmount.toFixed(2));

                    gst_on_commision = commissionValue * 18 / 100;

                    totalCal = commissionValue + gst_on_commision + gst_amount;
                    //alert(totalCal);
                    $('#gst_on_zoylee_commission').val(gst_on_commision.toFixed(2));

                    //      $('#zoylee_commission_in_rs').val(commission);
                    $('#vendor_earning').val((listPrice - totalCal).toFixed(2));
                }
            }

            var IntenetHandlingCharge = $('#after_discount_price').val() * 2 / 100;
            $('#internet_charge_in_rs').val(IntenetHandlingCharge.toFixed(2));

            var ZoyleeNetIncome = $('#zoylee_commission_in_rs').val() - IntenetHandlingCharge + gst_on_commision;
            $('#zoylee_net_income').val(ZoyleeNetIncome.toFixed(2));

            //Calculate user discount
            var z_commission = $('#zoylee_net_income').val();
            var commission_pass_on = $('#commission_pass_on').val();
            var u_d = z_commission * commission_pass_on / 100;
            var totalSettlementAmount = parseFloat($('#vendor_earning').val()) + parseFloat($('#gst').val());
            //alert(totalSettlementAmount);

            $('#user_discount').val(u_d.toFixed(2));

            $('#final_zoylee_income').val(($('#zoylee_net_income').val() - $('#user_discount').val() - gst_on_commision)
                .toFixed(2));
            $('#settlement_amount').val(totalSettlementAmount);

            $('#final_vendor_collaction').val($('#list_price').val());
        }
        $('.calculate_price').keyup(function() {
            calculate();
        });
        $('.calculate_price_change').change(function() {
            calculate();
        });
        //Calculation





        //cheange event of service
        $(document).on('change', '#service_id', function() {
            var service_id = $(this).val();
            $('#text_sub_service_name').val('');
            $.ajax({
                type: 'GET',
                data: {
                    id: service_id
                },
                url: "{{ route('get.sub.service.by.id') }}",
                success: function(data) {
                    $('#sub_service_name').html(data);
                    // console.log(data);
                },
                error: function() {
                    // alert("Error");
                }
            });
        });

        $('#select_service_type').change(function() {
            if ('package' == $(this).val()) {
                $('.package_section').removeClass('display-none');
                $('.service_section').addClass('display-none');
                $('.service_section input').val('');
                $('.service_section select').val('');
                $('.service_section textarea').val('');
            } else {
                $('.package_section').addClass('display-none');
                $('.service_section').removeClass('display-none');
                $('.package_section input').val('');
                $('.package_section select').val('');
                $('.package_section textarea').val('');
            }
            // alert($(this).val());
        });
    </script>
@endsection

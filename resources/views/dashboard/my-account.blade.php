@extends('layouts.app')
{{-- @section('dashboard-myAccount-tab', 'active') --}}

@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/bs-select/bs-select.css') }}" />
@endsection

@php
    $data = Auth::guard('business')->user();
    $vendor = $data->vendor_profile;
    $vendorDocument = $data->vendor_document;
    $vendorAmenity = null;
    $vendorAmenities = $vendor->amenity;
    $v = json_decode($vendorAmenities);
    if ($v) {
        $vendorAmenity = Arr::pluck($v, 'name');
    }
    $currentServiceType = explode(',', $vendor->service_type);
@endphp

@section('content')
    <!-- BEGIN .main-content -->
    <div class="main-content">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="card bg-white">
                    <div class="card-header">
                        <div style="height: 50px my-auto"><span class="float-left" style="line-height: 50px"> My Account
                                Details</span>
                        </div>
                        <img src="{{ cdn($data->vendor_profile->banner) }}" alt="profile img" class="float-right"
                            height="50" />
                    </div>
                    <div class="card-body">
                        <div class="nav-tabs-container">
                            <ul class="nav nav-tabs nav-justified" id="myTab5" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('type') === 'profile' || request()->get('type') == null ? 'active' : '' }}"
                                        id="profile-tab5" data-toggle="tab" href="#profile5" role="tab"
                                        aria-controls="home5" aria-selected="true">Profile </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('type') === 'address' ? 'active' : '' }}"
                                        id="address-tab5" data-toggle="tab" href="#address5" role="tab"
                                        aria-controls="address5" aria-selected="true">Address</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('type') === 'bank' ? 'active' : '' }}"
                                        id="bank-tab5" data-toggle="tab" href="#bank5" role="tab"
                                        aria-controls="profile5" aria-selected="false">Bank</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->get('type') === 'document' ? 'active' : '' }}"
                                        id="documents-tab5" data-toggle="tab" href="#document5" role="tab"
                                        aria-controls="contact5" aria-selected="false">Documents</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent5">
                                <div class="tab-pane fade {{ request()->get('type') === 'profile' || request()->get('type') == null ? 'active show' : '' }}"
                                    id="profile5" role="tabpanel" aria-labelledby="home-tab5">
                                    @include('dashboard.profile-components.basic-info')
                                </div>

                                <div class="tab-pane fade {{ request()->get('type') === 'address' ? 'show active' : '' }} "
                                    id="address5" role="tabpanel" aria-labelledby="address-tab5">
                                    @include('dashboard.profile-components.address-info')
                                </div>

                                <div class="tab-pane fade {{ request()->get('type') === 'bank' ? 'show active' : '' }}"
                                    id="bank5" role="tabpanel" aria-labelledby="profile-tab5">
                                    @include('dashboard.profile-components.bank-info')
                                </div>
                                <div class="tab-pane fade {{ request()->get('type') === 'document' ? 'show active' : '' }}"
                                    id="document5" role="tabpanel" aria-labelledby="contact-tab5">
                                    @include('dashboard.profile-components.document-info')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>{{-- End Of COL --}}
        </div>{{-- End Of Row Start --}}
    </div>
    @endsection @section('scripts')
    <script src="{{ asset('zoy-asset/vendor/bs-select/bs-select.min.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko&libraries=places&callback=initMap"
        async defer></script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        $('#profile-city').val('{{ $vendor->city }}');
        $('#opening_time').val('{{ $vendor->opening_time }}');
        $('#closing_time').val('{{ $vendor->closing_time }}');


        //    bank
        $('#bank_name').val($('#currentBankName').val());
        $('#branch_name').val($('#currentBranchName').val());
        $('#pan_id').click(function() {
            $('#pan_id_err').html('');
        });
        $('#gst_id').click(function() {
            $('#gst_id_err').html('');
        });
        $('#bank_name').click(function() {
            $('#bank_name_err').html('');
        });
        $('#branch_name').click(function() {
            $('#branch_name_err').html('');
        });
        $('#account_no').click(function() {
            $('#account_no_err').html('');
        });
        $('#account_holder').click(function() {
            $('#account_holder_err').html('');
        });
        $('#ifsc').click(function() {
            $('#ifsc_err').html('');
        });
        $('.btn-submit-bank').click(function(e) {
            e.preventDefault();
            $('#submit_type').val($(this).val());
            // if ($('#pan_id').val() === '') {
            //     $('#pan_id_err').html('Please Enter PAN no.');
            //     $('#pan_id').focus();
            // } else
            if ($('#bank_name').val() === '') {
                $('#bank_name').focus();
                $('#bank_name_err').html('Please select bank name');
            } else if ($('#branch_name').val() === '') {
                $('#branch_name').focus();
                $('#branch_name_err').html('Please select branch name');
            } else if ($('#account_no').val() === '') {
                $('#account_no').focus();
                $('#account_no_err').html('Please Enter Account No.');
            } else if ($('#account_holder').val() === '') {
                $('#account_holder').focus();
                $('#account_holder_err').html('Please Enter Account Holder name');
            } else if ($('#ifsc').val() === '') {
                $('#ifsc').focus();
                $('#ifsc_err').html('Please Enter IFSC Code');
            } else {
                var pan = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
                var gst =
                    /^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
                if ($('#pan_id').val() !== '' && !pan.test($('#pan_id').val().toUpperCase())) {
                    $('#pan_id_err').html('Invalid PAN no.');
                    $('#pan_id').focus();
                } else if ($('#gst_id').val() !== '' && !gst.test($('#gst_id').val())) {
                    $('#gst_id_err').html("Invalid GST no.");
                    $('#gst_id').focus();
                } else if ($('#account_no').val() !== '' && ($('#account_no').val().length < 10 || $('#account_no')
                        .val().length > 16)) {
                    $('#account_no_err').html("invalid length");
                    $('#account_no').focus();
                } else {
                    document.getElementById('save_bank_details').submit();
                }
            }
        });
    </script>
@endsection

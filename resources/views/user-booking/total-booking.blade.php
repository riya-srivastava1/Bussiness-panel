@extends('business.layouts.common-business-dashboard')
@section('dashboard-active-tab', 'selected')
@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/dataTables.bs4-custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/buttons.bs.css') }}" />
    <style>
        .table td,
        .table th {
            font-size: 13px;
        }

    </style>
@endsection
@section('content')

    <!-- BEGIN .main-content -->
    <div class="main-content">
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card bg-white">
                    <div class="card-header">Completed Bookings </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center" id="userbookings_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Vendor details</th> --}}
                                    <th>Booking ID</th>
                                    <th>Services</th>
                                    <th>Appointment</th>
                                    <th>Amount</th>
                                    <th>Booked at</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- END: .main-content -->

@endsection


@section('scripts')
    <script src="{{ asset('zoy-asset/vendor/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('zoy-asset/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function() {
            $('#userbookings_table').DataTable({
                // dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: '{!! route('user.total.booking', $vendor_id) !!}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    // {
                    //     data: 'vendor_details',
                    //     name: 'vendor_details'
                    // },
                    {
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'services',
                        name: 'services'
                    },
                    {
                        data: 'datetime',
                        name: 'datetime'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ],
                'columnDefs': [{
                    'targets': [0],
                    /* column index */
                    'orderable': false,
                    /* true or false */

                }]
            });
        });
    </script>
@endsection

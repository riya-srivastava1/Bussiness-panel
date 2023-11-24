@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/dataTables.bs4-custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('zoy-asset/vendor/datatables/buttons.bs.css') }}" />
    <style>
        .table td {
            font-size: 13px;
        }
    </style>
@endsection

@section('content')
    <div id="content" class="app-content">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card bg-white">
                <div class="card-header">Services


                    @if (empty($edit_permission) || $edit_permission == 'Write')
                        <a href="{{ route('export.vendor.service') }}" class="btn btn-info ml-3 btn-sm rounded">Download
                            Services</a>
                        <span class="float-right">
                            <a href="{{ route('vendor.service.create') }}" class="btn btn-success">Add Services</a>
                        </span>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="vendorservices_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category > Service | Package</th>
                                    <th>Service Name</th>
                                    <th>Sub service</th>
                                    <th>Duration</th>
                                    <th>Available For</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Discount Valid</th>
                                    <th>Net amount</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Status | Actions</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" id="confirmModal">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header custom-heading">
                        <h4 class="modal-title text-white">Confirmation</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5 style="margin:0;text-align: center">Are you sure you want to remove this data?</h5>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('zoy-asset/vendor/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('zoy-asset/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>


    <script>
        $(function() {
            $('#vendorservices_table').DataTable({
                // dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: "{!! route('business.dashboard.services') !!}",
                // buttons: [
                // 	'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'category_or_service_type_name',
                        name: 'category_or_service_type_name'
                    },
                    {
                        data: 'service_or_package_name',
                        name: 'service_or_package_name'
                    },
                    {
                        data: 'sub_service_or_package_dis',
                        name: 'sub_service_or_package_dis'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'available_for',
                        name: 'available_for'
                    },
                    {
                        data: 'actual_price',
                        name: 'actual_price'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'discount_valid',
                        name: 'discount_valid'
                    },
                    {
                        data: 'discount_price',
                        name: 'discount_price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
            });
        });


        var service_id;

        $(document).on('click', '.delete', function() {
            service_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });
        $('#ok_button').click(function() {
            console.log("vendor/service/destroy/" + service_id);
            var base_url = $('meta[name="base_url"]').attr('content');
            $.ajax({
                url: base_url + "/vendor/service/destroy/" + service_id,
                beforeSend: function() {
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    console.log("ok");
                    console.log(data);
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#vendorservices_table').DataTable().ajax.reload();
                        alert('Data Deleted');
                    }, 1000);
                }
            })
        });
    </script>
@endsection

@extends('layouts.app')
@section('style')
    @php $data = Auth::guard('business')->user(); @endphp
    <!--breadcrumbs-->
    <style>
        .table td,
        .table th {
            font-size: 14px !important;
        }
    </style>
<link rel="stylesheet" href="{{ asset('zoy-asset/css/bootstrap.min.css') }}">

    @endsection

    @section('content')


    <!-- BEGIN .main-content -->

    <div id="content" class="app-content">

        <div class="col-12">
            @if (Session::has('success'))
                <div class="alert alert-danger alert-dismissible fade show text-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show text-danger" role="alert">
                    @foreach ($errors->all() as $err)
                        <p>{{ $err }}</p>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card bg-white">
                <div class="card-header">Manage Branches <span class="float-right"><a
                            href="{{ route('vendor.add.branch') }}" class="btn btn-success">Add a Branch</a></span>
                </div>

                <div class="card-body">
                    <table class="table table-bordered text-center" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch Name</th>
                                <th>Email</th>
                                <th>Primary Contact</th>
                                <th>Edit Permission</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branchs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->vendor_profile->business_name ?? '' }}
                                        <p class="small text-muted">{{ $item->vendor_profile->full_address ?? '' }}</p>
                                    </td>
                                    <td class="text-center"> {{ $item->email }}</td>
                                    <td class="text-center">{{ $item->owner_contact }}</td>
                                    <td>
                                        <form action="{{ route('vendor.branch.edit.permission') }}"
                                            id="edit_permission_form" method="post">
                                            @csrf
                                            <input type="hidden" name="vendor_id" value="{{ $item->vendor_id }}">
                                            @php $edit_permission = $item->vendor_profile->edit_permission ?? ''; @endphp
                                            <select class="form-control" name="edit_permission" id="edit_permission_select"
                                                required>
                                                <option value="">Select Editing permisssion</option>
                                                <option {{ $edit_permission == 'Read' ? 'selected' : '' }} value="Read">
                                                    Read</option>
                                                <option {{ $edit_permission == 'Write' ? 'selected' : '' }} value="Write">
                                                    Write</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('vendor.add.branch.login') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $item->email }}">
                                            <input type="hidden" name="password" value="{{ $item->show_password }}">
                                            <button type="submit" class="btn btn-link">Manage branch</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3tBEtsH0JPA8Hh-lbBphyfgZM5KY0Hko&libraries=places&callback=initMap"
        async defer></script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        $('#edit_permission_select').change(function() {
            var value = $(this).val();
            if (value && confirm('Are you sure you want to change ' + value + ' permission?')) {
                $('#edit_permission_form').submit();
            }
        });
    </script>
@endsection

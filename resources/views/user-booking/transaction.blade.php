@extends('business.layouts.common-business-dashboard')
@section('dashboard-active-tab','selected')
@section('styles')
 <style>
    .table td, .table th {
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
                <div class="card">

                    @if($latest_transaction && $latest_transaction->count())

                    <div class="card-header text-center">
                        <span style="font-size:130%">
                            Billing Statement from {{date('d-M-Y',strtotime($latest_transaction->start_week_date))}} TO {{date('d-M-Y',strtotime($latest_transaction->end_week_date))}}
                        </span>
                        <span class="float-right">
                            <a href="{{route('user.booking.show.transaction',$latest_transaction->vendor_id)}}" class="btn btn-primary float-right">Transaction Details</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="font-size: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Booking ID</th>
                                        <th>Services</th>
                                        <th>Wallet/Coupon</th>
                                        <th>Total collection</th>
                                        <th>Zoylee's  Comm. With GST</th>
                                        <th>Vendor's Earning</th>
                                        <th>Mode of Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latest_transaction->transactionHistory as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->booking_date}}</td>
                                        <td>{{$item->user_booking_id}}</td>
                                        <td>{{substr(trim($item->services),0,-1)}} </td>
                                        <td align="center">{{$item->wallet_amount}}/{{$item->coupon_amount}}</td>
                                        <td align="center">{{$item->net_amount}}</td>
                                        <td>{{$item->zoylee_commission_with_gst_amount}}</td>
                                        <td>{{$item->vendor_earning}}</td>
                                        <td>{{$item->pay_with==="online" ? 'Online' : 'Counter'}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td><strong>Rs. {{$latest_transaction->total_wallet_amount}}/{{$latest_transaction->total_coupon_amount}}</strong></td>
                                        <td><strong>Rs. {{$latest_transaction->total_collection}}</strong></td>
                                        <td><strong>Rs. {{$latest_transaction->total_zoylee_commission_with_gst_amount}}</strong></td>
                                        <td><strong>Rs. {{$latest_transaction->total_vendor_earning}}</strong></td>
                                        <td>
                                            <p>Online  - Rs. <strong>{{$latest_transaction->online_payment}}</strong></p>
                                            <p>Counter  - Rs. <strong>{{$latest_transaction->counter_payment}}</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td colspan="9" align="right"><a href="{{route('transaction.export.to.pdf',$latest_transaction->vendor_transaction_id)}}" class="btn btn-success btn-sm">Export to PDF</a></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @else
                    <h3 class="text-center">no record found..</h3>
                    @endif
                </div>
            </div>

                <hr>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    {{-- @if(count($cashPayment))
                    <div class="card-header">Offline Payment</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Booking Id(s)</th>
                                        <th>Date</th>
                                        <th>Services</th>
                                        <th>Zoylee Commission</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashPayment as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->order_id}}</td>
                                        <td>{{$item->booking_date}}</td>
                                        <td>
                                        <strong>1.Hair Cut Rs.100,</strong>
                                            ( commission 5% + TCS 1% Rs. 5, vendor Amount Rs. 95) <a href="#"><span class="icon-priority_high"></span></a>
                                        <br>
                                        <strong>2. Hair Color Rs. 200,</strong>
                                            (commission 10% + TDS 1% Rs. 23.6, Vendor Amount Rs. 176.4)<a href="#"><span class="icon-priority_high"></span></a>

                                        </td>
                                        <td align="center"><strong>28.6<br><span class="small">(5+23.6)</span></strong></td>
                                        <td align="center">
                                        <strong>271.4<br><span class="small">(95+176.4)</span></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total</strong></td>
                                        <td><strong>Rs. 33.6</strong></td>
                                        <td><strong>Rs. 366.4</strong></td>
                                    </tr>
                                    <tr>

                                        <td colspan="6" align="right"><a href="#" class="btn btn-success btn-sm">Export to PDF</a></td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @endif --}}
                </div>
            </div>

        </div>
        <!-- Row end -->
    </div>
    <!-- END: .main-content -->



@endsection

@section('scripts')


@endsection

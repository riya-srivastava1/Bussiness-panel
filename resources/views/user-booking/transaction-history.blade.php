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
                
                    @if($transactions && $transactions->count())
                    
                    <div class="card-header text-center row">
                        <div class="col-md-9">
                            <span style="font-size:130%">
                                Billing Statement from {{date('d-M-Y',strtotime($transactions->start_week_date))}} TO {{date('d-M-Y',strtotime($transactions->end_week_date))}}
                                <br>
                                Transaction id  - {{$transactions->vendor_transaction_id}}
                            </span>
                        </div>
                        
                        <div class="col-md-3">
                            <span class="float-right">
                                <a href="{{route('user.booking.show.transaction',$transactions->vendor_id)}}" class="btn btn-primary float-right">Transaction Details</a>    
                            </span>
                        </div>
                        
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
                                    @foreach ($transactions->transactionHistory as $item)
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
                                        <td><strong>Rs. {{$transactions->total_wallet_amount}}/{{$transactions->total_coupon_amount}}</strong></td>
                                        <td><strong>Rs. {{$transactions->total_collection}}</strong></td>
                                        <td><strong>Rs. {{$transactions->total_zoylee_commission_with_gst_amount}}</strong></td>
                                        <td><strong>Rs. {{$transactions->total_vendor_earning}}</strong></td>
                                        <td>
                                            <p>Online  - Rs. <strong>{{$transactions->online_payment}}</strong></p>
                                            <p>Counter  - Rs. <strong>{{$transactions->counter_payment}}</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td colspan="9" align="right"><a href="{{route('transaction.export.to.pdf',$transactions->vendor_transaction_id)}}" class="btn btn-success btn-sm">Export to PDF</a></td>
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

        </div>
        <!-- Row end -->
    </div>
    <!-- END: .main-content -->


    
@endsection

@section('scripts')
   
  
@endsection
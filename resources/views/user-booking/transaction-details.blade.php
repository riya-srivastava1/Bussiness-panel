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
                    
                    <div class="card-header text-center" style="font-size:150%"> 
                        {{-- <span style="font-size:130%">
                            Billing Statement from {{date('d-M-Y',strtotime($transactions->start_week_date))}} TO {{date('d-M-Y',strtotime($transactions->end_week_date))}}
                        </span>--}}

                        Transaction Details
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center" style="font-size: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Show</th>
                                        <th>Transaction id</th>
                                        <th>Wallet / Coupon amount</th>
                                        <th>Total collection</th>
                                        <th>Online payment</th>
                                        <th>Counter payment</th>
                                        <th>Zoylee's Comm. With GST</th>
                                        <th>Vendor's Earning</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a href="{{route('user.booking.show.transaction.history',$item->vendor_transaction_id)}}" title="Show Transaction History">
                                                <span class="icon-shareable text-success"></span>
                                            </a>
                                        </td>
                                        <td>{{$item->vendor_transaction_id}}</td>
                                        <td>{{$item->total_wallet_amount}} / {{$item->total_coupon_amount}}</td>
                                        <td>{{$item->total_collection}}</td>
                                        <td>{{$item->online_payment}}</td>
                                        <td>{{$item->counter_payment}}</td>
                                        <td>{{$item->total_zoylee_commission_with_gst_amount}}</td>
                                        <td>{{$item->total_vendor_earning}}</td>
                                        <td>
                                            {{date('d-M-Y',strtotime($item->start_week_date))}} <strong>To</strong><br/>
                                            {{date('d-M-Y',strtotime($item->end_week_date))}}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td colspan="2" >
                                            <div class="mx-auto">
                                                {{$transactions->links()}}
                                            </div>
                                        </td>
                                        <td colspan="4"></td>
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
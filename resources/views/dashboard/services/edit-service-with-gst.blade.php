@extends('business.layouts.common-business-dashboard') 
@section('dashboard-services-tab','selected')

@section('styles')
<link rel="stylesheet" href="{{asset('zoy-asset/vendor/bs-select/bs-select.css')}}" />
<style>
    input:focus,select:focus{
        outline: none !important;
        border: 0;
    }
    .display-none{
        display: none;
    }
    .pricing_panel_row input,.pricing_panel_row select{
        height: 30px;
        text-align: center;
    }
    .pricing_panel_row select{
        font-size: 100%;
    }.disable_pricing_panel_row input{
        border: 0px;
        text-align: center;
    }
</style>
@endsection

@section('content')


<!-- BEGIN .main-content -->
<div class="main-content">
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="col-12">
                @if (Session::has('success'))
                    <div class="alert alert-danger alert-dismissible fade show text-success" role="alert">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
                        {{Session::get('error')}}
                    </div>
                @endif
                @if ($errors ->any())
                    <div class="alert alert-warning alert-dismissible fade show text-danger" role="alert">
                        @foreach($errors ->all() as $err) 
                            <p>{{$err}}</p>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="card bg-white">
                <div class="card-header">Edit GST Services </div>
                <div class="card-body">
                    <form class="form-signin-services small" method="post" id="form-signin" action="{{route('vendor.service.update',$vendorService->id)}}" >
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="vendor_id" value="{{$vendorService->vendor_id}}"/>
                        <div class="form-row">
                            @if ("package"==$vendorService->type)
                                <div class="form-group col-md-4">
                                    <label for="select_service_type" class="col-form-label">Select Service Type</label>
                                    <select name="type" id="select_service_type" class="form-control rounded-0">
                                        <option value="service">Service</option>
                                        <option value="package" selected>Package</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 package_section">
                                    <label for="inputEmail4" class="col-form-label">Select Service</label>
                                    <select name="service_type_name" id="service_type_name" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Select Service</option>
                                        @if($serviceType)
                                        @foreach($serviceType as $item)
                                            <option value="{{$item->service_type_name}}" 
                                                {{$vendorService->service_type_name==$item->service_type_name?'selected':''}}>
                                                {{$item->service_type_name}}
                                            </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4 package_section ">
                                    <label for="inputEmail4" class="col-form-label">Package Category</label>
                                    <select name="package_category" id="package_category" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Select Package Category</option>
                                        <option {{$vendorService->package_category=="Bridal" ? 'selected' : ''}} value="Bridal">Bridal</option>
                                        <option {{$vendorService->package_category=="Trending" ? 'selected' : ''}} value="Trending">Trending</option>
                                        <option  {{$vendorService->package_category=="Traditional" ? 'selected' : ''}} value="Traditional">Traditional</option>
                                        <option  {{$vendorService->package_category=="Formal" ? 'selected' : ''}} value="Formal">Formal</option>
                                    </select>
                                </div>
        
                                <div class="form-group col-md-4 package_section ">
                                    <label for="package_name" class="col-form-label ">Package Name</label>
                                    <input type="text"  alt="package_name" value="{{$vendorService->package_name}}" name="package_name" class="form-control rounded-0" placeholder="Package Name"/>
                                </div>
        
                                <div class="form-group col-md-4 package_section ">
                                    <label for="package_description" class="col-form-label">Package Description</label>
                                    <textarea name="package_description" placeholder="Package Description" id="package_description" style="height: 38px" class="form-control rounded-0" cols="30" rows="1">{{$vendorService->package_description}}</textarea>
                                </div>
                            @else 
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4" class="col-form-label">Select Service</label>
                                    <select name="service_id" id="service_id" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Select Service</option>
                                        @if($serviceType)
                                        @foreach($serviceType as $ser)
                                        @if($ser->service && count($ser->service)>0)
                                            <optgroup label="{{$ser->category ? $ser->category->category_name : 'Unnamed'}} - {{$ser->service_type_name}}">
                                                @foreach ($ser->service as $item)
                                                    <option value="{{$item->id}}" {{$item->id==$vendorService->service_id ? 'selected' : ''}}>{{$item->service_name}}</option>
                                                @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4" class="col-form-label">Select sub Service</label>
                                    <input type="text" value="{{$vendorService->sub_service_name}}" name="sub_service_name" class="rounded-0 custom-select form-control" id="text_sub_service_name" placeholder="Enter Sub Service" list="sub_service_name" required/>
                                    <datalist  id="sub_service_name" >
                                    </datalist>
                                </div>
                            @endif
                            
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="col-form-label">SERVICE DURATION (in min) </label>
                                <input type="text" id="duration" value="{{$vendorService->duration}}" class="form-control rounded-0" name="duration" placeholder="Duration" required/>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4" class="col-form-label">AVAILABLE FOR </label>
                                <select name="available_for" id="available_for" class="form-control schedule-days h-80 f-90 rounded-0" required>
                                    <!-- <option value="Unisex" selected="selected">Unisex </option> -->
                                    <option value="Female" {{'Female'==$vendorService->available_for ? 'selected' :''}}>Female</option>
                                    <option value="Male" {{'Male'==$vendorService->available_for ? 'selected' :''}}>Male</option>
                                    <option value="Kids" {{'Kids'==$vendorService->available_for ? 'selected' :''}}>Kids</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="inputEmail4" class="col-form-label">Status</label>
                                <select name="status" id="status" class="form-control schedule-days h-80 f-90 rounded-0" required>
                                    <option value="true" selected="selected" {{true==$vendorService->status  ? 'selected' :''}}>Available</option>
                                    <option value="false"  {{false==$vendorService->status  ? 'selected' :''}}>Not Available</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin:10px 0px; background:#f1f1f1; padding:10px 10px;"><strong>Pricing Panel</strong></div>
                        
                        <div class="col-md-12">
                            <div class="row pricing_panel_row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">Your Section</div>
                                        <div class="card-body">
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="price" class="col-sm-4 col-form-label"><strong>Service Price</strong></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="actual_price" id="service_price" class="form-control rounded-0 number calculate_price" value="{{$vendorService->actual_price}}" style="border:1px solid #65e717;" required/>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount_type" class="col-sm-4 col-form-label"><strong>Discount Type</strong></label>
                                                <div class="col-sm-8">
                                                <select name="discount_type" id="discount_type" class="form-control rounded-0 calculate_price_change" style="border:1px solid #65e717;">
                                                    <option value="2" {{2==$vendorService->discount_type?'selected':''}}>Percentage</option>
                                                    <option value="1" {{1==$vendorService->discount_type?'selected':''}}>Flat</option>
                                                </select>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount" class="col-sm-4 col-form-label"><strong>Vendor Discount for User</strong></label>
                                                <div class="col-sm-8">
                                                <input type="text" name="discount" id="discount" class="form-control number calculate_price" placeholder="in %" value="{{$vendorService->discount}}" style="border:1px solid #65e717;">
                                                </div>
                                            </div>
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount" class="col-sm-4 col-form-label"><strong>Discount valid (days)</strong></label>
                                                <div class="col-sm-8">
                                                <input type="text" name="discount_valid" id="discount_valid" class="form-control number calculate_price" value="{{$vendorService->discount_valid}}" style="border:1px solid #65e717;">
                                                </div>
                                            </div>  

                                        </div>
                                    </div>
                                    <div class="card py-3">
                                        <div class="form-group row gutters px-3 mb-2">
                                            <label for="commission_on" class="col-sm-4 col-form-label"><strong>Commission On</strong></label>
                                            <div class="col-sm-8">
                                            <select name="commission_on" id="commission_on" class="form-control calculate_price_change" style="border:1px solid #65e717;">
                                                <option value="1" {{1==$vendorService->commission_on?'selected':''}}>With GST</option>
                                                <option value="2" {{2==$vendorService->commission_on?'selected':''}}>Without GST</option>
                                            </select>
                                            </div>
                                        </div>
                                    

                                        <div class="form-group row gutters px-3 mb-2">
                                            <label for="commission_type" class="col-sm-4 col-form-label"><strong>Zoylee Commission Type </strong></label>
                                            <div class="col-sm-8">
                                            <select name="commission_type" id="commission_type" class="form-control calculate_price_change" aria-readonly="false" style="border:1px solid #65e717;">
                                                {{-- <option value="1">Flat</option> --}}
                                                <option value="2" selected>Percentage</option>
                                            </select>
                                            </div>
                                        </div>
            

                                        <input type="hidden" name="commission_pass_on" id="commission_pass_on" class="form-control rounded-0 number calculate_price"  value="{{$vendorService->commission_pass_on}}" style="border:1px solid #65e717;">
                                        <input type="hidden" min="5" max="100" name="commission" id="commission" class="form-control rounded-0 number calculate_price"  value="{{$vendorService->commission}}" style="border:1px solid #65e717;">
                                       
                                    </div>
                                </div>
                                <div class="col-md-6 disable_pricing_panel_row">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">Final Calculations</div>
                                        <div class="card-body">
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="discount_amount" class="col-sm-6 col-form-label"><strong>Discount Amount</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="actual_discount_amount" id="discount_amount" class="form-control number"  value="{{$vendorService->actual_discount_amount}}" readonly>
                                                </div>
                                            </div>
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="after_dicount_price" class="col-sm-6 col-form-label"><strong>After Discount Price</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="after_discount_price"  value="{{$vendorService->after_discount_price}}" id="after_discount_price" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                                        
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="gst" class="col-sm-6 col-form-label"><strong>GST(18%)</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="gst"  value="{{$vendorService->gst}}" id="gst" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="pre_gst_amount" class="col-sm-6 col-form-label"><strong>Pre GST Amount</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="pre_gst_amount"  value="{{$vendorService->pre_gst_amount}}" id="pre_gst_amount" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="list_price" class="col-sm-6 col-form-label"><strong>List Price</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text"  value="{{$vendorService->list_price}}" name="list_price" id="list_price" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="zoylee_commission_in_rs" class="col-sm-6 col-form-label"><strong>Zoylee Commission in RS.</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="commission_amount" id="zoylee_commission_in_rs" class="form-control rounded-0"  value="{{$vendorService->commission_amount}}" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group row gutters px-3 mb-2">
												<label for="gst_on_zoylee_commission" class="col-sm-6 col-form-label"><strong>18% GST On Zoylee Commission</strong></label>
												<div class="col-sm-6">
												<input type="text" name="gst_on_zoylee_commission" id="gst_on_zoylee_commission" class="form-control rounded-0" value="{{$vendorService->gst_on_zoylee_commission}}" readonly>
												</div>
											</div>
                                            
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="vendor_earning" class="col-sm-6 col-form-label"><strong>Final Vendor Collection</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="final_vendor_collection" id="final_vendor_collaction" class="form-control rounded-0"  value="{{$vendorService->final_vendor_collection}}" readonly>
                                                </div>
                                            </div>
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="vendor_earning" class="col-sm-6 col-form-label"><strong>Vendor Earning</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="vendor_earning"  value="{{$vendorService->vendor_earning}}" id="vendor_earning" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="internet_charge" class="col-sm-6 col-form-label"><strong>Internet Charge (2%)</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="internet_charge"  value="{{$vendorService->internet_charge}}" id="internet_charge" class="form-control rounded-0" value="2" readonly>
                                                </div>
                                            </div>
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="internet_charge_in_rs" class="col-sm-6 col-form-label"><strong>Internet Charge in Rs.</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="internet_charge_amount"  value="{{$vendorService->internet_charge_amount}}" id="internet_charge_in_rs" class="form-control rounded-0" readonly>
                                                </div>
                                            </div>
                
                                            <div class="form-group row gutters px-3 mb-2">
                                                <label for="settlement_amount" class="col-sm-6 col-form-label"><strong>Settlement Amount</strong></label>
                                                <div class="col-sm-6">
                                                <input type="text" name="settlement_amount" id="settlement_amount" class="form-control rounded-0" style="color:green; font-weight:bold;"  value="{{$vendorService->settlement_amount}}" readonly>
                                                </div>
                                            </div>

                                            <input type="hidden" name="zoylee_net_income" id="zoylee_net_income" class="form-control rounded-0" style="color:green; font-weight:bold;"  value="{{$vendorService->zoylee_net_income}}" readonly/>
                                            <input type="hidden" name="zoylee_user_discount"  value="{{$vendorService->zoylee_user_discount}}" id="user_discount" class="form-control rounded-0" readonly>
                                            <input type="hidden" name="final_zoylee_income"  value="{{$vendorService->final_zoylee_income}}" id="final_zoylee_income" class="form-control rounded-0" style="color:green; font-weight:bold;" readonly>

                
                
                                            <div class="form-group col-md-8 text-right">
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-success margin-top-33">Save</button>
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
</div>
    <!-- Row end -->


@endsection

@section('scripts')
<script src="{{asset('zoy-asset/vendor/bs-select/bs-select.min.js')}}"></script>
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

    function calculate(){
        var servicePrice = $('#service_price').val();
        var discount = $('#discount').val();
        var discount_type = $('#discount_type').val();
        var discount_amount = $('#discount_amount').val();
        var commission_type = $('#commission_type').val();
        var commission = $('#commission').val();
        var commission_pass_on = $('#commission_pass_on').val();
        var commission_on = $('#commission_on').val();
        var pre_gst_amount = $('#pre_gst_amount').val();
        var discAmount, listPrice, commissionValue, gst_on_commision;
        var totalCal = 0;
        if(discount<0 || discount>100 || discount=="") {
            discount = 0;
            // $('#discount').val(0);
            // alert('Vendor discount field can not be less then 0, not greater then 100 and not blank!')
            $('#discount').focus();
        }

        if(commission=="") {
            $('#commission').val(5);
            // alert('Zoylee Commission field can not be blank!')
            $('#commission').focus();
        }

        if(commission_pass_on=="" || commission_pass_on>100) {
            $('#commission_pass_on').val(0);
            // alert('Commission pass-on field can not be blank or not greater then 100')
            $('#commission_pass_on').focus();
        }

        //Calculate after discount price
        if(discount_type==1){
            $('#discount_amount').val(discount);
            $('#after_discount_price').val((servicePrice-discount).toFixed(2));
        }
        else if(discount_type==2) {
            discAmount=servicePrice*discount/100;
            $('#discount_amount').val(discAmount);
            $('#after_discount_price').val((servicePrice-discAmount).toFixed(2));
            //
        }

        //Calculate Gst
        //Calculate gst
        var GST = $('#after_discount_price').val()*18/118;
        $('#gst').val(GST.toFixed(2));
        
        $('#pre_gst_amount').val(($('#after_discount_price').val()-$('#gst').val()).toFixed(2));

        listPrice = $('#after_discount_price').val();
        $('#list_price').val(listPrice);

        // if(commission==0) {
        //     $('#zoylee_commission_in_rs').val('0');
        //     $('#vendor_earning').val($('#pre_gst_amount').val());
        // }

        if(commission_type==2){
            if(commission!=0 && commission_on==1){
                commissionValue = listPrice*commission/100;
                $('#zoylee_commission_in_rs').val(commissionValue);
                var afterGstAmount = (listPrice-commissionValue)-(listPrice-commissionValue)*18/118;

                gst_on_commision = commissionValue*18/100;
                $('#gst_on_zoylee_commission').val(gst_on_commision.toFixed(2));
                totalCal = commissionValue + GST + gst_on_commision;
                var vendorEaring = listPrice-totalCal;
                $('#vendor_earning').val(vendorEaring.toFixed(2));
                
            }
            else{
                if(commission!=0 && commission_on==2){
                    commissionValue = $('#pre_gst_amount').val()*commission/100;
                    $('#zoylee_commission_in_rs').val(commissionValue.toFixed(2));
                    var afterGstAmount = (listPrice-commissionValue)-(listPrice-commissionValue)*18/118;
                    // $('#vendor_earning').val(afterGstAmount.toFixed(2));

                    gst_on_commision = commissionValue*18/100;
                    totalCal = commissionValue + GST + gst_on_commision;
                $('#gst_on_zoylee_commission').val(gst_on_commision.toFixed(2));

                    //      $('#zoylee_commission_in_rs').val(commission);
                    var vendorEaring = listPrice-totalCal;
                    $('#vendor_earning').val(vendorEaring.toFixed(2));
                    //$('#zoylee_net_income').val(commissionValue+gst_on_commision);
                   
                }
                
            }
        }

        var IntenetHandlingCharge = $('#after_discount_price').val() * 2/100;
        $('#internet_charge_in_rs').val(IntenetHandlingCharge.toFixed(2));

        var ZoyleeNetIncome = $('#zoylee_commission_in_rs').val()-IntenetHandlingCharge + gst_on_commision;
        $('#zoylee_net_income').val(ZoyleeNetIncome.toFixed(2));

        //Calculate user discount
        var z_commission = $('#zoylee_commission_in_rs').val();
        var commission_pass_on = $('#commission_pass_on').val();
        var u_d = z_commission*commission_pass_on/100;
        var totalSettlementAmount = parseFloat($('#vendor_earning').val()) + parseFloat($('#gst').val());

        $('#user_discount').val(u_d.toFixed(2));
        $('#final_zoylee_income').val(($('#zoylee_net_income').val()-$('#user_discount').val()-gst_on_commision).toFixed(2));
        $('#settlement_amount').val(totalSettlementAmount);
        $('#final_vendor_collaction').val($('#list_price').val());
    }
    //Calculation
    $('.calculate_price').keyup(function(){
        calculate();
    });
    $('.calculate_price_change').change(function(){
        calculate();
    });
   


    $('#category').change(function () {
        var id = $(this).val();
        if (id != null && id!="") {
            $.ajax({
                url: "",
                type: 'GET',
                data: { id: id },
                success: function (data) {
                    //alert(data); 
                    $('#vendor_service').html(data);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }else{
            $('#vendor_service').html("<option value=''>no record found! please select another category </option>");
        }
    });
    
    //cheange event of service
    $(document).on('change','#service_id',function(){
        var service_id = $(this).val();
        $('#text_sub_service_name').val('');
        $.ajax({
            type:'GET',
            data:{id:service_id},
            url:"{{route('get.sub.service.by.id')}}",
            success:function(data){
                $('#sub_service_name').html(data);
                // console.log(data);
            },error:function(){
                // alert("Error");
            }
        });
    });

    $('#select_service_type').change(function(){
        if('package'==$(this).val()){
            $('.package_section').removeClass('display-none');
            $('.service_section').addClass('display-none');
            $('.service_section input').val('');
            $('.service_section select').val('');
            $('.service_section textarea').val('');
        }else{
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


@extends('layouts.app')
@section('styles')
    <style type="text/css">
    .display-none {
        display: none;
    }
    .btn-disable-date-time{
        background: gray;
    }
    .btn-limit-time{
        background: #04a9b3;
    }
    </style>
@endsection
@section('dashboard-time-manage-tab','selected')
@php $data = Auth::guard('business')->user();
@endphp


@php
    $profileData = Auth::guard('business')->user();
    $currentDate =  date('d-m-Y');
    $endDate = date('d-m-Y', strtotime($currentDate. ' + 29 days'));
    $start = strtotime($currentDate);
    $end = strtotime($endDate);
    $openTime = (int)$profileData->vendor_profile->opening_time;
    $closeTime = (int)$profileData->vendor_profile->closing_time;
    $diffTime = $closeTime-$openTime;
    $zeroCounter = 0;
@endphp
@section('content')


<!-- BEGIN .main-content -->
<div class="main-content">
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card bg-white">
                <div class="card-header">Manage Date and Time
                    <span class="float-right color-palette">
                        <ul>
                            <li><span class="current"></span> Today</li>
                            <li><span class="active"></span> Active Tab</li>
                            <li><span class="current"></span> Enabled Date/Time</li>
                            <li><span class="disable"></span> Disabled Date/Time</li>
                            <li><span class="time"></span> Set Limit</li>
                        </ul>
                    </span>
                </div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-dark text-white">Date</div>
                                <div class="card-body text-center">
                                    <form method="post" id="date-action-form">
                                        @csrf
                                        <input  type="hidden" name="date" id="dateTxt" required/>
                                        <input class="btn display-none btn-sm" id="enableDisableDateBtn"  type="submit" value="">
                                    </form>
                                    <h4 class="font-weight-bold">@php echo date('F-Y') ;@endphp</h4>
                                    <div class="date-tab">
                                        @while ($start<=$end)
                                            @if(date('m', $start)>date('m') && date('d', $start)=='01')
                                            <hr class="border-dark">
                                            <h4>@php echo date('F-Y', $start) ;@endphp</h4>

                                            @endif
                                            <button  class="btn dateButton {{in_array(date('d-m-Y',$start), $disabledDate) ? 'btn-disable-date-time' : ''}}" {{in_array($start, $disabledDate) ? 'disabled' : ''}} value="{{date('d-m-Y', $start)}}">{{date('d', $start)}} </button>
                                            @php
                                                $currentDate  = date('d-m-Y', strtotime($currentDate. ' + 1 days'));
                                                $start = strtotime($currentDate);
                                            @endphp
                                        @endwhile
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    Time -
                                    <span class="dateLable" ></span>
                                </div>

                                <div class="card-body text-center right-side">
                                    <div class="time-tab">
                                    </div>
                                    {{-- @while ($zeroCounter<=$diffTime)
                                        <button href="#myModal" data-toggle="modal" value="{{$openTime}}"  class="btn timeButton">{!!$openTime>12 ? ($openTime==24 ? ($openTime-12).":00 am"  : ($openTime-12).":00 pm") : ($openTime==12 ? $openTime.":00 pm"  : ($openTime.":00 am"))!!} </button>
                                        @php
                                            $openTime+=1;
                                            $zeroCounter+=1;
                                        @endphp
                                    @endwhile --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->

</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Manage Time
                <small><strong class="pl-5">Date: <span class="dateLable"></span> </strong></small>
            </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>
                    {{-- Enable/Disable Time <strong>Date : <span class="dateLable"></span> </strong> <br/> --}}
                    <strong>Time: <span class="timeLable"></span> </strong>
                    <form method="post" id="time-action-form">
                        @csrf
                        <input  type="hidden" name="time"  id="timeTxt"/>
                        <input  type="hidden" name="date"  id="timeDate"/>
                        <input class="btn btn-sm" id="enableDisableTimeBtn"  type="submit" value="Disable/Enable">
                    </form>
                </p>
                <hr>
                <p>
                    Set Limit for Bookings <br><br>
                    {{-- <strong >Date: <span class="dateLable"></span> </strong>  --}}
                    <strong>Time: <span class="timeLable"></span> </strong>
                </p>
                <form method="post" class="form-horizontal" id="manage-time-action-form">
                    @csrf
                    <input  type="hidden" name="time"  id="manageTimeTxt"/>
                    <input  type="hidden" name="date"  id="manageTimeDate"/>
                    <input  type="number" name="limit" class="form-control rounded-0" id="numberOfCustomer" required min="1"  placeholder="Number Of Customer"/>
                    <input class="btn btn-outline-success rounded btn-sm my-2" id="manageDateTimeBtn"  type="submit" value="Save">
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $("#loading-wrapper").show();
    var base_url = $('meta[name="base_url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var defaultDate = $('.date-tab button:nth-child(2)').val();
    $('.dateLable').html(defaultDate);
    $('#dateTxt').val(defaultDate)
    $('#timeDate').val(defaultDate);
    $('#manageTimeDate').val(defaultDate);
    $.ajax({
        url:"{{route('vendor.get.time.shedule')}}",
        type:'GET',
        data:{date:$('.date-tab button:nth-child(2)').val()},
        success:function(data){
            $('.time-tab').html(data);
            $("#loading-wrapper").fadeOut();
        },
        error:function(err){
            console.log(err);
            $("#loading-wrapper").fadeOut();
        }
    });

    $(".left-side button").click(function(){
        $(".left-side button").removeClass('active zoom');
        $(this).addClass('active zoom');
    });
    $(".right-side button").click(function(){
        $(".right-side button").removeClass('active zoom');
        $(this).addClass('active zoom');
    });

    $('.dateButton').click(function(){
        var dateVal = $(this).val();
        if( $(this).hasClass('btn-disable-date-time')){
            $('.right-side').hide();
            $('#enableDisableDateBtn').val("Click To Enable");
            $('#enableDisableDateBtn').addClass("btn-success");
            $('#enableDisableDateBtn').removeClass("btn-danger display-none");
            $('#date-action-form').attr('action',"{{route('vendor.date.enable')}}");
        }
        else{
            $("#loading-wrapper").show();
            $('.right-side').show();
            $('#enableDisableDateBtn').val("Click To Disable");
            $('#enableDisableDateBtn').addClass("btn-danger");
            $('#enableDisableDateBtn').removeClass("btn-success display-none");
            $('#date-action-form').attr('action',"{{route('vendor.date.disabled')}}");
            $.ajax({
                url:"{{route('vendor.get.time.shedule')}}?"+new Date().getTime(),
                type:'get',
                data:{date:dateVal},
                success:function(data){
                    $("#loading-wrapper").fadeOut();
                    $('.time-tab').html(data);
                    //alert(data);
                },
                error:function(){
                    $("#loading-wrapper").fadeOut();
                    // alert("errr");
                }
            });
        }
        // alert(dateVal);
        $('#dateTxt').val(dateVal)
        $('#manageTimeDate').val(dateVal);
        $('.dateLable').html(dateVal);
        $('#timeDate').val(dateVal);

    });

    $(document).on("click",".timeButton",function() {
        var timeVal = $(this).val();
        if($('#manageTimeDate').val()==""){
            alert("Please Select date first");
            return false;
        }
        $('#manageTimeTxt').val(timeVal);
        $('#timeTxt').val(timeVal);
        var conTimeVal;
        if(timeVal>=12){
            if(timeVal==12){
                conTimeVal = "12:00 pm"
            }
            else if(timeVal==24){
                conTimeVal = "12:00 am"
            }
            else{
                conTimeVal = timeVal-12+":00 pm";
            }
        }else{
            conTimeVal = timeVal+":00 am";
        }
        $('.timeLable').html(conTimeVal);

        if( $(this).hasClass('btn-disable-date-time')){
            $('#enableDisableTimeBtn').val("Click To Enable");
            $('#enableDisableTimeBtn').addClass("btn-success");
            $('#enableDisableTimeBtn').removeClass("btn-danger");
            $('#time-action-form').attr('action',"{{route('vendor.time.enable')}}");

        }
        else{
            $('#enableDisableTimeBtn').val("Click To Disable");
            $('#enableDisableTimeBtn').addClass("btn-danger");
            $('#enableDisableTimeBtn').removeClass("btn-success");
            $('#time-action-form').attr('action',"{{route('vendor.time.disabled')}}");
            $('#manage-time-action-form').attr('action',"{{route('vendor.date.enable')}}");
        }
        if($(this).hasClass('btn-limit-time')){
            $('#numberOfCustomer').val($(this).attr('id'));
            $('#manageDateTimeBtn').val('Update');
            $('#manage-time-action-form').attr('action',"{{route('vendor.manage.customer.update')}}");
        }else{
            $('#numberOfCustomer').val($(this).attr('id'));
            $('#manage-time-action-form').attr('action',"{{route('vendor.manage.customer.store')}}");
        }
    });

</script>

@endsection

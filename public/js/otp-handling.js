var base_url = $('meta[name="base_url"]').attr('content');
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


$('.change-num').click(function(e){
    e.preventDefault();
    console.log("Change number");
    $('.signup-phone').attr('readonly',false);
    $('.signup-phone').focus();
});
function signUpSenOTP(){
    console.log("signup send OTP");
    var phone = $('.signup-phone').val();
    // $('.signup-resend-spinner').removeClass('display-none');
    $('.signup-resendOTP').attr('disabled',true);
    $('.signup-OTPERROR').html('');
    console.log(phone);
    $.ajax({
        type:'GET',
        url:base_url+'/sendOtp',
        data:{phone:phone},
        success:function(data){
            try {
                data = JSON.parse(data);
            } catch (error) {
                data = data;
            }
            console.log(data);
            // console.log(data.status);
            if(data.status==="success"){
                setTimeout(function(){ $('.signup-resendOTP').attr('disabled',false); $('.signup-resend-spinner').addClass('display-none');
                 }, 30000);
                $('.signup-phone-btn').html('Send OTP');
                $('.signup-OTPSection').removeClass('display-none');
            }
            else{
                // $('.signup-OTPSection').removeClass('display-none');
                $('.signup-success').html(data.msg);
                $('.signup-success').addClass("text-danger");
                $('.signup-phone-btn').html('Send OTP');
            }
        },
        error:function(err){
            console.log(err);
        }
    });
}

$('.signup-phone-btn').bind({
    click: function() {
        $('.signup-success').html('');
        // console.log("blur");
        // console.log($('#otpStatus').val());
        // if($(this).val().length===10 && $('#otpStatus').val()==='null'){
        if($('.signup-phone').val().length===10 && $('#otpStatus').val()==='null'){
            // console.log("blur");
            $(this).html("Sending..");
            signUpSenOTP();
            $(this).attr('readonly',true);
        }
    }
});

$(".signup-sendOTP").bind({
    click: function() {
        console.log("Click");
        signUpSenOTP();
    },
});

$('.signup_btn').click(function(e){
    if($('#otpStatus').val()==='null'){
        e.preventDefault();
        // $('.signup-phone').focus();
        $('.change-num').html('Verify number first');
        alert("Verify number first");
    }
});


$('#signup-partitioned').keyup(function(){
    $('.signup-OTPERROR').html('');
   if($(this).val().length===4){
       $('#signup-partitioned').attr('diasbled',true);
       console.log($(this).val());
       var otp = $(this).val();
       var phone = $('.signup-phone').val();
      $.ajax({
          type:'GET',
          url:`${base_url}/verifyOtp`,
          data:{phone:phone,otp:otp,part:"signup"},
          success:function(data){
            // data = JSON.parse(data);
            console.log(data); 
            if(data.status){
                $('.signup-OTPERROR').addClass('text-success');
                $('.signup-OTPERROR').removeClass('text-danger');
                $('.signup-OTPERROR').html(data.msg);
                $('.signup-success').addClass('text-success');
                $('.signup-success').html(data.msg);
                $('#signup-partitioned').attr('diasbled',false);
                // window.open(`${base_url}/list?category=Salon`,'_self');
                $('#otpStatus').val(true);
                $('.signup-OTPSection').addClass('display-none');
                $('.signup-password-section').removeClass('display-none');
            }else{
                $('.signup-OTPERROR').removeClass('text-success');
                $('.signup-success').removeClass('text-success');
                $('.signup-OTPERROR').addClass('text-danger');
                $('.signup-OTPERROR').html(data.msg);
                $('#signup-partitioned').attr('diasbled',false);
            }
          },
          error:function(err){
            console.log(err);
          }
      }); 
   }
});
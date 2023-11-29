var base_url = $('meta[name="base_url"]').attr('content');
var notifyAudio = new Audio(`${base_url}/plucky.mp3`);
var match = new Array();

$(document).on('click','.confirm-btn',function(e){
    e.preventDefault();
    //  alert("test");
    $(this).prop('disabled',true);
    var data = $(this).attr('id');
    // console.log(data);
    data = JSON.parse(data);
    notification_id = data.notification_id;
    device_token = data.device_token;
    // console.log(`device token : ${device_token}`);
    if($(this).hasClass('mobile')){
        $.ajax({
          type:'GET',
          data:{notification_id:notification_id,device_token:device_token},
          url:`${base_url}/confirm/mobile/request`,
          success:function(data){
            console.log("Mobile");
            // console.log(data);
            // console.log(`device token : ${device_token}`);
            if(data==="success"){
              //  alert('confirm');
            }
          },
          error:function(err){
              //alert(err);
          }
      });
    }else{
      console.log('web');
        $.ajax({
          type:'GET',
          data:{notification_id:notification_id},
          url:`${base_url}/confirm/request`,
          success:function(data){
            if(data==="success"){
              //  alert('confirm');
            }
          },
          error:function(err){
              //alert(err);
          }
      });
    }
    
});


$(document).on('click','.reject-btn',function(e){
    e.preventDefault();
    $(this).prop('disabled',true);
    //  alert("test");
    // reject/mobile/request
    var data = $(this).attr('id');
    // console.log(data);
    data = JSON.parse(data);
    notification_id = data.notification_id;
    device_token = data.device_token;
    // console.log(`device token : ${device_token}`);
    if($(this).hasClass('mobile')){
        console.log('mobile');
          $.ajax({
            type:'GET',
            data:{notification_id:notification_id,device_token:device_token},
            url:`${base_url}/reject/mobile/request`,
            success:function(data){
              // console.log(data);
              if(data==="success"){
                // alert('reject');
              }
            },
            error:function(err){
               console.log(err);
            }
        });
    }else{
      console.log('web');
      $.ajax({
        type:'GET',
        data:{notification_id:notification_id},
        url:`${base_url}/reject/request`,
        success:function(data){
           if(data==="success"){
            // alert('reject');
           }
        },
        error:function(err){
            //alert(err);
        }
    });
    }
});

function convertTime(time) {
    var conTime;
    if (time >= 12) {
      if (time === 12) {
        conTime = "12:00 pm";
      } else if (time === 24) {
        conTime = "12:00 am";
      } else {
        conTime = time - 12 + ":00 pm";
      }
    } else {
      conTime = time + ":00 am";
    }
    return conTime;
};


function outNotify(match){
  _.forEach(match,(value)=>{
    var i = 90;
    var setIntr = setInterval(function(){
      $(`#${value} small`).html(i);
      i--;
    },1000); 
    setTimeout(function(){
      clearInterval(setIntr);
      $(`#${value}`).fadeOut();
    },90000);
  });
}

 
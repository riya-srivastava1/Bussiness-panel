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

$("#max_capcity").keyup(function() {
  //  alert($("#mix_capcity").val());
  if (parseInt($(this).val()) < parseInt($("#min_capcity").val())) {
    $("#alertmaxcapcity").show();
  } else {
    $("#alertmaxcapcity").hide();
  }
});

$("#min_capcity").keyup(function() {
  //  alert($("#mix_capcity").val());
  if (parseInt($(this).val()) > parseInt($("#max_capcity").val())) {
    $("#alertmaxcapcity").show();
  } else {
    $("#alertmaxcapcity").hide();
  }
});

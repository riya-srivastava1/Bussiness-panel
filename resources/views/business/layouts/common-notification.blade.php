<script>
    $("#add_serive").click(function(e){
        e.preventDefault();
        $("#Showaddservie").slideToggle("slow");
    });
    
    @if(Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ Session::get('success') }}",
            showConfirmButton: true,
            timer: 30000
        });
    @endif

    @if(Session::has('info'))
        Swal.fire({
            icon: 'info',
            title: "{{ Session::get('info') }}",
            showConfirmButton: true,
            timer: 30000
        });
    @endif

    @if(Session::has('warning'))
        Swal.fire({
            icon: 'warning',
            title: "{{ Session::get('warning') }}",
            showConfirmButton: true,
            timer: 30000
        });
    @endif

    @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: "{{ Session::get('error') }}",
            showConfirmButton: true,
            timer: 30000
        });
    @endif

    @if ($errors ->any())
      var msg = '';
      @foreach($errors ->all() as $err) 
       msg +="{{$err}}"; 
      @endforeach
        Swal.fire({
            icon: 'error',
            text:msg,
            showConfirmButton: true,
            timer: 30000
        });
       
    @endif

    $('.msg-body-modal').click(function(){
     $(this).css({'background-color':'rgba(0,0,0,0.0)','height':'auto'});
  });
</script>
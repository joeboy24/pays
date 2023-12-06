
@extends('layouts.app')

@section('header_text')
  <div class="header_top_col">
    <p class="logo_text1"><i class="fa fa-unlock-alt" style="font-size:1.4em"></i>&nbsp; MASLOC<b class="logo_text2"></b></p>
  </div>
@endsection

@section('main_content')

  <div class="login_body">

  </div>

    <div class="login_body2">

      {{-- <div class="lock_container">
        <img class="logo_top" src="https://www.pngall.com/wp-content/uploads/4/Web-Security-Shield-PNG.png" alt="logo">
      </div> --}}


      <section class="login_content">
        @if (session('check_otp_redirect') == 'verified')
          <div class="otp_top">
            <img class="otp_logo" src="https://www.pngall.com/wp-content/uploads/4/Web-Security-Shield-PNG.png" alt="logo">
            <h4>Verification</h4>
            <p>Account has been verified</p>
            <div class="alert alert-success">
                Page will auto redirect soon...
            </div>
          </div>
          <form>
            @csrf

            <div class="login_btn_container">
              <a href="/otp-verification"><button type="button" class="login_btn3"><i class="fa fa-chevron-left"></i>&nbsp; Back</button></a>
            </div>
            <p class="cent_p">Didn't receive the verification SMS? <button class="my_trash_small bg8 color2">Resend OTP</button></p>
            <p>&nbsp;</p>
          </form>

          <script>
            window.setTimeout(function(){
              window.location.href = "/";
              // window.location.href = "https://www.google.co.in";
            }, 2000);
          </script>
        @else
          {{-- <p>SMS: {{session('otp_sms_count').' - '.session('otp_try_count')}} :Try</p> --}}
          <div class="otp_top">
            <img class="otp_logo" src="https://www.pngall.com/wp-content/uploads/4/Web-Security-Shield-PNG.png" alt="logo">
            <h4>Verification</h4>
            <p>We've sent you a OTP via SMS</p>
            @include('inc.messages')
          </div>
          <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf

            <input placeholder="****" id="password" type="password" maxlength="4" class="@error('password') is-invalid @enderror otp_input" name="temp_pass" required>
            
            <div class="login_btn_container">
              <button type="submit" name="store_action" value="verify_otp" class="login_btn3">Verify</button>
            </div>
            <p class="cent_p">Didn't receive the verification SMS? 
              <a href="/otp-resend"><button type="button" name="store_action" value="send_new_otp" class="my_trash_small bg8 color2">Resend OTP</button></a>
              <!--button type="submit" name="store_action" value="send_new_otp" class="my_trash_small bg8 color2">Resend OTP</button>
              <button class="my_trash_small bg8 color2" onclick="return alert('Oops..! Limited SMS bundle')">Resend OTP</button-->
            </p>
            <p>&nbsp;</p>
          </form>
        @endif

        @if (session('check_otp_redirect') == 1)
          <script language="JavaScript" type="text/JavaScript" >
            function send_with_ajax( the_url ){
                var httpRequest = new XMLHttpRequest();
                httpRequest.onreadystatechange = function() { alertContents(httpRequest); };  
                httpRequest.open("GET", the_url, true);
                httpRequest.send(null);
            }
          </script>

          <script language="javascript" type="text/javascript">   
            // alert ('sent')
            send_with_ajax("https://apps.mnotify.net/smsapi?key=EDjbRLUSSIfwfGV9gar4kmi8n&to=<?php echo auth()->user()->contact; ?>&msg=Your OTP is <?php echo session('phold'); ?>&sender_id=MASLOC-GH");
          </script>
        @endif
      </section>

    </div>


@endsection

    
  
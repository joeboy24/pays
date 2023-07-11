
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
        
        <div class="otp_top">
          <img class="otp_logo" src="https://www.pngall.com/wp-content/uploads/4/Web-Security-Shield-PNG.png" alt="logo">
          <h4>Verification</h4>
          <p>Account has been disabled</p>
          <div class="alert alert-danger">
              Try again after 5 minutes
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
        
      </section>

    </div>


@endsection

    
  
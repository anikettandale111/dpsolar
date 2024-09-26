@extends('frontend.front')
@section('title', 'Register')
@section('content')
<section class="section" style="margin-top: 7rem;">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Register</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}" id="register_form">
              @csrf
              @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <div class="row">
                <div class="form-group col-6">
                  <label for="first_name">First Name<span class="required">*</span></label>
                  <input id="first_name" type="text" class="form-control" name="first_name" value="{{old('first_name')}}" autofocus required autocomplete="off">
                  <span class="invalid-feedback error"></span>
                </div>
                <div class="form-group col-6">
                  <label for="last_name">Last Name<span class="required">*</span></label>
                  <input id="last_name" type="text" class="form-control" name="last_name" value="{{old('last_name')}}" autofocus required autocomplete="off">
                  <span class="invalid-feedback error"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email<span class="required">*</span></label>
                <input id="email" type="email" class="form-control" name="email" value="{{old('email')}}" required autocomplete="off">
                <span class="invalid-feedback error"></span>
              </div>
              <div class="form-group">
                <label for="mobile_num">Mobile<span class="required">*</span></label>
                <input id="mobile_num" type="text" class="form-control" name="mobile_num" value="{{old('mobile_num')}}" required autocomplete="off">
                <span class="invalid-feedback error"></span>
              </div>
              <div id="loader" style="display: none;">
                <div class="spinner"></div>
              </div>
              <div class="form-group otp_div" style="display: none;">
                <label for="mobile_otp">OTP<span class="required">*</span></label>
                <input id="mobile_otp" type="text" class="form-control" name="mobile_otp">
                <span class="invalid-feedback error"></span>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label for="password" class="d-block">Password<span class="required">*</span></label>
                  <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required autocomplete="new-password">
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <div class="form-group col-12">
                  <label for="password2" class="d-block">Confirm Password<span class="required">*</span></label>
                  <input id="password2" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  <span class="invalid-feedback error"></span>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg btn-block">
                  Register
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    var APP_URL = $('#app-url').attr("content");
    var ajaxSent = false;
    var ajaxSentTwo = false;
    // Hide the OTP div initially
    $('.otp_div').hide();
    $('#mobile_num').keyup(function() {
      var myInputValue = $(this).val();
      if (myInputValue.length !== 10) {
        // Show error message if the mobile number is not 10 digits
        $(this).siblings('span').text('Mobile Number should be 10 digits').show();
      } else {
        // Clear the error message
        $(this).siblings('span').text('').hide();
        // Call AJAX function if number is 10 digits
        showLoader();
        numsendajax(myInputValue);
      }
    });
    $('#mobile_otp').keyup(function() {
      var myInputValue = $(this).val();
      var mb_num = $('#mobile_num').val();
      var mb_otp = $('#mobile_otp').val();
      if (myInputValue.length !== 6) {
        // Show error message if the mobile number is not 10 digits
        $(this).siblings('span').text('OTP should be 6 digits').show();
      } else {
        // Clear the error message
        $(this).siblings('span').text('').hide();
        // Call AJAX function if number is 10 digits
        showLoader();
        if (mb_num != null && mb_otp !== null) {
          verifysendajax(mb_num, mb_otp);
        }
      }
      return false;
    });

    function numsendajax(phone) {
      if (!ajaxSent) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: APP_URL + "/getotp",
          data: {
            'mobile_num': phone,
            'first_name': $('#first_name').val(),
            'last_name': $('#last_name').val(),
          },
          type: 'get',
          dataType: 'json',
          success: function(response) {
            // Show the OTP div on successful response
            $('.otp_div').show();
            ajaxSent = true;
            hideLoader();
          },
          error: function(xhr, status, error) {
            // Handle errors here
            console.log('Error:', error);
          }
        });
      }
    }


    $('#submitBtn').click(function(e) {
      e.preventDefault(); // Prevent the default form submission
      var first_name = $('#first_name').val().trim();
      var last_name = $('#last_name').val().trim();
      var mb_num = $('#mobile_num').val().trim();
      var mb_otp = $('#mobile_otp').val().trim();
      var password = $('#password').val().trim();
      var confirmPassword = $('#password2').val().trim();
      var email = $('#email').val().trim();
      if (first_name == '' && last_name == '') {
        toastr.error('Name field required');
        return false;
      }
      if (isValidEmail(email)) {} else {
        toastr.error('Empty OR Invalid Email-ID entered');
        return false;
      }
      // Check if password and confirm password match
      if (password !== '' && password === confirmPassword) {
        $('#password2').siblings('.error').hide(); // Hide error message
        // $('#register_form').submit(); // Submit the form
      } else {
        toastr.error('Confirm Password should be the same as Password');
        $('#password2').siblings('.error').text('Confirm Password should be the same as Password').show(); // Show error message
        return false;
      }
      if (!ajaxSentTwo) {
        if (mb_num !== '' && mb_otp !== '') {
          verifysendajax(mb_num, mb_otp);
          ajaxSentTwo = true; // Mark AJAX as sent
        } else {
          toastr.error('* marked fields are required.');
          return false; // Stop further execution if mobile number or OTP are missing
        }
      }
      $('#register_form').submit();
    });
    // Function to check if the email is in valid format
    function isValidEmail(email) {
      var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return emailPattern.test(email);
    }

    function verifysendajax(mb_num, mb_otp) {
      if (mb_num != null && mb_otp !== null) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: APP_URL + "/verifyotp",
          data: {
            'mobile_num': mb_num,
            'mobile_otp': mb_otp,
          },
          type: 'get',
          dataType: 'json',
          success: function(response) {
            ajaxSentTwo = true;
            hideLoader();
            $('.otp_div').hide();
            // if ($('#password').val() != '' && ($('#password').val() == $('#password2').val())) {
            //   $('#register_form').submit();
            // }
          },
          error: function(xhr, status, error) {
            console.log('Error:', error);
          }
        });
      }
    }
  });

  function showLoader() {
    $('#loader').show();
  }

  function hideLoader() {
    $('#loader').hide();
  }
</script>
@endpush
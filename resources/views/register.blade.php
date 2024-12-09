@extends('front.layouts.layout')

@section('content')
  
        <div class="elite-register">
            <div class="container">
                <div class="row elite-register-inner">

                    <div class="signup-inner-content">
                    @if(session()->has("success"))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ session()->get("success") }} </strong>
                    </div>
                    @elseif(session()->has("error"))
                    <div class="alert alert-warning" role="alert">
                        <strong>{{ session()->get("error") }} </strong>
                    </div>
                    @endif

                        <div class="form-register">
                            <h5>Register a new account</h5>
                            <p>Please log in to your account</p>
                            <form class="pt-3" method="POST" action="{{route('signup')}}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" name="first_name" maxlength="60" required/>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email_id" maxlength="60" required/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="60" required/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password" name="password_confirmation" maxlength="60" required/>
                                <p id="error_password" style="color:red; display:none;">Password and Confirm Password do not match!</p>
                            </div>
                            <!-- <div class="form-group">
                                <select name="" id="">
                                    <option value="1">User</option>
                                    <option value="2">Merchent(Guru)</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputNumber1" placeholder="Mobile Number" name="number_field"  maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required/>
                            </div>

                            <!--div-- class="form-check">
                                <label class="form-check-label text-muted"> <input type="checkbox" class="form-check-input" name="terms" />Remember me <i class="input-helper"></i></label>
                            </!--div-->

                            <div class="mt-3 d-grid gap-2">
                                <input type="submit" value="Sign Up" class="btn btn-block btn-lg font-weight-medium auth-form-btn" />
                            </div>

                            <p class="already-account">Already have an account? <a href="{{ url('login') }}">Sign In</a></p>

                            <!--a href="#" class="continue">Or Continue with</!--a>

                            <div-- class="three-btn">
                                <a href="#"><img class="one" src="https://votivelaravel.in/tailor_hub/public/web/images/one.svg" /></a>
                                <a href="#"><img class="three" src="https://votivelaravel.in/tailor_hub/public/web/images/three.svg" /></a>
                                <a href="#"><img class="two" src="https://votivelaravel.in/tailor_hub/public/web/images/two.svg" /></a>
                            </div-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#exampleInputPassword2').on('input', function () {
            const password = $('#exampleInputPassword1').val();
            const confirmPassword = $(this).val();
            const errorMessage = $('#error_password');

            if (password !== confirmPassword) {
                errorMessage.show(); // Show error message
            } else {
                errorMessage.hide(); // Hide error message
            }
        });
        </script>

        @endsection
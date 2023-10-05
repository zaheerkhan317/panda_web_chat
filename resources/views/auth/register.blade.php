<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.2/firebase-database.js"></script>

@extends('layouts.app')

@section('content')

<style>
.popup {
    position: fixed;
    top: 0%;
    left: 50%;
    transform: translate(-50%);
    padding: 10px 20px;
    background-color: rgba(0, 255, 0, 0.8);
    border-radius: 5px;
    color: white;
    text-align: center;
    z-index: 9999;
    display: none;
    width: 50%;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <div class="popup alert alert-danger" id="error" style="display: none;"></div>
                    <div class="popup alert alert-success" id="sentSuccess" style="display: none;"></div>
                    <div class="popup alert alert-success" id="successRegister" style="display: none;"></div>
                    
                      

                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                            <label for="phone_country_code" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                    <select id="phone_country_code" class="form-control" name="phone_country_code" required onchange="validatePhoneNumber()">
                                        <option value="">Select Country Code</option>
                                        <option value="+1">+1 (USA)</option>
                                        <option value="+91">+91 (India)</option>
                                        <option value="+44">+44 (United Kingdom)</option>
                                        <option value="+61">+61 (Australia)</option>
                                        <option value="+86">+86 (China)</option>
                                        <option value="+33">+33 (France)</option>
                                        <option value="+49">+49 (Germany)</option>
                                        <option value="+81">+81 (Japan)</option>
                                        <option value="+7">+7 (Russia)</option>
                                        <option value="+82">+82 (South Korea)</option>
                                        <option value="+39">+39 (Italy)</option>
                                        <option value="+34">+34 (Spain)</option>
                                        <option value="+52">+52 (Mexico)</option>
                                        <option value="+55">+55 (Brazil)</option>
                                        <option value="+971">+971 (United Arab Emirates)</option>
                                        <option value="+966">+966 (Saudi Arabia)</option>
                                        <option value="+20">+20 (Egypt)</option>
                                        <option value="+27">+27 (South Africa)</option>
                                        <option value="+65">+65 (Singapore)</option>
                                        <option value="+60">+60 (Malaysia)</option>
                                        <option value="+1">+1 (Canada)</option>
                                        <option value="+54">+54 (Argentina)</option>
                                        <option value="+32">+32 (Belgium)</option>
                                        <option value="+55">+55 (Brazil)</option>
                                        <option value="+57">+57 (Colombia)</option>
                                        <option value="+45">+45 (Denmark)</option>
                                        <option value="+20">+20 (Egypt)</option>
                                        <option value="+358">+358 (Finland)</option>
                                        <option value="+33">+33 (France)</option>
                                        <option value="+49">+49 (Germany)</option>
                                        <option value="+30">+30 (Greece)</option>
                                        <option value="+852">+852 (Hong Kong)</option>
                                        <option value="+36">+36 (Hungary)</option>
                                        <option value="+62">+62 (Indonesia)</option>
                                        <option value="+353">+353 (Ireland)</option>
                                        <option value="+972">+972 (Israel)</option>
                                        <option value="+39">+39 (Italy)</option>
                                        <option value="+81">+81 (Japan)</option>
                                        <option value="+965">+965 (Kuwait)</option>
                                        <option value="+961">+961 (Lebanon)</option>
                                        <option value="+60">+60 (Malaysia)</option>
                                        <option value="+52">+52 (Mexico)</option>
                                        <option value="+31">+31 (Netherlands)</option>
                                        <option value="+64">+64 (New Zealand)</option>
                                        <option value="+234">+234 (Nigeria)</option>
                                        <option value="+47">+47 (Norway)</option>
                                        <option value="+92">+92 (Pakistan)</option>
                                        <option value="+63">+63 (Philippines)</option>
                                        <option value="+48">+48 (Poland)</option>
                                        <option value="+351">+351 (Portugal)</option>
                                        <option value="+974">+974 (Qatar)</option>
                                        <option value="+7">+7 (Russia)</option>
                                        <option value="+966">+966 (Saudi Arabia)</option>
                                        <option value="+65">+65 (Singapore)</option>
                                        <option value="+27">+27 (South Africa)</option>
                                        <option value="+34">+34 (Spain)</option>
                                        <option value="+46">+46 (Sweden)</option>
                                        <option value="+41">+41 (Switzerland)</option>
                                        <option value="+971">+971 (United Arab Emirates)</option>
                                        <option value="+44">+44 (United Kingdom)</option>
                                        <option value="+598">+598 (Uruguay)</option>
                                        <option value="+58">+58 (Venezuela)</option>
                                        <option value="+84">+84 (Vietnam)</option>
                                        <option value="+967">+967 (Yemen)</option>
                                        <option value="+260">+260 (Zambia)</option>
                                        <option value="+263">+263 (Zimbabwe)</option>
                                        <option value="+93">+93 (Afghanistan)</option>
                                        <option value="+355">+355 (Albania)</option>
                                        <option value="+213">+213 (Algeria)</option>
                                        <option value="+376">+376 (Andorra)</option>
                                        <option value="+244">+244 (Angola)</option>
                                        <option value="+1264">+1264 (Anguilla)</option>
                                        <option value="+1268">+1268 (Antigua & Barbuda)</option>
                                        <option value="+54">+54 (Argentina)</option>
                                        <option value="+374">+374 (Armenia)</option>
                                        <option value="+297">+297 (Aruba)</option>
                                        <option value="+61">+61 (Australia)</option>
                                        <option value="+43">+43 (Austria)</option>
                                        <option value="+994">+994 (Azerbaijan)</option>
                                        <option value="+1242">+1242 (Bahamas)</option>
                                        <option value="+973">+973 (Bahrain)</option>
                                        <option value="+880">+880 (Bangladesh)</option>
                                        <option value="+1246">+1246 (Barbados)</option>
                                        <option value="+375">+375 (Belarus)</option>
                                        <option value="+32">+32 (Belgium)</option>
                                        <option value="+501">+501 (Belize)</option>
                                        <option value="+229">+229 (Benin)</option>
                                        <option value="+1441">+1441 (Bermuda)</option>
                                        <option value="+975">+975 (Bhutan)</option>
                                        <option value="+591">+591 (Bolivia)</option>
                                        <option value="+387">+387 (Bosnia & Herzegovina)</option>
                                        <option value="+267">+267 (Botswana)</option>
                                        <option value="+55">+55 (Brazil)</option>
                                        <option value="+673">+673 (Brunei)</option>
                                        <option value="+359">+359 (Bulgaria)</option>
                                        <option value="+226">+226 (Burkina Faso)</option>
                                        <option value="+257">+257 (Burundi)</option>
                                        <option value="+855">+855 (Cambodia)</option>
                                        <option value="+237">+237 (Cameroon)</option>
                                        <option value="+238">+238 (Cape Verde)</option>
                                        <option value="+1345">+1345 (Cayman Islands)</option>
                                        <option value="+236">+236 (Central African Republic)</option>
                                        <option value="+235">+235 (Chad)</option>
                                        <option value="+56">+56 (Chile)</option>
                                        <option value="+86">+86 (China)</option>
                                        <option value="+57">+57 (Colombia)</option>
                                        <option value="+269">+269 (Comoros)</option>
                                        <option value="+242">+242 (Congo)</option>
                                        <option value="+682">+682 (Cook Islands)</option>
                                        <option value="+506">+506 (Costa Rica)</option>
                                        <option value="+385">+385 (Croatia)</option>
                                        <option value="+53">+53 (Cuba)</option>
                                        <option value="+599">+599 (Curacao)</option>
                                        <option value="+357">+357 (Cyprus)</option>
                                        <option value="+420">+420 (Czech Republic)</option>
                                        <option value="+243">+243 (Democratic Republic of Congo)</option>
                                        <option value="+45">+45 (Denmark)</option>
                                        <option value="+246">+246 (Diego Garcia)</option>
                                        <option value="+253">+253 (Djibouti)</option>
                                        <option value="+1767">+1767 (Dominica)</option>
                                        <option value="+1809">+1809 (Dominican Republic)</option>
                                        <option value="+670">+670 (East Timor)</option>
                                        <option value="+593">+593 (Ecuador)</option>
                                        <option value="+20">+20 (Egypt)</option>
                                        <option value="+503">+503 (El Salvador)</option>
                                        <option value="+240">+240 (Equatorial Guinea)</option>
                                        <option value="+291">+291 (Eritrea)</option>
                                        <option value="+372">+372 (Estonia)</option>
                                        <option value="+251">+251 (Ethiopia)</option>
                                        <option value="+500">+500 (Falkland Islands)</option>
                                        <option value="+298">+298 (Faroe Islands)</option>
                                        <option value="+679">+679 (Fiji)</option>
                                        <option value="+358">+358 (Finland)</option>
                                        <option value="+33">+33 (France)</option>
                                        <option value="+594">+594 (French Guiana)</option>
                                        <option value="+689">+689 (French Polynesia)</option>
                                        <option value="+241">+241 (Gabon)</option>
                                        <option value="+220">+220 (Gambia)</option>
                                        <option value="+995">+995 (Georgia)</option>
                                        <option value="+49">+49 (Germany)</option>
                                        <option value="+233">+233 (Ghana)</option>
                                        <option value="+350">+350 (Gibraltar)</option>
                                        <option value="+30">+30 (Greece)</option>
                                        <option value="+299">+299 (Greenland)</option>
                                        <option value="+1473">+1473 (Grenada)</option>
                                        <option value="+590">+590 (Guadeloupe)</option>
                                        <option value="+1671">+1671 (Guam)</option>
                                        <option value="+502">+502 (Guatemala)</option>
                                    </select>
                                    </div>
                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }} col-md-10">
                                        

                                            <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" required maxlength="10" pattern="[0-9]{10}" data-validation-route="{{ route('validate.phone') }}" onkeyup="validatePhoneNumber()">

                                            @if ($errors->has('phone_number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                            @endif
                                        
                                    </div>

                                    <div class="col-md-10">
                                        <span class="validation-message"></span>
                                    </div>
                                </div>

                               
                            </div>
                        


                        
                        
                        <!-- Send Code Button -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div id="recaptcha-container"></div>
                                <button type="button" id="sendcode" class="btn btn-success" onclick="phoneSendAuth();" disabled>Send Code</button>
                            </div>
                            
                        </div>
                        
                        
                        <!-- End of Send Code Button -->

                        <!-- Verification Code Input and Verify Button -->
                        <div class="form-group{{ $errors->has('verificationCode') || $errors->has('verificationCode') ? ' has-error' : '' }}">
                            <label for="verificationCode" class="col-md-4 control-label">Verification Code</label>
                            <div class="col-md-6">
                                <input type="text" id="verificationCode" class="form-control" name="verificationCode" placeholder="Enter verification code" required>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" id="verifyButton" class="btn btn-success" onclick="codeverify();" disabled>Verify</button>
                            </div>
                            
                        </div>
                        
                       
                        <!-- End of Verification Code Input and Verify Button -->
                       




                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="registerButton" disabled>
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
      <script>
         var firebaseConfig = {
           apiKey: "AIzaSyAaOjKCksyFX084mdNcd3YxVY_S5LHwCC0",
           authDomain: "phone-number-otp-78caa.firebaseapp.com",
           databaseURL: "https://phone-number-otp-78caa.firebaseapp.com",
           projectId: "phone-number-otp-78caa",
           storageBucket: "phone-number-otp-78caa.appspot.com",
           messagingSenderId: "853358259364",
           appId: "1:1081772606944:web:9817e1803948b1699d1785",
           measurementId: "p266654231222"
         };
           
         firebase.initializeApp(firebaseConfig);
      </script>
      <script type="text/javascript">
       
         window.onload=function () {
           render();
         };
         
         function render() {
             window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
             recaptchaVerifier.render();
         }

         function validatePhoneNumber() {
            const countryCode = document.getElementById('phone_country_code').value;
            const phoneNumber = document.getElementById('phone_number').value;
            
            // Check if phoneNumber has less than 10 digits
            const isPhoneNumberLengthValid = phoneNumber.length >= 10;

            // Check if combinedPhoneNumber length is greater than 12 digits
            const combinedPhoneNumber = countryCode + phoneNumber;
            const isCombinedPhoneNumberValid = combinedPhoneNumber.length > 11;

            // Make an AJAX request to validate the phone number
            if (isPhoneNumberLengthValid && isCombinedPhoneNumberValid) {
                fetch('{{ route('validate.phone') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ combined_phone_number: combinedPhoneNumber })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('error').innerText = 'Phone number already exists.';
                        
                        document.getElementById('sendcode').disabled = true;
                    } else {
                        document.getElementById('error').style.display = 'none';
                       
                        document.getElementById('sendcode').disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error').innerText = 'An error occurred';
                    document.getElementById('sendcode').disabled = true;
                });
            }else {
                // Disable "Send Code" button if combinedPhoneNumber is not greater than 12 digits
                if(phoneNumber.length < 11){
                    document.getElementById('sendcode').disabled = false;
                }
                document.getElementById('sendcode').disabled = true;
            }
        }

         
        document.getElementById('phone_number').addEventListener('keyup', validatePhoneNumber);
        
        document.getElementById('phone_country_code').addEventListener('change', validatePhoneNumber);
         
         
         
         function phoneSendAuth() {
                
             var number = $("#phone_country_code").val() + $("#phone_number").val();

             $(document).ready(function() {
                $('#phone_number').on('input', function() {
                    var phoneInput = $(this).val();
                    var validationRoute = '{{ route("validate.phone") }}'; // Replace with your route URL

                    $.ajax({
                        url: validationRoute,
                        type: 'POST',
                        data: {
                            phone_number: phoneInput,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            var statusElement = $('#phone-validation-status');
                            if (response.exists) {
                                statusElement.text('Phone number already exists.');
                                statusElement.addClass('text-danger');
                            } else {
                                statusElement.text('');
                                statusElement.removeClass('text-danger');


                                
                            }
                        }
                    });
                });
                
            });

             firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                   
                 window.confirmationResult=confirmationResult;
                 coderesult=confirmationResult;
                 console.log(coderesult);
                 $("#sentSuccess").text("Message Sent Successfully.");
                 $("#sentSuccess").show();
                 document.getElementById('verifyButton').disabled = false;
                 setTimeout(function() {
                    $("#sentSuccess").fadeOut("slow");
                }, 4000);
                   
             }).catch(function (error) {
                 $("#error").text(error.message);
                 $("#error").show();
                 setTimeout(function() {
                    $("#error").fadeOut("slow");
                }, 4000);
             });
         
         }
         
         function codeverify() {
         
             var code = $("#verificationCode").val();
         
             coderesult.confirm(code).then(function (result) {
                 var user=result.user;
                 
                 $("#successRegister").text("Verified Successfully.");
                 $("#successRegister").show();
                 setTimeout(function() {
                        $("#successRegister").fadeOut("slow");
                    }, 4000);

                 $("#verifyButton").text("Verified");
                 $("#verifyButton").attr("disabled", true);
                 $("#registerButton").prop("disabled", false);

         
             }).catch(function (error) {
                 $("#error").text(error.message);
                 $("#error").show();
                 setTimeout(function() {
                    $("#error").fadeOut("slow");
                }, 4000);

                $("#registerButton").prop("disabled", true);
             });
         }




         function validateForm() {
            const countryCode = document.getElementById('phone_country_code').value;
            const phoneNumber = document.getElementById('phone_number').value;
            
            // Check if phoneNumber has less than 10 digits
            const isPhoneNumberLengthValid = phoneNumber.length >= 10;

            // Check if combinedPhoneNumber length is greater than 12 digits
            const combinedPhoneNumber = countryCode + phoneNumber;
            const isCombinedPhoneNumberValid = combinedPhoneNumber.length > 12;

            // Other required form fields
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            

            // Enable "Register" button only if all required fields are valid
            if (isPhoneNumberLengthValid && isCombinedPhoneNumberValid && name && email && password) {
                document.getElementById('registerButton').disabled = false;
            } else {
                document.getElementById('registerButton').disabled = true;
            }
        }

        // Attach the validateForm function to various form input events
        document.getElementById('phone_number').addEventListener('keyup', validateForm);
        document.getElementById('phone_country_code').addEventListener('change', validateForm);
        document.getElementById('name').addEventListener('keyup', validateForm);
        document.getElementById('email').addEventListener('keyup', validateForm);
        document.getElementById('password').addEventListener('keyup', validateForm);

        // Call the function once to initialize the button state on page load
        validateForm();


         
      </script>

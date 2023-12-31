<html>
   <head>
      <title>Phone Number Authentication using Firebase In Laravel 8</title>
      <!-- CSS only -->
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
       <!-- Js only -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   </head>
   <body>
      <div class="container">
      <div class="jumbotron">
      <div class="container text-center">
         <p>Phone Number Authentication using Firebase In Laravel 8</p>
      </div>
      </div>
         
         <div class="alert alert-danger" id="error" style="display: none;"></div>
         <div class="card">
            <div class="card-header">
               Enter Phone Number
            </div>
            <div class="card-body">
               <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
               <form>
                  <label>Phone Number:</label>
                  <input type="text" id="number" class="form-control" placeholder="+91********">
                  <div id="recaptcha-container"></div>
                  <button type="button" class="btn btn-success" onclick="phoneSendAuth();">SendCode</button>
               </form>
            </div>
         </div>
         <div class="card" style="margin-top: 10px">
            <div class="card-header">
               Enter Verification code
            </div>
            <div class="card-body">
               <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
               <form>
                  <input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code">
                  <button type="button" class="btn btn-success" onclick="codeverify();">Verify code</button>
               </form>
            </div>
         </div>
      </div>
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
         
         function phoneSendAuth() {
                
             var number = $("#number").val();
               
             firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                   
                 window.confirmationResult=confirmationResult;
                 coderesult=confirmationResult;
                 console.log(coderesult);
         
                 $("#sentSuccess").text("Message Sent Successfully.");
                 $("#sentSuccess").show();
                   
             }).catch(function (error) {
                 $("#error").text(error.message);
                 $("#error").show();
             });
         
         }
         
         function codeverify() {
         
             var code = $("#verificationCode").val();
         
             coderesult.confirm(code).then(function (result) {
                 var user=result.user;
                 
                 $("#successRegsiter").text("you are register Successfully.");
                 $("#successRegsiter").show();
         
             }).catch(function (error) {
                 $("#error").text(error.message);
                 $("#error").show();
             });
         }
      </script>
   </body>
</html>
<div class="container">
    <form action="/home/do_forgot_password" method="POST" onsubmit="return validateEmailAddress()">
        <br/>
        <div class="row">
            <div class="col-md-6">
                <div clas="row">
                    <div class="col-md-12">
                            <?php
                                $error = false;
                                if(isset($login_error) && !is_null($login_error))
                                {
                                    $error = true;
                            ?>
                            <div class="alert alert-dismissible alert-danger">
                                <strong>Error:</strong> <?php echo $login_error; ?>
                            </div>
                            <?php
                                }
                            ?>
                    </div>
                </div>
                <div class="card border-dark mb-3">
                    <div class="card-header" style="background-color:#d3d3d3">Reset your password</div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-4">Email:</div>
                            <div class="col-md-8">
                                <input id="email" type="text" name="email" class="form-control">
                            </div>
                            
                        </div>
                        
                        
                        <br/>
                        <div class="row">
                            <div class="col-md-12 ">
                                <center><button type="submit" class="btn btn-info">Submit</button></center>
                            </div>
                            
                        </div>
                    </div>
                  </div>
                    
            </div>
            <div class="col-md-6">
            </div>
        </div>
        
        
        
        <?php 
            if(isset($google_reCAPTCHA_site_key) && !is_null($google_reCAPTCHA_site_key))
            {
        ?>
            <!-------------------reCAPTCHA v3 check  ---------------------------------->
                        <input type="hidden" id="recaptcha_token" name="recaptcha_token" value="">
                        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $google_reCAPTCHA_site_key; ?>"></script>
                        <script>
                            grecaptcha.ready(function() {
                                 grecaptcha.execute('<?php echo $google_reCAPTCHA_site_key; ?>', {action: 'register'}).then(function(token) {
                                 //console.log(token);
                                 document.getElementById('recaptcha_token').value = token;
                                });
                            });
                        </script>        
            <!------------------End reCAPTCHA v3 check -------------------------------->
        <?php
            } 
        ?>
        <script> 
            function validateEmailAddress() 
            {
                var email = document.getElementById('email').value;
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                
                var result = re.test(String(email).toLowerCase());
                if(!result)
                {
                    alert('Invalid email format');
                }
                return result;
            }
            /*function ValidateEmail() 
            {
                var email = document.getElementById('email');
                alert(email);
             if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.emailAddr.value))
              {
                return (true)
              }
                alert("You have entered an invalid email address!")
                return (false)
            }*/
        </script>
        
    </form>
</div>


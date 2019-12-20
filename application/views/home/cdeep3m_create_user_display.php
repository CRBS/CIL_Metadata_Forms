<form action="/user/do_create_user" method="post" onsubmit="return check_password()">
<div class="container">
    <br/><br/>
    <div class="row">
        
        <div class="col-md-12">
        <?php
            $error = false;
            if(isset($create_user_error) && !is_null($create_user_error))
            {
                $error = true;
        ?>
        <div class="alert alert-dismissible alert-danger">
            <strong>Error:</strong> <?php echo $create_user_error; ?>
        </div>
        <?php
            }
        ?>
        </div>
        
        
        
        <div class="col-md-12">
        <?php
            
            if(!$error && isset($create_user_success) && !is_null($create_user_success))
            {
               
        ?>
        <div class="alert alert-dismissible alert-success">
            <strong>Success:</strong> User account has been created successfully.
        </div>
        <?php
            }
        ?>
        </div>
        
        <div class="col-md-12">
            <span class="cil_title2">Create Account</span>
        </div>
        
        <div class="col-md-2">User name</div>
        <div class="col-md-4">
            <input type="text" id="create_username" name="create_username" class="form-control" value="<?php if($error & isset($create_username) && !is_null($create_username)) echo $create_username;   ?>">
        </div>
        <div class="col-md-6">(At least 6 characters)</div>
        <hr style="height:10px; visibility:hidden;" />
        
        <div class="col-md-2">Password</div>
        <div class="col-md-4">
            <input type="password" id="create_password" name="create_password" class="form-control" value="<?php if($error & isset($create_password) && !is_null($create_password)) echo $create_password;   ?>">
        </div>
        <div class="col-md-6">(At least 6 characters)</div>
        
        <hr style="height:10px; visibility:hidden;" />
        <div class="col-md-2">Full name</div>
        <div class="col-md-4">
            <input type="text" id="create_fullname" name="create_fullname" class="form-control" value="<?php if($error & isset($create_fullname) && !is_null($create_fullname)) echo $create_fullname;   ?>">
        </div>
        <div class="col-md-6"></div>
        
        
        <hr style="height:10px; visibility:hidden;" />
        <div class="col-md-2">Email</div>
        <div class="col-md-4">
            <input type="text" id="create_email" name="create_email" class="form-control" value="<?php if($error & isset($create_email) && !is_null($create_email)) echo $create_email;   ?>">
        </div>
        <div class="col-md-6"></div>
        
        

        
        
        <div class="col-md-12 "><br/></div>
        <div class="col-md-6 ">
            <center><button type="submit" class="btn btn-info" >Create account</button></center>
        </div>
       <div class="col-md-6"></div>
       
       <div class="col-md-12">
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
       </div>
       
    </div>
</div>
<script>
    function check_password()
    {

        var create_username = document.getElementById('create_username').value;
        if(create_username.length <= 6)
        {
            alert("User name length has to be at least 6 characters");
            return false;
        }
        
        var create_password = document.getElementById('create_password').value;
        if(create_password.length <= 6)
        {
            alert("Password length has to be at least 6 characters");
            return false;
        }
        
        var create_fullname = document.getElementById('create_fullname').value;
        if(create_fullname.length == 0)
        {
            alert("Full name is required");
            return false;
        }
        
        var create_email = document.getElementById('create_email').value;
        if(create_email.length == 0)
        {
            alert("Email is required");
            return false;
        }
        
        return true;
    }
</script>
            
            


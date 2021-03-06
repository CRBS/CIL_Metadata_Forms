<div class="container">
     <form action="/internal_image_viewer/login/<?php echo $image_id."?".$query_string; ?>" method="POST">
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
                    <div class="card-header" style="background-color:#d3d3d3">Login</div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md-4">User name</div>
                            <div class="col-md-8">
                                <input type="text" name="username" class="form-control">
                            </div>
                            <hr style="height:10px; visibility:hidden;" />
                        </div>
                        
                        <div class="row">
                             
                            <div class="col-md-4">Password</div>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control">
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
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-5">
                        <a href="/home/create_user">Request an account</a>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <a href="/home/forgot_password">Forgot Username or Password</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                &nbsp;
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
        
        
    </form>
</div>
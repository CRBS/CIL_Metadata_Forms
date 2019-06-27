<div class="container">
    <?php
        $form_open = false;
        if(isset($image_id))
        {
            $form_open = true;
    ?>        
    <form action="/login/auth_image/<?php echo $image_id; ?>" method="POST">
    <?php
        }
        else if(isset($tag))
        {
            $form_open = true;
    ?>
    <form action="/login/process_tag/<?php echo $tag; ?>" method="POST">
    <?php
        }
    ?>
    <br/>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-dark mb-3">
                <div class="card-header" style="background-color:#d3d3d3">Login</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">User name</div>
                        <div class="col-md-8">
                            <input type="text" name="username" class="form-control">
                        </div>
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
    <?php
        if($form_open)
        {
    ?>        
    </form>
    <?php
        }
    ?>
</div>


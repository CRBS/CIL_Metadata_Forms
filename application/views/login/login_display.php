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
                <div class="card-header">Login</div>
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


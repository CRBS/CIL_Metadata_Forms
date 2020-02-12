<div class="container">
    
        <br/>
        <div class="row">
            <div class="col-md-12">
                <span class="cil_title2">My Account</span>
            </div>
            <div class="col-md-12">
                <?php
                    if(isset($myAccountJson))
                    {
                ?>
                    <div class="row">
                        <div class="col-md-4">
                            User name:
                        </div>
                        <div class="col-md-8">
                            <?php echo $myAccountJson->full_name; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            Email:
                        </div>
                        <div class="col-md-8">
                            <?php echo $myAccountJson->email; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            User type:
                        </div>
                        <div class="col-md-8">
                            <?php 
                                $userTypeInt = $myAccountJson->user_role; 
                                if($userTypeInt==1)
                                    echo "Admin";
                                else if($userTypeInt==2)
                                    echo "Member";
                            ?>
                        </div>
                    </div>
                    <hr>
                    <form action="/cdeep3m_preview/do_reset_password" method="POST" onsubmit="return validate_password()">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-dark mb-3">
                            <div class="card-header" style="background-color:#d3d3d3">Reset your password</div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">New password:</div>
                                    <div class="col-md-6">
                                        <input id="new_password" type="password" name="new_password" class="form-control">
                                    </div>
                                    <div class="col-md-2">(6 characters or more)</div>
                                    <div class="col-md-4">confirm password:</div>
                                    <div class="col-md-6">
                                        <input id="confirm_password" type="password" name="confirm_password" class="form-control">
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>


                                <br/>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <center><button type="submit" class="btn btn-info">Reset password</button></center>
                                    </div>

                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    </form>
                <?php
                    }
                ?>
            </div>
            
        </div>
    
</div>

<script> 
    function validate_password()
    {
        var new_password = document.getElementById('new_password').value;
        //alert(new_password);
        if(new_password.length < 6)
        {
            alert("New password must have 6 characters or more");
            return false;
        }
        
        var confirm_password = document.getElementById('confirm_password').value; 
        if(new_password != confirm_password)
        {
            alert("Your new password and confirmed password do not match.");
            return false;
        }
    }
</script>
                    


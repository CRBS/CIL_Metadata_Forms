<form action="/user/update_password" method="post" onsubmit="return check_password()">
<div class="container">
    <br/><br/>
    <div class="row">
        
        <?php
            if(isset($update_sucess))
            {
        ?>
        <div class="alert alert-dismissible alert-success">
            <strong>Success!</strong> Your password has been updated.
        </div>
        <?php
            }
        ?>
        <div class="col-md-12">
            <span class="cil_title2">Change password</span>
        </div>
        <div class="col-md-2">New password</div>
        <div class="col-md-4">
            <input type="password" id="new_password" name="new_password" class="form-control">
        </div>
        <div class="col-md-6"></div>
    </div>
    
    <div class="row">
        <div class="col-md-2">Confirm password</div>
        <div class="col-md-4">
            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
        </div>
        <div class="col-md-6"></div>
    </div>
    
    <div class="row">
        <div class="col-md-12 "><br/></div>
        <div class="col-md-6 ">
            <center><button type="submit" class="btn btn-info" >Save</button></center>
        </div>
        <div class="col-md-6 "></div>
    </div>
</div>
</form>
<script>
    function check_password()
    {
        var new_password = document.getElementById('new_password').value;
        var confirm_password = document.getElementById('confirm_password').value;
        if(new_password != confirm_password)
        {
            alert("The confirmed password is different.")
            return false;
        }
        
        if(new_password.length <= 6)
        {
            alert("Password length has to be at least 6 characters");
            return false;
        }
        
        return true;
    }
</script>
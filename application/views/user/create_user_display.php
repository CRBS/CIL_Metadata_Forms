<form action="/user/do_create_user" method="post" onsubmit="return check_password()">
<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Create user</span>
        </div>
        
        <div class="col-md-2">User name</div>
        <div class="col-md-4">
            <input type="text" id="create_username" name="create_username" class="form-control">
        </div>
        <div class="col-md-6">(At least 6 characters)</div>
        <hr style="height:10px; visibility:hidden;" />
        
        <div class="col-md-2">Password</div>
        <div class="col-md-4">
            <input type="password" id="create_password" name="create_password" class="form-control">
        </div>
        <div class="col-md-6">(At least 6 characters)</div>
        
        <hr style="height:10px; visibility:hidden;" />
        <div class="col-md-2">Full name</div>
        <div class="col-md-4">
            <input type="text" id="create_fullname" name="create_fullname" class="form-control">
        </div>
        <div class="col-md-6"></div>
        
        
        <hr style="height:10px; visibility:hidden;" />
        <div class="col-md-2">Email</div>
        <div class="col-md-4">
            <input type="text" id="create_email" name="create_email" class="form-control">
        </div>
        <div class="col-md-6"></div>
        
        
        <div class="col-md-2">Type</div>
        <div class="col-md-4">
            Web user only
        </div>
        <div class="col-md-6"></div>
        
        
        <div class="col-md-12 "><br/></div>
        <div class="col-md-6 ">
            <center><button type="submit" class="btn btn-info" >Create</button></center>
        </div>
       <div class="col-md-6"></div>
       
    
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
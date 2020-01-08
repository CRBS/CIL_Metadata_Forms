<form action="/home/do_approve_users" method="post" >
<div class="container">
    <br/><br/>
    <?php
        if(!isset($inactive_user_list) || is_null($inactive_user_list) || count($inactive_user_list) ==0)
        {
            echo "There are no inactive users to approve";
        }
        else
        {
     
            foreach($inactive_user_list as $user)
            {
    ?>
    <div class="row">
        <div class="col-md-2">
            <?php echo $user->username;?>
        </div>
        <div class="col-md-2">
           <?php echo $user->full_name;?>
        </div>
        <div class="col-md-3">
            <?php echo $user->email;?>
        </div>
        <div class="col-md-3">
            <?php echo $user->create_time;?>
        </div>
        <div class="col-md-2">
            <a href="/user/do_approve/<?php echo $user->id; ?>" class="btn btn-info" target="_self">Approve</a>
        </div>
    </div>
    <hr/>
    <?php
            }
        }
    ?>
</div>
    
    
 
</form>

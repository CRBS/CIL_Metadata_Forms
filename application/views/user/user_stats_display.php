<div class="container">
<div class="row" style="color: #004d99;font-weight:bold">
    <div class="col-md-12"><br/></div>
<div class="col-1">ID</div>
<div class="col-2">Full Name</div>
<div class="col-2">Username</div>
<div class="col-3">Email</div>
<div class="col-1">Role</div>
<div class="col-md-3">Action</div>        
</div>
    <hr>
<div class="row">    
    <div class="col-md-12"><br/></div>
</div>
<?php

foreach ($allUserJsons as $item)
{
?>    
<div class="row">
    <div class="col-1">
        <?php echo $item->id; ?>
    </div>
    <div class="col-2">
        <?php echo $item->full_name; ?>
    </div>
    <div class="col-2">
        <?php echo $item->username; ?>
    </div>
    <div class="col-3">
        <?php echo $item->email; ?>
    </div>
    <div class="col-1">
        <?php
            if($item->user_role == 1)
                echo "<b>Admin</b>";
            else if($item->user_role == 2)
                echo "Member";
        ?>
    </div>
    <div class="col-md-3">
         <a href="/user/view_activities/<?php echo $item->id; ?>" class="btn btn-primary">View activities</a>
    </div>
    
</div>
    <hr>
<?php    
}
?>
</div>
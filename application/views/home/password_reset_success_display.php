<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <?php 
                if(isset($success) && $success)
                {
            ?>
            <div class="alert alert-dismissible alert-success">
                <strong>Success:</strong> Your password has been updated.
            </div>
            <?php
                }
                else 
                {
            ?>
            <div class="alert alert-dismissible alert-danger">
                <strong>Error:</strong> The system cannot update your password. Please try again.
            </div>
            <?php
                }
            ?>
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <center><a href="/home" class="btn btn-primary">Go back to the main page.</a></center>
        </div>
    </div>
</div>


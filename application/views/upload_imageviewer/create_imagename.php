<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Step 1: Create a new image name</span>
        </div>
    </div>
    
<?php
    if(isset($error_message))
    {
?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissible alert-danger">
                <strong>Error:</strong> <?php echo $error_message; ?>
            </div>
        </div>
    </div>
<?php
    }
?>
    
    <form action="/Upload_imageviewer/create_imagename" method="POST">
    <div class="row">
        <div class="col-md-2">Image name: NCMIR_</div>
        <div class="col-md-5">
            <input class="form-control" type="text" id="image_name" name="image_name">
        </div>
        <div class="col-md-5">(Characters, Numbers and underscores only)</div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </div>
    </form>
</div>


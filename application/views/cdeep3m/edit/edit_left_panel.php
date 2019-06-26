<div class="row">
    <div class="col-md-12">
        <center>
            
            <?php
                if($hasDisplayImage)
                {
            ?>
            <img src="https://cildata.crbs.ucsd.edu/media/model_display/<?php echo $model_id; ?>/<?php echo $model_id; ?>_thumbnailx512.jpg?<?php echo uniqid(); ?>" class="img-thumbnail pull-right" width="100%">
            <?php
                }
                else
                {
            ?>
            <img src="/pix/default_jpg3.png?<?php echo uniqid(); ?>" class="img-thumbnail pull-right" width="100%">
            <?php
                }
            ?>
        </center>
    </div>
    <div class="col-md-12">
        
        <form action="/cdeep3m_models/upload_model_image/<?php echo $model_id; ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return validate_cil_image_upload();">
            
                    <input class="upload_cil_image" type="file" name="userfile" accept="image/x-png, image/gif, image/jpeg" data-max-size="12048000"><br/>
                    <input type="submit" name="submit" class="btn btn-primary" value="Upload image">
                
        </form>
        
    </div>
</div>
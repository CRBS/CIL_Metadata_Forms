<?php
    $id = 0;
    if(isset($numeric_id))
    {
        $id = $numeric_id;
    }
?>
<br/>
<div class="row">
    <div class="col-md-12">
        <center>
            <img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id; ?>/<?php echo $id; ?>_thumbnailx512.jpg" class="img-thumbnail pull-right" width="100%">
        </center>
    </div>
    <div class="col-md-12">
        
        <form action="/image_metadata/upload_cil_image/<?php echo $id; ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return validate_cil_image_upload();">
            
                    <input class="upload_cil_image" type='file' name='userfile' accept="image/x-png, image/gif, image/jpeg" data-max-size="12048000" />
                    <input type='submit' name='submit' class="btn btn-primary" value='Upload image' />
                
        </form>
        
    </div>
    <div class="col-md-12">
    <br/>
    </div>
    <div class="col-md-12">
        
            <a href="<?php echo $staging_website_prefix."/images/".$numeric_id; ?>" target="_blank" class="btn btn-primary">View image</a>
        
    </div>
</div>


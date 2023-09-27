<?php

//if(isset($image_size_json) && isset($image_size_json->jpeg_size) && isset($image_size_json->zip_size) && isset($numeric_id))
if(isset($image_size_json) && isset($numeric_id))
{
?>
<br/>
<span class="cil_title2">Image files</span>
<div class="row">
    <div class="col-md-9">
        <?php $jpg_url = "https://cildata.crbs.ucsd.edu/media/images/".$numeric_id."/".$numeric_id.".jpg"; ?>
        <a href="<?php echo $jpg_url; ?>" target="_blank"><?php echo $jpg_url; ?></a>
    </div>
    <div class="col-md-3">
        <?php 
            if(isset($image_size_json->jpeg_size))
            {
                echo $image_size_json->jpeg_size." bytes";
            }
        ?>
        <input type="hidden" id="jpeg_size" name="jpeg_size" value="<?php echo $image_size_json->jpeg_size; ?>">
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <?php 
            $zip_url = "";
            if(isset($json->CIL_CCDB->Data_type->Video) && $json->CIL_CCDB->Data_type->Video)
                $zip_url = "https://cildata.crbs.ucsd.edu/media/videos/".$numeric_id."/".$numeric_id.".zip"; 
            else
                $zip_url = "https://cildata.crbs.ucsd.edu/media/images/".$numeric_id."/".$numeric_id.".zip"; 
            
        ?> 
        <a href="<?php echo $zip_url; ?>" target="_blank"><?php echo $zip_url; ?></a>
    </div>
    <div class="col-md-3">
        <?php 
            if(isset($image_size_json->zip_size))
            {
        ?>
        <!-- <input  id="zip_size" name="zip_size" value="<?php //echo $image_size_json->zip_size; ?>"> bytes -->
        <?php
                echo $image_size_json->zip_size." bytes";
            }
        ?>
         <input type="hidden" id="zip_size" name="zip_size" value="<?php echo $image_size_json->zip_size; ?>"> 
    </div>
    <div class="col-md-12">
        <br/>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <center>
            <a href="/image_metadata/upload_jpeg_image/<?php echo $numeric_id; ?>" class="btn btn-primary" target="_self">Replace JPEG file</a>
        </center>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-3">
        <center>
            <a href="/image_metadata/upload_zipped_image/<?php echo $numeric_id; ?>" class="btn btn-primary" target="_self">Replace ZIP file</a>
        </center>
    </div>
    <div class="col-md-2"></div>
</div>



<?php
}
?>
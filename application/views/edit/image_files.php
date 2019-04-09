<?php

if(isset($image_size_json) && isset($image_size_json->jpeg_size) && isset($image_size_json->zip_size)
        && isset($numeric_id))
{
?>
<br/>
<span class="cil_title2">Image files</span>
<div class="row">
    <div class="col-md-9">
        <?php echo "https://cildata.crbs.ucsd.edu/media/images/".$numeric_id."/".$numeric_id.".jpg"; ?>
    </div>
    <div class="col-md-3">
        <?php 
            if(isset($image_size_json->jpeg_size))
            {
                echo $image_size_json->jpeg_size." bytes";
            }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <?php echo "https://cildata.crbs.ucsd.edu/media/images/".$numeric_id."/".$numeric_id.".zip"; ?>
    </div>
    <div class="col-md-3">
        <?php 
            if(isset($image_size_json->zip_size))
            {
                echo $image_size_json->zip_size." bytes";
            }
        ?>
    </div>
</div>
<?php
}
else
{
    var_dump($image_size_json);
   if(!isset($image_size_json))
       echo "image_size_json is not set";
   
   if(!isset($image_size_json->jpeg_size))
        echo "image_size_json->jpeg_size is not set";
}
?>
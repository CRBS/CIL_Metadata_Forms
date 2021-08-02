<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Image Viewer URL</span>
        </div>
    </div>
    <?php
        $imageUrl = $image_viewer_prefix."/internal_data/".$image_id."?username=".$username."&token=".$token;
    ?>
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo $imageUrl;  ?>" target="_blank"><?php echo $imageUrl;  ?></a>
        </div>
    </div>
    
    
</div>


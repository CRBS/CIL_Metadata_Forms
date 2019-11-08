<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Upload display image (Jpeg Image ONLY)</span>
        </div>
        <form action="/upload_images/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return validate_cil_image_upload();">
        <div class="col-md-12">            
            <input class="upload_cil_image" type="file" name="userfile" accept="image/x-png, image/gif, image/jpeg" data-max-size="12048000">   
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
             <label> Tag:</label>
             <select id="tag" name="tag" class="form-control">
             <?php
                if(isset($tag_array))
                {
                    foreach($tag_array as $tag)
                    {
             ?>
                    <option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
             <?php
                    }
                }
              ?>
            </select> 
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">    
            <input type="submit" name="submit" class="btn btn-primary" value="Upload image">
        </div>
        
        </form>
    </div>
</div>


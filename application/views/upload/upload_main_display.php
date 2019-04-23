<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Upload image</span>
        </div>
        <form action="/upload_images/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return validate_cil_image_upload();">
        <div class="col-md-12">            
            <input class="upload_cil_image" type="file" name="userfile" accept="image/x-png, image/gif, image/jpeg" data-max-size="12048000">   
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">    
            <input type="submit" name="submit" class="btn btn-primary" value="Upload image">
        </div>
        </form>
    </div>
</div>


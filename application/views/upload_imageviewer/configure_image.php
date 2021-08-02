<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Step 3: Configure image parameters</span>
        </div>
    </div>
    <form action="/Upload_imageviewer/submit_config" method="post">
    <input type="hidden" name="image_id" value="<?php echo $image_name; ?>">

    <div class="row">
        <div class="col-md-12">Image name: <?php echo $image_name; ?></div>
    </div>   
    <div class="row">
        <div class="col-md-2">Max Z:</div>
        <div class="col-md-4">
            <input class="form-control" type="text" name="max_z" value="<?php if(isset($max_z)) echo $max_z; else echo "0"; ?>">
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-2">Is RGB:</div>
        <div class="col-md-4">
            <input  type="checkbox" name="is_rgb" value="is_rgb" checked>
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-2">Max zoom:</div>
        <div class="col-md-4">
            <input class="form-control" type="text" name="max_zoom" value="7">
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-2">Init_lat:</div>
        <div class="col-md-4">
            <input class="form-control" type="text" name="init_lat" value="-15">
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-2">Init_lng:</div>
        <div class="col-md-4">
            <input class="form-control" type="text" name="init_lng" value="-7">
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-2">Init zoom:</div>
        <div class="col-md-4">
            <input class="form-control" type="text" name="init_zoom" value="1">
        </div>
        <div class="col-md-6"></div>
    </div>
    
    
    <br/>
    <div class="row">
        <div class="col-md-6">
            <center><button type="submit" class="btn btn-info" value="Submit">Submit</button></center>
        </div>
        <div class="col-md-6"></div>
    </div>
    </form>
</div>

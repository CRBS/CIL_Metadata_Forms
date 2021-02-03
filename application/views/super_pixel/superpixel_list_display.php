<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br/>
        </div>
        <div class="col-md-12">
            <span class="cil_title2">Superpixel results</span>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
    <?php 
    
        if(!isset($superpixelArray) || is_null($superpixelArray) || count($superpixelArray)==0)     
        {
            echo "<br/>No superpixel results found.";
        }
    ?>
        </div>
    </div>
    
    
    <?php 
    
        if(!is_null($superpixelArray) && count($superpixelArray)>0)
        {
    ?>
    <div class="row">
        <div class="col-md-1"><b>ID</b></div>
        <div class="col-md-1"><b>width</b></div>
        <div class="col-md-1"><b>height</b></div>
        <div class="col-md-2"><b>number of images</b></div>
        <div class="col-md-5"><b>upload time</b></div>
        <div class="col-md-2"><b>option</b></div>
        <div class='col-md-12'><hr><br/></div>
    </div>
    
    <?php
        foreach($superpixelArray as $superpixel)   
        {
            echo "\n<div class='row'>";
            echo "\n<div class='col-md-1'>".$superpixel['id']."</div>";
            echo "\n<div class='col-md-1'>".$superpixel['width']."</div>";
            echo "\n<div class='col-md-1'>".$superpixel['height']."</div>";
            echo "\n<div class='col-md-2'>".$superpixel['num_of_images']."</div>";
            echo "\n<div class='col-md-5'>".$superpixel['upload_time']."</div>";
            echo "\n<div class='col-md-2'><a href='".$image_viewer_prefix."/super_pixel/overlay/SP_".$superpixel['id']."/0". "' class='btn btn-info' target='_blank'>View</a></div>";
            echo "\n<div class='col-md-12'><hr><br/></div>";
            echo "\n</div>";
        }
        
        //echo "\nCOUNT:".count($superpixelArray);
     ?>
    
     
   
    <?php
        }
    ?>
</div>


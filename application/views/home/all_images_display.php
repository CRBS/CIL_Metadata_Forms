<div class="container">
    <?php
        $i=0;
        $count = count($idArray);
        
        //$host = "http://localhost";
        
        while($i < $count)
        {
    ?>        
            <div class="row">
                <div class="col-md-12"><br/></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?php
                        if($i < $count)
                        {
                    ?>
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $idArray[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $idArray[$i];  ?>/<?php echo $idArray[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
                    <?php
                            $i++;
                        }    
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        if($i < $count)
                        {
                    ?>
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $idArray[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $idArray[$i];  ?>/<?php echo $idArray[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
                    <?php
                            $i++;
                        }    
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        if($i < $count)
                        {
                    ?>
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $idArray[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $idArray[$i];  ?>/<?php echo $idArray[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
                    <?php
                            $i++;
                        }    
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        if($i < $count)
                        {
                    ?>
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $idArray[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $idArray[$i];  ?>/<?php echo $idArray[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
                    <?php
                            $i++;
                        }    
                    ?>
                </div>
                <br/>
            </div>
            
    <?php
    
        }
        
    ?>
    <div class="row">
        <div class="col-md-12"><br/></div>
    </div>
</div>

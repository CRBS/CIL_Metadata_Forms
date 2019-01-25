<div class="container">
    <?php
        $i=0;
        $count = count($id_array);
        
        $host = "http://localhost";
        
        while($i < $count)
        {
    ?>        
    
            <div class="row">
                <div class="col-md-3">
                    <?php
                        if($i < $count)
                        {
                    ?>
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i];  ?>/<?php echo $id_array[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i];  ?>/<?php echo $id_array[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i];  ?>/<?php echo $id_array[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i];  ?>/<?php echo $id_array[$i];  ?>_thumbnailx140.jpg" width="140"></a>
                            
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
</div>
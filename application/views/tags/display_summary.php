<div class="container">
    <?php
        $i=0;
        $count = count($id_array);
        
        if($count==0)
        {
    ?>
            <div class="row">
                <div class="col-md-12"><br/></div>
                <div class="col-md-12">No datasets found yet.</div>
            </div>
    
    <?php
        }
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i][0];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i][0];  ?>/<?php echo $id_array[$i][0];  ?>_thumbnailx140.jpg" width="140"></a>
                            <br/><?php echo $id_array[$i][1]; ?>
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i][0];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i][0];  ?>/<?php echo $id_array[$i][0];  ?>_thumbnailx140.jpg" width="140"></a>
                            <br/><?php echo $id_array[$i][1]; ?>
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i][0];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i][0];  ?>/<?php echo $id_array[$i][0];  ?>_thumbnailx140.jpg" width="140"></a>
                            <br/><?php echo $id_array[$i][1]; ?>
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
                            <a href="<?php echo $host ?>/image_metadata/edit/CIL_<?php echo $id_array[$i][0];  ?>"><img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id_array[$i][0];  ?>/<?php echo $id_array[$i][0];  ?>_thumbnailx140.jpg" width="140"></a>
                            <br/><?php echo $id_array[$i][1]; ?>
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
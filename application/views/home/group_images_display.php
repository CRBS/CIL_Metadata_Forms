<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
           <span class="cil_title2">Group images</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                $count = count($groupImagesArray);
                if($count== 0)
                    echo "You don't have any images in this group yet.";
            ?>
        </div>
    </div>
    
    <div class="row">
        <?php
            $index = 0;
        
            if($count > 0)
            {
                while($index < $count)
                {
                   
        ?>
                <div class='col-md-4'>
                    <?php 
                        if($index <$count)
                        {
                            
                    ?> 
                    <center><a href='<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" /></a></center>
                    <br/>
                    <center><a href='<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_self'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
                    <?php
                        }
                        $index++;
                    ?>
                </div>
        
                <div class='col-md-4'>
                    <?php 
                        if($index <$count)
                        {
                            
                    ?> 
                    <center><a href='#' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" /></a></center>
                    <br/>
                    <center><a href='#' target='_self'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
                    <?php
                        }
                        $index++;
                    ?>
                </div>
        
                <div class='col-md-4'>
                    <?php 
                        if($index <$count)
                        {
                            
                    ?> 
                    <center><a href='#' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" /></a></center>
                    <br/>
                    <center><a href='#' target='_self'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
                    <?php
                        }
                        $index++;
                    ?>
                </div>
        
        
        <?php
                }
            }
        ?>
        
    </div>
    
</div>
    
    


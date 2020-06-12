<?php
    $count = count($groupImagesArray);
?>
<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <?php
                if($count > 0)
                {
            ?>
           <span class="cil_title2"><?php echo $groupImagesArray[0]['group_name']." group images:"; ?></span>
           <?php
                }
                else
                {
            ?>
           <span class="cil_title2">Group images</span>
            <?php
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                
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
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" height="256"/></a></center>
                    <br/>
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
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
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" height="256"/></a></center>
                    <br/>
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
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
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $groupImagesArray[$index]['group_name']; ?>/<?php echo $groupImagesArray[$index]['image_id'];  ?>.jpg' width="256" height="256"/></a></center>
                    <br/>
                    <center><a href='<?php echo $image_viewer_prefix ?>/internal_data/<?php echo $groupImagesArray[$index]['image_id']; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>' target='_blank'><?php echo $groupImagesArray[$index]['image_id'];  ?></a></center>
                    <?php
                        }
                        $index++;
                    ?>
                </div>
                <div class="col-md-12"><hr></div>
        
        <?php
                }
            }
        ?>
        
    </div>
    
</div>
    
    


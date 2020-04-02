<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
           <span class="cil_title2">Group images</span>
        </div>
    </div>
    
    <?php
        if(is_null($userGroupArray))
        {
    ?>
    <div class="row">
        <div class="col-md-12">
            You don't have any group images.
        </div>
    </div>
    <?php
        }
    ?>
    
    <?php
        if(!is_null($userGroupArray))
        {
            $index = 0;
            $count = count($userGroupArray);
            while($index < $count)
            {                
    ?> 
                <?php
                    if($index==0)
                    {
                ?>
                <div class="row">
                <?php
                    } 
                ?>
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                        ?>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $userGroupArray[$index]['group_name']; ?>/default.jpg' width="256" /></a></center>
                        <br/>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><?php echo $userGroupArray[$index]['group_name'];  ?></a></center>
                        <?php
                                
                                $index++;
                            }
                        ?>
                    </div>
                    
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                        ?>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $userGroupArray[$index]['group_name']; ?>.jpg' width="256" /></a></center>
                        <br/>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><?php echo $userGroupArray[$index]['group_name'];  ?></a></center>
                        <?php
                                
                                $index++;
                            }
                        ?>
                    </div>
                    
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                        ?>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $userGroupArray[$index]['group_name']; ?>.jpg' width="256" /></a></center>
                        <br/>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><?php echo $userGroupArray[$index]['group_name'];  ?></a></center>
                        <?php
                                
                                $index++;
                            }
                        ?>
                    </div>
                    
                <?php
                    if($index==0)
                    {
                ?>
                </div>
                <?php
                    }
                    
                    if($index == 2)
                        $index =0;
                ?>    
    <?php
            }             
        }
    ?>
    
    
</div>


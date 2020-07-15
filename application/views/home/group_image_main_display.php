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
    <div class="row">
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
                
                <?php
                    } 
                ?>
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                        ?>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='/pix/default_jpg3.png?<?php echo microtime(); ?>' width="256" /></a></center>
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
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='/pix/default_jpg3.png?<?php echo microtime(); ?>' width="256" /></a></center>
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
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><img src='/pix/default_jpg3.png?<?php echo microtime(); ?>' width="256" /></a></center>
                        <br/>
                        <center><a href='/home/internal_group_images/<?php echo $userGroupArray[$index]['id']; ?>' target='_self'><?php echo $userGroupArray[$index]['group_name'];  ?></a></center>
                        <?php
                                
                                $index++;
                            }
                        ?>
                    </div>
        
        
                <div class="col-md-12"><hr></div>
                    
                <?php
                    //if($index==0)
                    //{
                ?>
                
                <?php
                    //}
                    
                    //if($index == 2)
                    //    $index =0;
                ?>    
    <?php
            }             
        }
    ?>
    </div>
    
    
    <!--------------------Video group--------------------------------->
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
           <span class="cil_title2">Group videos</span>
        </div>
    </div>
    <div class="row">
    <?php
        if(isset($userVideoGroupArray) && !is_null($userVideoGroupArray))
        {
            //var_dump($userVideoGroupArray);
            $index = 0;
            foreach($userVideoGroupArray as $videoGroup)
            {
    ?> 
        <div class="col-md-4">
            <center><a href='/home/internal_group_videos/<?php echo $videoGroup['id']; ?>' target='_self'><img src='/pix/video_group.png?<?php echo microtime(); ?>' width="200" /></a></center>
            <br/>
            <center><a href='/home/internal_group_videos/<?php echo $videoGroup['id']; ?>' target='_self'><?php echo $videoGroup['group_name'];  ?></a></center>
        </div>
    <?php
                $index++;
            }
        } 
        
    ?>
    </div>
</div>


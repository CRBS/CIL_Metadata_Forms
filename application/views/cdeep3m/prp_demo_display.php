<?php

    function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

?>


<div class="container">
    <div class="row" id="browse_header">
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <div class="cil_title2" id="browse_header_text">
        CDeep3M PRP Demo
        </div>
        </div>

        

        
    </div>
    <br/>
    <!-- <div class="row"> -->
        <?php
            $count = count($image_array);
            $index = 0;
            foreach($image_array as $image)
            {
                if($index == 0)
                   echo "<div class=\"row\">";
        ?>
        
        <div class="col-md-4">
            <?php
                if(startsWith($image, "CIL_"))
                {
                    //echo $image;
                    $id = str_replace("CIL_", "", $image);
            ?>
            <div class="row">
                <div class="col-md-12">
                <center><div class="thumbnail-kenburn">
                    <a alt="<?php echo $image ?>" title="Demo" href="<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $image; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>" target="_blank" >
                        <img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id; ?>/<?php echo $id; ?>_thumbnailx140.jpg" />
                    </a>
                     
                    </div></center>
                </div>
                <div class="col-md-12">
                    <center>
                <?php 

                        if(array_key_exists($image, $image_names))
                        {
                ?>
                        <a alt="<?php echo $image ?>" title="Demo" href="<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $image; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>" target="_blank" >
                            <b><?php
                            echo $image_names[$image];
                            ?></b>
                        </a>
                
                <?php            
                        }

                ?>  
                    </center>
                </div>
                <div class="col-md-12">
                    <?php
                        if(strcmp($image, "CIL_50667") != 0 && strcmp($image, "CIL_50668") != 0 && strcmp($image, "CIL_50669") != 0)
                        {
                    ?>
                    <center><a href="http://cellimagelibrary.org/images/<?php echo $image; ?>" target="_blank">More info</a></center>
                    <?php
                        }
                    ?>
                </div>
            </div>
          
            <?php
                }
                else if(startsWith($image, "CCDB_"))
                {
                    $id = str_replace("CCDB_", "", $image);
            ?>
            <div class="row">
                <div class="col-md-12">
             <center><div class="thumbnail-kenburn">
                <a alt="<?php echo $image ?>" title="Demo" href="<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $image; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>" target="_blank" >
                    <img src="https://cildata.crbs.ucsd.edu/display_images/ccdb/ccdb_512/<?php echo $id; ?>_512v.jpg" width="140">
                </a>
            </div></center>
                </div>
                <div class="col-md-12">
                    <center>
                <?php 

                        if(array_key_exists($image, $image_names))
                        {
                ?>
                        <a alt="<?php echo $image ?>" title="Demo" href="<?php echo $image_viewer_prefix ?>/cdeep3m_prp/<?php echo $image; ?>?username=<?php echo $username ?>&token=<?php echo $token ?>" target="_blank" >
                            <b><?php
                                echo $image_names[$image];
                                ?></b>
                        </a>
                <?php
                            
                        }

                ?>  
                    </center>
                </div>
                
                <div class="col-md-12">
                    <center><a href="http://cellimagelibrary.org/images/<?php echo $image; ?>" target="_blank">More info</a></center>
                </div>
                
            </div>
            <?php
                }
                
                
                
            ?>
        </div>
              
        <?php
                if($index == 2)
                {
                   echo "</div><!-- Closing row ".$index." -->";
                   echo "<div class='col-md-12'><br/></div>";
                   $index = 0;
                   continue;
                }
                $index++;
                
                ///if($index == 3)
                //    $index = 0;
        
            }
        ?>
    <!-- </div> -->
    <div class="row">
        <div class="col-md-12"><br/></div>
    </div>
</div>
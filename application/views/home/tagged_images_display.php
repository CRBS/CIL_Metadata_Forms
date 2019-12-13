<div class="container">
    <?php
        $i=0;
        $count = count($tag_array);
        
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
                            <a href="/tagged/images/<?php echo $tag_array[$i]; ?>" class="btn btn-info"><?php echo $tag_array[$i]; ?> datasets</a>
                            
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
                            <a href="/tagged/images/<?php echo $tag_array[$i]; ?>" class="btn btn-info"><?php echo $tag_array[$i]; ?> datasets</a>
                            
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
                           <a href="/tagged/images/<?php echo $tag_array[$i]; ?>" class="btn btn-info"><?php echo $tag_array[$i]; ?> datasets</a>
                            
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
                            <a href="/tagged/images/<?php echo $tag_array[$i]; ?>" class="btn btn-info"><?php echo $tag_array[$i]; ?> datasets</a>
                            
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

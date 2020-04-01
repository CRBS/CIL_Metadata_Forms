<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
           <span class="cil_title2">Upload trained model</span>
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
                                echo $userGroupArray[$index]['group_name']; 
                                $index++;
                            }
                        ?>
                    </div>
                    
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                                echo $userGroupArray[$index]['group_name']; 
                                $index++;
                            }
                        ?>
                    </div>
                    
                    <div class="col-md-4">
                        <?php 
                            if($index < $count)
                            {
                                echo $userGroupArray[$index]['group_name']; 
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


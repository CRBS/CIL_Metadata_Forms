<div class="container">
<div class="row">
    <div class="col-md-12"><br/></div>
    <div class="col-md-12">
        <span class="cil_title2">My retrained models</span>
    </div>
    <div class="col-md-12"><br/></div>
    <div class="col-md-12">
    <?php
    if(count($retrainArray) ==0)
        echo "Empty result!";
    ?>
    </div>
</div>
 <div class="row">
    <div class="col-md-2"><b>Process ID</b></div>
    <div class="col-md-2"><b>Image ID</b></div>
    <div class="col-md-2"><b>Start time</b></div>
    <div class="col-md-2"><b>Finish time</b></div>
    <div class="col-md-2"><b>Log file</b></div>
    <div class="col-md-2"><b>Option</b></div>
    
</div>
    <hr>
    <?php 
        foreach($retrainArray as $item)
        {
    ?>
<div class="row">
    <div class="col-md-2">
                    <?php 
                        if(!is_null($item->finish_time))
                        {
                    ?>
                    <a href="<?php echo $base_url; ?>/cdeep3m_retrain/result/<?php echo $item->id; ?>" target="_blank" ><?php echo $item->id; ?></a>
                    <?php
                        }
                        else 
                        {
                    ?>
                    <?php echo $item->id; ?>
                    <?php
                        }
                    ?>
    </div>
    <div class="col-md-2">
                    <?php 
                        if(strcmp($item->image_id,'CIL_0') == 0)
                           echo "Custom images";
                        else
                            echo $item->image_id; 
                    ?>
                </div>
                <div class="col-md-2">
                    <?php 
                    
                        if(!is_null($item->submit_time))
                        {
                            $submit_timeArray = explode(".", $item->submit_time);
                            echo $submit_timeArray[0];
                        }
                        else
                            echo $item->submit_time; 
                        
                    ?>
                </div>
                <div class="col-md-2">
                    <?php 
                    
                        if(!is_null($item->finish_time))
                        {
                            $finish_timeArray = explode(".", $item->finish_time);
                            echo $finish_timeArray[0];
                        }
                        else 
                            echo $item->finish_time; 
                        
                    ?>
                </div>
                <div class="col-md-1"><a href="http://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/logs.tar" target="_blank">Log files</a></div>
                <div class="col-md-1">
                <a href="http://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/CDEEP3M_prp.log" target="_blank">PRP log</a>
                </div>                 
                
</div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <?php
        }
    ?>
  
    
    
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <div class="bs-component">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#1fm">Prediction History</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#3fm">Retrain History</a>
                </li>
              </ul>
            </div>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade show active" id="1fm">
                  <br/>
                  
                  <!-----------------Tab1------------------------------> 
                    <div class="row">
            <div class="col-md-12">
                <span class="cil_title2">Process History - <?php if(isset($full_name)) echo $full_name;   ?></span>
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
        
            if(is_null($process_json) || count($process_json) == 0)
            {
                echo "<br/>No activities so far.";
            }
            else
            {
                foreach($process_json as $item)
                {
            ?>
            <div class="row">
                <div class="col-md-2">
                    <?php 
                        if(!is_null($item->finish_time))
                        {
                    ?>
                    <a href="<?php echo $image_viewer_prefix; ?>/cdeep3m_result/view/<?php echo $item->id; ?>" target="_blank" ><?php echo $item->id; ?></a>
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
                <div class="col-md-1"><a href="https://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/logs.tar" target="_blank">Log files</a></div>
                <div class="col-md-1">
                <a href="https://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/CDEEP3M_prp.log" target="_blank">PRP log</a>
                </div>
                <div class="col-md-2">
                    <a id="delete_prediction_data_id" name="delete_prediction_data_id" href="/home/delete_prediction_data/<?php echo $item->id ?>" target="_self" class="btn btn-danger" onclick="return confirm('Your prediction data will be permanently destroyed. Are you sure?')">Delete forever</a>
                </div>
            </div>
            <hr>    
            <?php
                }
            }
        ?>
                </div>
                
                <!-----------------End tab1-------------------------->
                
                
                <!------------------Tab2------------------------------------------->
                <div class="tab-pane fade" id="3fm">
                  
                  <br/>
                   
                    <div class="row">
                            <div class="col-md-12">
                                <span class="cil_title2">Retrain History - <?php if(isset($full_name)) echo $full_name;   ?></span>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><b>Retrain ID</b></div>
                        <div class="col-md-2"><b>Image ID</b></div>
                        <div class="col-md-2"><b>Start time</b></div>
                        <div class="col-md-2"><b>Finish time</b></div>
                        <div class="col-md-2"><b>Log file</b></div>
                    </div>
                    <hr>
                    <?php
        
            if(is_null($retrain_json) || count($retrain_json) == 0)
            {
                echo "<br/>No activities so far.";
            }
            else
            {
                foreach($retrain_json as $item)
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
                <div class="col-md-1"><a href="https://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/logs.tar" target="_blank">Log files</a></div>
                <div class="col-md-1">
                <a href="https://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $item->id; ?>/log/CDEEP3M_prp.log" target="_blank">PRP log</a>
                </div>
            </div>
            <hr>    
            <?php
                }
            }
        ?>
                 
                </div>
                <!--------------------End Tab2-------------------------->
                
                
            </div>
        
         
         
        </div>
    </div>

        
</div>

<script>
    
    
</script>
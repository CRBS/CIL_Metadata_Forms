<div class="container">
    
        <br/>
        <div class="row">
            <div class="col-md-12">
                <span class="cil_title2">Process History</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"><b>Process ID</b></div>
            <div class="col-md-2"><b>Image ID</b></div>
            <div class="col-md-3"><b>Submit time</b></div>
            <div class="col-md-3"><b>Finish time</b></div>
            <div class="col-md-2"><b>Log file</b></div>
        </div>
        <hr>
        <?php
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
            <div class="col-md-3">
                <?php echo $item->submit_time; ?>
            </div>
            <div class="col-md-3">
                <?php echo $item->finish_time; ?>
            </div>
            <div class="col-md-2">Log file</div>
        </div>
        <hr>    
        <?php
            }
        ?>
</div>


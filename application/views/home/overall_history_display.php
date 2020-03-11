<div class="container">
        <br/>
        <div class="row">
            <div class="col-md-12">
                <span class="cil_title2">Overall History</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <b>From</b> <?php echo $earliestTimestamp; ?> <b>to</b> <?php echo $oldestTimstamp; ?>
            </div>
            <div class="col-md-12"><b>Total finished processes:</b> <?php echo $numOfFinishedResults; ?></div>
            <div class="col-md-12"><b>Total failed processes:</b> <?php echo $numOfUnfinishedResults; ?></div>
        </div>
        <form action="/user/search_processes_time" method="POST">
        <div class="row">
            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <span class="cil_title2">Search process history by time</span>
            </div>
            <div class="col-md-2">
                <b>Starting time</b>
            </div>
            <div class="col-md-4">
              <input type="text" id="starting_time" name="starting_time" class="form-control">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <b>Ending time</b>
            </div>
            <div class="col-md-4">
              <input type="text" id="ending_time" name="ending_time" class="form-control">
            </div>
            <div class="col-md-6"></div>
            
            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Search processes">
            </div>
        </div>
        </form>
<?php
    if(isset($processArray))
    {
        if(count($processArray) == 0)
        {
            echo "<br/><br/>No processes found";
        }
        else
        {
        ?>
        <div class="row">
            <div class="col-md-12"><br/><br/></div>
            <div class="col-md-12"><b>Number of processes: <?php echo count($processArray); ?></b></div>
            <div class="col-md-12"><br/></div>
        </div>
        <?php
            foreach($processArray as $process)
            {
        ?>        
        <div class="row">
            
            <div class="col-md-12"></div>
            <div class="col-md-1">
                <?php
                if(!is_null($process['finish_time']))
                {
                    
                ?>
                <a href='<?php echo $image_viewer_prefix."/cdeep3m_result/view/".$process['id']; ?>' target="_blank"><?php echo $process['id']; ?></a>
                <?php
                }
                else
                {
                ?>
                <?php echo $process['id']; ?>
                <?php
                }
                ?>
                
            </div>
            <div class="col-md-2">
                <?php 
                    if(strcmp("CIL_0", $process['image_id'])==0)
                       echo "Custom images";
                    else 
                       echo $process['image_id']; ?>
            </div>
            <div class="col-md-2">
                <?php 
                    echo $process['contact_email'];
                ?>
            </div>
            <div class="col-md-2">
                <?php 
                
                    if(!is_null($process['submit_time']))
                    {
                        $submit_timeArray = explode(".", $process['submit_time']);
                        echo $submit_timeArray[0];
                    }
                    else
                        echo $process['submit_time'];
                ?>
            </div>
            <div class="col-md-2">
                <?php
                
                    if(!is_null($process['finish_time']))
                    {
                        $finish_timeArray = explode(".", $process['finish_time']);
                        echo $finish_timeArray[0];
                        
                    }
                    else
                        echo $process['finish_time'];
                ?>
            </div>
            <div class="col-md-1">
                <a href="http://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $process['id']; ?>/log/logs.tar" target="_blank">Log files</a>
            </div>
            <div class="col-md-1">
                <a href="http://cildata.crbs.ucsd.edu/cdeep3m_results/<?php echo $process['id']; ?>/log/CDEEP3M_prp.log" target="_blank">PRP log</a>
            </div>
        </div>  
        <hr>
        <?php
            }
            
            
        }
    }

?>
        
<script>
  $( function() {
    $( "#starting_time" ).datepicker();
    $( "#ending_time" ).datepicker();
  } );
</script>
</div>
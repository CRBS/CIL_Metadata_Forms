<div class="container">
    <div class="row">
        <div class="col-md-12"><br/></div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-2">
            <!-- <div class="alert alert-dismissible alert-success"> -->
            <div class="alert  alert-success"><center><strong>Submitted!</strong></center></div> 
            <!-- </div> -->
        </div>
        <div class="col-md-10"></div>
        <div class="col-md-12">
            <?php $result_url = $base_url."/cdeep3m_retrain/result/".$retrainID; ?>
            An email will be sent to you at (<?php if(isset($email)) echo $email; ?>) when the CDeep3M Retrain process is finished.<br/>
            Once processing is finished, your results will be available at <a href='<?php echo $result_url; ?>' target="_blank"><?php echo $result_url; ?></a>. It might take 30 minutes or longer.
                    
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <center><a href="/home" class="btn btn-primary">Back to the main page</a></center>
        </div>

    </div>
    
</div>
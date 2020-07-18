<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Alz data organizer</span>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <?php include_once 'breadcrumb.php'; ?>
        </div>
    </div>
    <div class="row">
        <?php
       
        //var_dump($alzDataJson);
            if(isset($alzDataJson) && !is_null($alzDataJson) && count($alzDataJson) > 0)
            {
                foreach ($alzDataJson as $alzData)
                {
                    
        ?>
        <div class="col-md-4">
            <center><a href="/alzdata_organizer/tag/<?php echo $alzData->image_id; ?>" target="_self" ><img width="256" height="256" src="https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $alzData->group_name."/".$alzData->image_id.".jpg"; ?>" /></a></center>
            <br/>
            <center><a href="/alzdata_organizer/tag/<?php echo $alzData->image_id; ?>" target="_self" ><?php echo $alzData->image_id; ?></a></center>
            <br/><br/>
        </div>
        <?php
 
                    
                }
            } 
        ?>
    </div>
    
       
</div>



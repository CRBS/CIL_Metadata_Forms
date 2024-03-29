<?php
    $id = 0;
    if(isset($numeric_id))
    {
        $id = $numeric_id;
    }
?>
<br/>

<div class="row">
    <div class="col-md-12">
        Image name: <?php echo $image_name; ?>
    </div>
    <div class="col-md-12">
        <center>
            <img src="https://cildata.crbs.ucsd.edu/media/thumbnail_display/<?php echo $id; ?>/<?php echo $id; ?>_thumbnailx512.jpg" class="img-thumbnail pull-right" width="100%">
        </center>
    </div>
    <div class="col-md-12">
        
        <form action="/image_metadata/upload_cil_image/<?php echo $id; ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return validate_cil_image_upload();">
            
                    <input class="upload_cil_image" type='file' name='userfile' accept="image/x-png, image/gif, image/jpeg" data-max-size="12048000" />
                    <input type='submit' name='submit' class="btn btn-primary" value='Upload image' />
                
        </form>
        
    </div>
    
    <div class="col-md-6">
        <?php
            if(isset($enable_unpublish_button) && $enable_unpublish_button)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="<?php echo $staging_website_prefix."/images/".$numeric_id; ?>" target="_blank" class="btn btn-primary">View image (stage)</a>      
        <?php
            }
        ?>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
        <br/>
        </div>
        
        <div class="col-md-12">
        <?php
            if(!isset($doi_exists))
            {
        ?>
        <a href="<?php echo "/image_metadata/create_doi/".$image_id; ?>" target="_self" class="btn btn-info">Create DOI</a>
        <?php
            }
            else
            {
        ?>
        <a href="<?php echo "/image_metadata/create_doi/".$image_id; ?>" target="_self" class="btn btn-info">Update DOI</a>
        <?php
            }
        ?>
        </div>
        
        <div class="col-md-12">
        <br/>
        </div>
        <div class="col-md-12">
        <?php
        if(isset($doi_exists))
        {
        ?>
        <a href="<?php echo "/image_metadata/view_doi/".$image_id; ?>" target="_blank" class="btn btn-info">View DOI Info</a>
        <?php
        }
            
        ?>
        </div>
    </div>
    
    

    
    
    <div class="col-md-12">
        <?php
            if(isset($enable_unpublish_button_prod) && $enable_unpublish_button_prod)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="<?php echo $prod_website_prefix."/images/".$numeric_id; ?>" target="_blank" class="btn btn-primary">View image (Prod)</a>      
        <?php
            }
        ?>
        
    </div>
    
    <div class="col-md-12">
        <?php
            //if(isset($enable_publish_button) && $enable_publish_button)
            //{
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="/image_metadata/publish_data/CIL_<?php echo $numeric_id; ?>" target="_self" class="btn btn-primary">Publish data (Stage)</a>
        <?php
            //}
        ?>
    </div>
    <div class="col-md-12">
        <?php
            //if(isset($enable_unpublish_button) && $enable_unpublish_button)
            if(true)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="/image_metadata/publish_data_prod/CIL_<?php echo $numeric_id; ?>" target="_self" class="btn btn-primary">Publish data (Prod)</a>
        <?php
            }
        ?>
    </div>
    
    
    <div class="col-md-12">
        <?php
            if(isset($enable_unpublish_button) && $enable_unpublish_button)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="/image_metadata/delete_es_image/CIL_<?php echo $numeric_id; ?>"  class="btn btn-danger">Unpublish (Stage)</a>
        <?php
            }
        ?>
    </div>
    
    
    <div class="col-md-12">
        <?php
            if(isset($enable_unpublish_button_prod) && $enable_unpublish_button_prod)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="/image_metadata/delete_es_image_prod/CIL_<?php echo $numeric_id; ?>"  class="btn btn-danger">Unpublish (Prod)</a>
        <?php
            }
        ?>
    </div>
    
    
    <div class="col-md-12">
        <?php
            if(isset($debug) && $debug)
            {
        ?>      
                <div class="col-md-12">
                <br/>
                </div>
                <a href="/rest/metadata_json/CIL_<?php echo $numeric_id; ?>" target="_blank" class="btn btn-primary">View JSON</a> 
        <?php
            }
        ?>
    </div>
    
    <div class="col-md-12">
        <?php
            //if(isset($user_role) && strcmp($user_role,'admin') ==0)
            //{
                
        ?>
           <!-- <div class="col-md-12">
                <br/>
            </div>
            <a href="" target="_blank" class="btn btn-primary">Create the DOI</a> -->
        <?php
            //}
        ?>
    </div>
    
    
    <?php
        if(isset($json->CIL_CCDB->CIL->CORE->GROUP_ID))
        {
    ?>
        <div class="col-md-12">
            <br/>
                
                <a href="/image_metadata/publish_group/stage/CIL_<?php echo $numeric_id; ?>" target="_self" class="btn btn-primary">Publish group(stage)</a>
        </div>
    
        <div class="col-md-12">
            <br/>
                
                <a href="/image_metadata/publish_group/prod/CIL_<?php echo $numeric_id; ?>" target="_self" class="btn btn-primary">Publish group(prod)</a>
        </div>
    <?php
        }
    ?>
    

    
    
    <div class="col-md-12"><br/></div>
    <div class="col-md-12">
        <a href="/image_metadata/delete_db_image/CIL_<?php echo $numeric_id; ?>"  class="btn btn-danger">Delete image</a>
    </div>
    
    
    
</div>


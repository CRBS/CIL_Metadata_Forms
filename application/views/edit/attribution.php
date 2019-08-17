<br/>
<span class="cil_title2">Attribution</span>
<div class="row">
    
    
    
    <!---------------- Name------------------------------------->
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">Name</label>
            <?php
            
                if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors) && 
                        is_array($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors) &&
                        count($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors) > 0)
                {
                    $contributors = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors;
                    echo "<ul>";
                    foreach($contributors as $contributor)
                    {
                        $cname = str_replace(" ", "%20", $contributor);
                        echo "<li>".$contributor."<a  href=\"/image_metadata/delete_attribution/".$image_id."/Contributors/".$cname."\" target=\"_self\"> &#x2716;</a></li>";
                    }
                    echo "</ul>";

                }
            
            ?>
            <input id="attribution_name" name="attribution_name" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
    <!---------------End Name------------------------------>
    
    
    
     <!---------------- OTHER ------------------------------------->
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">Other</label>
            <?php
            
                if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER) && 
                        is_array($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER) &&
                        count($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER) > 0)
                {
                    $contributors = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->OTHER;
                    
                    
                    echo "<ul>";
                    foreach($contributors as $contributor)
                    {
                        $cname = str_replace(" ", "%20", $contributor);
                        
                        echo "<li>".$contributor."<a  href=\"/image_metadata/delete_attribution/".$image_id."/OTHER/".$cname."\" target=\"_self\"> &#x2716;</a></li>";
                    }
                    echo "</ul>";

                }
            
            ?>
            <input id="attribution_other" name="attribution_other" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
        </div>
    </div>

    <!---------------End OTHER------------------------------>
    
    
    
    <div class="col-md-12">
        <div class="form-group">
            <?php
               
                if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs))
                {
                    $urls = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->URLs;
                    if(is_array($urls))
                    {
                        echo "<ul>";
                        foreach($urls as $url)
                        {
                            if(isset($url->Label) && isset($url->Href))
                            {
                                $label = str_replace("'", "%27", $url->Label);
                                echo "\n<li><a href='".$url->Href."' target='_blank'>URL: ".$url->Label."</a>";
                                echo "\n<a  href=\"/image_metadata/delete_attribution/".$image_id."/Attribution_url/".$label."\" target=\"_self\"> &#x2716;</a></li>";
                                echo "\n</li>";
                                
                            }
                        }
                        echo "</ul>";
                    }
                }
            
            ?>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">URL label</label>
            <input id="attribution_url_label" name="attribution_url_label" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
        </div> 
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">URL</label>
            <input id="attribution_url" name="attribution_url" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
        </div> 
    </div>
</div>

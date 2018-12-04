<br/>
<span class="cil_title2">Attribution</span>
<div class="row">
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
</div>

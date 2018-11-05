<br/>
<span class="cil_title2">Imaging Methods</span>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Image Type</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->ITEMTYPE))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->ITEMTYPE;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/ITEMTYPE/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/ITEMTYPE/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_item_type_bim" name="image_search_parms[item_type_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Image Mode</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->IMAGINGMODE))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->IMAGINGMODE;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/IMAGINGMODE/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/IMAGINGMODE/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_image_mode_bim" name="image_search_parms[image_mode_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>
<!---------------New row --------------------->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Visualization Method</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->VISUALIZATIONMETHODS;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/VISUALIZATIONMETHODS/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/VISUALIZATIONMETHODS/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_visualization_methods_bim" name="image_search_parms[visualization_methods_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Source of Contrast</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->SOURCEOFCONTRAST;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/SOURCEOFCONTRAST/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/SOURCEOFCONTRAST/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_source_of_contrast_bim" name="image_search_parms[source_of_contrast_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>
<!---------------New row --------------------->

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Relation to Intact Cell</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->RELATIONTOINTACTCELL;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/RELATIONTOINTACTCELL/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/RELATIONTOINTACTCELL/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_relation_to_intact_cell_bim" name="image_search_parms[relation_to_intact_cell_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Processing History</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->PROCESSINGHISTORY;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/PROCESSINGHISTORY/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/PROCESSINGHISTORY/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            <input id="image_search_parms_processing_history_bim" name="image_search_parms[processing_history_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>
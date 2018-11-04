<br/>
<span class="cil_title2">Biological Sources</span>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Biological Process (GO)</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->BIOLOGICALPROCESS;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/BIOLOGICALPROCESS/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/BIOLOGICALPROCESS/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
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
            <input id="image_search_parms_biological_process" name="image_search_parms[biological_process]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">  Molecular Function (GO)</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->MOLECULARFUNCTION;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/MOLECULARFUNCTION/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/MOLECULARFUNCTION/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
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
            <input id="image_search_parms_molecular_function" name="image_search_parms[molecular_function]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>
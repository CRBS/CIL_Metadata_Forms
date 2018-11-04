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
        
    </div>
</div>
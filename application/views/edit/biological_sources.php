<br/>
<span class="cil_title2">Biological Sources</span>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> NCBI Organismal Classification</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION))
                {
                    
                    $ncbiJson = $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION;
                    
                    if(is_array($ncbiJson))
                    {
                        echo "Is_array";
                        echo "<ul>";
                        foreach($ncbiJson as $ncbi)
                        {
                            if(isset($ncbi->free_text))
                                echo "<li>".$ncbi->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/NCBIORGANISMALCLASSIFICATION/".$ncbi->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($ncbi->onto_name) && isset($ncbi->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$ncbi->onto_id."\">".$ncbi->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/NCBIORGANISMALCLASSIFICATION/".$ncbi->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        echo "Is_NOT_array";
                    }
                }
            ?>
            
            <input id="image_search_parms_ncbi" name="image_search_parms[ncbi]" style="width: 100%" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off" type="text">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Type</label>
            <input id="image_search_parms_cell_type" name="image_search_parms[cell_type]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off"> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Line</label>
            <input id="image_search_parms_cell_line" name="image_search_parms[cell_line]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Component (GO)</label>
            <input id="image_search_parms_cellular_component" name="image_search_parms[cellular_component]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>

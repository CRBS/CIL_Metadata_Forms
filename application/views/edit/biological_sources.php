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
                        //echo "Is_NOT_array";
                    }
                }
            ?>
            
            <input id="image_search_parms_ncbi" name="image_search_parms[ncbi]" style="width: 100%" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off" type="text">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Type</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE))
                {
                    
                    $cellTypeJson = $json->CIL_CCDB->CIL->CORE->CELLTYPE;
                    
                    if(is_array($cellTypeJson))
                    {
                        echo "<ul>";
                        foreach($cellTypeJson as $cellType)
                        {
                            if(isset($cellType->free_text))
                                echo "<li>".$cellType->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/CELLTYPE/".$cellType->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($cellType->onto_name) && isset($cellType->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$cellType->onto_id."\">".$cellType->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/CELLTYPE/".$cellType->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
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
            <input id="image_search_parms_cell_type" name="image_search_parms[cell_type]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off"> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Line</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->CELLLINE))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->CELLLINE;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/CELLLINE/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/CELLLINE/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
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
            <input id="image_search_parms_cell_line" name="image_search_parms[cell_line]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Component (GO)</label>
            <?php 
                if(isset($json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT))
                {
                    $itemsJson = $json->CIL_CCDB->CIL->CORE->CELLULARCOMPONENT;
                    if(is_array($itemsJson))
                    {
                        echo "<ul>";
                        foreach($itemsJson as $item)
                        {
                            if(isset($item->free_text))
                                echo "<li>".$item->free_text."<a  href=\"/image_metadata/delete_field/".$image_id."/CELLULARCOMPONENT/".$item->free_text."\" target=\"_self\"> &#x2716;</a></li>";
                            else if(isset($item->onto_name) && isset($item->onto_id))
                            {
                                echo "<li><a href=\"#\" data-toggle=\"tooltip\" title=\"".$item->onto_id."\">".$item->onto_name."</a><a  href=\"/image_metadata/delete_field/".$image_id."/CELLULARCOMPONENT/".$item->onto_name."\" target=\"_self\"> &#x2716;</a></li>";
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
            <input id="image_search_parms_cellular_component" name="image_search_parms[cellular_component]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
        </div>
    </div>
</div>

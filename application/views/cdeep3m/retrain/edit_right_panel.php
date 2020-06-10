<?php

    function formatIput($input)
    {
        $input = str_replace("(", "%28", $input);
        $input = str_replace(")", "%29", $input);
        return $input;     
    }

?>

    <div class="row">
        
        <div class="col-md-12">
            <span class="cil_title2">Retrained model metadata</span>
        </div>
        <div class="col-md-12">
            <input type="submit" name="submit" class="btn btn-primary float-right" value="Update">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Model Name</label>
            <input id="trained_model_name" name="trained_model_name" style="width: 100%" value="<?php 
            
            if(!is_null($mjson) && isset($mjson->Cdeepdm_model->Name))
                echo $mjson->Cdeepdm_model->Name;
            
            ?>" class="form-control cil_san_regular_font"  type="text">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">NCBI Organismal Classification</label>
            <?php
                if(isset($mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION) && count($mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION)>0)
                {
                    $ncbiArray = $mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION;
                    foreach($ncbiArray as $ncbi)
                    {
            ?>      
            <ul>
                
                <li>
                    <?php 
                        if(isset($ncbi->onto_id) && isset($ncbi->onto_name))
                        {
                    ?>        
                    <a href="#" data-toggle="tooltip" title="<?php echo $ncbi->onto_id; ?>"><?php echo $ncbi->onto_name;  ?></a><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/NCBIORGANISMALCLASSIFICATION/<?php echo formatIput($ncbi->onto_name); ?>" target="_self"> ✖</a>
                    <?php
                        }
                        else if(isset($ncbi->free_text))
                        {
                    ?>
                    <?php echo $ncbi->free_text; ?><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/NCBIORGANISMALCLASSIFICATION/<?php  echo formatIput($ncbi->free_text); ?>" target="_self"> ✖</a>
                    <?php
                        }
                    ?>
                </li>
            </ul>

            <?php
                    }
                }
            ?>
            
            <input id="image_search_parms_ncbi" name="image_search_parms[ncbi]" style="width: 100%" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off" type="text">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Cell Type</label>
            <?php
                if(isset($mjson->Cdeepdm_model->CELLTYPE) && count($mjson->Cdeepdm_model->CELLTYPE)>0)
                {
                    $ncbiArray = $mjson->Cdeepdm_model->CELLTYPE;
                    foreach($ncbiArray as $ncbi)
                    {
            ?>      
            
            <ul>
                
                <li>
                    <?php 
                        if(isset($ncbi->onto_id) && isset($ncbi->onto_name))
                        {
                    ?>        
                    <a href="#" data-toggle="tooltip" title="<?php echo $ncbi->onto_id; ?>"><?php echo $ncbi->onto_name;  ?></a><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/CELLTYPE/<?php echo $ncbi->onto_name; ?>" target="_self"> ✖</a>
                    <?php
                        }
                        else if(isset($ncbi->free_text))
                        {
                    ?>
                    <?php echo $ncbi->free_text; ?><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/CELLTYPE/<?php  echo $ncbi->free_text; ?>" target="_self"> ✖</a>
                    <?php
                        }
                    ?>
                </li>
            </ul>

            <?php
                    }
                }
            ?>
            
            <input id="image_search_parms_cell_type" name="image_search_parms[cell_type]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off"> 
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Component (GO)</label>
            <?php
                if(isset($mjson->Cdeepdm_model->CELLULARCOMPONENT) && count($mjson->Cdeepdm_model->CELLULARCOMPONENT)>0)
                {
                    $ncbiArray = $mjson->Cdeepdm_model->CELLULARCOMPONENT;
                    foreach($ncbiArray as $ncbi)
                    {
            ?>      
            <ul>
                <li>
                    <?php 
                        if(isset($ncbi->onto_id) && isset($ncbi->onto_name))
                        {
                    ?>        
                    <a href="#" data-toggle="tooltip" title="<?php echo $ncbi->onto_id; ?>"><?php echo $ncbi->onto_name;  ?></a><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/CELLULARCOMPONENT/<?php echo $ncbi->onto_name; ?>" target="_self"> ✖</a>
                    <?php
                        }
                        else if(isset($ncbi->free_text))
                        {
                    ?>
                    <?php echo $ncbi->free_text; ?><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/CELLULARCOMPONENT/<?php  echo $ncbi->free_text; ?>" target="_self"> ✖</a>
                    <?php
                        }
                    ?>
                </li>
            </ul>
            <?php
                    }
                }
            ?>
            <input id="image_search_parms_cellular_component" name="image_search_parms[cellular_component]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
            </div>
        </div><div class="col-md-6"></div>
    </div>


    

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Microscope Type</label>
            <?php
                if(isset($mjson->Cdeepdm_model->ITEMTYPE) && count($mjson->Cdeepdm_model->ITEMTYPE)>0)
                {
                    $ncbiArray = $mjson->Cdeepdm_model->ITEMTYPE;
                    foreach($ncbiArray as $ncbi)
                    {
            ?>      

            <ul>
                <li>
                    <?php 
                        if(isset($ncbi->onto_id) && isset($ncbi->onto_name))
                        {
                    ?>        
                    <a href="#" data-toggle="tooltip" title="<?php echo $ncbi->onto_id; ?>"><?php echo $ncbi->onto_name;  ?></a><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/ITEMTYPE/<?php echo formatIput($ncbi->onto_name); ?>" target="_self"> ✖</a>
                    <?php
                        }
                        else if(isset($ncbi->free_text))
                        {
                    ?>
                    <?php echo $ncbi->free_text; ?><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/ITEMTYPE/<?php  echo formatIput($ncbi->free_text); ?>" target="_self"> ✖</a>
                    <?php
                        }
                    ?>
                </li>
            </ul>
            
            <?php
                    }
                }
            ?>
            <input id="image_search_parms_item_type_bim" name="image_search_parms[item_type_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Magnification</label>
            <input id="magnification" name="magnification" style="width: 100%" value="<?php if(isset($mjson->Cdeepdm_model->Magnification)) echo $mjson->Cdeepdm_model->Magnification; ?>" class="form-control cil_san_regular_font"  type="text">
            </div>
       </div><div class="col-md-6"></div>
    </div>

    <!------ Old Voxel size --->
    <!-- <div class="row">
       <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Voxel size</label>
            <input id="voxelsize" name="voxelsize" style="width: 100%" value="<?php //if(isset($mjson->Cdeepdm_model->Voxelsize) && isset($mjson->Cdeepdm_model->Voxelsize->Value)) echo $mjson->Cdeepdm_model->Voxelsize->Value; ?>" class="form-control cil_san_regular_font"  type="text"> 
            </div>
       </div><div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label" for="voxelsize_unit">&nbsp;</label>
                       <select class="form-control cil_san_regular_font" id="voxelsize_unit" name="voxelsize_unit">
                       <option value="µm" <?php //if(isset($mjson->Cdeepdm_model->Voxelsize) && isset($mjson->Cdeepdm_model->Voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Voxelsize->Unit, "µm")==0) echo "selected"; ?>>µm</option>
                       <option value="nm" <?php //if(isset($mjson->Cdeepdm_model->Voxelsize) && isset($mjson->Cdeepdm_model->Voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Voxelsize->Unit, "nm")==0) echo "selected"; ?>>nm</option>
                     </select>
                </div>
       </div><div class="col-md-4">
       </div>
    </div> -->
    <!------End Old Voxel size --->

    
    <!-----X voxel size --->
    <div class="row">
       <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*X Voxel size</label>
            <input id="x_voxelsize" name="x_voxelsize" style="width: 100%" value="<?php if(isset($mjson->Cdeepdm_model->X_voxelsize) && isset($mjson->Cdeepdm_model->X_voxelsize->Value)) echo $mjson->Cdeepdm_model->X_voxelsize->Value; ?>" class="form-control cil_san_regular_font"  type="text"> 
            </div>
       </div><div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label" for="x_voxelsize_unit">&nbsp;</label>
                       <select class="form-control cil_san_regular_font" id="x_voxelsize_unit" name="x_voxelsize_unit">
                       <option value="µm" <?php if(isset($mjson->Cdeepdm_model->X_voxelsize) && isset($mjson->Cdeepdm_model->X_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->X_voxelsize->Unit, "µm")==0) echo "selected"; ?>>µm</option>
                       <option value="nm" <?php if(isset($mjson->Cdeepdm_model->X_voxelsize) && isset($mjson->Cdeepdm_model->X_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->X_voxelsize->Unit, "nm")==0) echo "selected"; ?>>nm</option>
                     </select>
                </div>
       </div><div class="col-md-4">
       </div>
    </div>
    <!-----End X voxel size --->
    
    <!-----Y voxel size --->
    <div class="row">
       <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Y Voxel size</label>
            <input id="y_voxelsize" name="y_voxelsize" style="width: 100%" value="<?php if(isset($mjson->Cdeepdm_model->Y_voxelsize) && isset($mjson->Cdeepdm_model->Y_voxelsize->Value)) echo $mjson->Cdeepdm_model->Y_voxelsize->Value; ?>" class="form-control cil_san_regular_font"  type="text"> 
            </div>
       </div><div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label" for="y_voxelsize_unit">&nbsp;</label>
                       <select class="form-control cil_san_regular_font" id="y_voxelsize_unit" name="y_voxelsize_unit">
                       <option value="µm" <?php if(isset($mjson->Cdeepdm_model->Y_voxelsize) && isset($mjson->Cdeepdm_model->Y_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Y_voxelsize->Unit, "µm")==0) echo "selected"; ?>>µm</option>
                       <option value="nm" <?php if(isset($mjson->Cdeepdm_model->Y_voxelsize) && isset($mjson->Cdeepdm_model->Y_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Y_voxelsize->Unit, "nm")==0) echo "selected"; ?>>nm</option>
                     </select>
                </div>
       </div><div class="col-md-4">
       </div>
    </div>
    <!-----End Y voxel size --->
    
    <!-----Z voxel size --->
    <div class="row">
       <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Z Voxel size</label>
            <input id="z_voxelsize" name="z_voxelsize" style="width: 100%" value="<?php if(isset($mjson->Cdeepdm_model->Z_voxelsize) && isset($mjson->Cdeepdm_model->Z_voxelsize->Value)) echo $mjson->Cdeepdm_model->Z_voxelsize->Value; ?>" class="form-control cil_san_regular_font"  type="text"> 
            </div>
       </div><div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label" for="z_voxelsize_unit">&nbsp;</label>
                       <select class="form-control cil_san_regular_font" id="z_voxelsize_unit" name="z_voxelsize_unit">
                       <option value="µm" <?php if(isset($mjson->Cdeepdm_model->Z_voxelsize) && isset($mjson->Cdeepdm_model->Z_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Z_voxelsize->Unit, "µm")==0) echo "selected"; ?>>µm</option>
                       <option value="nm" <?php if(isset($mjson->Cdeepdm_model->Z_voxelsize) && isset($mjson->Cdeepdm_model->Z_voxelsize->Unit) && strcmp($mjson->Cdeepdm_model->Z_voxelsize->Unit, "nm")==0) echo "selected"; ?>>nm</option>
                     </select>
                </div>
       </div><div class="col-md-4">
       </div>
    </div>
    <!-----End Z voxel size --->
    
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Contributor</label>
            <?php
                if(isset($mjson->Cdeepdm_model->Contributors) && count($mjson->Cdeepdm_model->Contributors)>0)
                {
                    $ncbiArray = $mjson->Cdeepdm_model->Contributors;
                    foreach($ncbiArray as $ncbi)
                    {
            ?>      
            <ul>
                <li>
                    
                    <?php
                        if(!is_null($ncbi))
                        {
                    ?>
                    <?php echo $ncbi; ?><a href="/cdeep3m_models/delete_field/<?php echo $model_id; ?>/Contributors/<?php  echo $ncbi; ?>" target="_self"> ✖</a>
                    <?php
                        }
                    ?>
                </li>
            </ul>

            <?php
                    }
                }
            ?>
            
            <input id="contributor" name="contributor" style="width: 100%" value="" class="form-control cil_san_regular_font" autocomplete="off" type="text">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        
        <div class="col-md-12">
             <label class="col-form-label" for="inputDefault">*Description</label>
            <textarea rows="4" cols="50" class="form-control cil_san_regular_font" name="description" id="description"><?php
            if(!is_null($mjson) && isset($mjson->Cdeepdm_model->Description))
                echo $mjson->Cdeepdm_model->Description;
            
            ?></textarea> 
        </div>
    </div>

     <div class="row">
           <div class="col-md-12">
               <div id="myModal" class="modal">
                    <div class="modal-dialog" role="document">
                       <div class="modal-content">
                         <div class="modal-header">
                           <h5 class="modal-title">Modal title</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">×</span>
                           </button>
                         </div>
                         <div class="modal-body">
                           <p>Modal body text goes here.</p>
                         </div>
                         <div class="modal-footer">
                           <button type="button" class="btn btn-primary">Save changes</button>
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         </div>
                       </div>
                     </div>
               </div>
           </div>
       </div> 

       
    <div class="row">
        <div class="col-md-12"> <br/></div>
        <div class="col-md-3">
           
           <input type="submit" name="submit" class="btn btn-primary" value="Update">
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-3">
           <!-- <a href="#" target="_self" class="btn btn-warning">Exit</a> -->
        </div>
    </div>

<script>

    
    
</script>
<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-1"><img src="/pix/fitler_128.png" width="52px" /> </div>
        <div class="col-md-1">
            <b>Imaging Type</b>
        </div>
        <div class="col-md-2">
            
            <select name="image_type_id" id="image_type_id" class="form-control" >
                <option value="None">None</option>
                <option value="SBEM">SBEM</option>
                <option value="TEM">TEM</option>
                <option value="Fluorescence">Fluorescence</option>
                <option value="XRM">XRM</option>
            </select>
        </div>
        <div class="col-md-1">
            <b>Cell structure</b>
        </div>
        <div class="col-md-2">
            
            <select name="cell_struct_id" id="cell_struct_id" class="form-control" >
                <option value="None">None</option>
                <option value="Mitochondria">Mitochondria</option>
                <option value="Synapses">Synapses</option>
                <option value="Vesicles">Vesicles</option>
                <option value="Nuclei">Nuclei</option>
                <option value="Axons">Axons</option>
            </select>
        </div>
        
        <div class="col-md-2">
            <b>&nbsp;</b>
             <button type="button" onclick="updateDropDown()" class="btn btn-primary">Filter</button> 
        </div>
    </div>
    <br/>
    <?php 
        foreach($publishedModelArray as $model)
        {
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php
                
                $json_str = $model['metadata_json'];
                $model_id = $model['model_id'];
                //echo "<br/>".$json_str;
                $json = json_decode($json_str);
                $cc_name = "";
                $scope_names = "";
                
                
                
                if(isset($json->Cdeepdm_model->CELLULARCOMPONENT))
                {
                    $cc = $json->Cdeepdm_model->CELLULARCOMPONENT;
                    if(!is_null($cc) && count($cc) > 0)
                    {
                        $cc_item = $cc[0];
                        if(isset($cc_item->free_text))
                        {
                            $cc_name= $cc_item->free_text;
                            //echo "<br/><br/>".$cc_item->free_text;
                            
                        }
                    }
                }
                
                if(isset($json->Cdeepdm_model->ITEMTYPE))
                {
                    $its = $json->Cdeepdm_model->ITEMTYPE;
                    if(!is_null($its) && count($its) > 0)
                    {
                        foreach($its as $it_item)
                        {
                            
                            if(isset($it_item->free_text))
                            {
                                $scope_names = $it_item->free_text." ";
                                //echo "<br/><br/>".$it_item->free_text;

                            }
                        }
                    }
                }
                
                $title = $scope_names." ".$cc_name." (".$model_id.")";
                
                if(strcmp($image_type, "None") != 0 || strcmp($cell_structure, "None") != 0)
                {
                    if(strcmp($image_type, "None") != 0)
                    {
                        if(strpos($title, $image_type) == false)
                        {
                            continue;
                        }
                    }
                    
                    if(strcmp($cell_structure, "None") != 0)
                    {
                        $hasMatch = false;
                        if(isset($json->Cdeepdm_model->CELLULARCOMPONENT))
                        {
                            
                            $ccArray = $json->Cdeepdm_model->CELLULARCOMPONENT;
                            foreach($ccArray as $cc)
                            {
                                if(isset($cc->free_text))
                                {
                                    if(strlen($cc->free_text) > 0)
                                    {
                                        if(strpos($cc->free_text, $cell_structure) !== false)
                                            $hasMatch = true;
                                    }
                                }
                            }
                            
                            
                        }
                        if(!$hasMatch)
                           continue;
                    }
                }
                
                //echo "<br/><br/>".$title;
                $x_voxel_sum = "";
                $y_voxel_sum = "";
                $z_voxel_sum = "";
                if(isset($json->Cdeepdm_model->X_voxelsize))
                {
                    $x_vol = $json->Cdeepdm_model->X_voxelsize;
                    if(isset($x_vol->Value) && isset($x_vol->Unit) && !is_null($x_vol->Value) && !is_null($x_vol->Unit))
                    {
                        $x_voxel_sum = $x_vol->Value." ".$x_vol->Unit;
                    }
                }
                
                if(isset($json->Cdeepdm_model->Y_voxelsize))
                {
                    $y_vol = $json->Cdeepdm_model->Y_voxelsize;
                    if(isset($y_vol->Value) && isset($y_vol->Unit) && !is_null($y_vol->Value) && !is_null($y_vol->Unit))
                    {
                        $y_voxel_sum = $y_vol->Value." ".$y_vol->Unit;
                    }
                }
                
                if(isset($json->Cdeepdm_model->Z_voxelsize))
                {
                    $z_vol = $json->Cdeepdm_model->Z_voxelsize;
                    if(isset($z_vol->Value) && isset($z_vol->Unit) && !is_null($z_vol->Value) && !is_null($z_vol->Unit))
                    {
                        $z_voxel_sum = $z_vol->Value." ".$z_vol->Unit;
                    }
                }
                
            ?>
        </div>
        <div class="col-md-12">
            <span class="cil_title2"><?php echo $title; ?></span>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="biological_sources">

            <dl>
    

                <dt><span class=""><b>Trained model</b></span></dt>
                    <dd class="eol_dd">
                    <span>
                        &#8226;&nbsp;<?php if(isset($json->Cdeepdm_model->Name)) echo $json->Cdeepdm_model->Name; ?>               </span>
                    </dd>


                <dt><span class="" style="font-weight:bold">Description</span></dt>
                <dd class="eol_dd">
                <span>
                    &#8226;&nbsp;<?php if(isset($json->Cdeepdm_model->Description)) echo $json->Cdeepdm_model->Description; ?>  </span>
                </span>
                </dd>

                
                <dt><span class="" style="font-weight:bold">X Voxelsize</span></dt>
                <dd class="eol_dd">
                <span>
                &#8226;&nbsp;<?php echo $x_voxel_sum; ?>              </span>
                </dd>
                
                <dt><span class="" style="font-weight:bold">Y Voxelsize</span></dt>
                <dd class="eol_dd">
                <span>
                &#8226;&nbsp;<?php echo $y_voxel_sum; ?>               </span>
                </dd>
                
                <dt><span class="" style="font-weight:bold">Z Voxelsize</span></dt>
                <dd class="eol_dd">
                <span>
                &#8226;&nbsp;<?php echo $z_voxel_sum; ?>                </span>
                </dd>

                                
                <!------------------Cellular component -------------->
                                
                <dt><span class="" style="font-weight:bold">Cellular component</span></dt>
                <?php 
                    if(isset($json->Cdeepdm_model->CELLULARCOMPONENT))
                    {
                        $ccArray = $json->Cdeepdm_model->CELLULARCOMPONENT;
                        foreach($ccArray as $cc)
                        {
                            $cc_name = "";
                            if(isset($cc->free_text))
                                $cc_name = $cc->free_text;
                ?>
                <dd class="eol_dd">
                <span>
                     &#8226;&nbsp;<?php echo $cc_name; ?>             
                </span>
                </dd>
                <?php
                        }
                    }
                    else
                    {
                ?>
                <dd class="eol_dd">
                <span>
                     &#8226;&nbsp;           
                </span>
                </dd>
                <?php
                    }
                ?>
                <!------------------End Cellular component -------------->
                
                
                <!------------------Author -------------->
                                
                <dt><span class="" style="font-weight:bold">Author</span></dt>
                                        
                <?php 
                    if(isset($json->Cdeepdm_model->Contributors))
                    {
                        $cArray = $json->Cdeepdm_model->Contributors;
                        foreach($cArray as $c_name)
                        {
                            
                            
                ?>
                <dd class="eol_dd">
                <span>
                     &#8226;&nbsp;<?php echo $c_name; ?>             
                </span>
                </dd>
                <?php
                        }
                    }
                ?>
                <!------------------End Author -------------->
                
                
                <dt><span class="" style="font-weight:bold">DOI</span></dt>
                       
                
                <dd class="eol_dd">
                <span>
                &#8226;&nbsp;https://doi.org/10.7295/W9CDEEP3M<?php echo $model_id; ?>                
                </span>
                </dd>
                
            </dl>
            </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <a href="https://cildata.crbs.ucsd.edu/media/model_display/<?php echo $model_id; ?>/<?php echo $model_id; ?>_thumbnailx512.jpg" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" target="_blank"><img src="https://cildata.crbs.ucsd.edu/media/model_display/<?php echo $model_id; ?>/<?php echo $model_id; ?>_thumbnailx512.jpg" width="512px" height="512px"></a>
            
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <center><a href="https://doi.org/10.7295/W9CDEEP3M<?php echo $model_id; ?>" class="btn btn-outline-primary" target="_blank" alt="Model <?php echo $model_id; ?> Download">Download</a></center>
        </div>
    </div>
    <hr>
    <?php
        }
    ?>

</div>

<script>
    function updateDropDown()
    {
        var image_type_id = document.getElementById('image_type_id').value;
        var cell_struct_id = document.getElementById('cell_struct_id').value;
        
        //console.log(image_type_id);
        //console.log(cell_struct_id);
        
        window.location.href = "<?php echo $base_url; ?>/home/pre_trained_models?image_type="+image_type_id+"&cell_structure="+cell_struct_id;
    }
    
    
</script>
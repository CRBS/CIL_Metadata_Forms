<?php
    //echo ($biopsyIdBlockArray);
?>

<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Alz data organizer</span>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <?php include_once 'breadcrumb.php'; ?>
        </div>
    </div>
    <div class="row">
        <?php
       
        //var_dump($alzDataJson);
            if(isset($alzDataJson) && !is_null($alzDataJson) && count($alzDataJson) > 0)
            {
                foreach ($alzDataJson as $alzData)
                {
                    
        ?>
        <div class="col-md-4">
            <center><a href="#" target="_self" onclick="imageClick('<?php echo $alzData->image_id; ?>')"><img width="256" height="256" src="https://cildata.crbs.ucsd.edu/media/internal_group_display/<?php echo $alzData->group_name."/".$alzData->image_id.".jpg"; ?>" /></a></center>
            <br/>
            <!-- <center><a href="/alzdata_organizer/tag/<?php //echo $alzData->image_id; ?>" target="_self" ><?php //echo $alzData->image_id; ?></a></center> -->
            <center><a href="#" target="_self" onclick="imageClick('<?php echo $alzData->image_id; ?>')"><?php echo $alzData->image_id; ?></a>
            
            <?php
                foreach($allImageInfoArray as $imageInfo)
                {
                    if(strcmp($alzData->image_id, $imageInfo['image_id']) == 0)
                    {
                         $desc = ":<center>".$imageInfo['biopsy_name'].", ".$imageInfo['block_name'];
                         //if(!is_null($imageInfo['roi_id']) || !is_null($imageInfo['roi_name']))
                             $desc = $desc.", ".$imageInfo['section_name'].", ".$imageInfo['roi_name'];
                         $desc = $desc.", ".$imageInfo['image_type']."</center>";
                         echo $desc;
                         break;
                    }
                }
            
            ?>
                </center><br/>
        </div>
        <?php
 
                    
                }
            } 
        ?>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div id="tag_modal_id" class="modal">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Select image type</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        
                        <form action="/Alzdata_organizer/tag_image" method="POST">
                        Image Name: <input type="text" id="image_name_id" name="image_name_id" readonly="" class="form-control" value="">
                      <br/>
                      Biopsy source: <select name="biopsy_source_id" id="biopsy_source_id" class="form-control" onchange="updateBlocks()">
                                        <?php
                                            foreach($biopsy_info as $biopsy)
                                            {
                                        ?>         
                                                <option value="<?php echo $biopsy->id; ?>"><?php echo $biopsy->biopsy_name; ?></option>
                                        <?php
                                            }
                                        ?>
                                     </select>
                          
                      <br/>
                      Block: <select name="block_id" id="block_id" class="form-control" onchange="updateSection()">  
                                    <?php
                                        //echo $biopsyIdBlockStr;
                                        $biopsyIdBlockArray = json_decode($biopsyIdBlockStr);
                                        //var_dump($biopsyIdBlockArray);
                                        $blockArray = $biopsyIdBlockArray->{"1"};
                                        foreach ($blockArray as $block)
                                        {
                                    ?>  
                                            <option value="<?php echo $block->block_id; ?>"><?php echo $block->block_name; ?></option> 
                                    <?php
                                        }
                                    
                                    ?>
                             </select>
                      <br/>
                      
                      Serial section: <select name="section_id" id="section_id" class="form-control" onchange="updateROI()">
                          
                      </select>
                      <br/>
                      
                      ROI: <select name="roi_id" id="roi_id" class="form-control" >
                          
                      </select>
                      <br/>
                      
                      Image type: <select name="image_type_id" id="image_type_id" class="form-control">
                                    <option value="3D XRM">3D XRM</option>
                                    <option value="SEM Mosaic">SEM Mosaic</option>
                                    <option value="Serial-section SEM">Serial-section SEM</option>
                                    <option value="Serial-section TEM">Serial-section TEM</option>
                                  </select>
                      <br/>
                      <center><input type="submit" value="Submit" class="btn btn-primary"></center>
                        </form>
                    </div>
                    <div class="modal-footer">
                      
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
       
</div>


<script>
    
    var jsonStr = '<?php echo $biopsyIdBlockStr; ?>';
    var biopsyBlockJson = JSON.parse(jsonStr);
    
    var roiStr = '<?php echo $roi_str; ?>';
    var roiJson = JSON.parse(roiStr);
    
    var sectionStr = '<?php echo $section_str; ?>';
    var sectionJson = JSON.parse(sectionStr);
    
    function updateBlocks() 
    {
        
        var biopsy_id = document.getElementById('biopsy_source_id').value;
        var block = document.getElementById('block_id');
        block.innerHTML="";
        //alert(biopsy_id);
        var barray = biopsyBlockJson[biopsy_id];
        //console.log(barray);
        for(i=0;i<barray.length;i++)
        {
            var opt = document.createElement('option');
            opt.text = barray[i].block_name;
            opt.value = barray[i].block_id;
            block.add(opt, null);
        }
        
        //updateROI();
        updateSection();
    }
    
    function updateSection()
    {
        var sectionSelect = document.getElementById('section_id');
        sectionSelect.innerHTML="";
        var block_id = document.getElementById("block_id").value;
        block_id = parseInt(block_id);
        
        var opt = document.createElement('option');
        opt.text = "NA";
        opt.value = "-1";
        sectionSelect.add(opt, null);
        
        for(i=0;i<sectionJson.length;i++)
        {
            var section = sectionJson[i];
            if(block_id == section.block_id)
            {
                //console.log("block id matched:"+block_id);
                opt = document.createElement('option');
                opt.text = section.serial_section_name;
                opt.value = section.id;
                sectionSelect.add(opt, null);
            }
        }
        
        updateROI();
    }
    
    function updateROI()
    {
        //console.log('updateROI');
        //console.log(roiJson);
        var roiSelect = document.getElementById('roi_id');
        roiSelect.innerHTML="";
        var section_id = document.getElementById("section_id").value;
        section_id = parseInt(section_id);
        //console.log("block_id:"+block_id);
        
        var opt = document.createElement('option');
        opt.text = "NA";
        opt.value = "-1";
        roiSelect.add(opt, null);
        
        
        for(i=0;i<roiJson.length;i++)
        {
            var roi = roiJson[i];
            if(section_id == roi.serial_section_id)
            {
                opt = document.createElement('option');
                opt.text = roi.roi_name;
                opt.value = roi.id;
                roiSelect.add(opt, null);
            }
        }
                    
        
        
    }
    
    function imageClick(image_id)
    {
        //alert('hello');
        document.getElementById('image_name_id').value = image_id;
         $("#tag_modal_id").modal('show');
    }
    
    
    updateSection();
    updateROI();
    
</script>
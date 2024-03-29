<?php

    function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

?>
<form action="/cdeep3m_preview/submit_preview_job/<?php echo $crop_id; ?>" method="POST" onsubmit="do_submit_tasks()">
<div class="container">
    
    <div class="row">
        <div class="col-md-12">
             <?php include_once 'images_breadcrumb.php'; ?>
         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
            <span class="cil_title2">Run CDeep3M Preview Step 2: Select CDeep3M parameters</span>
        </div>
    </div>            
    <div class="row">
        <div class="col-md-8">
                <div class="row">
                           
                    <div class="col-md-12"><br/></div>
                            <!-----Training model-------------->
                            <div class="col-md-4">
                                 Trained model:
                            </div>
                            <div class="col-md-6">
                                <select name="ct_training_models" id="ct_training_models" class="form-control" onchange="showRuntime()">
                                    <!--
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50682">SBEM synaptic vesicles (50682)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50681">SBEM and ssTEM Mitochondria  (50681)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50673">SEMTEM membranes (50673)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50685">Synapses (50685)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50687">SBEM Membranes (denoised) (50687)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50689">SBEM Mitochondria (denoised) (50689)</option>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M50692">SBEM Membranes (denoised, resize augm.) (50692)</option>  
                                    -->
                                    <?php
                                        if(isset($all_model_json) && is_array($all_model_json))
                                        {
                                            foreach($all_model_json as $mjson)
                                            {
                                                if(isset($mjson->Cdeepdm_model->Version_number) && startsWith($mjson->Cdeepdm_model->Version_number, "2"))
                                                {
                                    ?>
                                                    <option value="https://doi.org/10.7295/W9CDEEP3M<?php echo $mjson->id ?>" style='color:#29a329'><?php  if(isset($mjson->Cdeepdm_model->Name)) echo $mjson->Cdeepdm_model->Name." (".$mjson->id.") "; if(isset($mjson->Cdeepdm_model->Version_number)){ echo "[v".$mjson->Cdeepdm_model->Version_number."]"; } ?></option>
                                   <?php
                                                }
                                                else 
                                                {
                                    ?>               
                                                    <option value="https://doi.org/10.7295/W9CDEEP3M<?php echo $mjson->id ?>"><?php  if(isset($mjson->Cdeepdm_model->Name)) echo $mjson->Cdeepdm_model->Name." (".$mjson->id.") "; if(isset($mjson->Cdeepdm_model->Version_number)){ echo "[v".$mjson->Cdeepdm_model->Version_number."]"; } ?></option>
                                    <?php
                                                }
                                            }
                                        }
                                    
                                    
                                    ?>
                                </select> 
                            </div>
                            <div class="col-md-2"><a href="http://cellimagelibrary.org/cdeep3m" target="_blank">Details</a></div>
                            <!-----End Training model-------------->
                            <hr style="height:10px; visibility:hidden;" />
                            <!------------------Augmentation---------------->
                            <div class="col-md-4">
                                Augspeed:
                            </div>
                            <div class="col-md-6">
                                <select name="ct_augmentation" id="ct_augmentation" class="form-control" onchange="showRuntime()"> 
                                    <option value="10">10</option>
                                    <!-- <option value="8">8</option> -->
                                    <option value="4">4</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select> 
                                
                            </div> 
                            <div class="col-md-2"> 
                                <!-- <a href="#"  data-toggle="tooltip" data-placement="left" data-html="true" title="Augspeed 10: fastest, no addtl augmentation <br/>Augspeed 1: slowest, 16x augmented (8x for 1fm), higher accuracy">Help</a>  -->
                                <a href="#" style="color:#00aaff" title="Augspeed 10: fastest, no addtl augmentation
Augspeed 1: slowest, 16x augmented (8x for 1fm), higher accuracy" >Info</a> 
                                   
                            </div> 
                                   
                            <div class="col-md-4">
                                Neural net:
                            </div>
                            <div class="col-md-6">
                                <!-- <input type="checkbox" id="fm1" name="fm1" value="1fm" onclick="frame_change('fm1')" checked>1fm&nbsp;&nbsp;
                                <input type="checkbox" id="fm3" name="fm3" value="3fm" onclick="frame_change('fm3')">3fm&nbsp;&nbsp;
                                <input type="checkbox" id="fm5" name="fm5" value="5fm" onclick="frame_change('fm5')">5fm -->
                                <input type="checkbox" id="fm1" name="fm1" value="1fm" checked onchange="showRuntime()">1fm&nbsp;&nbsp;
                                <input type="checkbox" id="fm3" name="fm3" value="3fm" onchange="showRuntime()">3fm&nbsp;&nbsp;
                                <input type="checkbox" id="fm5" name="fm5" value="5fm" onchange="showRuntime()">5fm
                            </div> 
                            <div class="col-md-2">
                                <a href="#" style="color:#00aaff" title="1fm (1 frame) = 2D model
3fm (3 frames) = 3D model
5fm (5 frames) = 3D model" >Info</a>
                            </div> 
                            <div class="col-md-12"><br/></div>
                                                        <!------------------End Augmentation---------------->

                            <div class="col-md-4">
                                Email address:
                            </div>
                            <div class="col-md-8">
                                <input id="email" type="text" name="email" class="form-control" value="<?php if(isset($email)) echo $email; ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <br/>
                            </div>
                            <!----Preview Contrast enhancement----->
                            <!--
                            <div class="col-md-5">
                                Contrast enhancement:
                            </div>
                            <div class="col-md-1">
                                
                                <input type="checkbox" id="contrast_e" name="contrast_e" value="contrast_e">
                            </div>
                            <div class="col-md-6"></div>  -->
                            
                            <!----End contrast enhancement----->
                            <div class="col-md-12">
                                <br/>
                            </div>
                            <div class="col-md-12">
                                <div id="average_rt_id" name="average_rt_id"></div>
                            </div>
                            
                            <div class="col-md-12">
                                <br/>
                                <center><button id="prp_submit" name="prp_submit" type="submit" class="btn btn-info">Submit</button></center>
                            </div>
                            <div id="after_submit" name="after_submit" class="col-md-12">
                                <br/>
                                <center><span style="color:#00b300">Waiting...</span></center>
                            </div>
                
                </div>
    </div>
        <div class="col-md-4"></div>    
    </div>
</div>
</form>


<script>
   /* $(function () {
  $('[data-toggle="tooltip"]').tooltip({html: true});
  
   $('.example').tooltip({html: true}); 
})*/
    
    
    
    document.getElementById('after_submit').style.display = "none";
   function do_submit_tasks()
   {
       document.getElementById('prp_submit').disabled = true;
       document.getElementById('after_submit').style.display = "block";
   }
   
</script>
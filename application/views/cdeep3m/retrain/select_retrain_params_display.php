<div class="container">
    <form action='/cdeep3m_retrain/submit_retrain/<?php echo $retrainID; ?>' method='post'>
    <div class="row">
        <div class="col-md-12">
             

            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item ">Step 1. Upload training images</li>
                <li class="breadcrumb-item ">Step 2. Upload trainging labels</li>
                <li class="breadcrumb-item active">Step 3. Select re-train parameters</li>
            </ol>

         </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 cil_title2">
            Step 3. Select re-train parameters
        </div>
    </div>

    <div class='row'>
        <div class='col-md-8'>
            <div class='row'>
                <!-----Training model-------------->
                <div class="col-md-4">
                    Trained model:
                </div>
                <div class="col-md-6">
                    <select name="ct_training_models" id="ct_training_models" class="form-control" onchange="showRuntime()">
                        <?php
                            if(isset($all_model_json) && is_array($all_model_json))
                            {
                                foreach($all_model_json as $mjson)
                                {
                        ?>
                                    <option value="https://doi.org/10.7295/W9CDEEP3M<?php echo $mjson->id ?>"><?php  if(isset($mjson->Cdeepdm_model->Name)) echo $mjson->Cdeepdm_model->Name." (".$mjson->id.")"; ?> </option>
                        <?php
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
                    <select name="ct_augmentation" id="ct_augmentation" class="form-control" > 
                        <option value="10">10</option>
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
                <!------------------End Augmentation---------------->
                <hr style="height:10px; visibility:hidden;" />
                <!------------------Iterations----------------------> 
                <div class="col-md-4">
                    Iterations:
                </div>
                <div class="col-md-6">
                    <input type="range" class="custom-range" min="100" max="2000" step="100" id="ct_iteration_ranage" name='ct_iteration_ranage' value='100' onchange='update_iteration()'>
                </div>
                <div class="col-md-2">
                    <div id='iteration_value' name='iteration_value'>100</div>
                </div>
                <!------------------End Iterations---------------------->
                <hr style="height:10px; visibility:hidden;" />
                <!----------------Email--------------------------> 
                <div class="col-md-4">
                                Email address:
                            </div>
                            <div class="col-md-8">
                                <input id="email" type="text" name="email" class="form-control" value="<?php if(isset($email)) echo $email; ?>" readonly>
                            </div>  
                <!--------------End Email-------------------->
                
                
                
                <div class="col-md-12">
                    <br/>
                    <center><button id="prp_submit" name="prp_submit" type="submit" class="btn btn-info">Submit</button></center>
                </div>
                
            </div>
        </div> 
        <div class='col-md-4'></div>
    </div>


    </form>

</div>


<script>
    function update_iteration()
    {
        //alert('iteration update');
        var iteration_value =  document.getElementById('ct_iteration_ranage').value;
        document.getElementById('iteration_value').innerHTML = iteration_value;
    }
    
    
</script>
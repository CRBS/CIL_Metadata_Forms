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
                <div class="col-md-2"><a href="/home/pre_trained_models" target="_blank">Details</a></div>
                <!-----End Training model-------------->
                
                <hr style="height:10px; visibility:hidden;" />
                <!------------------Secondary Augmentation---------------->
                <div class="col-md-4">
                    Secondary Aug value:
                </div>
                <div class="col-md-6">
                    <input type="range" class="custom-range" min="-1" max="10" step="1" id="second_ranage" name='second_ranage' value='-1' onchange='update_second_ranage()'>
                </div>
                <div class="col-md-2">
                    <div id='second_ranage_value' name='second_ranage_value'>-1</div>
                </div>
                <!------------------End Secondary Augmentation---------------->
                
                <hr style="height:10px; visibility:hidden;" />
                <!------------------Tertiary Augmentation---------------->
                <div class="col-md-4">
                    Tertiary Aug value:
                </div>
                <div class="col-md-6">
                    <input type="range" class="custom-range" min="0" max="10" step="1" id="tertiary_ranage" name='tertiary_ranage' value='0' onchange='update_tertiary_ranage()'>
                </div>
                <div class="col-md-2">
                    <div id='tertiary_ranage_value' name='tertiary_ranage_value'>0</div>
                </div>
                <!------------------End Tertiary Augmentation---------------->
                
                
                <hr style="height:10px; visibility:hidden;" />
                <!------------------Iterations----------------------> 
                <div class="col-md-4">
                     Additerations:
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
    
    
    function update_second_ranage()
    {
        var iteration_value =  document.getElementById('second_ranage').value;
        document.getElementById('second_ranage_value').innerHTML = iteration_value;
    }
    
    function update_tertiary_ranage()
    {
        var iteration_value =  document.getElementById('tertiary_ranage').value;
        document.getElementById('tertiary_ranage_value').innerHTML = iteration_value;
    }
    
</script>
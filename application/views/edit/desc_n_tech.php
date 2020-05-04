<div class="row">
    <div class="col-md-12">
        <br/>
    </div>
    <div class="col-md-12">
        <center>
            <button type="submit" class="btn btn-primary">Submit</button>
        </center>
    </div>
</div>
<br/>
<span class="cil_title2">Description</span>
<div class="row">
    <div class="col-md-12">
        <textarea id="description" name="description" rows="10" cols="90" placeholder=""><?php
            if(isset($json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION->free_text))
            {
                echo $json->CIL_CCDB->CIL->CORE->IMAGEDESCRIPTION->free_text;
            }
        ?></textarea> 
    </div>
</div>
<br/>
<span class="cil_title2">Technical Details</span>
<div class="row">
    <div class="col-md-12">
        <textarea id="tech_details" name="tech_details" rows="10" cols="90" placeholder=""><?php
            if(isset($json->CIL_CCDB->CIL->CORE->TECHNICALDETAILS->free_text))
            {
                echo $json->CIL_CCDB->CIL->CORE->TECHNICALDETAILS->free_text;
            }
        ?></textarea> 
    </div>
</div>


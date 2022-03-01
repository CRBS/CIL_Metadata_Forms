<?php
$alz_neuropathologist = null;
$alz_embedded_sample = null;

if(isset($json->CIL_CCDB->CIL->ALZHEIMER_METADATA))
{
    if(isset($json->CIL_CCDB->CIL->ALZHEIMER_METADATA->NEUROPATHOLOGIST))
        $alz_neuropathologist = $json->CIL_CCDB->CIL->ALZHEIMER_METADATA->NEUROPATHOLOGIST;
    
    if(isset($json->CIL_CCDB->CIL->ALZHEIMER_METADATA->EMBEDDED_SAMPLE))
        $alz_embedded_sample = $json->CIL_CCDB->CIL->ALZHEIMER_METADATA->EMBEDDED_SAMPLE;
}

?>

<br/>
<span class="cil_title2">Alzheimer's metadata</span>
<div class='row'>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">Neuropathologist</label>
            <input id="alz_neuropathologist" name="alz_neuropathologist" style="width: 100%" type="text" value="<?php if(!is_null($alz_neuropathologist)) echo $alz_neuropathologist;  ?>" class="form-control cil_san_regular_font">
        </div>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault">Embedded sample</label>
            <input id="alz_embedded_sample" name="alz_embedded_sample" style="width: 100%" type="text" value="<?php if(!is_null($alz_embedded_sample)) echo $alz_embedded_sample;  ?>" class="form-control cil_san_regular_font">
        </div>
    </div>
    <div class="col-md-6"></div>
</div>



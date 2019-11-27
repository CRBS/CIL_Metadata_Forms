<br/>
<span class="cil_title2">Licensing</span>
<div class="row">
    <div class="col-md-3">
        <label class="col-form-label" for="inputDefault">Public Domain</label>
        <input id="public_domain" name="public_domain" type="checkbox" value="true" <?php 
            if(isset($json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text))
            {
                $term = $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text;
                if(strcmp($term, "public_domain") == 0)
                        echo " checked";
            }
        ?>>
    </div>
    <div class="col-md-3">
        <label class="col-form-label" for="inputDefault">Attribution By</label>
        <input id="attribution_cc" name="attribution_cc" type="checkbox" value="true" <?php
            if(isset($json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text))
            {
                $term = $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text;
                if(strcmp($term, "attribution_cc_by") == 0)
                        echo " checked";
            }
        ?>>
    </div>
    <div class="col-md-4">
        <label class="col-form-label" for="inputDefault">Attribution Non-Commercial</label>
        <input id="attribution_nc_sa" name="attribution_nc_sa" type="checkbox" value="true" <?php
            if(isset($json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text))
            {
                $term = $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text;
                if(strcmp($term, "attribution_nc_sa") == 0)
                        echo " checked";
            }
        ?>>
    </div>
    <div class="col-md-2">
        <label class="col-form-label" for="inputDefault">Copyright</label>
        <input id="copyright" name="copyright" type="checkbox" value="true" <?php 
            if(isset($json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text))
            {
                $term = $json->CIL_CCDB->CIL->CORE->TERMSANDCONDITIONS->free_text;
                if(strcmp($term, "copyright") == 0)
                        echo " checked";
            }
        
        ?>>
    </div>
</div>

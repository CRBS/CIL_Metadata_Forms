<br/>
<span class="cil_title2">Citation title</span>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            
            <textarea id="citation_title" name="citation_title" rows="5" cols="50" placeholder="">
            <?php
                if(isset($json->CIL_CCDB->Citation->Title))
                {
                    echo $json->CIL_CCDB->Citation->Title;
                }
            ?>
            </textarea>
        </div>
    </div>

</div>

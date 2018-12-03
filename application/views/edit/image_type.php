<br/>
<span class="cil_title2">Data Type</span>
<div class="row">
    <div class="col-md-3">
        Still image<input type="checkbox" id="still_image" name="still_image" value="still_image" <?php
            if(isset($json->CIL_CCDB->Data_type->Still_image) && $json->CIL_CCDB->Data_type->Still_image)
                echo "checked";
        ?>>
    </div>
    <div class="col-md-3">
        Z stack<input type="checkbox" id="z_stack" name="z_stack" value="z_stack" <?php 
            if(isset($json->CIL_CCDB->Data_type->Z_stack) && $json->CIL_CCDB->Data_type->Z_stack)
                echo "checked";
        ?>>
    </div>
    <div class="col-md-3">
        Time series<input type="checkbox" id="time_series" name="time_series" value="time_series" <?php
            if(isset($json->CIL_CCDB->Data_type->Time_series) && $json->CIL_CCDB->Data_type->Time_series)
                echo "checked";
        ?>> 
    </div>
    <div class="col-md-3">
        Video<input type="checkbox" id="video" name="video" value="video" <?php 
            if(isset($json->CIL_CCDB->Data_type->Video) && $json->CIL_CCDB->Data_type->Video)
                echo "checked";
        ?>>
    </div>
</div>

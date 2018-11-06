<br/>
<span class="cil_title2"> Image Dimensions</span>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> X image size</label>
            <input id="x_image_size" name="x_image_size" style="width: 100%" type="text" value="<?php 
            if(isset($json->CIL_CCDB->CIL->CORE->DIMENSION))
            {
                $dimensions = $json->CIL_CCDB->CIL->CORE->DIMENSION;
                foreach ($dimensions as $dim)
                {
                    if(isset($dim->Space->axis)
                            && strcmp($dim->Space->axis,"X")==0
                            && isset($dim->Space->Image_size))
                    {
                        echo $dim->Space->Image_size;
                    }
                }
            }    
                
                ?>" class="form-control cil_san_regular_font " >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> X pixel size</label>
            <input id="x_pixel_size" name="x_pixel_size"  type="text" value="" class="form-control cil_san_regular_font " >
             
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label id="x_pixel_unit" name="x_pixel_unit" class="col-form-label" for="inputDefault">Unit</label>
            <select class="form-control cil_san_regular_font ">
            <option value="microns">µm</option>
            <option value="nanometers">nm</option>
          </select>
        </div>
    </div>
</div>

<!----New row --->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Y image size</label>
            <input id="y_image_size" name="y_image_size" style="width: 100%" type="text" value="<?php
            if(isset($json->CIL_CCDB->CIL->CORE->DIMENSION))
            {
                $dimensions = $json->CIL_CCDB->CIL->CORE->DIMENSION;
                foreach ($dimensions as $dim)
                {
                    if(isset($dim->Space->axis)
                            && strcmp($dim->Space->axis,"Y")==0
                            && isset($dim->Space->Image_size))
                    {
                        echo $dim->Space->Image_size;
                    }
                }
            }
            
            ?>" class="form-control cil_san_regular_font " >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Y pixel size</label>
            <input id="y_pixel_size" name="y_pixel_size"  type="text" value="" class="form-control cil_san_regular_font " >
             
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label id="y_pixel_unit" name="y_pixel_unit" class="col-form-label" for="inputDefault">Unit</label>
            <select class="form-control cil_san_regular_font ">
            <option value="microns">µm</option>
            <option value="nanometers">nm</option>
          </select>
        </div>
    </div>
</div>


<!----New row --->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Z image size</label>
            <input id="y_image_size" name="z_image_size" style="width: 100%" type="text" value="<?php
            if(isset($json->CIL_CCDB->CIL->CORE->DIMENSION))
            {
                $dimensions = $json->CIL_CCDB->CIL->CORE->DIMENSION;
                foreach ($dimensions as $dim)
                {
                    if(isset($dim->Space->axis)
                            && strcmp($dim->Space->axis,"Z")==0
                            && isset($dim->Space->Image_size))
                    {
                        echo $dim->Space->Image_size;
                    }
                }
            }
            ?>" class="form-control cil_san_regular_font " >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Z pixel size</label>
            <input id="y_pixel_size" name="z_pixel_size"  type="text" value="" class="form-control cil_san_regular_font " >
             
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label id="y_pixel_unit" name="z_pixel_unit" class="col-form-label" for="inputDefault">Unit</label>
            <select class="form-control cil_san_regular_font ">
            <option value="microns">µm</option>
            <option value="nanometers">nm</option>
          </select>
        </div>
    </div>
</div>
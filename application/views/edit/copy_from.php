<br/>
<form action="/image_metadata/copy_metadata/<?php echo $image_id; ?>" method="post">
<span class="cil_title2">Copy metadata from</span>
<div class="row">
    <div class="col-md-6">Copy metadata from another image:</div>
    <div class="col-md-6">
        <input type="text" name="copy_metadata_from_id" id="copy_metadata_from_id">
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Copy</button>
    </div>
</div>
</form>


<br/>
<form action="/image_metadata/copy_biological_sources/<?php echo $image_id; ?>" method="post">
<span class="cil_title2">Copy Biological Sources</span>
<div class="row">
    <div class="col-md-6">Copy Biological Sources from another image:</div>
    <div class="col-md-6">
        <input type="text" name="copy_cell_component_id" id="copy_cell_component_id">
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Copy Biological Sources</button>
    </div>
</div>
</form>


<br/>
<form action="/image_metadata/copy_imaging_methods/<?php echo $image_id; ?>" method="post">
<span class="cil_title2">Copy Imaging Method</span>
<div class="row">
    <div class="col-md-6">Copy Imaging Method from another image:</div>
    <div class="col-md-6">
        <input type="text" name="copy_imaging_methods_id" id="copy_imaging_methods_id">
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Copy Imaging Method</button>
    </div>
</div>
</form>


<br/>
<form action="/image_metadata/copy_attribution_names/<?php echo $image_id; ?>" method="post">
<span class="cil_title2">Copy Attribution Names</span>
<div class="row">
    <div class="col-md-6">Copy Attribution Names from another image:</div>
    <div class="col-md-6">
        <input type="text" name="copy_attribution_names_id" id="copy_attribution_names_id">
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Copy Attribution Names</button>
    </div>
</div>
</form>
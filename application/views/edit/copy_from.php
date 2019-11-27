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

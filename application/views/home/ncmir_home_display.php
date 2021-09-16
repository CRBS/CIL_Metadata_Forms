<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Options</span>
        </div>
        <div class="col-md-12">
            <br/>
        </div>
        <div class="col-md-4">
            <a href="/home/group_image_main_page" class="btn btn-primary" target="_self">Internal data on image viewer</a>
        </div>
        <div class="col-md-4">
            <a href="/home/demo_main_page" class="btn btn-primary" target="_self">Go to CDeep3M homepage</a>
        </div>
        <?php
            if(isset($isAlz) && $isAlz)
            { 
        ?>        
        <div class="col-md-4">
            <!-- <a href="/alzdata_organizer/start" class="btn btn-primary" target="_self">Alzheimer's data structure</a> -->
            <a href="/alzdata_organizer" class="btn btn-primary" target="_blank">Alzheimer's data structure</a>
        </div>
        <?php
            }
        ?>
        <div class="col-md-12">
            <br/>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="/Upload_imageviewer/create_imagename" class="btn btn-primary" target="_blank">Upload Image Viewer Data</a>
        </div>
        
        <div class="col-md-4">
            <a href="/home/my_annotation_priority" class="btn btn-primary" target="_blank">My annotation priorities</a>
        </div>
    </div>
</div>

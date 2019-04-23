<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">Images</span>
                </div>
                <div class="col-md-12">
                <a href="/all_images" class="btn btn-info">All images</a>
                </div>
                <div class="col-md-12"><br/></div>
                <?php
                    foreach($tag_array as $tag)
                    {
                ?>
                <div class="col-md-12">
                <a href="/tagged/images/wellcome" class="btn btn-info">Wellcome datasets</a>
                </div>
                <div class="col-md-12"><br/></div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
               <span class="cil_title2">Manage</span>
            </div>
            <div class="col-md-12">
                <a href="/upload_images" class="btn btn-info">Upload images</a>
            </div>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
</div>



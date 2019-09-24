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
                <div class="col-md-12"><br/><?php //var_dump($tag_array); ?></div>
                <?php
                    foreach($tag_array as $tag)
                    {
                        if(strcmp($tag,"none") !=0)
                        {
                ?>
                <div class="col-md-12">
                <a href="/tagged/images/<?php echo $tag; ?>" class="btn btn-info"><?php echo $tag; ?> datasets</a>
                </div>
                <div class="col-md-12"><br/></div>
                <?php
                        }
                    }
                ?>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">CDeep3M</span>
                </div>
                <div class="col-md-12">
                    <a href="/cdeep3m_models/list_models" target="_self" class="btn btn-info"> All trained models </a>
                </div>
            </div>
            
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                   <span class="cil_title2">Manage</span>
                </div>
                
                <div class="col-md-12">
                    <a href="/upload_images" class="btn btn-primary">Upload images</a>
                </div>
                <div class="col-md-12"><br/></div>
                <div class="col-md-12">
                    <a href="/cdeep3m_models/new_model" class="btn btn-primary">Upload CDeep3M Model</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br/><br/>
                </div>
                <div class="col-md-12">
                   <span class="cil_title2">Existing data</span>
                </div>
                <div class="col-md-12">
                    <a href="/home/retract_image" class="btn btn-primary">Retract image</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                   <span class="cil_title2">User</span>
                </div>
                <div class="col-md-12">
                    <a href="/user/change_password" class="btn btn-primary">Change password</a>
                </div>
            </div>
        </div>
    </div>
</div>



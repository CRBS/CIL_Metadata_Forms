<div class="container">
<div class="row">
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <ul>
                    <li>
                        Model ID: <?php 
                            if(isset($model_id))
                                echo $model_id; ?>
                    </li>
                    <li>
                        File name: <?php 
                            if(isset($model_info) && isset($model_info->file_name))
                                echo $model_info->file_name; ?>
                    </li>
                    <li>
                        File size: <?php 
                            if(isset($model_info) && isset($model_info->file_size))
                                echo $model_info->file_size; ?>
                    </li>
                    <li>
                        Punlished date: <?php 
                            if(isset($model_info) && isset($model_info->publish_date))
                                echo $model_info->publish_date; ?>
                    </li>
                </ul>
                
            </div>
            <div class="col-md-6">
                    <a href="/Cdeep3m_models/release_model_to_website/stage/<?php echo $model_id; ?>" class="btn btn-primary">Release to Stage</a>
            </div>
            <div class="col-md-6">
                    <a href="http://flagella.crbs.ucsd.edu/cdeep3m" class="btn btn-primary" target="_blank">View stage website</a>
            </div>
            <div class="col-md-12"><br/></div>
            <div class="col-md-6">
                    <a href="/Cdeep3m_models/release_model_to_website/prod/<?php echo $model_id; ?>" class="btn btn-primary">Release to Production</a>
            </div>
            <div class="col-md-6">
                <a href="http://cellimagelibrary.org/cdeep3m" class="btn btn-primary" target="_blank">View Production website</a>
            </div>
        </div>
    </div>
    <div class="col-md-7">

                <br/>
        
        <textarea rows="40" style=" width:100%;">
         <?php 
            if(isset($model_json))
            {
                echo $model_json;
            }
         ?>
         </textarea> 
    </div>
</div>
</div>    
    

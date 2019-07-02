
<div class="container">
    <div class="row">
         <div class="col-md-12">
             <?php 
             
             $breadcrumbPath =  getcwd()."/application/views/cdeep3m/model_breadcrumb.php";
             include_once $breadcrumbPath; ?>
         </div>
     </div>
    <div class="row">
        <div class="col-md-12">
             <br/>
            <span class="cil_title2">Step 3: Enter metadata</span>
           
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php 
                if(isset($model_info) && isset($model_info->file_name) && isset($model_info->file_size))
                    echo "Model file: ".$model_info->file_name." (".$model_info->file_size.")";
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php 
                if(isset($training_data_json) && isset($training_data_json->file_name) && isset($training_data_json->file_size))
                    echo "Training file: ".$training_data_json->file_name." (".$training_data_json->file_size.")";
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <?php include_once 'edit_left_panel.php'; ?>
        </div>
        <div class="col-md-7">
            <form action="/cdeep3m_models/submit/<?php echo $model_id; ?>" method="post" onsubmit="return check_model_form()">
            <?php include_once 'edit_right_panel.php'; ?>
            </form>
        </div>
    </div>
</div>
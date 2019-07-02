<?php
    $step_1 = false;
    $step_2 = false;
    $step_3 = false;
    
    $date_exist = false;
    if($step ==1)
        $step_1 = true;
    else if($step ==2)
        $step_2 = true;
    else if($step ==3)
        $step_3 = true;
    
    
    if(isset($model_info_json) && isset($model_info_json->file_name))
        $date_exist = true;
    
?>


<br/>
<ol class="breadcrumb">
<?php
    if(!$step_1)
    {
?>
    <li class="breadcrumb-item <?php if($step ==1) echo "active"; ?>" ><a href="/cdeep3m_models/upload/<?php echo $model_id; ?>" target="_self">Step 1. Upload model</a></li>
    
<?php
    }
    else
    {
?>
    <li class="breadcrumb-item <?php if($step ==1) echo "active"; ?>" >Step 1. Upload model</li>
<?php
    }
?>
<?php
    if(($step_1 && $date_exist) || $step_3)
    {
?>
    <li class="breadcrumb-item <?php if($step ==2) echo "active"; ?>"><a href="/cdeep3m_models/upload_training_data/<?php echo $model_id; ?>" target="_self">Step 2. Upload trainging data</a></li>
   
<?php
    }
    else
    {
?>
     <li class="breadcrumb-item <?php if($step ==2) echo "active"; ?>">Step 2. Upload trainging data</li>
<?php
    }
?>
 
<?php
    if(($step_1 && $date_exist) || $step_2)
    {
?>
     <li class="breadcrumb-item <?php if($step ==3) echo "active"; ?>"><a href="/cdeep3m_models/edit/<?php echo $model_id; ?>" target="_self">Step 3. Edit metadata</a></li>
<?php
    }
    else
    {
?> 
    <li class="breadcrumb-item <?php if($step ==3) echo "active"; ?>">Step 3. Edit metadata</li>
<?php
    }
?>
</ol>


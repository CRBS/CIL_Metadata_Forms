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
    
    
    //if(isset($model_info_json) && isset($model_info_json->file_name))
    //    $date_exist = true;
    
?>


<br/>
<ol class="breadcrumb">
<?php
    if(!$step_1)
    {
?>
    <li class="breadcrumb-item <?php if($step ==1) echo "active"; ?>" ><a style="color:#4287f5" href="/cdeep3m_preview/upload_images/<?php echo $crop_id; ?>" target="_self">Step 1. Upload images</a></li>
    
<?php
    }
    else
    {
?>
    <li class="breadcrumb-item <?php if($step ==1) echo "active"; ?>" >Step 1. Upload images</li>
<?php
    }
?>

 
<?php
    if(($step_1 && $date_exist) || $step_2)
    {
?>
     <li class="breadcrumb-item <?php if($step ==3) echo "active"; ?>"><a style="color:#4287f5" href="/cdeep3m_preview/select_parameters/<?php echo $crop_id; ?>" target="_self">Step 2. Select parameters</a></li>
<?php
    }
    else
    {
?> 
    <li class="breadcrumb-item <?php if($step ==3) echo "active"; ?>">Step 2. Select parameters</li>
<?php
    }
?>
</ol>


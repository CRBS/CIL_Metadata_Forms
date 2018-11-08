<form action="/image_metadata/submit/<?php echo $image_id; ?>" method="post">
<?php
    //var_dump($json);
    include_once 'desc_n_tech.php';
    include_once 'image_type.php';
    include_once 'biological_sources.php';
    include_once 'biological_context.php';
    include_once 'imaging_methods.php'; 
    include_once 'dimensions.php';
    
    include_once 'bottom_panel.php';
    
?>
</form>
<div class="container">
<div class="row">
    <div class="col-md-12"><br/></div>
<?php

foreach($mjson as $item)
{
?>
    <div class="col-md-4">
        <div class="row">
        <?php
            if(isset($item->has_display_image) && $item->has_display_image)
            {
        ?>
        
        <div class="col-md-12">
        <a href="/cdeep3m_models/edit/<?php echo  $item->model_id; ?>">
        <img alt="<?php echo  $item->model_id; ?>" src="https://cildata.crbs.ucsd.edu/media/model_display/<?php echo  $item->model_id; ?>/<?php echo $item->model_id; ?>_thumbnailx220.jpg?<?php echo uniqid(); ?>" class="img-thumbnail pull-right" width="220px">
        </a>
        </div>
        <div class="col-md-12">
            <?php echo  $item->model_id; ?> - <?php echo $item->file_name; ?>
        </div>
        <?php
            }
            else
            {
        ?>
       
        <div class="col-md-12">
        <a href="/cdeep3m_models/edit/<?php echo  $item->model_id; ?>">
        <img src="/pix/default_jpg3.png?<?php echo uniqid(); ?>" class="img-thumbnail pull-right"  width="220px">
        </a>
        </div>
        <div class="col-md-12">
            <?php echo  $item->model_id; ?> - <?php echo $item->file_name; ?>
        </div>
        <?php
        
            }
        ?>
        </div>
    </div>

<?php    
}

?>
</div>
</div>
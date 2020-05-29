<div class="container">
    <div class="row">
        <div class="col-md-12"><br/><br/></div>
        <div class="col-md-5">
            <?php include_once 'edit_left_panel.php'; ?>
        </div>
        <div class="col-md-7">
            <form action="/Cdeep3m_retrain/submit_metadata/<?php echo $model_id; ?>" method="post" onsubmit="return check_model_form()">
            <?php include_once 'edit_right_panel.php'; ?>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2"><?php echo  $videoName; ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <video controls="" autoplay="" width="100%">
                <source src="https://cildata.crbs.ucsd.edu/media/ncmir_videos/<?php echo $videoName.".mp4"; ?>" type="video/mp4">
           </video>
        </div>
        <div class="col-md-12">
            <br/>
            <center><a class="btn btn-primary" href='https://cildata.crbs.ucsd.edu/media/ncmir_videos/<?php echo $videoName.".avi"; ?>' blank="_blank">Download the original file</a></center>
        </div>
    </div>
</div>



<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />


<div class="container">
     <div class="row">
         <div class="col-md-12">
             <?php include_once 'model_breadcrumb.php'; ?>
         </div>
     </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
            <span class="cil_title2">Step 2: Upload the trainging data (Optional)</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div id="html5_uploader">Your browser doesn't support native upload.</div>
        </div>
        <div class="col-md-6">
            
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
        <?php
        if(isset($training_data_json) && isset($training_data_json->file_name))
        {
          echo "<b>Current model file:</b> ".$training_data_json->file_name." (".$training_data_json->file_size.")";

        }
        ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <br/><br/>
        
            <a class="btn btn-primary" href="/cdeep3m_models/edit/<?php echo $model_id; ?>">Next step</a>
        

        </div><div class="col-md-6"></div>
    </div>
</div>

<script type="text/javascript">
$(function() {


	// Setup html5 version
	$("#html5_uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : "/upload_images/process_upload/<?php echo $model_id; ?>",
                //url:"https://iruka.crbs.ucsd.edu/CIL-Storage-RS/index.php/image_upload_service/upload_cdeep3m_model/<?php //echo $model_id; ?>",
		chunk_size : '1mb',
                multipart : true,
		//unique_names : true,
		
		filters : {
			max_file_size : '20000mb',
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,tif"},
				{title : "Zip files", extensions : "zip,tar"}
			]
		},
                init : {
                    FilesAdded: function(up, files) 
                    {
                         if (up.files.length == 1)
                         {
                             //console.log(up.files[0].name);
                             //console.log(files[0].name);
                             //gurl = "/upload_images/process_upload/"+files[0].name;
                         }
                        
                         if (up.files.length > 1) 
                         {
                            up.removeFile(files[0]);
                            alert("Only 1 file is allowed");
                         }
                    },
                    FileUploaded: function(up, file, info) 
                    {
                        console.log("Uploaded:"+file.name);
                        var addUrl = "<?php echo $base_url."/cdeep3m_models/add_training/".$model_id ?>";
                        addUrl = addUrl+"/"+file.name;
                        window.location.href = addUrl;
                        
                        
                    }
                }

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90}
	});


});
</script>




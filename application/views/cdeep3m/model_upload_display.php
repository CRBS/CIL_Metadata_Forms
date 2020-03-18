

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
            <span class="cil_title2">Step 1: Upload trained model</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        Upload your trained CDeep3M model/s and share it to contribute to the database. Each trained model receives a DOI for citations.<br/>
        (Info: Follow these steps to <a href="https://github.com/CRBS/cdeep3m/wiki/Demorun-2-Running-small-training-and-prediction-with-mito-testsample-dataset" target="_blank">generate a new trained model</a> or 
        <a href="https://github.com/CRBS/cdeep3m/wiki/How-to-retrain-a-pretrained-network" target="_blank">re-train a previously trained model</a>)
        </div>
        <div class="col-md-12"><br/></div>
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
            <b>Note:</b> Characters such as slashes, question mark, semicolon, colon and comma are NOT allowed in the file name.
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
        <?php
        if(isset($model_info_json) && isset($model_info_json->file_name))
        {
          echo "<b>Current model file:</b> ".$model_info_json->file_name." (".$model_info_json->file_size.")";

        }
        ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <br/><br/>
        <?php
        if(isset($model_info_json) && isset($model_info_json->file_name))
        {
        ?>
            <a class="btn btn-primary" href="/cdeep3m_models/upload_training_data/<?php echo $model_id; ?>">Next step</a>
        <?php

        }
        ?>

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
                             
                             if(up.files[0].name.includes('/') || up.files[0].name.includes('\\'))
                             {
                                up.removeFile(files[0]);
                                alert("Slash is not allowed in the file name.");
                             }
                             
                             if(up.files[0].name.includes(','))
                             {
                                up.removeFile(files[0]);
                                alert("Comma is not allowed in the file name.");
                             }
                             
                             if(up.files[0].name.includes('+'))
                             {
                                up.removeFile(files[0]);
                                alert("Plus sign is not allowed in the file name.");
                             }
                             
                             if(up.files[0].name.includes('+'))
                             {
                                up.removeFile(files[0]);
                                alert("Semicolon is not allowed in the file name.");
                             }
                             
                             if(up.files[0].name.includes('?'))
                             {
                                up.removeFile(files[0]);
                                alert("Question mark is not allowed in the file name.");
                             }
                             
                             if(up.files[0].name.includes(':'))
                             {
                                up.removeFile(files[0]);
                                alert("Question mark is not allowed in the file name.");
                             }
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
                        var addUrl = "<?php echo $base_url."/cdeep3m_models/add/".$model_id ?>";
                        
                        addUrl = addUrl+"/"+file.name;
                        window.location.href = addUrl;
                        
                        
                    }
                }

		
	});


});
</script>




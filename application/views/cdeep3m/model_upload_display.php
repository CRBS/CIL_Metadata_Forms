

<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="html5_uploader">Your browser doesn't support native upload.</div>
        </div>
        <div class="col-md-6">
            
        </div>
        
    </div>
    
</div>

<script type="text/javascript">
$(function() {


	// Setup html5 version
	$("#html5_uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : "/upload_images/process_upload",
		chunk_size : '3mb',
		//unique_names : true,
		
		filters : {
			max_file_size : '20000mb',
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png,tif"},
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
                        window.location.href = "<?php echo $base_url."/cdeep3m_models/edit/".$model_id ?>";
                        
                        
                    }
                }

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90}
	});


});
</script>



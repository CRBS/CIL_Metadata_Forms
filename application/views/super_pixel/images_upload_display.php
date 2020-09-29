

<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />


<div class="container">

    <div class="row">
        <div class="col-md-12">
             <?php include_once 'images_breadcrumb.php'; ?>
         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <b>Accepted Filetypes:</b> .PNG 
        </div>
        <!-- <div class="col-md-12">
            <b>Sizelimit per file:</b> 20MB
        </div> -->
        <div class="col-md-12">
            <b>Max number of files:</b> 20
        </div>
        <?php
            if(isset($isUncappedUpload) && !$isUncappedUpload)
            { 
        ?>        
        <div class="col-md-12">
            <b>Mx file size:</b> 20mb
        </div>
        <?php
            }  
        ?>
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
            <span class="cil_title2">Create training data - Step 1: Upload the images</span>
        </div>
    </div>
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
		url : "/Cdeep3m_create_training/process_images_upload/<?php echo $sp_id; ?>",
                //url:"https://iruka.crbs.ucsd.edu/CIL-Storage-RS/index.php/image_upload_service/upload_cdeep3m_model/<?php //echo $model_id; ?>",
		chunk_size : '1mb',
                multipart : true,
		//unique_names : true,
		
		filters : {
                    
                    <?php
                        if(isset($isUncappedUpload) && $isUncappedUpload)
                        { 
                    ?>
                        max_file_size : '9999999mb',  
			
                    <?php
                        } 
                        else 
                        { 
                    ?>   
                        max_file_size : '20mb',         
                    <?php  
                        } 
                    ?>   
                     
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,tif"},
				{title : "png", extensions : "png"}
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
                        
                         if (up.files.length > 20) 
                         {
                            //up.removeFile(files[0]);
                            //alert("Only 1 file is allowed");
                            alert('You are allowed to add only 20 files.');
                            up.splice(); // reset the queue to zero);
                         }
                         
                    },
                    FileUploaded: function(up, file, info) 
                    {
                        console.log("Uploaded:"+file.name);
                        var addUrl = "<?php echo $base_url."/cdeep3m_create_training/pending/".$sp_id ?>";
                        
                        
                        //window.location.href = addUrl;
                         if( (up.total.uploaded) == up.files.length)
                         {
                            //alert("DONE");
                            window.location.href = addUrl;
                         }
                        
                    }
                }

		
	});


});
</script>




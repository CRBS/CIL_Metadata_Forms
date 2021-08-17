

<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />


<div class="container">

    <div class="row">
        <div class="col-md-12">
             
         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <b>Accepted Filetypes:</b> .sqllite3
        </div>
        
         <div class="col-md-12">
            <b>Max number of files:</b> 2000
        </div> 
        

    </div>
    <div class="row">
        <div class="col-md-12">
            <br/>
            <span class="cil_title2">Step 2: Upload sqlite files</span>
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
		url : "/Upload_imageviewer/process_images_upload/<?php echo $image_name; ?>",
                //url:"https://iruka.crbs.ucsd.edu/CIL-Storage-RS/index.php/image_upload_service/upload_cdeep3m_model/<?php //echo $model_id; ?>",
		chunk_size : '1mb',
                multipart : true,
		//unique_names : true,
		
		filters : {
                    
                 
                        max_file_size : '99999999999mb',  
			
                    
                     
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,tif"},
				{title : "sqlite3", extensions : "sqllite3,json"}
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
                        
                         if (up.files.length > 2000) 
                         {
                            //up.removeFile(files[0]);
                            //alert("Only 1 file is allowed");
                            alert('You are allowed to add only 100 files.');
                            up.splice(); // reset the queue to zero);
                         }
                         
                    },
                    FileUploaded: function(up, file, info) 
                    {
                        console.log("Uploaded:"+file.name);
                        var addUrl = "<?php echo $base_url."/Upload_imageviewer/configure/".$image_name ?>";
                        
                        
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




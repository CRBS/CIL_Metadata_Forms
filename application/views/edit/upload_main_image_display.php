<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />



<div class="container">

    <div class="row">
        <div class="col-md-12">
            <br/>
            <span class="cil_title2">Upload ZIP file</span>
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
        <div id="error_message_id" class="col-md-12"></div>
    </div>
</div>


<script type="text/javascript">
$(function() {


	// Setup html5 version
	var uploader = $("#html5_uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : "<?php echo $base_url; ?>/Data_uploader/process_images_upload/<?php echo $image_id; ?>",
		chunk_size : '1mb',
                multipart : true,
		
		
		filters : {
                    
                   
                        max_file_size : '9999999mb',  
			
                     
                     
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,tif"},
				{title : "zip", extensions : "zip"}
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
                            //up.removeFile(files[0]);
                            //alert("Only 1 file is allowed");
                            alert('You are allowed to add only 1 file.');
                            up.splice(); // reset the queue to zero);
                         }
                         
                    },
                    FileUploaded: function(up, file, info) 
                    {
                        console.log("Uploaded:"+file.name);
                        console.log(info);
                        /*var addUrl = "<?php //echo $base_url."/cdeep3m_create_training/pending/" ?>";
                        
                        
                        //window.location.href = addUrl;
                         if( (up.total.uploaded) == up.files.length)
                         {
                            //alert("DONE");
                            window.location.href = addUrl;
                         }*/
    
    
                         document.getElementById('error_message_id').innerHTML = "<br/><center><a class='btn btn-success' href='<?php echo $base_url; ?>/image_metadata/edit/CIL_<?php echo $image_id; ?>'>Done</a></center>";
                        
                    },
                    Error: function(up, obj) {
                        // Called when error occurs
                        if (obj.hasOwnProperty('response')) 
                        {
                            var res = JSON.parse(obj.response);
                            console.log(res);
                            if(res.hasOwnProperty('error'))
                            {
                                alert('Error: '+res.error.message);
                                var backBtn = "<br/><center><a class='btn btn-success' href='<?php echo $base_url; ?>/image_metadata/edit/CIL_<?php echo $image_id; ?>'>Back to the image page</a></center>";
                                document.getElementById('error_message_id').innerHTML = "<span style='color: red'>"+res.error.message+
                                        "</span><br/>Refresh the browser to try again."+backBtn;
                            }
                            else 
                            {
                                alert("Error: Unable to upload");
                            }
                            
                        }
                        //alert("error");
                        //console.log(obj);
                    }
                }

		
	});

        

});
</script>
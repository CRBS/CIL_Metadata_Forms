<script type="text/javascript" src="/js/plupload-2.3.6/js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/plupload-2.3.6/js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="/js/plupload-2.3.6/js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />


<div class="container">
    <div class="row">
        <div class="col-md-12">
             

            <br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Step 1. Upload training images</li>
                <li class="breadcrumb-item ">Step 2. Upload trainging labels</li>
                <li class="breadcrumb-item ">Step 3. Select re-train parameters</li>
            </ol>

         </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 cil_title2">
            Step 1. Upload training images
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12"><br/></div>
        <div class="col-md-6">
            <div id="html5_uploader" style="position: relative;"><div class="plupload_wrapper plupload_scroll"><div id="html5_uploader_container" class="plupload_container" title="Using runtime: html5"><div class="plupload"><div class="plupload_header"><div class="plupload_header_content"><div class="plupload_header_title">Select files</div><div class="plupload_header_text">Add files to the upload queue and click the start button.</div></div></div><div class="plupload_content"><div class="plupload_filelist_header"><div class="plupload_file_name">Filename</div><div class="plupload_file_action">&nbsp;</div><div class="plupload_file_status"><span>Status</span></div><div class="plupload_file_size">Size</div><div class="plupload_clearer">&nbsp;</div></div><ul id="html5_uploader_filelist" class="plupload_filelist" style="position: relative;"><li class="plupload_droptext">Drag files here.</li></ul><div class="plupload_filelist_footer"><div class="plupload_file_name"><div class="plupload_buttons"><a href="#" class="plupload_button plupload_add" id="html5_uploader_browse" style="position: relative; z-index: 1;">Add Files</a><a href="#" class="plupload_button plupload_start plupload_disabled">Start Upload</a></div><span class="plupload_upload_status"></span></div><div class="plupload_file_action"></div><div class="plupload_file_status"><span class="plupload_total_status">0%</span></div><div class="plupload_file_size"><span class="plupload_total_file_size">0 b</span></div><div class="plupload_progress"><div class="plupload_progress_container"><div class="plupload_progress_bar"></div></div></div><div class="plupload_clearer">&nbsp;</div></div></div></div></div><input type="hidden" id="html5_uploader_count" name="html5_uploader_count" value="0"></div><div id="html5_1e45fntrpjd91qtj1d37kjd1mtb4_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 292px; left: 16px; width: 80px; height: 22px; overflow: hidden; z-index: 0;"><input id="html5_1e45fntrpjd91qtj1d37kjd1mtb4" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept=".zip,.tar" tabindex="-1"></div></div>
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
</div>


<script type="text/javascript">
$(function() {


	// Setup html5 version
	$("#html5_uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : "/cdeep3m_retrain/do_upload_retraining_images/<?php echo $retrainID; ?>",
		chunk_size : '1mb',
                multipart : true,
		//unique_names : true,
		
		filters : {
			max_file_size : '999999999mb',
			mime_types: [
				//{title : "Image files", extensions : "jpg,gif,png,tif"},
				{title : "png & tif", extensions : "png,tif"}
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
                        var addUrl = "<?php echo $base_url."/cdeep3m_retrain/add_retraining_images/".$retrainID; ?>";

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
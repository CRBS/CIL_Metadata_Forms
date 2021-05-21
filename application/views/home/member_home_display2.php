<div class="container">
    <br/>
    <?php
        if(isset($cdeep3m_down) && $cdeep3m_down)
        {
    ?>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Warning!</strong> Our CDeep3M demo is currently NOT available. Please try it again later.
            </div>
        </div>
    </div>
    <?php
        }
    ?>
    

    <div class="row" style="width: 100%; height: 942px">
        
        
       <!-- <div class="col-md-12" style="background-image: url('/pix/cdeep3m_background3.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;">  -->
        
       <div id="background_id" class="hidden-xs hidden-sm col-md-12 hidden-lg" style="background-image: url('/pix/cdeep3m_background3.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;">  

       <!--------------Row---------------------------->

        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <span class="cdeep3m_bg_title" style="color:white">Training</span>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_create_training/create" class="btn btn-info" style="color:white" onmouseover="showCreateTrainingMessage()" onmouseout="hideMessageBoard()">Create training data</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_retrain" class="btn btn-info" style="color:white" onmouseover="showRetrainModelMessage()" onmouseout="hideMessageBoard()">Retrain model</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_models/new_model" class="btn btn-info" style="color:white" onmouseover="showUploadTrainedModelMessage()" >Upload trained model</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_models/my_models" class="btn btn-info" style="color:white" onmouseover="hideMessageBoard()" onmouseout="hideMessageBoard()">My trained model</a>
                    </div>
                    
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_create_training/my_superpixel" class="btn btn-info" style="color:white" onmouseover="hideMessageBoard()" onmouseout="hideMessageBoard()">My superpixel results</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div> 
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <span class="cdeep3m_bg_title" style="color:white">Prediction</span>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_preview/new_images" class="btn btn-info" style="color:white" onmouseover="showYourOwnImageMessage()" >Your own images</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_preview/new_images_job" class="btn btn-info" style="color:white" onmouseover="showYourOwnImageMessage()" >Your big images</a>
                    </div>
                    
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/cdeep3m_preview/prp_demo" class="btn btn-info" style="color:white" onmouseover="showCilImageMessage()" onmouseout="hideMessageBoard()">The CIL images</a>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12"><br/></div>
            
            <div class="col-md-5" >
                <div id="message_board_id" style="background-color: black; height:  300px;color:white; padding-left: 10px; padding-right: 10px;">
                
                </div>    
            </div>
            <div class="col-md-7"></div>
            
        </div>
        
            
        <!--------------End Row---------------------------->
        </div>
        
        </div>

</div>    
  

<script>
    document.getElementById('message_board_id').style.display = "none";
    
    function hideMessageBoard()
    {
        document.getElementById('message_board_id').style.display = "none";
    }
    
    function showCreateTrainingMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = "<b><u>Create training data</u></b><br/>  Generate new training data based on your own microscopy images using a superpixel clustering algorithm. You can select superpixels to convert them into training labels. Note: Training data for CDeep3M can also be generated using other platforms online or offline and imported. The use of superpixels can in certain cases facilitate the creation of training labels and reduce the time required for manual annotation.";
        
    }
    
    function showRetrainModelMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = "<b><u>Retrain model</u></b><br/> Upload training data and re-train a trained model from the database. This helps to improve accuracy of existing models for a new dataset. Small training data and short training times (500-5000 iterations) are usually sufficient to re-train an existing model.";
    }
    
    function showUploadTrainedModelMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = 
        '<b><u>Upload trained model</u></b><br/> Upload your trained CDeep3M model/s and share it to contribute to the CDeep3M model zoo. Each trained model is attributed to you, receives a DOI for citations. Making your trained models available here will contribute to the community and facilitates finding available pre-trained models.<br>'+
        '(Info: Follow these steps to <a href="https://github.com/CRBS/cdeep3m2/wiki/PreprocessTrainingData.py-and-runtraining.sh" target="_blank">generate a new trained model</a> or '+
        '<a href="https://github.com/CRBS/cdeep3m2/wiki/Transfer-Learning" target="_blank">re-train a previously trained model</a>)';
              
    }
    
    function showYourOwnImageMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = 
            '<b><u>Your own image</u></b><br/> To perform image segmentation on your own test images and try out different pre-trained models or settings, you can upload your own microscopy images here and try the CDeep3M preview function. Select a trained model from the database, augspeed, and frames to run CDeep3M remotely  (using the <a href="https://nautilus.optiputer.net/" target="_blank">PRP cluster</a>).';
             
    }
    
    function showCilImageMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = '<b><u>The CIL images</u></b><br/> Browse through large SBEM volumes hosted on the CIL, select ROI for segmentation and run CDeep3M Demo to test a trained model from the database on the image volume. ';
    }
    
    
   window.addEventListener('resize', function () {
  // change background
        console.log('Resize');
        var windowWidth = window.innerWidth; // get the new window width
        var windowHeight = window.innerHeight; // get the new window height
        console.log("Width:"+windowWidth);
        console.log("Height:"+windowHeight);
        if(windowWidth < 600)
        {
            document.getElementById('background_id').style = 
                    "background-image: url('/pix/cdeep3m_background3_480.png');background-position: center center;background-size: 100%;background-repeat: repeat;";
        }
        else
        {
            document.getElementById('background_id').style = 
                    "background-image: url('/pix/cdeep3m_background3.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;";
        }
    });
    
    
    
    if(window.innerWidth < 600)
    {
        document.getElementById('background_id').style = 
                    "background-image: url('/pix/cdeep3m_background3_480.png');background-position: center center;background-size: 100%;background-repeat: repeat;";
    }
    else
    {
        document.getElementById('background_id').style = 
                    "background-image: url('/pix/cdeep3m_background3.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;";
    }
    
    
    
</script>
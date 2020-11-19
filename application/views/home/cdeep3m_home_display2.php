<div class="container">
    <br/><br/>
    <?php
        if(isset($cdeep3m_down) && $cdeep3m_down)
        {
    ?>
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
    
    <div class="row">

        <div class="col-md-6">
            <!-- <video controls="" autoplay="" loop="" width="100%" > -->
            <video controls="" autoplay=""  width="100%" >
                <source src="/pix/msog_v2_fin.mp4" type="video/mp4">
           </video>
            
        </div>
        
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
            <span class="cil_title2">What is CDeep3M</span>
            Our goal is improve reproducibility and to make deep-learning algorithms available to the community, we built CDeep3M as a cloud-based tool for image segmentation tasks, using the underlying architecture of a state-of-the-art deep-learning convolutional neural network (CNN), DeepEM3D7, which was integrated in the Caffe deep-learning framework. 
                </div>
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12"><a href="https://www.biorxiv.org/content/10.1101/353425v1" class="btn btn-outline-primary" target="_blank" alt="Cdeep3m article">Read more</a></div>
            </div>
        </div>
        <div class="col-md-12">
            
        </div>
        <div class="col-md-12"><br/></div>
    </div>
    <div class="row" style="width: 100%; height: 942px">
        
        
       <div class="col-md-12" style="background-image: url('/pix/cdeep3m_background3.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;"> 
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
                        <a href="/home" class="btn btn-info" style="color:white" onmouseover="showCreateTrainingMessage()" onmouseout="hideMessageBoard()">Create training data</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/home" class="btn btn-info" style="color:white" onmouseover="showRetrainModelMessage()" onmouseout="hideMessageBoard()">Retrain model</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/home" class="btn btn-info" style="color:white" onmouseover="showUploadTrainedModelMessage()" >Upload trained model</a>
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
                        <a href="/home" class="btn btn-info" style="color:white" onmouseover="showYourOwnImageMessage()" >Your own images</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="/home" class="btn btn-info" style="color:white" onmouseover="showCilImageMessage()" onmouseout="hideMessageBoard()">The CIL images</a>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12"><br/></div>
            
            <div class="col-md-5" >
                <div id="message_board_id" style="background-color: black; height:  300px;color:white;">
                
                </div>    
            </div>
            <div class="col-md-7"></div>
            
        </div>
        
            
        <!--------------End Row---------------------------->
        </div>
        
        </div>
    <div class="row">
        <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <a href="/home/create_user" class="btn btn-primary">Request an account</a>
        </div>
        <div class="col-md-4"></div>
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
        document.getElementById('message_board_id').innerHTML = "Create training data by selecting the super pixel grids.";
        
    }
    
    function showRetrainModelMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = "Upload more training data and improve the accuracy of your model.";
    }
    
    function showUploadTrainedModelMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = 
        'Upload your trained CDeep3M model/s and share it to contribute to the database. Each trained model receives a DOI for citations.<br>'+
        '(Info: Follow these steps to <a href="https://github.com/CRBS/cdeep3m2/wiki/PreprocessTrainingData.py-and-runtraining.sh" target="_blank">generate a new trained model</a> or '+
        '<a href="https://github.com/CRBS/cdeep3m2/wiki/Transfer-Learning" target="_blank">re-train a previously trained model</a>)';
              
    }
    
    function showYourOwnImageMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = 
            'Upload own images and try the CDeep3M preview function. Select a trained model from the database, augspeed, and frames to run CDeep3M remotely (using the <a href="https://nautilus.optiputer.net/" target="_blank">PRP cluster</a>).';
             
    }
    
    function showCilImageMessage()
    {
        document.getElementById('message_board_id').style.display = "block";
        document.getElementById('message_board_id').innerHTML = 'Browse through large SBEM volumes hosted on the CIL, select ROI for segmentation and run CDeep3M Demo to test a trained model from the database on the image volume. ';
    }
    
</script>
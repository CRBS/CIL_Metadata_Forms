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
        <div class="row">
        
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">Upload trained model/Retrain Model</span>
                </div>
                
                <div class="col-md-12">
                    <img src="/pix/50685_thumbnailx512.jpg" width="100%" />
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                 
                <!-- <div class="col-md-12">
                   
                    A new trained model is generated based on training images and labels. For 3D segmentation tasks CDeep3M trains three different models seeing one frame (1 fm), seeing three frames (3 fm), and seeing five frames (5 fm) that are applied to image data.
                </div> -->
                 
                <div class="col-md-12">
                Upload your trained CDeep3M model/s and share it to contribute to the database. Each trained model receives a DOI for citations.<br/>
                (Info: Follow these steps to <a href="https://github.com/CRBS/cdeep3m2/wiki/PreprocessTrainingData.py-and-runtraining.sh" target="_blank">generate a new trained model</a> or 
                <a href="https://github.com/CRBS/cdeep3m2/wiki/Transfer-Learning" target="_blank">re-train a previously trained model</a>)
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                

                 
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">CDeep3M Preview (import test images)</span>
                </div>
                <div class="col-md-12">
                    <img src="/pix/overlay_002.png" width="100%" />
                </div>
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                
                <div class="col-md-12">
                    <!-- Upload small images and try the CDeep3M preview function. Select a trained model, augspeed , and frames to run the CDeep3M remotely. -->
                    Upload own images and try the CDeep3M preview function. Select a trained model from the database, augspeed, and frames to run CDeep3M remotely (using the <a href="https://nautilus.optiputer.net/" target="_blank">PRP cluster</a>).
                </div>
                <!--
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12"> 
                   <a href="/home/create_user" class="btn btn-primary">Request an account</a>
                </div>
                -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">CDeep3M Demo (CIL image volumes)</span>
                </div>
                <div class="col-md-12">
                    <img src="/pix/cil_image_viewer.jpg" width="100%" />
                </div>
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                
                <div class="col-md-12">
                    <!-- The CIL Image Viewer utilizes the Leaflet library and the CodeIgniter PHP library for browsing the high definition images. This image viewer is capable of displaying confocal images, electron tomography z-stack images, and time-series images. This user-interface includes image controls such as zooming, panning, contrast adjustment, brightness adjustment, moving Z-stack location, moving the time location. --> 
                    Browse through large SBEM volumes hosted on the CIL, select ROI for segmentation and run CDeep3M Demo to test a trained model from the database on the image volume.
                </div>
            </div>
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
  


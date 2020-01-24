<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">Upload trained model</span>
                </div>
                
                <div class="col-md-12">
                    <img src="/pix/50685_thumbnailx512.jpg" width="100%" />
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                 
                <!--<div class="col-md-12">
                   
                    A new trained model is generated based on training images and labels. For 3D segmentation tasks CDeep3M trains three different models seeing one frame (1 fm), seeing three frames (3 fm), and seeing five frames (5 fm) that are applied to image data.
                </div> -->
                <div class="col-md-12">
                Upload your trained CDeep3M model/s and share it to contribute to the database. Each trained model receives a DOI for citations.<br/>
                (Info: Follow these steps to <a href="https://github.com/CRBS/cdeep3m/wiki/Demorun-2-Running-small-training-and-prediction-with-mito-testsample-dataset" target="_blank">generate a new trained model</a> or 
                <a href="https://github.com/CRBS/cdeep3m/wiki/How-to-retrain-a-pretrained-network" target="_blank">re-train a previously trained model</a>)
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12">
                    
                    <a href="/cdeep3m_models/new_model" class="btn btn-primary">Upload CDeep3M Model</a>
                </div>
                 <div class="col-md-12"><br/></div>
                 <div class="col-md-12">
                     <a href="/cdeep3m_models/my_models" class="btn btn-primary">My trained Models</a>
                 </div>
                 
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">CDeep3M Preview (import test images)</span>
                </div>
                <div class="col-md-12">
                    <img src="https://iruka.crbs.ucsd.edu/cdeep3m_results/4962/overlay/overlay_002.png" width="100%" />
                </div>
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                
                <div class="col-md-12">
                    <!-- Upload small images and try the CDeep3M preview function. Select a trained model, augspeed , and frames to run the CDeep3M remotely. -->
                    Upload own images and try the CDeep3M preview function. Select a trained model from the database, augspeed, and frames to run CDeep3M remotely (using the <a href="https://nautilus.optiputer.net/" target="_blank">PRP cluster</a>).
                </div>
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12"> 
                   <a href="/cdeep3m_preview/new_images" class="btn btn-primary">Run CDeep3M Preview</a>
                </div>
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
                <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12"> 
                   <a href="/cdeep3m_preview/prp_demo" class="btn btn-primary">CDeep3M Demo on the CIL viewer</a>
                </div>
            </div>
        </div>
    </div>
</div>
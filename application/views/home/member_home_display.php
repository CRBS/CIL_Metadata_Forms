<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <span class="cil_title2">Upload trained model</span>
                </div>
                
                <div class="col-md-12">
                    <img src="https://cildata.crbs.ucsd.edu/media/model_display/50685/50685_thumbnailx512.jpg" width="100%" />
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                 
                <div class="col-md-12">
                   
                    A new trained model is generated based on training images and labels. For 3D segmentation tasks CDeep3M trains three different models seeing one frame (1 fm), seeing three frames (3 fm), and seeing five frames (5 fm) that are applied to image data.
                </div>
                 <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
                <div class="col-md-12">
                    
                    <a href="/cdeep3m_models/new_model" class="btn btn-primary">Upload CDeep3M Model</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <span class="cil_title2">CDeep3M Preview (import test images)</span>
            </div>
            <div class="col-md-12">
                <img src="https://iruka.crbs.ucsd.edu/cdeep3m_results/4962/overlay/overlay_002.png" width="100%" />
            </div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12">
                Upload small images and try the CDeep3M preview function. Select a trained model, augspeed , and frames to run the CDeep3M remotely.
            </div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12"> 
               <a href="/cdeep3m_preview/new_images" class="btn btn-primary">Run CDeep3M Preview</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <span class="cil_title2">CDeep3M Demo (use public CIL image volumes)</span>
            </div>
            <div class="col-md-12">
                <img src="/pix/cil_image_viewer.jpg" width="100%" />
            </div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12">
                The CIL Image Viewer utilizes the Leaflet library and the CodeIgniter PHP library for browsing the high definition images. This image viewer is capable of displaying confocal images, electron tomography z-stack images, and time-series images. This user-interface includes image controls such as zooming, panning, contrast adjustment, brightness adjustment, moving Z-stack location, moving the time location.
            </div>
            <div class="col-md-12"><hr style="height:1px; visibility:hidden;" /></div>
            <div class="col-md-12"> 
               <a href="http://cellimagelibrary.org/cdeep3m/prp_demo" class="btn btn-primary">Run CDeep3M Preview</a>
            </div>
        </div>
    </div>
</div>
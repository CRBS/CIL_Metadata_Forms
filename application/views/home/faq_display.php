<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12">
            <span class="cil_title3">FAQ:</span>
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <span class="cil_title2">What are CDeep3M Preview and CDeep3M Demo</span>
        </div>
        <!-- <hr style="height:10px; visibility:hidden;" /> -->
        <div class="col-md-12">
            <b>CDeep3M Preview</b> allows you to try CDeep3M without installations. You can predict on your own data with any pretrained model in our database and test the effect of different settings and see the whether the pretrained model is working well for your dataset.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <b>CDeep3M Demo</b> allows you to try CDeep3M without installations on images from hosted on the CIL (cellimagelibrary.org). You can predict select an ROI on a dataset and apply any pretrained model in our database and test the effect of different settings and see the whether the pretrained model is working well for this dataset. For further analysis you can download the full data and run CDeep3M using the same settings on the cloud, or within a Docker container.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            In both cases CDeep3M runs remotely on the <a href="https://nautilus.optiputer.net/" target="_blank" alt="prp cluster">PRP cluster.</a>
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <span class="cil_title2">How to use preview:</span>
        </div>
        <!-- <hr style="height:10px; visibility:hidden;" /> -->
        <div class="col-md-12">
        1) Add files <br/>
        2) Start Upload <br/>
        3) Select trained model to use <br/>
        4) Select augspeed <br/>
        5) Select 1fm, 3fm, 5fm<br/>
        6) Submit<br/>

        </div>
        
        <div class="col-md-12">
            <video controls=""   width="100%" >
                <source src="/pix/cdeep3m_demo.mp4" type="video/mp4">
           </video>
        </div>
        
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <span class="cil_title2">What is Augspeed:</span>
        </div>
        <!-- <hr style="height:10px; visibility:hidden;" /> -->
        <div class="col-md-12">
            <b>Augspeed 1:</b> Each dataset is augmented into 16 standard augmentations (rotations, flip l/r, flip u/d, stack inverted) and therefore the same data is processed 16 times. This is the slowest, but can increase the accuracy of the prediction.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <b>Augspeed 2 and 4:</b> Intermediate values, faster then augspeed 1 (by using only 8 or 4 augmentations). Around 2 and 4 times faster then augspeed 1 as a rough estimate, times might vary as they are also influenced by other factors.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <b>Augspeed 10:</b> Fastest configuration, processing the images without any augmentations.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <span class="cil_title2">What is 1fm, 3fm and 5fm:</span>
        </div>
        <div class="col-md-12">
            1fm = one frame is a 2D model whereas the 3fm and 5fm are 3D models. The 3fm model uses 3 frames for each predicted image and 5fm uses 5 frames for each predicted image.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <img src="/pix/1_3_5_fm.jpg" /><br/>From Haberl et al., 2018
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <b>Should I use 1fm, 3fm or 5fm:</b>
        </div>
        <hr style="height:5px; visibility:hidden;" />
        <div class="col-md-12">
            If your data is one of the following, it’s best to first test with the 1fm model: individual images, not well aligned stacks, or your z-step size is very different from the trained model. (See here what the z-steps are for each trained model)
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            If you have a well aligned stack of images that is fairly similar in the z-step size to the trained model, you can get better results with the 3fm and 5fm models.
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            If you select all three models (1fm, 3fm and 5fm) you will get all three processed and the results can be downloaded to compare the results. An ensemble will be generated from all three and is displayed and overlaid on top of your original image/s. The ensemble can be downloaded from the result.tar
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            <span class="cil_title2">I did not receive a link to see my results:</span>
        </div>
        <div class="col-md-12">
            Please check your spam folder in case you don’t receive a notification email within an hour after submitting the job (for small submissions with augspeed 10 it typically is less than 5min).
        </div>
        <div class="col-md-12"><br/></div>
        <div class="col-md-12">
            CDeep3M Preview generates a Job ID, you can check your results also directly by inserting your Job ID number at the end of this link: <br/>
            https://cdeep3m-viewer-stage.crbs.ucsd.edu/cdeep3m_result/view/<span style="color: red">0000</span><br/>
            <span style="color: red">Replace Job ID 0000 with real number.</span>
        </div>
    </div>
</div>

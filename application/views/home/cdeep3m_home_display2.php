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
    <div class="row" style="width: 100%; height: 1118px">
        
        
        <div class="col-md-12" style="background-image: url('/pix/cdeep3m_background.png');background-position: center center;background-size: 100% 100%;background-repeat: no-repeat;">
        <!--------------Row---------------------------->
        
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <span class="cil_title2" style="color:white">Training</span>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="#" class="btn btn-info" style="color:white">Create training data</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="#" class="btn btn-info" style="color:white">Retrain model</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="#" class="btn btn-info" style="color:white">Upload trained model</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div> 
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <br/>
                        <span class="cil_title2" style="color:white">Prediction</span>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="#" class="btn btn-info" style="color:white">Your own images</a>
                    </div>
                    
                    <div class="col-md-12">
                        <br/>
                        <a href="#" class="btn btn-info" style="color:white">The CIL images</a>
                    </div>

                </div>
            </div>
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
  


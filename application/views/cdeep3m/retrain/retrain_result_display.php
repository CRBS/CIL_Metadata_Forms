<div class="container">
<div class="row">
    <div class="col-md-12">
        <br/>
    </div>
    <div class="col-md-12 cil_title2">
        <br/>
        CDeep3M Retrain result: <?php echo $retrainID; ?>
    </div>
    <div class="col-md-6">
        <br/>
        <ul>
            <?php
                if(isset($model_json) && !is_null($model_json) && isset($model_json->Cdeepdm_model->Name))
                {
            ?>        
                <li><b>Model name:</b> <?php echo $model_json->Cdeepdm_model->Name;  ?></li>
            <?php
                }
            ?>
            <li><b>Model DOI:</b> <?php if(!is_null($retrain_info_json) && isset($retrain_info_json->model_doi)) echo $retrain_info_json->model_doi;  ?></li>
            <li><b>Additerations:</b> <?php if(!is_null($retrain_info_json) && isset($retrain_info_json->num_iterations)) echo $retrain_info_json->num_iterations;  ?></li>
            <li><b>Secondary Aug value:</b> <?php if(!is_null($retrain_info_json) && isset($retrain_info_json->second_aug)) echo $retrain_info_json->second_aug;  ?></li>
            <li><b>Tertiary Aug value: :</b> <?php if(!is_null($retrain_info_json) && isset($retrain_info_json->tertiary_aug)) echo $retrain_info_json->tertiary_aug;  ?></li>
            <li><b>Start time: :</b> <?php 
                if(!is_null($retrain_info_json) && isset($retrain_info_json->process_start_time))
                {
                    $start_time = explode(".", $retrain_info_json->process_start_time);
                    if(count($start_time) == 2)
                        echo $start_time[0];
                    else
                        echo $retrain_info_json->process_start_time;  
                }
            ?></li>
            <li><b>End time: :</b> <?php 
                if(!is_null($retrain_info_json) && isset($retrain_info_json->process_finish_time))
                {
                    $end_time = explode(".", $retrain_info_json->process_finish_time);
                    if(count($end_time) == 2)
                        echo $end_time[0];
                    else
                        echo $retrain_info_json->process_finish_time;  
                }
            ?></li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <br/>
                <center>
                <a href="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/retrained.tar" target="_blank" class="btn btn-primary">Download retrained model</a>
                </center>
            </div>
            <div class="col-md-12">
                <br/>
                <center>
                    <a href="<?php echo $image_viewer_prefix; ?>/cdeep3m_result/view/<?php echo $retrainID; ?>" target="_blank" class="btn btn-info">View the prediction result</a>
                </center>
            </div>
            <div class="col-md-12">
                <br/>
                <center>
                    <a href="<?php echo $base_url; ?>/cdeep3m_retrain/publish_model/<?php echo $retrainID; ?>" target="_blank" class="btn btn-info">Publish this retrained model</a>
                </center>
            </div>
        </div>
    </div>
    
    
    <div class="col-md-12">
          <div class="bs-component">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#1fm">1fm</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#3fm">3fm</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#5fm">5fm</a>
                </li>
                
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade show active" id="1fm">
                  <br/>
                  <span class="cil_title3">1fm</span>
                  <br/>
                  
                  <div class="row">
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/1fm/log/accuracy.png" width="100%"  />
                      </div>
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/1fm/log/loss.png" width="100%"  />
                      </div>
                  </div>
                  <!-- <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/1fm/log/accuracy.png" width="100%" height="600px" />
                  <br/>
                  <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/1fm/log/loss.png" width="100%" height="600px" /> -->
                </div>
                <div class="tab-pane fade" id="3fm">
                  <br/>
                  <span class="cil_title3">3fm</span>
                  <br/>
                  <div class="row">
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/3fm/log/accuracy.png" width="100%" />
                      </div>
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/3fm/log/loss.png" width="100%"  />
                      </div>
                  </div>
                  <!-- <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/3fm/log/accuracy.png" width="100%" height="600px" />
                  <br/>
                  <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/3fm/log/loss.png" width="100%" height="600px" /> -->
                </div>
                 <div class="tab-pane fade" id="5fm">
                  <br/>
                  <span class="cil_title3">5fm</span>
                  <br/>
                  <div class="row">
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/5fm/log/accuracy.png" width="100%"  />
                      </div> 
                      <div class="col-md-6">
                          <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php echo $retrainID; ?>/retrain_model/5fm/log/loss.png" width="100%" />
                      </div>
                  </div>
                  <!--
                  <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/5fm/log/accuracy.png" width="100%" height="600px" />
                  <br/>
                  <embed src="https://iruka.crbs.ucsd.edu/cdeep3m_retrain_results/<?php //echo $retrainID; ?>/retrain_model/5fm/log/loss.png" width="100%" height="600px" /> -->
                </div>
              </div>
          </div>
    </div>
    
    
    

    
    

</div>    
</div>

<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
include_once 'Image_dbutil.php';


class Cdeep3m_retrain extends CI_Controller
{
    
    public function index()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        $cropID =  $dbutil->getNextCropID();
        if(is_null($cropID) || !is_numeric($cropID))
        {
            redirect($base_url."/home");
            return;
        }
        
        $cropID = intval($cropID);
        $success = $dbutil->insertRetrainedModel($cropID);
        if(!$success)
        {
            redirect($base_url."/home");
            return;
        }
        
        redirect($base_url."/cdeep3m_retrain/upload_training_images/".$cropID);
    }
    
    public function submit_metadata($model_id="0")
    {
                $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        $ezutil = new EZIDUtil();
        $outil = new Ontology_util();
        
        if(strcmp($model_id, "0") == 0 || !is_numeric($model_id))
        {
            show_404();
            return;
        }
        
        $model_id = intval($model_id);
        $mjson = $dbutil->getModelJson($model_id);
        
        
        
        $base_url = $this->config->item('base_url');
        $data['debug'] = $this->input->get('debug', TRUE);
        $login_hash = $this->session->userdata('login_hash');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $username = $this->session->userdata('username');
        $data['username'] = $username;
        $data['user_role'] = $dbutil->getUserRole($username);
        
        
        $trained_model_name = $this->input->post('trained_model_name', TRUE);
        $ncbi = $this->input->post('image_search_parms[ncbi]', TRUE);
        $cell_type = $this->input->post('image_search_parms[cell_type]', TRUE);
        $cell_component = $this->input->post('image_search_parms[cellular_component]', TRUE);
        $image_type = $this->input->post('image_search_parms[item_type_bim]', TRUE);
        $magnification = $this->input->post('magnification', TRUE);
        $contributor = $this->input->post('contributor', TRUE);
        $desc = $this->input->post('description', TRUE);
        
        //$voxelsize = $this->input->post('voxelsize', TRUE);
        //$voxelsize_unit = $this->input->post('voxelsize_unit', TRUE);
        
        /********Voxel sizes******************/
        $x_voxelsize = $this->input->post('x_voxelsize', TRUE);
        $x_voxelsize_unit = $this->input->post('x_voxelsize_unit', TRUE);
        
        $y_voxelsize = $this->input->post('y_voxelsize', TRUE);
        $y_voxelsize_unit = $this->input->post('y_voxelsize_unit', TRUE);
        
        $z_voxelsize = $this->input->post('z_voxelsize', TRUE);
        $z_voxelsize_unit = $this->input->post('z_voxelsize_unit', TRUE);
        /********End voxel sizes**************/
        
        echo "<br/>trained_model_name:".$trained_model_name;
        if(!is_null($trained_model_name))
            $mjson->Cdeepdm_model->Name = $trained_model_name;
        
        if(!is_null($desc))
            $mjson->Cdeepdm_model->Description = $desc;
        
        echo "<br/>NCBI:".$ncbi;
        echo "<br/>cell_type:".$cell_type;
        echo "<br/>cell_component:".$cell_component;
        echo "<br/>image_type:".$image_type;
        echo "<br/>magnification:".$magnification;
        echo "<br/>x_voxelsize:".$x_voxelsize;
        echo "<br/>x_voxelsize_unit:".$x_voxelsize_unit;
        echo "<br/>y_voxelsize:".$y_voxelsize;
        echo "<br/>y_voxelsize_unit:".$y_voxelsize_unit;
        echo "<br/>z_voxelsize:".$z_voxelsize;
        echo "<br/>z_voxelsize_unit:".$z_voxelsize_unit;
        $targetDir = $this->config->item('model_upload_location');
        if(!file_exists($targetDir))
           mkdir($targetDir);
                
        $targetDir = $targetDir."/".$model_id;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        
          
        if(!is_null($ncbi) && strlen(trim($ncbi)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION))
                $ncbiJson = $mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "ncbi_organism", $ncbi);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->NCBIORGANISMALCLASSIFICATION = $ncbiJson;
        }
        
        if(!is_null($cell_type) && strlen(trim($cell_type)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->CELLTYPE))
                $ncbiJson = $mjson->Cdeepdm_model->CELLTYPE;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "cell_types", $cell_type);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->CELLTYPE = $ncbiJson;
        }
        
        if(!is_null($cell_component) && strlen(trim($cell_component)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->CELLULARCOMPONENT))
                $ncbiJson = $mjson->Cdeepdm_model->CELLULARCOMPONENT;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "cellular_components", $cell_component);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->CELLULARCOMPONENT = $ncbiJson;
        }
        
        
        if(!is_null($image_type) && strlen(trim($image_type)) > 0)
        {   
            $narray = array();
            $ncbiJsonStr = json_encode($narray);
            $ncbiJson = json_decode($ncbiJsonStr);
            if(isset($mjson->Cdeepdm_model->ITEMTYPE))
                $ncbiJson = $mjson->Cdeepdm_model->ITEMTYPE;
            
            $ncbiJson=$outil->handleExistingOntoJSON($ncbiJson, "imaging_methods", $image_type);
            //echo json_encode($ncbiJson,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $mjson->Cdeepdm_model->ITEMTYPE = $ncbiJson;
        }
        
        if(!is_null($magnification) && strlen(trim($magnification)) > 0)
        { 
            $mjson->Cdeepdm_model->Magnification = $magnification;
        }
        
        
        /*        
        if(!is_null($voxelsize) && strlen(trim($voxelsize)) > 0)
        { 
            $varray = array();
            $varray['Value'] = doubleval($voxelsize);
            $varray['Unit'] = $voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Voxelsize = $vjson;
        }
        */
        if(!is_null($x_voxelsize) && strlen(trim($x_voxelsize)) > 0 && is_numeric($x_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($x_voxelsize);
            $varray['Unit'] = $x_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->X_voxelsize = $vjson;
        }
        if(!is_null($y_voxelsize) && strlen(trim($y_voxelsize)) > 0 && is_numeric($y_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($y_voxelsize);
            $varray['Unit'] = $y_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Y_voxelsize = $vjson;
        }
        if(!is_null($z_voxelsize) && strlen(trim($z_voxelsize)) > 0 && is_numeric($z_voxelsize))
        { 
            $varray = array();
            $varray['Value'] = doubleval($z_voxelsize);
            $varray['Unit'] = $z_voxelsize_unit;
            $vjson_str = json_encode($varray);
            $vjson = json_decode($vjson_str);
            $mjson->Cdeepdm_model->Z_voxelsize = $vjson;
        }
        else
        {
            
            if(isset($mjson->Cdeepdm_model->Z_voxelsize))
                //unset($mjson['Cdeepdm_model']['Z_voxelsize']);
                unset($mjson->Cdeepdm_model->Z_voxelsize);
        }

        
        if(!is_null($contributor)&& strlen(trim($contributor)) > 0)
        {
            
            if(isset($mjson->Cdeepdm_model->Contributors))
            {
                array_push($mjson->Cdeepdm_model->Contributors, $contributor);
            }
            else
            {
                $carray = array();
                array_push($carray, $contributor);
                $cjson_str = json_encode($carray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $cjson = json_decode($cjson_str);
                $mjson->Cdeepdm_model->Contributors = $cjson;
            }
        }
        
        
        if(!is_null($mjson))
        {
            $json_str = json_encode($mjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $dbutil->updateModelJson($model_id,$json_str);
        }
       
    }
    
    public function publish_model($retrain_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        $retrain_id = intval($retrain_id);
        $model_id = $retrain_id;
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        $mjson = $dbutil->getModelJson($retrain_id);
        $data['mjson'] = $mjson;
        $userInfo = $dbutil->getUserInfo($data['username']);
        $data['model_id'] = $retrain_id;
        
        ///////////////////////////Display image//////////////////////////
        $remote_service_prefix =  $this->config->item('remote_service_prefix');
        $jpg_path = "/export2/media/model_display/".$model_id."/".$model_id."_thumbnailx512.jpg";
        $metadata_auth = $this->config->item('metadata_auth');
        $filezize_str = $cutil->auth_curl_get_with_data($metadata_auth,$remote_service_prefix."/rest/file_size", $jpg_path);
        //echo "<br/>File JSON STR:".$filezize_str;
        $sjson = json_decode($filezize_str);
        $hasImage = false;
        if(!is_null($sjson) && isset($sjson->Size) && $sjson->Size > 0)
            $hasImage = true;
        
        $data['hasDisplayImage'] = $hasImage;
        
        
        //////////////////////////End Display image///////////////////////
        
        
        
        $data['retrainID'] = $retrain_id;
        $data['title'] = 'Home > Publish model:'.$retrain_id;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/publish_retrain_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function result($retrain_id="0")
    {
        $dbutil = new DB_util();
        
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        
        $done = $dbutil->isRetrainProcessFinished($retrain_id);
        if(!$done)
        {
            echo "Your retrain process is not done yet.";
            return;
        }
        
        $retrain_result_folder_prefix = $this->config->item('retrain_result_folder_prefix');
        $retrain_result_folder = $retrain_result_folder_prefix."/".$retrain_id."/retrain_model";
        if(!file_exists($retrain_result_folder))
        {
            echo "Your retrain result folder does not exist";
            return;
        }
        
        $retrainInfoJson = $dbutil->getRetrainInfo($retrain_id);
        $data['retrain_info_json'] = $retrainInfoJson;
        
        if(!is_null($retrainInfoJson) && isset($retrainInfoJson->model_doi))
        {
            $modelID = str_replace("https://doi.org/10.7295/W9CDEEP3M", "", $retrainInfoJson->model_doi);
            if(!is_null($modelID) && is_numeric($modelID))
            {
                $modelID = intval($modelID);
                $model_json = $dbutil->getModelJson($modelID);
                if(!is_null($model_json))
                {
                    $data['model_json'] = $model_json;
                }
            }
        }
        
        
        /*
        $files = scandir($retrain_result_folder);
        foreach($files as $file)
        {
            echo "<br/>".$file;
        }
        */
        $data['retrain_result_folder'] = $retrain_result_folder;
        $data['retrainID'] = $retrain_id;
        $data['title'] = 'Home > Retrain result:'.$retrain_id;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/retrain_result_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function upload_training_images($retrain_id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        $data['base_url'] = $base_url;
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        if(is_null($retrain_id) || !is_numeric($retrain_id) || $retrain_id == 0)
        {
            redirect($base_url."/home");
            return;
        }
        
        
        $data['retrainID'] = $retrain_id;
        $data['title'] = 'Home > Upload re-training images';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/retrain_images_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function do_upload_retrain_labels($retrainID=0)
    {
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Unable to verify the user."}, "id" : "id"}';
            die($message);
        }
        
        $targetDir0 = $this->config->item('retrain_upload_location');
        if(!file_exists($targetDir0))
            mkdir($targetDir0);
                
        $targetDir1 = $targetDir0."/".$retrainID;
        if(!file_exists($targetDir1))
            mkdir($targetDir1);
        
        $targetDir = $targetDir1."/retrain_labels";
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        error_log("\ntargetDir:".$targetDir1, 3, $targetDir1."/retrain_labels_upload.log");

        $cleanupTargetDir = false; // Remove old files
        $maxFileAge = 60 * 60*60; // Temp file age in seconds
        set_time_limit(5 * 60*100);
               
                
        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        // Clean the fileName for security reasons
        $fileName = "";
        if (isset($_REQUEST["name"])) 
        {
            $fileName = $_REQUEST["name"];           
        }

        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
        if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            error_log("\nStep 0: Filename:".$fileName, 3, $targetDir1."/retrain_labels_upload.log");
                
        $fileName2 = $_FILES["file"]["name"];
        error_log("\nStep 0.1: Filename:".$fileName2, 3, $targetDir1."/retrain_labels_upload.log");
                
        // Create target dir
        if (!file_exists($targetDir))
            mkdir($targetDir);
                
        // Remove old temp files
        if (!file_exists($targetDir))
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
                
        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
                
        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];
                
        error_log("\nStep 0", 3, $targetDir1."/retrain_labels_upload.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1", 3, $targetDir1."/retrain_labels_upload.log");

            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            {
                // Open temp file
                $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) 
                {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");
                    if ($in) 
                    {
                        while ($buff = fread($in, 4096))
                        {
                            fwrite($out, $buff);
                        }
                    }
                    else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    
                    fclose($out);
                    unlink($_FILES['file']['tmp_name']);
                }
                else
                {
                    $message = '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
                    error_log("\n".$message, 3, $targetDir1."/retrain_labels_upload.log");
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                error_log("\n".$message, 3, $targetDir1."/retrain_labels_upload.log");
                die($message);
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $targetDir1."/retrain_labels_upload.log");
            // Open temp file
            $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) 
            {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");
                if ($in) 
                {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                }
            }
        }
    }
    
    public function add_retraining_labels($retrainID)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $do_tar_retrain_files = $this->config->item('do_tar_retrain_files');
        
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        if(is_null($retrainID) || !is_numeric($retrainID) || $retrainID == 0)
        {
            redirect($base_url."/cdeep3m_retrain");
            return;
        }
        
        //$dbutil->insertRetrainedModel($retrainID);
        $retrainLabelFolder = $this->config->item('retrain_upload_location')."/".$retrainID."/retrain_labels";
        if(file_exists($retrainLabelFolder))
        { 
            echo "<br/>".$retrainLabelFolder;
            
            $retrainID = intval($retrainID);
            $dbutil->updateRetrainLabelFolder($retrainID, $retrainLabelFolder);
            if($do_tar_retrain_files)
            {
                $parentFolder = $this->config->item('retrain_upload_location')."/".$retrainID; 
                $gutil->createRetrainLabelTar($retrainID, $parentFolder, $retrainLabelFolder);
            }
            //echo "<br/>Success!";
            //return;
        }
        else 
        {
            echo "Error---Retrain label folder does not exist:".$retrainLabelFolder;
            return;
            //redirect($base_url."/cdeep3m_retrain");
            //return;
        }
        redirect ($base_url."/cdeep3m_retrain/select_retrain_params/".$retrainID);
        
    }
    
    public function add_retraining_images($retrainID)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $do_tar_retrain_files = $this->config->item('do_tar_retrain_files');
        
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        if(is_null($retrainID) || !is_numeric($retrainID) || $retrainID == 0)
        {
            redirect($base_url."/cdeep3m_retrain");
            return;
        }
        
        //$dbutil->insertRetrainedModel($retrainID);
        $retrainImageFolder = $this->config->item('retrain_upload_location')."/".$retrainID."/retrain_images";
        if(file_exists($retrainImageFolder))
        { 
            echo "<br/>".$retrainImageFolder;
            
            $retrainID = intval($retrainID);
            $dbutil->updateRetrainImageFolder($retrainID, $retrainImageFolder);
            if($do_tar_retrain_files)
            {
                $parentFolder  = $this->config->item('retrain_upload_location')."/".$retrainID; 
                $gutil->createRetrainImageTar($retrainID, $parentFolder, $retrainImageFolder);
            }
            //echo "<br/>Success!";
            //return;
        }
        else 
        {
            echo "Error ----- image folder does not exist:".$retrainImageFolder;
            return;
            //redirect($base_url."/cdeep3m_retrain");
            //return;
        }
        redirect ($base_url."/cdeep3m_retrain/upload_training_labels/".$retrainID);
        
    }
    
    
    public function do_upload_retraining_images($retrainID=0)
    {
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Unable to verify the user."}, "id" : "id"}';
            die($message);
        }
        
        $targetDir0 = $this->config->item('retrain_upload_location');
        
        if(!file_exists($targetDir0))
            mkdir($targetDir);
                
        $targetDir1 = $targetDir0."/".$retrainID;
        if(!file_exists($targetDir1))
            mkdir($targetDir1);
        
        $targetDir = $targetDir1."/retrain_images";
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        error_log("\ntargetDir:".$targetDir1, 3, $targetDir1."/retrain_image_upload.log");

        $cleanupTargetDir = false; // Remove old files
        $maxFileAge = 60 * 60*60; // Temp file age in seconds
        set_time_limit(5 * 60*100);
               
                
        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        // Clean the fileName for security reasons
        $fileName = "";
        if (isset($_REQUEST["name"])) 
        {
            $fileName = $_REQUEST["name"];           
        }

        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
        if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            error_log("\nStep 0: Filename:".$fileName, 3, $targetDir1."/retrain_image_upload.log");
                
        $fileName2 = $_FILES["file"]["name"];
        error_log("\nStep 0.1: Filename:".$fileName2, 3, $targetDir1."/retrain_image_upload.log");
                
        // Create target dir
        if (!file_exists($targetDir))
            mkdir($targetDir);
                
        // Remove old temp files
        if (!file_exists($targetDir))
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
                
        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
                
        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];
                
        error_log("\nStep 0", 3, $targetDir1."/retrain_image_upload.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1", 3, $targetDir1."/retrain_image_upload.log");

            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            {
                // Open temp file
                $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) 
                {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");
                    if ($in) 
                    {
                        while ($buff = fread($in, 4096))
                        {
                            fwrite($out, $buff);
                        }
                    }
                    else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    
                    fclose($out);
                    unlink($_FILES['file']['tmp_name']);
                }
                else
                {
                    $message = '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
                    error_log("\n".$message, 3, $targetDir1."/retrain_image_upload.log");
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                error_log("\n".$message, 3, $targetDir1."/retrain_image_upload.log");
                die($message);
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $targetDir1."/retrain_image_upload.log");
            // Open temp file
            $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) 
            {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");
                if ($in) 
                {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                }
            }
        }
    }
    
    
    public function submit_retrain($retrainID=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $cutil = new Curl_util();
        
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $is_prod = $this->config->item('is_prod');
        $remote_service_prefix = $this->config->item('remote_service_prefix');
        $metadata_auth = $this->config->item('metadata_auth');
        $retrainUrl = $remote_service_prefix."/cdeep3m_retrain_service/submit_prp_retrain/".$retrainID;
        
        
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        if(is_null($retrainID) || !is_numeric($retrainID))
        {
            redirect($base_url."/home");
            return;
        }
        
        
        
        $retrainID = intval($retrainID);
        $model_doi = $this->input->post('ct_training_models', TRUE);
        //$aug_speed = $this->input->post('ct_augmentation', TRUE);
        //$aug_speed = intval($aug_speed);
        
        $second_aug = $this->input->post('second_ranage', TRUE);
        $second_aug = intval($second_aug);
        
        $tertiary_aug = $this->input->post('tertiary_ranage', TRUE);
        $tertiary_aug = intval($tertiary_aug);
        
        
        $num_iterations = $this->input->post('ct_iteration_ranage', TRUE);
        $num_iterations = intval($num_iterations);
        $email = $this->input->post('email', TRUE);
        
        
        $dbutil->updateRetrainParameters($retrainID, $model_doi, $second_aug, $tertiary_aug, $num_iterations, $username, $email);
        
        $dbutil->insertCroppingInfoWithTraining($retrainID, $email, $model_doi, 10, "1fm");
        //echo "<br/>retrain ID:".$retrainID;
        $do_tar_retrain_files = $this->config->item('do_tar_retrain_files');
        if($do_tar_retrain_files)
        {
            $retrainImageTarFile = $this->config->item('retrain_upload_location')."/".$retrainID."/retrain_images/retrain_images.tar";
            if(file_exists($retrainImageTarFile))
            {
                //echo "<br/>Retrain image tar URL: http://cildata.crbs.ucsd.edu/retrain_upload/".$retrainID."/retrain_images/retrain_images.tar";
            }
            
            $retrainLabelTarFile = $this->config->item('retrain_upload_location')."/".$retrainID."/retrain_labels/retrain_labels.tar";
            if(file_exists($retrainLabelTarFile))
            {
                //echo "<br/>Retrain label tar URL: http://cildata.crbs.ucsd.edu/retrain_upload/".$retrainID."/retrain_labels/retrain_labels.tar";
            }
        }
        
        /*
        echo "<br/>training model DOI:".$model_doi;
        echo "<br/>Iteration:".$num_iterations;
        echo "<br/>Email:".$email;
        echo "<br/>Username:".$username;
        echo "<br/>Secondary Aug value:".$second_aug;
        echo "<br/>Tertiary Aug value:".$tertiary_aug;
         */
        
        $inputArray = array();
        $inputArray['model_url'] = $model_doi;
        $inputArray['secondary_aug_v'] = $second_aug;
        $inputArray['tertiary_aug_v'] = $tertiary_aug;
        $inputArray['additerations'] = $num_iterations;
        $inputArray['email'] = $email;
        $inputArray['username'] = $data['username'];
        
        $retrain_input_str = json_encode($inputArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $targetDir0 = $this->config->item('retrain_upload_location');
        if(!file_exists($targetDir0))
            mkdir($targetDir);
                
        $targetDir1 = $targetDir0."/".$retrainID;
        if(!file_exists($targetDir1))
            mkdir($targetDir1);
        
        $targetFile= $targetDir1."/retrain_input_from_site.json";
        $debugLogFile = $targetDir1."/debug.log";
        
        if(file_exists($debugLogFile))
            unlink ($debugLogFile);
        
        error_log("\n".$retrainUrl, 3, $debugLogFile);
        
        if(file_exists($targetFile))
            unlink($targetFile);
  
        file_put_contents($targetFile, $retrain_input_str);
        if($is_prod)
            $cutil->auth_curl_post($retrainUrl, $metadata_auth, $retrain_input_str);
        
        
        $data['retrainID'] = $retrainID;
        $data['title'] = 'Home > Cdeep3M Submitted';
        $data['email'] = $email;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/submitted_parameters_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function select_retrain_params($retrainID=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        $userInfo = $dbutil->getUserInfo($data['username']);
        if(!is_null($userInfo))
        {
            
            $data['email'] = $userInfo['email'];
        }
        $data['all_model_json'] = $dbutil->getAllModelJsonList();
        
        $data['retrainID'] = $retrainID;
        $data['title'] = 'Home > Select retrain parameters';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/select_retrain_params_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function upload_training_labels($retrainID=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['base_url'] = $base_url;
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        
        $data['retrainID'] = $retrainID;
        $data['title'] = 'Home > Upload re-training labels';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/retrain_labels_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
}


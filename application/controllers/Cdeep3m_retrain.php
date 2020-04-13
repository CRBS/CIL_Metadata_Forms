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
            //echo "<br/>Success!";
            //return;
        }
        else 
        {
            //echo "Error:".$retrainImageFolder;
            //return;
            redirect($base_url."/cdeep3m_retrain");
            return;
        }
        redirect ($base_url."/cdeep3m_retrain/select_retrain_params/".$retrainID);
        
    }
    
    public function add_retraining_images($retrainID)
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
            //echo "<br/>Success!";
            //return;
        }
        else 
        {
            //echo "Error:".$retrainImageFolder;
            //return;
            redirect($base_url."/cdeep3m_retrain");
            return;
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
        
        if(is_null($retrainID) || !is_numeric($retrainID))
        {
            redirect($base_url."/home");
            return;
        }
        
        $retrainID = intval($retrainID);
        $model_doi = $this->input->post('ct_training_models', TRUE);
        $aug_speed = $this->input->post('ct_augmentation', TRUE);
        $aug_speed = intval($aug_speed);
        $num_iterations = $this->input->post('ct_iteration_ranage', TRUE);
        $num_iterations = intval($num_iterations);
        $email = $this->input->post('email', TRUE);
        
        
        $dbutil->updateRetrainParameters($retrainID, $model_doi, $aug_speed, $num_iterations, $username, $email);
        
        
        echo "<br/>retrain ID:".$retrainID;
        echo "<br/>training model DOI:".$model_doi;
        echo "<br/>Augspeed:".$aug_speed;
        echo "<br/>Iteration:".$num_iterations;
        echo "<br/>Email:".$email;
        echo "<br/>Username:".$username;
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


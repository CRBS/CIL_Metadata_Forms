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
        
        $targetDir = $this->config->item('images_upload_location');
        if(!file_exists($targetDir))
            mkdir($targetDir);
                
        $targetDir = $targetDir."/".$retrainID;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        $targetDir = $targetDir."/retrain_labels";
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        error_log("\ntargetDir:".$targetDir, 3, $targetDir."/retrain_image_upload.log");

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
            error_log("\nStep 0: Filename:".$fileName, 3, $targetDir."/retrain_image_upload.log");
                
        $fileName2 = $_FILES["file"]["name"];
        error_log("\nStep 0.1: Filename:".$fileName2, 3, $targetDir."/retrain_image_upload.log");
                
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
                
        error_log("\nStep 0", 3, $targetDir."/retrain_image_upload.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1", 3, $targetDir."/retrain_image_upload.log");

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
                    error_log("\n".$message, 3, $targetDir."/retrain_image_upload.log");
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                error_log("\n".$message, 3, $targetDir."/retrain_image_upload.log");
                die($message);
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $targetDir."/retrain_image_upload.log");
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
    
    
    public function add_retraining_record($retrainID)
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
        
        $dbutil->insertRetrainedModel($retrainID);
        
        redirect ($base_url."/cdeep3m_retrain/upload_training_labels/".$retrainID);
        
    }
    
    public function upload_training_labels($retrainID=0)
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
        
        
        $data['retrainID'] = $retrainID;
        $data['title'] = 'Home > Upload re-training images';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/retrain/retrain_labels_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
}


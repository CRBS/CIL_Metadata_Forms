<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';

class Cdeep3m_create_training extends CI_Controller
{
    public function create()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $base_url = $this->config->item('base_url');
        
        
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        //echo $data['username'];
        $data['token'] = $dbutil->getAuthToken($data['username']);
        //echo "<br/>Token:".$data['token']."----";
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        
        $id = $dbutil->getNextCropID();
        
        $super_pixel_prefix = $this->config->item('super_pixel_prefix');
        if(file_exists($super_pixel_prefix))
        {
            $subFolder1 = $super_pixel_prefix."/SP_".$id;
            mkdir($subFolder1);
            
            if(file_exists($subFolder1))
            {
                $subFolder2 = $subFolder1."/original";
                mkdir($subFolder2);
                
                $subFolder3 = $subFolder1."/overlay";
                mkdir($subFolder3);
            }
        }
        
                
        redirect ($base_url."/cdeep3m_create_training/upload_images/".$id);
        
    }
    
    public function upload_images($sp_id)
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $data['base_url'] = $this->config->item('base_url');
        $data['sp_id'] = intval($sp_id);
        $data['step'] = 1;
        $data['title'] = 'Home > Upload images';
        $this->load->view('templates/header', $data);
        $this->load->view('super_pixel/images_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function pending($sp_id)
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $targetDir = $this->config->item('super_pixel_prefix');
        $targetDir = $targetDir."/SP_".$sp_id;
        $topDir = $targetDir;
        $targetDir = $targetDir."/original";
        
        $files = scandir($targetDir);
        $index = 0;
        $mainArray = array();
        $width = 0;
        $height = 0;
        $imageCount = 0;
        
        foreach($files as $file)
        {
            
            if(strcmp($file, ".") == 0 || strcmp($file, "..") == 0)
               continue;
            
            if($gutil->endsWith($file, ".png"))
            {
                $imageCount++;
                $item = array();
                $item['image_name'] = $file;
                $item['index'] = $index;
                
                $imageSize = getimagesize($targetDir."/".$file);
                if($index == 0)
                {                    
                    $width = $imageSize[0];
                    $height = $imageSize[1];
                }
                $item['width'] = $imageSize[0];
                $item['height'] = $imageSize[1];
                
                array_push($mainArray, $item);
            }
            $index++;
        }
        $json_str = json_encode($mainArray, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES);
        file_put_contents($topDir."/mapping.json", $json_str);
        
        $dbutil->insertSuperPixel($sp_id, $width, $height, $imageCount, $username);
        
        $data['base_url'] = $this->config->item('base_url');
        $data['sp_id'] = intval($sp_id);
        $data['step'] = 1;
        $data['title'] = 'Home > Upload images';
        $this->load->view('templates/header', $data);
        $this->load->view('super_pixel/pending_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    function process_images_upload($model_id=0)
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
        
        $targetDir = $this->config->item('super_pixel_prefix');
        if(!file_exists($targetDir))
            mkdir($targetDir);
                
        $targetDir = $targetDir."/SP_".$model_id;
        $topDir = $targetDir;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        $targetDir = $targetDir."/original";
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        error_log("\ntargetDir:".$targetDir, 3, $topDir."/upload.log");

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
            error_log("\nStep 0: Filename:".$fileName, 3, $topDir."/upload.log");
                
        $fileName2 = $_FILES["file"]["name"];
        error_log("\nStep 0.1: Filename:".$fileName2, 3, $topDir."/upload.log");
                
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
                
        error_log("\nStep 0", 3, $topDir."/upload.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1", 3, $topDir."/upload.log");

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
                    error_log("\n".$message, 3, $topDir."/upload.log");
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                error_log("\n".$message, 3, $topDir."/upload.log");
                die($message);
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $topDir."/upload.log");
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
    
    
}

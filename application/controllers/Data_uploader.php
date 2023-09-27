<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';



class Data_uploader extends CI_Controller
{

    public function test()
    {
        $imagesFolder = $this->config->item('data_location');
        echo $imagesFolder;
    }
    
    
    public function process_images_upload($image_id="CIL_0")
    {
        error_reporting(E_ALL ^ E_WARNING);
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Unable to verify the user."}, "id" : "id"}';
            //die($message);
            //$message = "Invalid login";
            $this->output->set_status_header('400');
            header('Content-Type: application/json');
            die($message);
        }
        
        $min_upload_id = $this->config->item('min_upload_id');
        //$imagesFolder = $this->config->item('production_data_location');
        $imagesFolder = $this->config->item('data_location');
        //$is_prod = $this->config->item('is_prod');
        
        /*if($is_prod)
            $imagesFolder = $this->config->item('data_location');
        else
            $imagesFolder = $this->config->item('data_location');*/
        $num_folder = $image_id;//str_replace("CIL_", "", $image_id);

        $targetDir = $imagesFolder."/".$num_folder;
        
        $num = intval($num_folder);
        if($num<=$min_upload_id)
        {
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Invalid image ID: '.$num.'."}, "id" : '.$num.'}';
            //$message = "Invalid Image ID:"+$num;
            error_log("\nUpload error: ID is ".$num, 3, $targetDir."/upload_zip.log");
            $this->output->set_status_header('400');
            //header('Content-Type: application/json');
            die($message);
            return;
            
        }
            
        
        
        
        $topDir = $targetDir;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        
        $uploadLog = $targetDir."/upload.log";
        if(!file_exists($uploadLog))
        {
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "This folder cannot be modified - image ID: '.$num.'."}, "id" : '.$num.'}';
            //$message = "Invalid Image ID:"+$num;
            error_log("\nUpload error: ID is ".$num, 3, $targetDir."/upload_zip.log");
            error_log("\n".$message, 3, $targetDir."/upload_zip.log");
            $this->output->set_status_header('400');
            //header('Content-Type: application/json');
            die($message);
            return;
        }
        
        error_log("\ntargetDir:".$targetDir, 3, $targetDir."/upload_zip.log");

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

        //$fileName = preg_replace('/[^\w\._]+/', '', $fileName);
        $fileName = $image_id.".zip";
        
        if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            error_log("\nStep 0: Filename:".$fileName, 3, $targetDir."/upload_zip.log");
                
        //$fileName2 = $_FILES["file"]["name"];
        //error_log("\nStep 0.1: Filename:".$fileName2, 3, $targetDir."/upload_zip.log");
                
        // Create target dir
        if (!file_exists($targetDir))
            mkdir($targetDir);
                
        // Remove old temp files
        if (!file_exists($targetDir))
        {
           // die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            $message = '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
            //$message = "Failed to open temp directory.";
            $this->output->set_status_header('400');
            header('Content-Type: application/json');
            die($message);
        }
        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
                
        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];
                
        error_log("\nStep 0", 3, $topDir."/upload_zip.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1:", 3, $topDir."/upload_zip.log");

            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) 
            {
                error_log("\nStep 1.1 - upload file:".$_FILES['file']['tmp_name'], 3, $topDir."/upload_zip.log");
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
                    {
                        //die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                        //$message = "Failed to open input stream.";
                        $message = '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                        $this->output->set_status_header('400');
                        header('Content-Type: application/json');
                        die($message);
                    }
                    fclose($out);
                    try
                    {
                    unlink($_FILES['file']['tmp_name']);
                    
                    }
                    catch(Exception $e) 
                    {
                         error_log("\n".$e->getMessage(), 3, $targetDir."/upload_zip.log");
                    }
                }
                else
                {
                    $message = '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
                    //$message = "Failed to open output stream.";
                    error_log("\n".$message, 3, $targetDir."/upload_zip.log");
                    //die($message);
                    $this->output->set_status_header('400');
                    header('Content-Type: application/json');
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                //error_log("\n".$message, 3, $targetDir."/upload_zip.log");
                //die($message);
                //$message = "Failed to move uploaded file.";
                error_log("\n".$message, 3, $targetDir."/upload_zip.log");
                //die($message);
                $this->output->set_status_header('400');
                header('Content-Type: application/json');
                die($message);
                
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $imagesFolder."/upload_zip.log");
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
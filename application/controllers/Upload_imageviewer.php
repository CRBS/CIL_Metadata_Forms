<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';

class Upload_imageviewer extends CI_Controller
{
    public function create_imagename()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data['title'] = "NCMIR | Upload image viewer data";
        
        
        $base_url = $this->config->item('base_url');
        $is_prod = $this->config->item('is_prod');
        
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!$this->isUserNcmir($username))
        {
            //echo "<br/> Is not NCMIR";
            redirect($base_url."/home");
        }
        
        $image_name = $this->input->post('image_name', TRUE);
        
        if(is_null($image_name))
        {
            $this->load->view('templates/header2', $data);
            $this->load->view('upload_imageviewer/create_imagename', $data);
            $this->load->view('templates/footer', $data);
        }
        else 
        {
            $imageviewer_data_folder = $this->config->item('imageviewer_data_folder');
            if($is_prod)
                $response =  exec("ls ".$imageviewer_data_folder);
            else 
                $response =  exec("dir ".$imageviewer_data_folder);
            
            $image_dir = $imageviewer_data_folder."/NCMIR_".$image_name;
            if(is_dir($image_dir))
            {
                $data['error_message'] = "Image name, 'NCMIR_".$image_name."' already exists. Please choose another name.";
                $this->load->view('templates/header2', $data);
                $this->load->view('upload_imageviewer/create_imagename', $data);
                $this->load->view('templates/footer', $data);
            }
            else 
            {
                mkdir($image_dir);
                //echo "<br/>Folder created:".$image_dir;
                redirect($base_url."/Upload_imageviewer/upload_sqlite_files/NCMIR_".$image_name);
            }
            //echo "<br/>".$image_name;
        }
        
        
        
        
    }
    
    public function configure($image_name) 
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data['title'] = "NCMIR | Upload image viewer data";
        $data['image_name'] = $image_name;
        
        $base_url = $this->config->item('base_url');
        $is_prod = $this->config->item('is_prod');
        
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!$this->isUserNcmir($username))
        {
            //echo "<br/> Is not NCMIR";
            redirect($base_url."/home");
        }
        
        $imageviewer_data_folder = $this->config->item('imageviewer_data_folder');
        $targetDir = $imageviewer_data_folder."/".$image_name;
        if($is_prod)
            $response =  exec("ls ".$targetDir);
        else 
            $response =  exec("dir ".$targetDir);
        
        $data['max_z'] = 0;
        
        if(is_dir($targetDir))
        {
           $counter = 0;
           $files = scandir($targetDir);
           foreach($files as $file)
           {
                if($gutil->endsWith($file, ".sqllite3"))
                {
                    $counter++;
                }
           }
           if($counter > 0)
               $counter = $counter -1;
           $data['max_z'] = $counter;
        }
        
        $gdal_info_file = $targetDir."/gdal_info.json";
        if(file_exists($gdal_info_file))
        {
            $gjson_str = file_get_contents($gdal_info_file);
            $gjson = json_decode($gjson_str);
            if(isset($gjson->max_zoom))
            {
                $data['max_zoom'] = $gjson->max_zoom;
            }
        }
        
        $this->load->view('templates/header2', $data);
        $this->load->view('upload_imageviewer/configure_image', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function submit_config()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data['title'] = "NCMIR | Image Viewer URL";
       
        
        $base_url = $this->config->item('base_url');
        $is_prod = $this->config->item('is_prod');
        
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!$this->isUserNcmir($username))
        {
            //echo "<br/> Is not NCMIR";
            redirect($base_url."/home");
        }
        
            $base_url = $this->config->item('base_url');
            $image_id = $this->input->post('image_id', TRUE);
            $max_z = $this->input->post('max_z', TRUE);
            $is_rgb = "true";
            $temp = $this->input->post('is_rgb', TRUE);
            if(is_null($temp))
                $is_rgb = "false";
            $max_zoom = $this->input->post('max_zoom', TRUE);
            $init_lat = $this->input->post('init_lat', TRUE);
            $init_lng = $this->input->post('init_lng', TRUE);
            $init_zoom = $this->input->post('init_zoom', TRUE);
            
            $is_public = "false";
            $is_timeseries = "false";
            $max_t = 0;
            
            $array = array();
            $array['max_z'] = $max_z;
            $array['is_rgb'] = $is_rgb;
            $array['max_zoom'] = $max_zoom;
            $array['init_lat'] = $init_lat;
            $array['init_lng'] = $init_lng;
            $array['init_zoom'] = $init_zoom;
            $array['is_public'] = $is_public;
            $array['is_timeseries'] = $is_timeseries;
            $array['max_t'] = $max_t;
            
            $dbutil = new DB_util();
            $db_params = $this->config->item('image_viewer_db_params');
            $dbutil->handleImageUpdate($db_params, $image_id, $array);     
            
            $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
            $data['token'] = $dbutil->getAuthToken($data['username']);
            $data['image_id'] = $image_id;
           $this->load->view('templates/header2', $data);
           $this->load->view('upload_imageviewer/show_image_url_display', $data);
           $this->load->view('templates/footer', $data);
    }
    
    public function upload_sqlite_files($image_name)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data['title'] = "NCMIR | Upload image viewer data";
        
        
        $base_url = $this->config->item('base_url');
        $is_prod = $this->config->item('is_prod');
        
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!$this->isUserNcmir($username))
        {
            //echo "<br/> Is not NCMIR";
            redirect($base_url."/home");
        }
        
        
        if(is_null($image_name) || strlen($image_name) == 0)
        {
            redirect($base_url."/home");
        }
        
        $data['image_name'] = $image_name;
        
        $this->load->view('templates/header2', $data);
        $this->load->view('upload_imageviewer/images_upload_display', $data);
        $this->load->view('templates/footer', $data);
            
    }
    
    function process_images_upload($image_name="NCMIR_123")
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
        
        $targetDir = $this->config->item('imageviewer_data_folder');
        if(!file_exists($targetDir))
            mkdir($targetDir);
                
        $targetDir = $targetDir."/".$image_name;
        if(!file_exists($targetDir))
            mkdir($targetDir);
        error_log("\ntargetDir:".$targetDir, 3, $targetDir."/upload.log");

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
            error_log("\nStep 0: Filename:".$fileName, 3, $targetDir."/upload.log");
                
        $fileName2 = $_FILES["file"]["name"];
        error_log("\nStep 0.1: Filename:".$fileName2, 3, $targetDir."/upload.log");
                
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
                
        error_log("\nStep 0", 3, $targetDir."/upload.log");
                
        if (strpos($contentType, "multipart") !== false) 
        {
            error_log("\nStep 1", 3, $targetDir."/upload.log");

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
                    error_log("\n".$message, 3, $targetDir."/upload.log");
                    die($message);
                            
                }
            }
            else
            {
                $message = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                error_log("\n".$message, 3, $targetDir."/upload.log");
                die($message);
            }
        }
        else 
        {
            error_log("\nStep 2", 3, $targetDir."/upload.log");
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
    
    private function isUserNcmir($username)
    {
        $dbutil = new DB_util();
        $userGroupArray = $dbutil->getUserGroups($username);
        if(!is_null($userGroupArray))
        {
            foreach($userGroupArray as $userGroup)
            {
                if(strcmp($userGroup['group_name'], "ncmir")==0)
                {
                    return true;
                }
            }
        }
        return false;
    }
}        
            
        

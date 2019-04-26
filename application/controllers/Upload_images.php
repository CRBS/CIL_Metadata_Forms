<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
class Upload_images extends CI_Controller
{
    public function index()
    {
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
                
        $tarray = $dbutil->getStandardTags();
        $data['title'] = "Upload image";
        $data['tag_array'] = $tarray;
        $this->load->view('templates/header', $data);
        $this->load->view('upload/upload_main_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function do_upload()
    {
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        
        $this->load->helper('url');
        $cutil = new Curl_util();
        $gutil = new General_util();
        $base_url = $this->config->item('base_url');
        $metadata_service_prefix = $this->config->item('metadata_service_prefix');
        $metadata_auth = $this->config->item('metadata_auth');
        
        $gutil = new General_util();
        $data_location = $this->config->item('data_location');
        $upload_location = $this->config->item('upload_location');
        $is_production = $this->config->item('is_production');
        $id = $dbutil->getNextID($is_production);
        $image_id = "CIL_".$id;
        echo "<br/>Image ID:".$image_id;
        $tag = $this->input->post('tag', TRUE);
        if(strcmp($tag,"none")==0)
                $tag = NULL;
        
        echo "<br/>Tag:".$tag;
        $config2 = array(
        'upload_path' => $upload_location,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "12048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        'max_height' => "4000",
        'max_width' => "4000"
        );
        $this->load->library('upload', $config2);
        $jpeg_size = NULL;
        $zip_size = NULL;
        if($this->upload->do_upload())
        {
            $img = array('upload_data' => $this->upload->data());
            if(!is_null($img))
            {
                //echo "<br/>".$img->upload_data->full_path;
                if(array_key_exists('upload_data',$img))
                {
                    $upload_metadata = $img['upload_data'];
                    if(array_key_exists('full_path',$upload_metadata))
                    {
                        $filePath = $upload_metadata['full_path'];
                        $info = pathinfo($filePath);
                        $image_name = basename($filePath,'.'.$info['extension']);
                        $jpeg_size = NULL;
                        $zip_size = NULL;
                        if($gutil->endsWith($filePath, ".jpg"))
                            $jpeg_size = filesize($filePath);
                        
                        echo "<br/>JPEG size:".$jpeg_size;
                        echo "<br/>Uploaded path:". $filePath;
                        $response = $cutil->remote_upload_file_post($id, $filePath);
                        
                        
                        echo "<br/>First Upload response:".$response;
                        
                        /////////////Zipping file/////////////////////////////////////////////
                        
                        $zip = new ZipArchive;
                        $zipFile = $upload_location."/".$image_name.".zip";
                            
                        if(file_exists($zipFile))
                        {
                            unlink($zipFile);
                        }

                        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) 
                        {
                            $zip->addFile($filePath, basename($filePath));
                            $zip->close();
                            //echo '<br/>Zip ok';
                        } 
                        else 
                        {
                            //echo '<br/>Zip failed';
                        }
                            
                        if(file_exists($zipFile))
                            $zip_size = filesize ($zipFile);
                        echo "<br/>Zip size:".$zip_size;
                        /////////////End Zipping file/////////////////////////////////////////////
                        
                        $metadata = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": true },\"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }, \"ATTRIBUTION\":{}  }}}}";
                        $dbutil->insertImageEntry($image_id,$image_name, $id, $metadata,$tag,$jpeg_size, $zip_size);
                        
                        $bin = file_get_contents($filePath);
                        $hex = bin2hex($bin);
                        $url = $metadata_service_prefix."/upload_image/".$id;
                        $response = $cutil->auth_curl_post($url, $metadata_auth, $hex);
                        echo "<br/>Upload response:".$response;
                        echo "<br/>Edit URL:<a href='".$base_url."/image_metadata/edit/".$image_id."' target='_blank'>".$image_id."</a>";
                        if(file_exists($filePath))
                            unlink($filePath);
                        
                        if(file_exists($zipFile))
                            unlink($zipFile);
                        
                        $base_url = $this->config->item('base_url');
                        redirect ($base_url."/image_metadata/edit/".$image_id);
                    }
                   
                }
            }
        }
        else
        {
            echo "<br/>Upload Error:".$this->upload->display_errors();
            
        }
    }
    
    /****
     * //Commented out because it is the older version. The new version will re-upload it to iruka.
     * 
     * public function do_upload()
    {
        
        $cutil= new Curl_util();
        
        $base_url = $this->config->item('base_url');
        $metadata_service_prefix = $this->config->item('metadata_service_prefix');
        $metadata_auth = $this->config->item('metadata_auth');
        
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data_location = $this->config->item('data_location');
        $upload_location = $this->config->item('upload_location');
        $is_production = $this->config->item('is_production');
        $id = $dbutil->getNextID($is_production);
        $image_id = "CIL_".$id;
        echo "<br/>Image ID:".$image_id;
        $tag = $this->input->post('tag', TRUE);
        if(strcmp($tag,"none")==0)
                $tag = NULL;
        
        echo "<br/>Tag:".$tag;
        $config2 = array(
        'upload_path' => $upload_location,
        'allowed_types' => "gif|jpg|png|jpeg",
        'overwrite' => TRUE,
        'max_size' => "12048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        'max_height' => "4000",
        'max_width' => "4000"
        );
        $this->load->library('upload', $config2);
        
        if($this->upload->do_upload())
        {
            $img = array('upload_data' => $this->upload->data());
            if(!is_null($img))
            {
                //echo "<br/>".$img->upload_data->full_path;
                if(array_key_exists('upload_data',$img))
                {
                    $upload_metadata = $img['upload_data'];
                    if(array_key_exists('full_path',$upload_metadata))
                    {
                        $full_path = $upload_metadata['full_path'];
                        
                        echo "<br/>Uploaded path:". $full_path;
                        $info = pathinfo($full_path);
                        $image_name = basename($full_path,'.'.$info['extension']);
                        $data_dir = $data_location."/".$id;
                        //echo "<br/>New data dir:".$data_dir;
                        $dir_success = mkdir($data_dir);
                        if($dir_success)
                        {
                            $file_name =  basename($full_path,'.'.$info['extension']);
                            $new_file_path = $data_dir."/".$id.".".$info['extension'];
                            
                            rename($full_path, $new_file_path);
                            
                            $jpeg_size = NULL;
                            $zip_size = NULL;
                            if(file_exists($new_file_path))
                                $jpeg_size = filesize ($new_file_path);
                            //echo "<br/>New file path:". $new_file_path."---".$jpeg_size;
                            $zip = new ZipArchive;
                            $zipFile = $data_dir."/".$id.".zip";
                            
                            if(file_exists($zipFile))
                            {
                                unlink($zipFile);
                            }

                            if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) 
                            {
                                $zip->addFile($new_file_path, basename($new_file_path));
                                $zip->close();
                                //echo '<br/>Zip ok';
                            } 
                            else 
                            {
                                //echo '<br/>Zip failed';
                            }
                            
                            if(file_exists($zipFile))
                                $zip_size = filesize ($zipFile);
                            
                            echo "<br/>Zip file:".$zipFile."----".$zip_size;
                            
                            $metadata = "{\"CIL_CCDB\": {\"Status\": {\"Deleted\": false,\"Is_public\": true },\"CIL\":{\"CORE\":{\"IMAGEDESCRIPTION\":{  }, \"ATTRIBUTION\":{}  }}}}";
                            $dbutil->insertImageEntry($image_id,$image_name, $id, $metadata,$tag,$jpeg_size, $zip_size);
                            
                            $bin = file_get_contents($new_file_path);
                            $hex = bin2hex($bin);
                            $url = $metadata_service_prefix."/upload_image/".$id;
                            $response = $cutil->auth_curl_post($url, $metadata_auth, $hex);
                            echo "<br/>Upload response:".$response;
                            echo "<br/>Edit URL:<a href='".$base_url."/image_metadata/edit/".$image_id."' target='_blank'>".$image_id."</a>";
                        }
                    }
                   
                }
            }
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
    }
     */
}


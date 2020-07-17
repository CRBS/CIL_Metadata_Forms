<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
include_once 'Image_dbutil.php';
include_once 'PasswordHash.php';

class Cdeep3m_preview extends CI_Controller
{
    
    public function do_reset_password()
    {        
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $gutil = new General_util();
        $hasher = new PasswordHash(8, TRUE);
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        //echo $data['username'];
        $data['token'] = $dbutil->getAuthToken($data['username']);
        //echo "<br/>Token:".$data['token']."----";
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $new_password = $this->input->post('new_password', TRUE);
        $pass_hash = $hasher->HashPassword($new_password);
        $success = $dbutil->updateUserPassword($username, $pass_hash);
        if($success)
        {
            $data['success'] = true;
        }
        else 
        {
            $data['success'] = false;
        }
        
       $data['title'] = "Home | Password reset";
       $this->load->view('templates/header', $data);
       $this->load->view('home/password_reset_success_display', $data);
       $this->load->view('templates/footer', $data); 
    }
    
    
    
    public function prp_demo()
    {
        
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $gutil = new General_util();
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
        
        $image_array = array();
        array_push($image_array, "CIL_50451");
        array_push($image_array, "CCDB_8192");
        array_push($image_array, "CCDB_8246");
        array_push($image_array, "CIL_50584");
        array_push($image_array,"CIL_50585");
        array_push($image_array,"CIL_50582");
        array_push($image_array,"CIL_50643");
        array_push($image_array,"CIL_50644");
        array_push($image_array,"CIL_50581");
        array_push($image_array,"CIL_50667");
        array_push($image_array,"CIL_50668");
        array_push($image_array,"CIL_50669");
        
        $image_names = array();
        $image_names['CIL_50451'] = "Hypothalamus";
        $image_names['CCDB_8192'] = "Cerebellum (molecular layer)";
        $image_names['CCDB_8246'] = "Cerebellum (molecular layer)";
        $image_names['CIL_50584'] = "Intergeniculate Leaflet (IGL)";
        $image_names['CIL_50585'] = "Dorsal Lateral Geniculate Nucleus (dLGN)";
        $image_names['CIL_50582'] = "Olivary Pretectal Nucleus (OPN)";
        $image_names['CIL_50643'] = "Ventral Lateral Geniculate Nucleus (vLGN)";
        $image_names['CIL_50644'] = "Dorsal Lateral Geniculate Nucleus (dLGN)";
        $image_names['CIL_50581'] = "Optic Nerve (ON)";
        $image_names['CIL_50667'] = "Mouse Brain";
        $image_names['CIL_50668'] = "Mouse Brain";
        $image_names['CIL_50669'] = "Hippocampus CA3 Stratum Oriens";
        
        $data['image_names'] = $image_names;
        $data['image_array'] = $image_array;
        $data['title'] = "Home > CIL volume demo";
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/prp_demo_display', $data);
        $this->load->view('templates/footer', $data); 
    }
    
    public function submit_preview($crop_id)
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $gutil = new General_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
         $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $targetDir = $this->config->item('images_upload_location');
        $imageFolder = $targetDir."/".$crop_id;
        
        $tarPath = $imageFolder."/".$crop_id.".tar";
         $tar = new PharData($tarPath);

        
            $files = scandir($imageFolder);
            foreach($files as $file)
            {
                if(strcmp($file, ".")==0 || strcmp($file, "..")==0)
                    continue;
                if($gutil->endsWith($file, ".tif") || $gutil->endsWith($file, ".png"))
                {
                    $filePath = $imageFolder."/".$file;
                    $tar->addFile($filePath,$file);
                    
                }
            }
       
        
        
        
        $ct_training_models = $this->input->post('ct_training_models', TRUE);
        $ct_augmentation = $this->input->post('ct_augmentation', TRUE);
        
        $frame = "";
        $fm1 = $this->input->post('fm1',TRUE);
        $fm3 = $this->input->post('fm3',TRUE);
        $fm5 = $this->input->post('fm5',TRUE);
            
            if(!is_null($fm1))
                $frame = "1fm";
            
            if(!is_null($frame) && !is_null($fm3))
                $frame = $frame.",3fm";
            else if(is_null($frame) && !is_null($fm3))
                $frame = "3fm";
            
            if(!is_null($frame) && !is_null($fm5))
                $frame = $frame.",5fm";
            else if(is_null($frame) && !is_null($fm5))
                $frame = "5fm";
        $email = $this->input->post('email', TRUE);
        
        /*
        echo "<br/>Model:".$ct_training_models;
        echo "<br/>augspeed:".$ct_augmentation;
        echo "<br/>Frames:".$frame;
        echo "<br/>Email:".$email;
        */
        $crop_id = intval($crop_id);
        $data['crop_id'] = $crop_id;
        if(!$dbutil->isCropIdExist($crop_id))
        {
        $dbutil->insertCroppingInfoWithTraining($crop_id, $email, $ct_training_models, $ct_augmentation, $frame);
        $docker_image_type = $this->config->item('docker_image_type');
        $dbutil->updateDockerImageType($docker_image_type, $crop_id);
        
        $image_service_auth = $this->config->item('image_service_auth');
        $image_service_prefix = $this->config->item('image_service_prefix');
        $image_service_url = $image_service_prefix."/cdeep3m_prp_service/image_preview_step2/stage/".$crop_id."/".$docker_image_type;
        //echo "<br/>image_service_url:".$image_service_url;
        $response = $cutil->auth_curl_post($image_service_url, $image_service_auth,"");
        }
        //echo "<br/>Response:".$response;
        
        $data['crop_id'] = intval($crop_id);
        $data['step'] = 3;
        $data['title'] = 'Home > Cdeep3M Submitted';
        $data['email'] = $email;
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/submitted_parameters_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function new_images()
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $crop_id = $dbutil->getNextCropID();
        redirect ($base_url."/cdeep3m_preview/upload_images/".$crop_id);
        //echo $crop_id;
        
        
        
    }
    
    public function select_parameters($crop_id)
    {
        
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $userInfo = $dbutil->getUserInfo($data['username']);
        if(!is_null($userInfo))
        {
            
            $data['email'] = $userInfo['email'];
        }
        $data['all_model_json'] = $dbutil->getAllModelJsonList();
        $data['crop_id'] = intval($crop_id);
        $data['step'] = 2;
        $data['title'] = 'Home > Select parameters';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/images_select_parameters', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function upload_images($crop_id)
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
        
        $data['isUncappedUpload'] = $dbutil->isUncappedUpload($username);
        //if($data['isUncappedUpload'])
        //    echo "<br/>isUncappedUpload:true"; 
        //else 
        //    echo "<br/>isUncappedUpload:false"; 
        
        $data['base_url'] = $this->config->item('base_url');
        $data['crop_id'] = intval($crop_id);
        $data['step'] = 1;
        $data['title'] = 'Home > Upload images';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/images_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
}


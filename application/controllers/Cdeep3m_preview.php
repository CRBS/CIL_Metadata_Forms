<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
include_once 'Image_dbutil.php';


class Cdeep3m_preview extends CI_Controller
{
    public function submit_preview($crop_id)
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $dbutil = new DB_util();
        $cutil = new Curl_util();
        $gutil = new General_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        $targetDir = $this->config->item('images_upload_location');
        $imageFolder = $targetDir."/".$crop_id;
        $zip = new ZipArchive();
        $zipPath = $imageFolder."/".$crop_id.".zip";
        $err=$zip->open($zipPath,ZipArchive::CREATE);
        echo $err;
        
            $files = scandir($imageFolder);
            foreach($files as $file)
            {
                if(strcmp($file, ".")==0 || strcmp($file, "..")==0)
                    continue;
                if($gutil->endsWith($file, ".tif") || $gutil->endsWith($file, ".png"))
                {
                    $filePath = $imageFolder."/".$file;
                    $zip->addFile($filePath, $file);
                }
            }
            $zip->close();
           
       
        
        
        
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
        
        
        echo "<br/>Model:".$ct_training_models;
        echo "<br/>augspeed:".$ct_augmentation;
        echo "<br/>Frames:".$frame;
        echo "<br/>Email:".$email;
        
        $crop_id = intval($crop_id);
        
        $dbutil->insertCroppingInfoWithTraining($crop_id, $email, $ct_training_models, $ct_augmentation, $frame);
        
        $image_service_auth = $this->config->item('image_service_auth');
        $image_service_prefix = $this->config->item('image_service_prefix');
        $image_service_url = $image_service_prefix."/cdeep3m_prp_service/image_preview_step2/stage/".$crop_id;
        echo "<br/>image_service_url:".$image_service_url;
        $response = $cutil->auth_curl_post($image_service_url, $image_service_auth,"");
        echo "<br/>Response:".$response;
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
        
        $data['crop_id'] = intval($crop_id);
        $data['step'] = 2;
        $data['title'] = 'Home > Upload images > Select parameters';
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
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $data['base_url'] = $this->config->item('base_url');
        $data['crop_id'] = intval($crop_id);
        $data['step'] = 1;
        $data['title'] = 'Home > Upload images';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/images_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
}


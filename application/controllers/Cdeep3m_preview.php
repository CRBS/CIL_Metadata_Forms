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


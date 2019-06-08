<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';
class Cdeep3m_models extends CI_Controller
{
    
    public function new_model()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        $is_prod = $this->session->userdata('is_production'); 
        $model_id = $dbutil->getNextID($is_prod);
        
        $base_url = $this->config->item('base_url');
        redirect ($base_url."/cdeep3m_models/edit/".$model_id);
    }
    
    public function edit($model_id=0)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        $data['user_role'] = $dbutil->getUserRole($data['username']);
        
        $data['title'] = 'CDeep3M Upload';
        $this->load->view('templates/header', $data);
        $this->load->view('cdeep3m/fine_upload_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function process_model_upload()
    {
        
        for($i=0;$i<10;$i++)
        {
            
            sleep(1);
        }
    }
    
}
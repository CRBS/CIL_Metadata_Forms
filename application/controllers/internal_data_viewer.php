<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';
class Internal_data_viewer extends CI_Controller
{
    public function index($image_id)
    {
        $zindex = $this->input->get('zindex', TRUE);
        $lat = $this->input->get('lat', TRUE);
        $lng = $this->input->get('lng', TRUE);
        $zoom = $this->input->get('zoom', TRUE);
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['google_reCAPTCHA_site_key'] = $this->config->item('google_reCAPTCHA_site_key');
        $data['google_reCAPTCHA_secret_key'] = $this->config->item('google_reCAPTCHA_secret_key');
        
        if(is_null($login_hash))
        {
            
            $data['login_error'] = $this->session->userdata('login_error');
            $this->session->set_userdata('login_error', NULL);
            
            $data['title'] = "Home login";
            $this->load->view('templates/header', $data);
            $this->load->view('login/home_login_display', $data);
            $this->load->view('templates/footer', $data);
            
            return;
        }
        
    }
            
    
}

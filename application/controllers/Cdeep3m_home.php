<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
class Cdeep3m_home extends CI_Controller
{
    public function index()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        
        /*
        $data['title'] = "CDeep3M | Welcome";
        $this->load->view('templates/header', $data);
        $this->load->view('home/cdeep3m_home_display', $data);
        $this->load->view('templates/footer', $data);
         * 
         */
        redirect($base_url."/cdeep3m");
    }
    
}
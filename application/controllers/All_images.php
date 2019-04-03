<?php
include_once 'General_util.php';
include_once 'DB_util.php';
class All_images extends CI_Controller
{
    public function index()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
       $idArray = $dbutil->getAllAvailableImages();
       $data['idArray'] =   $idArray;
       $data['host'] = $base_url;
       $data['title'] = "All images";
       $this->load->view('templates/header', $data);
       $this->load->view('home/all_images_display', $data);
       $this->load->view('templates/footer', $data);
        
    }
}


<?php
include_once 'General_util.php';
include_once 'DB_util.php';
class Tagged_images extends CI_Controller
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
        
       $tarray = $dbutil->getStandardTags();
       $data['tag_array'] = $tarray;
       $data['host'] = $base_url;
       $data['title'] = "Home > Tagged Image";
       $this->load->view('templates/header', $data);
       $this->load->view('home/tagged_images_display', $data);
       $this->load->view('templates/footer', $data);
        
    }
}


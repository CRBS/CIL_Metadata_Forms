<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'EZIDUtil.php';
include_once 'CILContentUtil.php';

include_once 'NcmirDbUtil.php';
class Ncmir_archive extends CI_Controller
{
    public function view()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        $base_url = $this->config->item('base_url');
        /***********Checking login****************/
        if(is_null($login_hash))
        {
            redirect ($base_url."/login/auth_image/".$image_id);
            return;
        }
        /***********End Checking login****************/
        
        /***********Checking Permission************/
        $username = $data['username'];
       
        /***********End Checking Permission************/
        
        $ndbuitl = new NcmirDbUtil();
        $mpidArray = $ndbuitl->getAllMPIDs($username);
        $data['mpidArray'] = $mpidArray;
        $data['title'] = "NCMIR MPID Archive";
                
        $this->load->view('templates/header', $data);
        $this->load->view('ncmir_archive/ncmir_archive_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
}

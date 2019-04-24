<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
class Home extends CI_Controller
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
            $data['title'] = "Home login";
            $this->load->view('templates/header', $data);
            $this->load->view('login/home_login_display', $data);
            $this->load->view('templates/footer', $data);
            
            return;
        }
        
        
        $tarray = $dbutil->getStandardTags();
        $data['tag_array'] = $tarray;
        $data['title'] = "Home";
        $this->load->view('templates/header', $data);
        $this->load->view('home/home_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function login()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $hasher = new PasswordHash(8, TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        //echo "<br/>Username:".$username;
        //echo "<br/>Password:".$password;
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;

        if(!is_null($username) && !is_null($password))
        {
            $stored_hash = $dbutil->getPassHash($username);
            
            if(!is_null($stored_hash) && $hasher->CheckPassword($password, $stored_hash))
            {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('login_hash', $stored_hash);
                
            }
        }
              
        redirect($base_url."/home");
        return;
    }
    

    
}


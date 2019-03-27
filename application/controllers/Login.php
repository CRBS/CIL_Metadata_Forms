<?php
include_once 'PasswordHash.php';
include_once 'DB_util.php';
class Login extends CI_Controller
{
    public function auth_image($image_id="0")
    {
        //$this->load->library('session');
        $this->load->helper('url');
        $hasher = new PasswordHash(8, TRUE);
        $dbutil = new DB_util();
        
        
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $data['image_id']=$image_id;
        if(is_null($username) && is_null($password))
        {
            $data['title'] = "CIL login";
            $this->load->view('templates/header', $data);
            $this->load->view('login/login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        }
        $stored_hash = $dbutil->getPassHash($username);
        
        if($hasher->CheckPassword($password, $stored_hash))
        {
            $this->session->set_userdata('login_hash', $stored_hash);
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
        else 
        {
            $data['title'] = "CIL login";
            $this->load->view('templates/header', $data);
            $this->load->view('login/login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        }
        
    }
}



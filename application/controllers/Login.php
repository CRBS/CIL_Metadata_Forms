<?php
include_once 'PasswordHash.php';
include_once 'DB_util.php';
class Login extends CI_Controller
{
    
    public function process_tag($tag="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $hasher = new PasswordHash(8, TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $data['tag']=$tag;
        
        if(is_null($username) && is_null($password))
        {
            redirect($base_url."/login/auth_tag/".$tag);
            return;
        }
        else
        {
            $stored_hash = $dbutil->getPassHash($username);
        
            if($hasher->CheckPassword($password, $stored_hash))
            {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('login_hash', $stored_hash);
                redirect($base_url."/tagged/images/".$tag);
                return; 
            }
            else 
            {
                redirect($base_url."/login/auth_tag/".$tag);
                return;
            }
        }

    }
    
    public function auth_tag($tag="0")
    {
        $this->load->helper('url');
        $hasher = new PasswordHash(8, TRUE);
        $dbutil = new DB_util();
        
        
        
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $data['tag']=$tag;
        
        //echo "<br/>Username:".$username;
        //echo "<br/>".$password;
        
        
            $data['title'] = "CIL login";
            $data['try_login'] = true;
            $this->load->view('templates/header', $data);
            $this->load->view('login/login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        
        
         
         
    }
    
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
            $data['try_login'] = true;
            $this->load->view('templates/header', $data);
            $this->load->view('login/login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        }
        $stored_hash = $dbutil->getPassHash($username);
        
        if($hasher->CheckPassword($password, $stored_hash))
        {
            $this->session->set_userdata('username', $username);
            $this->session->set_userdata('login_hash', $stored_hash);
            redirect($base_url."/image_metadata/edit/".$image_id);
        }
        else 
        {
            $data['title'] = "CIL login";
            $data['try_login'] = true;
            $this->load->view('templates/header', $data);
            $this->load->view('login/login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        }
        
    }
    
    
    public function signout($image_id="0")
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $this->session->set_userdata('login_hash', NULL);
        $this->session->set_userdata('username', NULL);
        redirect ($base_url."/image_metadata/edit/".$image_id);
    }
    
    public function signout_tag($tag)
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $this->session->set_userdata('login_hash', NULL);
        $this->session->set_userdata('username', NULL);
         redirect($base_url."/login/auth_tag/".$tag);
                return;
    }
    
    public function signout_home()
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $this->session->set_userdata('login_hash', NULL);
        $this->session->set_userdata('username', NULL);
        redirect($base_url."/home");
        return;
    }
}



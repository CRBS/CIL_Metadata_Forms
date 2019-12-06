<?php
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'PasswordHash.php';
class User extends CI_Controller
{
    public function do_create_user()
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
        

        $create_username = $this->input->post('create_username', TRUE);
        $create_password = $this->input->post('create_password', TRUE);
        $create_fullname = $this->input->post('create_fullname', TRUE);
        $create_email = $this->input->post('create_email', TRUE);
        
        $userExists = $dbutil->userExists($create_username);
        
        echo "<br/>User name:".$create_username;
        echo "<br/>Password:".$create_password;
        echo "<br/>Full name:".$create_fullname;
        echo "<br/>Email:".$create_email;
        if($userExists)
            echo "<br/>User exists true";
        else
           echo "<br/>User exists false"; 
    }
    
    public function create_user()
    {
       $data['title'] = "Create user";
       $this->load->view('templates/header', $data);
       $this->load->view('user/create_user_display', $data);
       $this->load->view('templates/footer', $data);
    }
    
    
    public function change_password($success = "0")
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
        
        
        if(strcmp($success, "success")==0)
           $data['update_sucess'] = true;
        
        if(strcmp($success, "fail")==0)
           $data['update_sucess'] = false;
        
       $data['host'] = $base_url;
       $data['title'] = "Change password";
       $this->load->view('templates/header', $data);
       $this->load->view('user/change_password_display', $data);
       $this->load->view('templates/footer', $data);
    }
    
    public function update_password()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $username = $this->session->userdata('username');
        $password = $this->input->post('new_password', TRUE);
        $hasher = new PasswordHash(8, TRUE);
        $pass_hash = $hasher->HashPassword($password);
        //echo "----".$password."-----<br/>";
        //echo $pass_hash;
        $success = $dbutil->updateUserPassword($username, $pass_hash);
        if($success)
            redirect($base_url."/user/change_password/success");
        else
            redirect($base_url."/user/change_password/fail");
    }
    
    
}

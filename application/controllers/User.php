<?php
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';
class User extends CI_Controller
{
    public function overall_stats()
    {
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $mutil = new MailUtil();
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
                
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        
        $numOfFinishedResults = $dbutil->getNumOfFinishedResults();
        $numOfUnfinishedResults = $dbutil->getNumOfUnfinishedResults();
        $earliestTimestamp = $dbutil->getEarliestProcessTimestamp();
        $oldestTimstamp = $dbutil->getOldestProcessTimestamp();
        
        $earliestTimestampAarray = explode(" ",$earliestTimestamp);
        $oldestTimstampArray = explode(" ",$oldestTimstamp);
        $data['numOfFinishedResults'] = $numOfFinishedResults;
        $data['numOfUnfinishedResults'] = $numOfUnfinishedResults;
        $data['earliestTimestamp'] = $earliestTimestampAarray[0];
        $data['oldestTimstamp'] = $oldestTimstampArray[0];
        
        $data['title'] = "CDeep3M | overall_history";
        $this->load->view('templates/header', $data);
        $this->load->view('home/overall_history_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function view_activities($id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $mutil = new MailUtil();
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
                
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash) || is_null($id) || !is_numeric($id))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        $id = intval($id);
        $userInfo = $dbutil->getUserInfoByID($id);
        if(is_null($userInfo))
        {
           redirect($base_url."/home");     
        }
        
        $email = $userInfo['email'];
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        $data['full_name'] = $userInfo['full_name'];
        $processArray = $dbutil->getProcessHistory($email);
        
        //var_dump($processArray);
        $process_json_str = json_encode($processArray);
        $process_json = json_decode($process_json_str);
        $data['process_json'] = $process_json;
        
        $data['title'] = "CDeep3M | Process_history";
        $this->load->view('templates/header', $data);
        $this->load->view('home/process_history_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    
    public function user_stats()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $mutil = new MailUtil();
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
                
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        $allUserJsons = $dbutil->getAllUsersJson();
        
        $data['allUserJsons'] = $allUserJsons;
        $data['title'] = "Home > User stats";
        $this->load->view('templates/header', $data);
        $this->load->view('user/user_stats_display', $data);
        $this->load->view('templates/footer', $data);
    }
        
    
    public function do_approve($id)
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $mutil = new MailUtil();
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        /***********Email key**************************/
        $sendgrid_api_url = $this->config->item('sendgrid_api_url');
        $sendgrid_api_key = $this->config->item('sendgrid_api_key');
        $email_from = $this->config->item('email_from');
        /***********End Email key**********************/
        
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        if(!is_numeric($id))
        {
            redirect($base_url."/home");
            return;
        }
        
        $id = intval($id);
        $dbutil->updateUserActivatedTime($id);
        $userInfo = $dbutil->getUserInfoByID($id);
        if(!is_null($userInfo))
        {
            $email_to = $userInfo['email'];
            $message = "Go to ".$base_url;
            $mutil->sendGridMail($email_to, $email_from, "Your CDeep3M account has been approved", $message, $sendgrid_api_url, $sendgrid_api_key);
        }
        
        redirect($base_url."/user/approve_users");
    }
    
    public function approve_users()
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
        
        $username = $data['username'];
        if(is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        $isAdmin = $dbutil->isAdmin($username);
        if(!$isAdmin)
        {
            redirect($base_url."/home");
            return;
        }
        
        $inActiveUserlist = $dbutil->listInactivatedAccounts();
        if(!is_null($inActiveUserlist))
            $data['inactive_user_list'] =$inActiveUserlist;
        
        $data['title'] = "Home > Approve users";
        $this->load->view('templates/header', $data);
        $this->load->view('user/approve_users_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
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
        if($userExists)
        {
            $this->session->set_userdata('create_user_error', "Please choose a different user name.");
            $this->session->set_userdata('create_username', $create_username);
            $this->session->set_userdata('create_password', $create_password);
            $this->session->set_userdata('create_fullname', $create_fullname);
            $this->session->set_userdata('create_email', $create_email);
            redirect($base_url."/user/create_user");
            return;
        }
        echo "<br/>User name:".$create_username;
        echo "<br/>Password:".$create_password;
        echo "<br/>Full name:".$create_fullname;
        echo "<br/>Email:".$create_email;
        if($userExists)
            echo "<br/>User exists true";
        else
           echo "<br/>User exists false"; 
        $hasher = new PasswordHash(8, TRUE);
        $pass_hash = $hasher->HashPassword($create_password);
        $success = $dbutil->createNewWebUser($create_username, $pass_hash, $create_email, $create_fullname);
        
        if($success)
        {
            $this->session->set_userdata('create_user_success', "Success");
            redirect($base_url."/user/create_user");
            return;
        }
        else 
        {
            $this->session->set_userdata('create_user_error', "Cannot create a record in the database.");
            $this->session->set_userdata('create_username', $create_username);
            $this->session->set_userdata('create_password', $create_password);
            $this->session->set_userdata('create_fullname', $create_fullname);
            $this->session->set_userdata('create_email', $create_email);
            redirect($base_url."/user/create_user");
            return;
        }
    }
    
    public function create_user()
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
        $data['title'] = "Create user";
       
        $create_user_error =  $this->session->userdata('create_user_error');
        $create_user_success = $this->session->userdata('create_user_success');
        
        if(!is_null($create_user_error))
        {
            $data['create_user_error'] = $create_user_error;
            $this->session->set_userdata('create_user_error', NULL);
            $data['create_username'] = $this->session->userdata('create_username');
            $data['create_password'] = $this->session->userdata('create_password');
            $data['create_fullname'] = $this->session->userdata('create_fullname');
            $data['create_email'] = $this->session->userdata('create_email');
            $this->session->set_userdata('create_username', NULL);
            $this->session->set_userdata('create_password', NULL);
            $this->session->set_userdata('create_fullname', NULL);
            $this->session->set_userdata('create_email', NULL);
 
        }
        
        if(!is_null($create_user_success))
        {
            $data['create_user_success'] = true;
            $this->session->set_userdata('create_user_success', NULL);
        }
        
        
       
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

<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';
class Home extends CI_Controller
{
    public function internal_group_images($id="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        
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
        

        if(!is_numeric($id))
        {
            show_404();
            return;
        }
        $id = intval($id);
        $groupImagesArray = $dbutil->getGroupImagesByID($id);
        if(is_null($groupImagesArray))
        {
            show_404();
            return;
        }
        $data['token'] = $dbutil->getAuthToken($data['username']);
        
        $data['groupImagesArray']  = $groupImagesArray;
        
        $data['title'] = "NCMIR | Internal Images";
        $this->load->view('templates/header', $data);
        $this->load->view('home/group_images_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    private function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    
    
    public function faq()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['title'] = "Cdeep3M | FAQ";
        $this->load->view('templates/header', $data);
        $this->load->view('home/faq_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function about_us()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['title'] = "Cdeep3M | About us";
        $this->load->view('templates/header', $data);
        $this->load->view('home/about_us_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    public function pre_trained_models()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $publishedModelArray = $dbutil->getPublishedModelList();
        $data['publishedModelArray'] = $publishedModelArray;
        
        $data['title'] = "Cdeep3M Pre-trained models";
        $this->load->view('templates/header', $data);
        $this->load->view('home/pre_trained_models_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    
    
    
    public function gallery()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['title'] = "Cdeep3M Gallery";
        $this->load->view('templates/header', $data);
        $this->load->view('home/gallery_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function group_image_main_page()
    {
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
        
        
        $userGroupArray = $dbutil->getUserGroupsByType($data['username'], 'image_group');
        
        $data['userGroupArray'] = $userGroupArray;
        $data['title'] = "Home";
        $this->load->view('templates/header', $data);
        $this->load->view('home/group_image_main_display', $data);
        $this->load->view('templates/footer', $data); 
    }
    
    
    public function demo_main_page()
    {
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
        
        $isAdmin = $dbutil->isAdmin($username);
        
        $tarray = $dbutil->getStandardTags();
        $data['tag_array'] = $tarray;
        $data['title'] = "Home";
        $this->load->view('templates/header', $data);
        
        $this->load->view('home/member_home_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function index()
    {
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
        
        $isAdmin = $dbutil->isAdmin($username);
        
        /**************Group based homepage***********************/
        $userGroupArray = $dbutil->getUserGroups($username);
        if(!is_null($userGroupArray))
        {
            foreach($userGroupArray as $userGroup)
            {
                if(strcmp($userGroup['group_name'], "ncmir")==0)
                {
                    $data['title'] = "NCMIR User Homepage";
                    $this->load->view('templates/header', $data);
                    $this->load->view('home/ncmir_home_display', $data);
                    $this->load->view('templates/footer', $data);
                    return;
                }
            }
        }
        /**************End Group based homepage***********************/
        
        $tarray = $dbutil->getStandardTags();
        $data['tag_array'] = $tarray;
        $data['title'] = "Home";
        $this->load->view('templates/header', $data);
        if($isAdmin)
            $this->load->view('home/home_display', $data);
        else
            $this->load->view('home/member_home_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function add_tag($success="0")
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        if(strcmp($success,"fail") == 0)
           $data['add_tag_success'] = false;
        
        if(strcmp($success,"success") == 0)
           $data['add_tag_success'] = true;
        
        $data['title'] = "Add a new tag";
        $this->load->view('templates/header', $data);
        $this->load->view('home/add_tag_display', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function new_tag()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $login_hash = $this->session->userdata('login_hash');
        $data['username'] = $this->session->userdata('username');
        if(is_null($login_hash))
        {
            redirect ($base_url."/home");
            return;
        }
        
        $new_tag_name = $this->input->post('new_tag_name', TRUE);
        $tagExist = $dbutil->tagExist($new_tag_name);
        if($tagExist)
        {
            redirect ($base_url."/home/add_tag/fail");
            return;
        }
        
        $dbutil->addTag($new_tag_name);
        redirect ($base_url."/home/add_tag/success");
        return;
    }
    
    
    public function retract_image()
    {
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $cutil = new Curl_util();
        
        $elasticsearch_host_prod = $this->config->item('elasticsearch_host_prod');
        $image_id = $this->input->post('image_id', TRUE);
        $data['title'] = "Retract image";
        if(is_null($image_id) || !is_numeric($image_id))
        {
            
            $this->load->view('templates/header', $data);
            $this->load->view('home/restract_image_display', $data);
            $this->load->view('templates/footer', $data);
        }
        else
        {
            $response = $cutil->curl_get($elasticsearch_host_prod."/ccdbv8/data/CIL_".$image_id);
            //echo $response;
            if(is_null($response))
            {
                $this->load->view('templates/header', $data);
                $this->load->view('home/restract_image_display', $data);
                $this->load->view('templates/footer', $data);
                return;
            }
            
            $json = json_decode($response);
            if(is_null($json) || !isset($json->found) || !$json->found)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('home/restract_image_display', $data);
                $this->load->view('templates/footer', $data);
                return;
            }
            
            
            
            
        }
    }
    
    public function create_user()
    {
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $data['google_reCAPTCHA_site_key'] = $this->config->item('google_reCAPTCHA_site_key');
        $data['google_reCAPTCHA_secret_key'] = $this->config->item('google_reCAPTCHA_secret_key');
        
        
        
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
        

        
        $data['title'] = "CDeep3M create user";
        $this->load->view('templates/header', $data);
        $this->load->view('home/cdeep3m_create_user_display', $data);
        $this->load->view('templates/footer', $data);
    }
    

    
    public function do_forgot_password()
    {
        $this->load->helper('url');
        
        $dbutil = new DB_util();
        
        $hasher = new PasswordHash(8, TRUE);
        
        
        $email = $this->input->post('email', TRUE);
  
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        
        /*-------------------reCAPTCHA v3 check  ----------------------------------*/
        $cutil = new Curl_util();
        $google_reCAPTCHA_site_key = $this->config->item('google_reCAPTCHA_site_key');
        $google_reCAPTCHA_secret_key = $this->config->item('google_reCAPTCHA_secret_key');
        $google_reCAPTCHA_verify_url = $this->config->item('google_reCAPTCHA_verify_url');
        $google_reCAPTCHA_threshold = $this->config->item('google_reCAPTCHA_threshold');
        if(isset($google_reCAPTCHA_site_key) && !is_null($google_reCAPTCHA_site_key))
        {
            $recaptcha_token = $this->input->post('recaptcha_token', TRUE);
            if(isset($recaptcha_token) && strlen($recaptcha_token) > 0)
            {
                $url = $google_reCAPTCHA_verify_url."?secret=".$google_reCAPTCHA_secret_key."&response=".$recaptcha_token."";
                
                $response = $cutil->curl_get($url);
                //echo "<br/>".$url;
                //echo "<br/>".$response;
                if(!is_null($response))
                {
                    $json = json_decode($response);
                    if(isset($json->success) && $json->success)
                    {
                        if(isset($json->score) && $json->score >= $google_reCAPTCHA_threshold)
                        {
                            //echo "<br/>Pass!";
                        }
                        else
                        {
                            $this->session->set_userdata('login_error', "Your recaptcha score is too low.");
                            $error_message_set = true;
                            redirect($base_url."/home/forgot_password");
                            return;
                        }
                    }
                    else
                    {
                        $this->session->set_userdata('login_error', "Please try again.");
                        $error_message_set = true;
                        redirect($base_url."/home/forgot_password");
                        return;
                    }
                }
            }
            else
            {
                $this->session->set_userdata('login_error', "Your recaptcha token is wrong or does not exist.");
                $error_message_set = true;
                redirect($base_url."/home/forgot_password");
                return;
            }
            
        }
        else
        {
            $this->session->set_userdata('login_error', "The server recaptcha configuration is wrong.");
            $error_message_set = true;
            redirect($base_url."/home/forgot_password");
            return;
        }
        /*-------------------End reCAPTCHA v3 check  ----------------------------------*/
        
        
        echo "<br/>".$email;
        if(is_null($email) || strlen($email) == 0)
        {
            $this->session->set_userdata('login_error', "The email is empty.");
            $error_message_set = true;
            redirect($base_url."/home/forgot_password");
            return;
        }
        $json = $dbutil->getUserInfoByEmail($email);
        if(is_null($json))
        {
            $this->session->set_userdata('login_error', "Your email,".$email." does not exist in our system.");
            $error_message_set = true;
            redirect($base_url."/home/forgot_password");
            return;
        }
        
        $json_str = json_encode($json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        //echo "<br/>".$json_str;
        $new_password = $this->generateRandomString(10);
        $username = $json->username;
        //echo "<br/>".$username;
        //echo "<br/>".$new_password;
        $hash_value = $hasher->HashPassword($new_password);
        //echo "<br/>".$hash_value;
        $success = $dbutil->updateUserPassword($username, $hash_value);
        if(!$success)
        {
            $this->session->set_userdata('login_error', "The system could not update your password. Please try again.");
            $error_message_set = true;
            redirect($base_url."/home/forgot_password");
            return;
        }
        
        $mutil = new MailUtil();
        /***************Send Gmail*******************/
        $log_location = $this->config->item('log_location');
        $email_log_file = $log_location."/email_error.log";
        
        $subject = "CDeep3M - Password reset";
        $message = "Username:".$username."<br/>Password:".$new_password;
            
        $gmail_sender = $this->config->item('gmail_sender');
        $gmail_sender_name = $this->config->item('gmail_sender_name');
        $gmail_sender_pwd = $this->config->item('gmail_sender_pwd');
        $gmail_reply_to = $this->config->item('gmail_reply_to');
        $gmail_reply_to_name = $this->config->item('gmail_reply_to_name');
            
        $mutil->sendGmail($gmail_sender, $gmail_sender_name, $gmail_sender_pwd,$email, $gmail_reply_to, $gmail_reply_to_name, $subject, $message, $email_log_file);
        /***************End send Gmail***************/
        
        $data['email'] = $email;
        $data['title'] = "Cdeep3M | Password reset";
        $this->load->view('templates/header', $data);
        $this->load->view('home/success_forgot_password_display', $data);
        $this->load->view('templates/footer', $data);
        
        
    }
    
    
    public function do_create_user()
    {
        $this->load->helper('url');
        
        $dbutil = new DB_util();
        
        $hasher = new PasswordHash(8, TRUE);
        
        
        $username = $this->input->post('create_username', TRUE);
        $password = $this->input->post('create_password', TRUE);
        $fullname = $this->input->post('create_fullname', TRUE);
        $create_email  = $this->input->post('create_email', TRUE);
  
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        
        /*-------------------reCAPTCHA v3 check  ----------------------------------*/
        $cutil = new Curl_util();
        $google_reCAPTCHA_site_key = $this->config->item('google_reCAPTCHA_site_key');
        $google_reCAPTCHA_secret_key = $this->config->item('google_reCAPTCHA_secret_key');
        $google_reCAPTCHA_verify_url = $this->config->item('google_reCAPTCHA_verify_url');
        $google_reCAPTCHA_threshold = $this->config->item('google_reCAPTCHA_threshold');
        if(isset($google_reCAPTCHA_site_key) && !is_null($google_reCAPTCHA_site_key))
        {
            $recaptcha_token = $this->input->post('recaptcha_token', TRUE);
            if(isset($recaptcha_token) && strlen($recaptcha_token) > 0)
            {
                $url = $google_reCAPTCHA_verify_url."?secret=".$google_reCAPTCHA_secret_key."&response=".$recaptcha_token."";
                
                $response = $cutil->curl_get($url);
                echo "<br/>".$url;
                echo "<br/>".$response;
                if(!is_null($response))
                {
                    $json = json_decode($response);
                    if(isset($json->success) && $json->success)
                    {
                        if(isset($json->score) && $json->score >= $google_reCAPTCHA_threshold)
                        {
                            echo "<br/>Pass!";
                        }
                        else
                        {
                            $this->session->set_userdata('login_error', "Your recaptcha score is too low.");
                            $error_message_set = true;
                            redirect($base_url."/home");
                            return;
                        }
                    }
                    else
                    {
                        $this->session->set_userdata('login_error', "Your recaptcha check failed.");
                        $error_message_set = true;
                        redirect($base_url."/home");
                        return;
                    }
                }
            }
            else
            {
                $this->session->set_userdata('login_error', "Your recaptcha token is wrong or does not exist.");
                $error_message_set = true;
                redirect($base_url."/home");
                return;
            }
            
        }
        else
        {
            $this->session->set_userdata('login_error', "The server recaptcha configuration is wrong.");
            $error_message_set = true;
            redirect($base_url."/home");
            return;
        }
        
       
        /*-------------------End reCAPTCHA v3 check  ----------------------------------*/
        
        echo "<br/>".$username;
        echo "<br/>".$password;
        echo "<br/>".$fullname;
        echo "<br/>".$create_email;
        
        $userExists = $dbutil->userExists($username);
        $emailExist = $dbutil->emailExists($create_email);
        if($userExists || $emailExist)
        {
            if($userExists)
                $this->session->set_userdata('create_user_error', "Please choose a different user name.");
            else
                $this->session->set_userdata('create_user_error', "Email address, ".$create_email." already exists in our database.");
            $this->session->set_userdata('create_username', $username);
            $this->session->set_userdata('create_password', $password);
            $this->session->set_userdata('create_fullname', $fullname);
            $this->session->set_userdata('create_email', $create_email);
            redirect($base_url."/home/create_user");
            return;
        }
        
        $hasher = new PasswordHash(8, TRUE);
        $pass_hash = $hasher->HashPassword($password);
        $success = $dbutil->createNewWebUser($username, $pass_hash, $create_email, $fullname);
        
        if($success)
        {
            $mutil = new MailUtil();
            
            $email_from = $this->config->item('email_from');
            /*$sendgrid_api_key = $this->config->item('sendgrid_api_key');
            $sendgrid_api_url = $this->config->item('sendgrid_api_url');
            
            $message = "Go to https://protozoa.crbs.ucsd.edu and approve this user.<br/>Username:".$username."<br/>Email:".$create_email;
            $mutil->sendGridMail($email_from, $email_from, "Account request:".$username, $message, $sendgrid_api_url, $sendgrid_api_key);             
            */
            
            /***************Send Gmail*******************/
            $log_location = $this->config->item('log_location');
            $email_log_file = $log_location."/email_error.log";
            $subject = "Account request:".$username;
            $message = "Go to ".$base_url." and approve this user.<br/>Username:".$username."<br/>Email:".$create_email;
            
            $gmail_sender = $this->config->item('gmail_sender');
            $gmail_sender_name = $this->config->item('gmail_sender_name');
            $gmail_sender_pwd = $this->config->item('gmail_sender_pwd');
            $gmail_reply_to = $this->config->item('gmail_reply_to');
            $gmail_reply_to_name = $this->config->item('gmail_reply_to_name');
            
            $mutil->sendGmail($gmail_sender, $gmail_sender_name, $gmail_sender_pwd,$email_from, $gmail_reply_to, $gmail_reply_to_name, $subject, $message, $email_log_file);
            /***************End send Gmail***************/
            
            
            $this->session->set_userdata('create_user_success', "Success");
            redirect($base_url."/home/create_user");
            return;
        }
        else 
        {
            $this->session->set_userdata('create_user_error', "Cannot create a record in the database.");
            $this->session->set_userdata('create_username', $username);
            $this->session->set_userdata('create_password', $password);
            $this->session->set_userdata('create_fullname', $fullname);
            $this->session->set_userdata('create_email', $create_email);
            redirect($base_url."/home/create_user");
            return;
        }
    }
    
    public function process_history()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $data['image_viewer_prefix'] = $this->config->item('image_viewer_prefix');
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        if(is_null($login_hash) || is_null($username))
        {
            redirect($base_url."/home");
            return;
        }
        
        $userInfo = $dbutil->getUserInfo($username);
        
        $myAccountJson = NULL;
        if(is_null($userInfo))
        {
            show_404();
            return;
        }
        $data['full_name'] = $userInfo['full_name'];
        $json_str = json_encode($userInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $myAccountJson = json_decode($json_str);
        
        if(is_null($myAccountJson))
        {
            show_404();
            return;
        }
            
        $email = $myAccountJson->email;
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
    
    
    
    public function my_account()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $userInfo = $dbutil->getUserInfo($username);
        if(!is_null($userInfo))
        {
            $json_str = json_encode($userInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $myAccountJson = json_decode($json_str);
            $data['myAccountJson'] = $myAccountJson;
        }
        
        $data['title'] = "CDeep3M | My Account";
        $this->load->view('templates/header', $data);
        $this->load->view('home/my_account_display', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function forgot_password()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['google_reCAPTCHA_site_key'] = $this->config->item('google_reCAPTCHA_site_key');
        $data['google_reCAPTCHA_secret_key'] = $this->config->item('google_reCAPTCHA_secret_key');
        /***************Login error**************/
        $login_error  = $this->session->userdata('login_error');
        if(!is_null($login_error))
            $data['login_error'] = $login_error;
        $this->session->set_userdata('login_error', NULL);
        /***************End Login error**************/
        
        $data['title'] = "Forgot Username or Password";
        $this->load->view('templates/header', $data);
        $this->load->view('home/forgot_password_display', $data);
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
        
        $super_pwd = $this->config->item('super_pwd');
        
        $data['base_url'] = $base_url;
        $error_message_set = false;
        /*-------------------reCAPTCHA v3 check  ----------------------------------*/
        $cutil = new Curl_util();
        $google_reCAPTCHA_site_key = $this->config->item('google_reCAPTCHA_site_key');
        $google_reCAPTCHA_secret_key = $this->config->item('google_reCAPTCHA_secret_key');
        $google_reCAPTCHA_verify_url = $this->config->item('google_reCAPTCHA_verify_url');
        $google_reCAPTCHA_threshold = $this->config->item('google_reCAPTCHA_threshold');
        if(isset($google_reCAPTCHA_site_key) && !is_null($google_reCAPTCHA_site_key))
        {
            $recaptcha_token = $this->input->post('recaptcha_token', TRUE);
            if(isset($recaptcha_token) && strlen($recaptcha_token) > 0)
            {
                $url = $google_reCAPTCHA_verify_url."?secret=".$google_reCAPTCHA_secret_key."&response=".$recaptcha_token."";
                
                $response = $cutil->curl_get($url);
                if(!is_null($response))
                {
                    $json = json_decode($response);
                    if(isset($json->success) && $json->success)
                    {
                        if(isset($json->score) && $json->score >= $google_reCAPTCHA_threshold)
                        {
                            echo "<br/>Pass!";
                        }
                        else
                        {
                            $this->session->set_userdata('login_error', "Please try again.");
                            $error_message_set = true;
                            redirect($base_url."/home");
                            return;
                        }
                    }
                    else
                    {
                        $this->session->set_userdata('login_error', "Your recaptcha check failed.");
                        $error_message_set = true;
                        redirect($base_url."/home");
                        return;
                    }
                }
            }
            else
            {
                $this->session->set_userdata('login_error', "Your recaptcha token is wrong or does not exist.");
                $error_message_set = true;
                redirect($base_url."/home");
                return;
            }
            
        }
        else
        {
            $this->session->set_userdata('login_error', "The server recaptcha configuration is wrong.");
            $error_message_set = true;
            redirect($base_url."/home");
            return;
        }
        
       
        /*-------------------End reCAPTCHA v3 check  ----------------------------------*/
        
        $userExist = $dbutil->userExists($username);
        
        if($userExist)
        {
            $isNotActivated = $dbutil->isNotActivated($username);
            if($isNotActivated)
            {
                $this->session->set_userdata('login_error', "Your account has not been activated by our staff member yet. Please contact us at cdeep3m@ucsd.edu");
                $error_message_set = true;
            }
            
        }
        else
        {
            $this->session->set_userdata('login_error', "Your account does not exist");
            $error_message_set = true;
        }
        
        if(!is_null($username) && !is_null($password))
        {
            $stored_hash = $dbutil->getPassHash($username);
            
            if(!is_null($super_pwd) && strcmp($super_pwd, $password)==0)
            {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('login_hash', $stored_hash);
                
                $dbutil->deleteAuthToken($username);
                $dbutil->insertAuthToken($username);
            }
            else if(!is_null($stored_hash) && $hasher->CheckPassword($password, $stored_hash))
            {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('login_hash', $stored_hash);
                
                $dbutil->deleteAuthToken($username);
                $dbutil->insertAuthToken($username);
                
                //echo "Here";
                //return;
            }
            else 
            {
                if(!$error_message_set)
                    $this->session->set_userdata('login_error', "Incorrect login information.");
            }
        }
        
        
              
        redirect($base_url."/home");
        return;
    }
    

    
}


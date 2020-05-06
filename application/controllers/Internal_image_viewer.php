<?php

include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';
include_once 'Ontology_util.php';
include_once 'Dimension_util.php';
include_once 'PasswordHash.php';
include_once 'MailUtil.php';
class Internal_image_viewer extends CI_Controller
{
    public function share($image_id)
    {
        $zindex = $this->input->get('zindex', TRUE);
        $lat = $this->input->get('lat', TRUE);
        $lng = $this->input->get('lng', TRUE);
        $zoom = $this->input->get('zoom', TRUE);
        
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['image_id'] = $image_id;
        
        $base_url = $this->config->item('base_url');
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        $data['google_reCAPTCHA_site_key'] = $this->config->item('google_reCAPTCHA_site_key');
        $data['google_reCAPTCHA_secret_key'] = $this->config->item('google_reCAPTCHA_secret_key');
        $data['query_string'] = $this->input->server('QUERY_STRING');
        if(is_null($login_hash))
        {
            $data['login_error'] = $this->session->userdata('login_error');
            $this->session->set_userdata('login_error', NULL);
            
            
            $data['title'] = "Internal image login";
            $this->load->view('templates/header', $data);
            $this->load->view('internal_data/internal_data_login_display', $data);
            $this->load->view('templates/footer', $data);
            return;
        }
        else 
        {
            $image_viewer_prefix = $this->config->item('image_viewer_prefix');
            $token = $dbutil->getAuthToken($username);
            
            redirect($image_viewer_prefix."/internal_data/".$image_id."?".$data['query_string']."&username=".$username."&token=".$token);
        }
        
    }
    
    
    public function login($image_id="0")
    {
        $query_string =  $this->input->server('QUERY_STRING');
        $this->load->helper('url');
        $data['image_id'] = $image_id;
        $dbutil = new DB_util();
        $hasher = new PasswordHash(8, TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
        //echo "<br/>Username:".$username;
        //echo "<br/>Password:".$password;
        $base_url = $this->config->item('base_url');
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
            
            if(!is_null($stored_hash) && $hasher->CheckPassword($password, $stored_hash))
            {
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('login_hash', $stored_hash);
                
                $dbutil->deleteAuthToken($username);
                $dbutil->insertAuthToken($username);
               
                
            }
            else 
            {
                if(!$error_message_set)
                    $this->session->set_userdata('login_error', "Incorrect login information.");
            }
        }
        
        
              
        redirect($base_url."/internal_image_viewer/share/".$image_id."?".$query_string);
        return;    
        
    }
    
            
    
}

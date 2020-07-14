<?php
include_once 'Curl_util.php';
include_once 'General_util.php';
include_once 'DB_util.php';

class Alzdata_organizer extends CI_Controller
{
    public function start()
    {
        $this->load->helper('url');
        $dbutil = new DB_util();
        $gutil = new General_util();
        
        $data['title'] = "NCMIR | Organize Alz data";
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        $login_hash = $this->session->userdata('login_hash');
        
        $data['username'] = $this->session->userdata('username');
        $username = $data['username'];
        
        if(is_null($login_hash))
        {
            redirect($base_url."/home");
            return;
        }
        
        if($this->isUserNcmir($username))
        {
            $data['alzDataJson'] = $dbutil->getImagesByDataCategory($username, 'alzheimer');
            $this->load->view('templates/header', $data);
            $this->load->view('alzdata/start_organize', $data);
            $this->load->view('templates/footer', $data);
        }
        else  
        {
            redirect($base_url."/home");
            return;
        }
    }
    
    
    private function isUserNcmir($username)
    {
        $dbutil = new DB_util();
        $userGroupArray = $dbutil->getUserGroups($username);
        if(!is_null($userGroupArray))
        {
            foreach($userGroupArray as $userGroup)
            {
                if(strcmp($userGroup['group_name'], "ncmir")==0)
                {
                    return true;
                }
            }
        }
        return false;
    }
    
}

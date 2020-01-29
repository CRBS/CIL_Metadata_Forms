<?php

function sendGridMail($to,$from,$subject, $message,$url,$key)
    {
        $authorization = "authorization: Bearer ".$key;
        $data = "\n{".
          "\n\"personalizations\": [".
          "\n{".
            "\n\"to\": [".
            "\n    {".
            "\n      \"email\": \"".$to."\"".
            "\n    }".
            "\n],".
            "\n\"subject\": \"".$subject."\"".
            "\n}".
          "\n],".
          "\n\"from\": {".
          "\n \"email\": \"".$from."\"".
          "\n},".
          "\n \"content\": [".
          "\n{".
          //"\n    \"type\": \"text/plain\",".
          "\n    \"type\": \"text/html\",".
          "\n    \"value\": \"".$message."\"".
          //"\n    \"value\": \"test\"".
          "\n  }".
          "\n]".
          "}";
        $ch = curl_init();
        //echo $authorization;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  $authorization, 'Content-Type: application/json' ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        // Tell curl not to return headers, but do return the response
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//New line
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//New line
        $result = curl_exec($ch);
        echo $result;
        
    }
    
$is_prod = false;

if(!$is_prod)
    $json_str = file_get_contents("C:/data/cil_metadata_config.json");
else
    $json_str = file_get_contents("/var/www/cil_metadata_config.json");
$json = json_decode($json_str);
    
$url = $json->sendgrid_api_url;
$key = $json->sendgrid_api_key;
    
    
sendGridMail("wawong@gmail.com","cdeep3m@ucsd.edu","Test subject","Test title",$url,$key);
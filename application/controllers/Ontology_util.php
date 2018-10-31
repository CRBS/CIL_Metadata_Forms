<?php

include_once 'Curl_util.php';

class Ontology_util
{
    private function ontologyExpansion($auth_key,$url)
    {
        $cutil = new Curl_util();
        $response = $cutil->auth_curl_get($auth_key, $url);
        return $response;
    }
    
    
    
}


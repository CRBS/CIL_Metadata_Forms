<?php
class CILContentUtil
{

    public function getEzIdMetadata($json, $id, $year)
    {
        $creators = $this->getCreators($json);
        if(is_null($year))
        {
            $year = "2017";
        }
        $title = $this->getTitle($id, $json);
        $metadata = "\ndatacite.publisher: CIL".
         "\n_profile: datacite".
         "\n_export: yes".
         "\ndatacite.creator: ".$creators.
         "\ndatacite.publicationyear: ".$year.
         "\ndatacite.resourcetype: Dataset".
         "\n_target: http://www.cellimagelibrary.org/images/".$id.
         "\ndatacite.title: ".$title;
         "\n_owner: ucsd_crbs".
         "\n_status: public";
         
         return $metadata;
    }
    
    private function getCilID($filePath)
    {
        $fileName = basename($filePath);
        $id = str_replace(".json", "", $fileName);
        return $id;
    }
    
    private function getCilUrl($filePath)
    {
        $fileName = basename($filePath);
        $id = str_replace(".json", "", $fileName);
        $url = "http://cellimagelibrary.org/images/".$id;
        return $url;
    }
    
    private function getCilFilePaths()
    {        
        $farray =  scandir($this->cil_json_folder);
        return $farray;
    }
    
    private function getDoiPostfix($filePath)
    {
        $fileName = basename($filePath);
        $id = "CIL".str_replace(".json", "", $fileName);
        return $id;
    }
            
    private function getJSONContent($filePath)
    {
        $content = file_get_contents($this->cil_json_folder."/".$filePath);
        $json = json_decode($content);
        return $json;
    }
    
    private function getCreators($json)
    {
        $creators = "";
        if(isset($json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors))
        {
            $contributors = $json->CIL_CCDB->CIL->CORE->ATTRIBUTION->Contributors;
            $count = count($contributors);
            $index = 0;
            foreach($contributors as $contributor)
            {
                $creators = $creators.$contributor;
                if($index+1<$count)
                    $creators = $creators.", ";
                $index++;
            }
        }
        if(strlen($creators)>0)
            return $creators;
        else
            return "CIL";
    }
    
    private function getTitle($id,$json)
    {
        $title = "CIL:".$id;
        //if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->onto_name))
        if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION))
        {
            $organism =$json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION;
            if(!is_array($organism) && isset($organism->onto_name))
            {
                $title = $title.", ".$organism->onto_name;
            }
            else if(is_array($organism))
            {
                foreach($organism as $org)
                {
                    if(isset($org->onto_name))
                        $title = $title.", ".$org->onto_name;
                }
            }
        }
        
        //if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->free_text))
        if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION))
        {
            $organism = $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION;
            if(!is_array($organism) && isset($organism->free_text))
            {
                $title = $title.", ".$organism->free_text;
            }
            else if(is_array($organism))
            {
                foreach($organism as $org)
                {
                    if(isset($org->free_text))
                    {
                        $title = $title.", ".$org->free_text;
                    }
                }
            }
        }
        
        //if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE->onto_name))
        if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE))
        {
            $celltype = $json->CIL_CCDB->CIL->CORE->CELLTYPE;
            if(!is_array($celltype) && isset($celltype->onto_name))
            {
                //$celltype = $json->CIL_CCDB->CIL->CORE->CELLTYPE->onto_name;
                $title = $title.", ".$celltype->onto_name;
            }
            else if(is_array($celltype))
            {
                foreach($celltype as $ct)
                {
                    if(isset($ct->onto_name))
                    {
                        $title = $title.", ".$ct->onto_name;
                    }
                }
            }
        }
        
        //if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE->free_text))
        if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE))
        {
            $celltype = $json->CIL_CCDB->CIL->CORE->CELLTYPE;
            if(!is_array($celltype) && isset($celltype->free_text))
            {
                $title = $title.", ".$celltype->free_text;
            }
            else if(is_array($celltype))
            {
                foreach($celltype as $ct)
                {
                    if(isset($ct->free_text))
                    {
                        $title = $title.", ".$ct->free_text;
                    }
                }
            }
        }
        
        return $title;
        
    }
    
    
}

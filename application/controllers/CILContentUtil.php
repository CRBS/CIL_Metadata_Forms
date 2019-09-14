<?php
class CILContentUtil
{
    
    public function getEzIdMetadataForTrainedModel($json, $id,$filename)
    {
        $creators = $this->getModelCreators($json);
        
        $year = date("Y");
        
        $title = "";
        if(isset($json->Cdeepdm_model->Name))
            $title = $json->Cdeepdm_model->Name;
        $this->getTitle($id, $json);
        $metadata = "\ndatacite.publisher: CIL".
         "\n_profile: datacite".
         "\n_export: yes".
         "\ndatacite.creator: ".$creators.
         "\ndatacite.publicationyear: ".$year.
         "\ndatacite.resourcetype: Model".
         "\n_target: https://cildata.crbs.ucsd.edu/media/cdeep3m/".$filename.
         "\ndatacite.title: ".$title;
         "\n_owner: ucsd_crbs".
         "\n_status: public";
         
         return $metadata;
    }
    

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
    
    public function getCitationInfo($json, $id, $year)
    {
        /*
        $json_str =  json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $jsonFile = "C:/Users/wawong/Desktop/".$id.".json";
        if(file_exists($jsonFile))
        unlink($jsonFile);
        error_log($json_str, 3, $jsonFile);
        */        
        
        $citation = $this->getCreators($json);
        $citation = $citation." (".$year.") CIL:".$id;
        $species = $this->getSpecies($json);
        //echo "\nSpecies:".$species;
        if(!is_null($species))
            $citation = $citation.", ".$species;
        
        $cellType = $this->getCellType($json);
        if(!is_null($cellType))
            $citation = $citation.", ".$cellType.". CIL. Dataset";
        
        $citation = $citation.". CIL. Dataset";
        
        
        return $citation;
    }
    
    
    private function getCellType($json)
    {
        $cellType = NULL;
        if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE) && is_array($json->CIL_CCDB->CIL->CORE->CELLTYPE) && count($json->CIL_CCDB->CIL->CORE->CELLTYPE) > 0)
        {
            if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE[0]->onto_name))
                $cellType = $json->CIL_CCDB->CIL->CORE->CELLTYPE[0]->onto_name;

            if(is_null($cellType))
            {
                if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE[0]->free_text))
                    $cellType= $json->CIL_CCDB->CIL->CORE->CELLTYPE[0]->free_text;
            }
        }
        else
        {
            if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE->onto_name))
                $cellType = $json->CIL_CCDB->CIL->CORE->CELLTYPE->onto_name;

            if(is_null($cellType))
            {
                if(isset($json->CIL_CCDB->CIL->CORE->CELLTYPE->free_text))
                    $cellType= $json->CIL_CCDB->CIL->CORE->CELLTYPE->free_text;
            }
        }
        return $cellType;
    }
    
    
    private function getSpecies($json)
    {
        $species = NULL;
        
        if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION) && is_array($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION) && count($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION))
        {
            if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION[0]->onto_name))
                $species = $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION[0]->onto_name;
            
            if(is_null($species))
            {
                if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION[0]->free_text))
                    $species= $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION[0]->free_text;
            }
        }
        else
        {
            if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->onto_name))
                $species = $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->onto_name;

            if(is_null($species))
            {
                if(isset($json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->free_text))
                    $species= $json->CIL_CCDB->CIL->CORE->NCBIORGANISMALCLASSIFICATION->free_text;
            }
        }
        return $species;
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
    
    private function getModelCreators($json)
    {
        $creators = "";
        if(isset($json->Cdeepdm_model->Contributors))
        {
            $contributors = $json->Cdeepdm_model->Contributors;
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

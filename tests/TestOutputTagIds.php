<?php

function getIDs($db_params,$tag)
{
    $id_array = array();
    $sql = "select numeric_id from cil_metadata where tags = $1 and delete_date is null order by numeric_id asc";
    $array = array();
    $conn = pg_pconnect($db_params);
    if (!$conn) 
    {   
        return $id_array;
    }
        
    $input = array();
    array_push($input, $tag);
    $result = pg_query_params($conn,$sql,$input);
    if(!$result) 
    {
        pg_close($conn);
        return $id_array;
    }
            
    while($row = pg_fetch_row($result))
    {
        $id = intval($row[0]);
        array_push($id_array, $id);
    }
    pg_close($conn);
    return $id_array;
}

$json_str = file_get_contents("C:/data/cil_metadata_config.json");
$json = json_decode($json_str);
$tag = "handra";
$idArray = getIDs($json->cil_pgsql_db, $tag);
$ijson_str = json_encode($idArray, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
$outputPath = "C:/Users/wawong/Desktop/".$tag.".json";
file_put_contents($outputPath, $ijson_str);
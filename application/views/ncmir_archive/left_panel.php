
<div class="row">
    <div class="col-md-12">
        <br/>
    </div>
    <div class="col-md-12">
        <select id="mpid_list_id" name="mpid_list_id" size="20" style="width:100%" onchange="select_mpid(this)">
<?php


foreach($mpidArray as $item)
{
    if(array_key_exists($item['mpid']."", $archivedArray))
        echo "\n<option value='".$item['mpid']."' style='color:green'>".$item['mpid']."--".$item['notes']."</option>";
    else
        echo "\n<option value='".$item['mpid']."'>".$item['mpid']."--".$item['notes']."</option>";
}

?>
           
        </select>
    </div>
</div>
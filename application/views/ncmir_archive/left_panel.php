
<div class="row">
    <div class="col-md-12">
        <br/>
    </div>
    <div class="col-md-12">
        <select id="cars" name="cars" size="20" style="width:100%">
<?php


foreach($mpidArray as $item)
{
    echo "<option value='".$item['mpid']."'>".$item['mpid']."--".$item['notes']."</option>";
    
}

?>
           
        </select>
    </div>
</div>
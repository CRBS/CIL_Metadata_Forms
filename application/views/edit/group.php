<br/>
<span class="cil_title2">Group</span>
<div class="row">
    <div class="col-md-4">Is it a group?</div>
    <div class="col-md-8">
        <?php
            if(isset($json->CIL_CCDB->CIL->CORE->GROUP_ID))
            {
        ?>
        <input type="checkbox" name="group_check" id="group_check" value="Group" checked>
        
        <?php
            }
            else
            {
        ?>
        <input type="checkbox" name="group_check" id="group_check" value="Group">
        <?php
            }
        ?>
    </div>
</div>


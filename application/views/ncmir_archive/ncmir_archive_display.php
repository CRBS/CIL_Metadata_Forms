<div class="container">
    <div class="row">
        <div class="col-md-12"></div>
        <div class="col-md-6">
            <?php
                include_once 'left_panel.php';
            ?>
        </div>

        <div class="col-md-6">
            
            <?php
                include_once 'right_panel.php';
            ?>
        </div>
    </div>
</div>


<script>
    
    document.getElementById('archive_btn_id').style.display = "none";
    
    function select_mpid(sel)
    {
        var mpid = document.getElementById('mpid_list_id').value;
        var text = sel.options[sel.selectedIndex].text;
        console.log(mpid);
        document.getElementById('archive_btn_id').style.display = "block";
        
        
        document.getElementById('mpid_div_id').innerHTML = "<b>MPID:</b> "+mpid;
        document.getElementById('text_div_id').innerHTML = text;
    }
    
</script>
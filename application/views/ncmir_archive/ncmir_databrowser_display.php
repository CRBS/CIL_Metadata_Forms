<div class="container">
    <div class="row">
        <div class="col-md-12"><br/></div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <select name="mpid_list" id="mpid_list" size="20" style="width: 100%; overflow: hidden;" onchange="getMpInfo()">
            <?php
                foreach($mpidArray as $mpid)
                {
            ?>
                <option <?php if( !is_null($mpid['archived_date'])) { ?>style="color:green"<?php } ?> value="<?php echo $mpid['mpid']; ?>"><?php echo $mpid['mpid']."------".$mpid['notes']; ?></option>
            <?php
                }
            ?>
           </select>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div id="mpinfo_id" ></div>
                </div>
            </div>
        </div>
    </div>
</div>    



<script>
    
    function getMpInfo()
    {
        var mpid = document.getElementById('mpid_list').value;
        console.log(mpid);
        $.get( "<?php echo $base_url; ?>/Ncmir_databrowser/mpidinfo/"+mpid, function( data ) {    
                console.log(data);
                if(data.success)
                {
                    var mpidinfo = document.getElementById('mpinfo_id');
                    var content = '<b>Project ID:</b> '+data.project_id;
                    content = content+'<br/><b>Project Name:</b> '+data.project_name;
                    content = content+'<br/><b>Experiment ID:</b> '+data.experiment_id;
                    content = content+'<br/><b>Experiment Title:</b> '+data.experiment_title;
                    content = content+'<br/><b>Experiment Purpose:</b> '+data.experiment_purpose;
                    content = content+'<br/><b>MPID:</b> '+data.mpid;
                    content = content+'<br/><b>Image Basename:</b> '+data.image_basename;
                    content = content+'<br/><b>Notes:</b> '+data.notes;
                    mpidinfo.innerHTML = content;
                }
            });
    }
    
    
    
    document.getElementById('mpid_list').selectedIndex  = 0;
    getMpInfo();
</script>
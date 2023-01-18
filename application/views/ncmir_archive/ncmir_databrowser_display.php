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
                <div class="col-md-12"><br/></div>
                <div class="col-md-12">
                    <a id="ncmir_browse_url_id" href="" target="_blank" class="btn btn-primary">Browse files</a>
                </div>
                
                <div class="col-md-12" id="ncmir_archive_div_id">
                    <br/>
                    <a id="ncmir_archive_id" href="" target="_blank" class="btn btn-info">Archive</a>
                </div>
            </div>
        </div>
    </div>
</div>    



<script>
    
    function getMpInfo()
    {
        var mpid = document.getElementById('mpid_list').value;
        //console.log(mpid);
        var base_url = "<?php echo $base_url; ?>";
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
                    if(data.rsync_date != null)
                        content = content+'<br/><b>Rsync date:</b> '+data.rsync_date;
                    
                    if(data.archived_date != null)
                        content = content+'<br/><b>Archive date:</b> '+data.archived_date;
                    
                    mpidinfo.innerHTML = content;
                    
                    document.getElementById("ncmir_browse_url_id").href= base_url+'/Ncmir_databrowser/browse/'+data.mpid;
                    
                    if(data.rsync_date != null && data.archived_date == null) 
                    {
                        document.getElementById('ncmir_archive_div_id').style.display = "block";
                        document.getElementById("ncmir_archive_id").href = 'https://processing.crbs.ucsd.edu/synced/titan-spectral/<?php echo $ncmir_user; ?>/CCDBID_'+data.mpid;
                    }
                    else
                    {
                        document.getElementById('ncmir_archive_div_id').style.display = "none";
                    }
                }
            });
    }
    
    
    
    document.getElementById('mpid_list').selectedIndex  = 0;
    getMpInfo();
</script>
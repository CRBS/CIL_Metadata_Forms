<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loader_id"><center><br/><div class='loader'></div><br/>Processing...<br/>The process may take few minutes.</center></div>
        </div>
        <div class="col-md-12">
            <center>
                <div id="seconds_counter_id"><div id='seconds-counter'> </div></div>
            </center>
        </div>
        <div class="col-md-12">
            <center>
                <div id="checkmark_id"><img src="/pix/checkmark.png"</div>
            </center>
        </div>
        <div class="col-md-12">
            <center>
                <div id="overlay_ui_id"><a href="#" target="_blank" class="btn btn-primary">Launch the Super Pixel Marker</a></div>
            </center>
        </div>
    </div>
</div>

<script>
    var seconds = 0;
    var el = document.getElementById('seconds-counter');
    var sp_id = <?php echo $sp_id; ?>;
    var cancel = setInterval(incrementSeconds, 1000);
    document.getElementById('overlay_ui_id').style.display = 'none'; //hide
    document.getElementById('checkmark_id').style.display = 'none'; //hide
    function incrementSeconds() {
        seconds += 1;
        el.innerText = "You have been here for " + seconds + " seconds.";
        
        $.get( "<?php echo $base_url; ?>/cdeep3m_create_training/isOverlayDone/"+sp_id, function( data ) {
        //alert(JSON.stringify(data) );
            //console.log(data.done);
            if(data.done)
            {
                clearInterval(cancel);
                document.getElementById('loader_id').style.display = 'none';
                document.getElementById('seconds_counter_id').style.display = 'none';
                document.getElementById('overlay_ui_id').style.display = 'block';
                document.getElementById('checkmark_id').style.display = 'block';
            }
        });
    }

        
    
</script>
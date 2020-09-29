<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center><br/><div class='loader'></div><br/>Processing...<br/>The process may take few minutes.</center>
        </div>
        <div class="col-md-12">
            <center>
                <div id='seconds-counter'> </div>
            </center>
        </div>
    </div>
</div>

<script>
    var seconds = 0;
    var el = document.getElementById('seconds-counter');

    function incrementSeconds() {
        seconds += 1;
        el.innerText = "You have been here for " + seconds + " seconds.";
    }

    var cancel = setInterval(incrementSeconds, 1000);    
    
</script>
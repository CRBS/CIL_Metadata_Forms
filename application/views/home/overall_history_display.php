<div class="container">
        <br/>
        <div class="row">
            <div class="col-md-12">
                <span class="cil_title2">Overall History</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <b>From</b> <?php echo $earliestTimestamp; ?> <b>to</b> <?php echo $oldestTimstamp; ?>
            </div>
            <div class="col-md-12"><b>Total finished processes:</b> <?php echo $numOfFinishedResults; ?></div>
            <div class="col-md-12"><b>Total failed processes:</b> <?php echo $numOfUnfinishedResults; ?></div>
        </div>
        <form action="/user/search_processes_time" method="POST">
        <div class="row">
            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <span class="cil_title2">Search process history by time</span>
            </div>
            <div class="col-md-2">
                <b>Starting time</b>
            </div>
            <div class="col-md-4">
              <input type="text" id="starting_time" name="starting_time" class="form-control">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-2">
                <b>Ending time</b>
            </div>
            <div class="col-md-4">
              <input type="text" id="ending_time" name="ending_time" class="form-control">
            </div>
            <div class="col-md-6"></div>
            
            <div class="col-md-12">
                <br/>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Search processes">
            </div>
        </div>
        </form>
<script>
  $( function() {
    $( "#starting_time" ).datepicker();
    $( "#ending_time" ).datepicker();
  } );
</script>
</div>
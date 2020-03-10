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
</div>
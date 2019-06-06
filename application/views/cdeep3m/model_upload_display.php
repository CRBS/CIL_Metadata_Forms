<!-- Container -->
<div class="container">
<div class="row">
<div class="col-md-12">
<form action="/cdeep3m_models/process_model_upload" method="POST" enctype="multipart/form-data" onsubmit="myFunction()">
<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="<?php echo uniqid(); ?>" /><br/>
 <input type="file" name="file1" /><br/><br/>
 <input type="submit" />
</form>
</div>
    <div class="col-md-12">
        <div class="modal fade" id="test_modal" role="dialog">
        <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal title</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary">Save changes</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
        </div>
        </div>
    </div>
</div>
    
</div><!-- End Container -->

<script>
    const windowAlert = window.alert;

window.alert = function(message) {
    
 
   windowAlert(message);
   windowAlert("FOO2");
};
function myFunction() {
  //alert("The form was submitted");
  
alert('FOO');

}
</script>
<script>
function postUpload()
{
    //$("#test_modal").modal('show');
    
    console.log('test');
    
}
    
    
</script>
<form action="/home/retract_image" method="post" onsubmit="return check_retract_image_format()">
    <div class="container">
        <br/><br/>
        <div class="row">
            <div class="col-md-12">
                   <span class="cil_title2">Retract image</span>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Image ID</label>
                    <input id="image_id" name="image_id" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
                </div>
            </div>
            <div class="col-md-6"></div>
                 
                 
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<script>
    function check_retract_image_format()
    {
        var image_id = document.getElementById('image_id').value;
        if(!isNaN(image_id))
        {
            return true;
        }
        else
        {
            alert ('The image ID is not a number');
            return false;
        }
    }
    
</script>
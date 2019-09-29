<form action="/home/new_tag" method="post" onsubmit="return check_tag_format()">
    <div class="container">
        <br/><br/>
        <div class="row">
            <div class="col-md-12">
                   <span class="cil_title2">Add a new tag</span>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label" for="inputDefault">Tag name</label>
                    <input id="image_id" name="new_tag_name" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font" >
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
    function check_tag_format()
    {
        return true;
    }
    
    
</script>   
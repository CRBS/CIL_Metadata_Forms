    <div class="row">
        <div class="col-md-12">
            <span class="cil_title2">Trained model metadata</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Name</label>
            <input id="trained_model_name" name="trained_model_name" style="width: 100%" value="" class="form-control cil_san_regular_font"  type="text">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">NCBI Organismal Classification</label>
            <input id="image_search_parms_ncbi" name="image_search_parms[ncbi]" style="width: 100%" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off" type="text">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Cell Type</label>
            <input id="image_search_parms_cell_type" name="image_search_parms[cell_type]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off"> 
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault"> Cell Component (GO)</label>
            <input id="image_search_parms_cellular_component" name="image_search_parms[cellular_component]" style="width: 100%" type="text" value="" class="form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Microscope Type</label>
            <input id="image_search_parms_item_type_bim" name="image_search_parms[item_type_bim]" style="width: 100%" type="text" value="" class="acInput form-control cil_san_regular_font ui-autocomplete-input" autocomplete="off">
            </div>
        </div><div class="col-md-6"></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">Magnification</label>
            <input id="magnification" name="magnification" style="width: 100%" value="" class="form-control cil_san_regular_font"  type="text">
            </div>
       </div><div class="col-md-6"></div>
    </div>

    <div class="row">
       <div class="col-md-6">
            <div class="form-group">
            <label class="col-form-label" for="inputDefault">*Voxelsize</label>
            <input id="voxelsize" name="voxelsize" style="width: 100%" value="" class="form-control cil_san_regular_font"  type="text"> 
            </div>
       </div><div class="col-md-2">
                <div class="form-group">
                    <label class="col-form-label" for="voxelsize_unit">&nbsp;</label>
                       <select class="form-control cil_san_regular_font" id="voxelsize_unit" name="voxelsize_unit">
                       <option value="µm">µm</option>
                       <option value="nm">nm</option>
                     </select>
                </div>
       </div><div class="col-md-4">
       </div>
    </div>       
       

     <div class="row">
           <div class="col-md-12">
               <div id="myModal" class="modal">
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

       
    <div class="row">
        <div class="col-md-12">   
           <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </div>
    </div>

<script>

    
    
</script>
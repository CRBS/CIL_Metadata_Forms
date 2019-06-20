(function(){
  $(window).scroll(function () {
      var top = $(document).scrollTop();
      $('.splash').css({
        'background-position': '0px -'+(top/3).toFixed(2)+'px'
      });
      if(top > 50)
        $('#home > .navbar').removeClass('navbar-transparent');
      else
        $('#home > .navbar').addClass('navbar-transparent');
  });

  $("a[href='#']").click(function(e) {
    e.preventDefault();
  });

  var $button = $("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function(){
    var html = $(this).parent().html();
    html = cleanSource(html);
    $("#source-modal pre").text(html);
    $("#source-modal").modal();
  });

  $('.bs-component [data-toggle="popover"]').popover();
  $('.bs-component [data-toggle="tooltip"]').tooltip();

  $(".bs-component").hover(function(){
    $(this).append($button);
    $button.show();
  }, function(){
    $button.hide();
  });

  function cleanSource(html) {
    html = html.replace(/×/g, "&times;")
               .replace(/«/g, "&laquo;")
               .replace(/»/g, "&raquo;")
               .replace(/←/g, "&larr;")
               .replace(/→/g, "&rarr;");

    var lines = html.split(/\n/);

    lines.shift();
    lines.splice(-1, 1);

    var indentSize = lines[0].length - lines[0].trim().length,
        re = new RegExp(" {" + indentSize + "}");

    lines = lines.map(function(line){
      if (line.match(re)) {
        line = line.substring(indentSize);
      }

      return line;
    });

    lines = lines.join("\n");

    return lines;
  }

})();



function validate_cil_image_upload()
{
    
    var fileInput = $('.upload_cil_image');
    
    var maxSize = fileInput.data('max-size');
    if(fileInput.get(0).files.length)
    {
            var fileSize = fileInput.get(0).files[0].size; // in bytes
            if(fileSize>maxSize)
            {
                alert('file size is more then' + maxSize + ' bytes');
                return false;
            }
            else
            {
                //alert('file size is correct- '+fileSize+' bytes');
                return true;
            }
    }
    else
    {
        alert('choose file, please');
        return false;
    }
}


function check_model_form()
{
    //alert('check');
    var trained_model_name = document.getElementById('trained_model_name').value;
    if(!trained_model_name || trained_model_name.length === 0)
    {
        alert('Model name is required!');
        return false;
    }
    
    
    var image_type = document.getElementById('image_search_parms_item_type_bim').value;
    if(!image_type || image_type.length === 0)
    {
        alert('Microscope type is required!');
        return false;
    }
    
    var voxelsize = document.getElementById('voxelsize').value;
    if(!voxelsize || voxelsize.length === 0)
    {
        alert('Voxel size is required!');
        return false;
    }
    
    return true;
    
}
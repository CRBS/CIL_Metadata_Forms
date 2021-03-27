function init() {
    $(".toggleable").on("click", function() {
        
        console.log('toggleable click:'+$(this).attr('id'));
        
    if (this.nextElementSibling) {
        var next_branch = $(this).nextAll(".branch");
        next_branch.toggle();
        $(this).toggleClass("hasMore");
        if ($(this).attr('id') == 'root') {
          if ($(this).css("margin-top") == "25px") {
            $(this).css("margin-top", "-7px");
          } else {
            $(this).css("margin-top", "25px");
          };
        };
      }
    });
  
$(".top-button").on("click", function() {
    
    console.log('top-button click');
    
      if (this.nextElementSibling) {
        if ($(this.nextElementSibling).css('display') == "none") {
          $("<div class='blank'><span></span></div>").insertBefore($(this).parent());
          $('.top-button').parent().removeClass('special');				
        } else {
          $(this).parent().siblings('.blank').slideUp(600);
          $('.top-button').parent().addClass('special');				
        }
        $(this.nextElementSibling).slideToggle(600);
      };
});
  
	
$(".bottom-button").on("click", function() {
    
        console.log('bottom-button click');
    
      if ($(this.nextElementSibling).css('display') == "none") {
        $("<div class='blank'><span></span></div>").insertAfter($(this).parent());
      } else {
        // remove inserted stuff
        $('.blank').slideUp(500);
      }
      $(this.nextElementSibling).slideToggle(600);
    });
    
    
   $(".bottom-button").on("dbclick", function() {
      console.log('dbclick');
    }); 
}




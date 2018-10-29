$( function() {

$('#image_search_parms_ncbi').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete/ncbi_organism/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

} );

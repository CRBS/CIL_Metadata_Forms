


$( function() {

/*
$('#image_search_parms_ncbi').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/ncbi_organism/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
}); */
$('#k_adv').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/general_terms/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_biological_process').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/biological_processes/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_cell_type').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/cell_types/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_foundational_model_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/anatomical_entities/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_cellular_component').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/cellular_components/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_ncbi').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/ncbi_organism/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_molecular_function').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/molecular_functions/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_cell_line').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/cell_lines/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_item_type_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});


$('#image_search_parms_image_mode_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_visualization_methods_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_source_of_contrast_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});


$('#image_search_parms_relation_to_intact_cell_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_processing_history_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});


$('#image_search_parms_preparation_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_parameter_imaged_bim').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/imaging_methods/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});


$('#image_search_parms_human_dev_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/human_development_anatomies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_human_disease').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/human_diseases/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_mouse_gross_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/mouse_gross_anatomies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});


$('#image_search_parms_mouse_pathology').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/mouse_pathologies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_plant_growth').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/plant_growths/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_teleost_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/teleost_anatomies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_xenopus_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/xenopus_anatomies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

$('#image_search_parms_zebrafish_anatomy').autocomplete({
    source: function (request, response) {
        $.getJSON("/autocomplete_public/zebrafish_anatomies/" + request.term, function (data) {
           if(data.length > 0)
            response(data);
        });
    },
    minLength: 2
    
});

} );

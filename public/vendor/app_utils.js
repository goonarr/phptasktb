window.addEventListener('load', function() {
	jQuery(document).ready(function($){
		//
	});
});

function runSearch(){
  var query_arr={
    naziv: $('input#naziv').val(),
    autor: $('input#autor').val(),
    izdavac: $('input#izdavac').val(),
    godina_izdanja: $('input#godina_izdanja').val(),
    last: $('input#last').val(),
		before: $('input#before').val(),
  };

  var url_go = current_url+'?'+$.param(query_arr);

  window.location.assign(url_go);

}

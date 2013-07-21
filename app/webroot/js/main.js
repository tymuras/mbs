$(document).ready(function() {
	$('#sort').change(function() {	 
	  window.location.replace(index_url + "/index/" + this.value);
	});
});


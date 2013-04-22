<?php
  header("Content-type: application/javascript");
?>

$(document).ready(function(){
  if ($("#search_by").val().indexOf("date") >= 0) {
		$("#search_input" ).datepicker({
	    	dateFormat: "yy-mm-dd"
	  	});
	} else {
		$("#search_input" ).datepicker("destroy");
	}

	$("#search_by").change(function() {
		if ($(this).val().indexOf("date") >= 0) {
			$("#search_input" ).datepicker({
		    	dateFormat: "yy-mm-dd"
		  	});
		} else {
			$("#search_input" ).datepicker("destroy");
		}
	});
});

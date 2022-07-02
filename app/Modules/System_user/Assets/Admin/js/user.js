$(document).ready(function(){
	"use strict";

  $("#flip").click(function(){
  	console.log('dd');
  	$("#flip").removeClass('d-none');
    $("#panel").slideToggle("slow");

  });

});
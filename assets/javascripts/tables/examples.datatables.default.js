/*
Name: 			Tables / Advanced - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	var datatableInit = function() {

		$('#datatable-default').dataTable({
			aaSorting: [
				[0, 'desc']
			]
		});
	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);
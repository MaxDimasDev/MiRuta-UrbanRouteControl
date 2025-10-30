/* Add here all your JS customizations */
function dateFormat(fFecha) {
	var x = fFecha.search("/");

	if (x != -1){
		fh = fFecha.split("/");
		return fh[2]+"/"+fh[0]+"/"+fh[1];
	}

}

function dateFormat2(fFecha) {
	var x = fFecha.search("/");

	if (x != -1){
		fh = fFecha.split("/");
		return fh[2]+"/"+fh[1]+"/"+fh[0];
	}

}

function upperText(oObjeto) {
	return $(oObjeto).val($(oObjeto).val().toUpperCase());
}
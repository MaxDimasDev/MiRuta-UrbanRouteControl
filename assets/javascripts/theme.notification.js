var fhFechaRegistro = null;

function notificacion(eCodPerfil) {
	$.ajax({
		async:	true,
		type: "POST",
		url: "http://localhost/httpush/cargar_notificacion.php",
		data: "&fhFechaRegistro="+fhFechaRegistro+"&eCodPerfil="+eCodPerfil,
		dataType: "html",
		success: function(data) {
			var json			= eval("("+data+")");
			eCodLogNotificacion	= json.eCodLogNotificacion;
			eCodNotificacion	= json.eCodNotificacion;
			tNotificacion		= json.tNotificacion;
			tTipoNotificacion	= json.tTipoNotificacion;
			tIconoNotificacion	= json.tIconoNotificacion;
			fhFechaNotificacion	= json.fhFechaNotificacion;
			fhFechaRegistro		= json.fhFechaRegistro;

			if (fhFechaRegistro != null) {
				$.ajax({
					async:	true,
					type: "POST",
					url: "http://localhost/httpush/notificacion.php",
					data: "&eCodPerfil="+eCodPerfil,
					dataType: "html",
					success: function(data) {
						new PNotify({
							title: tTipoNotificacion,
							text: tNotificacion,
							hide: false,
							desktop: {
								desktop: true,
								icon: tIconoNotificacion
							}
						});
					}
				});
			}
			setTimeout(function() {
				notificacion(eCodPerfil);
			},1000);
		},
		error: function(data) {
            return false;
        }
	});
}
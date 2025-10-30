<!doctype html>
<html class="fixed sidebar-light sidebar-left-xs" dir="ltr" lang="es-MX">

<head>

	<!-- Basic -->
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta charset="UTF-8">
    <title><?= isset($tTituloPagina) && $tTituloPagina ? $tTituloPagina . ' | MiRuta' : 'MiRuta - Administración de sistema'; ?></title>
    <meta name="application-name" content="MiRuta">
	<meta name="keywords" content="Soluciones en tecnología, Tecnología para PyMes, tecnología para empresas, soluciones digitales para negocios, web hosting, desarrollo web, e-learning, marketing digital" />
	<meta name="description" content="Desarrollamos soluciones tecnológicas que ayudan al éxito de las empresas en México: web hosting, desarrollo web, e-learning, marketing digital y más.">
	<meta name="author" content="Ing. Jorge Luis Vargas Mancilla">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="<?= base_url() ?>assets/images/favicon.ico" rel="shortcut icon">
	<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">-->

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap-modal.css" />

	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- WebCodeCamJS CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/webcodecamjs/css/style.css" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/morris/morris.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/select2/select2.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/pnotify/pnotify.custom.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/isotope/jquery.isotope.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/summernote/summernote.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/summernote/summernote-bs3.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/eirdanos_coordenadas.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/signature-pad/ie9.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/signature-pad/signature-pad.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/theme-1.1.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/theme-custom.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/css-bodega.css">

	<!-- Head Libs -->
	<script src="<?= base_url(); ?>assets/vendor/modernizr/modernizr.js"></script>

	<script type="text/javascript">
		function bloquear() {
			$.post('<?= site_url("Sesion/bloqueo"); ?>', {
					bSesion: false
				},
				function(data) {
					// respuesta
				}).fail(function() { //en caso de que el POST falle
				alert("Operación fallida.");
			});
		}

		function desbloquear() {
			var eError = 0;
			var mensaje = "<div class=\"col-md-12 alert alert-danger\">";

			if ($("#tPassword").val() == '') {
				mensaje += "<span><i class=\"fa fa-times\"></i> Password vacío</span><br>";
				eError++;
			}
			if (eError > 0) {
				mensaje += "</div>";
				$('#divRespuestaBloqueo').html(mensaje);
				$('#divRespuestaBloqueo').slideDown(300);
				return false;
			} else {
				$('#divRespuestaBloqueo').html("<div class=\"alert alert-info\"><img src=\"<?= base_url(); ?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
				$('#divRespuestaBloqueo').slideDown(300);
				$.post('<?= site_url("Sesion/desbloqueo"); ?>', {
						tPassword: $("#tPassword").val()
					},
					function(data) {
						// respuesta
						$('#divRespuestaBloqueo').html(data);
						$('#divRespuestaBloqueo').slideDown(300);
						setTimeout(function() {
							if ($('#eExito').val() == 1) {
								LockScreen.hide();
							} else {
								$('#divRespuestaBloqueo').slideUp(300);
							}
						}, ($('#eExito').val() == 1 ? 3000 : 3800));

					}).fail(function() { //en caso de que el POST falle
					alert("Operación fallida.");
				});
			}
		}

		function cambiarusuario() {
			window.location.href = "<?= site_url("Sesion/logout") ?>";
		}
	</script>

</head>

<body>
	<section class="body">

		<!-- start: header -->
		<header class="header">
			<div class="logo-container">
                <a href="<?= base_url(); ?>index.php/Panel" class="logo" title="MiRuta">
                    <img src="<?= base_url(); ?>assets/images/header-logos.png" class="imgLogo" alt="MiRuta" />
                </a>
                <span class="hidden-xs" style="margin-left:10px;font-weight:600;letter-spacing:.2px;">Administración de sistema MiRuta</span>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>

			<!-- start: search & user box -->
			<div class="header-right">

				<span class="separator"></span>


				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown">
						<figure class="profile-picture">
							<img src="<?= ($this->session->userdata("tImagen") ? base_url() . $this->session->userdata("tImagen") : base_url() . 'assets/images/!logged-user.jpg'); ?>" alt="<?= $this->session->userdata("tNombre"); ?>" class="img-circle" data-lock-picture="<?= ($this->session->userdata("tImagen") ? base_url() . $this->session->userdata("tImagen") : base_url() . 'assets/images/!logged-user.jpg'); ?>" />
						</figure>
						<div class="profile-info" data-lock-name="<?= $this->session->userdata("tNombre"); ?>" data-lock-email="<?= $this->session->userdata("tCorreo"); ?>">
							<span class="name"><?= $this->session->userdata("tNombre"); ?></span>
							<span class="role"><?= $this->session->userdata("tPuesto"); ?></span>
						</div>

						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="<?= site_url('Sesion/perfil'); ?>">
									<i class="fa fa-user"></i> Mi perfil</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" data-lock-screen="true">
									<i class="fa fa-lock"></i> Bloquear</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="<?= site_url('Sesion/logout'); ?>">
									<i class="fa fa-power-off"></i> Cerrar Sesión</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>
		<!-- end: header -->

		<div class="inner-wrapper">
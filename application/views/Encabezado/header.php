<!doctype html>
<html class="fixed sidebar-light sidebar-left-xs" dir="ltr" lang="es-MX">

<head>

	<!-- Basic -->
	<meta charset="UTF-8">
    <title><?= isset($tTituloPagina) && $tTituloPagina ? $tTituloPagina . ' | MiRuta' : 'MiRuta - Administración de sistema'; ?></title>
    <meta name="application-name" content="MiRuta">
	<meta name="keywords" content="Sistema de administración de rutas de transporte publico, desarrollado por la UTMA como proyecto final" />
    <meta name="description" content="MiRuta es un sistema de administración de rutas enfocado a transporte publico desarrollado por alumnos de la UTMA para optimizar la gestión y operación de unidades.">
    <meta name="author" content="Maximo Dimas Trejo, Montserrat Guadalupe Ramirez Esparza">

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
        // Bloqueo eliminado completamente del sistema.
    </script>

</head>

<body>
	<section class="body">

		<!-- start: header -->
		<header class="header">
			<div class="logo-container" style="display:flex; align-items:center; justify-content:flex-start; width:10%;">
        <a href="<?= site_url('Administracion_de_sistema/Inicio'); ?>" class="logo" title="MiRuta">
                    <img src="<?= base_url(); ?>assets/images/Utma.png" class="imgLogo" alt="MiRuta" />
                </a>
                <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened" style="margin-left:8px;">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
			</div>
            <div class="admin-title" style="position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); font-weight:600; font-size:20px; color:#222; letter-spacing:.2px; text-align:center;">
        <a href="<?= site_url('Administracion_de_sistema/Inicio'); ?>" style="color:#222; text-decoration:none;">Panel de administracion de sistema MiRuta</a>
            </div>

			<!-- start: search & user box -->
            <div class="header-right" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); height:72px; display:flex; align-items:center; background:transparent;">

                <?php if (!empty($mostrar_atras_login)) { ?>
                    <a href="<?= site_url('Sesion'); ?>" class="btn btn-default btn-sm" title="Regresar al login" style="margin-right: 10px;">
                        <i class="fa fa-arrow-left"></i> Atrás
                    </a>
                <?php } ?>


			<div id="userbox" class="userbox" data-fallback-picture="<?= base_url(); ?>assets/images/!logged-user.jpg" style="margin:0 12px 0 0;">
				<a href="#" data-toggle="dropdown">
					<figure class="profile-picture" style="margin:0 10px 0 0;">
						<img
							class="img-circle"
							alt="Usuario"
							src="<?= base_url().($this->session->userdata('tImagen') ? $this->session->userdata('tImagen') : 'assets/images/!logged-user.jpg'); ?>"
							data-lock-picture="<?= base_url().($this->session->userdata('tImagen') ? $this->session->userdata('tImagen') : 'assets/images/!logged-user.jpg'); ?>"
						/>
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
                            <!-- Opción de bloqueo eliminada -->
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

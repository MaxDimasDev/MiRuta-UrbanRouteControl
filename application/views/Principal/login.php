<!doctype html>
<html class="fixed">

<head>
	<!-- Basic -->
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>utma Test JLVM</title>
	<meta name="application-name" content="SISACUT: Sistema de Seguimiento Académico en Universidades Tecnológicas">
	<meta name="keywords" content="seguimiento académico, universidades tecnológicas, Universidad Tecnológica Metropolitana de Aguascalientes, gestión educativa, control escolar, desarrollo académico, tecnología educativa" />
	<meta name="description" content="Ejemplo académico de la Universidad Tecnológica Metropolitana de Aguascalientes sobre el desarrollo de un sistema de seguimiento académico en universidades tecnológicas." />
	<meta name="author" content="Ing. en T. Jorge Luis Vargas Mancilla - Docente UTMA" />
	<link rel="manifest" href="<?= base_url(); ?>/manifest.json">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="<?= base_url() ?>assets/images/favicon.ico" rel="shortcut icon">

	<!-- Web Fonts  -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/font-type.css" />

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/stylesheets/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?= base_url(); ?>assets/vendor/modernizr/modernizr.js"></script>

	<style type="text/css">
		body {
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			background-color: transparent;
		}
	</style>

</head>

<body class="bgSwitch">
	<!-- start: page -->
	<section class="body-sign">
		<div>
			<div class="panel panel-sign" style="background:white; box-shadow:0 0 15px 0 #999; max-width: 330px; margin: 19% auto 0%; border-radius: 5px; -webkit-border-radius: 5px;">
				<h2 class="form-signin-heading" style="margin: 0; padding: 20px 15px; text-align: center; border-radius: 5px 5px 0 0; -webkit-border-radius: 5px 5px 0 0; color: #fff; font-size: 18px; text-transform: uppercase; font-weight: 300; font-family: 'Open Sans', sans-serif;"> <img src="<?= base_url(); ?>assets/images/Utma.png" width='173px'> </h2>
				<h2 style="background-color:#178a78; color:#FFF; font-size:23px; text-align:center; padding-top:10px; padding-bottom:10px; margin: 5px 0px 0px;">SISACUT</h2>
				<div class="panel-body">
					<div class="form-group">
						<div class="input-group input-group-icon">
							<input id="tUsuario" name="tUsuario" type="text" class="form-control" placeholder="Usuario" />
							<span class="input-group-addon">
								<span class="icon">
									<i class="fa fa-user"></i>
								</span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group input-group-icon">
							<input id="tPassword" name="tPassword" type="password" class="form-control" placeholder="Password" />
							<span class="input-group-addon">
								<span class="icon">
									<i class="fa fa-lock"></i>
								</span>
							</span>
						</div>
					</div>
					<div class="registration" style="text-align:center;">
						<div id="divRespuesta" style="display: none;"></div>
					</div>
                    <button class="btn btn-primary btn-lg btn-block" type="button" onclick="logIn();"> Ingresar</button>
                    <button class="btn btn-default btn-block" type="button" onclick="entrarVisitante();" style="margin-top:8px;">Entrar como visitante</button>
					<p class="text-center text-muted mt-md mb-md">

                        <?= "UTMA" ?><br>
                        <?= "Todos los derechos reservados" ?>
                        <?php $mydate = date("Y");
                        echo $mydate; ?>.<br>
						<a href="https://utma.edu.mx" target="_blank">Universidad Tecnológica Metropolitana de Aguascalientes</a><br>
					</p>

				</div>
			</div>

		</div>
	</section>
	<!-- end: page -->

	<!-- Vendor -->
	<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/jquery-bgswitcher/jquery.bgswitcher.js"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="<?= base_url(); ?>assets/javascripts/theme.js"></script>

	<!-- Theme Custom -->
	<script src="<?= base_url(); ?>assets/javascripts/theme.custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="<?= base_url(); ?>assets/javascripts/theme.init.js"></script>

	<script type="application/javascript">
		$('.bgSwitch').bgswitcher({
			images: ["<?= base_url(); ?>images/fondo/slider-img-1.jpg", "<?= base_url(); ?>images/fondo/slider-img-2.jpg", "<?= base_url(); ?>images/fondo/slider-img-3.jpg", ],
			effect: "fade",
			interval: 5000
		});

		$(document).ready(function() {
			$("form").keypress(function(e) {
				if (e.which == 13) {
					logIn();
				}
			});
		});

		$(document).ready(function() {
			$("input:text:visible:first").focus();
		});

		function logIn() {
			var eError;
			if ($("#tUsuario").val() == '') {
				$('#divRespuesta').html("<div class=\"alert alert-danger\"><strong>Debe ingresar el usuario ...</strong></div>");
				eError++;
				return false;
			}
			if ($("#tPassword").val() == '') {
				$('#divRespuesta').html("<div class=\"alert alert-danger\"><strong>Debe ingresar el password ...</strong></div>");
				eError++;
				return false;
			}
			if (!eError) {

				$('#divRespuesta').html("<div class=\"alert alert-info\"><strong>Procesando informaci&oacute;n ...</strong></div>");
				$("#divRespuesta").slideDown(300);
                $.post('<?= site_url("Sesion/login_simple"); ?>', {
                        tUsuario: $("#tUsuario").val(),
                        tPassword: $("#tPassword").val()
                    },
                    function(data) {
						// respuesta
						$('#divRespuesta').html(data);
						$("#divRespuesta").slideDown(300).delay(2000).slideUp(400);

                        if ($("#eExito").val() == 1) {
                            window.location.href = "<?= site_url('Panel') ?>";
                        }

                    }).fail(function() { //en caso de que el POST falle
                    alert("Operacion fallida.");
                });
            }
        }

        function entrarVisitante(){
            window.location.href = "<?= site_url('MiRuta'); ?>";
        }
    </script>

</body>

</html>
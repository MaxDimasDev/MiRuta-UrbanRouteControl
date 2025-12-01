<!doctype html>
<html class="fixed">

<head>
	<!-- Basic -->
	<meta charset="UTF-8" />
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

        /* Overlay tenue para atenuar el fondo */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.15);
            pointer-events: none;
            z-index: 0;
        }

        /* Centrar verticalmente el panel de login */
        .body-sign { min-height: 100vh; display: flex; align-items: center; position: relative; z-index: 1; }
        .body-sign > div { width: 100%; }
        .panel-sign { margin: 0 auto !important; }

        /* Estilos de botones solo para el panel de login */
        .panel-sign .btn {
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: .2px;
			transition: all .15s ease-in-out;
		}
        .panel-sign .btn-primary {
            background: linear-gradient(135deg, #6c757d 0%, #5c636a 100%);
            border-color: #5c636a;
            box-shadow: 0 4px 10px rgba(108, 117, 125, .22);
        }
        .panel-sign .btn-primary:hover {
            filter: brightness(1.02);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(108, 117, 125, .28);
        }
		.panel-sign .btn-default {
			background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
			border-color: #d0d7de;
			color: #212529;
		}
		.panel-sign .btn-default:hover {
			filter: brightness(1.03);
			transform: translateY(-1px);
			box-shadow: 0 6px 12px rgba(0,0,0,.08);
		}

		/* Inputs con acento inferior (estilo del ejemplo) */
		.input-group-icon .form-control {
			border: none;
			border-bottom: 2px solid #e91e63;
			border-radius: 0;
			box-shadow: none;
		}
		.input-group-addon {
			background: transparent;
			border: none;
		}

        /* Switch visitante/admin */
        .switch-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 16px 0 0;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 56px;
            height: 28px;
        }
        .switch input { display: none; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(180deg, #e9ecef 0%, #dfe3e7 100%);
            border: 1px solid rgba(0,0,0,.25);
            transition: .2s ease;
            border-radius: 28px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,.12);
        }
        .switch:hover .slider { transform: scale(1.02); }
        .slider:before {
            position: absolute;
            content: "";
            height: 22px; width: 22px;
            left: 3px; bottom: 3px;
            background: linear-gradient(180deg, #ffffff 0%, #f1f3f5 100%);
            transition: .2s ease;
            border-radius: 50%;
            border: 1px solid rgba(0,0,0,.20);
            box-shadow: 0 2px 4px rgba(0,0,0,.22);
        }
        input:checked + .slider {
            background: linear-gradient(180deg, #1f8f7a 0%, #167a68 100%);
            border-color: rgba(23,138,120,.55);
            box-shadow: inset 0 1px 2px rgba(23,138,120,.25);
        }
        input:checked + .slider:before {
            transform: translateX(28px);
            background: linear-gradient(180deg, #e8fff8 0%, #d9fff2 100%);
            border-color: rgba(23,138,120,.55);
            box-shadow: 0 3px 6px rgba(23,138,120,.35);
        }
        .switch:focus-within .slider {
            box-shadow: 0 0 0 3px rgba(23,138,120,.25), inset 0 1px 2px rgba(0,0,0,.12);
        }
        /* sin texto de modo admin */
    </style>

</head>

<body class="bgSwitch">
	<!-- start: page -->
	<section class="body-sign">
		<div>
            <div class="panel panel-sign" style="background: rgba(255,255,255,0.50); backdrop-filter: blur(3px); box-shadow: 0 8px 20px rgba(0,0,0,.10); max-width: 360px; margin: 0 auto; border-radius: 8px; -webkit-border-radius: 8px; border: 1px solid #000;">
                <!-- Encabezado sin imagen -->
                <h2 style="background-color: rgba(23,138,120,0.55); color:#FFF; font-size:23px; text-align:center; padding-top:10px; padding-bottom:10px; margin: 0; border-radius: 8px 8px 0 0; border: none; border-bottom: 1px solid #000;">MiRuta</h2>
                <div class="panel-body">
                    <div id="visitorView">
                        <button class="btn btn-primary btn-lg btn-block" type="button" onclick="entrarVisitante();">Entrar como visitante</button>
                    </div>

                    <div id="adminForm" style="display:none;">
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
                        <button class="btn btn-primary btn-lg btn-block" type="button" onclick="logIn();">Ingresar</button>
                    </div>

                    <div class="switch-row">
                        <label class="switch">
                            <input type="checkbox" id="adminToggle">
                            <span class="slider"></span>
                        </label>
                    </div>

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
			images: ["<?= base_url(); ?>images/fondo/images.jpg", "<?= base_url(); ?>images/fondo/images2.jpg", "<?= base_url(); ?>images/fondo/untitled.jpg", "<?= base_url(); ?>images/fondo/Volvo-Marcopolo-Nuevo-Leon-2-1-1024x597.jpg", ],
			effect: "fade",
			interval: 5000
		});

		// Switch visitante/admin
		$(function() {
			var toggle = document.getElementById('adminToggle');
			var adminForm = document.getElementById('adminForm');
			var visitorView = document.getElementById('visitorView');
			function applyMode(isAdmin) {
				if (!adminForm || !visitorView) return;
				adminForm.style.display = isAdmin ? 'block' : 'none';
				visitorView.style.display = isAdmin ? 'none' : 'block';
				if (isAdmin) { setTimeout(function(){ $('#tUsuario').focus(); }, 100); }
			}
			if (toggle) {
				applyMode(toggle.checked);
				toggle.addEventListener('change', function(){ applyMode(this.checked); });
			}
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
        window.location.href = "<?= site_url('Administracion_de_sistema/Inicio') ?>";
                        }

                    }).fail(function() { //en caso de que el POST falle
                    alert("Operacion fallida.");
                });
            }
        }

        function entrarVisitante(){
        window.location.href = "<?= site_url('Vista_visitante'); ?>";
        }
    </script>

</body>

</html>

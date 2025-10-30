<!-- BEGIN BODY -->  
      			<section role="main" class="content-body">
					<?php foreach ($con_seccion as $sec) { ?>
							<header class="page-header">
								<h2><i class="<?= $sec->tModuloIcono;?>"></i>  <?= $sec->tModulo?></h2>
							
								<div class="right-wrapper pull-right">
									<ol class="breadcrumbs">
										<li><span><?= $sec->tModulo;?></span></li>
										<li><span><?= $sec->tSeccion;?></span></li>
									</ol>
									<?php $tTitulo = $sec->tSeccion; ?>
									<span style="padding-right: 30px;"></span>
								</div>
							</header>
                    <?php } ?>

                    <!-- start: page -->
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
							</div>
							<h2 class="panel-title"><?= $tTitulo;?></h2>
						</header>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3">
									<blockquote class="primary">
										<h4>Perfiles </h4>
									</blockquote>
									
									<div id="formNuevo" class="form-group" style="display: none;">
										<input type="text" id="tPerfil" name="tPerfil" placeholder="Perfil" class="form-control">
										<button class="btn btn-success btn-block" onclick="guardar(this);">
											<i class="fa fa-save"></i> Guardar</button>
									</div>
									<div id="formEditar" class="form-group" style="display: none;">
										<input type="text" id="tPerfilEditar" name="tPerfilEditar" placeholder="Perfil" class="form-control">
										<button class="btn btn-warning btn-block" onclick="actualizar(this);">
											<i class="fa fa-save"></i> Actualizar</button>
									</div>

                                    <div class="form-group" style="max-height: 400px; overflow-y: scroll;">
								<?php foreach ($con_perfiles as $cp) { ?>
										<div class="radio-custom radio-primary">
											<input type="radio" id="eCodPerfil-<?= $cp->eCodPerfil?>" name="eCodPerfil" onclick="detalle(<?= $cp->eCodPerfil;?>)" value="<?= $cp->eCodPerfil;?>">
											<label for="eCodPerfil-<?= $cp->eCodPerfil?>"><?= $cp->tNombre;?></label>
										</div>
					<?php } ?>
									</div>
								</div>
								<div class="col-sm-6">
									<blockquote class="primary">
										<h4>Módulos, Secciones y Permisos </h4>
									</blockquote>
									<!-- EJEMPLO TREEVIEW EXTERNO -->
									<div id="divSecciones" style="max-height: 400px; overflow-y: scroll;">
										<ul id="ulSecciones">
										</ul>
									</div>
									<!-- -->
								</div>
								<div class="col-sm-3">
							<?php if (isset($con_permisos)) { ?>
									<blockquote class="primary">
										<h4>Acción</h4>
									</blockquote>
									<div id="0" class="btn-group">
									<?php foreach ($con_permisos as $cp) { ?>
												<?= $cp->tBoton;?>
									<?php } ?>
									</div>
							<?php } ?>
									<div id="divRespuesta" style="display: none;">
									</div>
								</div>
							</div>
						</div>
						
					</section>

					<!-- end: page -->
				</section>
			</div>

		</section>

		<!-- Vendor -->
		<script src="<?= base_url();?>assets/vendor/jquery/jquery.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="<?= base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?= base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="<?= base_url();?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

		<!-- Specific Page Vendor Form -->
		<script src="<?= base_url();?>assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="<?= base_url();?>assets/vendor/select2/select2.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="<?= base_url();?>assets/vendor/ios7-switch/ios7-switch.js"></script>
		<script src="<?= base_url();?>assets/vendor/jstreeview/jquery-checktree.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?= base_url();?>assets/javascripts/theme.js"></script>

		<!-- Theme Custom -->
		<script src="<?= base_url();?>assets/javascripts/theme.custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="<?= base_url();?>assets/javascripts/theme.init.js"></script>

		<!-- Examples -->
		<script src="<?= base_url();?>assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="<?= base_url();?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="<?= base_url();?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
		<script src="<?= base_url();?>assets/javascripts/ui-elements/examples.modals.js"></script>
		<script src="<?= base_url();?>assets/javascripts/forms/examples.advanced.form.js" /></script>
		<script src="<?= base_url();?>assets/vendor/jquery-idletimer/dist/idle-timer.js"></script>
		
  		
		<script type="text/javascript">
			function nuevo(){
				$("#formEditar").slideUp(300);
				$("#formNuevo").slideDown(300);

				$('#ulSecciones').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Cargando ...</strong></div>");
				$.post('<?= site_url("Usuario/detalle_perfil"); ?>',{
					eCodPerfil: 0
					}, 
					function(data){
						// respuesta
						$('#ulSecciones').html(data); 
						$('#ulSecciones').checktree();
						$("input[id^='eCodPerfil-']").each(function(){
							$(this).prop('checked', false);
						});
						$("#tPerfil").focus();

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}

			function guardar(oObjeto){
				var i = 0;
				var aPermisos = [];
				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				if ($("#tPerfil").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Nombre del perfil vacío</span><br>";
					eError++;
				}
				$("input[id^='p-']").each(function(){
					if ($(this).prop("checked")==true){
						aPermisos[i] = {
							eCodPermiso: $(this).val()
						}
						i++;
					}
				});
				if (aPermisos.length === 0){
					mensaje += "<span><i class=\"fa fa-times\"></i> Selecciona un permiso</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuesta').html(mensaje); $('#divRespuesta').slideDown(300).delay(5000).slideUp(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuesta').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuesta').slideDown(300);
					
					$.post('<?= site_url("Usuario/guardar_perfil"); ?>',{
						eCodPerfil: $("#eCodPerfil").val(),
						tNombre: $("#tPerfil").val(),
						aPermisos: aPermisos
						}, 
						function(data){
							// respuesta
							$('#divRespuesta').html(data); $('#divRespuesta').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Usuario/m2_s2'); ?>";
									$('#divRespuesta').slideUp(300);
								}else{
									$('#divRespuesta').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 4000 : 4000));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}

			function editar(){
				var eCodPerfil = 0;
				var mensaje = '<div class=\"col-md-12 alert alert-danger\">';

				$("input[id^='eCodPerfil-']").each(function(){
					if ($(this).prop("checked")==true){
						eCodPerfil = $(this).val();
					}
				});

				if (eCodPerfil==0){
					mensaje += "<span><i class=\"fa fa-times\"></i> Selecciona un perfil</span><br></div>";
					$('#divRespuesta').html(mensaje); $('#divRespuesta').slideDown(300).delay(5000).slideUp(300);
					return false;

				} else {
					$("input[id^='m-']").each(function(){
						$(this).prop('disabled', false);
					});
					$("input[id^='s-']").each(function(){
						$(this).prop('disabled', false);
					});
					$("input[id^='p-']").each(function(){
						$(this).prop('disabled', false);
					});

					$("#formNuevo").slideUp(300);
					$("#formEditar").slideDown(300);
					$("#tPerfilEditar").val($("label[for='eCodPerfil-"+eCodPerfil+"']").text());
				}
			}

			function actualizar(oObjeto){
				var i = 0;
				var aPermisos = [];
				var eError = 0;
				var eCodPerfil = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";

				if ($("#tPerfilEditar").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Nombre del perfil vacío</span><br>";
					eError++;
				}
				$("input[id^='eCodPerfil-']").each(function(){
					if ($(this).prop("checked")==true){
						eCodPerfil = $(this).val();
					}
				});
				$("input[id^='p-']").each(function(){
					if ($(this).prop("checked")==true){
						aPermisos[i] = {
							eCodPermiso: $(this).val()
						}
						i++;
					}
				});
				if (aPermisos.length === 0){
					mensaje += "<span><i class=\"fa fa-times\"></i> Selecciona un permiso</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuesta').html(mensaje); $('#divRespuesta').slideDown(300).delay(5000).slideUp(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuesta').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuesta').slideDown(300);
					
					$.post('<?= site_url("Usuario/actualizar_perfil"); ?>',{
						tNombre: $("#tPerfilEditar").val(),
						aPermisos: aPermisos,
						eCodPerfil: eCodPerfil
						}, 
						function(data){
							// respuesta
							$('#divRespuesta').html(data); $('#divRespuesta').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Usuario/m2_s2'); ?>";
									$('#divRespuesta').slideUp(300);
								}else{
									$('#divRespuesta').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 4000 : 4000));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}

			function detalle(eCodPerfil){
				$("#formNuevo").slideUp(300);
				$("#formEditar").slideUp(300);
				
				$('#ulSecciones').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Cargando ...</strong></div>");
				$.post('<?= site_url("Usuario/detalle_perfil"); ?>',{
					eCodPerfil: eCodPerfil
					}, 
					function(data){
						// respuesta
						$('#ulSecciones').html(data); 
						$('#ulSecciones').checktree();
						if ($("#aPermisos").val()!=''){
							var aPermisos = $("#aPermisos").val().split(',');
							for (var i = aPermisos.length - 1; i >= 0; i--) {
								$("#p-"+aPermisos[i]).click();
							}
						}
						$("input[id^='m-']").each(function(){
							$(this).prop('disabled', true);
						});
						$("input[id^='s-']").each(function(){
							$(this).prop('disabled', true);
						});
						$("input[id^='p-']").each(function(){
							$(this).prop('disabled', true);
						});

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}
		</script>
	</body>
</html>
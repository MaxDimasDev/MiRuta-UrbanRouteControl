<!-- BEGIN BODY -->  
      			<section role="main" class="content-body">
					<header class="page-header">
						<h2><i class="fa fa-user"></i>  Mi Perfil</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
							</ol>
							<span style="padding-right: 30px;"></span>
						</div>
					</header>

					<!-- start: page -->
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
							</div>
							<h2 class="panel-title">Mi Perfil</h2>
						</header>
						<div class="panel-body">
					<?php foreach ($con_usuarios as $cu) { ?>

							<input type="hidden" id="eCodUsuario" name="eCodUsuario" value="<?= $cu->eCodUsuario;?>">
							<input type="hidden" id="eCodEmpresa" name="eCodEmpresa" value="<?= $cu->eCodEmpresa;?>">
							<input type="hidden" id="eCodDepartamento" name="eCodDepartamento" value="<?= $cu->eCodDepartamento;?>">
							<input type="hidden" id="eCodPerfil" name="eCodPerfil" value="<?= $cu->eCodPerfil;?>">

							<div class="row">
								<div class="col-sm-3">
									<div class="thumb-info mb-md">
										<img id="imgPerfil" src="<?= base_url().($cu->tImagen ? $cu->tImagen : 'assets/images/!logged-user.jpg');?>" class="rounded img-responsive">
										<div class="thumb-info-title">
											<span id="txtNombre" class="thumb-info-inner"><?= $cu->tNombre;?></span>
											<span id="txtPuesto" class="thumb-info-type"><?= $cu->tPuesto;?></span>
										</div>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label class="control-label" style="padding: 3px;">Nombre</label>
												<input type="text" id="tNombre" name="tNombre" class="form-control" onkeyup="javascript:$('#txtNombre').html($(this).val());" value="<?= $cu->tNombre;?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<label class="control-label" style="padding: 3px;">Imagen</label>
											<div class="form-group">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input">
															<i class="fa fa-file fileupload-exists"></i>
															<span class="fileupload-preview"></span>
														</div>
														<span class="btn btn-default btn-file">
															<span class="fileupload-exists">Cambiar</span>
															<span class="fileupload-new">Seleccionar</span>
															<input type="file" id="fImagen" name="fImagen" onchange="verImagen(this);"/>
														</span>
														<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
													</div>
													<input type="hidden" id="tImagen" name="tImagen" value="<?= $cu->tImagen;?>">
													<div id="divRespuestaImagen"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" style="padding: 3px;">Correo</label>
												<input type="text" id="tCorreo" name="tCorreo" class="form-control" value="<?= $cu->tCorreo;?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" style="padding: 3px;">Usuario</label>
												<input type="txt" name="tUsuario" id="tUsuario" class="form-control" value="<?= $cu->tUsuario;?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" style="padding: 3px;">Puesto</label>
												<input type="text" id="tPuesto" name="tPuesto" class="form-control" onkeyup="javascript:$('#txtPuesto').html($(this).val());" value="<?= $cu->tPuesto;?>">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label" style="padding: 3px;">Teléfono</label>
												<input id="tTelefono" name="tTelefono" data-plugin-masked-input data-input-mask="(999) 99 99999" placeholder="(___) __ _____" class="form-control" value="<?= $cu->tTelefono;?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-8">
									<div id="divRespuestaActualizar" style="display: none;"></div>
								</div>
								<div class="col-md-4" align="right">
									<button type='button' class='btn btn-lg btn-warning' onclick='actualizar(this);'>
										<i class='fa fa-save'></i> Actualizar</button>
								</div>
							</div>
					<?php } ?>
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
		<script src="<?= base_url();?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

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
			$(document).ready(function(){
				$("input:text:visible:first").focus();
			});
			function verImagen(input) {

				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#imgPerfil')
							.attr('src', e.target.result);
					};

					reader.readAsDataURL(input.files[0]);
					
					var formData = new FormData();
					
					formData.append('userfile', input.files[0]);
					
					$.ajax({
						url: '<?= site_url("Usuario/subirArchivo");?>',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function(data){
							$("#divRespuestaImagen").html(data);
							
							if ($("#eExitoArchivo").val()==1){
								$("#tImagen").val($("#tMensajeArchivo").val());
							} else {
								$("#tImagen").val("");
							}
						}
					});
				}

			}

			function actualizar(oObjeto){
				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				
				if ($("#eCodEmpresa").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Seleccione la empresa</span><br>";
					eError++;
				}
				if ($("#eCodPerfil").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Seleccione el perfil</span><br>";
					eError++;
				}
				if ($("#eCodDepartamento").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Seleccione el departamento</span><br>";
					eError++;
				}
				if ($("#tNombre").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Nombre completo del usuario vacío</span><br>";
					eError++;
				}
				if ($("#tCorreo").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Correo electrónico del usuario vacío</span><br>";
					eError++;
				}
				if ($("#tUsuario").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i>  Usuario de acceso vacío</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuestaActualizar').html(mensaje); $('#divRespuestaActualizar').slideDown(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuestaActualizar').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuestaActualizar').slideDown(300);
					$.post('<?= site_url("Usuario/actualizar"); ?>',{
						eCodUsuario: $("#eCodUsuario").val(),
						eCodEmpresa: $("#eCodEmpresa").val(),
						eCodPerfil: $("#eCodPerfil").val(),
						eCodDepartamento: $("#eCodDepartamento").val(),
						tNombre: $("#tNombre").val(),
						tCorreo: $("#tCorreo").val(),
						tUsuario: $("#tUsuario").val(),
						tTelefono: $("#tTelefono").val(),
						tPuesto: $("#tPuesto").val(),
						tImagen: $("#tImagen").val()
						}, 
						function(data){
							// respuesta
							$('#divRespuestaActualizar').html(data); $('#divRespuestaActualizar').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Panel'); ?>";
								}else{
									$('#divRespuestaActualizar').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 3000 : 3800));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}
		</script>
	</body>
</html>
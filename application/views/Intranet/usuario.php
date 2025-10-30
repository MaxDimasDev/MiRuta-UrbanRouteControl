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
							<div class="row" style="padding-right: 15px; padding-bottom: 10px;">
								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Departamentos</label>
										<select data-plugin-selectTwo class="form-control populate" id="eCodDepartamento" name="eCodDepartamento">
											<option value="">- Todos -</option>
											<?php foreach ($con_departamentos as $cd) { ?>
													<option value="<?= $cd->eCodDepartamento;?>"><?= $cd->tNombre;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4" align="right">
									<label class="control-label"></label><br>
									<div class="btn-group">
										<?php if ($this->session->userdata("bAdmin")==1){ ?>
											<button type="button" class="btn btn-default btn-primary" onclick="filtro();">
											<i class="fa fa-search"></i> Filtrar</button>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div id="divRespuesta" style="display: none;"></div>
								</div>
							</div>
							<div id="divTblUsuario">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
								<thead>
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th>Departamento</th>
										<th>Correo</th>
										<th>Usuario</th>
										<th>Perfil Usuario</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
											<?php /*print_r($con_usuarios);*/ 
										if (isset($con_usuarios)){ 
									?>
								<?php foreach ($con_usuarios as $cu) { ?>
												<tr>
													<td><?= str_pad($cu->eCodUsuario, 6, "0", STR_PAD_LEFT);?></td>
													<td><?= $cu->tNombre;?><br><i><?= $cu->tPuesto;?></i></td>
													<td><?= $cu->tDepartamento;?></td>
													<td><?= $cu->tCorreo;?></td>
													<td><?= $cu->tUsuario;?></td>
													<td><?= $cu->tPerfil;?></td>
													<td>
														<div id="<?= $cu->eCodUsuario;?>" class="btn-group">
															<?php foreach ($con_permisos as $cp) { ?>
															<?php if (strrpos($cp->aEstatus, $cu->tCodEstatus)!==false) { ?>
																		<?= $cp->tBoton;?>
															<?php } ?>
															<?php } ?>
														</div>
													</td>
												</tr>
								<?php } ?>
								<?php } ?>
								</tbody>
								</table>
							</div>
						</div>
					</section>
					<!-- end: page -->

				</section>

			</div>

		</section>

		<!-- MODALS -->
		<div id="divInfo" class="modal-block modal-block-default mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Información <button class="close modal-dismiss"><i class="fa fa-times"></i></button></h2>
				</header>
				<div id="divInfoDetalle" class="panel-body">
					
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-default modal-dismiss">CERRAR</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<div id="divCancelar" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Cancelar <button class="close modal-dismiss"><i class="fa fa-times"></i></button></h2>
				</header>
				<div id="divDetalleCancelar" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-question-circle"></i>
						</div>
						<div class="modal-text">
							<h4>¿Esta seguro de cancelar el usuario?</h4>
						</div>
						<div class="modal-text">
							<div id="divRespuestaCancelar" style="display:none;">
								<div class="alert alert-success"><b>¡Usuario cancelado con éxito!,</b> redireccionando el listado..</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary" onclick="javascript:$('#divRespuestaCancelar').slideDown(300).delay(3000).slideUp(300);">Aceptar</button>
							<button class="btn btn-default modal-dismiss">Cancelar</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<div id="divEliminar" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Eliminar <button class="close modal-dismiss"><i class="fa fa-times"></i></button></h2>
				</header>
				<div id="divDetalleCancelar" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-question-circle"></i>
						</div>
						<div class="modal-text">
							<h4>¿Esta seguro de eliminar el usuario?</h4>
						</div>
						<div class="modal-text">
							<div id="divRespuestaEliminar" style="display:none;">
								<div class="alert alert-success"><b>¡Usuario eliminado con éxito!,</b> redireccionando el listado..</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary" onclick="javascript:$('#divRespuestaEliminar').slideDown(300).delay(3000).slideUp(300);">Aceptar</button>
							<button class="btn btn-default modal-dismiss">Cancelar</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<div id="divPassword" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">
						Password <button id="btnClosePassword" class="close modal-dismiss"><i class="fa fa-times"></i></button>
					</h2>
				</header>
				<div id="divDetalleCancelar" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-key"></i>
						</div>
						<div class="modal-text">
							<h4>Teclee el nuevo password</h4>
							<input type="text" id="tPassword" name="tPassword" class="form-control">
							<input type="hidden" id="eCodUsuarioPassword" name="eCodUsuarioPassword">
						</div>
						<div class="modal-text">
							<div id="divRespuestaPassword" style="display:none;">
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary" onclick="password_guardar(this)">Aceptar</button>
							<button class="btn btn-default modal-dismiss">Cancelar</button>
						</div>
					</div>
				</footer>
			</section>
		</div>
		<!-- END MODALS -->

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
		<script src="<?= base_url();?>assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="<?= base_url();?>assets/vendor/ios7-switch/ios7-switch.js"></script>
		
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
		<script src="<?= base_url();?>assets/vendor/jquery-idletimer/dist/idle-timer.js"></script>
		

		<script type="text/javascript">
			$(document).ready(function(){
				  var oTable = $('#datatable-tabletools').dataTable();
				  oTable.fnSort( [ [0,'desc'] ] );
			} );
			
			function info(oObjeto){
				var eCodUsuario = oObjeto.attr('id');
				$.post('<?= site_url("Usuario/detalle"); ?>',{
					eCodUsuario: eCodUsuario
					}, 
					function(data){
						// respuesta
						$('#divInfoDetalle').html(data);

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}

			function password_id(oObjeto){
				$("#eCodUsuarioPassword").val(oObjeto.attr('id'));
			}
			
			function password_guardar(oObjeto){

				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				
				if ($("#tPassword").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Password nuevo vacío</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuestaPassword').html(mensaje); $('#divRespuestaPassword').slideDown(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuestaPassword').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuestaPassword').slideDown(300);
					$.post('<?= site_url("Usuario/guardar_password"); ?>',{
						eCodUsuario: $("#eCodUsuarioPassword").val(),
						tPassword: $("#tPassword").val()
						}, 
						function(data){
							// respuesta
							$('#divRespuestaPassword').html(data); $('#divRespuestaPassword').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Usuario/m2_s2'); ?>";
								}else{
									$('#divRespuestaPassword').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 3000 : 3800));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}

			function editar(oObjeto){
				window.location.href = "<?= site_url('Usuario/editar')?>/"+oObjeto.attr('id');
			}

			function filtro(){
				$('#divRespuesta').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
				$('#divRespuesta').slideDown(300);

				$.post('<?= site_url("Usuario/filtro_usuario"); ?>',{
					eCodDepartamento: $("#eCodDepartamento").val(),
					}, 
					function(data){

						$('#divTblUsuario').html(data);
						$("#divRespuesta").slideUp(300);

						var datatableInit = function() {

							$('#datatable-default').dataTable({
								aaSorting: [
									[0, 'desc']
								]
							});
							$('.modal-basic').magnificPopup({
								type: 'inline',
								preloader: false,
								modal: true
							});
						};

						datatableInit();

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}
			function cancelar(oObjeto){
				alert("En Construcción para Baja Temporal, el Eliminar es para Cancelar el usuario indeterminado tiempo");
			}
		</script>
	</body>
</html>

	</body>
</html>
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
										<label class="control-label">Tipos de Item</label>
										<select data-plugin-selectTwo class="form-control populate" id="eCodTipoItemFiltro" name="eCodTipoItemFiltro">
											<option value="">- Todos -</option>
											<?php foreach ($con_tipositems as $cti) { ?>
													<option value="<?= $cti->eCodTipoItem;?>"><?= $cti->tNombre;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label class="control-label"></label><br>
									<div class="btn-group">
									<a title='Nuevo' href='#divNuevoItem' data-toggle='tooltip' class='modal-basic btn btn-default btn-success'><i class='fa fa-plus'></i> Nuevo</a>
									</div>
								</div>
								<div class="col-md-4" align="right">
									<label class="control-label"></label><br>
									<div class="btn-group">
										<button type="button" class="btn btn-default btn-primary" onclick="filtro();">
										<i class="fa fa-search"></i> Filtrar</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div id="divRespuesta" style="display: none;"></div>
								</div>
							</div>
							<div id="divTblItem">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
								<thead>
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th>Tipo</th>
										<th>Precio</th>
										<th>Acción</th>
									</tr>
								</thead>
								<tbody>
											<?php /*print_r($con_items);*/ 
												if (isset($con_items)){ 
											?>
											<?php foreach ($con_items as $ci) { ?>
												<tr>
													<td><?= str_pad($ci->eCodItem, 6, "0", STR_PAD_LEFT);?></td>
													<td><?= $ci->tNombre;?><br><i></td>
													<td><?= $ci->tTipoItem;?><br><i></td>
													<td><?= $ci->dPrecio;?></td>
													<td>
														<div id="<?= $ci->eCodItem;?>" class="btn-group">
																<?php foreach ($con_permisos as $cp) { ?>
																<?php if (strrpos($cp->aEstatus, $ci->tCodEstatus)!==false) { ?>
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

		<div id="divNuevoItem" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">
						Nuevo Item <button id="btnCloseItem" class="close modal-dismiss"><i class="fa fa-times"></i></button>
					</h2>
				</header>
				<div id="divFomularioNuevoItem" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-save"></i>
						</div>
						<div class="modal-text">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label" style="padding: 3px;">Nombre</label>
											<input type="text" id="tNombreNuevoItem" name="tNombreNuevoItem" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label" style="padding: 3px;">Tipo Item</label>
												<select id="eCodTipoItemNuevoItem" name="eCodTipoItemNuevoItem" class="form-control populate select2">
															<?php foreach ($con_tipositems as $ctig) { ?>
														<option value="<?= $ctig->eCodTipoItem?>"><?= $ctig->tNombre;?></option>	
															<?php } ?>
												</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label" style="padding: 3px;">Descripcion</label>
											<input type="text" id="tDescripcionNuevoItem" name="tDescripcionNuevoItem" class="form-control">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label" style="padding: 3px;">Precio</label>
											<input type='number' step='0.01' placeholder='0.00' id="dPrecioNuevoItem" name="dPrecioNuevoItem" class="form-control"/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-text">
							<div id="divRespuestaGuardar" style="display:none;">
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary" onclick="guardar(this)">Guardar</button>
							<button class="btn btn-default modal-dismiss">Cancelar</button>
						</div>
					</div>
				</footer>
			</section>
		</div>
		
		<div id="divEditarItem" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">
						Editar Item <button id="btnCloseItem" class="close modal-dismiss"><i class="fa fa-times"></i></button>
					</h2>
				</header>
				<div id="divFomularioEditarItem" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-edit"></i>
						</div>
						<div class="modal-text" id="divEditarDetalle" name="divEditarDetalle">

						</div>
						<div class="modal-text">
							<div id="divRespuestaEditarItem" style="display:none;">
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-warning" onclick="actualizaritem(this)">Actualizar</button>
							<button class="btn btn-default modal-dismiss">Cancelar</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

		<div id="divEliminarItem" class="modal-block modal-block-danger mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">
						Eliminar Item <button id="btnCloseItem" class="close modal-dismiss"><i class="fa fa-times"></i></button>
					</h2>
				</header>
				<div id="divFomularioEliminarItem" class="panel-body text-center">
					<div class="modal-wrapper">
						<div class="modal-icon center">
							<i class="fa fa-trash"></i>
						</div>
						<div class="modal-text" id="divEliminarDetalle" name="divEliminarDetalle">

						</div>
						<div class="modal-text">
							<div id="divRespuestaEliminarItem" style="display:none;">
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-danger" onclick="eliminaritem(this)">Eliminar</button>
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
				var eCodItem = oObjeto.attr('id');
				$.post('<?= site_url("Catalogo/itemdetalle"); ?>',{
					eCodItem: eCodItem
					}, 
					function(data){
						// respuesta
						$('#divInfoDetalle').html(data);

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}

			function actualizaritem(oObjeto){
				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				
				if ($("#eCodItemEditar").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> No debe modificar el ID</span><br>";
					eError++;
				}
				if ($("#tNombreEditarItem").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Nombre del Item vacío</span><br>";
					eError++;
				}
				if ($("#eCodTipoItemEditarItem").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Seleccione el Tipo de Item</span><br>";
					eError++;
				}
				if ($("#tDescripcionEditarItem").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Descripcion vacía</span><br>";
					eError++;
				}
				if ($("#dPrecioEditarItem").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i>  Item sin Precio</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuestaEditarItem').html(mensaje); $('#divRespuestaEditarItem').slideDown(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuestaEditarItem').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuestaEditarItem').slideDown(300);
					$.post('<?= site_url("Catalogo/actualizaritem"); ?>',{
						eCodItemEditar: $("#eCodItemEditar").val(),
						tNombreEditarItem: $("#tNombreEditarItem").val(),
						eCodTipoItemEditarItem: $("#eCodTipoItemEditarItem").val(),
						tDescripcionEditarItem: $("#tDescripcionEditarItem").val(),
						dPrecioEditarItem: $("#dPrecioEditarItem").val(),
						tCodEstatusEditarItem: $("#tCodEstatusEditarItem").val()
						}, 
						function(data){
							// respuesta
							$('#divRespuestaEditarItem').html(data); $('#divRespuestaEditarItem').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Catalogo/m3_s1'); ?>";
								}else{
									$('#divRespuestaEditarItem').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 3000 : 3800));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}
			function guardar(oObjeto){
				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				
				if ($("#tNombreNuevoItem").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Nombre del Item vacío</span><br>";
					eError++;
				}
				if ($("#eCodTipoItemNuevoItem").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> Seleccione el Tipo de Item</span><br>";
					eError++;
				}
				if ($("#tDescripcionNuevoItem").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i> Descripcion vacía</span><br>";
					eError++;
				}
				if ($("#dPrecioNuevoItem").val()==''){ 
					mensaje += "<span><i class=\"fa fa-times\"></i>  Item sin Precio</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuestaGuardar').html(mensaje); $('#divRespuestaGuardar').slideDown(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuestaGuardar').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuestaGuardar').slideDown(300);
					$.post('<?= site_url("Catalogo/guardar"); ?>',{
						tNombreNuevoItem: $("#tNombreNuevoItem").val(),
						eCodTipoItemNuevoItem: $("#eCodTipoItemNuevoItem").val(),
						tDescripcionNuevoItem: $("#tDescripcionNuevoItem").val(),
						dPrecioNuevoItem: $("#dPrecioNuevoItem").val()
						}, 
						function(data){
							// respuesta
							$('#divRespuestaGuardar').html(data); $('#divRespuestaGuardar').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Catalogo/m3_s1'); ?>";
									/*$('#divNuevoItem').dialog('close')
									$("#divTblItem").load(" #divTblItem");*/
								}else{
									$('#divRespuestaGuardar').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 3000 : 3800));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}

			function cargaritemeliminar(oObjeto){
				var eCodItem = oObjeto.attr('id');
				$.post('<?= site_url("Catalogo/cargaritemeliminar"); ?>',{
					eCodItem: eCodItem
					}, 
					function(data){
						// respuesta
						$('#divEliminarDetalle').html(data);

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});

			}

			function eliminaritem(oObjeto){
				var eError = 0;
				var mensaje = "<div class=\"col-md-12 alert alert-danger\">";
				
				if ($("#eCodItemEliminar").val()==''){
					mensaje += "<span><i class=\"fa fa-times\"></i> No debe modificar el ID</span><br>";
					eError++;
				}
				if (eError>0){
					mensaje += "</div>";
					$('#divRespuestaEliminarItem').html(mensaje); $('#divRespuestaEliminarItem').slideDown(300);
					return false;
				}else{
					$(oObjeto).prop('disabled', true);
					$('#divRespuestaEliminarItem').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
					$('#divRespuestaEliminarItem').slideDown(300);
					$.post('<?= site_url("Catalogo/eliminaritem"); ?>',{
						eCodItemEliminar: $("#eCodItemEliminar").val()
						}, 
						function(data){
							// respuesta
							$('#divRespuestaEliminarItem').html(data); $('#divRespuestaEliminarItem').slideDown(300);
							setTimeout(function() {
								if ($('#eExito').val()==1){
									window.location.href = "<?= site_url('Catalogo/m3_s1'); ?>";
								}else{
									$('#divRespuestaEliminarItem').slideUp(300);
									$(oObjeto).prop('disabled', false);
								}
							}, ($('#eExito').val()==1 ? 3000 : 3800));

						}).fail(function() { //en caso de que el POST falle
							alert( "Operación fallida." );
					});
					
				}
			}

			function editaritem(oObjeto){
				//window.location.href = "<?= site_url('Usuario/editar')?>/"+oObjeto.attr('id');
				var eCodItem = oObjeto.attr('id');
				$.post('<?= site_url("Catalogo/editaritem"); ?>',{
					eCodItem: eCodItem
					}, 
					function(data){
						// respuesta
						$('#divEditarDetalle').html(data);

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});

			}

			function filtro(){
				$('#divRespuesta').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");
				$('#divRespuesta').slideDown(300);

				$.post('<?= site_url("Catalogo/filtro_item"); ?>',{
					eCodTipoItemFiltro: $("#eCodTipoItemFiltro").val(),
					}, 
					function(data){

						$('#divTblItem').html(data);
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
		</script>
	</body>
</html>

	</body>
</html>
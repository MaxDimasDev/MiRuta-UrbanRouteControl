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
					<?php }
					?>

					<!-- start: page -->

					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">
							</div>
							<h2 class="panel-title"><?= $tTitulo;?></h2>
						</header>
						<div class="panel-body">
							<div class="col-xs-12">
								<form class="form-bordered" action="<?= site_url("Impresion/exportarSolicitudEntradaExcel")?>" method="post" style="margin-bottom: 5px;">
									<div class="row">
										<div class="col-xs-12">
											<div class="btn-group btn-group-justified">
												<a role="button" class="btn btn-default" onclick="cargar_evento(this);">
													<i class="fa fa-bug"></i><br>Eventos
												</a>
									<?php foreach ($con_eventos as $ce) { ?>
													<a role="button" class="btn btn-default" onclick="cargar_evento(this, <?= $ce->eCodEvento;?>);">
														<?= $ce->tIcono."<br>".$ce->tNombreCorto;?>
													</a>
									<?php } ?>
											</div>
										</div>
										<input type="hidden" id="eCodEvento" name="eCodEvento" value="">
									</div><br>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label" for="inputDefault"> Rango de Fechas</label>
												<div class="input-daterange input-group" data-plugin-datepicker="">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input type="text" class="form-control" id="fhFechaInicio" name="fhFechaInicio">
													<span class="input-group-addon">a</span>
													<input type="text" class="form-control" id="fhFechaFinal" name="fhFechaFinal">
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label" for="inputDefault">Usuario</label>
												<select data-plugin-selectTwo class="form-control populate" id="eCodUsuario" name="eCodUsuario">
													<option value="">- Todos -</option>
												<?php foreach ($con_usuarios as $cu) { ?>
														<option value="<?= $cu->eCodUsuario;?>"><?= $cu->tNombre;?></option>
												<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label" for="inputDefault">Evento</label>
												<input type="text" class="form-control" id="tEvento" name="tEvento">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group" align="right">
												<br>
												<div class="btn-group">
													<button type='button' class='btn btn-primary' onclick='filtro_logeventos(this);'><i class='fa fa-search'></i> Filtrar</button>
													<!--<button class='btn btn-default'><i class='fa fa-file-excel-o'></i> Exportar Excel</button>-->
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>

						<div id="divLogEvento" class="panel-body tab-content">
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

		<!-- Specific Page Vendor Form -->
		<script src="<?= base_url();?>assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="<?= base_url();?>assets/vendor/select2/select2.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="<?= base_url();?>assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="<?= base_url();?>assets/vendor/ios7-switch/ios7-switch.js"></script>

		<!-- Specific Page Vendor -->
		<script src="<?= base_url();?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.js"></script>
		<script src="<?= base_url();?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

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

		<script type="text/javascript">

			function cargar_evento(oObjeto, eCodEvento){
				$('a[role="button"]').each(function(){
					if ($(this).hasClass("btn-primary")){
						$(this).removeClass("btn-primary");
					}
				});
				$(oObjeto).addClass("btn-primary");
				$("#eCodEvento").val(eCodEvento);
			}

			function filtro_logeventos(oObjeto){
				$('#divLogEvento').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");

				$.post('<?= site_url("Configuracion/detalle_evento"); ?>',{
					eCodUsuario: $("#eCodUsuario").val(),
					eCodEvento: $("#eCodEvento").val(),
					tEvento: $("#tEvento").val(),
					fhFechaInicio: dateFormat($("#fhFechaInicio").val()),
					fhFechaFinal: dateFormat($("#fhFechaFinal").val()),
					}, 
					function(data){
						// respuesta
						setTimeout(function() {
							$('#divLogEvento').html(data);
							$("#tblLogEvento").dataTable({
								aaSorting: [
									[0, 'desc']
								]
							});
						}, 2000);

					}).fail(function() { //en caso de que el POST falle
						alert( "Operación fallida." );
				});
			}

		</script>

	</body>
</html>
<section role="main" class="content-body">
                    <?php foreach ($con_seccion as $sec) { ?>
                            <header class="page-header">
                                <h2>Logs del sistema</h2>
                                <div class="right-wrapper pull-right">
                                    <ol class="breadcrumbs">
                                        <li><span>Logs del sistema</span></li>
                                        <li><span>Historial de eventos del sistema</span></li>
                                    </ol>
                                    <?php $tTitulo = 'Historial de eventos del sistema'; ?>
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
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:right">
                                        <a href='<?= site_url("Administracion_de_sistema/Historial_de_eventos"); ?>' class='btn btn-default'><i class='fa fa-list'></i> Ver historial completo</a>
                                    </div>
                                </div>
                                
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

            // Se elimina la selección por tipo de evento (chips)

            function filtro_logeventos(limit){
                $('#divLogEvento').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando informaci&oacute;n ...</strong></div>");

                $.post('<?= site_url("Configuracion/detalle_evento"); ?>',{
                    limit: (typeof limit !== 'undefined' ? limit : '')
                    }, 
                    function(data){
                        // respuesta
                        $('#divLogEvento').html(data);
                        $("#tblLogEvento").dataTable({
                            aaSorting: [ [0, 'desc'] ]
                        });
                        var dt = $("#tblLogEvento").DataTable();
                        dt.column(2).visible(false);
                    }).fail(function() { // en caso de que el POST falle
                        $('#divLogEvento').html("<div class=\"alert alert-danger\"><strong>Error al cargar el log.</strong> Intenta de nuevo.</div>");
                        alert("Operación fallida.");
                });
            }

            

            // Carga inicial: últimos 10 registros
            $(function(){
                filtro_logeventos(10);
            });

            // Sin generador de datos de prueba

        </script>

        

	</body>
</html>

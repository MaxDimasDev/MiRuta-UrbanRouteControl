<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section class="body">
    <!-- start: header -->
    <!-- El header y menú ya se cargan desde el controlador -->
    <!-- end: header -->

    <div class="inner-wrapper">
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Historial completo de eventos</h2>
            </header>

            
            <section class="panel">
                <header class="panel-heading" style="position:relative;">
                    <h2 class="panel-title" style="display:inline-block;">Resultados</h2>
                    <div class="pull-right" style="display:inline-block;">
                        <a href='<?= site_url("Administracion_de_sistema/Logs_del_sistema"); ?>' class='btn btn-default btn-sm'><i class='fa fa-arrow-left'></i> Regresar</a>
                    </div>
                </header>
                <div id="divLogEvento" class="panel-body">
                    <div class="alert alert-info"><img src="<?= base_url();?>/assets/images/loader.gif" width="30px"> <strong> Cargando historial ...</strong></div>
                </div>
            </section>
        </section>
    </div>
</section>

<!-- Vendor -->
<script src="<?= base_url();?>assets/vendor/jquery/jquery.js"></script>
<script src="<?= base_url();?>assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?= base_url();?>assets/vendor/select2/select2.js"></script>
<script src="<?= base_url();?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= base_url();?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url();?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?= base_url();?>assets/javascripts/theme.js"></script>
<script src="<?= base_url();?>assets/javascripts/theme.custom.js"></script>
<script src="<?= base_url();?>assets/javascripts/theme.init.js"></script>

<script type="text/javascript">
    function filtro_logeventos_full(limit){
        $('#divLogEvento').html("<div class=\"alert alert-info\"><img src=\"<?= base_url();?>/assets/images/loader.gif\" width=\"30px\"> <strong> Procesando información ...</strong></div>");
        $.post('<?= site_url("Configuracion/detalle_evento"); ?>',{
            limit: (typeof limit !== 'undefined' ? limit : '')
        }, function(data){
            $('#divLogEvento').html(data);
            $("#tblLogEvento").dataTable({
                aaSorting: [[0, 'desc']],
                paging: true,
                scrollY: '60vh',
                scrollCollapse: true
            });
            var dt = $("#tblLogEvento").DataTable();
            dt.column(2).visible(false);
        }).fail(function(){
            $('#divLogEvento').html("<div class=\"alert alert-danger\"><strong>Error al cargar el historial.</strong> Intenta de nuevo.</div>");
            alert("Operación fallida.");
        });
    }

    // Carga inicial: sin límite (paginado por DataTables)
    $(function(){
        // Límite inicial fijo
        var initialLimit = 500;
        filtro_logeventos_full(initialLimit);
    });
</script>

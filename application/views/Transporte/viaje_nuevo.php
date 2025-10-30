<section role="main" class="content-body">
    <header class="page-header">
        <h2>Nuevo Viaje</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Crear viaje</h2>
                </header>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('mensaje')) { ?>
                        <div class="alert alert-info"><?= htmlentities($this->session->flashdata('mensaje')); ?></div>
                    <?php } ?>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12">
                            <a href="<?= site_url('Transporte/m4_s3'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Volver a Horarios</a>
                        </div>
                    </div>

                    <?php if (!isset($con_rutas) || count($con_rutas)==0) { ?>
                        <div class="alert alert-warning">No hay rutas activas. Primero registre rutas.</div>
                    <?php } ?>
                    <?php if (!isset($con_servicios) || count($con_servicios)==0) { ?>
                        <div class="alert alert-warning">No hay servicios activos. Registre servicios de operación.</div>
                    <?php } ?>

                    <form action="<?= site_url('Transporte/guardar_viaje'); ?>" method="post" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Ruta *</label>
                                <select name="eCodRuta" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <?php if(isset($con_rutas)) { foreach($con_rutas as $r) { ?>
                                        <option value="<?= (int)$r->eCodRuta; ?>">#<?= (int)$r->eCodRuta; ?> - <?= htmlentities($r->tNombre); ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Servicio *</label>
                                <select name="eCodServicio" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <?php if(isset($con_servicios)) { foreach($con_servicios as $s) { ?>
                                        <option value="<?= (int)$s->eCodServicio; ?>">#<?= (int)$s->eCodServicio; ?> - <?= htmlentities($s->tNombre); ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Sentido</label>
                                <select name="tSentido" class="form-control">
                                    <option value="">(Opcional)</option>
                                    <option value="N">N</option>
                                    <option value="S">S</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                                    <option value="NE">NE</option>
                                    <option value="NO">NO</option>
                                    <option value="SE">SE</option>
                                    <option value="SO">SO</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Nombre</label>
                                <input type="text" name="tNombre" class="form-control" placeholder="Opcional" />
                            </div>
                        </div>

                        <div class="row" style="margin-top: 14px;">
                            <div class="col-md-12" align="right">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Rutas de Transporte</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Listado de Rutas</h2>
                </header>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('mensaje')) { ?>
                        <div class="alert alert-info"><?php echo htmlentities($this->session->flashdata('mensaje')); ?></div>
                    <?php } ?>

                    <form action="<?php echo site_url('Transporte/guardar_ruta'); ?>" method="post" class="form-horizontal" style="margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nombre *</label>
                                <input type="text" name="tNombre" class="form-control" required />
                            </div>
                            <div class="col-md-2">
                                <label>Código</label>
                                <input type="text" name="tCodigo" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label>Color (hex)</label>
                                <input type="text" name="tColor" class="form-control" placeholder="#0088cc" />
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
                            <div class="col-md-3" style="padding-top:22px;">
                                <button type="submit" class="btn btn-primary">Guardar Ruta</button>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($con_rutas) && is_array($con_rutas) && count($con_rutas)>0) { ?>
                        <table class="table table-bordered table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Código</th>
                                    <th>Color</th>
                                    <th>Estatus</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($con_rutas as $r){ ?>
                                    <tr>
                                        <td><?php echo (int)$r->eCodRuta; ?></td>
                                        <td><?php echo htmlentities($r->tNombre); ?></td>
                                        <td><?php echo isset($r->tCodigo)?htmlentities($r->tCodigo):''; ?></td>
                                        <td>
                                            <?php if (!empty($r->tColor)) { ?>
                                                <span style="display:inline-block;width:18px;height:18px;border-radius:2px;background:<?php echo htmlentities($r->tColor); ?>;"></span>
                                                <small><?php echo htmlentities($r->tColor); ?></small>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo isset($r->tEstatus)?htmlentities($r->tEstatus):htmlentities($r->tCodEstatus); ?></td>
                                        <td><?php echo isset($r->fhFechaRegistro)?htmlentities($r->fhFechaRegistro):''; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('Transporte/asignar_paradas/'.(int)$r->eCodRuta); ?>" class="btn btn-default btn-xs">Paradas</a>
                                            <form action="<?php echo site_url('Transporte/estatus_ruta'); ?>" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar esta ruta?');">
                                                <input type="hidden" name="eCodRuta" value="<?php echo (int)$r->eCodRuta; ?>" />
                                                <input type="hidden" name="tCodEstatus" value="EL" />
                                                <button type="submit" class="btn btn-danger btn-xs">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="alert alert-info">
                            <strong>Sin datos:</strong> Aún no se han registrado rutas.
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</section>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Paradas de Transporte</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Listado de Paradas</h2>
                </header>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('mensaje')) { ?>
                        <div class="alert alert-info"><?php echo htmlentities($this->session->flashdata('mensaje')); ?></div>
                    <?php } ?>

                    <form action="<?php echo site_url('Transporte/guardar_parada'); ?>" method="post" class="form-horizontal" style="margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nombre *</label>
                                <input type="text" name="tNombre" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label>Dirección</label>
                                <input type="text" name="tDireccion" class="form-control" />
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
                                <label>Latitud *</label>
                                <input type="number" step="0.0000001" name="dLatitud" class="form-control" required />
                            </div>
                            <div class="col-md-2">
                                <label>Longitud *</label>
                                <input type="number" step="0.0000001" name="dLongitud" class="form-control" required />
                            </div>
                            <div class="col-md-12" style="padding-top:22px;">
                                <button type="submit" class="btn btn-primary">Guardar Parada</button>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($con_paradas) && is_array($con_paradas) && count($con_paradas)>0) { ?>
                        <table class="table table-bordered table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Dirección/Sentido</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($con_paradas as $p){ ?>
                                    <tr>
                                        <td><?php echo (int)$p->eCodParada; ?></td>
                                        <td><?php echo htmlentities($p->tNombre); ?></td>
                                        <td>
                                            <?php echo isset($p->tDireccion)?htmlentities($p->tDireccion):''; ?>
                                            <?php echo isset($p->tSentido)?' ('.htmlentities($p->tSentido).')':''; ?>
                                        </td>
                                        <td><?php echo isset($p->dLatitud)?htmlentities($p->dLatitud):''; ?></td>
                                        <td><?php echo isset($p->dLongitud)?htmlentities($p->dLongitud):''; ?></td>
                                        <td><?php echo isset($p->tEstatus)?htmlentities($p->tEstatus):htmlentities($p->tCodEstatus); ?></td>
                                        <td>
                                            <form action="<?php echo site_url('Transporte/estatus_parada'); ?>" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar esta parada?');">
                                                <input type="hidden" name="eCodParada" value="<?php echo (int)$p->eCodParada; ?>" />
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
                            <strong>Sin datos:</strong> Aún no se han registrado paradas.
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</section>
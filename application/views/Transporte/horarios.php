<section role="main" class="content-body">
    <header class="page-header">
        <h2>Horarios de Transporte</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Listado de Viajes</h2>
                </header>
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-md-12">
                            <a href="<?= site_url('Transporte/nuevo_viaje'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo viaje</a>
                            <?php if (isset($con_viajes) && is_array($con_viajes)) { ?>
                                <span class="label label-default" style="margin-left:8px;"><?= count($con_viajes); ?> viaje(s)</span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (isset($con_viajes) && is_array($con_viajes) && count($con_viajes)>0) { ?>
                        <table class="table table-bordered table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Ruta</th>
                                    <th>Servicio</th>
                                    <th>Sentido</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($con_viajes as $v){ ?>
                                    <tr>
                                        <td><?php echo (int)$v->eCodViaje; ?></td>
                                        <td><?php echo isset($v->tNombre) && $v->tNombre ? htmlentities($v->tNombre) : '<span class="text-muted">(sin nombre)</span>'; ?></td>
                                        <td><?php echo isset($v->tRuta)?htmlentities($v->tRuta):$v->eCodRuta; ?></td>
                                        <td><?php echo isset($v->tServicio)?htmlentities($v->tServicio):$v->eCodServicio; ?></td>
                                        <td><?php echo isset($v->tSentido)?htmlentities($v->tSentido):''; ?></td>
                                        <td>
                                            <?php
                                            $cod = isset($v->tCodEstatus) ? $v->tCodEstatus : 'AC';
                                            $nom = isset($v->tEstatus) ? $v->tEstatus : $cod;
                                            $cls = 'label-default';
                                            if ($cod=='AC') { $cls='label-success'; }
                                            else if ($cod=='EL') { $cls='label-danger'; }
                                            else if ($cod=='CA') { $cls='label-default'; }
                                            ?>
                                            <span class="label <?= $cls; ?>"><?php echo htmlentities($nom); ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('Transporte/editar_viaje/'.(int)$v->eCodViaje); ?>" class="btn btn-default btn-xs"><i class="fa fa-clock-o"></i> Editar tiempos</a>
                                            <form action="<?= site_url('Transporte/estatus_viaje'); ?>" method="post" style="display:inline;" onsubmit="return confirm('¿Eliminar este viaje?');">
                                                <input type="hidden" name="eCodViaje" value="<?= (int)$v->eCodViaje; ?>" />
                                                <input type="hidden" name="tCodEstatus" value="EL" />
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <div class="alert alert-info">
                            <strong>Sin datos:</strong> Aún no se han registrado viajes/horarios.
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</section>
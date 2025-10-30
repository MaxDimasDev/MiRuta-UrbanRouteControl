<section role="main" class="content-body">
    <header class="page-header">
        <h2>Asignar Paradas a Ruta</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Ruta: <?php echo htmlentities($ruta->tNombre); ?> (ID #<?php echo (int)$ruta->eCodRuta; ?>)</h2>
                </header>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('mensaje')) { ?>
                        <div class="alert alert-info"><?php echo htmlentities($this->session->flashdata('mensaje')); ?></div>
                    <?php } ?>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-12">
                            <a href="<?php echo site_url('Transporte/m4_s1'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Volver a Rutas</a>
                        </div>
                    </div>

                    <form action="<?php echo site_url('Transporte/guardar_ruta_paradas'); ?>" method="post" onsubmit="prepararEnvio()">
                        <input type="hidden" name="eCodRuta" value="<?php echo (int)$ruta->eCodRuta; ?>">

                        <div class="row">
                            <div class="col-md-5">
                                <label>Paradas asignadas (orden)</label>
                                <select id="lista_asignadas" class="form-control" multiple size="14" style="min-height:300px;">
                                    <?php if(isset($asignadas) && is_array($asignadas)) { foreach($asignadas as $p) { ?>
                                        <option value="<?php echo (int)$p->eCodParada; ?>">#<?php echo (int)$p->eCodParada; ?> - <?php echo htmlentities($p->tNombre); ?></option>
                                    <?php } } ?>
                                </select>
                                <div class="btn-group" style="margin-top:8px;">
                                    <button type="button" class="btn btn-default" onclick="orden_up()"><i class="fa fa-arrow-up"></i> Subir</button>
                                    <button type="button" class="btn btn-default" onclick="orden_down()"><i class="fa fa-arrow-down"></i> Bajar</button>
                                </div>
                            </div>

                            <div class="col-md-2" align="center" style="padding-top:68px;">
                                <div class="btn-group-vertical">
                                    <button type="button" class="btn btn-primary" onclick="mover('lista_disponibles','lista_asignadas')">Agregar &raquo;</button>
                                    <button type="button" class="btn btn-default" style="margin-top:8px;" onclick="mover('lista_asignadas','lista_disponibles')">&laquo; Quitar</button>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label>Paradas disponibles</label>
                                <select id="lista_disponibles" class="form-control" multiple size="14" style="min-height:300px;">
                                    <?php if(isset($disponibles) && is_array($disponibles)) { foreach($disponibles as $p) { ?>
                                        <option value="<?php echo (int)$p->eCodParada; ?>">#<?php echo (int)$p->eCodParada; ?> - <?php echo htmlentities($p->tNombre); ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div id="contenedor-hidden"></div>

                        <div class="row" style="margin-top:15px;">
                            <div class="col-md-12" align="right">
                                <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        function mover(srcId, dstId) {
                            var src = document.getElementById(srcId);
                            var dst = document.getElementById(dstId);
                            var selected = Array.from(src.selectedOptions);
                            selected.forEach(function(opt){
                                var nuevo = opt.cloneNode(true);
                                dst.appendChild(nuevo);
                                opt.remove();
                            });
                        }
                        function orden_up(){
                            var sel = document.getElementById('lista_asignadas');
                            var idxs = [];
                            for (var i=0;i<sel.options.length;i++){
                                if (sel.options[i].selected) idxs.push(i);
                            }
                            idxs.sort(function(a,b){return a-b;});
                            idxs.forEach(function(i){
                                if (i>0 && !sel.options[i-1].selected){
                                    var opt = sel.options[i];
                                    sel.insertBefore(opt, sel.options[i-1]);
                                }
                            });
                        }
                        function orden_down(){
                            var sel = document.getElementById('lista_asignadas');
                            var idxs = [];
                            for (var i=0;i<sel.options.length;i++){
                                if (sel.options[i].selected) idxs.push(i);
                            }
                            idxs.sort(function(a,b){return b-a;});
                            idxs.forEach(function(i){
                                if (i < sel.options.length-1 && !sel.options[i+1].selected){
                                    var opt = sel.options[i];
                                    sel.insertBefore(sel.options[i+1], opt);
                                }
                            });
                        }
                        function prepararEnvio(){
                            var cont = document.getElementById('contenedor-hidden');
                            cont.innerHTML = '';
                            var sel = document.getElementById('lista_asignadas');
                            for (var i=0;i<sel.options.length;i++){
                                var input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'eCodParada[]';
                                input.value = sel.options[i].value;
                                cont.appendChild(input);
                            }
                        }
                    </script>
                </div>
            </section>
        </div>
    </div>
</section>
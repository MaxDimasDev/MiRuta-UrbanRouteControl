<section role="main" class="content-body">
    <header class="page-header">
        <h2>Editar Viaje</h2>
    </header>

    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Viaje #<?= (int)$viaje->eCodViaje; ?> | Ruta: <?= htmlentities(isset($viaje->tRuta)?$viaje->tRuta:$viaje->eCodRuta); ?> | Servicio: <?= htmlentities(isset($viaje->tServicio)?$viaje->tServicio:$viaje->eCodServicio); ?></h2>
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

                    <form action="<?= site_url('Transporte/actualizar_viaje'); ?>" method="post" class="form-horizontal" style="margin-bottom: 12px;">
                        <input type="hidden" name="eCodViaje" value="<?= (int)$viaje->eCodViaje; ?>" />
                        <div class="row">
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input type="text" name="tNombre" value="<?= isset($viaje->tNombre)?htmlentities($viaje->tNombre):''; ?>" class="form-control" placeholder="Opcional" />
                            </div>
                            <div class="col-md-2">
                                <label>Sentido</label>
                                <select name="tSentido" class="form-control">
                                    <?php $sent = isset($viaje->tSentido)?$viaje->tSentido:''; ?>
                                    <option value="" <?= $sent==''?'selected':''; ?>>(Opcional)</option>
                                    <option value="N" <?= $sent=='N'?'selected':''; ?>>N</option>
                                    <option value="S" <?= $sent=='S'?'selected':''; ?>>S</option>
                                    <option value="E" <?= $sent=='E'?'selected':''; ?>>E</option>
                                    <option value="O" <?= $sent=='O'?'selected':''; ?>>O</option>
                                    <option value="NE" <?= $sent=='NE'?'selected':''; ?>>NE</option>
                                    <option value="NO" <?= $sent=='NO'?'selected':''; ?>>NO</option>
                                    <option value="SE" <?= $sent=='SE'?'selected':''; ?>>SE</option>
                                    <option value="SO" <?= $sent=='SO'?'selected':''; ?>>SO</option>
                                </select>
                            </div>
                            <div class="col-md-6" style="margin-top: 22px;" align="right">
                                <button type="submit" class="btn btn-default">Guardar datos</button>
                            </div>
                        </div>
                    </form>

                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-md-12">
                            <div class="alert alert-default" style="border: 1px solid #ddd;">
                                <strong>Prellenado de horarios</strong>
                                <div class="row" style="margin-top: 8px;">
                                    <div class="col-md-3">
                                        <label>Hora inicio</label>
                                        <input type="text" id="pre_hora_inicio" class="form-control" placeholder="HH:MM" value="08:00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Intervalo entre paradas (min)</label>
                                        <input type="number" id="pre_intervalo" class="form-control" min="0" value="5" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Estancia en parada (min)</label>
                                        <input type="number" id="pre_estancia" class="form-control" min="0" value="0" />
                                    </div>
                                    <div class="col-md-3" style="margin-top: 22px;" align="right">
                                        <button type="button" class="btn btn-default" id="btnPrellenar"><i class="fa fa-clock-o"></i> Prellenar</button>
                                        <button type="button" class="btn btn-default" id="btnLimpiar"><i class="fa fa-eraser"></i> Limpiar</button>
                                    </div>
                                </div>
                                <small>Usa formato HH:MM. El sistema calculará llegada/salida secuencialmente respetando coherencia.</small>
                            </div>
                        </div>
                    </div>

                    <?php if (!isset($paradas) || count($paradas)==0) { ?>
                        <div class="alert alert-warning">La ruta no tiene paradas asignadas. Asigne paradas a la ruta primero.</div>
                    <?php } else { ?>
                        <form action="<?= site_url('Transporte/guardar_tiempos_parada'); ?>" method="post">
                            <input type="hidden" name="eCodViaje" value="<?= (int)$viaje->eCodViaje; ?>" />

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Parada</th>
                                            <th>Hora llegada (HH:MM)</th>
                                            <th>Hora salida (HH:MM)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Índice de tiempos por parada para prellenar
                                        $mapTiempos = array();
                                        if (isset($tiempos) && is_array($tiempos)) {
                                            foreach ($tiempos as $tp) { $mapTiempos[(int)$tp->eCodParada] = $tp; }
                                        }
                                        $orden = 1;
                                        foreach ($paradas as $p) {
                                            $tp = isset($mapTiempos[(int)$p->eCodParada]) ? $mapTiempos[(int)$p->eCodParada] : null;
                                            $llegada = $tp ? substr($tp->fhHoraLlegada,0,5) : '';
                                            $salida  = $tp ? substr($tp->fhHoraSalida,0,5)  : '';
                                        ?>
                                        <tr>
                                            <td><?= $orden; ?></td>
                                            <td>#<?= (int)$p->eCodParada; ?> - <?= htmlentities($p->tNombre); ?></td>
                                            <td>
                                                <input type="hidden" name="eCodParada[]" value="<?= (int)$p->eCodParada; ?>" />
                                                <input type="text" name="fhHoraLlegada[]" value="<?= htmlentities($llegada); ?>" class="form-control" placeholder="08:00" required />
                                            </td>
                                            <td>
                                                <input type="text" name="fhHoraSalida[]" value="<?= htmlentities($salida); ?>" class="form-control" placeholder="08:00" required />
                                            </td>
                                        </tr>
                                        <?php $orden++; } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row" style="margin-top: 12px;">
                                <div class="col-md-8">
                                    <div id="tpErrors" class="alert alert-danger" style="display:none;"></div>
                                </div>
                                <div class="col-md-12" align="right">
                                    <button type="submit" class="btn btn-primary">Guardar tiempos</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
</section>
<style>
/* Marcado visual para errores de validación */
.tp-error{ border-color:#d9534f !important; background:#f2dede !important; }
</style>
<script>
(function(){
    function parseHM(t){
        var m = /^([01]\d|2[0-3]):([0-5]\d)$/.exec(t);
        if(!m) return null;
        return {h:parseInt(m[1],10), m:parseInt(m[2],10)};
    }
    function pad(n){ return (n<10?'0':'')+n; }
    function toHM(h,m){ h = (h+24)%24; m = (m+60)%60; return pad(h)+":"+pad(m); }
    function addMinutes(h,m,add){
        var total = h*60 + m + add;
        var hh = Math.floor(total/60)%24;
        var mm = total%60;
        return {h:hh, m:mm};
    }
    function hmToMinutes(hm){ return hm.h*60 + hm.m; }

    function validateAll(){
        var llegadas = document.querySelectorAll("input[name='fhHoraLlegada[]']");
        var salidas  = document.querySelectorAll("input[name='fhHoraSalida[]']");
        var errors = [];
        var prevLlegada = null;
        for(var i=0;i<llegadas.length;i++){
            var a = llegadas[i], b = salidas[i];
            a.classList.remove('tp-error');
            b.classList.remove('tp-error');
            var pa = parseHM(a.value.trim());
            var pb = parseHM(b.value.trim());
            if(!pa){ errors.push('Formato inválido en llegada de fila '+(i+1)); a.classList.add('tp-error'); }
            if(!pb){ errors.push('Formato inválido en salida de fila '+(i+1));  b.classList.add('tp-error'); }
            if(pa && pb){
                if(hmToMinutes(pb) < hmToMinutes(pa)){
                    errors.push('Salida menor que llegada en fila '+(i+1));
                    b.classList.add('tp-error');
                }
                if(prevLlegada && hmToMinutes(pa) < hmToMinutes(prevLlegada)){
                    errors.push('Llegada decreciente en fila '+(i+1));
                    a.classList.add('tp-error');
                }
                prevLlegada = pa;
            }
        }
        var box = document.getElementById('tpErrors');
        var btn = document.querySelector("form[action$='guardar_tiempos_parada'] button[type='submit']");
        if(box){
            if(errors.length>0){
                box.style.display='block';
                box.innerHTML = '<strong>Corrige los siguientes errores:</strong><br/>- '+errors.join('<br/>- ');
            } else {
                box.style.display='none';
                box.textContent='';
            }
        }
        if(btn){ btn.disabled = errors.length>0; }
        return errors.length===0;
    }

    var btn = document.getElementById('btnPrellenar');
    var btnClr = document.getElementById('btnLimpiar');
    if(btn){
        btn.addEventListener('click', function(){
            var ini = document.getElementById('pre_hora_inicio').value.trim();
            var intervalo = parseInt(document.getElementById('pre_intervalo').value,10);
            var estancia = parseInt(document.getElementById('pre_estancia').value,10);
            if(isNaN(intervalo) || intervalo<0) intervalo = 0;
            if(isNaN(estancia) || estancia<0) estancia = 0;
            var hm = parseHM(ini);
            if(!hm){ alert('Hora inicio inválida. Usa HH:MM'); return; }

            var llegadas = document.querySelectorAll("input[name='fhHoraLlegada[]']");
            var salidas  = document.querySelectorAll("input[name='fhHoraSalida[]']");
            var h = hm.h, m = hm.m;
            for(var i=0;i<llegadas.length;i++){
                // llegada
                llegadas[i].value = toHM(h,m);
                // salida = llegada + estancia
                var s1 = addMinutes(h,m,estancia);
                salidas[i].value = toHM(s1.h, s1.m);
                // próxima llegada = salida + intervalo
                var next = addMinutes(s1.h, s1.m, intervalo);
                h = next.h; m = next.m;
            }
            validateAll();
        });
    }
    if(btnClr){
        btnClr.addEventListener('click', function(){
            var llegadas = document.querySelectorAll("input[name='fhHoraLlegada[]']");
            var salidas  = document.querySelectorAll("input[name='fhHoraSalida[]']");
            for(var i=0;i<llegadas.length;i++){ llegadas[i].value=''; }
            for(var j=0;j<salidas.length;j++){ salidas[j].value=''; }
            validateAll();
        });
    }

    // Validación en vivo
    var allInputs = document.querySelectorAll("input[name='fhHoraLlegada[]'], input[name='fhHoraSalida[]']");
    for(var k=0;k<allInputs.length;k++){
        allInputs[k].addEventListener('input', validateAll);
        allInputs[k].addEventListener('blur', validateAll);
    }

    // Bloquear envío si hay errores
    var form = document.querySelector("form[action$='guardar_tiempos_parada']");
    if(form){
        form.addEventListener('submit', function(e){
            if(!validateAll()){
                e.preventDefault();
                alert('Corrige los errores antes de guardar.');
            }
        });
        // Validación inicial
        validateAll();
    }
})();
</script>
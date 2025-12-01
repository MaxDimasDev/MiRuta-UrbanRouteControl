<!doctype html>
<html class="fixed" lang="es-MX">

<head>
    <meta charset="UTF-8">
    <title><?= isset($tTituloPagina) && $tTituloPagina ? $tTituloPagina : 'MiRuta — Planear tu viaje'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="<?= base_url() ?>assets/images/favicon.ico" rel="shortcut icon">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
    <style>
        body { background: #f7f8fa; }
        .miruta-header { background-color: #fff; color:#222; font-size:22px; padding:10px 16px; margin:0; border-bottom: 1px solid #000; display:flex; align-items:center; justify-content:center; position:relative; }
        .miruta-header .back-btn { position:absolute; right:12px; top:50%; transform: translateY(-50%); }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 12px; }
        .card { background: #fff; border: 1px solid #e1e4e8; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.04); padding: 16px; margin-bottom: 16px; }
        h1 { font-size: 20px; margin: 0 0 8px 0; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 16px; }
        .controls label { display:block; font-weight:600; margin-bottom:6px; }
        .controls select, .controls button { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #d0d7de; border-radius: 6px; background: #fff; }
        .controls button { cursor: pointer; background: #00bcd4; color: #000; border-color: #00bcd4; }
        .controls button:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; cursor: not-allowed; }
        .line-tools button { cursor: pointer; background: #00bcd4; color: #000; border-color: #00bcd4; border-radius: 6px; }
        .line-tools button:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; }
        .route-item .btn-primary, .route-item .btn-default { background:#00bcd4; color:#000; border-color:#00bcd4; }
        .route-item .btn-primary:hover, .route-item .btn-default:hover, .controls button:hover, .line-tools button:hover, .miruta-header .back-btn:hover { background:#00a8c2; border-color:#00a8c2; color:#000; }
        .miruta-header .back-btn { background:#00bcd4; color:#000; border-color:#00bcd4; }
        .results h2 { font-size: 16px; margin: 0 0 8px 0; }
        .route-item { border:1px solid #e1e4e8; border-radius:6px; padding:10px; margin-bottom:8px; }
        .route-main { display:flex; align-items:center; gap:10px; }
        .color-dot { width: 14px; height: 14px; border-radius: 50%; border:1px solid #bbb; background:#ccc; }
        /* Botones de acciones de sugerencia en bloque y 100% */
        .route-item .btn { display:block; width:100%; background:#00bcd4; color:#000; border-color:#00bcd4; border-radius:6px; }
        .route-item .btn + .btn { margin-top:10px; }
        .route-item .btn:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; }
        .map { position: relative; height: clamp(360px, 62vh, 640px); border: 1px solid #e1e4e8; border-radius: 8px; background: #fff; overflow: hidden; }
        #leafletMap { position:absolute; inset:0; z-index:0; }
        .map-grid { position:absolute; inset:0; z-index:1; }
        .map-overlay { position:absolute; inset:0; z-index:2; }
        .map-banner { position:absolute; top:10px; left:10px; background:rgba(9,105,218,0.9); color:#000; padding:8px 12px; border-radius:6px; font-size:14px; pointer-events:none; }
        .hint { color:#57606a; font-size: 13px; }
        .line-tools { margin-top: 10px; }
        .line-tools h2 { font-size: 16px; margin: 10px 0; }
        .horarios { margin-top: 8px; }
        .horarios-item { border:1px dashed #e1e4e8; border-radius:6px; padding:8px; margin-bottom:6px; font-size:13px; }
        /* Caja inline de sugerencias (igual que Panel) */
        .suggestions-box { display:none; border:1px solid #e1e4e8; border-radius:8px; background:#fff; padding:10px; margin-top:8px; }
        .suggestions-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
        .suggestions-title { font-size:15px; font-weight:600; color:#24292f; }
        .suggestions-close { width:14px; height:16px; box-sizing:border-box; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d0d7de; border-radius:4px; background:#fff; color:#57606a; font-size:10px; line-height:1; padding:0; cursor:pointer; }
        .suggestions-close:hover { background:#f6f8fa; color:#24292f; }
        
        /* Responsivo: apilar columnas y ajustar tipografías/espacios en pantallas pequeñas */
        @media (max-width: 992px) {
            .grid { grid-template-columns: 1fr; gap: 12px; }
        }
        @media (max-width: 576px) {
            .container { padding: 0 8px; }
            .miruta-header { font-size: 18px; }
            .controls select,
            .controls button,
            #buscarLinea { font-size: 14px; }
            .suggestions-title { font-size: 14px; }
        }
    </style>
</head>

<body>
<!-- BEGIN BODY -->  
<section role="main" class="content-body">
    <div class="miruta-header">
        <span>Bienvenido a MiRuta</span>
        <a href="<?= site_url('Sesion'); ?>" class="btn btn-default btn-sm back-btn"><i class="fa fa-arrow-left"></i> Atrás</a>
    </div>

    <div class="container" style="padding-top:12px;">
        

        <div class="grid">
            <div class="card controls">
                <label for="origen">Origen</label>
                <select id="origen">
                    <option value="">Selecciona origen</option>
                    <?php if (!empty($con_paradas)) { foreach ($con_paradas as $p) { ?>
                        <option value="<?php echo (int)$p->eCodParada; ?>"><?php echo htmlspecialchars($p->tNombre); ?></option>
                    <?php }} ?>
                </select>

                <label for="destino">Destino</label>
                <select id="destino">
                    <option value="">Selecciona destino</option>
                    <?php if (!empty($con_paradas)) { foreach ($con_paradas as $p) { ?>
                        <option value="<?php echo (int)$p->eCodParada; ?>"><?php echo htmlspecialchars($p->tNombre); ?></option>
                    <?php }} ?>
                </select>

                <button id="buscar" disabled>Buscar rutas</button>
                <p class="hint" id="hint"></p>

                <div class="results" id="resultados">
                    <div id="sugerenciasBox" class="suggestions-box">
                        <div class="suggestions-header">
                            <div class="suggestions-title">Rutas sugeridas</div>
                            <button id="cerrarSugerencias" class="suggestions-close" aria-label="Cerrar">×</button>
                        </div>
                        <div id="listaRutas"></div>
                    </div>
                </div>

                <div class="line-tools">
                    <label for="buscarLinea">Buscar línea (nombre o código)</label>
                    <input id="buscarLinea" type="text" placeholder="Ej. 40 N" style="width:100%;padding:8px;margin-bottom:10px;border:1px solid #d0d7de;border-radius:6px;" />
                    <label for="lineaSel">Línea</label>
                    <select id="lineaSel">
                        <option value="">Selecciona línea</option>
                        <?php if (!empty($con_rutas)) { foreach ($con_rutas as $r) { ?>
                            <option value="<?php echo (int)$r->eCodRuta; ?>" data-color="<?php echo htmlspecialchars($r->tColor); ?>">
                                <?php echo htmlspecialchars($r->tNombre . ($r->tCodigo ? ' ('.$r->tCodigo.')' : '')); ?>
                            </option>
                        <?php }} ?>
                    </select>
                    <label for="paradaSel">Parada de la línea</label>
                    <select id="paradaSel" disabled>
                        <option value="">Selecciona parada</option>
                    </select>
                    <button id="mostrarLinea" disabled>Mostrar trazado</button>
                    <button id="verHorarios" disabled>Ver horarios</button>

                    <div class="horarios" id="listaHorarios"></div>
                    <div class="horarios" id="listaParadas"></div>
                </div>
            </div>

            <div class="card">
                <div class="map" id="mapa">
                    <div id="leafletMap"></div>
                    <div class="map-grid"><canvas id="gridCanvas"></canvas></div>
                    <div class="map-overlay">
                        <canvas id="mapCanvas"></canvas>
                        <div class="map-banner">Mapa cuadriculado de ejemplo</div>
                        <div id="tooltip" style="position:absolute;display:none;padding:6px 8px;background:rgba(0,0,0,0.75);color:#fff;border-radius:6px;font-size:12px;pointer-events:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS/JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        const origenSel  = document.getElementById('origen');
        const destinoSel = document.getElementById('destino');
        const buscarBtn  = document.getElementById('buscar');
        const listaRutas = document.getElementById('listaRutas');
        const hint       = document.getElementById('hint');
        const lineaSel   = document.getElementById('lineaSel');
        const mostrarBtn = document.getElementById('mostrarLinea');
        const horariosBtn= document.getElementById('verHorarios');
        const listaHor   = document.getElementById('listaHorarios');
        const listaPar   = document.getElementById('listaParadas');
        const buscarLinea= document.getElementById('buscarLinea');
        const paradaSel  = document.getElementById('paradaSel');
        const map        = document.getElementById('mapa');
        const leafletDiv = document.getElementById('leafletMap');
        const gridCanvas = document.getElementById('gridCanvas');
        const canvas     = document.getElementById('mapCanvas');
        const gridCtx    = gridCanvas.getContext('2d');
        const ctx        = canvas.getContext('2d');
        const tooltip    = document.getElementById('tooltip');
        const gridLayer  = document.querySelector('.map-grid');
        const overlayLayer = document.querySelector('.map-overlay');
        let currentPoints = []; // {x,y, parada}
        let currentColor  = '#0969da';
        let highlightIdx  = -1;
        let currentRouteStops = [];
        const sugerenciasBox = document.getElementById('sugerenciasBox');
        const cerrarSugBtn   = document.getElementById('cerrarSugerencias');

        cerrarSugBtn.addEventListener('click', () => {
            sugerenciasBox.style.display = 'none';
            listaRutas.innerHTML = '';
        });

        // Leaflet setup
        let leafletReady = !!window.L;
        let leafletMap   = null;
        let routePolyline= null;
        let routeMarkers = [];
        if (leafletReady){
            leafletMap = L.map('leafletMap');
            const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            });
            tiles.addTo(leafletMap);
            leafletMap.setView([21.8818, -102.2910], 12);
            // Por defecto usa Leaflet si está disponible
            useLeafletMode();
        } else {
            useCanvasMode();
        }

        function useLeafletMode(){
            if (!leafletDiv) return;
            leafletDiv.style.display = 'block';
            if (gridLayer) gridLayer.style.display = 'none';
            if (overlayLayer) overlayLayer.style.display = 'none';
            setTimeout(()=>{ if (leafletMap) leafletMap.invalidateSize(); }, 50);
        }

        function useCanvasMode(){
            if (leafletDiv) leafletDiv.style.display = 'none';
            if (gridLayer) gridLayer.style.display = 'block';
            if (overlayLayer) overlayLayer.style.display = 'block';
        }

        function validar(){
            const ok = origenSel.value && destinoSel.value && origenSel.value !== destinoSel.value;
            buscarBtn.disabled = !ok;
            hint.textContent = ok ? '' : 'Selecciona origen y destino distintos para habilitar la búsqueda.';
        }

        function validarLinea(){
            const ok = !!lineaSel.value;
            mostrarBtn.disabled = !ok;
            horariosBtn.disabled = !ok;
            // Reset selector de parada al cambiar línea
            paradaSel.innerHTML = '<option value="">Selecciona parada</option>';
            paradaSel.disabled = true;
            highlightIdx = -1;
        }

        origenSel.addEventListener('change', validar);
        destinoSel.addEventListener('change', validar);
        lineaSel.addEventListener('change', validarLinea);
        validar();
        validarLinea();

        function resizeCanvases(){
            const rect = map.getBoundingClientRect();
            const dpr = Math.max(1, Math.floor(window.devicePixelRatio || 1));

            // Grid canvas
            gridCanvas.style.width = rect.width + 'px';
            gridCanvas.style.height= rect.height + 'px';
            gridCanvas.width = rect.width * dpr; gridCanvas.height = rect.height * dpr;
            gridCtx.setTransform(1,0,0,1,0,0); // reset
            gridCtx.scale(dpr, dpr);

            // Route canvas
            canvas.style.width = rect.width + 'px';
            canvas.style.height= rect.height + 'px';
            canvas.width = rect.width * dpr; canvas.height = rect.height * dpr;
            ctx.setTransform(1,0,0,1,0,0); // reset
            ctx.scale(dpr, dpr);

            drawGrid();
            // Invalidate Leaflet size to fix tiles after container resize
            if (typeof leafletMap !== 'undefined' && leafletMap){
                setTimeout(()=>leafletMap.invalidateSize(), 50);
            }
            // If we are using canvas fallback, keep the route visible on resize
            if (currentPoints && currentPoints.length){
                const paradas = currentPoints.map(cp=>cp.parada);
                drawRouteCanvas(paradas, currentColor);
            }
        }
        window.addEventListener('resize', resizeCanvases);
        resizeCanvases();

        function drawGrid(){
            const w = gridCanvas.clientWidth; const h = gridCanvas.clientHeight;
            gridCtx.clearRect(0,0,w,h);
            const minor = 32; const major = 128;
            gridCtx.lineWidth = 1;
            gridCtx.strokeStyle = 'rgba(0,0,0,0.08)';
            for (let x=0; x<=w; x+=minor){ gridCtx.beginPath(); gridCtx.moveTo(x,0); gridCtx.lineTo(x,h); gridCtx.stroke(); }
            for (let y=0; y<=h; y+=minor){ gridCtx.beginPath(); gridCtx.moveTo(0,y); gridCtx.lineTo(w,y); gridCtx.stroke(); }
            gridCtx.lineWidth = 1.5; gridCtx.strokeStyle = 'rgba(9,105,218,0.25)';
            for (let x=0; x<=w; x+=major){ gridCtx.beginPath(); gridCtx.moveTo(x,0); gridCtx.lineTo(x,h); gridCtx.stroke(); }
            for (let y=0; y<=h; y+=major){ gridCtx.beginPath(); gridCtx.moveTo(0,y); gridCtx.lineTo(w,y); gridCtx.stroke(); }
        }

        function getBounds(paradas){
            let minLat=Infinity,maxLat=-Infinity,minLng=Infinity,maxLng=-Infinity;
            paradas.forEach(p=>{
                if (p.dLatitud && p.dLongitud){
                    const lat = parseFloat(p.dLatitud); const lng = parseFloat(p.dLongitud);
                    if (!isNaN(lat) && !isNaN(lng)){
                        minLat=Math.min(minLat,lat); maxLat=Math.max(maxLat,lat);
                        minLng=Math.min(minLng,lng); maxLng=Math.max(maxLng,lng);
                    }
                }
            });
            if (!isFinite(minLat)) { minLat=0; maxLat=paradas.length; minLng=0; maxLng=paradas.length; }
            return {minLat,maxLat,minLng,maxLng};
        }

        function toXY(lat,lng,bounds){
            const pad = 24;
            const w = canvas.width - pad*2;
            const h = canvas.height - pad*2;
            const latN = (lat - bounds.minLat) / (bounds.maxLat - bounds.minLat || 1);
            const lngN = (lng - bounds.minLng) / (bounds.maxLng - bounds.minLng || 1);
            const x = pad + lngN*w;
            const y = pad + (1-latN)*h;
            return {x,y};
        }

        function drawRoute(paradas, color){
            currentColor = color || '#0969da';
            const coords = paradas.map(p=>({lat:parseFloat(p.dLatitud), lng:parseFloat(p.dLongitud)})).filter(ll=>!isNaN(ll.lat) && !isNaN(ll.lng));
            const canUseLeaflet = leafletReady && coords.length>=2;
            if (canUseLeaflet) {
                useLeafletMode();
                drawRouteLeaflet(paradas, color, coords);
                tooltip.style.display='none';
            } else {
                useCanvasMode();
                drawRouteCanvas(paradas, color);
            }
        }

        function drawRouteLeaflet(paradas, color, coords){
            if (routePolyline){ leafletMap.removeLayer(routePolyline); routePolyline=null; }
            routeMarkers.forEach(m=>leafletMap.removeLayer(m)); routeMarkers=[];
            routePolyline = L.polyline(coords, { color: color || '#0969da', weight: 4, opacity: 0.9 });
            routePolyline.addTo(leafletMap);
            const bounds = routePolyline.getBounds();
            leafletMap.fitBounds(bounds, { padding: [20,20] });
            paradas.forEach((p,i)=>{
                const lat = parseFloat(p.dLatitud), lng=parseFloat(p.dLongitud);
                if (!isNaN(lat) && !isNaN(lng)){
                    const marker = L.circleMarker([lat,lng], { radius: (i===highlightIdx?7:5), color: color || '#0969da', weight: 2, fillColor:'#fff', fillOpacity:1 });
                    marker.bindTooltip(`${i+1}. ${p.tNombre || 'Parada'}${p.tDireccion ? ' • '+p.tDireccion : ''}`, { direction:'top' });
                    marker.addTo(leafletMap);
                    routeMarkers.push(marker);
                }
            });
        }

        function drawRouteCanvas(paradas, color){
            ctx.clearRect(0,0,canvas.width,canvas.height);
            const bounds = getBounds(paradas);
            const pts = paradas.map((p,i)=>{
                if (p.dLatitud && p.dLongitud){
                    return toXY(parseFloat(p.dLatitud), parseFloat(p.dLongitud), bounds);
                } else {
                    const pad = 24, w=canvas.width-pad*2, h=canvas.height-pad*2;
                    const x = pad + (i/(paradas.length-1||1))*w;
                    const y = pad + h/2;
                    return {x,y};
                }
            });
            currentPoints = pts.map((pt,i)=>({x:pt.x,y:pt.y, parada: paradas[i]}));
            currentColor = color || '#333';
            ctx.lineWidth = 4;
            ctx.strokeStyle = currentColor;
            ctx.lineJoin = 'round'; ctx.lineCap='round';
            ctx.beginPath();
            pts.forEach((pt,i)=>{ if(i===0) ctx.moveTo(pt.x,pt.y); else ctx.lineTo(pt.x,pt.y); });
            ctx.stroke();
            ctx.fillStyle = '#fff';
            pts.forEach((pt,i)=>{ ctx.beginPath(); ctx.arc(pt.x,pt.y,(i===highlightIdx?7:5),0,Math.PI*2); ctx.fill(); ctx.stroke(); });
            // Etiquetas simples: índice de parada
            ctx.fillStyle = 'rgba(0,0,0,0.65)';
            ctx.font = '12px system-ui, Arial';
            pts.forEach((pt,i)=>{ ctx.fillText(String(i+1), pt.x+8, pt.y-8); });
        }

        buscarBtn.addEventListener('click', async () => {
            listaRutas.innerHTML = '';
            sugerenciasBox.style.display = 'none';
            const origen  = origenSel.value;
            const destino = destinoSel.value;
            const url     = '<?php echo site_url('MiRuta/plan'); ?>';
            const params  = new URLSearchParams({ eCodParadaOrigen: origen, eCodParadaDestino: destino });
            buscarBtn.disabled = true;
            buscarBtn.textContent = 'Buscando…';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: params.toString()
                });
                const data = await res.json();
                if (data && data.eExito && Array.isArray(data.sugerencias) && data.sugerencias.length) {
                    sugerenciasBox.style.display = 'block';
                    data.sugerencias.forEach(r => {
                        const item = document.createElement('div');
                        item.className = 'route-item';
                        const main = document.createElement('div');
                        main.className = 'route-main';
                        const dot = document.createElement('span');
                        dot.className = 'color-dot';
                        if (r.tColor) { dot.style.background = r.tColor; dot.style.borderColor = r.tColor; }
                        const title = document.createElement('div');
                        title.textContent = `${r.tNombre || 'Ruta'}${r.tCodigo ? ' ('+r.tCodigo+')' : ''}`;
                        const sub = document.createElement('div');
                        sub.className = 'hint';
                        sub.textContent = `Dirección sugerida: ${r.tDireccionSugerida}. Origen #${r.eOrdenOrigen}, Destino #${r.eOrdenDestino}`;
                        const actions = document.createElement('div');
                        actions.innerHTML = '<button class="btn btn-xs btn-primary">Mostrar en mapa</button> <button class="btn btn-xs btn-default">Ver horarios</button>';
                        const btnMostrar = actions.querySelector('button.btn-primary');
                        const btnHorarios= actions.querySelector('button.btn-default');
                        btnMostrar.addEventListener('click', async ()=>{
                            lineaSel.value = r.eCodRuta; lineaSel.dispatchEvent(new Event('change'));
                            mostrarBtn.click();
                        });
                        btnHorarios.addEventListener('click', async ()=>{
                            lineaSel.value = r.eCodRuta; lineaSel.dispatchEvent(new Event('change'));
                            horariosBtn.click();
                        });
                        main.appendChild(dot);
                        main.appendChild(title);
                        item.appendChild(main);
                        item.appendChild(sub);
                        item.appendChild(actions);
                        listaRutas.appendChild(item);
                    });
                } else {
                    const empty = document.createElement('div');
                    empty.className = 'hint';
                    empty.textContent = 'No se encontraron rutas que conecten ambas paradas.';
                    listaRutas.appendChild(empty);
                    sugerenciasBox.style.display = 'block';
                }
            } catch (err) {
                const e = document.createElement('div');
                e.className = 'hint';
                e.textContent = 'Ocurrió un error al consultar sugerencias.';
                listaRutas.appendChild(e);
                sugerenciasBox.style.display = 'block';
            } finally {
                buscarBtn.disabled = false;
                buscarBtn.textContent = 'Buscar rutas';
            }
        });

        mostrarBtn.addEventListener('click', async () => {
            const ruta = lineaSel.value; if (!ruta) return;
            const url  = '<?php echo site_url('MiRuta/linea'); ?>';
            const params = new URLSearchParams({ eCodRuta: ruta });
            mostrarBtn.disabled = true; mostrarBtn.textContent = 'Cargando…'; listaHor.innerHTML='';
            listaPar.innerHTML='';
            paradaSel.innerHTML = '<option value="">Selecciona parada</option>';
            paradaSel.disabled = true;
            highlightIdx = -1;
            try {
                const res = await fetch(url, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}, body: params.toString() });
                const data = await res.json();
                if (data && data.eExito && Array.isArray(data.paradas) && data.paradas.length){
                    const opt = lineaSel.options[lineaSel.selectedIndex];
                    const color = opt.getAttribute('data-color') || '#0969da';
                    currentRouteStops = data.paradas;
                    drawRoute(currentRouteStops, color);
                    // Poblar desplegable de paradas
                    data.paradas.forEach((p,i)=>{
                        const o = document.createElement('option');
                        o.value = p.eCodParada ? String(p.eCodParada) : String(i);
                        o.textContent = `${i+1}. ${p.tNombre || 'Parada'}${p.tDireccion ? ' • '+p.tDireccion : ''}`;
                        o.setAttribute('data-idx', String(i));
                        paradaSel.appendChild(o);
                    });
                    paradaSel.disabled = false;
                } else {
                    ctx.clearRect(0,0,canvas.width,canvas.height);
                }
            } catch (e){ ctx.clearRect(0,0,canvas.width,canvas.height); }
            finally { mostrarBtn.disabled=false; mostrarBtn.textContent='Mostrar trazado'; }
        });

        // Selección de parada: resalta y centra en el mapa
        paradaSel.addEventListener('change', ()=>{
            const selIdxAttr = paradaSel.options[paradaSel.selectedIndex]?.getAttribute('data-idx');
            if (!selIdxAttr){ highlightIdx = -1; drawRoute(currentRouteStops, currentColor); return; }
            const idx = parseInt(selIdxAttr, 10);
            if (isNaN(idx)) { highlightIdx = -1; drawRoute(currentRouteStops, currentColor); return; }
            highlightIdx = idx;
            drawRoute(currentRouteStops, currentColor);
            if (leafletReady && currentRouteStops[idx]){
                const p = currentRouteStops[idx];
                const lat = parseFloat(p.dLatitud), lng = parseFloat(p.dLongitud);
                if (!isNaN(lat) && !isNaN(lng) && leafletMap){
                    leafletMap.setView([lat,lng], Math.max(leafletMap.getZoom() || 13, 15));
                }
            }
        });

        horariosBtn.addEventListener('click', async () => {
            const ruta = lineaSel.value; if (!ruta) return;
            const url  = '<?php echo site_url('MiRuta/horarios'); ?>';
            const params = new URLSearchParams({ eCodRuta: ruta });
            horariosBtn.disabled = true; horariosBtn.textContent = 'Consultando…'; listaHor.innerHTML='';
            try {
                const res = await fetch(url, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}, body: params.toString() });
                const data = await res.json();
                if (data && data.eExito && Array.isArray(data.viajes) && data.viajes.length){
                    data.viajes.forEach(v=>{
                        const item = document.createElement('div'); item.className='horarios-item';
                        item.textContent = `${v.tNombre || 'Viaje'}${v.tSentido ? ' • '+v.tSentido : ''}${v.tServicio ? ' • '+v.tServicio : ''} — ${v.fhInicio || '?'} a ${v.fhFin || '?'}`;
                        listaHor.appendChild(item);
                    });
                } else {
                    const empty = document.createElement('div'); empty.className='hint'; empty.textContent='No hay horarios disponibles para esta línea.'; listaHor.appendChild(empty);
                }
            } catch (e){ const err=document.createElement('div'); err.className='hint'; err.textContent='Error al consultar horarios.'; listaHor.appendChild(err); }
            finally { horariosBtn.disabled=false; horariosBtn.textContent='Ver horarios'; }
        });

        // Buscador de líneas: filtra opciones del selector
        buscarLinea.addEventListener('input', ()=>{
            const q = buscarLinea.value.trim().toLowerCase();
            let visibleAny = false;
            Array.from(lineaSel.options).forEach((opt,idx)=>{
                if (idx===0) return; // saltar "Selecciona"
                const t = opt.text.toLowerCase();
                const match = q==='' || t.includes(q);
                opt.hidden = !match;
                if (match) visibleAny = true;
            });
            if (!visibleAny) { lineaSel.value=''; validarLinea(); }
        });

        // Tooltip sobre nodos
        canvas.addEventListener('mousemove', (ev)=>{
            const rect = canvas.getBoundingClientRect();
            const x = ev.clientX - rect.left; const y = ev.clientY - rect.top;
            const nearIdx = currentPoints.findIndex(pt => Math.hypot(pt.x-x, pt.y-y) < 8);
            if (nearIdx>=0){
                const p = currentPoints[nearIdx].parada;
                tooltip.style.display = 'block';
                tooltip.style.left = (x+12)+'px'; tooltip.style.top = (y+12)+'px';
                tooltip.textContent = (p.tNombre || 'Parada') + (p.tDireccion ? ' • '+p.tDireccion : '');
            } else {
                tooltip.style.display = 'none';
            }
        });
        canvas.addEventListener('mouseleave', ()=>{ tooltip.style.display='none'; });
    </script>
</section>

<!-- Vendor JS -->
<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.js"></script>

</body>
</html>

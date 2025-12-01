<section role="main" class="content-body">
                    <header class="page-header">
                        <h2>Preview de visitante</h2>

						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
    <li><a href="<?= site_url('Administracion_de_sistema/Inicio'); ?>">Inicio</a></li>
							</ol>

							<span style="padding-right: 30px;"></span>
						</div>
					</header>
					<!-- start: page -->
					<div class="row">
					<div class="col-md-12 col-lg-12 col-xl-12">
						<section class="panel">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
                                        <!-- Embed MiRuta dentro del recuadro del panel (se reemplaza solo la imagen) -->
                                        <style>
                                            .miruta-embed { margin-top: 8px; }
                                            .miruta-embed .grid { display: grid; grid-template-columns: 360px 1fr; gap: 12px; }
                                            .miruta-embed .card { border: 1px solid #e1e4e8; border-radius: 8px; background: #fff; padding: 16px; }
                                            .miruta-embed .controls label { display:block; font-weight:600; margin-bottom:4px; color:#24292f; }
                                            .miruta-embed .controls select, .miruta-embed .controls button { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #d0d7de; border-radius: 6px; background: #fff; }
                                            .miruta-embed .controls button { cursor: pointer; background: #00bcd4; color: #000; border-color: #00bcd4; }
                                            .miruta-embed .controls button:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; cursor: not-allowed; }
                                            .miruta-embed .results h2 { font-size: 16px; margin: 0 0 8px 0; }
                                            .miruta-embed .route-item { border:1px solid #e1e4e8; border-radius:6px; padding:10px; margin-bottom:8px; }
                                            .miruta-embed .route-main { display:flex; align-items:center; gap:10px; }
                                            .miruta-embed .color-dot { width: 14px; height: 14px; border-radius: 50%; border:1px solid #bbb; background:#ccc; }
                                            .miruta-embed .hint { color:#57606a; font-size: 13px; }
                                            /* Caja inline de sugerencias con botón de cierre pequeño */
                                            .miruta-embed .suggestions-box { display:none; border:1px solid #e1e4e8; border-radius:8px; background:#fff; padding:10px; margin-top:8px; }
                                            .miruta-embed .suggestions-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
                                            .miruta-embed .suggestions-title { font-size:15px; font-weight:600; color:#24292f; }
                                            .miruta-embed .suggestions-close { width:14px; height:16px; box-sizing:border-box; display:inline-flex; align-items:center; justify-content:center; border:1px solid #d0d7de; border-radius:4px; background:#fff; color:#57606a; font-size:10px; line-height:1; padding:0; cursor:pointer; }
                                            .miruta-embed .suggestions-close:hover { background:#f6f8fa; color:#24292f; }
                                            /* Botones dentro de cada sugerencia: mismos estilos y ancho completo */
                                            .miruta-embed .route-item .btn { display:block; width:100%; background:#00bcd4; color:#000; border-color:#00bcd4; border-radius:6px; }
                                            .miruta-embed .route-item .btn + .btn { margin-top:10px; }
                                            .miruta-embed .route-item .btn:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; }
                                            .miruta-embed .line-tools { margin-top: 10px; }
                                            .miruta-embed .line-tools h2 { font-size: 16px; margin: 10px 0; }
                                            .miruta-embed .line-tools button { cursor: pointer; background: #00bcd4; color: #000; border-color: #00bcd4; border-radius: 6px; }
                                            .miruta-embed .line-tools button:disabled { background:#99e1ea; border-color:#99e1ea; color:#000; }
                                            .miruta-embed .horarios { margin-top: 8px; }
                                            .miruta-embed .horarios-item { border:1px dashed #e1e4e8; border-radius:6px; padding:8px; margin-bottom:6px; font-size:13px; }
                                            .miruta-embed .map { position: relative; height: 520px; border: 1px solid #e1e4e8; border-radius: 8px; background: #fff; overflow: hidden; }
                                            .miruta-embed #leafletMap { position:absolute; inset:0; z-index:0; }
                                            .miruta-embed .map-grid { position:absolute; inset:0; z-index:1; }
                                            .miruta-embed .map-overlay { position:absolute; inset:0; z-index:2; }
                                            .miruta-embed .map-banner { position:absolute; top:10px; left:10px; background:rgba(9,105,218,0.9); color:#000; padding:8px 12px; border-radius:6px; font-size:14px; pointer-events:none; }
                                        </style>
                                        <div class="miruta-embed">
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
                                        <!-- Leaflet CSS/JS para el mapa del embed -->
                                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                                        <script>
                                            (function(){
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
                                                const sugerenciasBox = document.getElementById('sugerenciasBox');
                                                const cerrarSugBtn = document.getElementById('cerrarSugerencias');
                                                let currentColor  = '#0969da';
                                                let highlightIdx  = -1;
                                                let currentRouteStops = [];

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
                                                    gridCtx.setTransform(1,0,0,1,0,0);
                                                    gridCtx.scale(dpr, dpr);

                                                    // Route canvas
                                                    canvas.style.width = rect.width + 'px';
                                                    canvas.style.height= rect.height + 'px';
                                                    canvas.width = rect.width * dpr; canvas.height = rect.height * dpr;
                                                    ctx.setTransform(1,0,0,1,0,0);
                                                    ctx.scale(dpr, dpr);

                                                    drawGrid();
                                                    if (typeof leafletMap !== 'undefined' && leafletMap){
                                                        setTimeout(()=>leafletMap.invalidateSize(), 50);
                                                    }
                                                }
                                                window.addEventListener('resize', resizeCanvases);
                                                setTimeout(resizeCanvases, 100);

                                                function drawGrid(){
                                                    const w = gridCanvas.width; const h = gridCanvas.height;
                                                    gridCtx.clearRect(0,0,w,h);
                                                    gridCtx.strokeStyle = '#e1e4e8';
                                                    gridCtx.lineWidth = 1;
                                                    const step = 40;
                                                    for (let x=0; x<w; x+=step){ gridCtx.beginPath(); gridCtx.moveTo(x,0); gridCtx.lineTo(x,h); gridCtx.stroke(); }
                                                    for (let y=0; y<h; y+=step){ gridCtx.beginPath(); gridCtx.moveTo(0,y); gridCtx.lineTo(w,y); gridCtx.stroke(); }
                                                }

                                                function toXY(lat, lng, bounds){
                                                    const minLat=bounds.minLat, maxLat=bounds.maxLat, minLng=bounds.minLng, maxLng=bounds.maxLng;
                                                    const pad = 24, w=canvas.width-pad*2, h=canvas.height-pad*2;
                                                    const x = pad + (lng-minLng)/(maxLng-minLng||1)*w;
                                                    const y = pad + (1-(lat-minLat)/(maxLat-minLat||1))*h;
                                                    return {x,y};
                                                }

                                                function drawRoute(paradas, color){
                                                    ctx.clearRect(0,0,canvas.width,canvas.height);
                                                    if (!Array.isArray(paradas) || paradas.length===0){ return; }
                                                    const bounds = { minLat: Infinity, maxLat: -Infinity, minLng: Infinity, maxLng: -Infinity };
                                                    paradas.forEach(p=>{
                                                        const lat=parseFloat(p.dLatitud), lng=parseFloat(p.dLongitud);
                                                        if (!isNaN(lat) && !isNaN(lng)){
                                                            bounds.minLat = Math.min(bounds.minLat, lat);
                                                            bounds.maxLat = Math.max(bounds.maxLat, lat);
                                                            bounds.minLng = Math.min(bounds.minLng, lng);
                                                            bounds.maxLng = Math.max(bounds.maxLng, lng);
                                                        }
                                                    });
                                                    const pts = paradas.map((p,i)=>{
                                                        const lat=parseFloat(p.dLatitud), lng=parseFloat(p.dLongitud);
                                                        if (!isNaN(lat) && !isNaN(lng)){
                                                            return toXY(lat, lng, bounds);
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
                                                    ctx.fillStyle = 'rgba(0,0,0,0.65)';
                                                    ctx.font = '12px system-ui, Arial';
                                                    pts.forEach((pt,i)=>{ ctx.fillText(String(i+1), pt.x+8, pt.y-8); });
                                                }

                                                cerrarSugBtn.addEventListener('click', () => {
                                                    sugerenciasBox.style.display = 'none';
                                                    listaRutas.innerHTML = '';
                                                });

                                                buscarBtn.addEventListener('click', async () => {
                                                    listaRutas.innerHTML = '';
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
                                                            // Intentar dibujar en Leaflet si hay coordenadas válidas
                                                            let latLngs = [];
                                                            routeMarkers.forEach(m=>{ if (leafletMap && m && leafletMap.hasLayer(m)) leafletMap.removeLayer(m); });
                                                            routeMarkers = [];
                                                            if (leafletMap && leafletReady){
                                                                if (routePolyline && leafletMap.hasLayer(routePolyline)) leafletMap.removeLayer(routePolyline);
                                                                latLngs = currentRouteStops.map(p=>{
                                                                    const lat = parseFloat(p.dLatitud), lng = parseFloat(p.dLongitud);
                                                                    return (!isNaN(lat) && !isNaN(lng)) ? [lat,lng] : null;
                                                                }).filter(Boolean);
                                                                if (latLngs.length >= 2){
                                                                    useLeafletMode();
                                                                    routePolyline = L.polyline(latLngs, { color: color, weight: 5 }).addTo(leafletMap);
                                                                    // Agregar marcadores simples
                                                                    currentRouteStops.forEach(p=>{
                                                                        const lat = parseFloat(p.dLatitud), lng = parseFloat(p.dLongitud);
                                                                        if (!isNaN(lat) && !isNaN(lng)){
                                                                            const mk = L.circleMarker([lat,lng], { radius: 4, color: color, fillColor: '#fff', fillOpacity: 1 });
                                                                            mk.addTo(leafletMap); routeMarkers.push(mk);
                                                                        }
                                                                    });
                                                                    leafletMap.fitBounds(routePolyline.getBounds(), { padding: [20,20] });
                                                                } else {
                                                                    // Fallback a canvas si no hay coordenadas suficientes
                                                                    useCanvasMode();
                                                                    drawRoute(currentRouteStops, color);
                                                                }
                                                            } else {
                                                                // Sin Leaflet: usar canvas
                                                                useCanvasMode();
                                                                drawRoute(currentRouteStops, color);
                                                            }
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

                                                buscarLinea.addEventListener('input', ()=>{
                                                    const q = buscarLinea.value.trim().toLowerCase();
                                                    let visibleAny = false;
                                                    Array.from(lineaSel.options).forEach((opt,idx)=>{
                                                        if (idx===0) return;
                                                        const t = opt.text.toLowerCase();
                                                        const match = q==='' || t.includes(q);
                                                        opt.hidden = !match;
                                                        if (match) visibleAny = true;
                                                    });
                                                    if (!visibleAny) { lineaSel.value=''; validarLinea(); }
                                                });
                                            })();
													</script>
												</div>
											</div>
									</div>
								</section>
							</div>
						</div>
					</section>
				<!-- Vendor CSS -->

				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/font-awesome/css/font-awesome.css" />
				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/magnific-popup/magnific-popup.css" />
				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

				<!-- Specific Page Vendor CSS -->
				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
				<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/morris/morris.css" />

				<!-- Vendor -->
				<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/nanoscroller/nanoscroller.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/magnific-popup/magnific-popup.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

				<!-- Specific Page Vendor -->
				<script src="<?= base_url(); ?>assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-appear/jquery.appear.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.pie.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.categories.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/flot/jquery.flot.resize.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/raphael/raphael.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/morris/morris.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/gauge/gauge.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/snap-svg/snap.svg.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/liquid-meter/liquid.meter.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/jquery.vmap.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>

				<!-- Specific Page Vendor -->
				<script src="<?= base_url(); ?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/pnotify/pnotify.custom.js"></script>

				<!-- Theme Base, Components and Settings -->
				<script src="<?= base_url(); ?>assets/javascripts/theme.js"></script>

				<!-- Theme Custom -->
				<script src="<?= base_url(); ?>assets/javascripts/theme.custom.js"></script>
				<!--<script src="<?= base_url(); ?>assets/javascripts/theme.notification.js"></script>-->

				<!-- Theme Initialization Files -->
				<script src="<?= base_url(); ?>assets/javascripts/theme.init.js"></script>

				<!-- Examples -->
				<script src="<?= base_url(); ?>assets/javascripts/tables/examples.datatables.default.js"></script>
				<script src="<?= base_url(); ?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
				<script src="<?= base_url(); ?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
				<script src="<?= base_url(); ?>assets/javascripts/ui-elements/examples.modals.js"></script>
				<script src="<?= base_url(); ?>assets/vendor/jquery-idletimer/dist/idle-timer.js"></script>

				</body>

				</html>

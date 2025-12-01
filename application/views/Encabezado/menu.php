<aside id="sidebar-left" class="sidebar-left">

    <style>
        /* Permitir que los textos largos usen segunda línea */
        #menu.nav-main .nav > li > a .menu-text,
        #menu.nav-main .nav-children > li > a .menu-text {
            display: inline-block;
            white-space: normal !important;
            line-height: 1.2;
        }

        /* Ocultar caret por defecto del tema para evitar duplicados */
        #menu.nav-main ul.nav-main li.nav-parent > a:after,
        #menu.nav-main li.nav-parent > a:after {
            content: none !important;
            border: none !important;
        }

        /* Caret (flecha) para módulos, rota al expandir */
        #menu.nav-main .nav-parent > a .menu-caret {
            display: inline-block;
            width: 0; height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 6px solid #666;
            margin-left: 8px;
            vertical-align: middle;
            transition: transform 0.2s ease;
        }
        #menu.nav-main .nav-parent.nav-expanded > a .menu-caret {
            transform: rotate(180deg);
        }
    </style>

    <div class="sidebar-header">
        <div class="sidebar-title">
            Men&uacute;
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li>
                        <a href="<?= site_url('Administracion_de_sistema/Inicio'); ?>">
                            <span class="menu-text">Inicio</span>
                        </a>
                    </li>

                    <?php
                    $eCodSeccionActivo = 0;
                    $eCodModuloActivo  = 0;
                    if (isset($con_seccion)) {
                        foreach ($con_seccion as $cs) {
                            $eCodSeccionActivo = $cs->eCodSeccion;
                            $eCodModuloActivo  = $cs->eCodModulo;
                        }
                    }
                    ?>

                    <?php if (isset($con_menu)) {
                        // Reordenar y renombrar módulos según requerimiento:
                        // Orden: Administracion de transportes (Transporte) -> Usuarios -> Config (hasta abajo)
                        // Eliminar módulo Catálogo del menú.

                        // Agrupar secciones por módulo
                        $friendlyRoutes = [
                            'Configuracion/m1_s1' => 'Administracion_de_sistema/Logs_del_sistema',
                            'Configuracion/historial_eventos' => 'Administracion_de_sistema/Historial_de_eventos',
                            'Transporte/m4_s1'    => 'Administracion_de_transportes/Rutas',
                            'Transporte/m4_s2'    => 'Administracion_de_transportes/Paradas',
                            'Transporte/m4_s3'    => 'Administracion_de_transportes/Horarios',
                        ];
                        $modulos = [];
                        foreach ($con_menu as $item) {
                            // Omitir Catálogo y Usuarios del menú
                            if (strtolower($item->tControlador) === 'catalogo') { continue; }
                            if (strtolower($item->tControlador) === 'usuario') { continue; }

                            $key = $item->eCodModulo;
                            if (!isset($modulos[$key])) {
                                $modulos[$key] = [
                                    'eCodModulo'     => $item->eCodModulo,
                                    'tControlador'   => $item->tControlador,
                                    'tModuloIcono'   => $item->tModuloIcono,
                                    'tModuloCorto'   => $item->tModuloCorto,
                                    'secciones'      => []
                                ];
                            }
                            $modulos[$key]['secciones'][] = $item;
                        }

                        // Definir orden personalizado de controladores
                        $ordenDeseado = ['transporte', 'configuracion'];

                        // Reordenar módulos
                        usort($modulos, function($a, $b) use ($ordenDeseado) {
                            $ia = array_search(strtolower($a['tControlador']), $ordenDeseado);
                            $ib = array_search(strtolower($b['tControlador']), $ordenDeseado);
                            $ia = ($ia === false ? PHP_INT_MAX : $ia);
                            $ib = ($ib === false ? PHP_INT_MAX : $ib);
                            if ($ia === $ib) { return 0; }
                            return ($ia < $ib) ? -1 : 1;
                        });

                        // Renderizar menú respetando activo y renombrando Transporte
                        foreach ($modulos as $mod) { 
                            $textoModulo = (strtolower($mod['tControlador']) === 'transporte' ? 'Administración de transportes' : (strtolower($mod['tControlador']) === 'configuracion' ? 'Administración de sistema MiRuta' : $mod['tModuloCorto']));
                        ?>
                            <li class="nav-parent <?= ($mod['eCodModulo'] == $eCodModuloActivo ? 'nav-expanded nav-active' : ''); ?>">
                                <a>
                                    <span class="menu-text"><?= $textoModulo; ?></span><span class="menu-caret" aria-hidden="true"></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php foreach ($mod['secciones'] as $secIndex => $m) { 
                                        // Omitir Preferencias del sistema
                                        if (strtolower($m->tControlador) === 'configuracion' && strtolower($m->tCodSeccion) === 'm1_s2') { continue; }
                                        $textoSeccion = ($secIndex === 0 ? $m->tSeccionCorto : $m->tSeccion);
                                        $orig = $m->tControlador . '/' . $m->tCodSeccion;
                                        $href = isset($friendlyRoutes[$orig]) ? $friendlyRoutes[$orig] : $orig;
                                    ?>
                                        <li class="<?= ($m->eCodSeccion == $eCodSeccionActivo ? 'nav-active' : ''); ?>">
                                            <a href="<?= site_url($href); ?>">
                                                <span class="menu-text"><?= $textoSeccion; ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </nav>

        </div>

    </div>

</aside>

<script>
(function(){
    function initFallback(){
        function collapse(li){
            if(!li) return;
            var ul = li.querySelector('ul.nav-children');
            if (ul) { ul.style.display = 'none'; }
            li.classList.remove('nav-expanded');
        }
        function expand(li){
            if(!li) return;
            var ul = li.querySelector('ul.nav-children');
            if (ul) { ul.style.display = 'block'; }
            li.classList.add('nav-expanded');
        }
        var anchors = document.querySelectorAll('#menu.nav-main li.nav-parent > a');
        for (var i = 0; i < anchors.length; i++) {
            anchors[i].addEventListener('click', function(ev){
                ev.preventDefault();
                var li = this.parentElement;
                var parentUl = li && li.parentElement;
                var prev = parentUl ? parentUl.querySelector('li.nav-expanded') : null;

                if (prev && prev !== li) {
                    collapse(prev);
                    expand(li);
                } else if (li.classList.contains('nav-expanded')) {
                    collapse(li);
                } else {
                    expand(li);
                }
            });
        }
    }

    // Si theme.js está disponible al final de la carga, dejamos que él maneje los clics.
    // Si no, activamos el fallback.
    if (!window.theme) {
        window.addEventListener('load', function(){
            if (!window.theme) {
                initFallback();
            }
        });
    }
})();
</script>

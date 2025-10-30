<aside id="sidebar-left" class="sidebar-left">

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
                        <a href="<?= site_url('Panel'); ?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Inicio</span>
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
                        foreach ($modulos as $mod) { ?>
                            <li class="nav-parent <?= ($mod['eCodModulo'] == $eCodModuloActivo ? 'nav-expanded nav-active' : ''); ?>">
                                <a>
                                    <i class="<?= $mod['tModuloIcono']; ?>" aria-hidden="true"></i>
                                    <span><?= (strtolower($mod['tControlador']) === 'transporte' ? 'Administración de transportes' : (strtolower($mod['tControlador']) === 'configuracion' ? 'Administración de sistema MiRuta' : $mod['tModuloCorto'])); ?></span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php foreach ($mod['secciones'] as $secIndex => $m) { ?>
                                        <li class="<?= ($m->eCodSeccion == $eCodSeccionActivo ? 'nav-active' : ''); ?>">
                                            <a href="<?= site_url($m->tControlador . '/' . $m->tCodSeccion); ?>">
                                                <i class="<?= $m->tSeccionIcono; ?>"></i><?= ($secIndex === 0 ? $m->tSeccionCorto : $m->tSeccion); ?>
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
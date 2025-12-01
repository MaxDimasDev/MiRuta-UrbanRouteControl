<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Transporte extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->seguridad();
        $this->load->model('secciones_m');
        $this->load->model('catalogos_m');
        $this->load->model('transporte_m');
        $this->load->model('inserts_m');
        $this->load->helper('date_helper');
        date_default_timezone_set('America/Mexico_City');
    }

    function seguridad() {
        if (!$this->session->userdata('bSesion')) {
            redirect(base_url());
        }
    }

    // Administración de Rutas
    public function m4_s1() {
        $data['tTituloPagina'] = 'Transporte - Rutas';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s1');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s1');
        $data['con_rutas']     = $this->transporte_m->con_rutas();

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/rutas', $data);
    }

    // Asignación de paradas a ruta
    public function asignar_paradas($eCodRuta){
        $eCodRuta = (int)$eCodRuta;
        if (!$eCodRuta) { redirect('Transporte/m4_s1'); return; }

        $data['tTituloPagina'] = 'Transporte - Asignar Paradas';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s1');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s1');

        $aRuta = $this->transporte_m->con_rutas($eCodRuta);
        $data['ruta']      = is_array($aRuta) && count($aRuta)>0 ? $aRuta[0] : null;
        if (!$data['ruta']) { $this->session->set_flashdata('mensaje','Ruta no encontrada.'); redirect('Transporte/m4_s1'); return; }

        $data['asignadas']  = $this->transporte_m->con_paradas_ruta($eCodRuta);
        $data['todas']      = $this->transporte_m->con_paradas(false, false, 'AC');

        // Construir disponibles (todas menos asignadas)
        $idsAsignadas = array();
        foreach ($data['asignadas'] as $p) { $idsAsignadas[] = (int)$p->eCodParada; }
        $disponibles = array();
        foreach ($data['todas'] as $p) { if (!in_array((int)$p->eCodParada, $idsAsignadas)) { $disponibles[] = $p; } }
        $data['disponibles'] = $disponibles;

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/ruta_paradas', $data);
    }

    public function guardar_ruta_paradas(){
        $eCodRuta = (int)$this->input->post('eCodRuta');
        $aParadas = $this->input->post('eCodParada');

        if (!$eCodRuta) { redirect('Transporte/m4_s1'); return; }

        $aParadas = is_array($aParadas) ? array_map('intval', $aParadas) : array();
        $aRes = $this->transporte_m->set_ruta_paradas($eCodRuta, $aParadas);
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Paradas asignadas a la ruta.' : 'Error al asignar paradas.');
        redirect('Transporte/asignar_paradas/'.$eCodRuta);
    }

    public function guardar_ruta(){
        $tNombre  = trim($this->input->post('tNombre'));
        $tCodigo  = trim($this->input->post('tCodigo'));
        $tColor   = trim($this->input->post('tColor'));
        $tSentido = trim($this->input->post('tSentido'));

        if (!$tNombre) {
            $this->session->set_flashdata('mensaje', 'Error: El nombre de la ruta es requerido.');
            redirect('Transporte/m4_s1');
            return;
        }

        $aDatos = array(
            'tNombre'     => $tNombre,
            'tCodigo'     => $tCodigo,
            'tColor'      => $tColor,
            'tSentido'    => $tSentido,
            'tCodEstatus' => 'AC'
        );
        $aRes = $this->transporte_m->ins_ruta($aDatos);
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Ruta guardada correctamente.' : 'Error al guardar la ruta.');
        redirect('Transporte/m4_s1');
    }

    public function actualizar_ruta(){
        $eCodRuta = (int)$this->input->post('eCodRuta');
        $tNombre  = trim($this->input->post('tNombre'));
        $tCodigo  = trim($this->input->post('tCodigo'));
        $tColor   = trim($this->input->post('tColor'));
        $tSentido = trim($this->input->post('tSentido'));

        if (!$eCodRuta || !$tNombre) {
            $this->session->set_flashdata('mensaje', 'Error: Ruta o nombre inválido.');
            redirect('Transporte/m4_s1');
            return;
        }
        $aRes = $this->transporte_m->upd_ruta(array(
            'eCodRuta' => $eCodRuta,
            'tNombre'  => $tNombre,
            'tCodigo'  => $tCodigo,
            'tColor'   => $tColor,
            'tSentido' => $tSentido
        ));
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Ruta actualizada.' : 'Error al actualizar la ruta.');
        redirect('Transporte/m4_s1');
    }

    public function estatus_ruta(){
        $eCodRuta    = (int)$this->input->post('eCodRuta');
        $tCodEstatus = trim($this->input->post('tCodEstatus')) ?: 'EL';
        if (!$eCodRuta) { redirect('Transporte/m4_s1'); return; }
        $aRes = $this->transporte_m->upd_ruta_estatus(array(
            'eCodRuta'    => $eCodRuta,
            'tCodEstatus' => $tCodEstatus
        ));
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Estatus de ruta actualizado.' : 'Error al actualizar estatus de ruta.');
        redirect('Transporte/m4_s1');
    }

    // Administración de Paradas
    public function m4_s2() {
        $data['tTituloPagina'] = 'Transporte - Paradas';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s2');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s2');
        $data['con_paradas']   = $this->transporte_m->con_paradas();

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/paradas', $data);
    }

    // Administración de Horarios (Trips/Stop Times)
    public function m4_s3() {
        $data['tTituloPagina'] = 'Transporte - Horarios';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s3');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s3');
        // Solo mostrar viajes activos en el listado
        $data['con_viajes']    = $this->transporte_m->con_viajes(false, false, false, 'AC');

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/horarios', $data);
    }

    // Nuevo viaje (formulario)
    public function nuevo_viaje(){
        $data['tTituloPagina'] = 'Transporte - Nuevo Viaje';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s3');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s3');

        $data['con_rutas']     = $this->transporte_m->con_rutas(false, 'AC');
        $data['con_servicios'] = $this->transporte_m->con_servicios(false, 'AC');

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/viaje_nuevo', $data);
    }

    // Guardar viaje
    public function guardar_viaje(){
        $eCodRuta     = (int)$this->input->post('eCodRuta');
        $eCodServicio = (int)$this->input->post('eCodServicio');
        $tNombre      = trim($this->input->post('tNombre'));
        $tSentido     = trim($this->input->post('tSentido'));

        if (!$eCodRuta || !$eCodServicio) {
            $this->session->set_flashdata('mensaje', 'Error: Ruta y servicio son requeridos.');
        redirect('Administracion_de_transportes/nuevo_viaje');
            return;
        }

        $aRes = $this->transporte_m->ins_viaje(array(
            'eCodRuta'     => $eCodRuta,
            'eCodServicio' => $eCodServicio,
            'tNombre'      => $tNombre,
            'tSentido'     => $tSentido,
            'tCodEstatus'  => 'AC'
        ));
        if ($aRes['eExito']) {
            $this->session->set_flashdata('mensaje', 'Viaje creado.');
            redirect('Transporte/editar_viaje/'.$aRes['eCodViaje']);
        } else {
            $this->session->set_flashdata('mensaje', 'Error al crear el viaje.');
            redirect('Transporte/m4_s3');
        }
    }

    // Editar tiempos por parada de un viaje
    public function editar_viaje($eCodViaje){
        $eCodViaje = (int)$eCodViaje;
        if (!$eCodViaje) { redirect('Transporte/m4_s3'); return; }

        $data['tTituloPagina'] = 'Transporte - Editar Viaje';
        $data['con_seccion']   = $this->secciones_m->con_secciones(false, false, 'm4_s3');
        $data['con_menu']      = $this->secciones_m->con_menu($this->session->userdata('eCodPerfil'));
        $data['con_permisos']  = $this->secciones_m->con_perfilpermiso($this->session->userdata('eCodPerfil'), 'm4_s3');

        $aViaje = $this->transporte_m->con_viajes($eCodViaje);
        $data['viaje'] = is_array($aViaje) && count($aViaje)>0 ? $aViaje[0] : null;
        if (!$data['viaje']) { $this->session->set_flashdata('mensaje','Viaje no encontrado.'); redirect('Transporte/m4_s3'); return; }

        // Paradas asignadas a la ruta de este viaje
        $data['paradas'] = $this->transporte_m->con_paradas_ruta($data['viaje']->eCodRuta);
        // Tiempos actuales
        $data['tiempos'] = $this->transporte_m->con_tiemposparada($eCodViaje);

        $this->load->view('Encabezado/header', $data);
        $this->load->view('Encabezado/menu');
        $this->load->view('Transporte/viaje_editar', $data);
    }

    // Guardar tiempos
    public function guardar_tiempos_parada(){
        $eCodViaje = (int)$this->input->post('eCodViaje');
        $aParadas  = $this->input->post('eCodParada');
        $aLlegadas = $this->input->post('fhHoraLlegada');
        $aSalidas  = $this->input->post('fhHoraSalida');

        if (!$eCodViaje) { redirect('Transporte/m4_s3'); return; }

        $aTiempos = array();
        $bErrorFormato = false;
        $bErrorCoherencia = false;
        $lastSalidaSec = null;
        if (is_array($aParadas) && is_array($aLlegadas) && is_array($aSalidas)){
            $n = min(count($aParadas), count($aLlegadas), count($aSalidas));
            for ($i=0; $i<$n; $i++){
                $parada  = (int)$aParadas[$i];
                $llegada = trim($aLlegadas[$i]);
                $salida  = trim($aSalidas[$i]);
                if ($parada>0 && $llegada && $salida){
                    if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $llegada)) { $bErrorFormato = true; break; }
                    if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $salida))  { $bErrorFormato = true; break; }
                    // Normalizar a HH:MM:SS
                    $llegada = strlen($llegada)==5 ? ($llegada.':00') : $llegada;
                    $salida  = strlen($salida)==5 ? ($salida.':00') : $salida;

                    // Validación de coherencia: salida >= llegada y llegada >= última salida
                    list($lh, $lm, $ls) = array_map('intval', explode(':', $llegada));
                    list($sh, $sm, $ss) = array_map('intval', explode(':', $salida));
                    $llegadaSec = $lh*3600 + $lm*60 + $ls;
                    $salidaSec  = $sh*3600 + $sm*60 + $ss;
                    if ($salidaSec < $llegadaSec) { $bErrorCoherencia = true; break; }
                    if ($lastSalidaSec !== null && $llegadaSec < $lastSalidaSec) { $bErrorCoherencia = true; break; }

                    $aTiempos[] = array(
                        'eCodParada'    => $parada,
                        'fhHoraLlegada' => $llegada,
                        'fhHoraSalida'  => $salida
                    );
                    $lastSalidaSec = $salidaSec;
                }
            }
        }
        if ($bErrorFormato) {
            $this->session->set_flashdata('mensaje', 'Error: Formato de hora inválido. Use HH:MM (00:00 a 23:59).');
            redirect('Transporte/editar_viaje/'.$eCodViaje);
            return;
        }
        if ($bErrorCoherencia) {
            $this->session->set_flashdata('mensaje', 'Error: Inconsistencia de horarios. La salida debe ser >= llegada y las llegadas deben ser no decrecientes.');
            redirect('Transporte/editar_viaje/'.$eCodViaje);
            return;
        }

        $aRes = $this->transporte_m->set_tiemposparada($eCodViaje, $aTiempos);
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Tiempos guardados.' : 'Error al guardar tiempos.');
        redirect('Transporte/editar_viaje/'.$eCodViaje);
    }

    // Actualiza información básica del viaje (nombre/sentido)
    public function actualizar_viaje(){
        $eCodViaje = (int)$this->input->post('eCodViaje');
        $tNombre   = trim($this->input->post('tNombre'));
        $tSentido  = trim($this->input->post('tSentido'));
        if (!$eCodViaje) { redirect('Transporte/m4_s3'); return; }

        $aRes = $this->transporte_m->upd_viaje(array(
            'eCodViaje' => $eCodViaje,
            'tNombre'   => $tNombre,
            'tSentido'  => $tSentido
        ));
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Viaje actualizado.' : 'Error al actualizar el viaje.');
        redirect('Transporte/editar_viaje/'.$eCodViaje);
    }

    // Cambio de estatus de viaje
    public function estatus_viaje(){
        $eCodViaje   = (int)$this->input->post('eCodViaje');
        $tCodEstatus = trim($this->input->post('tCodEstatus')) ?: 'EL';
        if (!$eCodViaje) { redirect('Transporte/m4_s3'); return; }
        $aRes = $this->transporte_m->upd_viaje_estatus(array(
            'eCodViaje'   => $eCodViaje,
            'tCodEstatus' => $tCodEstatus
        ));
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Estatus de viaje actualizado.' : 'Error al actualizar estatus de viaje.');
        redirect('Transporte/m4_s3');
    }

    public function guardar_parada(){
        $tNombre    = trim($this->input->post('tNombre'));
        $tDireccion = trim($this->input->post('tDireccion'));
        $tSentido   = trim($this->input->post('tSentido'));
        $dLatitud   = $this->input->post('dLatitud');
        $dLongitud  = $this->input->post('dLongitud');

        if (!$tNombre || !is_numeric($dLatitud) || !is_numeric($dLongitud)) {
            $this->session->set_flashdata('mensaje', 'Error: Nombre y coordenadas válidas son requeridos.');
            redirect('Transporte/m4_s2');
            return;
        }

        $aRes = $this->transporte_m->ins_parada(array(
            'tNombre'    => $tNombre,
            'tDireccion' => $tDireccion,
            'tSentido'   => $tSentido,
            'dLatitud'   => (float)$dLatitud,
            'dLongitud'  => (float)$dLongitud,
            'tCodEstatus'=> 'AC'
        ));
        if (!empty($aRes['eExito'])) {
            // eCodEvento 3: Alta de parada (creación/actualización)
            $this->inserts_m->ins_log(array(
                'eCodEvento' => 3,
                'tEvento'    => 'Parada creada: ' . $tNombre . ' (ID: ' . $aRes['eCodParada'] . ')'
            ));
        }
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Parada guardada correctamente.' : 'Error al guardar la parada.');
        redirect('Transporte/m4_s2');
    }

    public function actualizar_parada(){
        $eCodParada = (int)$this->input->post('eCodParada');
        $tNombre    = trim($this->input->post('tNombre'));
        $tDireccion = trim($this->input->post('tDireccion'));
        $tSentido   = trim($this->input->post('tSentido'));
        $dLatitud   = $this->input->post('dLatitud');
        $dLongitud  = $this->input->post('dLongitud');

        if (!$eCodParada || !$tNombre || !is_numeric($dLatitud) || !is_numeric($dLongitud)) {
            $this->session->set_flashdata('mensaje', 'Error: Parada, nombre y coordenadas válidas son requeridos.');
            redirect('Transporte/m4_s2');
            return;
        }

        $aRes = $this->transporte_m->upd_parada(array(
            'eCodParada' => $eCodParada,
            'tNombre'    => $tNombre,
            'tDireccion' => $tDireccion,
            'tSentido'   => $tSentido,
            'dLatitud'   => (float)$dLatitud,
            'dLongitud'  => (float)$dLongitud
        ));
        if (!empty($aRes['eExito'])) {
            // eCodEvento 3: Alta de parada (creación/actualización)
            $this->inserts_m->ins_log(array(
                'eCodEvento' => 3,
                'tEvento'    => 'Parada actualizada: ' . $tNombre . ' (ID: ' . $eCodParada . ')'
            ));
        }
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Parada actualizada.' : 'Error al actualizar la parada.');
        redirect('Transporte/m4_s2');
    }

    public function estatus_parada(){
        $eCodParada  = (int)$this->input->post('eCodParada');
        $tCodEstatus = trim($this->input->post('tCodEstatus')) ?: 'EL';
        if (!$eCodParada) { redirect('Transporte/m4_s2'); return; }
        $aRes = $this->transporte_m->upd_parada_estatus(array(
            'eCodParada' => $eCodParada,
            'tCodEstatus'=> $tCodEstatus
        ));
        if (!empty($aRes['eExito'])) {
            // Obtener nombre de la parada para el mensaje
            $aParada = $this->transporte_m->con_paradas($eCodParada);
            $tNombreParada = (is_array($aParada) && count($aParada)>0) ? $aParada[0]->tNombre : ('Parada '.$eCodParada);
            $tMensaje = ($tCodEstatus === 'EL')
                ? ('Parada eliminada: ' . $tNombreParada . ' (ID: ' . $eCodParada . ')')
                : ('Parada estatus actualizado a ' . $tCodEstatus . ': ' . $tNombreParada . ' (ID: ' . $eCodParada . ')');
            // eCodEvento 3: Alta/actualización de parada (también usamos para cambios de estatus)
            $this->inserts_m->ins_log(array(
                'eCodEvento' => 3,
                'tEvento'    => $tMensaje
            ));
        }
        $this->session->set_flashdata('mensaje', $aRes['eExito'] ? 'Estatus de parada actualizado.' : 'Error al actualizar estatus de parada.');
        redirect('Transporte/m4_s2');
    }
}
?>

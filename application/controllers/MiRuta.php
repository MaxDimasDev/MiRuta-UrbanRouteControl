<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MiRuta extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('Transporte_m');
    }

    // Página pública principal: planear ruta
    public function index(){
        $data['tTituloPagina'] = 'MiRuta - Planear ruta';
        $data['con_paradas']   = $this->Transporte_m->con_paradas(false, false, 'AC');
        $data['con_rutas']     = $this->Transporte_m->con_rutas(false, 'AC');
        // Vista pública autónoma: solo cargamos la vista independiente
        $this->load->view('Principal/miruta', $data);
    }

    // AJAX: sugerencias de rutas entre origen y destino
    public function plan(){
        $origen = (int)$this->input->post('eCodParadaOrigen');
        $dest   = (int)$this->input->post('eCodParadaDestino');
        $res    = array('eExito'=>false, 'sugerencias'=>array());

        if ($origen>0 && $dest>0) {
            $res['sugerencias'] = $this->Transporte_m->con_rutas_entre_paradas($origen, $dest);
            $res['eExito'] = true;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }

    // AJAX: paradas ordenadas de una ruta para trazar en mapa
    public function linea(){
        $ruta = (int)$this->input->post('eCodRuta');
        $res  = array('eExito'=>false, 'paradas'=>array());
        if ($ruta>0) {
            $res['paradas'] = $this->Transporte_m->con_paradas_ruta($ruta);
            $res['eExito']  = true;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }

    // AJAX: horarios de viajes de una ruta (resumen inicio/fin)
    public function horarios(){
        $ruta = (int)$this->input->post('eCodRuta');
        $res  = array('eExito'=>false, 'viajes'=>array());
        if ($ruta>0) {
            $viajes = $this->Transporte_m->con_viajes(false, $ruta, false, 'AC');
            $out = array();
            foreach ($viajes as $v) {
                $tiempos = $this->Transporte_m->con_tiemposparada($v->eCodViaje);
                $primero = (is_array($tiempos) && count($tiempos)>0) ? $tiempos[0] : null;
                $ultimo  = (is_array($tiempos) && count($tiempos)>0) ? $tiempos[count($tiempos)-1] : null;
                $out[] = array(
                    'eCodViaje' => (int)$v->eCodViaje,
                    'tNombre'   => $v->tNombre,
                    'tSentido'  => $v->tSentido,
                    'tServicio' => $v->tServicio,
                    'fhInicio'  => ($primero ? $primero->fhHoraSalida : null),
                    'fhFin'     => ($ultimo ? $ultimo->fhHoraLlegada : null),
                    'nParadas'  => (is_array($tiempos) ? count($tiempos) : 0)
                );
            }
            $res['viajes'] = $out;
            $res['eExito'] = true;
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }
}
?>
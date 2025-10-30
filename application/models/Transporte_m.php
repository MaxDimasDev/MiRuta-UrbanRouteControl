<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transporte_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    // Consulta de rutas
    public function con_rutas($eCodRuta=false, $tCodEstatus=false){
        if (!$this->db->table_exists('cat_rutas')) { return array(); }

        $tQuery = "\n            SELECT\n                cr.*,\n                ces.tNombre AS tEstatus\n            FROM cat_rutas cr\n            LEFT JOIN cat_estatus ces ON ces.tCodEstatus = cr.tCodEstatus\n            WHERE 1=1\n        ";

        if ($tCodEstatus) {
            $aStatus = array_map(function($s){ return $this->db->escape(trim($s)); }, explode(',', $tCodEstatus));
            $tQuery .= " AND cr.tCodEstatus IN (".implode(',', $aStatus).")";
        } else {
            $tQuery .= " AND cr.tCodEstatus IN ('AC','EL','CA')";
        }
        if ($eCodRuta) {
            $tQuery .= " AND cr.eCodRuta IN (".$eCodRuta.")";
        }
        $tQuery .= " ORDER BY cr.eCodRuta ASC";

        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Consulta de paradas, opcionalmente filtrado por ruta
    public function con_paradas($eCodParada=false, $eCodRuta=false, $tCodEstatus=false){
        if (!$this->db->table_exists('cat_paradas')) { return array(); }

        $tQuery = "\n            SELECT\n                cp.*,\n                ces.tNombre AS tEstatus\n            FROM cat_paradas cp\n            LEFT JOIN cat_estatus ces ON ces.tCodEstatus = cp.tCodEstatus\n        ";

        // Join a la relación ruta-parada si se filtra por ruta y existe la tabla
        if ($eCodRuta && $this->db->table_exists('rel_rutasparadas')) {
            $tQuery .= " INNER JOIN rel_rutasparadas rrp ON rrp.eCodParada = cp.eCodParada";
        }

        $tQuery .= " WHERE 1=1";
        if ($tCodEstatus) {
            $aStatus = array_map(function($s){ return $this->db->escape(trim($s)); }, explode(',', $tCodEstatus));
            $tQuery .= " AND cp.tCodEstatus IN (".implode(',', $aStatus).")";
        } else {
            $tQuery .= " AND cp.tCodEstatus IN ('AC','EL','CA')";
        }
        if ($eCodParada) {
            $tQuery .= " AND cp.eCodParada IN (".$eCodParada.")";
        }
        if ($eCodRuta && $this->db->table_exists('rel_rutasparadas')) {
            $tQuery .= " AND rrp.eCodRuta IN (".$eCodRuta.")";
        }
        $tQuery .= " ORDER BY cp.eCodParada ASC";

        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Consulta de viajes (horarios por ruta/servicio)
    public function con_viajes($eCodViaje=false, $eCodRuta=false, $eCodServicio=false, $tCodEstatus=false){
        if (!$this->db->table_exists('pro_viajes')) { return array(); }

        $tQuery = "\n            SELECT\n                pv.*,\n                cr.tNombre AS tRuta,\n                cs.tNombre AS tServicio,\n                ces.tNombre AS tEstatus\n            FROM pro_viajes pv\n            LEFT JOIN cat_rutas cr ON cr.eCodRuta = pv.eCodRuta\n            LEFT JOIN pro_servicios cs ON cs.eCodServicio = pv.eCodServicio\n            LEFT JOIN cat_estatus ces ON ces.tCodEstatus = pv.tCodEstatus\n            WHERE 1=1\n        ";
        if ($tCodEstatus) {
            $aStatus = array_map(function($s){ return $this->db->escape(trim($s)); }, explode(',', $tCodEstatus));
            $tQuery .= " AND pv.tCodEstatus IN (".implode(',', $aStatus).")";
        } else {
            $tQuery .= " AND pv.tCodEstatus IN ('AC','EL','CA')";
        }
        if ($eCodViaje)    { $tQuery .= " AND pv.eCodViaje IN (".$eCodViaje.")"; }
        if ($eCodRuta)     { $tQuery .= " AND pv.eCodRuta IN (".$eCodRuta.")"; }
        if ($eCodServicio) { $tQuery .= " AND pv.eCodServicio IN (".$eCodServicio.")"; }
        $tQuery .= " ORDER BY pv.eCodViaje ASC";

        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Consulta de tiempos por parada dentro de un viaje
    public function con_tiemposparada($eCodViaje=false){
        if (!$this->db->table_exists('pro_tiemposparada')) { return array(); }

        $tQuery = "
            SELECT
                ptp.*,
                cp.tNombre AS tParada
            FROM pro_tiemposparada ptp
            LEFT JOIN cat_paradas cp ON cp.eCodParada = ptp.eCodParada
            WHERE 1=1
        ";
        $tQuery .= " AND ptp.tCodEstatus IN ('AC','EL','CA')";
        if ($eCodViaje) { $tQuery .= " AND ptp.eCodViaje IN (".$eCodViaje.")"; }
        $tQuery .= " ORDER BY ptp.eOrden ASC";

        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Servicios (calendarios de operación)
    public function con_servicios($eCodServicio=false, $tCodEstatus=false){
        if (!$this->db->table_exists('pro_servicios')) { return array(); }
        $tQuery = "SELECT * FROM pro_servicios WHERE 1=1";
        if ($tCodEstatus) {
            $aStatus = array_map(function($s){ return $this->db->escape(trim($s)); }, explode(',', $tCodEstatus));
            $tQuery .= " AND tCodEstatus IN (".implode(',', $aStatus).")";
        } else {
            $tQuery .= " AND tCodEstatus IN ('AC','EL','CA')";
        }
        if ($eCodServicio) { $tQuery .= " AND eCodServicio IN (".$eCodServicio.")"; }
        $tQuery .= " ORDER BY eCodServicio ASC";
        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Alta de viaje
    public function ins_viaje($aDatos){
        if (!$this->db->table_exists('pro_viajes')) { return array('eExito'=>false); }
        $data = array(
            'eCodRuta'    => isset($aDatos['eCodRuta']) ? (int)$aDatos['eCodRuta'] : null,
            'eCodServicio'=> isset($aDatos['eCodServicio']) ? (int)$aDatos['eCodServicio'] : null,
            'tNombre'     => isset($aDatos['tNombre']) ? $aDatos['tNombre'] : null,
            'tSentido'    => isset($aDatos['tSentido']) ? $aDatos['tSentido'] : null,
            'tCodEstatus' => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'AC'
        );
        $this->db->insert('pro_viajes', $data);
        $aRes['eExito']    = ($this->db->affected_rows() == 1);
        $aRes['eCodViaje'] = $this->db->insert_id();
        return $aRes;
    }

    // Actualización de viaje
    public function upd_viaje($aDatos){
        if (!$this->db->table_exists('pro_viajes')) { return array('eExito'=>false); }
        // Construir solo campos presentes para no forzar NULL en NOT NULL
        $data = array();
        if (array_key_exists('eCodRuta', $aDatos))     { $data['eCodRuta']     = (int)$aDatos['eCodRuta']; }
        if (array_key_exists('eCodServicio', $aDatos)) { $data['eCodServicio'] = (int)$aDatos['eCodServicio']; }
        if (array_key_exists('tNombre', $aDatos))      { $data['tNombre']      = $aDatos['tNombre']; }
        if (array_key_exists('tSentido', $aDatos))     { $data['tSentido']     = $aDatos['tSentido']; }
        $this->db->where('eCodViaje', $aDatos['eCodViaje']);
        $aRes['eExito']     = ($this->db->update('pro_viajes', $data) ? true : false);
        $aRes['eCodViaje']  = $aDatos['eCodViaje'];
        return $aRes;
    }

    // Cambio de estatus de viaje
    public function upd_viaje_estatus($aDatos){
        if (!$this->db->table_exists('pro_viajes')) { return array('eExito'=>false); }
        $data = array(
            'tCodEstatus' => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'EL'
        );
        $this->db->where('eCodViaje', $aDatos['eCodViaje']);
        $aRes['eExito']     = ($this->db->update('pro_viajes', $data) ? true : false);
        $aRes['eCodViaje']  = $aDatos['eCodViaje'];
        return $aRes;
    }

    // Reemplaza tiempos por parada para un viaje
    public function set_tiemposparada($eCodViaje, $aTiempos){
        if (!$this->db->table_exists('pro_tiemposparada')) { return array('eExito'=>false); }
        $eCodViaje = (int)$eCodViaje;
        if (!$eCodViaje) { return array('eExito'=>false); }

        $this->db->trans_start();
        $this->db->where('eCodViaje', $eCodViaje)->delete('pro_tiemposparada');

        if (is_array($aTiempos)) {
            $orden = 1;
            foreach ($aTiempos as $t) {
                // Espera arreglo: ['eCodParada'=>int, 'fhHoraLlegada'=>"HH:MM:SS", 'fhHoraSalida'=>"HH:MM:SS"]
                $idParada = isset($t['eCodParada']) ? (int)$t['eCodParada'] : 0;
                $llegada  = isset($t['fhHoraLlegada']) ? $t['fhHoraLlegada'] : null;
                $salida   = isset($t['fhHoraSalida']) ? $t['fhHoraSalida'] : null;
                if ($idParada>0 && $llegada && $salida) {
                    $this->db->insert('pro_tiemposparada', array(
                        'eCodViaje'     => $eCodViaje,
                        'eCodParada'    => $idParada,
                        'fhHoraLlegada' => $llegada,
                        'fhHoraSalida'  => $salida,
                        'eOrden'        => $orden++,
                        'tCodEstatus'   => 'AC'
                    ));
                }
            }
        }

        $this->db->trans_complete();
        $eExito = $this->db->trans_status();
        return array('eExito'=>$eExito, 'eCodViaje'=>$eCodViaje);
    }

    // Paradas asignadas a una ruta con orden
    public function con_paradas_ruta($eCodRuta){
        if (!$this->db->table_exists('rel_rutasparadas') || !$this->db->table_exists('cat_paradas')) { return array(); }
        $eCodRuta = (int)$eCodRuta;
        if (!$eCodRuta) { return array(); }
        $tQuery = "
            SELECT
                cp.*,
                rrp.eOrden
            FROM rel_rutasparadas rrp
            INNER JOIN cat_paradas cp ON cp.eCodParada = rrp.eCodParada
            WHERE rrp.eCodRuta IN (".$eCodRuta.")
            ORDER BY rrp.eOrden ASC
        ";
        $rs = $this->db->query($tQuery);
        return ($rs && $rs->num_rows()>0) ? $rs->result() : array();
    }

    // Reemplaza asignación de paradas para una ruta (con orden)
    public function set_ruta_paradas($eCodRuta, $aParadas){
        if (!$this->db->table_exists('rel_rutasparadas')) { return array('eExito'=>false); }
        $eCodRuta = (int)$eCodRuta;
        if (!$eCodRuta) { return array('eExito'=>false); }

        $this->db->trans_start();
        $this->db->where('eCodRuta', $eCodRuta)->delete('rel_rutasparadas');

        if (is_array($aParadas)) {
            $orden = 1;
            foreach ($aParadas as $idParada) {
                $idParada = (int)$idParada;
                if ($idParada>0) {
                    $this->db->insert('rel_rutasparadas', array(
                        'eCodRuta'   => $eCodRuta,
                        'eCodParada' => $idParada,
                        'eOrden'     => $orden++
                    ));
                }
            }
        }

        $this->db->trans_complete();
        $eExito = $this->db->trans_status();
        return array('eExito'=>$eExito, 'eCodRuta'=>$eCodRuta);
    }
    // Alta de ruta
    public function ins_ruta($aDatos){
        if (!$this->db->table_exists('cat_rutas')) { return array('eExito'=>false); }
        $data = array(
            'tNombre'         => isset($aDatos['tNombre']) ? $aDatos['tNombre'] : null,
            'tCodigo'         => isset($aDatos['tCodigo']) ? $aDatos['tCodigo'] : null,
            'tColor'          => isset($aDatos['tColor']) ? $aDatos['tColor'] : null,
            'tSentido'        => isset($aDatos['tSentido']) ? $aDatos['tSentido'] : null,
            'tCodEstatus'     => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'AC',
            'fhFechaRegistro' => date('Y-m-d H:i:s')
        );
        $this->db->insert('cat_rutas', $data);
        $aRes['eExito']   = ($this->db->affected_rows() == 1);
        $aRes['eCodRuta'] = $this->db->insert_id();
        return $aRes;
    }

    // Actualización de ruta
    public function upd_ruta($aDatos){
        if (!$this->db->table_exists('cat_rutas')) { return array('eExito'=>false); }
        $data = array(
            'tNombre'              => isset($aDatos['tNombre']) ? $aDatos['tNombre'] : null,
            'tCodigo'              => isset($aDatos['tCodigo']) ? $aDatos['tCodigo'] : null,
            'tColor'               => isset($aDatos['tColor']) ? $aDatos['tColor'] : null,
            'tSentido'             => isset($aDatos['tSentido']) ? $aDatos['tSentido'] : null,
            'fhFechaActualizacion' => date('Y-m-d H:i:s')
        );
        $this->db->where('eCodRuta', $aDatos['eCodRuta']);
        $aRes['eExito']   = ($this->db->update('cat_rutas', $data) ? true : false);
        $aRes['eCodRuta'] = $aDatos['eCodRuta'];
        return $aRes;
    }

    // Cambio de estatus de ruta
    public function upd_ruta_estatus($aDatos){
        if (!$this->db->table_exists('cat_rutas')) { return array('eExito'=>false); }
        $data = array(
            'tCodEstatus'          => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'EL',
            'fhFechaActualizacion' => date('Y-m-d H:i:s')
        );
        $this->db->where('eCodRuta', $aDatos['eCodRuta']);
        $aRes['eExito']   = ($this->db->update('cat_rutas', $data) ? true : false);
        $aRes['eCodRuta'] = $aDatos['eCodRuta'];
        return $aRes;
    }

    // Alta de parada
    public function ins_parada($aDatos){
        if (!$this->db->table_exists('cat_paradas')) { return array('eExito'=>false); }
        $data = array(
            'tNombre'         => isset($aDatos['tNombre']) ? $aDatos['tNombre'] : null,
            'tDireccion'      => isset($aDatos['tDireccion']) ? $aDatos['tDireccion'] : null,
            'tSentido'        => isset($aDatos['tSentido']) ? $aDatos['tSentido'] : null,
            'dLatitud'        => isset($aDatos['dLatitud']) ? $aDatos['dLatitud'] : null,
            'dLongitud'       => isset($aDatos['dLongitud']) ? $aDatos['dLongitud'] : null,
            'tCodEstatus'     => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'AC',
            'fhFechaRegistro' => date('Y-m-d H:i:s')
        );
        $this->db->insert('cat_paradas', $data);
        $aRes['eExito']     = ($this->db->affected_rows() == 1);
        $aRes['eCodParada'] = $this->db->insert_id();
        return $aRes;
    }

    // Actualización de parada
    public function upd_parada($aDatos){
        if (!$this->db->table_exists('cat_paradas')) { return array('eExito'=>false); }
        $data = array(
            'tNombre'              => isset($aDatos['tNombre']) ? $aDatos['tNombre'] : null,
            'tDireccion'           => isset($aDatos['tDireccion']) ? $aDatos['tDireccion'] : null,
            'tSentido'             => isset($aDatos['tSentido']) ? $aDatos['tSentido'] : null,
            'dLatitud'             => isset($aDatos['dLatitud']) ? $aDatos['dLatitud'] : null,
            'dLongitud'            => isset($aDatos['dLongitud']) ? $aDatos['dLongitud'] : null,
            'fhFechaActualizacion' => date('Y-m-d H:i:s')
        );
        $this->db->where('eCodParada', $aDatos['eCodParada']);
        $aRes['eExito']     = ($this->db->update('cat_paradas', $data) ? true : false);
        $aRes['eCodParada'] = $aDatos['eCodParada'];
        return $aRes;
    }

    // Cambio de estatus de parada
    public function upd_parada_estatus($aDatos){
        if (!$this->db->table_exists('cat_paradas')) { return array('eExito'=>false); }
        $data = array(
            'tCodEstatus'          => isset($aDatos['tCodEstatus']) ? $aDatos['tCodEstatus'] : 'EL',
            'fhFechaActualizacion' => date('Y-m-d H:i:s')
        );
        $this->db->where('eCodParada', $aDatos['eCodParada']);
        $aRes['eExito']     = ($this->db->update('cat_paradas', $data) ? true : false);
        $aRes['eCodParada'] = $aDatos['eCodParada'];
        return $aRes;
    }

    // Sugerir rutas que pasan por origen y destino (en cualquier sentido)
    public function con_rutas_entre_paradas($eCodParadaOrigen, $eCodParadaDestino){
        // Validar tablas necesarias
        if (!$this->db->table_exists('cat_rutas') || !$this->db->table_exists('rel_rutasparadas')) { return array(); }

        $eCodParadaOrigen  = (int)$eCodParadaOrigen;
        $eCodParadaDestino = (int)$eCodParadaDestino;
        if (!$eCodParadaOrigen || !$eCodParadaDestino) { return array(); }

        $tQuery = "
            SELECT
                cr.eCodRuta,
                cr.tNombre,
                cr.tCodigo,
                cr.tColor,
                cr.tSentido,
                rrp1.eOrden AS eOrdenOrigen,
                rrp2.eOrden AS eOrdenDestino
            FROM cat_rutas cr
            INNER JOIN rel_rutasparadas rrp1 ON rrp1.eCodRuta = cr.eCodRuta
            INNER JOIN rel_rutasparadas rrp2 ON rrp2.eCodRuta = cr.eCodRuta
            WHERE 1=1
              AND cr.tCodEstatus IN ('AC')
              AND rrp1.eCodParada = " . $this->db->escape($eCodParadaOrigen) . "
              AND rrp2.eCodParada = " . $this->db->escape($eCodParadaDestino) . "
            ORDER BY cr.eCodRuta ASC
        ";

        $rs = $this->db->query($tQuery);
        $aRutas = ($rs && $rs->num_rows()>0) ? $rs->result() : array();

        // Adjuntar indicador de dirección sugerida (simple) según el orden de paradas
        foreach ($aRutas as &$r) {
            $r->tDireccionSugerida = ($r->eOrdenOrigen <= $r->eOrdenDestino) ? 'Origen → Destino' : 'Destino → Origen';
        }
        unset($r);

        return $aRutas;
    }
}
?>
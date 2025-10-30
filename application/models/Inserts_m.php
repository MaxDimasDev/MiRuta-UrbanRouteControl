<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inserts_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}

    public function ins_log($aDatos) {
        //campos de la tabla
        $data = array(
            'eCodUsuario'       =>  ($this->session->userdata('eCodUsuario')  ? $this->session->userdata('eCodUsuario') : $aDatos['eCodUsuario']),
            'eCodEvento'        =>  ($aDatos['eCodEvento']  ? $aDatos['eCodEvento'] : NULL),
            'tEvento'           =>  ($aDatos['tEvento']     ? $aDatos['tEvento']    : NULL),
            'fhFechaRegistro'   =>  mdate('%Y/%m/%d %H:%i:%s', time()),
            'tCodEstatus'       =>  "AC"
            );
        $this->db->insert('pro_logseventos',$data);

        $aRes['eExito']         = ($this->db->affected_rows() != 1) ? 0 : 1;
        $aRes['eCodLogEvento']  = $this->db->insert_id();

        return $aRes;
    }

}
?>
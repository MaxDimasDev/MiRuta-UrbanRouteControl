<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas_m extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    public function con_items($eCodItem = false, $tNombre = false,$tCodEstatus=false,$eCodTipoItem=false){
        $tQuery = "SELECT ci.eCodItem,	".
        "ci.tNombre, ".
        "cti.tNombre AS tTipoItem, ".
        "cti.eCodTipoItem, ".
        "ci.tDescripcion,  ".
        "ci.dPrecio, ".
        "DATE_FORMAT(ci.fhFechaRegistro,'%d/%m/%Y %H:%i:%s') as fhFechaRegistro, ".
        "ci.tCodEstatus, ".
        "ce.tNombre AS tEstatus, ".
        "ce.tClase ".
        "FROM cat_items ci ".
        "INNER JOIN cat_tipositems cti ON ci.eCodTipoItem = cti.eCodTipoItem ".
        "INNER JOIN cat_estatus ce ON ci.tCodEstatus = ce.tCodEstatus ".
        ($tCodEstatus != false ? " WHERE ci.tCodEstatus IN (".$tCodEstatus.")" : " WHERE ci.tCodEstatus IN ('AC','EL','CA')").
        ($eCodItem != false ? " AND ci.eCodItem = ".$eCodItem  : "").
        ($eCodTipoItem != false ? " AND cti.eCodTipoItem = ".$eCodTipoItem  : "").
        ($tNombre != false         ? " AND ci.tNombre = TRIM('".$tNombre."')"            : " ").
        " ORDER BY ci.eCodItem ASC ";
        //echo "Consulta:<br>".$tQuery;
        //print_r($tQuery);
        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }
}
?>
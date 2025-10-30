<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos_m extends CI_Model {

	function __construct(){
		parent::__construct();

	}

    public function con_usuarios($eCodUsuario = false, $eCodEmpresa = false, $eCodDepartamento = false, $eCodPerfil = false, $tUsuario = false, $tPassword = false, $tCodEstatus = false, $bAdmin = false){
        // Si existe la vista vUsuarios, usarla; de lo contrario, intentar con cat_usuarios.
        $hasView = method_exists($this->db, 'table_exists') ? $this->db->table_exists('vUsuarios') : false;
        $hasUsers = method_exists($this->db, 'table_exists') ? $this->db->table_exists('cat_usuarios') : false;

        if ($hasView) {
            $tQuery = "SELECT * FROM vUsuarios ".
                ($tCodEstatus != false ? " WHERE tCodEstatus IN (".$tCodEstatus.")" : " WHERE tCodEstatus NOT IN ('CA','IN')").
                ($eCodUsuario != false      ? " AND eCodUsuario IN (".$eCodUsuario.")"           : " ").
                ($eCodEmpresa != false      ? " AND eCodEmpresa = ".$eCodEmpresa                 : " ").
                ($eCodDepartamento != false ? " AND eCodDepartamento IN (".$eCodDepartamento.")" : " ").
                ($eCodPerfil != false       ? " AND eCodPerfil IN (".$eCodPerfil.")"             : " ").
                ($tUsuario != false         ? " AND tUsuario = TRIM('".$tUsuario."')"            : " ").
                ($tPassword != false        ? " AND tPassword = '".$tPassword."'"                : " ").
                ($bAdmin != false           ? " AND bAdmin = ".$bAdmin                           : " ").
                                            " ORDER BY eCodUsuario ASC ";
            $query = $this->db->query($tQuery);
            if ($query->num_rows()>0) {
                return $query->result();
            }
            return array();
        }

        if ($hasUsers) {
            // Consulta mínima sobre cat_usuarios para evitar 500 cuando falte vUsuarios
            $tQuery = "SELECT cu.* FROM cat_usuarios cu ".
                ($tCodEstatus != false ? " WHERE cu.tCodEstatus IN (".$tCodEstatus.")" : " WHERE cu.tCodEstatus NOT IN ('CA','IN')").
                ($eCodUsuario != false      ? " AND cu.eCodUsuario IN (".$eCodUsuario.")"           : " ").
                ($eCodEmpresa != false      ? " AND cu.eCodEmpresa = ".$eCodEmpresa                 : " ").
                ($eCodDepartamento != false ? " AND cu.eCodDepartamento IN (".$eCodDepartamento.")" : " ").
                ($eCodPerfil != false       ? " AND cu.eCodPerfil IN (".$eCodPerfil.")"             : " ").
                ($tUsuario != false         ? " AND cu.tUsuario = TRIM('".$tUsuario."')"            : " ").
                ($tPassword != false        ? " AND cu.tPassword = '".$tPassword."'"                : " ").
                ($bAdmin != false           ? " AND cu.bAdmin = ".$bAdmin                           : " ").
                                                " ORDER BY cu.eCodUsuario ASC ";
            $query = $this->db->query($tQuery);
            if ($query->num_rows()>0) {
                return $query->result();
            }
            return array();
        }

        // Si no existe ninguna fuente, devolver vacío para no romper la vista.
        return array();
    }

    public function con_perfiles(){
        $query = $this->db->query(  " SELECT cp.*, ces.tNombre as tEstatus ".
                                    " FROM cat_perfiles cp ".
                                        " LEFT JOIN cat_estatus ces ON ces.tCodEstatus = cp.tCodEstatus ".
                                    " WHERE cp.tCodEstatus = 'AC' ".
                                    " ORDER BY cp.tNombre ASC "
                                );
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_empresas(){
        $query = $this->db->query(  " SELECT ce.*, ces.tNombre as tEstatus ".
                                    " FROM cat_empresas ce ".
                                        " LEFT JOIN cat_estatus ces ON ces.tCodEstatus = ce.tCodEstatus ".
                                    " WHERE ce.tCodEstatus = 'AC' "
                                );
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_tipositems($eCodTipoItem = false) {
        $tQuery = " SELECT cti.*, ces.tNombre as tEstatus ".
        " FROM cat_tipositems cti ".
        " LEFT JOIN cat_estatus ces ON ces.tCodEstatus = cti.tCodEstatus ".
        " WHERE cti.tCodEstatus = 'AC' ".
        ($eCodTipoItem != false ? " AND cti.eCodTipoItem = ".$eCodTipoItem  : "").
        " ORDER BY cti.eCodTipoItem ASC ";
            $query = $this->db->query( $tQuery);
            if ($query->num_rows()>0) {
                return $query->result();
            }
        }

    public function con_departamentos(){
        $tQuery = " SELECT cat_departamentos.*, cat_estatus.tNombre as tEstatus ".
                    " FROM cat_departamentos".
                    " LEFT JOIN cat_estatus ON cat_estatus.tCodEstatus = cat_departamentos.tCodEstatus ".
                    " WHERE cat_departamentos.tCodEstatus = 'AC' ".
                    " ORDER BY cat_departamentos.eCodDepartamento ASC";
        $query = $this->db->query($tQuery);
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_direccionesgenerales(){
        $tQuery = " SELECT cat_direccionesgenerales.*, cat_estatus.tNombre as tEstatus ".
                    " FROM cat_direccionesgenerales".
                    " LEFT JOIN cat_estatus ON cat_estatus.tCodEstatus = cat_direccionesgenerales.tCodEstatus ".
                    " WHERE cat_direccionesgenerales.tCodEstatus = 'AC' ".
                    " ORDER BY cat_direccionesgenerales.eCodDireccionGeneral ASC";
        $query = $this->db->query($tQuery);
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_direccionesareas(){
        $tQuery = " SELECT cat_direccionesareas.*, cat_estatus.tNombre as tEstatus ".
                    " FROM cat_direccionesareas".
                    " LEFT JOIN cat_estatus ON cat_estatus.tCodEstatus = cat_direccionesareas.tCodEstatus ".
                    " WHERE cat_direccionesareas.tCodEstatus = 'AC' ".
                    " ORDER BY cat_direccionesareas.eCodDireccionArea ASC";
        $query = $this->db->query($tQuery);
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_estatus($tCodEstatus = false) {
        $query = $this->db->query(  " SELECT ces.* ".
                                    " FROM cat_estatus ces ".
        ($tCodEstatus != false  ?   " WHERE ces.tCodEstatus = '".$tCodEstatus."'" : "").
                                    " ORDER BY ces.tNombre ASC "
                                );
        if($query->num_rows() > 0 ){
            return $query->result();
        }
    }

    public function con_eventos($aFiltro = false) {
        $aFiltro = is_array($aFiltro) ? $aFiltro : array();
        $tQuery =   " SELECT ce.* " .
                    " FROM cat_eventos ce ";
        $tQuery .=  (isset($aFiltro['eCodEvento']) ? " WHERE ce.eCodEvento = ".((int)$aFiltro['eCodEvento']) : "");
        $tQuery .=  " ORDER BY ce.eCodEvento ASC ";

        $query = $this->db->query($tQuery);
        if ($query->num_rows() > 0 ) {
            return $query->result();
        }
        return array();
    }

    public function con_documentosdigitales($aFiltro = false) {
        $tQuery =   " SELECT cdd.* ".
                    " FROM cat_documentosdigitales cdd ";
        $tQuery .=  (isset($aFiltro['eCodDocumentoDigital']) ? " WHERE cdd.eCodDocumentoDigital IN (".$aFiltro['eCodDocumentoDigital'].")" : "");
        $tQuery .=  " ORDER BY cdd.tNombre ASC ";

        $query = $this->db->query($tQuery);
        if ($query->num_rows() > 0 ) {
            return $query->result();
        }
    }

}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secciones_m extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    public function con_menu($eCodPerfil = false, $eCodSeccion = false) {
        $tQuery =   " SELECT cm.tControlador, cs.tCodSeccion, ".
        " cm.ePosicion as ePosicionModulo, cs.ePosicion as ePosicionSeccion, ".
        " cm.eCodModulo, cs.eCodSeccion, ".
        " cm.tNombreCorto as tModulo, cs.tNombreCorto as tSeccion, ".
        " cm.tNombreCorto as tModuloCorto, cs.tNombreCorto as tSeccionCorto, ".
        " cm.tIcono as tModuloIcono, cs.tIcono as tSeccionIcono ".
    " FROM rel_perfilespermisos rpp ".
        " INNER JOIN cat_perfiles cpf ON cpf.eCodPerfil = rpp.eCodPerfil ".
        " INNER JOIN cat_permisos cp ON cp.eCodPermiso = rpp.eCodPermiso ".
        " INNER JOIN cat_secciones cs ON cs.eCodSeccion = cp.eCodSeccion ".
        " INNER JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo ".
($eCodPerfil != false   ?   " WHERE rpp.eCodPerfil = ".$eCodPerfil   : " ").
($eCodSeccion != false  ?   " AND rpp.eCodSeccion = ".$eCodSeccion   : " ").
    " GROUP BY cs.eCodSeccion ORDER BY ePosicionModulo, ePosicionSeccion ";
    //echo "Consulta<br><br>".$tQuery;
        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_perfilpermiso($eCodPerfil = false, $tCodSeccion = false) {
        $tQuery =  " SELECT cp.* ".
                   " FROM rel_perfilespermisos rpp ".
                   " LEFT JOIN cat_perfiles cpf ON cpf.eCodPerfil = rpp.eCodPerfil ".
                   " LEFT JOIN cat_permisos cp ON cp.eCodPermiso = rpp.eCodPermiso ".
                   " LEFT JOIN cat_secciones cs ON cs.eCodSeccion = cp.eCodSeccion ".
                   " LEFT JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo ".
        ($eCodPerfil != false   ?   " WHERE rpp.eCodPerfil = ".$eCodPerfil       : " ").
        ($tCodSeccion != false  ?   " AND cs.tCodSeccion = '".$tCodSeccion."'"   : " ").
                                    " ORDER BY cp.ePosicion ASC ";
                                    
        //echo "Consulta <br>".$tQuery;
        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_perfilnotificaciones($eCodPerfil = false, $eCodNotificacion = false) {
         $query = $this->db->query( " SELECT cpf.*, rpn.* ".
                                    " FROM rel_perfilesnotificaciones rpn ".
                                        " LEFT JOIN cat_perfiles cpf ON rpn.eCodPerfil = cpf.eCodPerfil ".
                                        " LEFT JOIN cat_secciones cn ON rpn.eCodNotificacion = cn.eCodNotificacion ".
        ($eCodPerfil != false       ?   " WHERE rpn.eCodPerfil = ".$eCodPerfil              : " ").
        ($eCodNotificacion != false ?   " AND rpn.eCodNotificacion = ".$eCodNotificacion    : " ").
                                    " ORDER BY cpf.eCodPerfil ASC ");
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_permisos($eCodPermiso = false, $eCodSeccion = false) {
        $query = $this->db->query(  " SELECT cp.*, cp.tNombre as tPermiso, ".
                                        " cs.eCodSeccion, cs.tCodSeccion, cs.tNombre as tSeccion, ".
                                        " cs.tNombreCorto as tSeccionCorto, cs.tIcono as tSeccionIcono, ".
                                        " cm.eCodModulo, cm.tCodModulo, cm.tNombre as tModulo, ".
                                        " cm.tNombreCorto as tModuloCorto, cm.tIcono as tModuloIcono ".
                                    " FROM cat_permisos cp ".
                                        " LEFT JOIN cat_secciones cs ON cs.eCodSeccion = cp.eCodSeccion ".
                                        " LEFT JOIN cat_modulos cm ON cs.eCodModulo = cm.eCodModulo ".
        ($eCodPermiso != false  ?   " WHERE cp.eCodPermiso = ".$eCodPermiso : " ").
        ($eCodSeccion != false  ?   " WHERE cp.eCodSeccion = ".$eCodSeccion : " "));
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_secciones($eCodSeccion = false, $eCodModulo = false, $tCodSeccion = false) {
        $query = $this->db->query(  " SELECT cs.eCodSeccion, cs.tCodSeccion, cs.tNombre as tSeccion, ".
                                        " cs.tNombreCorto as tSeccionCorto, cs.tIcono as tSeccionIcono, ".
                                        " cm.eCodModulo, cm.tCodModulo, cm.tNombre as tModulo, cm.tControlador, ".
                                        " cm.tNombreCorto as tModuloCorto, cm.tIcono as tModuloIcono ".
                                    " FROM cat_secciones cs ".
                                        " LEFT JOIN cat_modulos cm ON cm.eCodModulo = cs.eCodModulo ".
        ($eCodSeccion != false  ?   " WHERE cs.eCodSeccion = ".$eCodSeccion         : " ").
        ($eCodModulo != false   ?   " WHERE cm.eCodModulo = ".$eCodModulo           : " ").
        ($tCodSeccion != false  ?   " WHERE cs.tCodSeccion = '".$tCodSeccion."'"    : " "));
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_modulos($eCodModulo = false) {
        $query = $this->db->query(  " SELECT cm.* ".
                                    " FROM cat_modulos cm ".
        ($eCodModulo != false   ?   " WHERE cm.eCodModulo = ".$eCodModulo : " "));
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones_m extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function con_correos($aFiltro = false) {
        $tQuery =   " SELECT cc.*, ".
                        " ce.tNombre as tEmpresa ".
                    " FROM cog_correos cc ".
                        " LEFT JOIN cat_empresas ce ON ce.eCodEmpresa = cc.eCodEmpresa ";
        $tQuery .=  (isset($aFiltro['eCodEmpresa']) ? " WHERE cc.eCodEmpresa = ".$aFiltro['eCodEmpresa'] : "");
        $tQuery .=  " ORDER BY cc.eCodCorreo ASC ";

        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_logeventos($aFiltro = false) {
        // Evitar 500 si faltan tablas
        $hasLogs   = method_exists($this->db, 'table_exists') ? $this->db->table_exists('pro_logseventos') : false;
        $hasEvents = method_exists($this->db, 'table_exists') ? $this->db->table_exists('cat_eventos') : false;
        $hasUsers  = method_exists($this->db, 'table_exists') ? $this->db->table_exists('cat_usuarios') : false;

        if (!$hasLogs) {
            return array();
        }

        $tSelect = " SELECT ".
            ($hasUsers ? " cu.tNombre as tUsuario, " : " '' as tUsuario, ").
            " ple.eCodEvento, ple.tEvento, ";
        // Algunas instalaciones no tienen columnas tNombreCorto/tIcono en cat_eventos.
        // Usamos tNombre como corto y omitimos icono para evitar errores.
        $tSelect .= ($hasEvents ? " ce.tNombre as tTipoEvento, ce.tNombre as tTipoEventoCorto, '' as tIconoEvento, " : " '' as tTipoEvento, '' as tTipoEventoCorto, '' as tIconoEvento, ");
        $tSelect .= " DATE_FORMAT(ple.fhFechaRegistro,'%d/%m/%Y %H:%i:%s') as fhFechaRegistro ";

        $tFrom = " FROM pro_logseventos ple ";
        $tFrom .= ($hasEvents ? " LEFT JOIN cat_eventos ce on ce.eCodEvento = ple.eCodEvento " : " ");
        $tFrom .= ($hasUsers  ? " LEFT JOIN cat_usuarios cu on cu.eCodUsuario = ple.eCodUsuario " : " ");

        $tWhere = " WHERE ple.tCodEstatus = 'AC' ";
        $tWhere .= (isset($aFiltro['eCodEvento'])      ? " AND ple.eCodEvento = ".((int)$aFiltro['eCodEvento']) : "");
        $tWhere .= (isset($aFiltro['eCodUsuario'])     ? ($hasUsers ? " AND cu.eCodUsuario = ".((int)$aFiltro['eCodUsuario']) : " AND ple.eCodUsuario = ".((int)$aFiltro['eCodUsuario'])) : "");
        $tWhere .= (isset($aFiltro['tEvento'])         ? " AND ple.tEvento LIKE '%".$this->db->escape_str($aFiltro['tEvento'])."%'" : "");
        $tWhere .= (isset($aFiltro['fhFechaInicio'])   && isset($aFiltro['fhFechaFinal']) ? " AND ple.fhFechaRegistro BETWEEN '".$this->db->escape_str($aFiltro['fhFechaInicio'])." 00:00:00' AND '".$this->db->escape_str($aFiltro['fhFechaFinal'])." 23:59:59'" : "");

        $tOrder = " ORDER BY ple.eCodLogEvento DESC ";

        // Optional limit
        $tLimit = "";
        if (isset($aFiltro['limit'])) {
            $limit = (int)$aFiltro['limit'];
            if ($limit > 0) {
                $tLimit = " LIMIT " . $limit;
            }
        }
        $tQuery = $tSelect.$tFrom.$tWhere.$tOrder.$tLimit;

        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

    public function con_lognotificaciones($aFiltro = false) {
        // Evitar 500 si faltan tablas
        $hasLogs   = method_exists($this->db, 'table_exists') ? $this->db->table_exists('pro_logsnotificaciones') : false;
        $hasTypes  = method_exists($this->db, 'table_exists') ? $this->db->table_exists('cat_notificaciones') : false;
        $hasUsers  = method_exists($this->db, 'table_exists') ? $this->db->table_exists('cat_usuarios') : false;

        if (!$hasLogs) {
            return array();
        }

        $tSelect = " SELECT pln.*, ".
            ($hasUsers ? " cu.tNombre as tUsuario, " : " '' as tUsuario, ").
            " pln.eCodNotificacion, pln.tNotificacion, ";
        $tSelect .= ($hasTypes ? " cn.tNombre as tTipoNotificacion, cn.tNombreCorto as tTipoNotificacionCorto, cn.tCodIcono as tIconoNotificacion, " : " '' as tTipoNotificacion, '' as tTipoNotificacionCorto, '' as tIconoNotificacion, ");
        $tSelect .= " pln.fhFechaRegistro, DATE_FORMAT(pln.fhFechaRegistro,'%d/%m/%Y %H:%i:%s') as fhFechaNotificacion ";

        $tFrom = " FROM pro_logsnotificaciones pln ";
        $tFrom .= ($hasTypes ? " LEFT JOIN cat_notificaciones cn on cn.eCodNotificacion = pln.eCodNotificacion " : " ");
        $tFrom .= ($hasUsers ? " LEFT JOIN cat_usuarios cu on cu.eCodUsuario = pln.eCodUsuario " : " ");

        $tWhere = " WHERE pln.tCodEstatus = 'AC' ";
        $tWhere .= (isset($aFiltro['eCodNotificacion']) ? " AND pln.eCodNotificacion = ".((int)$aFiltro['eCodNotificacion']) : "");
        $tWhere .= (isset($aFiltro['eCodUsuario'])      ? ($hasUsers ? " AND cu.eCodUsuario = ".((int)$aFiltro['eCodUsuario']) : " AND pln.eCodUsuario = ".((int)$aFiltro['eCodUsuario'])) : "");
        $tWhere .= (isset($aFiltro['eCodPerfil'])       ? " AND pln.eCodPerfil = ".((int)$aFiltro['eCodPerfil']) : "");

        $tOrder = " ORDER BY pln.fhFechaRegistro DESC LIMIT 1 ";

        $tQuery = $tSelect.$tFrom.$tWhere.$tOrder;

        $query = $this->db->query($tQuery);
        if ($query->num_rows()>0) {
            return $query->result();
        }
    }

}
?>

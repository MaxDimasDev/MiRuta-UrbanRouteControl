<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Catinserts_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function ins_usuario($aDatos){
        //campos de la tabla
        $data = array(
            'eCodEmpresa'       =>   $aDatos['eCodEmpresa'],
            'eCodDepartamento'  =>   $aDatos['eCodDepartamento'],
            'eCodPerfil'        =>   $aDatos['eCodPerfil'],
            'tNombre'           =>   $aDatos['tNombre'],
            'tCorreo'           =>   $aDatos['tCorreo'],
            'tTelefono'         =>   $aDatos['tTelefono'],
            'tUsuario'          =>   $aDatos['tUsuario'],
            'tPassword'         =>   $aDatos['tPassword'],
            'tPuesto'           =>   $aDatos['tPuesto'],
            'tImagen'           =>   $aDatos['tImagen'],
            'fhFechaRegistro'   =>   $aDatos['fhFechaRegistro'],
            'tCodEstatus'       =>   $aDatos['tCodEstatus']
            );
        $this->db->insert('cat_usuarios',$data);

        $aRes['eExito']         = ($this->db->affected_rows() != 1) ? false : true;
        $aRes['eCodUsuario']    = $this->db->insert_id();

        return $aRes;
    }

    public function upd_usuario($aDatos){
        //campos de la tabla
        $data = array(
            'eCodEmpresa'       =>   $aDatos['eCodEmpresa'],
            'eCodDepartamento'  =>   $aDatos['eCodDepartamento'],
            'eCodPerfil'        =>   $aDatos['eCodPerfil'],
            'tNombre'           =>   $aDatos['tNombre'],
            'tCorreo'           =>   $aDatos['tCorreo'],
            'tTelefono'         =>   $aDatos['tTelefono'],
            'tUsuario'          =>   $aDatos['tUsuario'],
            'tPuesto'           =>   $aDatos['tPuesto'],
            'tImagen'           =>   $aDatos['tImagen'],
            'fhFechaActualizacion'  =>   $aDatos['fhFechaActualizacion']
            );
        $this->db->where('eCodUsuario', $aDatos['eCodUsuario']);

        $aRes['eExito']         = ($this->db->update('cat_usuarios',$data) ? true : false);
        $aRes['eCodUsuario']    = $aDatos['eCodUsuario'];

        return $aRes;
    }

    public function upd_usuario_password($aDatos){
        //campos de la tabla
        $data = array(
            'tPassword'             =>   $aDatos['tPassword'],
            'fhFechaActualizacion'  =>   $aDatos['fhFechaActualizacion']
            );
       //print_r($data);
       $this->db->where('eCodUsuario', $aDatos['eCodUsuario']);
        
        $aRes['eExito']         = ($this->db->update('cat_usuarios',$data) ? true : false);
        $aRes['eCodUsuario']    = $aDatos['eCodUsuario'];

        return $aRes;
    }

    public function upd_usuario_estatus($aDatos){
        //campos de la tabla
        $data = array(
            'tCodEstatus'       =>   $aDatos['tCodEstatus'],
            'fhFechaActualizacion'  =>   $aDatos['fhFechaActualizacion']
            );
        $this->db->where('eCodUsuario', $aDatos['eCodUsuario']);

        $aRes['eExito']         = ($this->db->update('cat_usuarios',$data) ? true : false);
        $aRes['eCodUsuario']    = $aDatos['eCodUsuario'];

        return $aRes;
    }


    public function ins_item($aDatos){
        $data = array(
            'tNombre'           =>   $aDatos['tNombre'],
            'eCodTipoItem'      =>   $aDatos['eCodTipoItem'],
            'tDescripcion'      =>   $aDatos['tDescripcion'],
            'dPrecio'           =>   $aDatos['dPrecio'],
            'fhFechaRegistro'   =>   $aDatos['fhFechaRegistro'],
            'tCodEstatus'       =>   $aDatos['tCodEstatus']
            );
        $this->db->insert('cat_items',$data);

        $aRes['eExito']         = ($this->db->affected_rows() != 1) ? false : true;
        $aRes['eCodItem']       = $this->db->insert_id();

        return $aRes;
    }

    public function upd_item($aDatos){
        $data = array(
            'eCodItem'      =>   $aDatos['eCodItem'],
            'tNombre'       =>   $aDatos['tNombre'],
            'eCodTipoItem'  =>   $aDatos['eCodTipoItem'],
            'tDescripcion'  =>   $aDatos['tDescripcion'],
            'dPrecio'       =>   $aDatos['dPrecio'],
            'tCodEstatus'   =>   $aDatos['tCodEstatus']
            );
        $this->db->where('eCodItem', $aDatos['eCodItem']);

        $aRes['eExito']         = ($this->db->update('cat_items',$data) ? true : false);
        $aRes['eCodItem']    = $aDatos['eCodItem'];

        return $aRes;
    }

    public function upd_eliminaritem($aDatos){
        $data = array('tCodEstatus' => 'EL');
        $this->db->where('eCodItem', $aDatos['eCodItem']);

        $aRes['eExito']      = ($this->db->update('cat_items',$data) ? true : false);
        $aRes['eCodItem']    = $aDatos['eCodItem'];

        return $aRes;
    }

    public function ins_perfil($aDatos) {
        //campos de la tabla
        $data = array(
            'tNombre'       =>   $aDatos['tNombre'],
            'tCodEstatus'   =>   $aDatos['tCodEstatus']
            );
        $this->db->insert('cat_perfiles',$data);

        $aRes['eExito']       = ($this->db->affected_rows() != 1) ? false : true;
        $aRes['eCodPerfil']   = $this->db->insert_id();

        return $aRes;
    }

    public function upd_perfil($aDatos) {
        //campos de la tabla
        $data = array(
            'tNombre'     =>   $aDatos['tNombre']
            );
        $this->db->where('eCodPerfil', $aDatos['eCodPerfil']);

        $aRes['eExito']       = ($this->db->update('cat_perfiles',$data) ? true : false);
        $aRes['eCodPerfil']   = $this->db->insert_id();

        return $aRes;
    }

    public function ins_perfilpermiso($aDatos) {
        //campos de la tabla
        $data = array(
            'eCodPerfil'    =>   $aDatos['eCodPerfil'],
            'eCodPermiso'   =>   $aDatos['eCodPermiso']
            );
        $this->db->insert('rel_perfilespermisos',$data);

        $aRes['eExito']             = ($this->db->affected_rows() != 1) ? false : true;
        $aRes['eCodPerfilPermiso']  = $this->db->insert_id();

        return $aRes;
    }

    public function del_perfilpermiso($aDatos) {
        //campos de la tabla
        $data = array(
            'eCodPerfil' => $aDatos['eCodPerfil']
            );
        $this->db->where('eCodPerfil', $aDatos['eCodPerfil']);

        $aRes['eExito'] = ($this->db->delete('rel_perfilespermisos',$data) ? true : false);

        return $aRes;
    }

}
?>
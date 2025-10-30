<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_login extends CI_Controller {

    public function index() {
        echo "<h2>Test de Login y Acceso</h2>";
        
        // Probar login simple
        echo "<h3>1. Probando login simple (admin/admin)</h3>";
        
        // Simular datos POST
        $_POST['tUsuario'] = 'admin';
        $_POST['tPassword'] = 'admin';
        
        $this->load->library('session');
        $this->load->model('catalogos_m');
        
        $tUsuario  = 'admin';
        $tPassword = 'admin';

        if ($tUsuario === 'admin' && $tPassword === 'admin') {
            echo "<p style='color: green;'>✓ Credenciales correctas</p>";
            
            // Verificar/crear estatus
            $this->load->database();
            $estatusAC = $this->db->get_where('cat_estatus', ['tCodEstatus' => 'AC'])->row();
            if (!$estatusAC) {
                $this->db->insert('cat_estatus', ['tCodEstatus'=>'AC','tNombre'=>'Activo','tClase'=>'success']);
                echo "<p>✓ Estatus AC creado</p>";
            } else {
                echo "<p>✓ Estatus AC existe</p>";
            }

            // Verificar/crear perfil
            $perfilRow = $this->db->get_where('cat_perfiles', ['tNombre' => 'Administrador'])->row();
            if (!$perfilRow) {
                $this->db->insert('cat_perfiles', ['tNombre' => 'Administrador', 'tCodEstatus' => 'AC']);
                $eCodPerfil = (int)$this->db->insert_id();
                echo "<p>✓ Perfil Administrador creado con ID: $eCodPerfil</p>";
            } else {
                $eCodPerfil = (int)$perfilRow->eCodPerfil;
                echo "<p>✓ Perfil Administrador existe con ID: $eCodPerfil</p>";
            }

            // Establecer sesión
            $this->session->set_userdata('bSesion', true);
            $this->session->set_userdata('eCodPerfil', $eCodPerfil);
            $this->session->set_userdata('tNombre', 'Administrador');
            
            echo "<p style='color: green;'>✓ Sesión establecida</p>";
            
            // Probar acceso al menú
            echo "<h3>2. Probando acceso al menú</h3>";
            $this->load->model('secciones_m');
            
            try {
                $con_menu = $this->secciones_m->con_menu($eCodPerfil);
                if ($con_menu && count($con_menu) > 0) {
                    echo "<p style='color: green;'>✓ Menú cargado correctamente (" . count($con_menu) . " elementos)</p>";
                    echo "<ul>";
                    foreach ($con_menu as $item) {
                        echo "<li>" . $item->tNombre . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p style='color: orange;'>⚠ Menú vacío o sin permisos</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error al cargar menú: " . $e->getMessage() . "</p>";
            }
            
            echo "<h3>3. Enlaces de prueba</h3>";
            echo "<p><a href='" . site_url('Panel') . "' target='_blank'>Ir al Panel Principal</a></p>";
            echo "<p><a href='" . site_url('Configuracion/m1_s1') . "' target='_blank'>Ir a Configuración - Log de Eventos</a></p>";
            
        } else {
            echo "<p style='color: red;'>✗ Credenciales incorrectas</p>";
        }
    }
}
?>
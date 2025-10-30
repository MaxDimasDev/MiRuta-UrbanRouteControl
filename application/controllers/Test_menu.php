<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_menu extends CI_Controller {

    public function index() {
        echo "<h2>Test de Menú y Datos del Sistema</h2>";
        
        // Establecer sesión de prueba
        $this->load->library('session');
        $this->load->database();
        
        // Obtener perfil de administrador
        $perfilRow = $this->db->get_where('cat_perfiles', ['tNombre' => 'Administrador'])->row();
        if (!$perfilRow) {
            echo "<p style='color: red;'>✗ No se encontró el perfil de Administrador</p>";
            return;
        }
        
        $eCodPerfil = (int)$perfilRow->eCodPerfil;
        echo "<p>✓ Perfil encontrado: ID $eCodPerfil</p>";
        
        // Establecer sesión
        $this->session->set_userdata('bSesion', true);
        $this->session->set_userdata('eCodPerfil', $eCodPerfil);
        $this->session->set_userdata('tNombre', 'Administrador');
        
        // Cargar modelo de secciones
        $this->load->model('secciones_m');
        
        echo "<h3>1. Probando carga del menú</h3>";
        try {
            $con_menu = $this->secciones_m->con_menu($eCodPerfil);
            
            if ($con_menu && count($con_menu) > 0) {
                echo "<p style='color: green;'>✓ Menú cargado: " . count($con_menu) . " elementos</p>";
                
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Módulo</th><th>Sección</th><th>Controlador</th><th>Código Sección</th><th>Icono</th></tr>";
                
                foreach ($con_menu as $item) {
                    echo "<tr>";
                    echo "<td>" . (isset($item->tModuloCorto) ? $item->tModuloCorto : 'N/A') . "</td>";
                    echo "<td>" . (isset($item->tSeccion) ? $item->tSeccion : 'N/A') . "</td>";
                    echo "<td>" . (isset($item->tControlador) ? $item->tControlador : 'N/A') . "</td>";
                    echo "<td>" . (isset($item->tCodSeccion) ? $item->tCodSeccion : 'N/A') . "</td>";
                    echo "<td>" . (isset($item->tSeccionIcono) ? $item->tSeccionIcono : 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
            } else {
                echo "<p style='color: orange;'>⚠ Menú vacío</p>";
                
                // Verificar tablas necesarias
                echo "<h4>Verificando tablas del menú:</h4>";
                $tablas = ['cat_modulos', 'cat_secciones', 'cat_permisos', 'rel_perfilespermisos'];
                foreach ($tablas as $tabla) {
                    if ($this->db->table_exists($tabla)) {
                        $count = $this->db->count_all($tabla);
                        echo "<p>✓ $tabla: $count registros</p>";
                    } else {
                        echo "<p style='color: red;'>✗ $tabla: no existe</p>";
                    }
                }
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error al cargar menú: " . $e->getMessage() . "</p>";
        }
        
        echo "<h3>2. Probando Panel con datos</h3>";
        echo "<p><a href='" . site_url('Panel') . "' target='_blank'>Abrir Panel Principal</a></p>";
        
        echo "<h3>3. Verificando configuración base_url</h3>";
        echo "<p>Base URL configurada: " . base_url() . "</p>";
        echo "<p>Site URL: " . site_url() . "</p>";
        
        echo "<h3>4. Probando rutas específicas</h3>";
        echo "<ul>";
        echo "<li><a href='" . site_url('Configuracion/m1_s1') . "' target='_blank'>Configuración - Log de Eventos</a></li>";
        echo "<li><a href='" . site_url('Configuracion/m1_s2') . "' target='_blank'>Configuración - Preferencias</a></li>";
        if ($con_menu && count($con_menu) > 0) {
            foreach ($con_menu as $item) {
                if (isset($item->tControlador) && isset($item->tCodSeccion)) {
                    echo "<li><a href='" . site_url($item->tControlador . '/' . $item->tCodSeccion) . "' target='_blank'>" . $item->tSeccion . "</a></li>";
                }
            }
        }
        echo "</ul>";
    }
}
?>
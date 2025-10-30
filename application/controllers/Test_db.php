<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_db extends CI_Controller {

    public function index() {
        // Probar conexión básica
        echo "<h2>Test de Conexión a Base de Datos</h2>";
        
        try {
            // Verificar conexión
            $this->load->database();
            echo "<p style='color: green;'>✓ Conexión a base de datos exitosa</p>";
            
            // Probar consulta simple
            $query = $this->db->query("SELECT DATABASE() as current_db");
            $result = $query->row();
            echo "<p>Base de datos actual: <strong>" . $result->current_db . "</strong></p>";
            
            // Mostrar tablas
            $query = $this->db->query("SHOW TABLES");
            echo "<h3>Tablas disponibles:</h3><ul>";
            foreach ($query->result_array() as $row) {
                $table_name = array_values($row)[0];
                echo "<li>" . $table_name . "</li>";
            }
            echo "</ul>";
            
            // Probar datos de cat_perfiles
            $query = $this->db->query("SELECT * FROM cat_perfiles LIMIT 5");
            echo "<h3>Datos de cat_perfiles:</h3>";
            if ($query->num_rows() > 0) {
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Estatus</th></tr>";
                foreach ($query->result() as $row) {
                    echo "<tr>";
                    echo "<td>" . (isset($row->eCodPerfil) ? $row->eCodPerfil : 'N/A') . "</td>";
                    echo "<td>" . (isset($row->tNombre) ? $row->tNombre : 'N/A') . "</td>";
                    echo "<td>" . (isset($row->tCodEstatus) ? $row->tCodEstatus : 'N/A') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: orange;'>No hay datos en cat_perfiles</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error de conexión: " . $e->getMessage() . "</p>";
        }
    }
}
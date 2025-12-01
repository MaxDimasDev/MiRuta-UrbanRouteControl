<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Configuracion extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->seguridad();
		$this->load->model('secciones_m');
		$this->load->model('catalogos_m');
		$this->load->model('catinserts_m');
		$this->load->model('consultas_m');
		$this->load->model('configuraciones_m');
		$this->load->model('inserts_m');
		$this->load->helper('date_helper');
		date_default_timezone_set('America/Mexico_City');
		ini_set('memory_limit', "256M");
		ini_set('max_execution_time', 600);
	}

	function seguridad() {
		if (!$this->session->userdata('bSesion')) {
			redirect(base_url());
		}
	}

	public function m1_s1() { // LOG de Eventos

		$data['con_menu']		= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_seccion']	= $this->secciones_m->con_secciones(false, false, "m1_s1");
		$data['con_permisos']	= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m1_s1");
		$data['con_eventos']	= $this->catalogos_m->con_eventos();
		$data['con_usuarios']	= $this->catalogos_m->con_usuarios();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Configuracion/logevento', $data);
	}

	// Página dedicada: Historial completo de eventos
	public function historial_eventos() {
		$data['con_menu']		= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_seccion']	= $this->secciones_m->con_secciones(false, false, "m1_s1");
		$data['con_permisos']	= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m1_s1");
		$data['con_eventos']	= $this->catalogos_m->con_eventos();
		$data['con_usuarios']	= $this->catalogos_m->con_usuarios();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Configuracion/logevento_full', $data);
	}
	public function detalle_evento() {
		$aFiltro['eCodUsuario']		= ($this->input->post("eCodUsuario")	? $this->input->post("eCodUsuario")		: NULL);
		$aFiltro['eCodEvento']		= ($this->input->post("eCodEvento")		? $this->input->post("eCodEvento")		: NULL);
		$aFiltro['fhFechaInicio']	= ($this->input->post("fhFechaInicio")	? $this->input->post("fhFechaInicio")	: NULL);
		$aFiltro['fhFechaFinal']	= ($this->input->post("fhFechaFinal")	? $this->input->post("fhFechaFinal")	: NULL);
		$aFiltro['tEvento']			= ($this->input->post("tEvento")		? $this->input->post("tEvento")			: NULL);
		// Limit opcional (para mostrar últimos N registros)
		$aFiltro['limit']			= ($this->input->post("limit")			? (int)$this->input->post("limit") : NULL);

		$con_logeventos = $this->configuraciones_m->con_logeventos($aFiltro);

		echo	"<div class='col-md-12'>
					<table class=\"table table-bordered table-striped mb-none\" id=\"tblLogEvento\">
						<thead>
							<tr>
								<th style=\"width: 15%\"><span class=\"text-normal text-sm\">F. Registro</span></th>
								<th><span class=\"text-normal text-sm\">Tipo</span></th>
								<th><span class=\"text-normal text-sm\">Usuario</span></th>
								<th><span class=\"text-normal text-sm\">Mensaje</span></th>
							</tr>
						</thead>";
		if (isset($con_logeventos)) {
			echo		"<tbody class=\"log-viewer\">";
			foreach ($con_logeventos as $cle) {
				echo		"<tr>
								<td data-title=\"Fecha\" class=\"pt-md pb-md\">
									".$cle->fhFechaRegistro."
								</td>
								<td data-title=\"Tipo\" class=\"pt-md pb-md\">
									".$cle->tIconoEvento." ".$cle->tTipoEventoCorto."
								</td>
								<td data-title=\"Usuario\" class=\"pt-md pb-md\">
									".$cle->tUsuario."
								</td>
								<td data-title=\"Mensaje\" class=\"pt-md pb-md\">
									".$cle->tEvento."
								</td>
							</tr>";
			}
			echo		"</tbody>";
		}
		echo		"</table>".
				"</diV>";
	}
	public function m1_s2() {
		$data['con_menu']		= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_seccion']	= $this->secciones_m->con_secciones(false, false, "m1_s2");
		$data['con_permisos']	= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m1_s2");

		$this->load->view('Encabezado/cabecera', $data);
		$this->load->view('Encabezado/menu', $data);
		$this->load->view('Configuracion/logevento', $data);
		$this->load->view('Encabezado/pie', $data);
	}

    // Nota: Se eliminó la vista de preferencias y su guardado asociado.


}
?>

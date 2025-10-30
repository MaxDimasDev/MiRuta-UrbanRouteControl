<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Panel extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->seguridad();
		$this->load->model('secciones_m');
		$this->load->model('catalogos_m');
		$this->load->model('consultas_m');
		$this->load->helper('date_helper');
		date_default_timezone_set('America/Mexico_City');

	}

	function seguridad() {

		if (!$this->session->userdata('bSesion')) {
			redirect(base_url());
		}
	}

	public function index(){

		$data['tTituloPagina']	= "Inicio";
		$data['con_menu']		= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$IPServer 				= gethostbyname($_SERVER['HTTP_HOST']); //Esto da la ip del Servidor. 
		$IPRemotaServer 		= $_SERVER['REMOTE_ADDR'];

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
			$data['alerta'] = "Dashboard";
			$this->load->view('Panel/panel', $data);
	}

}
?>
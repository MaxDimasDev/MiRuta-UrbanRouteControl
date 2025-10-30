<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Sesion extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('secciones_m');
		$this->load->model('catalogos_m');
		$this->load->model('catinserts_m');
		$this->load->model('inserts_m');
		$this->load->helper('date_helper');
		date_default_timezone_set('America/Mexico_City');
	}

	public function index() {
		$data['usuario'] = "Admin";
		$this->load->view('Principal/login', $data);
	}

	public function logout() {
		$this->session->sess_destroy();
		$this->session->unset_userdata('bSesion');
		$this->session->unset_userdata('eCodUsuario');
		$this->session->unset_userdata('eCodPerfil');
		$this->session->unset_userdata('tNombre');
		$this->session->unset_userdata('tEmpresa');
		$this->session->unset_userdata('eCodEmpresa');
		$this->session->unset_userdata('tDepartamento');
		$this->session->unset_userdata('eCodDepartamento');
		$this->session->unset_userdata('tPuesto');
		$this->session->unset_userdata('tPerfil');
		$this->session->unset_userdata('tCorreo');
		$this->session->unset_userdata('tImagen');
		redirect(base_url());
	}

	public function login() {

		$tCadenaUsuarioEspacios 	= str_replace(' ', '',$this->input->post("tUsuario"));
		$tCadenaUsuarioParentesis 	= str_replace(')', '',$tCadenaUsuarioEspacios);
		$tCadenaUsuarioApostrofes 	= str_replace("'", "",$tCadenaUsuarioParentesis);
		$tCadenaUsuarioNumeral 		= str_replace('#', '',$tCadenaUsuarioApostrofes);
		$tCadenaUsuarioFinal		= str_replace(';', '',$tCadenaUsuarioNumeral);
		
		$tCadenaPasswordEspacios 	= str_replace(' ', '',$this->input->post("tPassword"));
		$tCadenaPasswordParentesis 	= str_replace(')', '',$tCadenaPasswordEspacios);
		$tCadenaPasswordApostrofes 	= str_replace("'", "",$tCadenaPasswordParentesis);
		$tCadenaPasswordNumeral 	= str_replace('#', '',$tCadenaPasswordApostrofes);
		$tCadenaPasswordFinal		= str_replace(';', '',$tCadenaPasswordNumeral);

		$tUsuario		= $this->security->xss_clean(strip_tags($tCadenaUsuarioFinal));
		$tPassword		= sha1($this->security->xss_clean(strip_tags($tCadenaPasswordFinal)));
		$eCodUsuario	= false;
		$con_usuarios	= $this->catalogos_m->con_usuarios(false, false, false, false, $tUsuario, $tPassword, "'AC'");
		$tUsuarioCompleto			  = $this->input->post("tUsuario");
		$tPasswordCompleto 			  = $this->input->post("tPassword");


        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            $direccionIP = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $direccionIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            $direccionIP = $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            $direccionIP = $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"])){
            $direccionIP = $_SERVER["HTTP_FORWARDED"];
        }
        else{
            $direccionIP = $_SERVER["REMOTE_ADDR"];
        }

        $IPLocal = getHostByName(getHostName());


		if (isset($con_usuarios)) {

			foreach ($con_usuarios as $usr) { 

				echo "<div class=\"alert alert-success\">
						<strong>¡Bienvenido ".$usr->tNombre."!, redireccionando al sistema... </strong></div>";
				echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"1\">";
				echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$eCodUsuario."\">";

				$this->session->set_userdata('bSesion', true);
				$this->session->set_userdata('bAdmin', $usr->bAdmin);
				$this->session->set_userdata('eCodUsuario', $usr->eCodUsuario);
				$this->session->set_userdata('eCodPerfil', $usr->eCodPerfil);
				$this->session->set_userdata('tNombre', $usr->tNombre);
				$this->session->set_userdata('tEmpresa', $usr->tEmpresa);
				$this->session->set_userdata('eCodEmpresa', $usr->eCodEmpresa);
				$this->session->set_userdata('tDepartamento', $usr->tDepartamento);
				$this->session->set_userdata('eCodDepartamento', $usr->eCodDepartamento);
				$this->session->set_userdata('tPuesto', $usr->tPuesto);
				$this->session->set_userdata('tPerfil', $usr->tPerfil);
				$this->session->set_userdata('tCorreo', $usr->tCorreo);
				$this->session->set_userdata('tImagen', $usr->tImagen);

		        $aDataLogin['eCodUsuario']   = $eCodUsuario;
		        $aDataLogin['eCodEvento']    = 8;
				$aDataLogin['tEvento']       = 'El Usuario: '.$tUsuario.' accedió al sistema desde la IP Pública: '.$direccionIP.' | IP Local: '.$IPLocal;
        		$this->inserts_m->ins_log($aDataLogin);
			}

		} else {
			echo "<div class=\"alert alert-danger\"><strong>¡El usuario o contrase&ntilde;a no existen!... </strong></div>";
			echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"0\">";
	        
	        $aDataLogueo['eCodUsuario']   = 0;
	        $aDataLogueo['eCodEvento']    = 8;
			$aDataLogueo['tEvento']       = 'Intentaron acceder al sistema con el Usuario: " '.$tUsuarioCompleto.' " | Contraseña: " '.$tPasswordCompleto.' " desde la IP Pública: '.$direccionIP.' | IP Local: '.$IPLocal;

	      	$this->inserts_m->ins_log($aDataLogueo);
		}
	}

    // Autenticación simplificada con credenciales fijas (admin/admin)
    public function login_simple() {
        $tUsuario  = trim($this->input->post('tUsuario'));
        $tPassword = trim($this->input->post('tPassword'));

		if ($tUsuario === 'admin' && $tPassword === 'admin') {
			// Asegurar estatus base
			$estatusAC = $this->db->get_where('cat_estatus', ['tCodEstatus' => 'AC'])->row();
			if (!$estatusAC) {
				$this->db->insert('cat_estatus', ['tCodEstatus'=>'AC','tNombre'=>'Activo','tClase'=>'success']);
				$this->db->insert('cat_estatus', ['tCodEstatus'=>'IN','tNombre'=>'Inactivo','tClase'=>'secondary']);
				$this->db->insert('cat_estatus', ['tCodEstatus'=>'EL','tNombre'=>'Eliminado','tClase'=>'danger']);
				$this->db->insert('cat_estatus', ['tCodEstatus'=>'CA','tNombre'=>'Cancelado','tClase'=>'warning']);
			}

			// Obtener/crear el perfil Administrador desde BD para evitar desajustes de ID
			$perfilRow = $this->db->get_where('cat_perfiles', ['tNombre' => 'Administrador'])->row();
			if (!$perfilRow) {
				$this->db->insert('cat_perfiles', ['tNombre' => 'Administrador', 'tCodEstatus' => 'AC']);
				$eCodPerfil = (int)$this->db->insert_id();
			} else {
				$eCodPerfil = (int)$perfilRow->eCodPerfil;
			}

            $this->session->set_userdata('bSesion', true);
            $this->session->set_userdata('bAdmin', 1);
            $this->session->set_userdata('eCodUsuario', 1);
			$this->session->set_userdata('eCodPerfil', $eCodPerfil);
            $this->session->set_userdata('tNombre', 'Administrador');
            $this->session->set_userdata('tEmpresa', '');
            $this->session->set_userdata('eCodEmpresa', 0);
            $this->session->set_userdata('tDepartamento', '');
            $this->session->set_userdata('eCodDepartamento', 0);
            $this->session->set_userdata('tPuesto', 'Admin');
            $this->session->set_userdata('tPerfil', 'Administrador');
            $this->session->set_userdata('tCorreo', '');
            $this->session->set_userdata('tImagen', '');


			// Seed mínimo del módulo de Transporte y permisos si faltan
			$modTrans = $this->db->get_where('cat_modulos', ['tCodModulo' => 'm4'])->row();
			if (!$modTrans) {
				$this->db->insert('cat_modulos', [
					'tCodModulo'    => 'm4',
					'tNombre'       => 'Administración de transportes',
					'tNombreCorto'  => 'Transporte',
					'tIcono'        => 'fa-bus',
					'tControlador'  => 'Transporte',
					'ePosicion'     => 4
				]);
				$modTrans = $this->db->get_where('cat_modulos', ['tCodModulo' => 'm4'])->row();
			}
			$eCodModulo = (int)$modTrans->eCodModulo;

			$secciones = [
				['tCodSeccion'=>'m4_s1','tNombre'=>'Administrar rutas','tNombreCorto'=>'Rutas','tIcono'=>'fa-route','ePosicion'=>1],
				['tCodSeccion'=>'m4_s2','tNombre'=>'Administrar paradas','tNombreCorto'=>'Paradas','tIcono'=>'fa-map-marker-alt','ePosicion'=>2],
				['tCodSeccion'=>'m4_s3','tNombre'=>'Administrar horarios','tNombreCorto'=>'Horarios','tIcono'=>'fa-clock','ePosicion'=>3],
			];
			foreach ($secciones as $sec) {
				$secRow = $this->db->get_where('cat_secciones', ['tCodSeccion' => $sec['tCodSeccion']])->row();
				if (!$secRow) {
					$sec['eCodModulo'] = $eCodModulo;
					$this->db->insert('cat_secciones', $sec);
					$secRow = $this->db->get_where('cat_secciones', ['tCodSeccion' => $sec['tCodSeccion']])->row();
				}
				$eCodSeccion = (int)$secRow->eCodSeccion;

				$permRow = $this->db->get_where('cat_permisos', ['eCodSeccion' => $eCodSeccion, 'tNombre' => 'Acceso'])->row();
				if (!$permRow) {
					$this->db->insert('cat_permisos', [
						'eCodSeccion'   => $eCodSeccion,
						'tNombre'       => 'Acceso',
						'tNombreCorto'  => 'Acceso',
						'tIcono'        => 'fa-check',
						'ePosicion'     => 1,
					]);
					$permRow = $this->db->get_where('cat_permisos', ['eCodSeccion' => $eCodSeccion, 'tNombre' => 'Acceso'])->row();
				}
				$eCodPermiso = (int)$permRow->eCodPermiso;

				$rppRow = $this->db->get_where('rel_perfilespermisos', ['eCodPerfil' => $eCodPerfil, 'eCodPermiso' => $eCodPermiso])->row();
				if (!$rppRow) {
					$this->db->insert('rel_perfilespermisos', ['eCodPerfil' => $eCodPerfil, 'eCodPermiso' => $eCodPermiso]);
				}
			}

			// Seed mínimo del módulo de Configuración y permisos si faltan
			$modConfig = $this->db->get_where('cat_modulos', ['tCodModulo' => 'm1'])->row();
			if (!$modConfig) {
				$this->db->insert('cat_modulos', [
					'tCodModulo'    => 'm1',
					'tNombre'       => 'Configuración del sistema',
					'tNombreCorto'  => 'Configuración',
					'tIcono'        => 'fa-cogs',
					'tControlador'  => 'Configuracion',
					'ePosicion'     => 1
				]);
				$modConfig = $this->db->get_where('cat_modulos', ['tCodModulo' => 'm1'])->row();
			}
			$eCodModuloConfig = (int)$modConfig->eCodModulo;

			$configSecciones = [
				['tCodSeccion'=>'m1_s1','tNombre'=>'Log de eventos','tNombreCorto'=>'Eventos','tIcono'=>'fa-list','ePosicion'=>1],
				['tCodSeccion'=>'m1_s2','tNombre'=>'Preferencias del sistema','tNombreCorto'=>'Preferencias','tIcono'=>'fa-sliders-h','ePosicion'=>2],
			];
			foreach ($configSecciones as $sec) {
				$secRow = $this->db->get_where('cat_secciones', ['tCodSeccion' => $sec['tCodSeccion']])->row();
				if (!$secRow) {
					$sec['eCodModulo'] = $eCodModuloConfig;
					$this->db->insert('cat_secciones', $sec);
					$secRow = $this->db->get_where('cat_secciones', ['tCodSeccion' => $sec['tCodSeccion']])->row();
				}
				$eCodSeccion = (int)$secRow->eCodSeccion;

				$permRow = $this->db->get_where('cat_permisos', ['eCodSeccion' => $eCodSeccion, 'tNombre' => 'Acceso'])->row();
				if (!$permRow) {
					$this->db->insert('cat_permisos', [
						'eCodSeccion'   => $eCodSeccion,
						'tNombre'       => 'Acceso',
						'tNombreCorto'  => 'Acceso',
						'tIcono'        => 'fa-check',
						'ePosicion'     => 1,
					]);
					$permRow = $this->db->get_where('cat_permisos', ['eCodSeccion' => $eCodSeccion, 'tNombre' => 'Acceso'])->row();
				}
				$eCodPermiso = (int)$permRow->eCodPermiso;

				$rppRow = $this->db->get_where('rel_perfilespermisos', ['eCodPerfil' => $eCodPerfil, 'eCodPermiso' => $eCodPermiso])->row();
				if (!$rppRow) {
					$this->db->insert('rel_perfilespermisos', ['eCodPerfil' => $eCodPerfil, 'eCodPermiso' => $eCodPermiso]);
				}
			}

			// Sembrar catálogo de eventos si existe la tabla
			if ($this->db->table_exists('cat_eventos')) {
				$eventos = [
					['eCodEvento'=>1,'tNombre'=>'Acceso al sistema','tDescripcion'=>'Un usuario accedió al sistema','tCodEstatus'=>'AC'],
					['eCodEvento'=>2,'tNombre'=>'Alta de ruta','tDescripcion'=>'Creación/actualización de una ruta','tCodEstatus'=>'AC'],
					['eCodEvento'=>3,'tNombre'=>'Alta de parada','tDescripcion'=>'Creación/actualización de una parada','tCodEstatus'=>'AC'],
					['eCodEvento'=>4,'tNombre'=>'Alta de servicio','tDescripcion'=>'Creación/actualización de un calendario de servicio','tCodEstatus'=>'AC'],
					['eCodEvento'=>5,'tNombre'=>'Alta de viaje','tDescripcion'=>'Creación/actualización de un viaje','tCodEstatus'=>'AC'],
					['eCodEvento'=>8,'tNombre'=>'Login simple (admin)','tDescripcion'=>'Acceso rápido con admin/admin','tCodEstatus'=>'AC'],
				];
				foreach ($eventos as $ev) {
					$evRow = $this->db->get_where('cat_eventos', ['eCodEvento' => $ev['eCodEvento']])->row();
					if (!$evRow) {
						$this->db->insert('cat_eventos', $ev);
					}
				}
			}

			echo "<div class=\"alert alert-success\"><strong>¡Bienvenido Administrador!, redireccionando al sistema... </strong></div>";
            echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"1\">";
            echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"1\">";
        } else {
            echo "<div class=\"alert alert-danger\"><strong>¡El usuario o contraseña no son válidos! </strong></div>";
            echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"0\">";
        }
    }

	// Opción de visitante: redirige a MiRuta sin sesión de administrador
	public function visitante() {
		redirect(site_url('MiRuta'));
	}

	public function bloqueo(){
		$bSesion = $this->input->post("bSesion");

		$this->session->set_userdata('bSesion', false);

	}

	public function desbloqueo(){
		$tPassword 		= sha1($this->security->xss_clean(strip_tags($this->input->post("tPassword"))));
		$con_usuarios 	= $this->catalogos_m->con_usuarios($this->session->userdata('eCodUsuario'), false, false, false, false, $tPassword, "AC");

		if (isset($con_usuarios)){

			foreach ($con_usuarios as $usr) { 

				$this->session->set_userdata('bSesion', true);
				$this->session->set_userdata('bAdmin', $usr->bAdmin);
				$this->session->set_userdata('eCodUsuario', $usr->eCodUsuario);
				$this->session->set_userdata('eCodPerfil', $usr->eCodPerfil);
				$this->session->set_userdata('tNombre', $usr->tNombre);
				$this->session->set_userdata('tEmpresa', $usr->tEmpresa);
				$this->session->set_userdata('eCodEmpresa', $usr->eCodEmpresa);
				$this->session->set_userdata('tDepartamento', $usr->tDepartamento);
				$this->session->set_userdata('eCodDepartamento', $usr->eCodDepartamento);
				$this->session->set_userdata('tPuesto', $usr->tPuesto);
				$this->session->set_userdata('tPerfil', $usr->tPerfil);
				$this->session->set_userdata('tCorreo', $usr->tCorreo);
				$this->session->set_userdata('tImagen', $usr->tImagen);

				echo "<div class=\"alert alert-success\">
						<strong>¡Bienvenido de vuelta ".$usr->tNombre."!</strong></div>";
				echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"1\">";
				echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$usr->eCodUsuario."\">";
			}

		} else {
			echo "<div class=\"alert alert-danger\"><strong>¡La contrase&ntilde;a es incorrecta! </strong></div>";
			echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"0\">";
		}
	}


	public function perfil($eCodUsuario = false){
		
		$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_usuarios']		= $this->catalogos_m->con_usuarios($this->session->userdata("eCodUsuario"));
		$data['con_empresas']		= $this->catalogos_m->con_empresas();
		$data['con_perfiles']		= $this->catalogos_m->con_perfiles();
		$data['con_departamentos']	= $this->catalogos_m->con_departamentos();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Intranet/sesion_perfil', $data);
	}

}
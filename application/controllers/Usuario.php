<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Usuario extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->seguridad();
		$this->load->model('secciones_m');
		$this->load->model('consultas_m');
		$this->load->model('catalogos_m');
		$this->load->model('catinserts_m');
		$this->load->helper('date_helper');
		date_default_timezone_set('America/Mexico_City');

	}

	function seguridad() {
		if (!$this->session->userdata('bSesion')) {
			redirect(base_url());
		}
	}

	public function m2_s1() { // Usuario Nuevo

		$data['con_seccion']		= $this->secciones_m->con_secciones(false, false, "m2_s1");
		$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_permisos']		= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m2_s1");
		$data['con_empresas']		= $this->catalogos_m->con_empresas();
		$data['con_perfiles']		= $this->catalogos_m->con_perfiles();
		$data['con_departamentos']	= $this->catalogos_m->con_departamentos();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Intranet/usuario_nuevo', $data);

	}

	public function m2_s2() { // Listaddo de Usuarios

		$data['con_seccion']		= $this->secciones_m->con_secciones(false, false, "m2_s2");
		$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_permisos']		= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m2_s2");
		$data['con_departamentos']	= $this->catalogos_m->con_departamentos();
		$data['con_usuarios']		= $this->catalogos_m->con_usuarios();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Intranet/usuario', $data);

	}

	public function m2_s3() { // Perfil

		$data['con_seccion']		= $this->secciones_m->con_secciones(false, false, "m2_s3");
		$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_permisos']		= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m2_s3");
		$data['con_perfiles']		= $this->catalogos_m->con_perfiles();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Intranet/usuario_perfil', $data);

	}

	public function editar($eCodUsuario = false) {
		
		if (!$eCodUsuario){
			redirect(site_url("Usuario/m2_s2"));
		} else {
			$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
			$data['con_seccion']		= $this->secciones_m->con_secciones(false, false, "m2_s2");
			$data['con_permisos']		= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m2_s2");
			$data['con_usuarios']		= $this->catalogos_m->con_usuarios($eCodUsuario);
			$data['con_empresas']		= $this->catalogos_m->con_empresas();
			$data['con_perfiles']		= $this->catalogos_m->con_perfiles();
			$data['con_departamentos']	= $this->catalogos_m->con_departamentos();

			$this->load->view('Encabezado/header', $data);
			$this->load->view('Encabezado/menu');
			$this->load->view('Intranet/usuario_editar', $data);
		}

	}

	public function detalle() {
		$con_usuarios = $this->catalogos_m->con_usuarios($this->input->post("eCodUsuario"));
		foreach ($con_usuarios as $cu) {
			echo 	"<div class=\"panel-body\">
						<div class=\"modal-icon\">
							<div class=\"thumb-info mb-md\">
								<img id=\"imgPerfil\" src=\"".base_url().($cu->tImagen ? $cu->tImagen : 'assets/images/!logged-user.jpg')."\" class=\"rounded img-responsive\">
							</div>
						</div>
						<div class=\"modal-text\">
							<blockquote class=\"primary\">
								<h3> ".$cu->tNombre."</h3>
							</blockquote>
							<div >
							<table width=\"100%\" class=\"table table-striped mb-none\">
								<tbody>
									<tr>
										<th colspan=\"2\" width=\"50%\">Empresa:</th>
										<th colspan=\"2\" width=\"50%\">Departamento:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$cu->tEmpresa."</td>
										<td width=\"5%\"></td>
										<td>".$cu->tDepartamento."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"50%\">Perfil:</th>
										<th colspan=\"2\" width=\"50%\">Puesto:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$cu->tPerfil."</td>
										<td width=\"5%\"></td>
										<td>".$cu->tPuesto."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"30%\">Correo:</th>
										<th colspan=\"2\" width=\"30%\">Usuario:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$cu->tCorreo."</td>
										<td width=\"5%\"></td>
										<td>".$cu->tUsuario."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"30%\">Teléfono:</th>
										<th colspan=\"2\" width=\"30%\"></th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$cu->tTelefono."</td>
										<td width=\"5%\"></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							<br>";
			//echo $this->ver_correofirma($cu->eCodUsuario);
			echo			"</div>
						</div>
					</div>";
		}

	}

	public function detalle_perfil() {
		$aPermisos			= '';
		$eCodPerfil			= $this->input->post("eCodPerfil");
		$bHabilitar			= ($this->input->post("bHabilitar") ? $this->input->post("bHabilitar") : 0);
		$con_perfilpermiso	= $this->secciones_m->con_perfilpermiso($eCodPerfil);

		$con_modulos = $this->secciones_m->con_modulos();
		foreach ($con_modulos as $cm) {
			echo "<li>
					<label>
						<div class=\"checkbox-custom checkbox-primary\">
							<input type=\"checkbox\" id=\"m-".$cm->tCodModulo."\">
							<label for=\"m-".$cm->tCodModulo."\">
								<i class=\"".$cm->tIcono."\"></i> ".$cm->tNombre."
							</label>
						</div>
					</label>";
				$con_secciones = $this->secciones_m->con_secciones(false, $cm->eCodModulo);
				if (isset($con_secciones)){ 
					echo "<ul>";
					foreach ($con_secciones as $cs) {
						echo "<li>
								<label>
									<div class=\"checkbox-custom checkbox-primary\">
										<input type=\"checkbox\" id=\"s-".$cs->tCodSeccion."\"/> 
										<label for=\"s-".$cs->tCodSeccion."\">
											".$cs->tSeccion."
										</label>
									</div>
								</label>";
							$con_permisos = $this->secciones_m->con_permisos(false, $cs->eCodSeccion);
							if (isset($con_permisos)){ 
								echo "<ul>";
								foreach ($con_permisos as $cp) { 
									echo "<li>
											<input type=\"checkbox\" id=\"p-".$cp->eCodPermiso."\" value=\"".$cp->eCodPermiso."\"/> 
											<label for=\"p-".$cp->eCodPermiso."\">
												".$cp->tNombre."
											</label>
										</li>";
								}
								echo "</ul>";
							}
						echo "</li>";
					}
					echo "</ul>";
				}
			echo "</li>";
		}

		if (isset($con_perfilpermiso)){
			foreach ($con_perfilpermiso as $cpp) {
				$aPermisos .= ($aPermisos=='' ? $cpp->eCodPermiso : ','.$cpp->eCodPermiso);
			}
		}

		echo "<input type=\"hidden\" id=\"aPermisos\" name=\"aPermisos\" value=\"".$aPermisos."\">";

	}

	public function guardar() {
		$aDatos['eCodEmpresa']			= ($this->input->post("eCodEmpresa")		? $this->input->post("eCodEmpresa")			: NULL);
		$aDatos['eCodPerfil']			= ($this->input->post("eCodPerfil")			? $this->input->post("eCodPerfil")			: NULL);
		$aDatos['eCodDepartamento']		= ($this->input->post("eCodDepartamento")	? $this->input->post("eCodDepartamento")	: NULL);
		$aDatos['tNombre']				= ($this->input->post("tNombre")			? $this->input->post("tNombre")				: NULL);
		$aDatos['tCorreo']				= ($this->input->post("tCorreo")			? $this->input->post("tCorreo")				: NULL);
		$aDatos['tTelefono']			= ($this->input->post("tTelefono")			? $this->input->post("tTelefono")			: NULL);
		$aDatos['tUsuario']				= ($this->input->post("tUsuario")			? $this->input->post("tUsuario")			: NULL);
		$aDatos['tPassword']			= ($this->input->post("tPassword")			? sha1($this->input->post("tPassword"))		: NULL);
		$aDatos['tPasswordN']			= ($this->input->post("tPassword")			? $this->input->post("tPassword")			: NULL);
		$aDatos['tPuesto']				= ($this->input->post("tPuesto")			? $this->input->post("tPuesto")				: NULL);
		$aDatos['tImagen']				= ($this->input->post("tImagen")			? $this->input->post("tImagen")				: NULL);
		$aDatos['fhFechaRegistro']		= mdate('%Y/%m/%d %H:%i:%s', time());
		$aDatos['tCodEstatus']			= 'AC';

		$aRes = $this->catinserts_m->ins_usuario($aDatos);

		echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$aRes['eCodUsuario']."\">";
		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
		echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Usuario existoso,</strong> redireccionando al listado de usuarios</div>";
		// ----- EMAIL 
		//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
		// ------ END DE MAIL

	}

	public function actualizar() {
		$aDatos['eCodUsuario'] 			= ($this->input->post("eCodUsuario")		? $this->input->post("eCodUsuario") 		: NULL);
		$aDatos['eCodEmpresa'] 			= ($this->input->post("eCodEmpresa")		? $this->input->post("eCodEmpresa") 		: NULL);
		$aDatos['eCodPerfil'] 			= ($this->input->post("eCodPerfil")			? $this->input->post("eCodPerfil") 			: NULL);
		$aDatos['eCodDepartamento'] 	= ($this->input->post("eCodDepartamento")	? $this->input->post("eCodDepartamento") 	: NULL);
		$aDatos['tNombre'] 				= ($this->input->post("tNombre")			? $this->input->post("tNombre") 			: NULL);
		$aDatos['tCorreo'] 				= ($this->input->post("tCorreo")			? $this->input->post("tCorreo") 			: NULL);
		$aDatos['tTelefono'] 			= ($this->input->post("tTelefono")			? $this->input->post("tTelefono") 			: NULL);
		$aDatos['tUsuario'] 			= ($this->input->post("tUsuario")			? $this->input->post("tUsuario") 			: NULL);
		$aDatos['tPuesto'] 				= ($this->input->post("tPuesto")			? $this->input->post("tPuesto") 			: NULL);
		$aDatos['tImagen'] 				= ($this->input->post("tImagen")			? $this->input->post("tImagen") 			: NULL);
		$aDatos['fhFechaActualizacion'] = mdate('%Y/%m/%d %H:%i:%s', time());

		// Respaldo: si la tabla no existe, guardar cambio en sesión para evitar fallo
		if (method_exists($this->db, 'table_exists') && !$this->db->table_exists('cat_usuarios')) {
			$this->session->set_userdata('tNombre', ($aDatos['tNombre'] ?: $this->session->userdata('tNombre')));
			$this->session->set_userdata('tCorreo', ($aDatos['tCorreo'] ?: $this->session->userdata('tCorreo')));
			$this->session->set_userdata('tTelefono', ($aDatos['tTelefono'] ?: $this->session->userdata('tTelefono')));
			$this->session->set_userdata('tUsuario', ($aDatos['tUsuario'] ?: $this->session->userdata('tUsuario')));
			$this->session->set_userdata('tPuesto', ($aDatos['tPuesto'] ?: $this->session->userdata('tPuesto')));
			$this->session->set_userdata('tImagen', ($aDatos['tImagen'] ?: $this->session->userdata('tImagen')));
			$this->session->set_userdata('eCodEmpresa', ($aDatos['eCodEmpresa'] ?: $this->session->userdata('eCodEmpresa')));
			$this->session->set_userdata('eCodPerfil', ($aDatos['eCodPerfil'] ?: $this->session->userdata('eCodPerfil')));
			$this->session->set_userdata('eCodDepartamento', ($aDatos['eCodDepartamento'] ?: $this->session->userdata('eCodDepartamento')));

			echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$this->session->userdata('eCodUsuario')."\">";
			echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"1\">";
			echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Perfil actualizado,</strong> cambios guardados en sesión</div>";
			return;
		}
		
		$aRes = $this->catinserts_m->upd_usuario($aDatos);

		echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$aRes['eCodUsuario']."\">";
		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
		echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Usuario actualizado,</strong> redireccionando al listado de usuarios</div>";
		// ----- EMAIL 
		//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
		// ------ END DE MAIL
	
	}

	public function guardar_password() {
		$aDatos['eCodUsuario']			= ($this->input->post("eCodUsuario")		? $this->input->post("eCodUsuario") 		: NULL);
		$aDatos['tPassword']			= ($this->input->post("tPassword")			? sha1($this->input->post("tPassword")) 	: NULL);
		$aDatos['tPasswordN']			= ($this->input->post("tPassword")			? $this->input->post("tPassword") 			: NULL);
		$aDatos['fhFechaActualizacion'] = mdate('%Y-%m-%d %H:%i:%s', time());

		$aRes = $this->catinserts_m->upd_usuario_password($aDatos);

		echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$aRes['eCodUsuario']."\">";
		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
		echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Usuario actualizado,</strong> redireccionando al listado de usuarios</div>";
		// ----- EMAIL 
		//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
		// ------ END DE MAIL
	
	}

	public function guardar_perfil() {
		$aDatos['tNombre']		= ($this->input->post("tNombre")	? $this->input->post("tNombre") 	: NULL);
		$aDatos['aPermisos']	= ($this->input->post("aPermisos")	? $this->input->post("aPermisos")	: NULL);
		$aDatos['tCodEstatus']	= "AC";

		$aRes = $this->catinserts_m->ins_perfil($aDatos);
		
		if ($aRes['eExito']){

			for ($i=0; $i < sizeof($aDatos['aPermisos']); $i++) { 

				$aDatos1['eCodPerfil'] 	= $aRes['eCodPerfil'];
				$aDatos1['eCodPermiso'] = $aDatos['aPermisos'][$i]['eCodPermiso'];

				$aRes1 = $this->catinserts_m->ins_perfilpermiso($aDatos1);
			}

			echo "<input type=\"hidden\" id=\"eCodPerfil\" name=\"eCodPerfil\" value=\"".$aRes['eCodPerfil']."\">";
			echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
			echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Perfil guardado con éxito,</strong> redireccionando página</div>";
			// ----- EMAIL 
			//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
			// ------ END DE MAIL
		}

	}

	public function actualizar_perfil() {
		$aDatos['eCodPerfil']	= ($this->input->post("eCodPerfil")	? $this->input->post("eCodPerfil") 	: NULL);
		$aDatos['tNombre']		= ($this->input->post("tNombre")	? $this->input->post("tNombre") 	: NULL);
		$aDatos['aPermisos']	= ($this->input->post("aPermisos")	? $this->input->post("aPermisos")	: NULL);

		$aRes = $this->catinserts_m->upd_perfil($aDatos);

		if ($aRes['eExito']){

			$aDel = $this->catinserts_m->del_perfilpermiso($aDatos);

			for ($i=0; $i < sizeof($aDatos['aPermisos']); $i++) { 

				$aDatos1['eCodPerfil']	= $aDatos['eCodPerfil'];
				$aDatos1['eCodPermiso'] = $aDatos['aPermisos'][$i]['eCodPermiso'];

				$aRes1 = $this->catinserts_m->ins_perfilpermiso($aDatos1);
			}

			echo "<input type=\"hidden\" id=\"eCodPerfil\" name=\"eCodPerfil\" value=\"".$aRes['eCodPerfil']."\">";
			echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
			echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Perfil actualizado,</strong> redireccionando al listado de perfiles</div>";
			// ----- EMAIL 
			//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
			// ------ END DE MAIL
		}

	}

	public function estatus_usuario() {

		$aDatos['eCodUsuario']			= ($this->input->post("eCodUsuario")	? $this->input->post("eCodUsuario")	: NULL);
		$aDatos['tCodEstatus']			= ($this->input->post("tCodEstatus")	? $this->input->post("tCodEstatus")	: NULL);
		$aDatos['fhFechaActualizacion'] = mdate('%Y/%m/%d %H:%i:%s', time());

		$aRes = $this->inserts_m->upd_usuario_estatus($aDatos);

		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";

		if ($aRes['eExito']==1) {

			echo "<input type=\"hidden\" id=\"eCodUsuario\" name=\"eCodUsuario\" value=\"".$aRes['eCodUsuario']."\">";
			echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> ¡Usuario actualizado con éxito! </strong> redireccionando el listado..</div>";
			// ----- EMAIL 
			//$correo = $this->correos->nuevo_usuario($aRes['eCodUsuario']);
			// ------ END DE MAIL
		} else {
			echo "<div class=\"alert alert-danger\"><strong><i class=\"fa fa-times\"></i> ¡Error Inesperado, Cod. 101! </strong>, intente más tarde, si persiste el error llame a soporte.</div>";
		}

	}

	public function filtro_usuario(){
		
		$eCodDepartamento	= ($this->input->post("eCodDepartamento")	? $this->input->post("eCodDepartamento") : false);

		$con_permisos	= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m2_s2");
		$con_usuarios	= $this->catalogos_m->con_usuarios(false, false, $eCodDepartamento);
		

		echo 	"<table class=\"table table-bordered table-striped mb-none\" id=\"datatable-default\">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Departamento</th>
							<th>Correo</th>
							<th>Usuario</th>
							<th>Perfil Usuario</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>";

		if (isset($con_usuarios)){
			foreach ($con_usuarios as $dato) {
				echo 	"<tr>
							<td>".$dato->tNombre."</td>
							<td>".$dato->tDepartamento."</td>
							<td>".$dato->tCorreo."</td>
							<td>".$dato->tUsuario."</td>
							<td>".$dato->tPerfil."</td>
							<td>
								<div id=\"".$dato->eCodUsuario."\" class=\"btn-group\">";
									foreach ($con_permisos as $cp) { 
										if (strrpos($cp->aEstatus, $dato->tCodEstatus)!==false) { 
											echo $cp->tBoton;
										}	
									}
				echo			"</div>
							</td>
						</tr>";
			}

		}

		echo		"</tbody>
				</table>";

	}

	public function subirArchivo() {

		$config['upload_path'] = './images/usuarios';
		$config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG';
		$config['max_size'] = '50000';


		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());

			echo "<input type=\"hidden\" id=\"eExitoArchivo\" value=\"0\">";
			echo "<input type=\"hidden\" id=\"tMensajeArchivo\" value=\"".$error['error']."\">";;

		} else	{
			$data = array('upload_data' => $this->upload->data());

			echo "<input type=\"hidden\" id=\"eExitoArchivo\" value=\"1\">";
			echo "<input type=\"hidden\" id=\"tMensajeArchivo\" value=\"images/usuarios/".$data['upload_data']['file_name']."\">";

		}

	}

	public function ver_correofirma($eCodUsuario){
		if (!$eCodUsuario) {
			echo "";
		} else {
			$con_usuario 	= $this->catalogos_m->con_usuarios($eCodUsuario);
			$fFirma			= imagecreatefromjpeg('./images/usuarios/firma/Ayuntamiento de Manzanillo_navidad.jpg');
			//$tFontRegular	= './images/usuarios/font/arialnarrow.otf';
			$tFontBold		= './images/usuarios/font/arialnarrow-bold.ttf';
			$tFontItalic	= './images/usuarios/font/arialnarrow-bolditalic.ttf';
			$tColorBlanco	= imagecolorallocate($fFirma, 255, 255, 255);
			$tColorNegro	= imagecolorallocate($fFirma, 0, 0, 0);

			foreach ($con_usuario as $dato) {
				$tNombre	= trim($dato->tNombre);
				$tPuesto	= trim($dato->tPuesto);
				$tCorreo	= trim($dato->tCorreo);
				$tCelular	= ($dato->tTelefono ? "Cel: ".trim($dato->tTelefono) : "");
				$tTelefono	= "Tel: 01 (314) 138 46 62 / 63";

				$aDimension	= imagettfbbox((strlen($tNombre)>30 ? 35 : 45), 0, $tFontBold, $tNombre);
				$eTextWidth	= abs($aDimension[4] - $aDimension[0]);
				$x			= imagesx($fFirma) - $eTextWidth;
				imagettftext($fFirma, (strlen($tNombre)>30 ? 35 : 45), 0, $x-580, 80, $tColorNegro, $tFontBold, $tNombre);

				$aDimension	= imagettfbbox((strlen($tPuesto)>35 ? 25 : 35), 0, $tFontBold, $tPuesto);
				$eTextWidth	= abs($aDimension[4] - $aDimension[0]);
				$x			= imagesx($fFirma) - $eTextWidth;
				imagettftext($fFirma, (strlen($tPuesto)>35 ? 25 : 35), 0, $x-580, 125, $tColorBlanco, $tFontBold, $tPuesto);

				$aDimension	= imagettfbbox((strlen($tCorreo)>35 ? 25 : 35), 0, $tFontItalic, $tCorreo);
				$eTextWidth	= abs($aDimension[4] - $aDimension[0]);
				$x			= imagesx($fFirma) - $eTextWidth;
				imagettftext($fFirma, (strlen($tCorreo)>35 ? 25 : 35), 0, $x-580, 165, $tColorBlanco, $tFontItalic, $tCorreo);

				$aDimension	= imagettfbbox(35, 0, $tFontBold, $tTelefono);
				$eTextWidth	= abs($aDimension[4] - $aDimension[0]);
				$x			= imagesx($fFirma) - $eTextWidth;
				imagettftext($fFirma, 35, 0, $x-580, 250, $tColorBlanco, $tFontBold, $tTelefono);

				$aDimension	= imagettfbbox(35, 0, $tFontBold, $tCelular);
				$eTextWidth	= abs($aDimension[4] - $aDimension[0]);
				$x			= imagesx($fFirma) - $eTextWidth;
				imagettftext($fFirma, 35, 0, $x-580, 300, $tColorBlanco, $tFontBold, $tCelular);
			}

			imagejpeg($fFirma,'./images/usuarios/firma/'.$dato->eCodUsuario.'.jpg');

			echo "<img src='".base_url()."/images/usuarios/firma/".$dato->eCodUsuario.".jpg' width='100%'>";

		}
	}

}
?>

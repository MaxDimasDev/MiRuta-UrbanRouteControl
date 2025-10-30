<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Catalogo extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->seguridad();
		$this->load->model('secciones_m');
		$this->load->model('consultas_m');
		$this->load->model('catalogos_m');
		$this->load->model('catinserts_m');
		$this->load->helper('date_helper');
		date_default_timezone_set('America/Mexico_City');
		$this->load->library("email");

	}

	function seguridad() {
		if (!$this->session->userdata('bSesion')) {
			redirect(base_url());
		}
	}

	public function m3_s1() { // Items

		$data['con_seccion']		= $this->secciones_m->con_secciones(false, false, "m3_s1");
		$data['con_menu']			= $this->secciones_m->con_menu($this->session->userdata("eCodPerfil"));
		$data['con_permisos']		= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m3_s1");
		$data['con_tipositems']		= $this->catalogos_m->con_tipositems();
		$data['con_items']			= $this->consultas_m->con_items();

		$this->load->view('Encabezado/header', $data);
		$this->load->view('Encabezado/menu');
		$this->load->view('Catalogo/item', $data);

	}


	public function itemdetalle() {
		
		$con_items = $this->consultas_m->con_items($this->input->post("eCodItem"));
		
		foreach ($con_items as $ci) {
			echo 	"<div class=\"panel-body\">
						<div class=\"modal-text\">
							<blockquote class=\"primary\">
								<h3> ".$ci->tNombre."</h3>
							</blockquote>
							<div >
							<table width=\"100%\" class=\"table table-striped mb-none\">
								<tbody>
									<tr>
										<th colspan=\"2\" width=\"50%\">ID:</th>
										<th colspan=\"2\" width=\"50%\">Nombre:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$ci->eCodItem."</td>
										<td width=\"5%\"></td>
										<td>".$ci->tNombre."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"50%\">Tipo:</th>
										<th colspan=\"2\" width=\"50%\">Descripción:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$ci->tTipoItem."</td>
										<td width=\"5%\"></td>
										<td>".$ci->tDescripcion."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"30%\">Precio:</th>
										<th colspan=\"2\" width=\"30%\">Fecha Registro:</th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td>".$ci->dPrecio."</td>
										<td width=\"5%\"></td>
										<td>".$ci->fhFechaRegistro."</td>
									</tr>
									<tr>
										<th colspan=\"2\" width=\"30%\">Estatus:</th>
										<th colspan=\"2\" width=\"30%\"></th>
									</tr>
									<tr>
										<td width=\"5%\"></td>
										<td><label class=\"".$ci->tClase."\">".$ci->tEstatus."</label></td>
										<td width=\"5%\"></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							<br>";
			echo			"</div>
						</div>
					</div>";
		}

	}

	public function editaritem() {
		
		$con_items = $this->consultas_m->con_items($this->input->post("eCodItem"));
		$con_tipositems = $this->catalogos_m->con_tipositems();
		$con_estatus = $this->catalogos_m->con_estatus();
		
		foreach ($con_items as $ci) {
			$tEstrutura =	"<div class=\"col-sm-12\">
									<div class=\"row\">
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
											<label class=\"control-label\" style=\"padding: 3px;\">ID</label>
											<input type=\"text\" id=\"eCodItemEditar\" name=\"eCodItemEditar\" value=\"".$ci->eCodItem."\" class=\"form-control\" readonly>
											</div>
										</div>
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">Estatus</label>
													<select id=\"tCodEstatusEditarItem\" name=\"tCodEstatusEditarItem\" class=\"form-control populate select2\">";
														foreach ($con_estatus as $ce){
															if($ce->tCodEstatus != "EL"){
																if($ci->tCodEstatus == $ce->tCodEstatus){
																	$tEstrutura .=	"<option value=\"".$ce->tCodEstatus."\" selected>".$ce->tNombre."</option>";
																}else{
																	$tEstrutura .=	"<option value=\"".$ce->tCodEstatus."\">".$ce->tNombre."</option>";
																}
															}

														}
									$tEstrutura .=	"</select>";
							$tEstrutura .="</div>
										</div>
									</div>
									<div class=\"row\">
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">Nombre</label>
												<input type=\"text\" id=\"tNombreEditarItem\" name=\"tNombreEditarItem\" value=\"".$ci->tNombre."\" class=\"form-control\">
											</div>
										</div>
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">Tipo Item</label>
													<select id=\"eCodTipoItemEditarItem\" name=\"eCodTipoItemEditarItem\" class=\"form-control populate select2\">";
														foreach ($con_tipositems as $ctig){
															if($ci->eCodTipoItem == $ctig->eCodTipoItem){
																$tEstrutura .=	"<option value=\"".$ctig->eCodTipoItem."\" selected>".$ctig->tNombre."</option>";
															}else{
																$tEstrutura .=	"<option value=\"".$ctig->eCodTipoItem."\">".$ctig->tNombre."</option>";
															}
														}
														$tEstrutura .=	"</select>";
							 $tEstrutura .="</div>
										</div>
									</div>
									<div class=\"row\">
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">Descripcion</label>
												<input type=\"text\" id=\"tDescripcionEditarItem\" name=\"tDescripcionEditarItem\" value=\"".$ci->tDescripcion."\" class=\"form-control\">
											</div>
										</div>
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">Precio</label>
												<input type=\"number\" step=\"0.01\" placeholder=\"0.00\" id=\"dPrecioEditarItem\" name=\"dPrecioNuevoItem\" value=\"".$ci->dPrecio."\" class=\"form-control\"/>
											</div>
										</div>
									</div>
								</div>
							</div>";
			echo $tEstrutura;
		}
	}

	public function guardar() {
		$aDatos['tNombre']				= ($this->input->post("tNombreNuevoItem")			? $this->input->post("tNombreNuevoItem")				: NULL);
		$aDatos['eCodTipoItem']			= ($this->input->post("eCodTipoItemNuevoItem")		? $this->input->post("eCodTipoItemNuevoItem")			: NULL);
		$aDatos['tDescripcion']			= ($this->input->post("tDescripcionNuevoItem")		? $this->input->post("tDescripcionNuevoItem")			: NULL);
		$aDatos['dPrecio']				= ($this->input->post("dPrecioNuevoItem")			? $this->input->post("dPrecioNuevoItem")				: NULL);
		$aDatos['fhFechaRegistro']		= mdate('%Y/%m/%d %H:%i:%s', time());
		$aDatos['tCodEstatus']			= 'AC';

		$aRes = $this->catinserts_m->ins_item($aDatos);

		echo "<input type=\"hidden\" id=\"eCodItem\" name=\"eCodItem\" value=\"".$aRes['eCodItem']."\">";
		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
		echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Resgistro de Item exitoso </strong></div>";

	}

	public function actualizaritem() {
		$aDatos['eCodItem'] 			= ($this->input->post("eCodItemEditar")		    	? $this->input->post("eCodItemEditar") 					: NULL);
		$aDatos['tNombre']				= ($this->input->post("tNombreEditarItem")			? $this->input->post("tNombreEditarItem")				: NULL);
		$aDatos['eCodTipoItem']			= ($this->input->post("eCodTipoItemEditarItem")		? $this->input->post("eCodTipoItemEditarItem")			: NULL);
		$aDatos['tDescripcion']			= ($this->input->post("tDescripcionEditarItem")		? $this->input->post("tDescripcionEditarItem")			: NULL);
		$aDatos['dPrecio']				= ($this->input->post("dPrecioEditarItem")			? $this->input->post("dPrecioEditarItem")				: NULL);
		$aDatos['tCodEstatus']			= ($this->input->post("tCodEstatusEditarItem")		? $this->input->post("tCodEstatusEditarItem")			: NULL);
		
		//print_r($aDatos);
		$aRes = $this->catinserts_m->upd_item($aDatos);

		echo "<input type=\"hidden\" id=\"eCodItem\" name=\"eCodItem\" value=\"".$aRes['eCodItem']."\">";
		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";
		echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Item actualizado satisfactoriamente</strong></div>";
	
	}
	public function cargaritemeliminar() {
		
		$con_items = $this->consultas_m->con_items($this->input->post("eCodItem"));
		
		foreach ($con_items as $ci) {
			$tEstrutura =	"   <div class=\"col-sm-12\">
									<div class=\"row\">
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												<label class=\"control-label\" style=\"padding: 3px;\">ID</label>
												<input type=\"text\" id=\"eCodItemEliminar\" name=\"eCodItemEliminar\" value=\"".$ci->eCodItem."\" class=\"form-control\" readonly>
											</div>
										</div>
										<div class=\"col-sm-6\">
											<div class=\"form-group\">
												&nbsp
											</div>
										</div>
									</div>
							    </div>";
			echo $tEstrutura;
		}
	}
	public function eliminaritem() {

		$aDatos['eCodItem']				= ($this->input->post("eCodItemEliminar")	? $this->input->post("eCodItemEliminar")	: NULL);

		//print_r($aDatos);
		$aRes = $this->catinserts_m->upd_eliminaritem($aDatos);

		echo "<input type=\"hidden\" id=\"eExito\" name=\"eExito\" value=\"".$aRes['eExito']."\">";

		if ($aRes['eExito']==1) {

			echo "<input type=\"hidden\" id=\"eCodItem\" name=\"eCodItem\" value=\"".$aRes['eCodItem']."\">";
			echo "<div class=\"alert alert-success\"><strong><i class=\"fa fa-check\"></i> Item eliminado con éxito! </strong></div>";
		} else {
			echo "<div class=\"alert alert-danger\"><strong><i class=\"fa fa-times\"></i> ¡Error Inesperado, Cod. 101! </strong>, intente más tarde, si persiste el error llame a soporte.</div>";
		}

	}

	public function filtro_item(){
		
		$eCodTipoItem	= ($this->input->post("eCodTipoItemFiltro")	? $this->input->post("eCodTipoItemFiltro") : false);

		$con_permisos	= $this->secciones_m->con_perfilpermiso($this->session->userdata("eCodPerfil"), "m3_s1");
		$con_items		= $this->consultas_m->con_items(false, false, false, $eCodTipoItem);
		

		echo 	"<table class=\"table table-bordered table-striped mb-none\" id=\"datatable-default\">
					<thead>
						<th>Código</th>
						<th>Nombre</th>
						<th>Tipo</th>
						<th>Precio</th>
						<th>Acción</th>
					</thead>
					<tbody>";

		if (isset($con_items)){
			foreach ($con_items as $ci) {
				echo 	"<tr>
							<td>".str_pad($ci->eCodItem, 6, "0", STR_PAD_LEFT)."</td>
							<td>".$ci->tNombre."</td>
							<td>".$ci->tTipoItem."</td>
							<td>".$ci->dPrecio."</td>
							<td>
								<div id=\"".$ci->eCodItem."\" class=\"btn-group\">";
									foreach ($con_permisos as $cp) { 
										if (strrpos($cp->aEstatus, $ci->tCodEstatus)!==false) { 
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


}
?>
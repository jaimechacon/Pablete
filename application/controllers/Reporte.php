<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('reporte_model');
		$this->load->model('institucion_model');
		$this->load->model('hospital_model');
		$this->load->model('cuenta_model');
		$this->load->model('item_model');
		$this->load->model('asignacion_model');
		$this->load->model('sub_asignacion_model');
		$this->load->model('usuario_model');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('inicio', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarReportes()
	{
		$usuario = $this->session->userdata();
		
		if($this->session->userdata('id_usuario'))
		{
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			/*mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			mysqli_next_result($this->db->conn_id);
			$items = $this->item_model->listarItemsUsu($usuario["id_usuario"], "null");
			if($items)
				$usuario["items"] = $items;*/

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumen($usuario["id_usuario"], $idInstitucion, $idArea, "null");
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenGasto($usuario["id_usuario"], $idInstitucion, $idArea, "null");
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesTipo = $this->reporte_model->listarReporteResumenTipo($usuario["id_usuario"], $idInstitucion, $idArea, "null");
			if($reporteResumenesTipo)
				$usuario["reporteResumenesTipo"] = $reporteResumenesTipo;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesTipoGasto = $this->reporte_model->listarReporteResumenTipoGasto($usuario["id_usuario"], $idInstitucion, $idArea, "null");
			if($reporteResumenesTipoGasto)
				$usuario["reporteResumenesTipoGasto"] = $reporteResumenesTipoGasto;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGraficos = $this->reporte_model->listarReporteResumenGrafico($usuario["id_usuario"], $idInstitucion, $idArea, 1);
			if($reporteResumenesGraficos)
				$usuario["reporteResumenesGraficos"] = $reporteResumenesGraficos;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGraficos22 = $this->reporte_model->listarReporteResumenGrafico($usuario["id_usuario"], $idInstitucion, $idArea, 2);
			if($reporteResumenesGraficos22)
				$usuario["reporteResumenesGraficos22"] = $reporteResumenesGraficos22;

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportes', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReportesItem()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			if(!is_null($this->input->GET('idCuenta')) && $this->input->GET('idCuenta') != "")
            {
            	$idCuenta = $this->input->GET('idCuenta');
			}

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			/*mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			mysqli_next_result($this->db->conn_id);
			$items = $this->item_model->listarItemsUsu($usuario["id_usuario"], "null");
			if($items)
				$usuario["items"] = $items;*/

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumenItem($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, 2);
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenItem($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, 1);
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			if($idCuenta != "null")
			{
				mysqli_next_result($this->db->conn_id);
				$cuenta = $this->cuenta_model->obtenerCuenta($idCuenta);
				$usuario['cuentaSeleccion'] = $cuenta[0];
			}else{
				$cuentaSeleccion["id_cuenta"] = "null";
				$cuentaSeleccion["codigo"] = "";
				$cuentaSeleccion["nombre"] = "SIN DESCRIPCI&Oacute;N DE ITEM";
				$usuario['cuentaSeleccion'] = $cuentaSeleccion;
			}			

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesItem', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReportesAsignacion()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$idItem = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			if(!is_null($this->input->GET('idCuenta')) && $this->input->GET('idCuenta') != "")
            {
            	$idCuenta = $this->input->GET('idCuenta');
			}

			if(!is_null($this->input->GET('idItem')) && $this->input->GET('idItem') != "")
            {
            	$idItem = $this->input->GET('idItem');
			}

			$usuario['idCuenta'] = $idCuenta;

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			/*mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			mysqli_next_result($this->db->conn_id);
			$items = $this->item_model->listarItemsUsu($usuario["id_usuario"], "null");
			if($items)
				$usuario["items"] = $items;*/

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumenAsignacion($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, 2);
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenAsignacion($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, 1);
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			if($idItem != "null")
			{
				mysqli_next_result($this->db->conn_id);
				$item = $this->item_model->obtenerItem($idItem);
				$usuario['itemSeleccion'] = $item[0];
			}else{
				$itemSeleccion["id_item"] = "null";
				$itemSeleccion["codigo"] = "";
				$itemSeleccion["nombre"] = "SIN DESCRIPCI&Oacute;N DE ASIGNACION";
				$usuario['itemSeleccion'] = $itemSeleccion;
			}
			

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesAsignacion', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}
	
	public function listarReportesSubAsignacion()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$idItem = "null";
			$idAsignacion = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			if(!is_null($this->input->GET('idCuenta')) && $this->input->GET('idCuenta') != "")
            {
            	$idCuenta = $this->input->GET('idCuenta');
			}

			if(!is_null($this->input->GET('idItem')) && $this->input->GET('idItem') != "")
            {
            	$idItem = $this->input->GET('idItem');
			}

			if(!is_null($this->input->GET('idAsignacion')) && $this->input->GET('idAsignacion') != "")
            {
            	$idAsignacion = $this->input->GET('idAsignacion');
			}

			$usuario['idCuenta'] = $idCuenta;
			$usuario['idItem'] = $idItem;
			//var_dump($usuario);

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			/*mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			mysqli_next_result($this->db->conn_id);
			$items = $this->item_model->listarItemsUsu($usuario["id_usuario"], "null");
			if($items)
				$usuario["items"] = $items;*/

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumenSubAsignacion($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, $idAsignacion, 2);
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenSubAsignacion($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, $idAsignacion, 1);
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			if($idAsignacion != "null")
			{
				mysqli_next_result($this->db->conn_id);
				$asignacion = $this->asignacion_model->obtenerAsignacion($idAsignacion);
				$usuario['asignacionSeleccion'] = $asignacion[0];
			}else{
				$asignacionSeleccion["id_asignacion"] = "null";
				$asignacionSeleccion["codigo"] = "";
				$asignacionSeleccion["nombre"] = "SIN DESCRIPCION DE ASIGNACION";
				$usuario['asignacionSeleccion'] = $asignacionSeleccion;
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesSubAsignacion', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReportesEspecifico()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$idItem = "null";
			$idAsignacion = "null";
			$idSubAsignacion = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			if(!is_null($this->input->GET('idCuenta')) && $this->input->GET('idCuenta') != "")
            {
            	$idCuenta = $this->input->GET('idCuenta');
			}

			if(!is_null($this->input->GET('idItem')) && $this->input->GET('idItem') != "")
            {
            	$idItem = $this->input->GET('idItem');
			}

			if(!is_null($this->input->GET('idAsignacion')) && $this->input->GET('idAsignacion') != "")
            {
            	$idAsignacion = $this->input->GET('idAsignacion');
			}

			if(!is_null($this->input->GET('idSubAsignacion')) && $this->input->GET('idSubAsignacion') != "")
            {
            	$idSubAsignacion = $this->input->GET('idSubAsignacion');
			}

			$usuario['idCuenta'] = $idCuenta;
			$usuario['idItem'] = $idItem;
			$usuario['idAsignacion'] = $idAsignacion;

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			/*mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			mysqli_next_result($this->db->conn_id);
			$items = $this->item_model->listarItemsUsu($usuario["id_usuario"], "null");
			if($items)
				$usuario["items"] = $items;*/

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumenEspecifico($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, $idAsignacion, $idSubAsignacion, 2);
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenEspecifico($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $idItem, $idAsignacion, $idSubAsignacion, 1);
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			if($idSubAsignacion != "null")
			{
				mysqli_next_result($this->db->conn_id);
				$subAsignacion = $this->sub_asignacion_model->obtenerSubAsignacion($idSubAsignacion);
				$usuario['subasignacionSeleccion'] = $subAsignacion[0];
			}else{
				$subasignacionSeleccion["id_sub_asignacion"] = "null";
				$subasignacionSeleccion["codigo"] = "";
				$subasignacionSeleccion["nombre"] = "SIN DESCRIPCIÓN DE ASIGNACION";
				$usuario['subasignacionSeleccion'] = $subasignacionSeleccion;
			}			

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesEspecifico', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}

	public function listarHospitalesInstitucion()
	{
		$usuario = $this->session->userdata();
		$hospitales = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $institucion);
			echo json_encode($hospitales);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumen()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenes = $this->reporte_model->listarReporteResumen($usuario["id_usuario"], $institucion, $hospital, $cuenta);
		}
		echo json_encode($reporteResumenes);
	}

	public function listarReporteResumenItem()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenes = $this->reporte_model->listarReporteResumenItem($usuario["id_usuario"], $institucion, $hospital, $cuenta, 2);

			echo json_encode($reporteResumenes);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenAsignacion()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenes = $this->reporte_model->listarReporteResumenAsignacion($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, 2);

			echo json_encode($reporteResumenes);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenSubAsignacion()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$asignacion = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('asignacion')) && $this->input->post('asignacion') != "-1")
				$asignacion = $this->input->post('asignacion');

			$reporteResumenes = $this->reporte_model->listarReporteResumenSubAsignacion($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, $asignacion, 2);

			echo json_encode($reporteResumenes);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenEspecifico()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$asignacion = "null";
			$subAsignacion = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('asignacion')) && $this->input->post('asignacion') != "-1")
				$asignacion = $this->input->post('asignacion');

			if(!is_null($this->input->post('subAsignacion')) && $this->input->post('subAsignacion') != "-1")
				$subAsignacion = $this->input->post('subAsignacion');

			$reporteResumenes = $this->reporte_model->listarReporteResumenEspecifico($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, $asignacion, $subAsignacion, 2);
		
			echo json_encode($reporteResumenes);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenFecha()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$mes = "null";
			$anio = "null";
			$inflactor = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('mes')) && $this->input->post('mes') != "-1")
				$mes = $this->input->post('mes');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1")
				$anio = $this->input->post('anio');

			if(!is_null($this->input->post('inflactor')) && $this->input->post('inflactor') != "-1")
				$inflactor = $this->input->post('inflactor');

			$reporteResumenes = $this->reporte_model->listarReporteResumenFecha($usuario["id_usuario"], $institucion, $hospital, $cuenta, $mes, $anio, $inflactor, 2);

			echo json_encode($reporteResumenes);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenGasto($usuario["id_usuario"], $institucion, $hospital, $cuenta);

			echo json_encode($reporteResumenesGastos);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenItemGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenItem($usuario["id_usuario"], $institucion, $hospital, $cuenta, 1);

			echo json_encode($reporteResumenesGastos);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenAsignacionGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenAsignacion($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, 1);

			echo json_encode($reporteResumenesGastos);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenSubAsignacionGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$asignacion = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('asignacion')) && $this->input->post('asignacion') != "-1")
				$asignacion = $this->input->post('asignacion');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenSubAsignacion($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, $asignacion, 1);

			echo json_encode($reporteResumenesGastos);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenEspecificoGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$asignacion = "null";
			$subAsignacion = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('asignacion')) && $this->input->post('asignacion') != "-1")
				$asignacion = $this->input->post('asignacion');

			if(!is_null($this->input->post('subAsignacion')) && $this->input->post('subAsignacion') != "-1")
				$subAsignacion = $this->input->post('subAsignacion');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenEspecifico($usuario["id_usuario"], $institucion, $hospital, $cuenta, $item, $asignacion, $subAsignacion, 1);

			echo json_encode($reporteResumenesGastos);
		}else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenFechaGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesGastos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$mes = "null";
			$anio = "null";
			$inflactor = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('mes')) && $this->input->post('mes') != "-1")
				$mes = $this->input->post('mes');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1")
				$anio = $this->input->post('anio');

			if(!is_null($this->input->post('inflactor')) && $this->input->post('inflactor') != "-1")
				$inflactor = $this->input->post('inflactor');

			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenFecha($usuario["id_usuario"], $institucion, $hospital, $cuenta, $mes, $anio, $inflactor, 1);

			echo json_encode($reporteResumenesGastos);
		}
		else
		{
			redirect('Login');
		}
	}


	public function listarReporteResumenTipo()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesTipo = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenesTipo = $this->reporte_model->listarReporteResumenTipo($usuario["id_usuario"], $institucion, $hospital, $cuenta);

			echo json_encode($reporteResumenesTipo);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenTipoGasto()
	{
		$usuario = $this->session->userdata();
		$reporteResumenesTipoGasto = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			$reporteResumenesTipoGasto = $this->reporte_model->listarReporteResumenTipoGasto($usuario["id_usuario"], $institucion, $hospital, $cuenta);

			echo json_encode($reporteResumenesTipoGasto);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReportesFecha()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$mes = "null";
			$anio = "null";
			$inflactor = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

            if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			mysqli_next_result($this->db->conn_id);
			$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
			$anios[] = array();
         	unset($anios[0]);


			/*$idInstitucion = 1;
         	mysqli_next_result($this->db->conn_id);
			$listarReporteGrafico22 = $this->reporte_model->listarReporteGrafico22($usuario["id_usuario"], $idInstitucion, $idArea);
			if($listarReporteGrafico22)
				$usuario["listarReporteGrafico22"] = $listarReporteGrafico22;
*/
			//var_dump($listarReporteGrafico22);

			foreach ($mesesAnios as $mesAnio) {	

				$anioEncontrado = array();
         		unset($anioEncontrado);

         		$anioEncontrado['idAnio'] = $mesAnio['idAnio'];
         		$anioEncontrado['nombreAnio'] = $mesAnio['nombreAnio'];

         		if(!in_array($anioEncontrado, $anios))
                	array_push($anios, $anioEncontrado);
			}
			$usuario['anios'] = $anios;

			$meses[] = array();
         	unset($meses[0]);

			foreach ($mesesAnios as $mes) {	

				$mesEncontrado = array();
         		unset($mesEncontrado);

         		$mesEncontrado['idMes'] = $mes['idMes'];
         		$mesEncontrado['nombreMes'] = $mes['nombreMes'];

         		if(!in_array($mesEncontrado, $meses))
                	array_push($meses, $mesEncontrado);
			}
			$usuario['meses'] = $meses;
			$usuario['anioSeleccionado'] = $mesesAnios[0]["anioSeleccionado"];
			$usuario['mesSeleccionado'] = $mesesAnios[0]["mesSeleccionado"];

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteResumenFecha($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $mesesAnios[0]["mesSeleccionado"], $mesesAnios[0]["anioSeleccionado"], $inflactor, 2);
			if($reporteResumenes)
				$usuario["reporteResumenes"] = $reporteResumenes;

			mysqli_next_result($this->db->conn_id);
			$reporteResumenesGastos = $this->reporte_model->listarReporteResumenFecha($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $mesesAnios[0]["mesSeleccionado"], $mesesAnios[0]["anioSeleccionado"], $inflactor, 1);
			if($reporteResumenesGastos)
				$usuario["reporteResumenesGastos"] = $reporteResumenesGastos;

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesFecha', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReportesEquilibrioFinanciero()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$mes = "null";
			$anio = "null";
			$inflactor = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

            if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			mysqli_next_result($this->db->conn_id);
			$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
			$anios[] = array();
         	unset($anios[0]);


			/*$idInstitucion = 1;
         	mysqli_next_result($this->db->conn_id);
			$listarReporteGrafico22 = $this->reporte_model->listarReporteGrafico22($usuario["id_usuario"], $idInstitucion, $idArea);
			if($listarReporteGrafico22)
				$usuario["listarReporteGrafico22"] = $listarReporteGrafico22;
*/
			//var_dump($listarReporteGrafico22);

			foreach ($mesesAnios as $mesAnio) {	

				$anioEncontrado = array();
         		unset($anioEncontrado);

         		$anioEncontrado['idAnio'] = $mesAnio['idAnio'];
         		$anioEncontrado['nombreAnio'] = $mesAnio['nombreAnio'];

         		if(!in_array($anioEncontrado, $anios))
                	array_push($anios, $anioEncontrado);
			}
			$usuario['anios'] = $anios;

			$meses[] = array();
         	unset($meses[0]);

			foreach ($mesesAnios as $mese) {	

				$mesEncontrado = array();
         		unset($mesEncontrado);

         		$mesEncontrado['idMes'] = $mese['idMes'];
         		$mesEncontrado['nombreMes'] = $mese['nombreMes'];

         		if(!in_array($mesEncontrado, $meses))
                	array_push($meses, $mesEncontrado);
			}
			$usuario['meses'] = $meses;
			$usuario['anioSeleccionado'] = $mesesAnios[0]["anioSeleccionado"];
			//$usuario['mesSeleccionado'] = $mesesAnios[0]["mesSeleccionado"];

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteEquilibrioFinanciero($usuario["id_usuario"], $idInstitucion, $idArea, $idCuenta, $mes, $mesesAnios[0]["anioSeleccionado"]);
			if($reporteResumenes)
			{

				$ponderado_2017 = 0;
				$ponderado_2018 = 0;
				$cant_2017 = 0;
				$cant_2018 = 0;

				for ($i=0; $i < sizeof($reporteResumenes); $i++) { 
					$puntuacion = null;
					$cumplimiento = (float)$reporteResumenes[$i]['cumplimiento'];
					$anio = (int)$reporteResumenes[$i]['anio'];

					#var_dump($cumplimiento);
					if($cumplimiento > 1.030)
						$puntuacion = 0;
					else
						if($cumplimiento > 1.020)
							$puntuacion = 1;
						else
							if($cumplimiento > 1.010)
								$puntuacion = 2;
						else
							if($cumplimiento > 1.000)
								$puntuacion = 3;
							else
								if($cumplimiento <= 1.000)
									$puntuacion = 4;

					//var_dump($cumplimiento);
					//var_dump($cumplimiento);
					if ($anio == 2017)
					{
						$ponderado_2017 = $ponderado_2017 + $cumplimiento;
						$cant_2017 = $cant_2017 + 1;
					}
					
					if ($anio == 2018)
					{

						//$suma = $ponderado_2018 + $cumplimiento;
						$ponderado_2018 = ($ponderado_2018 + $cumplimiento);
						$cant_2018 = $cant_2018 + 1;						
					} 

					$reporteResumenes[$i]['puntuacion'] = $puntuacion;
					//array_push($reporteResumenes[$i], $puntuacion);	
				}


				$reporteResumenes[0]['2017'] = ($cant_2017 > 0 ? ($ponderado_2017/$cant_2017) : 0 );
				$reporteResumenes[0]['2018'] = ($cant_2018 > 0 ? ($ponderado_2018/$cant_2018) : 0 );
				$usuario["reporteResumenes"] = $reporteResumenes;
				//var_dump($reporteResumenes);
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesEquilibrioFinanciero', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
		else
		{
			redirect('Login');
		}
	}


	public function listarReportesRecaudacion()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			$idInstitucion = "null";
			$idArea = "null";
			$idCuenta = "null";
			$mes = "null";
			$anio = "null";
			$inflactor = "null";

			if(!is_null($this->input->GET('idInstitucion')) && $this->input->GET('idInstitucion'))
			{
            	$idInstitucion = $this->input->GET('idInstitucion');
            	$usuario['idInstitucion'] = $idInstitucion;
			}

			if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

            if(!is_null($this->input->GET('idArea')) && $this->input->GET('idArea'))
			{
            	$idArea = $this->input->GET('idArea');
            	$usuario['idHospital'] = $idArea;
            }

			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			mysqli_next_result($this->db->conn_id);
			$hospitales = $this->hospital_model->listarHospitalesUsu($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			mysqli_next_result($this->db->conn_id);
			$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
			$anios[] = array();
         	unset($anios[0]);


			/*$idInstitucion = 1;
         	mysqli_next_result($this->db->conn_id);
			$listarReporteGrafico22 = $this->reporte_model->listarReporteGrafico22($usuario["id_usuario"], $idInstitucion, $idArea);
			if($listarReporteGrafico22)
				$usuario["listarReporteGrafico22"] = $listarReporteGrafico22;
*/
			//var_dump($listarReporteGrafico22);

			foreach ($mesesAnios as $mesAnio) {	

				$anioEncontrado = array();
         		unset($anioEncontrado);

         		$anioEncontrado['idAnio'] = $mesAnio['idAnio'];
         		$anioEncontrado['nombreAnio'] = $mesAnio['nombreAnio'];

         		if(!in_array($anioEncontrado, $anios))
                	array_push($anios, $anioEncontrado);
			}
			$usuario['anios'] = $anios;

			$meses[] = array();
         	unset($meses[0]);

			foreach ($mesesAnios as $mese) {	

				if($mesesAnios[0]["anioSeleccionado"] == $mese['anioSeleccionado'])
				{
					$mesEncontrado = array();
	         		unset($mesEncontrado);

	         		$mesEncontrado['idMes'] = $mese['idMes'];
	         		$mesEncontrado['nombreMes'] = $mese['nombreMes'];

	         		if(!in_array($mesEncontrado, $meses))
	                	array_push($meses, $mesEncontrado);
				}
			}

			$usuario['meses'] = $meses;
			$usuario['anioSeleccionado'] = $mesesAnios[0]["anioSeleccionado"];
			//$usuario['mesSeleccionado'] = $mesesAnios[0]["mesSeleccionado"];

			mysqli_next_result($this->db->conn_id);
			$reporteResumenes = $this->reporte_model->listarReporteRecaudacionIngresos($usuario["id_usuario"], $idInstitucion, $idArea, $mesesAnios[0]["anioSeleccionado"], $mes);

			if($reporteResumenes)
			{
				$usuario["reporteResumenes"] = $reporteResumenes;
				//var_dump($reporteResumenes);
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarReportesRecaudacion', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteGrafico()
	{
		$usuario = $this->session->userdata();
		$listarReporteGrafico = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$tipo = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('tipo')) && $this->input->post('tipo') != "-1")
				$tipo = $this->input->post('tipo');

			$listarReporteGrafico = $this->reporte_model->listarReporteGrafico($usuario["id_usuario"], $institucion, $hospital, $cuenta, $tipo);

			echo json_encode($listarReporteGrafico);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReporteResumenGrafico()
	{
		$usuario = $this->session->userdata();
		$listarReportResumeneGrafico = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$item = "null";
			$tipo = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('item')) && $this->input->post('item') != "-1")
				$item = $this->input->post('item');

			if(!is_null($this->input->post('tipo')) && $this->input->post('tipo') != "-1")
				$tipo = $this->input->post('tipo');

			$listarReportResumeneGrafico = $this->reporte_model->listarReporteResumenGrafico($usuario["id_usuario"], $institucion, $hospital, $tipo);

			echo json_encode($listarReportResumeneGrafico);
		}
		else
		{
			redirect('Login');
		}
	}



	public function listarReporteResumenGraficoProduccion()
	{
		$usuario = $this->session->userdata();
		$listarReportResumeneGrafico = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$grupo = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('grupo')) && $this->input->post('grupo') != "-1")
				$grupo = $this->input->post('grupo');

			$listarReportResumeneGrafico = $this->reporte_model->listarReporteGraficoProduccion($usuario["id_usuario"], $institucion, $hospital, $grupo);

			echo json_encode($listarReportResumeneGrafico);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReportesEquilibrioFinancieroFiltro()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$cuenta = "null";
			$mes = "null";
			$anio = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('cuenta')) && $this->input->post('cuenta') != "-1")
				$cuenta = $this->input->post('cuenta');

			if(!is_null($this->input->post('mes')) && $this->input->post('mes') != "-1")
				$mes = $this->input->post('mes');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1")
				$anio = $this->input->post('anio');

			$reporteResumenes = $this->reporte_model->listarReporteEquilibrioFinanciero($usuario["id_usuario"], $institucion, $hospital, $cuenta, $mes, $anio);

			$ponderado_2017 = 0;
			$ponderado_2018 = 0;
			$cant_2017 = 0;
			$cant_2018 = 0;



			for ($i=0; $i < sizeof($reporteResumenes); $i++) { 
				$puntuacion = null;
				$cumplimiento = (float)$reporteResumenes[$i]['cumplimiento'];
				$anio = (float)$reporteResumenes[$i]['anio'];

				$puntuacion = ($cumplimiento > 1.030 ? 0 : ($cumplimiento > 1.020 ? 1 : ($cumplimiento > 1.010 ? 2 : ($cumplimiento > 1.000 ? 3 : ($cumplimiento <= 1.000 ? 4 : null)))));
				//var_dump($puntuacion);

				if ($anio == 2017)
				{
					$ponderado_2017 = $ponderado_2017 + $cumplimiento;
					$cant_2017++;
				}

				if ($anio == 2018)
				{
					$ponderado_2018 = $ponderado_2018 + $cumplimiento;
					$cant_2018++;
				} 

				$reporteResumenes[$i]['puntuacion'] = $puntuacion;
				//array_push($reporteResumenes[$i], $puntuacion);	
			}
			$reporteResumenes[0]['2017'] = ($cant_2017 > 0 ? ($ponderado_2017/$cant_2017) : 0 );
			$reporteResumenes[0]['2018'] = ($cant_2018 > 0 ? ($ponderado_2018/$cant_2018) : 0 );

			echo json_encode($reporteResumenes);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarReportesRecaudacionFiltro()
	{
		$usuario = $this->session->userdata();
		$reporteResumenes = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$mes = "null";
			$anio = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('mes')) && $this->input->post('mes') != "-1")
				$mes = $this->input->post('mes');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1")
				$anio = $this->input->post('anio');

			$reporteResumenes = $this->reporte_model->listarReporteRecaudacionIngresos($usuario["id_usuario"], $institucion, $hospital, $anio, $mes);
			
			echo json_encode($reporteResumenes);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarMesesAnios()
	{
		$usuario = $this->session->userdata();
		$meses = [];
		if($this->session->userdata('id_usuario'))
		{
			$anios = "null";
			if(!is_null($this->input->post('anios')) && $this->input->post('anios') != "-1")
				$anios = $this->input->post('anios');

			$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
			
			$meses[] = array();
         	unset($meses[0]);

			foreach ($mesesAnios as $mese) {	

				if($anios != "null")
				{
					if($anios == $mese['anioSeleccionado'])
					{
						$mesEncontrado = array();
		         		unset($mesEncontrado);

		         		$mesEncontrado['idMes'] = $mese['idMes'];
		         		$mesEncontrado['nombreMes'] = $mese['nombreMes'];

		         		if(!in_array($mesEncontrado, $meses))
		                	array_push($meses, $mesEncontrado);
					}
				}else{
					$mesEncontrado = array();
	         		unset($mesEncontrado);

	         		$mesEncontrado['idMes'] = $mese['idMes'];
	         		$mesEncontrado['nombreMes'] = $mese['nombreMes'];

	         		if(!in_array($mesEncontrado, $meses))
	                	array_push($meses, $mesEncontrado);	
				}
			}
			echo json_encode($meses);
		}else
		{
			redirect('Login');
		}
	}
	
}

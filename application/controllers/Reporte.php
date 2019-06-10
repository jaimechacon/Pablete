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
		$this->load->library('pdf');
		$this->load->library('excel');
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

	public function listarHospitalesInstitucionPagosTesoreria()
	{
		$usuario = $this->session->userdata();
		$hospitales = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			$hospitales = $this->hospital_model->listarHospitalesUsuPagosTesoreria($usuario["id_usuario"], $institucion);
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

	public function enviarEvaluaciones($id_institucion)
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario') && is_numeric($id_institucion) && $id_institucion > 0)
		{			
			$usuarios_directores = $this->reporte_model->listarUsuariosEvaluadosUsuario($usuario['id_usuario'], $id_institucion);
			//$usuarios_directores = $this->reporte_model->listarUsuariosEvaluados($usuario['id_usuario']);
			if($usuarios_directores)
			{
				if(sizeof($usuarios_directores) > 0)
				{
					$nombres = $usuarios_directores[0]["u_nombres"];
					$apellidos = $usuarios_directores[0]["u_apellidos"];
					$email = $usuarios_directores[0]["u_email"];
					$telefono = $usuarios_directores[0]["u_telefono"];
					$celular = $usuarios_directores[0]["u_celular"];
					$direccion = $usuarios_directores[0]["u_direccion"];
					$perfil = $usuarios_directores[0]["pf_nombre"];
					$id_institucion = $usuarios_directores[0]["id_institucion"];
					$codigo_ss = $usuarios_directores[0]["codigo"];
					$nombre_ss = $usuarios_directores[0]["nombre"];
					$abreviacion_ss = $usuarios_directores[0]["abreviacion"];
					mysqli_next_result($this->db->conn_id);
					$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
					$anios[] = array();
		         	unset($anios[0]);

		         	$mes = "null";
					$anio = "null";
					$idArea = "null";
					$idCuenta = "null";
					
					//$usuario['mesSeleccionado'] = $mesesAnios[0]["mesSeleccionado"];

					mysqli_next_result($this->db->conn_id);
					$reporteResumenes = $this->reporte_model->listarReporteRecaudacionIngresosSS($usuario["id_usuario"], $id_institucion, $idArea, $mesesAnios[0]["anioSeleccionado"], $mes);

					mysqli_next_result($this->db->conn_id);
					$equilibrioFinaciero = $this->reporte_model->listarReporteEquilibrioFinancieroSS($usuario["id_usuario"], $id_institucion, $idArea, $idCuenta, $mes, $mesesAnios[0]["anioSeleccionado"]);

					$id_hospitalEF = $equilibrioFinaciero[0]['id_hospital'];
					$headerEF = '<div class="row">
									<div class="col-sm-12">

										<div class="card">
											<div class="card-header">
													<div class="d-flex">
													  <div class="mr-auto p-2">
													 	<p class="text-left">II. Equilibrio Financiero (Vista en M$) '.utf8_encode($equilibrioFinaciero[0]['nombre_hospital']).'</p>
													  </div>
													 	
													  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
													</div>
											</div>		
										</div>
								
										<div id="tablaReporteResumen" class="row">
											<div class="col-sm-12 text-right">
											<br/>
												<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
													<thead class="thead-dark">
														<tr>
															<th class="text-center texto-pequenio" scope="col">Area</th>
															<th class="text-center texto-pequenio" scope="col">Mes</th>
															<th class="text-center texto-pequenio" scope="col">A&ntilde;o</th>
															<th class="text-center texto-pequenio" scope="col">Gastos Devengados ( $ )</th>
															<th class="text-center texto-pequenio" scope="col">Ingresos Devengados ( $ )</th>
															<th class="text-center texto-pequenio" scope="col">Cumplimiento Coeficiente</th>
															<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n</th>
														</tr>
													</thead>
													<tbody id="tbodyReporteResumen">';


						
						$footerEF = 	'</tbody>
											</table>
											<a class="text-right" href="'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'&idArea='.$id_hospitalEF.'">'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'&idArea='.$id_hospitalEF.'</a><br/>
										</div>
									</div>				
								</div>
							</div>';
						$todoEF = "";
						$resumen_institucionEF ="";

						foreach ($equilibrioFinaciero as $equilibrioF) {
							if($id_hospitalEF == $equilibrioF['id_hospital'])
							{
								if($equilibrioF['nombre_hospital'] == "Total")
								{
									$resumen_institucionEF = $resumen_institucionEF.'<tr>
									<th class="text-center" colspan="2"><p class="texto-pequenio">'.ucwords($equilibrioF['nombre_hospital']).'</p></th>
									<th class="text-center"><p class="texto-pequenio">'.$equilibrioF['anio'].'</p></th>
									<th class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['gastos'], 4, ",", ".").'</p></th>
									<th class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['ingresos'], 4, ",", ".").'</p></th>
									<th class="text-center"><p class="texto-pequenio">'.number_format($equilibrioF['cumplimiento'], 4, ",", ".").' %</p></th>
									<th class="text-center"><p class="texto-pequenio">'.$equilibrioF['puntuacion'].'</p></th>
									</tr>';
								}else
								{
									$resumen_institucionEF = $resumen_institucionEF.'<tr>
									<td class="text-center"><p class="texto-pequenio">'.ucwords($equilibrioF['nombre_hospital']).'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.ucwords($equilibrioF['nombreMes']).'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$equilibrioF['anio'].'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['gastos'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['ingresos'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.number_format($equilibrioF['cumplimiento'], 4, ",", ".").' %</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$equilibrioF['puntuacion'].'</p></td>
									</tr>';
								}
							}else
							{
								$todoEF = $todoEF.' '.$headerEF.' '.$resumen_institucionEF.' '.$footerEF;
								$headerEF = '<div class="row">
											<div class="col-sm-12">
												<div class="card">
													<div class="card-header">

														<div class="d-flex">
														  <div class="mr-auto p-2">
														 	<p class="text-left">II. Equilibrio Financiero (Vista en M$) '.utf8_encode($equilibrioF['nombre_hospital']).'</p>
														  </div>
														 	
														  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
														</div>

													</div>
												</div>
										
												<div id="tablaReporteResumen" class="row">
													<div class="col-sm-12  text-right">
													<br/>
														<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
															<thead class="thead-dark">
																<tr>
																	<th class="text-center texto-pequenio" scope="col">Area</th>
																	<th class="text-center texto-pequenio" scope="col">Mes</th>
																	<th class="text-center texto-pequenio" scope="col">A&ntilde;o</th>
																	<th class="text-center texto-pequenio" scope="col">Gastos Devengados ( $ )</th>
																	<th class="text-center texto-pequenio" scope="col">Ingresos Devengados ( $ )</th>
																	<th class="text-center texto-pequenio" scope="col">Cumplimiento Coeficiente</th>
																	<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n</th>
																</tr>
															</thead>
															<tbody id="tbodyReporteResumen">';
								$id_hospitalEF = $equilibrioF['id_hospital'];
								$footerEF = 	'</tbody>
												</table>
												<a class="text-right" href="'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'&idArea='.$id_hospitalEF.'">'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'&idArea='.$id_hospitalEF.'</a><br/>
											</div>
										</div>				
									</div>
								</div>';
								$resumen_institucionEF = '<tr>
								<td class="text-center"><p class="texto-pequenio">'.ucwords($equilibrioF['nombre_hospital']).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.ucwords($equilibrioF['nombreMes']).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.$equilibrioF['anio'].'</p></td>
								<td class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['gastos'], 4, ",", ".").'</p></td>
								<td class="text-center"><p class="texto-pequenio">$ '.number_format($equilibrioF['ingresos'], 4, ",", ".").'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.number_format($equilibrioF['cumplimiento'], 4, ",", ".").' %</p></td>
								<td class="text-center"><p class="texto-pequenio">'.$equilibrioF['puntuacion'].'</p></td>
								</tr>';
							}						
						}

//						$todo = $todo.' '.$header.' '.$resumen_institucion.' '.$footer;
						$todoEF = $todoEF.' '.$headerEF.' '.$resumen_institucionEF.' '.$footerEF;

						$todo = "";
						$resumen_institucion ="";

						$mensaje = "Hola ".$nombres." ".$apellidos.", el documento adjunto corresponde a indicadores de eficiencia hospitalaria.";
						$asunto = "Indicadores ".$nombre_ss;

						
						if(isset($reporteResumenes) && !isset($reporteResumenes["resultado"]))
						{								
							$id_hospital = $reporteResumenes[0]['id_hospital'];
							$header = '<div class="row">
												<div class="col-sm-12">
													<div class="card">
														<div class="card-header">
															
																
															

																<div class="d-flex">
																  <div class="mr-auto p-2">
																 	<p class="text-left">I. Recaudaci&oacute;n de Ingresos (Vista en M$) '.utf8_encode($reporteResumenes[0]['nombre_hospital']).'</p>
																  </div>
																 	
																  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
																</div>

														</div>
													</div>
											
													<div id="tablaReporteResumen" class="row">
														<div class="col-sm-12  text-right">
														<br/>
															<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
																<thead class="thead-dark">
																	<tr>
																		<th class="text-center texto-pequenio" scope="col">Area</th>
																		<th class="text-center texto-pequenio" scope="col">Mes</th>
																		<th class="text-center texto-pequenio" scope="col">A&ntilde;o</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 7 y 8 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Devengado Subt. 7 y 8 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Porcentaje 70 % Subt. 7 y 8</th>
																		<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 7 y 8</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 a&ntilde;o anterior ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Porcentaje 30 % Subt. 15</th>
																		<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 15</th>
																		<th class="text-center texto-pequenio" scope="col">Nota Final</th>
																	</tr>
																</thead>
																<tbody id="tbodyReporteResumen">';


							
							$footer = 	'</tbody>
															</table>
															<a class="text-right" href="'.base_url().'Reporte/ListarReportesRecaudacion?idInstitucion='.$id_institucion.'&idArea='.$id_hospital.'">'.base_url().'Reporte/ListarReportesRecaudacion?idInstitucion='.$id_institucion.'&idArea='.$id_hospital.'</a><br/>
														</div>
													</div>				
												</div>
											</div>';		
							foreach ($reporteResumenes as $reporteResumen) {
								if($id_hospital == $reporteResumen['id_hospital'])
								{
									if($reporteResumen['nombre_hospital'] == "Total")
									{
										$resumen_institucion = $resumen_institucion.'<tr>
										<th class="text-center" colspan="2"><p class="texto-pequenio">'.ucwords($reporteResumen['nombre_hospital']).'</p></th>
										<th class="text-center"><p class="texto-pequenio">'.$reporteResumen['anio'].'</p></th>
										<th class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_70'], 4, ",", ".").'</p></th>
										<th class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['devengado_70'], 4, ",", ".").'</p></th>
										<th class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_70'], 4, ",", ".").' %</p></th>
										<th class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_70'].'</p></th>
										<th class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_actual'], 4, ",", ".").'</p></th>
										<th class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_anterior'], 4, ",", ".").'</p></th>
										<th class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_30'], 4, ",", ".").' %</p></th>
										<th class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_30'].'</p></th>
										<th class="text-center"><p class="texto-pequenio">'.$reporteResumen['ponderado'].'</p></th>
										</tr>';
									}else{
										$resumen_institucion = $resumen_institucion.'<tr>
										<td class="text-center"><p class="texto-pequenio">'.ucwords($reporteResumen['nombre_hospital']).'</p></td>
										<td class="text-center"><p class="texto-pequenio">'.ucwords($reporteResumen['mes']).'</p></td>
										<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['anio'].'</p></td>
										<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_70'], 4, ",", ".").'</p></td>
										<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['devengado_70'], 4, ",", ".").'</p></td>
										<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_70'], 4, ",", ".").' %</p></td>
										<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_70'].'</p></td>
										<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_actual'], 4, ",", ".").'</p></td>
										<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_anterior'], 4, ",", ".").'</p></td>
										<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_30'], 4, ",", ".").' %</p></td>
										<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_30'].'</p></td>
										<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['ponderado'].'</p></td>
										</tr>';
									}
								}else
								{
									$todo = $todo.' '.$header.' '.$resumen_institucion.' '.$footer;
									$header = '<div class="row">
												<div class="col-sm-12">
													<div class="card">
														<div class="card-header">
																
														
																<div class="d-flex">
																  <div class="mr-auto p-2">
																 	<p class="text-left">I. Recaudaci&oacute;n de Ingresos (Vista en M$) '.utf8_encode($reporteResumen['nombre_hospital']).'</p>
																  </div>
																 	
																  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
																</div>

														</div>
													</div>
											
													<div id="tablaReporteResumen" class="row">
														<div class="col-sm-12  text-right">
														<br/>
															<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
																<thead class="thead-dark">
																<tr>
																		<th class="text-center texto-pequenio" scope="col">Area</th>
																		<th class="text-center texto-pequenio" scope="col">Mes</th>
																		<th class="text-center texto-pequenio" scope="col">A&ntilde;o</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 7 y 8 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Devengado Subt. 7 y 8 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Porcentaje 70 % Subt. 7 y 8</th>
																		<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 7 y 8</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 a&ntilde;o anterior ( $ )</th>
																		<th class="text-center texto-pequenio" scope="col">Porcentaje 30 % Subt. 15</th>
																		<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 15</th>
																		<th class="text-center texto-pequenio" scope="col">Nota Final</th>
																	</tr>
																</thead>
																<tbody id="tbodyReporteResumen">';
									$id_hospital = $reporteResumen['id_hospital'];
									$footer = 	'</tbody>
															</table>
															<a class="text-right" href="'.base_url().'Reporte/ListarReportesRecaudacion?idInstitucion='.$id_institucion.'&idArea='.$id_hospital.'">'.base_url().'Reporte/ListarReportesRecaudacion?idInstitucion='.$id_institucion.'&idArea='.$id_hospital.'</a><br/>
														</div>
													</div>				
												</div>
											</div>';		
									$resumen_institucion = '<tr>
									<td class="text-center"><p class="texto-pequenio">'.ucwords($reporteResumen['nombre_hospital']).'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.ucwords($reporteResumen['mes']).'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['anio'].'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_70'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['devengado_70'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_70'], 4, ",", ".").' %</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_70'].'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_actual'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_anterior'], 4, ",", ".").'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_30'], 4, ",", ".").' %</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_30'].'</p></td>
									<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['ponderado'].'</p></td>
									</tr>';
								}	

							}

							$todo = $todo.' '.$header.' '.$resumen_institucion.' '.$footer;
						}

						$path = base_url().'assets/img/logo.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);						

						$html = '<html lang="en">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=" utf-8"="">
							    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							    <title>Sistema de Reportes Minsal</title>

							    <!-- Core CSS - Include with every page -->
								<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
							    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">-->
							    <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">

								<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
								
								<link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">
								<!--<link href="/assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />-->
								<link href="http://www.divpre.info//assets/css/style.css" rel="stylesheet">
								<!--<link href="/assets/css/main-style.css" rel="stylesheet" />-->
							</head>
							<style>
							.texto-pequenio {
							    font-size: 0.5 rem !important;
							    margin: 0rem !important;
							    width: auto !important;
							}
							</style>
							<body>
								<div class="container-full">
									<div class="row pt-3">
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-12">
													<div class="col-sm-3 mb-3">
														<img src="'.$base64.'" width="80" class="d-inline-block align-top" alt="">
													</div>
													<div class="col-sm-9">
														<h3>'.utf8_encode($nombre_ss).'</h3>
													</div>
												</div>
											</div>
											<hr class="my-4">'.$todo.$todoEF.
										'</div>
									</div>
								</div>
								
								<script>
									
								</script>
								<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
								<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
								<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
								<script src="http://www.divpre.info/assets/scripts/index.js"></script>	    
							    <script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.js"></script>
							    <script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.min.js"></script>
								<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
								<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
								<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>
								<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
							</body>
						</html>';

						$pdf = null;
						$pdf = $this->pdf->generate($html, '', false, null, null, $resumen_institucion);
						
						$this->enviar($email, $mensaje, $asunto, $pdf);

						var_dump($html);
				}
			}	

			$this->load->view('enviarEvaluaciones', $usuario);
		}else
		{
			redirect('Inicio');
		}
	}

	 private function enviar($emailCliente, $mensaje, $asunto, $archivo){

		$this->load->library('email');
		$this->email->clear(true);
		$confing =array(
		'protocol'=>'smtp',
		'smtp_host'=>"smtp.gmail.com",
		'smtp_port'=>465,
		//'smtp_user'=>"validacion@gsbpo.cl",
		'smtp_user'=>"administracion@zenweb.cl",
		'smtp_pass'=>"black.Hole2017$",
		//'smtp_pass'=>"black.Hole2019$$",
		'smtp_crypto'=>'ssl',              
		'mailtype'=>'html'  
		);

		$confing['charset']      = 'utf-8';
		$confing['smtp_timeout']     = 50000;

		if (isset($archivo) != null)
			$this->email->attach($archivo, 'application/pdf', "Pdf File " . date("m-d H-i-s") . ".pdf", false);
			//$this->email->attach($archivo);
		$this->email->initialize($confing);
		$this->email->set_newline("\r\n");
		$this->email->from('administracion@zenweb.cl');
		//$this->email->from('validacion@gsbpo.cl');
		$this->email->to($emailCliente);
		$this->email->subject($asunto);
		$this->email->message($mensaje);

		if(!$this->email->send()) {
			$this->email->clear(true);
		    return 1;
		}
	}

	public function enviarEvaluacionesResumen($id_institucion)
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario') && is_numeric($id_institucion) && $id_institucion > 0)
		{
			$usuarios_directores = $this->reporte_model->listarUsuariosEvaluadosUsuarioSubDirector($usuario['id_usuario'], $id_institucion);
			if($usuarios_directores)
			{
				if(sizeof($usuarios_directores) > 0)
				{
					$nombres = $usuarios_directores[0]["u_nombres"];
					$apellidos = $usuarios_directores[0]["u_apellidos"];
					$email = $usuarios_directores[0]["u_email"];
					$telefono = $usuarios_directores[0]["u_telefono"];
					$celular = $usuarios_directores[0]["u_celular"];
					$direccion = $usuarios_directores[0]["u_direccion"];
					$perfil = $usuarios_directores[0]["pf_nombre"];
					$id_institucion = $usuarios_directores[0]["id_institucion"];
					$codigo_ss = $usuarios_directores[0]["codigo"];
					$nombre_ss = $usuarios_directores[0]["nombre"];
					$abreviacion_ss = $usuarios_directores[0]["abreviacion"];
					mysqli_next_result($this->db->conn_id);
					$mesesAnios = $this->reporte_model->obtenerAniosTransacciones();
					$anios[] = array();
		         	unset($anios[0]);

		         	mysqli_next_result($this->db->conn_id);
		         	$recaudacionIngresos = $this->reporte_model->listarReporteRecaudacionIngresosPDF($usuario['id_usuario'], $id_institucion, 'null', $mesesAnios[0]["anioSeleccionado"], 'null');

		         	mysqli_next_result($this->db->conn_id);
		         	$equilibrioFinaciero = $this->reporte_model->listarReporteEquilibrioFinancieroPDF($usuario['id_usuario'], $id_institucion, 'null', $mesesAnios[0]["anioSeleccionado"], 'null');

					

					#$levels = array_unique(array_column($recaudacionIngresos, 'mes'));
					$meses[] = array();
			        unset($meses[0]);

			        $hospitales[] = array();
			        unset($hospitales[0]);

					foreach ($recaudacionIngresos as $reg) {
						$hospital = array('id_hospital' => $reg['id_hospital'], 'nombre_hospital' => $reg['nombre_hospital'] );

						if (!in_array($hospital, $hospitales, true) && $hospital['nombre_hospital'] <> "Total" ) {
						 	array_push($hospitales, $hospital);
						}
					}

					$mesesEF[] = array();
			        unset($mesesEF[0]);

			        $hospitalesEF[] = array();
			        unset($hospitalesEF[0]);

					foreach ($equilibrioFinaciero as $regEF) {
						$hospitalEF = array('id_hospital' => $regEF['id_hospital'], 'nombre_hospital' => $regEF['nombre_hospital'] );

						if (!in_array($hospitalEF, $hospitalesEF, true) && $hospitalEF['nombre_hospital'] <> "Total" ) {
						 	array_push($hospitalesEF, $hospitalEF);
						}
					}

					$td_hospitalesEF = "";
					foreach ($hospitalesEF as $hospitalEF) {
						$td_hospitalesEF = $td_hospitalesEF.'<th class="text-center texto-pequenio" scope="col">'.$hospitalEF['nombre_hospital'].'</th>';
					}


					$todo = "";
					$td_hospitales = "";
					$nombre_ss = $recaudacionIngresos[0]["nombre"];
					foreach ($hospitales as $hospital) {
						$td_hospitales = $td_hospitales.'<th class="text-center texto-pequenio" scope="col">'.$hospital['nombre_hospital'].'</th>';
					}

					$path = base_url().'assets/img/logo.png';
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$data = file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);		

					$header = '<html lang="en">
										<head>
											<meta http-equiv="Content-Type" content="text/html; charset=" utf-8"="">
										    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
										    <title>Sistema de Reportes Minsal</title>

										    <!-- Core CSS - Include with every page -->
											<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
										    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">-->
										    <link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">

											<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
											
											<link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">
											<!--<link href="/assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />-->
											<link href="http://www.divpre.info//assets/css/style.css" rel="stylesheet">
											<!--<link href="/assets/css/main-style.css" rel="stylesheet" />-->
										</head>
										<body>
											<div class="container-full">
												<div class="row pt-3">
													<div class="col-sm-12">
														<div class="row">
															<div class="col-sm-12">
																<div class="col-sm-3 mb-3">
																	<img src="'.$base64.'" width="80" class="d-inline-block align-top" alt="">
																</div>
																<div class="col-sm-9">
																	<h3>'.utf8_encode($nombre_ss).'</h3>
																</div>
															</div>
														</div>
														<hr class="my-4">';

					$footer = 	'</div>
												</div>
											</div>
											
											<script>
												
											</script>
											<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
											<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
											<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
											<script src="http://www.divpre.info/assets/scripts/index.js"></script>	    
										    <script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.js"></script>
										    <script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.min.js"></script>
											<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
											<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
											<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>
											<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
										</body>
									</html>';

					$td_r_70 = '';
					$td_d_70 = '';
					$td_p_70 = '';
					$td_r_30 = '';
					$td_r_30_a = '';
					$td_p_30 = '';
					$td_nf = '';

					$header_recaudacion = '<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-secondary" role="alert">

												<div class="d-flex">
												  <div class="mr-auto p-2">
												 	<p class="text-left">I. Resumen Recaudaci&oacute;n de Ingresos (Vista en M$)</p>
												  </div>
												 	
												  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
												</div>
									</div>
							
									<div id="tablaReporteResumen" class="row">
										<div class="col-sm-12 text-right">
										<br/>
											<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
												<thead class="thead-dark">
												<tr>
														<th class="text-center texto-pequenio" scope="col"></th>
														<th class="text-center texto-pequenio" scope="col">Total</th>'.$td_hospitales
													.'</tr>
												</thead>
												<tbody id="tbodyReporteResumen">';
					$footer_recaudacion = '</tbody>
																		</table>
																		<a class="text-right" href="'.base_url().'Reporte/ListarReportesRecaudacion?idInstitucion='.$id_institucion.'">'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'</a><br/>
																	</div>
																</div>				
															</div>
														</div>';

					$header_equilibrio = '<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-secondary" role="alert">

												<div class="d-flex">
												  <div class="mr-auto p-2">
												 	<p class="text-left">II. Resumen Equilibrio Financiero (Vista en M$)</p>
												  </div>
												 	
												  <div class="p-2"><p class="text-right">(Fuente SIGFE)</p></div>
												</div>
										
									</div>
							
									<div id="tablaReporteResumenEF" class="row">
										<div class="col-sm-12 text-right">
										<br/>
											<table id="tReporteResumenEF" class="table table-sm table-hover table-bordered">
												<thead class="thead-dark">
												<tr>
														<th class="text-center texto-pequenio" scope="col"></th>
														<th class="text-center texto-pequenio" scope="col">Total</th>'.$td_hospitalesEF
													.'</tr>
												</thead>
												<tbody id="tbodyReporteResumenEF">';
					$footer_equilibrio = '</tbody>
																		</table>
																		<a class="text-right" href="'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'">'.base_url().'Reporte/ListarReportesEquilibrioFinanciero?idInstitucion='.$id_institucion.'</a><br/>
																	</div>
																</div>				
															</div>
														</div>';


					foreach ($recaudacionIngresos as $registro) {
						//var_dump($registro);
						if($registro['nombre_hospital'] != 'Total')
						{
							$td_r_70 = $td_r_70.'<td class="text-center"><p class="texto-pequenio recaudado_70">$ '.number_format($registro['recaudado_70'], 4, ",", ".").'</p></td>';
							$td_d_70 = $td_d_70.'<td class="text-center"><p class="texto-pequenio devengado_70">$ '.number_format($registro['devengado_70'], 4, ",", ".").'</p></td>';
							$td_p_70 = $td_p_70.'<td class="text-center"><p class="texto-pequenio porcentaje_70">'.number_format($registro['porcentaje_70'], 4, ",", ".").' %</p></td>';
							$td_r_30 = $td_r_30.'<td class="text-center"><p class="texto-pequenio recaudado_30_anio_actual">$ '.number_format($registro['recaudado_30_anio_actual'], 4, ",", ".").'</p></td>';
							$td_r_30_a = $td_r_30_a.'<td class="text-center"><p class="texto-pequenio recaudado_30_anio_anterior">$ '.number_format($registro['recaudado_30_anio_anterior'], 4, ",", ".").'</p></td>';
							$td_p_30 = $td_p_30.'<td class="text-center"><p class="texto-pequenio porcentaje_30">'.number_format($registro['porcentaje_30'], 4, ",", ".").' %</p></td>';
							$td_nf = $td_nf.'<th class="text-center"><p class="texto-pequenio">'.number_format($registro['ponderado'], 4, ",", ".").'</p></th>';
						}else
						{
							$td_r_70 = '<tr><td class="text-center"><p class="texto-pequenio">Recaudado Subt. 7 y 8</p></td><td class="text-center"><p class="texto-pequenio total_r_70">$ '.number_format($registro['recaudado_70'], 4, ",", ".").'</p></td>'.$td_r_70.'</tr>';
							$td_d_70 = '<tr><td class="text-center"><p class="texto-pequenio">Devengado Subt. 7 y 8</p></td><td class="text-center"><p class="texto-pequenio total_d_70">$ '.number_format($registro['devengado_70'], 4, ",", ".").'</p></td>'.$td_d_70.'</tr>';
							$td_p_70 = '<tr><td class="text-center"><p class="texto-pequenio">Porcentaje Subt. 7 y 8</p></td><td class="text-center"><p class="texto-pequenio total_p_70">'.number_format($registro['porcentaje_70'], 4, ",", ".").' %</p></td>'.$td_p_70.'</tr>';
							$td_r_30 = '<tr><td class="text-center"><p class="texto-pequenio">Recaudado A&ntilde;o Actual Subt. 12</p></td><td class="text-center"><p class="texto-pequenio total_r_30">$ '.number_format($registro['recaudado_30_anio_actual'], 4, ",", ".").'</p></td>'.$td_r_30.'</tr>';
							$td_r_30_a = '<tr><td class="text-center"><p class="texto-pequenio">Recaudado A&ntilde;o Anterior Subt. 12</p></td><td class="text-center"><p class="texto-pequenio total_r_30_a">$ '.number_format($registro['recaudado_30_anio_anterior'], 4, ",", ".").'</p></td>'.$td_r_30_a.'</tr>';
							$td_p_30 = '<tr><td class="text-center"><p class="texto-pequenio">Porcentaje Subt. 12</p></td><td class="text-center"><p class="texto-pequenio total_p_30">'.number_format($registro['porcentaje_30'], 4, ",", ".").' %</p></td>'.$td_p_30.'</tr>';
							$td_nf = '<tr><th class="text-center"><p class="texto-pequenio">Nota Final</p></th><th class="text-center"><p class="texto-pequenio total_nf">'.number_format($registro['ponderado'], 4, ",", ".").'</p></th>'.$td_nf.'</tr>';
						}
					}

					$td_ingresos = '';
					$td_gastos = '';
					$td_cumplimiento = '';
					$td_nf_EF = '';

					foreach ($equilibrioFinaciero as $registroEF) {
						if($registroEF['nombre_hospital'] != 'Total')
						{
							$td_gastos = $td_gastos.'<td class="text-center"><p class="texto-pequenio recaudado_70">$ '.number_format($registroEF['gastos'], 4, ",", ".").'</p></td>';
							$td_ingresos = $td_ingresos.'<td class="text-center"><p class="texto-pequenio devengado_70">$ '.number_format($registroEF['ingresos'], 4, ",", ".").'</p></td>';
							$td_cumplimiento = $td_cumplimiento.'<td class="text-center"><p class="texto-pequenio porcentaje_70">'.number_format($registroEF['cumplimiento'], 4, ",", ".").'</p></td>';
							$td_nf_EF = $td_nf_EF.'<th class="text-center"><p class="texto-pequenio">'.number_format($registroEF['puntuacion'], 4, ",", ".").'</p></th>';
						}else
						{
							$td_gastos = '<tr><td class="text-center"><p class="texto-pequenio">Gastos Devengados</td><td class="text-center"><p class="texto-pequenio total_d_70">$ '.number_format($registroEF['gastos'], 4, ",", ".").'</p></td>'.$td_gastos.'</tr>';
							$td_ingresos = '<tr><td class="text-center"><p class="texto-pequenio">Ingresos Devengados</p></td><td class="text-center"><p class="texto-pequenio total_r_70">$ '.number_format($registroEF['ingresos'], 4, ",", ".").'</p></td>'.$td_ingresos.'</tr>';
							$td_cumplimiento = '<tr><td class="text-center"><p class="texto-pequenio">Cumplimiento</p></td><td class="text-center"><p class="texto-pequenio total_p_70">'.number_format($registroEF['cumplimiento'], 4, ",", ".").'</p></td>'.$td_cumplimiento.'</tr>';
							$td_nf_EF = '<tr><th class="text-center"><p class="texto-pequenio">Nota Final</p></th><th class="text-center"><p class="texto-pequenio total_nf">'.number_format($registroEF['puntuacion'], 4, ",", ".").'</p></th>'.$td_nf_EF.'</tr>';
						}
					}

					$todo = $header.$header_recaudacion.$td_r_70.$td_d_70.$td_p_70.$td_r_30.$td_r_30_a.$td_p_30.$td_nf.$footer_recaudacion.$header_equilibrio.$td_gastos.$td_ingresos.$td_cumplimiento.$td_nf_EF.$footer_equilibrio.$footer;
					

					$mensaje = "Hola ".$nombres." ".$apellidos.", el documento adjunto corresponde a indicadores de eficiencia hospitalaria.";
					$asunto = "Indicadores ".$nombre_ss;

					$pdf = $this->pdf->generate($todo, '', false, null, null, '');


					//$this->enviar($email, $mensaje, $asunto, $pdf_2);
					$se_envio = $this->enviar($email, $mensaje, $asunto, $pdf);
					//$this->enviar($email, $mensaje, $asunto, $pdf_2);
					//var_dump($pdf_2);
					//var_dump($se_envio);
         		}
         	}
		}else
		{
			redirect('Inicio');
		}
	
	}

	
	public function listarPagosTesoreria()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){

			if(!is_null($this->input->post('hospital')) || !is_null($this->input->post('institucion')))
			{
				$institucion = 'null';
				$hospital = 'null';
				$rut_proveedor = 'null';

				if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
					$institucion = $this->input->post('institucion');

				if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
					$hospital = $this->input->post('hospital');

				if(!is_null($this->input->post('rut_proveedor')) && trim($this->input->post('rut_proveedor')) != "")
					$rut_proveedor = $this->input->post('rut_proveedor');

				$listaPagos = $this->reporte_model->listarPagosTesoreriaUsu($usuario["id_usuario"], $institucion, $hospital, $rut_proveedor);
				

				$table_pagos_tesoreria ='
				<table id="tListaPagosTesoreria" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th class="text-center texto-pequenio" scope="col">Servicio de Salud</th>
							<th class="text-center texto-pequenio" scope="col">Area</th>
							<th class="text-center texto-pequenio" scope="col">Rut Beneficiario</th>
							<th class="text-center texto-pequenio" scope="col">Nombre Beneficiario</th>
							<th class="text-center texto-pequenio" scope="col">Rut Proveedor</th>
							<th class="text-center texto-pequenio" scope="col">Nombre Proveedor</th>
							<th class="text-center texto-pequenio" scope="col" >Numero de Documento</th>
							<th class="text-center texto-pequenio" scope="col">Numero Cuenta de Pago</th>
							<th class="text-center texto-pequenio" scope="col">Monto ( $ )</th>								
						</tr>
					</thead>
					<tbody id="tbodyPagosTesoreria">
		        ';

		        if(isset($listaPagos) && sizeof($listaPagos) > 0)
				{								
					foreach ($listaPagos as $pago) {
						$table_pagos_tesoreria .= '<tr>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_institucion'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['rut_beneficiario'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_beneficiario'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['rut_proveedor'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_proveedor'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['numero_documento'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">'.(substr($pago['numero_cuenta_pago'], 0, 30)).'</p></td>
								<td class="text-center"><p class="texto-pequenio">$ '.number_format($pago['monto_pago'], 0, ",", ".").'</p></td>
								</tr>';
						
					}
				}else
				{
					$table_pagos_tesoreria .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_pagos_tesoreria .='
		        	</tbody>
		        </table>';

				$datos = array('table_pagos_tesoreria' =>$table_pagos_tesoreria);
		        

		        echo json_encode($datos);

				//echo json_encode($listaPagos);
				#echo json_encode($institucion.'  --  '.$hospital);
			}else
			{
				$usuario['controller'] = 'reporte';

				$id_usuario = $this->session->userdata('id_usuario');

				$id_institucion_seleccionado = "null";


				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				
				if($datos_usuario[0]["id_perfil"] == "1")
				{
					mysqli_next_result($this->db->conn_id);
					$instituciones =  $this->institucion_model->listarInstitucionesUsu($id_usuario);
					$usuario["instituciones"] = $instituciones;
					$usuario["idInstitucion"] = $instituciones[0]["id_institucion"];
					$id_institucion_seleccionado = $instituciones[0]["id_institucion"];
				}

				mysqli_next_result($this->db->conn_id);
				$listaPagos = $this->reporte_model->listarPagosTesoreriaUsu($usuario["id_usuario"], $id_institucion_seleccionado, 'null', 'null');

				if($listaPagos)
				{
					$usuario["listaPagos"] = $listaPagos;
					mysqli_next_result($this->db->conn_id);
					$hospitales = $this->hospital_model->listarHospitalesUsuPagosTesoreria($id_usuario, $listaPagos[0]['id_institucion']);
					$usuario["hospitales"] = $hospitales;
					//var_dump($reporteResumenes);
				}

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarPagosTesoreria', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
		else
		{
			redirect('Login');
		}
	}

	public function exportarexcelPagosTesoreria(){
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{
			$id_usuario = $this->session->userdata('id_usuario');
			$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
			$id_institucion_seleccionado = "null";
			$hospital = "null";
			$rut_proveedor = "null";
			
			if(!is_null($this->input->get('institucion')) && $this->input->get('institucion') != "-1")
				$id_institucion_seleccionado = $this->input->get('institucion');


			if(!is_null($this->input->get('hospital')) && $this->input->get('hospital') != "-1")
				$hospital = $this->input->get('hospital');

			if(!is_null($this->input->get('rut_proveedor')) && $this->input->get('rut_proveedor') != "-1")
				$rut_proveedor = $this->input->get('rut_proveedor');

			mysqli_next_result($this->db->conn_id);
			$pagos = $this->reporte_model->listarPagosTesoreriaUsu($usuario["id_usuario"], $id_institucion_seleccionado, $hospital, $rut_proveedor);

			
			$this->excel->getActiveSheet()->setTitle('ListadoPagosTesoreria');
			#var_dump($institucion, $hospital, $proveedor, $mes, $anio);
			#var_dump($pagos);
	        //Contador de filas
	        $contador = 7;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('i')->setWidth(30);

	        $this->excel->getActiveSheet()->getStyle('A7:I7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');

	        $this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			$this->excel->getActiveSheet()->mergeCells("A1:I5");

			$style = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	$styleTitulo = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	$this->excel->getActiveSheet()->getStyle('A1:I5')->applyFromArray($styleTitulo);
        	 $this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Pagos Tesoreria');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($style);

			$gdImage = imagecreatefrompng(base_url()."assets/img/logo.png");
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(100);
			$objDrawing->setwidth(100);
			$objDrawing->setCoordinates('A1');

			$objDrawing->setWorksheet($this->excel->getActiveSheet());

			$this->excel->getActiveSheet()->getStyle('A6');
	        
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Servicio de Salud');
			$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Area');
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Rut Beneficiario');
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Nombre Beneficiario');
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Rut Proveedor');
			$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Nombre Proveedor');
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Numero de Documento');
			$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Numero Cuenta de Pago');
			$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Monto ( $ )');
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($pagos as $pago){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $pago['nombre_institucion']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $pago['nombre']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $pago['rut_beneficiario']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $pago['nombre_beneficiario']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $pago['rut_proveedor']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $pago['nombre_proveedor']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $pago['numero_documento']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $pago['numero_cuenta_pago']);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", "$ ".number_format($pago['monto_pago'], 0, ",", "."));
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "listadoPagosTesoreria_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }

    public function enviarContraseniaDirectores(){
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
			
			if($datos_usuario[0]["id_usuario"] == "2")
			{
				mysqli_next_result($this->db->conn_id);
				$usuarios_directores = $this->reporte_model->listarUsuariosEvaluados($usuario['id_usuario']);

	    		for ($i=0; $i < sizeof($usuarios_directores); $i++) { 
	    			$u_nombres = $usuarios_directores[$i]['u_nombres'];
	    			$u_apellidos = $usuarios_directores[$i]['u_apellidos'];
	    			$servicio_salud = $usuarios_directores[$i]['nombre'];
	    			$ss = $usuarios_directores[$i]['abreviacion'];
	    			$email = $usuarios_directores[$i]['u_email'];
	    			$contrasenia = $usuarios_directores[$i]['u_contrasenia'];
	    			//$email_usu = 'jchacon@zenweb.cl'; 
	    			$email_usu = 'pablo.sandoval@zenweb.cl';
	    			//$email_usu = 'psandoval@zenweb.cl'; 
	    			//$usuarios_directores[$i]['u_email'];

	    			$asunto = "Ingreso a Sistema de Reporte Minsal - ".$servicio_salud;
	    			/*$mensaje = 'Estimado(a) '.$u_nombres.' '.$u_apellidos.', Adjunto a este correo encontrara su usuario, clave de acceso e instructivo de como ingresar y visualizar información en nuestro nuevo portal "Sistema de Reportes Minsal", el cual contiene información respecto de pagos efectuados por la Tesorería General de la Republica a proveedores relacionados a su  servicio o establecimiento según corresponda. La información será actualizada en concordancia con la periodicidad en que los nuevos antecedentes sean liberados. <br/><br/><br/>
	    						Sus credenciales son: <br/><br/><br/>
	    						Usuario: '.$email.'<br/>
	    						Contraseña: '.$contrasenia.' <br/><br/><br/>';*/

	    			$path = base_url().'assets/img/logo.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);	

	    			$mensaje = '<!DOCTYPE html>
					<html lang="en">
					<head>
					    <meta charset="utf-8">
					    <meta name="viewport" content="width=device-width">
					    <meta http-equiv="X-UA-Compatible" content="IE=edge">
					    <meta name="x-apple-disable-message-reformatting">
					    <title></title>

						<style>
							.button-a-primary:hover {
						        background: #00497a !important;
						        border-color: #00497a !important;
								color: #ffffff !important;
						    }
						</style>

					</head>
					<body width="100%" style="margin: 0; mso-line-height-rule: exactly; background-color: linear-gradient(45deg, #00497a, #3CBAD0);">
					    <center style="width: 100%; background-color: linear-gradient(45deg, #00497a, #3CBAD0); text-align: left;">        
					        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: 0 auto;" class="email-container">
					            <tr>
					                <td style="padding: 20px;text-align: center; background: linear-gradient(45deg, #F8F9FA, #F8F9FA);text-align:  left;">
					                    <img src="http://www.divpre.info/assets/img/logo.png" width="80" class="d-inline-block align-top" alt="">
					                </td>
					            </tr>
						    
					            <tr>
					                <td style="background-color: #ffffff;">
					                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
					                        <tr>
					                            <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
					                                <h1 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #006CB8; font-weight: normal;">Bienvenido a Sistema de Reporte Minsal</h1>
					                                <p style="margin: 0 0 10px;">Estimado(a) '.$u_nombres.' '.$u_apellidos.'.</p>
					                                <p style="margin: 0 0 10px;">Adjunto a este correo encontrara su usuario, clave de acceso e instructivo de como ingresar y visualizar información en nuestro nuevo portal "Sistema de Reportes Minsal", el cual contiene información respecto de pagos efectuados por la Tesorería General de la Republica a proveedores relacionados a su  servicio o establecimiento según corresponda. La información será actualizada en concordancia con la periodicidad en que los nuevos antecedentes sean liberados..</p>
													<br/>
					                                <ul style="padding: 0; margin: 0; list-style-type: disc;">
														<li style="margin:0 0 10px 20px;" class="list-item-first">Su usuario es "<b>'.$email.'</b>"</li>
					                                    <li style="margin:0 0 10px 20px;" class="list-item-first">Su contraseña es "<b>'.$contrasenia.'</b>"</li>
													</ul>
					                            </td>
					                        </tr>
					                        <tr>
					                            <td style="padding: 0 20px 20px;">
					                                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
					                                    <tr>
					                                        <td class="button-td button-td-primary" style="border-radius: 4px; background: linear-gradient(45deg, #F8F9FA, #F8F9FA);">
																<a target="_blank" class="button-a button-a-primary" href="http://www.divpre.info/Login" style="background: linear-gradient(45deg, #F8F9FA, #F8F9FA); font-family: sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #006CB8; display: block; border-radius: 4px;">Ingresa al PORTAL</a>
															</td>
					                                    </tr>
					                                </table>       
					                            </td>
					                        </tr>

					                    </table>
					                </td>
					            </tr>
					            <tr>            
					                <td valign="middle" style="text-align: center; background: #fff; background-position: center center !important; background-size: cover !important;">
						                <div>
						                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
						                        <tr>
						                            <td valign="middle" style="text-align: left; padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: black; border-top-style: groove; border-top-color: solid; border-top-width: 2px;">
						                            </td>
						                        </tr>
						                    </table>
						                </div>
						            </td>
						        </tr>
					    </center>
					</body>
					</html>';

	    			$nombre_pdf = "Instructivo de Uso Sistema de Reportes Minsal";

	    			$pdf = file_get_contents(base_url()."/assets/doc/instructivo_directores_sub.pdf");

	    			$this->enviar($email_usu, $mensaje, $asunto, $pdf);

	    		}

	    		mysqli_next_result($this->db->conn_id);
				$usuarios_sub_directores = $this->reporte_model->listarUsuariosEvaluadosUsuario($usuario['id_usuario'], "null");
				for ($i=0; $i < sizeof($usuarios_sub_directores); $i++) { 
	    			$u_nombres = $usuarios_sub_directores[$i]['u_nombres'];
	    			$u_apellidos = $usuarios_sub_directores[$i]['u_apellidos'];
	    			$servicio_salud = $usuarios_sub_directores[$i]['nombre'];
	    			$ss = $usuarios_sub_directores[$i]['abreviacion'];
	    			$email = $usuarios_sub_directores[$i]['u_email'];
	    			$contrasenia = $usuarios_sub_directores[$i]['u_contrasenia'];
	    			//$email_usu = 'jchacon@zenweb.cl';
	    			$email_usu = 'pablo.sandoval@minsal.cl';
	    			//$email_usu = 'psandoval@zenweb.cl'; 
	    			 //$usuarios_sub_directores[$i]['u_email'];

	    			$asunto = "Ingreso a Sistema de Reporte Minsal - ".$servicio_salud;
	    			/*$mensaje = 'Estimado(a) '.$u_nombres.' '.$u_apellidos.', ya puede ingresar a nuestro nuevo portal "Sistema de Reportes Minsal". <br/><br/><br/>
	    						Sus credenciales son: <br/><br/><br/>
	    						Usuario: '.$email.'<br/>
	    						Contraseña: '.$contrasenia.' <br/><br/><br/>
	    						Se adjunta un Instructivo de Uso para su conocimiento.';*/

	    			$mensaje = '<!DOCTYPE html>
					<html lang="en">
					<head>
					    <meta charset="utf-8">
					    <meta name="viewport" content="width=device-width">
					    <meta http-equiv="X-UA-Compatible" content="IE=edge">
					    <meta name="x-apple-disable-message-reformatting">
					    <title></title>

						<style>
							.button-a-primary:hover {
						        background: #00497a !important;
						        border-color: #00497a !important;
								color: #ffffff !important;
						    }
						</style>

					</head>
					<body width="100%" style="margin: 0; mso-line-height-rule: exactly; background-color: linear-gradient(45deg, #00497a, #3CBAD0);">
					    <center style="width: 100%; background-color: linear-gradient(45deg, #00497a, #3CBAD0); text-align: left;">        
					        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: 0 auto;" class="email-container">
					            <tr>
					                <td style="padding: 20px;text-align: center; background: linear-gradient(45deg, #F8F9FA, #F8F9FA);text-align:  left;">
					                    <img src="http://www.divpre.info/assets/img/logo.png" width="80" class="d-inline-block align-top" alt="">
					                </td>
					            </tr>
						    
					            <tr>
					                <td style="background-color: #ffffff;">
					                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
					                        <tr>
					                            <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
					                                <h1 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #006CB8; font-weight: normal;">Bienvenido a Sistema de Reporte Minsal</h1>
					                                <p style="margin: 0 0 10px;">Estimado(a) '.$u_nombres.' '.$u_apellidos.'.</p>
					                                <p style="margin: 0 0 10px;">Adjunto a este correo encontrara su usuario, clave de acceso e instructivo de como ingresar y visualizar información en nuestro nuevo portal "Sistema de Reportes Minsal", el cual contiene información respecto de pagos efectuados por la Tesorería General de la Republica a proveedores relacionados a su  servicio o establecimiento según corresponda. La información será actualizada en concordancia con la periodicidad en que los nuevos antecedentes sean liberados..</p>
													<br/>
					                                <ul style="padding: 0; margin: 0; list-style-type: disc;">
														<li style="margin:0 0 10px 20px;" class="list-item-first">Su usuario es "<b>'.$email.'</b>"</li>
					                                    <li style="margin:0 0 10px 20px;" class="list-item-first">Su contraseña es "<b>'.$contrasenia.'</b>"</li>
													</ul>
					                            </td>
					                        </tr>
					                        <tr>
					                            <td style="padding: 0 20px 20px;">
					                                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
					                                    <tr>
					                                        <td class="button-td button-td-primary" style="border-radius: 4px; background: linear-gradient(45deg, #F8F9FA, #F8F9FA);">
																<a target="_blank" class="button-a button-a-primary" href="http://www.divpre.info/Login" style="background: linear-gradient(45deg, #F8F9FA, #F8F9FA); font-family: sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #006CB8; display: block; border-radius: 4px;">Ingresa al PORTAL</a>
															</td>
					                                    </tr>
					                                </table>       
					                            </td>
					                        </tr>

					                    </table>
					                </td>
					            </tr>
					            <tr>            
					                <td valign="middle" style="text-align: center; background: #fff; background-position: center center !important; background-size: cover !important;">
						                <div>
						                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
						                        <tr>
						                            <td valign="middle" style="text-align: left; padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: black; border-top-style: groove; border-top-color: solid; border-top-width: 2px;">
						                            </td>
						                        </tr>
						                    </table>
						                </div>
						            </td>
						        </tr>
					    </center>
					</body>
					</html>';

	    			$nombre_pdf = "Instructivo de Uso Sistema de Reportes Minsal";

	    			$pdf = file_get_contents(base_url()."/assets/doc/instructivo_directores_sub.pdf");

	    			$this->enviar($email_usu, $mensaje, $asunto, $pdf);

	    		}
			}
    	}
    }


    public function listarResumenProgramas()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			$usuario['controller'] = 'reporte';

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$idInstitucion = "null";
				
				if(!is_null($this->input->post('institucion')))
					$idInstitucion = $this->input->post('institucion');

				
				$listaPagos = $this->reporte_model->listarResumenProgramas($usuario["id_usuario"], $idInstitucion);

				mysqli_next_result($this->db->conn_id);
				$listaPagosAPS = $this->reporte_model->listarResumenProgramasAPS($usuario["id_usuario"], $idInstitucion);
				if($listaPagosAPS)
					$usuario["listaPagosAPS"] = $listaPagosAPS;

				mysqli_next_result($this->db->conn_id);
				$listaPagosAPSSS = $this->reporte_model->listarResumenProgramasAPSSS($usuario["id_usuario"], $idInstitucion);
				if($listaPagosAPSSS)
					$usuario["listaPagosAPSSS"] = $listaPagosAPSSS;

				$datos = array('listarPagos' => $listaPagos, 'listarPagosAPS' => $listaPagosAPS, 'listarPagosAPSSS' => $listaPagosAPSSS);


				echo json_encode($datos);

			}else{
				$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
				if($instituciones)
					$usuario["instituciones"] = $instituciones;

				$idInstitucion = "null";

				$usuario["idInstitucion"] = $instituciones[0]["id_institucion"];

				$idInstitucion = $instituciones[0]["id_institucion"];
				
				mysqli_next_result($this->db->conn_id);
				$listaPagos = $this->reporte_model->listarResumenProgramas($usuario["id_usuario"], $idInstitucion);
				if($listaPagos)
					$usuario["listaPagos"] = $listaPagos;


				mysqli_next_result($this->db->conn_id);
				$listaPagosAPS = $this->reporte_model->listarResumenProgramasAPS($usuario["id_usuario"], $idInstitucion);
				if($listaPagosAPS)
					$usuario["listaPagosAPS"] = $listaPagosAPS;

				mysqli_next_result($this->db->conn_id);
				$listaPagosAPSSS = $this->reporte_model->listarResumenProgramasAPSSS($usuario["id_usuario"], $idInstitucion);
				if($listaPagosAPSSS)
					$usuario["listaPagosAPSSS"] = $listaPagosAPSSS;

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarResumenProgramas', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}else
		{
			redirect('Login');
		}
	}


}

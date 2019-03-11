<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pago extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('reporte_model');
		$this->load->model('institucion_model');
		$this->load->model('hospital_model');
		$this->load->model('cuenta_model');
		$this->load->model('item_model');
		$this->load->model('asignacion_model');
		$this->load->model('pago_model');
		$this->load->model('usuario_model');
		$this->load->library('excel');
		$this->load->library('pagination');
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

	public function listarPagos()
	{
		$usuario = $this->session->userdata();
		
		if($this->session->userdata('id_usuario'))
		{
			$usuario['controller'] = 'pago';
			$idInstitucion = "null";
			$idArea = "null";
			$idPrincipal = "null";

			$instituciones = $this->institucion_model->listarInstitucionesUsuPagos($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;

			$usuario['idInstitucion'] = $instituciones[0]['id_institucion'];
			$idInstitucion = $instituciones[0]['id_institucion'];

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
			$hospitales = $this->hospital_model->listarHospitalesUsuPagos($usuario["id_usuario"], $idInstitucion);
			if($hospitales)
				$usuario["hospitales"] = $hospitales;

			mysqli_next_result($this->db->conn_id);
			$principales = $this->pago_model->listarPrincipalesUsu($usuario["id_usuario"], $idInstitucion, $idArea);
			if($principales)
				$usuario["principales"] = $principales;

			if(sizeof($principales) == 1)
				$idPrincipal = $principales[0]["id_principal"];

			mysqli_next_result($this->db->conn_id);
			$mesesAnios = $this->pago_model->obtenerAniosPagos($usuario["id_usuario"], $idInstitucion, $idArea, $idPrincipal);
			$anios[] = array();
         	unset($anios[0]);

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

			mysqli_next_result($this->db->conn_id);
			$cantPagos = $this->pago_model->listarCantPagos($usuario["id_usuario"], "null", $idArea, $idPrincipal, "null", $mesesAnios[0]["idAnio"]);

			$config = array();
			$config['base_url'] = "#";//base_url()."Pago/ListarPagos";
  			$config['total_rows'] = (int)$cantPagos[0]["cantPagos"];
			$config['per_page'] = 100;
			$config['uri_segment'] = 86;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = FALSE;
			$config['first_url'] = 28;

			$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';

			$config['first_link'] = 'Principio';
			$config["first_tag_open"] = '<li class="page-item"><a href="'.base_url().'Pago/ListarPagos/1" class="page-link" data-ci-pagination-page="1">';
			$config["first_tag_close"] = '</a></li>';

			$config['last_link'] = 'Final';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Siguiente';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = 'Anterior';
			$config['prev_tag_open'] = '<li class="page-item">Anterior';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="page-item active"><a href="'.base_url().'Pago/ListarPagos/1" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';

			$config['attributes'] = array('class' => 'page-link');

			$config['num_links'] = 6;

			$this->pagination->initialize($config);
            // build paging links
            $usuario['links'] = $this->pagination->create_links();
            //$this->pagination->create_links();
			
			//$links = $this->pagination->create_links();
			mysqli_next_result($this->db->conn_id);
			$pagos = $this->pago_model->listarPagos($usuario["id_usuario"], $idInstitucion, $idArea, $idPrincipal, "null", "null", "null", "null");
			if($pagos)
				$usuario["pagos"] = $pagos;

			$usuario['meses'] = $meses;
			#$usuario['anioSeleccionado'] = $mesesAnios[0]["idAnio"];
			#$usuario['mesSeleccionado'] = $mesesAnios[0]["idMes"];

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarPagos', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Login');
		}
	}


	public function listarPagosFiltrados()
	{
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$mes = "null";
			$anio = "null";
			$proveedor = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('proveedor')) && $this->input->post('proveedor') != "-1" && is_numeric($this->input->post('proveedor')))
				$proveedor = $this->input->post('proveedor');

			if(is_null($this->input->post('proveedor')))
			{
				$principales = $this->pago_model->listarPrincipalesUsu($usuario["id_usuario"], 'null', 'null');
				if($principales && sizeof($principales) == 1 && $principales[0]["dedicado"] == 1)
					$proveedor = $principales[0]["id_principal"];
				mysqli_next_result($this->db->conn_id);
			}


			if(!is_null($this->input->post('mes')) && $this->input->post('mes') != "-1")
				$mes = $this->input->post('mes');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1")
				$anio = $this->input->post('anio');

			$inicio = 1;
			$tamanio = 100;

			$inicio = "null";
			$tamanio = "null";

			if(!is_null($this->input->post('inicio')) && $this->input->post('inicio') != "-1")
				$inicio = $this->input->post('inicio');

			if(!is_null($this->input->post('tamanio')) && $this->input->post('tamanio') != "-1")
				$tamanio = $this->input->post('tamanio');

			//mysqli_next_result($this->db->conn_id);
			$pagos = $this->pago_model->listarPagos($usuario["id_usuario"], $institucion, $hospital, $proveedor, $mes, $anio, $inicio, $tamanio);

			echo json_encode($pagos);
		}
		else
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

			$hospitales = $this->hospital_model->listarHospitalesUsuPagos($usuario["id_usuario"], $institucion);
			echo json_encode($hospitales);
		}else
		{
			redirect('Login');
		}
	}

	public function listarProveedores()
	{
		$usuario = $this->session->userdata();
		$proveedores = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			$proveedores = $this->pago_model->listarPrincipalesUsu($usuario["id_usuario"], $institucion, $hospital);

			echo json_encode($proveedores);
		}
		else
		{
			redirect('Login');
		}
	}

	public function exportarexcel(){
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$mes = "null";
			$anio = "null";
			$proveedor = "null";

			if(!is_null($this->input->get('institucion')) && $this->input->get('institucion') != "-1")
				$institucion = $this->input->get('institucion');

			if(!is_null($this->input->get('hospital')) && $this->input->get('hospital') != "-1")
				$hospital = $this->input->get('hospital');

			if(!is_null($this->input->get('proveedor')) && $this->input->get('proveedor') != "-1" && is_numeric($this->input->post('proveedor')))
				$proveedor = $this->input->get('proveedor');

			$principales = $this->pago_model->listarPrincipalesUsu($usuario["id_usuario"], 'null', 'null');
			if($principales)
			{
				if(sizeof($principales) == 1)
				$proveedor = $principales[0]["id_principal"];
			}

			if(!is_null($this->input->get('mes')) && $this->input->get('mes') != "-1")
				$mes = $this->input->get('mes');

			if(!is_null($this->input->get('anio')) && $this->input->get('anio') != "-1")
				$anio = $this->input->get('anio');

			mysqli_next_result($this->db->conn_id);
			$pagos = $this->pago_model->listarPagos($usuario["id_usuario"], $institucion, $hospital, $proveedor, $mes, $anio, "null", "null");
			
			$this->excel->getActiveSheet()->setTitle('ListadoPagosRealizados');
			#var_dump($institucion, $hospital, $proveedor, $mes, $anio);
			#var_dump($pagos);
	        //Contador de filas
	        $contador = 7;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('i')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
	        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);

	        $this->excel->getActiveSheet()->getStyle('A7:V7')
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
        	 $this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Pagos Realizados');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:V7')->applyFromArray($style);

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
	        
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Area Transaccional');
			$this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Folio');
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Tipo Operacion');
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Fecha Generación');
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Cta. Contable');
			$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Tipo Documento');
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Nro. Documento');
			$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Fecha Cumplimiento');
			$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Combinación Catalogo');
			$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Principal');
			$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Principal Relacionado');
			$this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Beneficiario');
			$this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Banco');
			$this->excel->getActiveSheet()->setCellValue("N{$contador}", 'Cta. Corriente');
			$this->excel->getActiveSheet()->setCellValue("O{$contador}", 'Medio Pago');
			$this->excel->getActiveSheet()->setCellValue("P{$contador}", 'Tipo Medio Pago');
			$this->excel->getActiveSheet()->setCellValue("Q{$contador}", 'Nro. Documento Pago');
			$this->excel->getActiveSheet()->setCellValue("R{$contador}", 'Fecha Emisi&oacute;n');
			$this->excel->getActiveSheet()->setCellValue("S{$contador}", 'Estado Documento');
			$this->excel->getActiveSheet()->setCellValue("T{$contador}", 'Monto');
			$this->excel->getActiveSheet()->setCellValue("U{$contador}", 'Moneda');
			$this->excel->getActiveSheet()->setCellValue("V{$contador}", 'Tipo Cambio');

	        //Definimos la data del cuerpo.        
	        
	        foreach($pagos as $pago){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $pago['nombre_area_transaccional']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $pago['folio']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $pago['tipo_operacion']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $pago['fecha_generacion']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $pago['cta_contable']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $pago['nombre_tipo_documento']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $pago['nro_documento']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $pago['fecha_cumplimiento']);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $pago['combinacion_catalogo']);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $pago['nombre_principal']);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", $pago['nombre_principal_relacionado']);
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $pago['nombre_beneficiario']);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", $pago['nombre_banco']);
				$this->excel->getActiveSheet()->setCellValue("N{$contador}", $pago['cta_corriente_banco']);
				$this->excel->getActiveSheet()->setCellValue("O{$contador}", $pago['medio_pago']);
				$this->excel->getActiveSheet()->setCellValue("P{$contador}", $pago['nombre_tipo_medio_pago']);
				$this->excel->getActiveSheet()->setCellValue("Q{$contador}", $pago['nro_documento_pago']);
				$this->excel->getActiveSheet()->setCellValue("R{$contador}", $pago['fecha_emision']);
				$this->excel->getActiveSheet()->setCellValue("S{$contador}", $pago['estado_documento']);
				$this->excel->getActiveSheet()->setCellValue("T{$contador}", $pago['monto']);
				$this->excel->getActiveSheet()->setCellValue("U{$contador}", $pago['moneda']);
				$this->excel->getActiveSheet()->setCellValue("V{$contador}", $pago['tipo_cambio']);
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "listadoPagosRealizados_{$contador}.xls";
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


    public function listarMesesAnios()
	{
		$usuario = $this->session->userdata();
		$meseAnio = [];
		$mesesAnios = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$hospital = "null";
			$proveedor = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('hospital')) && $this->input->post('hospital') != "-1")
				$hospital = $this->input->post('hospital');

			if(!is_null($this->input->post('proveedor')) && $this->input->post('proveedor') != "-1")
				$proveedor = $this->input->post('proveedor');

			$mesesAnios = $this->pago_model->obtenerAniosPagos($usuario["id_usuario"], $institucion, $hospital, $proveedor);

			$anios[] = array();
         	unset($anios[0]);


         	foreach ($mesesAnios as $mesAnio) {

				$anioEncontrado = array();
         		unset($anioEncontrado);

         		$anioEncontrado['idAnio'] = $mesAnio['idAnio'];
         		$anioEncontrado['nombreAnio'] = $mesAnio['nombreAnio'];

         		if(!in_array($anioEncontrado, $anios))
                	array_push($anios, $anioEncontrado);
			}
			$meseAnio['anios'] = $anios;

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
			$meseAnio['meses'] = $meses;

			echo json_encode($meseAnio);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarPagosPagination()
	{
		$usuario = $this->session->userdata();
		$meseAnio = [];
		$mesesAnios = [];
		if($this->session->userdata('id_usuario'))
		{
			mysqli_next_result($this->db->conn_id);
			$cantPagos = $this->pago_model->listarCantPagos($usuario["id_usuario"], "null", $idArea, $idPrincipal, "null", $mesesAnios[0]["idAnio"]);

			$config = array();
			$config['base_url'] = "#";//base_url()."Pago/ListarPagos";
  			$config['total_rows'] = (int)$cantPagos[0]["cantPagos"];
			$config['per_page'] = 100;
			$config['uri_segment'] = 86;
			$config['use_page_numbers'] = TRUE;
			$config['reuse_query_string'] = FALSE;
			$config['first_url'] = 28;

			$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
			$config['full_tag_close'] = '</ul></nav>';

			$config['first_link'] = 'Principio';
			$config["first_tag_open"] = '<li class="page-item"><a href="'.base_url().'Pago/ListarPagos/1" class="page-link" data-ci-pagination-page="1">';
			$config["first_tag_close"] = '</a></li>';

			$config['last_link'] = 'Final';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = 'Siguiente';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = 'Anterior';
			$config['prev_tag_open'] = '<li class="page-item">Anterior';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="page-item active"><a href="'.base_url().'Pago/ListarPagos/1" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';

			$config['attributes'] = array('class' => 'page-link');

			$config['num_links'] = 6;

			$this->pagination->initialize($config);
            // build paging links
            $usuario['links'] = $this->pagination->create_links();
            //$this->pagination->create_links();
			
			//$links = $this->pagination->create_links();
			mysqli_next_result($this->db->conn_id);
			$pagos = $this->pago_model->listarPagos($usuario["id_usuario"], $idInstitucion, $idArea, $idPrincipal, "null", "null", "null", "null");
			if($pagos)
				$usuario["pagos"] = $pagos;

		}else
		{
			redirect('Login');
		}
	}

}

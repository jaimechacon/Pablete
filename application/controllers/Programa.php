<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('programa_model');
		$this->load->model('institucion_model');
		$this->load->model('cuenta_model');
		$this->load->helper('form');
		//$this->load->library('upload', $this->session->userdata('config'));
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($usuario){

			$programas = $this->programa_model->listarProgramas();
				
			$usuario['programas'] = $programas;
			$usuario['controller'] = 'programa';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarProgramas', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function asignarPrograma()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			$programas = $this->programa_model->listarProgramas();
			$usuario['programas'] = $programas;
			
			mysqli_next_result($this->db->conn_id);
			$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
			if($instituciones)
				$usuario["instituciones"] = $instituciones;


			mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			$usuario['controller'] = 'programa';

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('asignarPrograma', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function agregarPrograma()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$formaPagos = $this->programa_model->obtenerFormasPago();
			$usuario['formaPagos'] = $formaPagos;

			$usuario['controller'] = 'programa';
			//mysqli_next_result($this->db->conn_id);
			//$usuarios = $this->usuario_model->listarAnalistaUsu();
			//$usuario['usuarios'] = $usuarios;
				
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarPrograma', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function listarProgramas()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$programas = $this->programa_model->listarProgramas();

				$table_programas ='
				<table id="tablaProgramas" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="text-center align-middle registro texto-pequenio"># ID</th>
					    <th scope="col" class="text-center align-middle registro texto-pequenio">Nombre</th>
					    <th scope="col" class="text-center align-middle registro texto-pequenio">Descripci&oacute;n</th>
					    <th scope="col" class="text-center align-middle registro texto-pequenio">Forma de Pago</th>
					    <th scope="col" class="text-center align-middle registro texto-pequenio" style="width: 50px;"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
		        ';

		        if(isset($programas) && sizeof($programas) > 0)
				{								
					foreach ($programas as $programa) {
						$table_programas .= '<tr>
								<tr>
						        <th scope="row" class="text-center align-middle registro texto-pequenio">'.$programa['id_programa'].'</th>
						        <td class="text-center align-middle registro texto-pequenio">'.$programa['nombre'].'</td>
						        <td class="text-center align-middle registro texto-pequenio">'.$programa['descripcion'].'</td>
						        <td class="text-center align-middle registro texto-pequenio">'.$programa['forma_pago'].'</td>
						        <td class="text-center align-middle registro texto-pequenio">
						        	<a id="trash_'.$programa['id_programa'].'" class="trash" href="#" data-id="'.$programa['id_programa'].'" data-nombre="'.$programa['nombre'].'" data-toggle="modal" data-target="#modalEliminarPrograma">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$programa['id_programa'].'" class="edit" type="link" href="ModificarPrograma/?idPrograma='.$programa['id_programa'].'" data-id="'.$programa['id_programa'].'" data-nombre="'.$programa['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_programas .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_programas .='
		        	</tbody>
		        </table>';

				$datos = array('table_programas' =>$table_programas);
		        

		        echo json_encode($datos);

			}else{
				$programas = $this->programa_model->listarProgramas();
				
				$usuario['programas'] = $programas;
				$usuario['controller'] = 'programa';
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarProgramas', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}

	public function eliminarPrograma()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idPrograma = null;
			if($this->input->POST('idPrograma'))
				$idPrograma = $this->input->POST('idPrograma');
			$resultado = $this->programa_model->eliminarPrograma($idPrograma, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function agregarMarco()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$programa = "null";
			$subtitulo = "null";
			$institucion = "null";
			$marco = "null";
			$nombre = "null";
			$extension = "null";
			$peso = "null";


			if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "-1")
				$programa = $this->input->post('idPrograma');

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$institucion = $this->input->post('institucion');

			if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "-1")
				$subtitulo = $this->input->post('subtitulo');

			if(!is_null($this->input->post('inputMarco')) && $this->input->post('inputMarco') != "-1")
				$marco = $this->input->post('inputMarco');

			if(!is_null($this->input->post('archivoMarco')) && $this->input->post('archivoMarco') != "-1")
				$archivoMarco = $this->input->post('archivoMarco');

			$resultado = $this->programa_model->agregarMarco("null", $programa, $subtitulo, $institucion, $marco, $usuario['id_usuario']);
			
			if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_marco']))
			{
				$idMarco = $resultado[0]['id_marco'];
				$cantArchivos = $resultado[0]['cant_archivos'];

				$nombreOriginal = $_FILES["archivoMarco"]["name"];
				$temp = explode(".", $_FILES["archivoMarco"]["name"]);
				$nuevoNombre =  $idMarco. '_' .($cantArchivos + 1). '.' . end($temp);
				$config['upload_path'] = './assets/files/';
				$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
				$config['file_name'] = $nuevoNombre;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('archivoMarco'))
				{
					$error = $this->upload->display_errors();
				}
				else
				{
					$archivo = $this->upload->data();
					$tmp = explode(".", $archivo['file_ext']);
					$extension = end($tmp);

					mysqli_next_result($this->db->conn_id);
					$archivoAgregado = $this->programa_model->agregarArchivo("null", $idMarco, "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

					if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
					{
						$datos['mensaje'] = 'Se ha agregado exitosamente el Marco Presupuestario';
						$datos['resultado'] = 1;
					}
				}
			}

			echo json_encode($datos);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarComunasMarco()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$marco = "null";

			if(!is_null($this->input->post('marco')) && $this->input->post('marco') != "-1")
				$marco = $this->input->post('marco');

			$comunas = $this->programa_model->listarComunasMarco($marco, $usuario["id_usuario"]);
			echo json_encode($comunas);
		}
		else
		{
			redirect('Login');
		}
	}

	public function asignarConvenios()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			$marcos = $this->programa_model->listarMarcosUsuario($usuario["id_usuario"]);
			$usuario['marcos'] = $marcos;
			
			mysqli_next_result($this->db->conn_id);
			$comunas = $this->programa_model->listarComunasMarco("null", $usuario["id_usuario"]);
			if($comunas)
				$usuario["comunas"] = $comunas;


			mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			$usuario['controller'] = 'programa';

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('asignarConvenios', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}


	public function agregarConvenio()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$idMarco = "null";
			$comuna = "null";
			$convenio = "null";
			$archivoConvenio = "null";
			$extension = "null";
			$peso = "null";


			if(!is_null($this->input->post('idMarco')) && $this->input->post('idMarco') != "-1")
				$idMarco = $this->input->post('idMarco');

			if(!is_null($this->input->post('comuna')) && $this->input->post('comuna') != "-1")
				$comuna = $this->input->post('comuna');

			if(!is_null($this->input->post('inputConvenio')) && $this->input->post('inputConvenio') != "-1")
				$convenio = $this->input->post('inputConvenio');

			//if(!is_null($this->input->post('archivoConvenio')) && $this->input->post('archivoConvenio') != "-1")
				//$archivoConvenio = $this->input->post('archivoConvenio');
			//var_dump($archivoConvenio);
			//var_dump($_FILES);
			$resultado = $this->programa_model->agregarConvenio("null", $idMarco, $comuna, $convenio, $usuario['id_usuario']);
			//var_dump($resultado);
			if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['idConvenio']))
			{
				$idConvenio = $resultado[0]['idConvenio'];
				$cantArchivos = $resultado[0]['cant_archivos'];
				
				$nombreOriginal = $_FILES["archivoConvenio"]["name"];
				$temp = explode(".", $_FILES["archivoConvenio"]["name"]);
				$nuevoNombre =  $idMarco.'_'.$idConvenio. '_' .($cantArchivos + 1). '.' . end($temp);
				$config['upload_path'] = './assets/files/';
				$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
				$config['file_name'] = $nuevoNombre;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('archivoConvenio'))
				{
					$error = $this->upload->display_errors();
				}
				else
				{
					$archivo = $this->upload->data();
					$tmp = explode(".", $archivo['file_ext']);
					$extension = end($tmp);

					mysqli_next_result($this->db->conn_id);
					$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", $idConvenio, $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

					if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
					{
						$datos['mensaje'] = 'Se ha agregado exitosamente el Convenio.';
						$datos['resultado'] = 1;
					}
				}
			}

			echo json_encode($datos);
		}
		else
		{
			redirect('Login');
		}
	}
}

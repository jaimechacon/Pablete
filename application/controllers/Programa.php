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

	public function asignarMarco()
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

	public function guardarPrograma()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$datos[] = array();
		     	unset($datos[0]);
				$clasificacion = "null";
				$nombre = "null";
				$id_forma_pago = "null";
				$observacion = "null";
				$id_programa = "null";

				if(!is_null($this->input->post('clasificacion')) && $this->input->post('clasificacion') != "-1")
					$clasificacion = $this->input->post('clasificacion');

				if(!is_null($this->input->post('nombre')) && $this->input->post('nombre') != "-1")
					$nombre = $this->input->post('nombre');

				if(!is_null($this->input->post('observacion')) && $this->input->post('observacion') != "-1")
					$observacion = $this->input->post('observacion');

				if(!is_null($this->input->post('idFormaPago')) && $this->input->post('idFormaPago') != "-1")
					$id_forma_pago = $this->input->post('idFormaPago');

				if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "-1")
					$id_programa = $this->input->post('idPrograma');

				$resultado = $this->programa_model->agregarPrograma("null", $clasificacion, $nombre, $id_forma_pago, $observacion, $usuario['id_usuario']);

				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_programa']))
				{
					$datos['mensaje'] = 'Se ha agregado exitosamente el Programa.';
					$datos['resultado'] = 1;
				}
		        echo json_encode($datos);				
			}
		}else
		{
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
			
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarPrograma', $usuario);
			$this->load->view('temp/footer');
		}else
		{
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
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Forma de Pago</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
		        ';

		        if(isset($programas) && sizeof($programas) > 0)
				{								
					foreach ($programas as $programa) {
						$table_programas .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$programa['id_programa'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$programa['nombre'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$programa['descripcion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$programa['forma_pago'].'</p></td>
						        <td class="text-center align-middle registro texto-pequenio botonTabla">
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
					$datos['error'] = $error;
					$datos['mensaje'] = 'Se ha producido un error al guardar el adjunto.';
					$datos['resultado'] = 0;
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

			$comunas = $this->programa_model->listarComunasMarco("null", $marco, $usuario["id_usuario"]);
			echo json_encode($comunas);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarMarcosUsuario()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$idInstitucion = "null";

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1")
				$idInstitucion = $this->input->post('institucion');

			$marcos = $this->programa_model->listarMarcosUsuario($idInstitucion, $usuario["id_usuario"]);

			mysqli_next_result($this->db->conn_id);
			$comunas = $this->programa_model->listarComunasMarco($idInstitucion, "null", $usuario["id_usuario"]);
			
			$datos = array('marcos' =>$marcos, 'comunas' =>$comunas);

			echo json_encode($datos);
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
			$marcos = $this->programa_model->listarMarcosUsuario("null", $usuario["id_usuario"]);
			$usuario['marcos'] = $marcos;
			
			mysqli_next_result($this->db->conn_id);
			$comunas = $this->programa_model->listarComunasMarco("null", "null", $usuario["id_usuario"]);
			if($comunas)
				$usuario["comunas"] = $comunas;


			mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			$usuario['controller'] = 'programa';

			$id_usuario = $this->session->userdata('id_usuario');

			$id_institucion_seleccionado = "null";

			mysqli_next_result($this->db->conn_id);
			$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
			
			if($datos_usuario[0]["id_perfil"] == "1")
			{
				mysqli_next_result($this->db->conn_id);
				$instituciones =  $this->institucion_model->listarInstitucionesUsu($id_usuario);
				$usuario["instituciones"] = $instituciones;
				$usuario["idInstitucion"] = $instituciones[0]["id_institucion"];
				$id_institucion_seleccionado = $instituciones[0]["id_institucion"];
			}

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

	public function listarMarcos()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$marcos = $this->programa_model->listarMarcos("null", "null", $usuario["id_usuario"]);

				$table_marcos ='
				<table id="tListaMarcos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro">PDF</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
						</tr>
					</thead>
					<tbody id="tbodyMarcos">
		        ';

		        if(isset($marcos) && sizeof($marcos) > 0)
				{								
					foreach ($marcos as $marco) {
						$table_marcos .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['id_marco'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['programa'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['fecha'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['marco'], 0, ",", ".").'</p></td>
						         <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">';
						        if(strlen(trim($marco['ruta_archivo'])) > 1) {
									$table_marcos .= '<a id="view_'.$marco['id_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>';
						        }
					        	$table_marcos .= '</td>
					        	 <td class="text-center align-middle registro botonTabla">
						        	<a id="trash_'.$marco['id_marco'].'" class="trash" href="#" data-id="'.$marco['id_marco'].'" data-institucion="'.$marco['institucion'].'"  data-programa="'.$marco['programa'].'" data-toggle="modal" data-target="#modalEliminarMarco">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_marcos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_marcos .='
		        	</tbody>
		        </table>';

				$datos = array('table_marcos' =>$table_marcos);
		        echo json_encode($datos);
			}else{
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

				mysqli_next_result($this->db->conn_id);
				$marcos = $this->programa_model->listarMarcos("null", "null", $usuario["id_usuario"]);
				if($marcos)
					$usuario['marcos'] = $marcos;

				$usuario['controller'] = 'programa';

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarMarcos', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function listarConvenios()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$convenios = $this->programa_model->listarConvenios("null", "null", "null", $usuario["id_usuario"]);

				$table_convenios ='
				<table id="tListaConvenios" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro">Adjunto</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
						</tr>
					</thead>
					<tbody id="tbodyConvenios">
		        ';

		        if(isset($convenios) && sizeof($convenios) > 0)
				{								
					foreach ($convenios as $convenio) {
						$table_convenios .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['id_convenio'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['comuna'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['programa'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['fecha'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($convenio['convenio'], 0, ",", ".").'</p></td>

						        <td class="text-center align-middle registro botonTabla paginate_button">';

						        if(strlen(trim($convenio['ruta_archivo'])) > 1) {
									$table_convenios .= '<a id="view_'.$convenio['id_convenio'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$convenio['ruta_archivo'].'">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>';
						        }
					        	$table_convenios .= '</td>
					        	 <td class="text-center align-middle registro botonTabla">
						        	<a id="trash_'.$convenio['id_convenio'].'" class="trash" href="#" data-id="'.$convenio['id_convenio'].'" data-comuna="'.$convenio['comuna'].'" data-toggle="modal" data-target="#modalEliminarConvenio">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_convenios .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_convenios .='
		        	</tbody>
		        </table>';

				$datos = array('table_convenios' =>$table_convenios);
		        echo json_encode($datos);
			}else{
				$convenios = $this->programa_model->listarConvenios("null", "null", "null", $usuario["id_usuario"]);
				if($convenios)
					$usuario['convenios'] = $convenios;

				$usuario['controller'] = 'programa';

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarConvenios', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function eliminarConvenio()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idConvenio = null;
			if($this->input->POST('idConvenio'))
				$idConvenio = $this->input->POST('idConvenio');
			$resultado = $this->programa_model->eliminarConvenio($idConvenio, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function eliminarMarco()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idMarco = null;
			if($this->input->POST('idMarco'))
				$idMarco = $this->input->POST('idMarco');
			$resultado = $this->programa_model->eliminarMarco($idMarco, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function realizarTransferencias()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			$marcos = $this->programa_model->listarMarcosUsuario("null", $usuario["id_usuario"]);
			$usuario['marcos'] = $marcos;
			
			mysqli_next_result($this->db->conn_id);
			$comunas = $this->programa_model->listarComunasMarco("null", "null", $usuario["id_usuario"]);
			if($comunas)
				$usuario["comunas"] = $comunas;


			mysqli_next_result($this->db->conn_id);
			$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
			if($cuentas)
				$usuario["cuentas"] = $cuentas;

			$usuario['controller'] = 'programa';

			$id_usuario = $this->session->userdata('id_usuario');

			$id_institucion_seleccionado = "null";

			mysqli_next_result($this->db->conn_id);
			$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
			
			if($datos_usuario[0]["id_perfil"] == "1")
			{
				mysqli_next_result($this->db->conn_id);
				$instituciones =  $this->institucion_model->listarInstitucionesUsu($id_usuario);
				$usuario["instituciones"] = $instituciones;
				$usuario["idInstitucion"] = $instituciones[0]["id_institucion"];
				$id_institucion_seleccionado = $instituciones[0]["id_institucion"];
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('realizarTransferencias', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}
}

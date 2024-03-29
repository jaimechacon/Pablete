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
		$this->load->model('hospital_model');
		$this->load->helper('form');
		$this->load->library('excel');
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
			
			//var_dump($presupuestos);


			
			$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
			$usuario['periodos'] = $periodos;
			$anioSeleccionado = "NULL";
			if (isset($periodos) && sizeof($periodos) > 0){
				if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
					$anioSeleccionado = $usuario["anio_seleccionado"];
					$usuario['anioSeleccionado'] = $anioSeleccionado;
				}else{
					$anioSeleccionado = $periodos[0]["anio"];
					$usuario['anioSeleccionado'] = $periodos[0]["anio"];
					$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
				}
			}

			#
			$presupuestos = $this->programa_model->listarPresupuestosMarco($anioSeleccionado, "null", $usuario["id_usuario"]);
			$usuario['presupuestos'] = $presupuestos;

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
			$this->load->view('asignarMarco', $usuario);
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
				$codigo = "null";
				$nombre = "null";
				$id_forma_pago = "null";
				$observacion = "null";
				$id_programa = "null";

				if(!is_null($this->input->post('codigo')) && $this->input->post('codigo') != "-1")
					$codigo = $this->input->post('codigo');

				if(!is_null($this->input->post('nombre')) && $this->input->post('nombre') != "-1")
					$nombre = $this->input->post('nombre');

				if(!is_null($this->input->post('observacion')) && $this->input->post('observacion') != "-1")
					$observacion = $this->input->post('observacion');

				if(!is_null($this->input->post('idFormaPago')) && $this->input->post('idFormaPago') != "-1")
					$id_forma_pago = $this->input->post('idFormaPago');

				if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "-1")
					$id_programa = $this->input->post('idPrograma');

				$resultado = $this->programa_model->agregarPrograma("null", $codigo, $nombre, $id_forma_pago, $observacion, $usuario['id_usuario']);

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

	public function modificarPrograma()
	{
		$usuario = $this->session->userdata();
		//var_dump($this->input->get('idPrograma'));
		//var_dump($usuario);
		if($usuario){
			//var_dump('expression');
			$idPrograma = "null";
			if(!is_null($this->input->get('idPrograma')) && $this->input->get('idPrograma') != "-1")
				$idPrograma = $this->input->get('idPrograma');
			//var_dump($idPrograma);
			$resultado = $this->programa_model->obtenerPrograma($idPrograma);

			mysqli_next_result($this->db->conn_id);
			$formaPagos = $this->programa_model->obtenerFormasPago();

			//var_dump($resultado);
			$usuario['formaPagos'] = $formaPagos;
			$usuario['programa'] = $resultado[0];
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

	public function modificarPresupuesto()
	{
		$usuario = $this->session->userdata();
		//var_dump($this->input->get('idPresupuesto'));
		//var_dump($usuario);
		if($usuario){
			//var_dump('expression');

			if ($_SERVER['REQUEST_METHOD'] === 'POST' && !is_null($this->input->post('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1") {
				$programa = "null";
				$subtitulo = "null";
				$presupuesto = "null";
				$presupuesto6 = "null";
				$presupuesto3 = "null";
				$presupuesto4 = "null";
				$presupuesto5 = "null";
				$nombre = "null";
				$extension = "null";
				$peso = "null";
				$primero = false;

				$id_presupuesto = $this->input->post('idPresupuesto');


				if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "-1")
					$programa = $this->input->post('idPrograma');

				
				if(!is_null($this->input->post('inputPresupuesto6')) && $this->input->post('inputPresupuesto6') != "-1")
					$presupuesto6 = $this->input->post('inputPresupuesto6');

				if(!is_null($this->input->post('inputPresupuesto3')) && $this->input->post('inputPresupuesto3') != "-1")
					$presupuesto3 = $this->input->post('inputPresupuesto3');

				if(!is_null($this->input->post('inputPresupuesto4')) && $this->input->post('inputPresupuesto4') != "-1")
					$presupuesto4 = $this->input->post('inputPresupuesto4');

				if(!is_null($this->input->post('inputPresupuesto5')) && $this->input->post('inputPresupuesto5') != "-1")
					$presupuesto5 = $this->input->post('inputPresupuesto5');

				
				$resultado = null;
				$idPresupuesto = null;
				$cantArchivos = null;
				$nombreOriginal = null;
				$temp = null;
				$nuevoNombre = null;
				$archivo = null;
				$tmp = null;
				$extension = null;
				$config = null;
				//$presupuesto = (($i==0) ? $presupuesto6 : (($i==1) ? $presupuesto3 : (($i==2) ? $presupuesto4 : $presupuesto5)));
				//$subtitulo = (($i==0) ? 6 : (($i==1) ? 3 : (($i==2) ? 4 : 5)));
				
					

				$resultado = $this->programa_model->agregarPresupuesto($id_presupuesto, $programa, $presupuesto6, $presupuesto3, $presupuesto4, $presupuesto5, $usuario['id_usuario']);
				$primero = true;
				//var_dump($presupuesto6.$presupuesto3, $presupuesto4, $presupuesto5);
				//var_dump($resultado[0]['id_presupuesto']);
				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_presupuesto']))
				{
					$idPresupuesto = $resultado[0]['id_presupuesto'];
					//$cantArchivos = $resultado[0]['cant_archivos'];

					/*if($_FILES["archivoPresupuesto"]["name"] != "")
					{
						$nombreOriginal = $_FILES["archivoPresupuesto"]["name"];
						$temp = explode(".", $_FILES["archivoPresupuesto"]["name"]);
						$nuevoNombre =  $idPresupuesto. '_' .($cantArchivos + 1). '.' . end($temp);
						$config['upload_path'] = './assets/files/';
						$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
						$config['file_name'] = $nuevoNombre;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if(!$this->upload->do_upload('archivoPresupuesto'))
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
							$archivoAgregado = $this->programa_model->agregarArchivo("null", $idPresupuesto, "null", "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

							if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
							{
								$datos['Subtitulo'.$subtitulo]['mensaje'] = 'Se ha agregado exitosamente el Presupuesto. Se ha importado exitosamente el adjunto.';
								$datos['Subtitulo'.$subtitulo]['resultado'] = 1;
								$datos['Subtitulo'.$subtitulo]['idPresupuesto'] = $idPresupuesto;
							}
						}
					}else
					{*/
					$datos['mensaje'] = 'Se ha modificado exitosamente el Presupuesto.';
					$datos['resultado'] = 1;
					$datos['idPresupuesto'] = $idPresupuesto;
					//}
				}
				

				echo json_encode($datos);
			
			}else{
				$idPresupuesto = "null";
				if(!is_null($this->input->get('idPresupuesto')) && $this->input->get('idPresupuesto') != "-1")
					$idPresupuesto = $this->input->get('idPresupuesto');
				#var_dump($idPresupuesto);
				$resultado = $this->programa_model->obtenerPresupuesto($usuario['id_usuario'], $idPresupuesto);

				mysqli_next_result($this->db->conn_id);
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

				//var_dump($resultado);
				
				//var_dump($resultado);
				//$formaPagos = $this->programa_model->obtenerFormasPago();
				$usuario['presupuesto'] = $resultado[0];
				//var_dump($resultado[0]);
				$usuario['controller'] = 'programa';
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('modificarPresupuesto', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function modificarMarco()
	{
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$resultado = null;
				$presupuesto = "null";
				$institucion = "null";
				$grupo_marco = "null";
				$nombre = "null";
				$extension = "null";
				$peso = "null";
				$hospitales = "null";
				$comunas = "null";
				$cantidad = 0;
				$subtitulo = "null";
				$asignacion = "null";

				if(!is_null($this->input->post('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1")
					$presupuesto = $this->input->post('idPresupuesto');

				if(!is_null($this->input->post('archivoMarcoModificar')) && $this->input->post('archivoMarcoModificar') != "-1")
					$archivoMarco = $this->input->post('archivoMarcoModificar');

				if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1" && $this->input->post('institucion') != "")
					$institucion = $this->input->post('institucion');

				if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1" && $this->input->post('cantidad') != "")
					$cantidad = $this->input->post('cantidad');

				if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "-1" && $this->input->post('subtitulo') != "")
					$subtitulo = $this->input->post('subtitulo');

				if(!is_null($this->input->post('inputIdMarco')) && $this->input->post('inputIdMarco') != "-1" && $this->input->post('inputIdMarco') != "")
					$grupo_marco = $this->input->post('inputIdMarco');

				if(!is_null($this->input->post('inputPresupuestoInstitucionMarco')) && $this->input->post('inputPresupuestoInstitucionMarco') != "-1" && $this->input->post('inputPresupuestoInstitucionMarco') != "")
					$asignacion = $this->input->post('inputPresupuestoInstitucionMarco');
				
				if (is_numeric($cantidad) && (int)$cantidad > 0) {
					$cantidades = (int)$cantidad;
					$hospital = "null";
					$comuna = "null";
					for ($i=0; $i < $cantidades; $i++) {
						$idMarco = "null";
						//var_dump('entro al for');
						if (is_numeric($this->input->post('inputIdMarco'.$i)) && (floatval($this->input->post('inputIdMarco'.$i)) > 0))
							$idMarco = $this->input->post('inputIdMarco'.$i);

						if($subtitulo == "3" || $subtitulo == "5" || $subtitulo == "6")
						{
							$hospital = $this->input->post('inputHospital'.$i);
							$marco = $this->input->post('inputMarco'.$i);
							if (is_numeric($hospital) && (floatval($hospital) > 0))
								$hospital = floatval($hospital);
						}else{
							if ($subtitulo == "4") {
								$comuna = $this->input->post('inputComuna'.$i);
								$marco = $this->input->post('inputMarco'.$i);
								if (is_numeric($comuna) && (floatval($comuna) > 0))
									$comuna = floatval($comuna);
							}
						}

						if ($marco == "" && is_numeric($idMarco))
							$marco = 0;

						if (is_numeric($marco))
						{
							$resultado = $this->programa_model->agregarMarco($grupo_marco, $idMarco, $presupuesto, $institucion, $hospital, $comuna, $marco, $asignacion, $usuario['id_usuario']);
							//var_dump($resultado);
							mysqli_next_result($this->db->conn_id);
						}
					}
				}

				if ($resultado && isset($resultado) && sizeof($resultado) > 0) {
					
						$grupo_marco = $resultado[0]['idGrupoMarco'];

					if($grupo_marco != null && is_numeric($grupo_marco) > 0)
					{
						$idMarco = $resultado[0]['idGrupoMarco'];
						$cantArchivos = (int)$resultado[0]['cant_archivos'];


						if($_FILES["archivoMarcoModificar"]["name"] != "")
						{
							$nombreOriginal = $_FILES["archivoMarcoModificar"]["name"];
							$temp = explode(".", $_FILES["archivoMarcoModificar"]["name"]);
							$nuevoNombre =  $presupuesto.'_'.$idMarco. '_' .($cantArchivos + 1). '.' . end($temp);
							$config['upload_path'] = './assets/files/';
							$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
							$config['file_name'] = $nuevoNombre;
							$this->load->library('upload', $config);

							if(!$this->upload->do_upload('archivoMarcoModificar'))
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

								//mysqli_next_result($this->db->conn_id);

								$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", $idMarco, "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

								//var_dump($archivoAgregado);

								if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
								{
									$datos['mensaje'] = 'Se ha modificado exitosamente el Marco Presupuestario. Se ha importado exitosamente el adjunto.';
									$datos['resultado'] = 1;
									$datos['idMarco'] = $idMarco;
								}
							}
						}else
						{
							$datos['mensaje'] = 'Se ha modificado exitosamente el Marco Presupuestario';
							$datos['resultado'] = 1;
							$datos['idMarco'] = $idMarco;
						}
					}
				}

				echo json_encode($datos);
				//$idMarco = $resultado[0]['id_marco'];
			}else{
				$idMarco = "null";
				//var_dump($this->input->get('idMarco'));
				if(!is_null($this->input->get('idMarco')) && $this->input->get('idMarco') != "-1")
					$idMarco = $this->input->get('idMarco');



				$resultado = $this->programa_model->obtenerMarco($usuario['id_usuario'], $idMarco);
				//var_dump($resultado);

				$suma_marcos = array_sum(array_column($resultado, 'marco'));
				
				if (isset($resultado) && !is_null($resultado) && sizeof($resultado) > 0) {

					mysqli_next_result($this->db->conn_id);
					$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
					if($instituciones)
						$usuario["instituciones"] = $instituciones;


					$es_hospital = $resultado[0]['es_hospital'];
					$hospitales = null;
					$comunas = null;
					if($es_hospital == "1")
					{
						mysqli_next_result($this->db->conn_id);
						$hospitales = $this->hospital_model->listarHospitalesUsuAPS($usuario["id_usuario"], $resultado[0]['id_institucion']);
						$usuario['cantidad'] = sizeof($hospitales);
					}else{
						mysqli_next_result($this->db->conn_id);
						$comunas = $this->programa_model->listarComunasInstitucion($usuario["id_usuario"], $resultado[0]['id_institucion'], "null");
						$usuario['cantidad'] = sizeof($comunas);
					}

					$usuario['hospitales'] = $hospitales;
					$usuario['comunas'] = $comunas;
					$usuario['suma_marcos'] = $suma_marcos;
					//var_dump($resultado);
					//$formaPagos = $this->programa_model->obtenerFormasPago();

					$usuario['controller'] = 'programa';
					$usuario['marco'] = $resultado;

					$this->load->view('temp/header');
					$this->load->view('temp/menu', $usuario);
					$this->load->view('modificarMarco', $usuario);
					$this->load->view('temp/footer');
				}else
				{
					redirect('Programa/listarMarcos');
				}
			}
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
			$presupuesto = "null";
			$institucion = "null";
			$grupo_marco = "null";
			$nombre = "null";
			$extension = "null";
			$peso = "null";
			$hospitales = "null";
			$comunas = "null";
			$cantidad = 0;
			$subtitulo = "null";
			$asignacion = "null";
			#$anio = "null";

			#if(!is_null($this->input->post('periodo')) && $this->input->post('periodo') != "" && $this->input->post('periodo') != "-1"){
				#$anio = $this->input->post('periodo');
				#$this->session->set_userdata('anio_seleccionado', $anio);
			#}

			if(!is_null($this->input->post('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1")
				$presupuesto = $this->input->post('idPresupuesto');

			if(!is_null($this->input->post('archivoMarcoAsignar')) && $this->input->post('archivoMarcoAsignar') != "-1")
				$archivoMarco = $this->input->post('archivoMarcoAsignar');

			if(!is_null($this->input->post('idInstitucionM')) && $this->input->post('idInstitucionM') != "-1" && $this->input->post('idInstitucionM') != "")
				$institucion = $this->input->post('idInstitucionM');

			if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1" && $this->input->post('cantidad') != "")
				$cantidad = $this->input->post('cantidad');

			if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "-1" && $this->input->post('subtitulo') != "")
				$subtitulo = $this->input->post('subtitulo');

			if(!is_null($this->input->post('inputPresupuestoInstitucion')) && $this->input->post('inputPresupuestoInstitucion') != "-1" && $this->input->post('inputPresupuestoInstitucion') != "")
				$asignacion = $this->input->post('inputPresupuestoInstitucion');

			//var_dump($presupuesto.' - institucion: '.$institucion.' - cantidad: '.$cantidad.' -  subtitulo: '.$subtitulo);
			//var_dump($this->input->post());

			$suma_total = 0;

			if (is_numeric($cantidad) && (int)$cantidad > 0) {
				$cantidades = (int)$cantidad;
				$hospital = "null";
				$comuna = "null";
				for ($i=0; $i < $cantidades; $i++) {
					$resultado = null;
					if($subtitulo == "3" || $subtitulo == "5" || $subtitulo == "6")
					{
						$hospital = $this->input->post('inputHospital'.$i);
						$marco = $this->input->post('inputMarco'.$i);
						if (is_numeric($hospital) && (floatval($hospital) > 0))
							$hospital = floatval($hospital);
					}else{
						if ($subtitulo == "4") {
							$comuna = $this->input->post('inputComuna'.$i);
							$marco = $this->input->post('inputMarco'.$i);
							if (is_numeric($comuna) && (floatval($comuna) > 0))
								$comuna = floatval($comuna);
						}
					}

					//var_dump($grupo_marco."null".$presupuesto.$institucion.$hospital.$comuna.$marco.$usuario['id_usuario']);
					//var_dump($grupo_marco);


					if (is_numeric($marco) && (floatval($marco) > 0))
					{
						$resultado = $this->programa_model->agregarMarco($grupo_marco, "null", $presupuesto, $institucion, $hospital, $comuna, $marco, $asignacion, $usuario['id_usuario']);
						$suma_total = $suma_total + $marco;
						$grupo_marco = $resultado[0]['idGrupoMarco'];

						//if ($grupo_marco > 0)
						mysqli_next_result($this->db->conn_id);
					}
				}
			}

			if ($suma_total == 0) {
				$resultado = $this->programa_model->agregarGrupoMarco($grupo_marco, $presupuesto, $institucion, $asignacion, $usuario['id_usuario']);
				
				$grupo_marco = $resultado[0]['idGrupoMarco'];
				mysqli_next_result($this->db->conn_id);
			}

			if($grupo_marco != null && is_numeric($grupo_marco) > 0)
			{
				$idMarco = $grupo_marco;//$resultado[0]['idGrupoMarco'];
				$cantArchivos = (int)$resultado[0]['cant_archivos'];

				if($_FILES["archivoMarcoAsignar"]["name"] != "")
				{
					$nombreOriginal = $_FILES["archivoMarcoAsignar"]["name"];
					$temp = explode(".", $_FILES["archivoMarcoAsignar"]["name"]);
					$nuevoNombre =  $presupuesto.'_'.$idMarco. '_' .($cantArchivos + 1). '.' . end($temp);
					$config['upload_path'] = './assets/files/';
					$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
					$config['file_name'] = $nuevoNombre;
					$this->load->library('upload', $config);

					if(!$this->upload->do_upload('archivoMarcoAsignar'))
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

						//mysqli_next_result($this->db->conn_id);
						$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", $idMarco, "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

						if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
						{
							$datos['mensaje'] = 'Se ha agregado exitosamente el Marco Presupuestario. Se ha importado exitosamente el adjunto.';
							$datos['resultado'] = 1;
							$datos['idMarco'] = $idMarco;
						}
					}
				}else
				{
					$datos['mensaje'] = 'Se ha agregado exitosamente el Marco Presupuestario';
					$datos['resultado'] = 1;
					$datos['idMarco'] = $idMarco;
				}
			}

			echo json_encode($datos);
		}
		else
		{
			redirect('Login');
		}
	}

	public function agregarMarcoD()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$grupo_marco = "null";
			$id_grupo_marco = "null";
			$id_marco = "null";
			$hospitales = "null";
			$comunas = "null";
			$cantidad = 0;
			$subtitulo = "null";
			$convenio = "null";
			$idConvenio = "null";

			$cantConvenios = 0;
			$cantConveniosArchivos = 0;

			if(!is_null($this->input->post('idMarcoD')) && $this->input->post('idMarcoD') != "-1")
				$id_grupo_marco = $this->input->post('idMarcoD');

			if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1" && $this->input->post('cantidad') != "")
				$cantidad = $this->input->post('cantidad');

			if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "-1" && $this->input->post('subtitulo') != "")
				$subtitulo = $this->input->post('subtitulo');

			//var_dump($presupuesto.' - institucion: '.$institucion.' - cantidad: '.$cantidad.' -  subtitulo: '.$subtitulo);
			//var_dump($this->input->post());
			if (is_numeric($cantidad) && (int)$cantidad > 0) {
				$cantidades = (int)$cantidad;
				$hospital = "null";
				$comuna = "null";
				$numResolucion = "null";
				$fechaResolucion = "null";

				for ($i=0; $i < $cantidades; $i++) {
					$resultado = null;
					$convenio = "null";

					$fecha = $this->input->post('inputFecha'.$i);
					$numero = $this->input->post('inputNum'.$i);

					if (DateTime::createFromFormat('Y-m-d', $fecha) !== FALSE)
					  $fechaResolucion = $fecha;

					if (is_numeric($numero) && (floatval($numero)) > 0)
						$numResolucion = floatval($numero);

					if($subtitulo == "3" || $subtitulo == "5" || $subtitulo == "6")
					{
						$hospital = $this->input->post('inputHospital'.$i);
						$convenio = $this->input->post('inputMarco'.$i);
						if (is_numeric($hospital) && (floatval($hospital) > 0))
							$hospital = floatval($hospital);
					}else{
						if ($subtitulo == "4") {
							$comuna = $this->input->post('inputComuna'.$i);
							$convenio = $this->input->post('inputMarco'.$i);
							if (is_numeric($comuna) && (floatval($comuna) > 0))
								$comuna = floatval($comuna);
						}
					}

					if (is_numeric($convenio) && (floatval($convenio) > 0))
					{
						$resultado = $this->programa_model->agregarMarcoConvenio($id_grupo_marco, $id_marco, $hospital, $comuna, $convenio, $numResolucion, $fechaResolucion, $usuario['id_usuario']);

						$idConvenio = $resultado[0]['idConvenio'];
						$id_marco = $resultado[0]['idMarco'];
						$nuevoNombre = "";

						mysqli_next_result($this->db->conn_id);

						if($idConvenio != null && is_numeric($idConvenio) > 0)
						{
							$cantConvenios++;
							$cantArchivos = $resultado[0]['cant_archivos'];

							if($_FILES['inputAdjunto'.$i]["name"] != "")
							{
								$nombreOriginal = $_FILES['inputAdjunto'.$i]["name"];
								$temp = explode(".", $_FILES['inputAdjunto'.$i]["name"]);
								$nuevoNombre =  $id_grupo_marco.'_'.$id_marco.'_'.$idConvenio.'_1.'.end($temp);
								$config['upload_path'] = './assets/files/';
								$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
								$config['file_name'] = $nuevoNombre;
								$this->load->library('upload', $config);

								

								$dir_subida = './assets/files/';
								$fichero_subido = $dir_subida . basename($nuevoNombre);
								
								if (move_uploaded_file($_FILES['inputAdjunto'.$i]['tmp_name'], $fichero_subido)) {
									$archivo = $this->upload->data();
									$tmp = explode(".", $archivo['file_ext']);
									$extension = end($tmp);

									//mysqli_next_result($this->db->conn_id);
									$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", "null", $idConvenio, $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);
									mysqli_next_result($this->db->conn_id);

									if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
										$cantConveniosArchivos++;
								}else{
									$error = $this->upload->display_errors();
									$datos['error'] = $error;
									$datos['mensaje'] = 'Se ha producido un error al guardar el adjunto.';
									$datos['resultado'] = 0;
								}

								/*if(!$this->upload->do_upload('inputAdjunto'.$i))
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

									//mysqli_next_result($this->db->conn_id);
									$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", "null", $idConvenio, $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);
									mysqli_next_result($this->db->conn_id);

									if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
										$cantConveniosArchivos++;
								}*/
							}
						}
					}
				}

				$datos['mensaje'] = 'Se ha agregado exitosamente los Convenios, Cant. Convenios: '.$cantConvenios.' Cant. Adjuntos: '.$cantConveniosArchivos;
				$datos['resultado'] = 1;
			}else{
				$datos['mensaje'] = 'No se ha envaido un Convenio para agregar.';
				$datos['resultado'] = -1;
			}
			echo json_encode($datos);
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarComunasHospitalesMarco()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			$subtitulo = "null";
			$institucion = "null";

			if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "")
				$subtitulo = $this->input->post('subtitulo');

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1" && $this->input->post('institucion') != "")
				$institucion = $this->input->post('institucion');

			if($subtitulo == "3" || $subtitulo == "5" || $subtitulo == "6")
			{
				$datos['hospitales'] = $this->hospital_model->listarHospitalesUsuAPS($usuario["id_usuario"], $institucion);
			}else{
				if ($subtitulo == "4") {
					$datos['comunas'] = $this->programa_model->listarComunasInstitucion($usuario["id_usuario"], $institucion, "null");
				}				
			}
			$datos['datos'] = $subtitulo.' - '.$institucion;
			echo json_encode($datos);
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

			if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1"  && $this->input->post('institucion') != "")
				$idInstitucion = $this->input->post('institucion');

			//var_dump($idInstitucion);

			//$marcos = $this->programa_model->listarMarcos($idInstitucion, "null", "null", $usuario["id_usuario"]);			

			mysqli_next_result($this->db->conn_id);
			$comunas = $this->programa_model->listarComunasMarco($idInstitucion, "null", $usuario["id_usuario"]);
			//var_dump($idInstitucion);
			/*$table_marcos ='
			<table id="tListaMarcosUsuario" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="text0o-pequenio text-center align-middle registro">#</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Establecimiento</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
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
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['programa'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['codigo_cuenta'].' '.$marco['cuenta'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['codigo_institucion'].' '.$marco['institucion'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['codigo_hospital'].' '.$marco['hospital'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['comuna'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['fecha'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p></td>
					        <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['marco'], 0, ",", ".").'</p></td>
					         <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p></td>
					        <td class="text-center align-middle registro botonTabla paginate_button">';
					        if(strlen(trim($marco['ruta_archivo'])) > 1) {
								$table_marcos .= '<a id="view_'.$marco['id_grupo_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
						        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
					        		</a>';
					        }
				        	$table_marcos .= '</td>
				        	<td class="text-center align-middle registro botonTabla paginate_button">
			        			<button href="#" aria-controls="tListaMarcosUsuario" data-id="'.$marco['id_marco'].'" data-programa="'.$marco['programa'].'" data-marco="'.$marco['marco'].'" data-restante="'.$marco['dif_rest'].'" data-codigo_cuenta="'.$marco['codigo_cuenta'].'" data-nombre_cuenta="'.$marco['cuenta'].'" data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-hospital="'.$marco['codigo_hospital'].' '.$marco['hospital'].'" data-comuna="'.$marco['comuna'].'" data-id_institucion="'.$marco['id_institucion'].'" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>
			        		</td>
				    	</tr>';
					
				}
			}*//*else
			{
				$table_marcos .= '<tr>
						<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
					  </tr>';
			}

	        $table_marcos .='
	        	</tbody>
	        </table>';

			$datos = array('table_marcos' => $table_marcos, 'comunas' =>$comunas);
	        echo json_encode($datos);*/
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
			#$marcos = $this->programa_model->listarMarcosUsuario("null", "null", "null", $usuario["id_usuario"]);
			#$usuario['marcos'] = $marcos;

			$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
			$usuario['periodos'] = $periodos;
			$anioSeleccionado = "NULL";
			if (isset($periodos) && sizeof($periodos) > 0){
				if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
					$anioSeleccionado = $usuario["anio_seleccionado"];
					$usuario['anioSeleccionado'] = $anioSeleccionado;
				}else{
					$anioSeleccionado = $periodos[0]["anio"];
					$usuario['anioSeleccionado'] = $periodos[0]["anio"];
					$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
				}
			}

			#mysqli_next_result($this->db->conn_id);
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

	public function asignarConveniosSinDistribucion()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			#$marcos = $this->programa_model->listarMarcosUsuario("null", "null", "null", $usuario["id_usuario"]);
			#$usuario['marcos'] = $marcos;

			$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
			$usuario['periodos'] = $periodos;
			$anioSeleccionado = "NULL";
			if (isset($periodos) && sizeof($periodos) > 0){
				if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
					$anioSeleccionado = $usuario["anio_seleccionado"];
					$usuario['anioSeleccionado'] = $anioSeleccionado;
				}else{
					$anioSeleccionado = $periodos[0]["anio"];
					$usuario['anioSeleccionado'] = $periodos[0]["anio"];
					$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
				}
			}

			#mysqli_next_result($this->db->conn_id);
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
			$this->load->view('asignarConveniosSinDistribucion', $usuario);
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
			$convenio = "null";
			$fecha = "null";
			$archivoConvenio = "null";
			$numResolucion = "null";
			$extension = "null";
			$peso = "null";


			if(!is_null($this->input->post('idMarco')) && $this->input->post('idMarco') != "-1")
				$idMarco = $this->input->post('idMarco');

			if(!is_null($this->input->post('inputConvenio')) && $this->input->post('inputConvenio') != "-1")
				$convenio = $this->input->post('inputConvenio');

			if(!is_null($this->input->post('inputResolucion')) && $this->input->post('inputResolucion') != "-1")
				$numResolucion = $this->input->post('inputResolucion');

			if(!is_null($this->input->post('inputFecha')) && $this->input->post('inputFecha') != "-1")
				$fecha = $this->input->post('inputFecha');
			//if(!is_null($this->input->post('archivoConvenio')) && $this->input->post('archivoConvenio') != "-1")
				//$archivoConvenio = $this->input->post('archivoConvenio');
			//var_dump($archivoConvenio);
			//var_dump($_FILES);
			$resultado = $this->programa_model->agregarConvenio("null", $numResolucion, $fecha, $idMarco, $convenio, $usuario['id_usuario']);
			//var_dump($resultado);
			if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['idConvenio']))
			{
				$idConvenio = $resultado[0]['idConvenio'];
				$cantArchivos = $resultado[0]['cant_archivos'];
				$idPresupuesto = $resultado[0]['idPresupuesto'];
				/*$email = $resultado[0]['email'];
				$institucion = $resultado[0]['institucion'];
				$perfil = $resultado[0]['perfil'];
				$nombres = $resultado[0]['nombres'];
				$apellidos = $resultado[0]['apellidos'];

				$mensaje = 'Estimado, usted tiene una nueva solicitud de convenio N°: '.$idConvenio.' de '.$nombres.' '.$apellidos.' '.$perfil.' de la Institucion '.$institucion.', puede contactarlo al email: '.$email.'.';

				$asunto = 'Solicitud de Convenio N°: '.$idConvenio;
				$email_destino = 'jchacon@zenweb.cl';


				$se_envio = $this->enviar($email_destino, $mensaje, $asunto, null);

				*/


				if($_FILES["archivoConvenio"]["name"] != "")
				{
					$nombreOriginal = $_FILES["archivoConvenio"]["name"];
					$temp = explode(".", $_FILES["archivoConvenio"]["name"]);
					$nuevoNombre =  $idPresupuesto.'_'.$idMarco.'_'.$idConvenio. '_' .($cantArchivos + 1). '.' . end($temp);
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
						$archivoAgregado = $this->programa_model->agregarArchivo("null", "null", "null", $idConvenio, $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

						if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
						{
							$datos['mensaje'] = 'Se ha agregado exitosamente el Convenio. Se ha importado exitosamente el adjunto.';
							$datos['resultado'] = 1;
							$datos['idConvenio'] = $idConvenio;
						}
					}
				}else{
					$datos['mensaje'] = 'Se ha agregado exitosamente el Convenio.';
					$datos['resultado'] = 1;
					$datos['idConvenio'] = $idConvenio;
				}
			}

			echo json_encode($datos);
		}
		else
		{
			redirect('Login');
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

	public function listarMarcos()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$idInstitucion = "null";
				if(!is_null($this->input->POST('idInstitucion')) && $this->input->post('idInstitucion') != "-1" && $this->input->post('idInstitucion') != "")
					$idInstitucion = $this->input->POST('idInstitucion');

				$idPresupuesto = "null";
				if(!is_null($this->input->POST('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1" && $this->input->post('idPresupuesto') != "")
					$idPresupuesto = $this->input->POST('idPresupuesto');

				$idPrograma = "null";
				if(!is_null($this->input->POST('idPrograma')) && $this->input->post('idPrograma') != "-1" && $this->input->post('idPrograma') != "")
					$idPrograma = $this->input->POST('idPrograma');

				/*$marcos = $this->programa_model->listarMarcosUsuario($idInstitucion, $idPresupuesto, $idPrograma, $usuario["id_usuario"]);

				$table_marcos ='
				<table id="tListaMarcos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
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
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['id_grupo_marco'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['programa'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['codigo_cuenta'].' '.$marco['cuenta'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['codigo_institucion'].' '.$marco['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['fecha'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['marco_presupuesto'], 0, ",", ".").'</p></td>
						         <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">';
						        if(strlen(trim($marco['ruta_archivo'])) > 1) {
									$table_marcos .= '<a id="view_'.$marco['id_grupo_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>';
						        }
					        	$table_marcos .= '</td>
					        	 <td class="text-center align-middle registro botonTabla">
					        	 	<a id="edit_'.$marco['id_grupo_marco'].'" class="edit" type="link" href="ModificarMarco/?idMarco='.$marco['id_grupo_marco'].'" data-id="'.$marco['id_grupo_marco'].'" data-programa="'.$marco['programa'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
						        	<a id="trash_'.$marco['id_grupo_marco'].'" class="trash" href="#" data-id="'.$marco['id_grupo_marco'].'"  data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-programa="'.$marco['programa'].'" data-toggle="modal" data-target="#modalEliminarMarco">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}*//*else
				{
					$table_marcos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}*/

		        /*$table_marcos .='
		        	</tbody>
		        </table>';

				$datos = array('table_marcos' =>$table_marcos);
		        echo json_encode($datos);*/
			}else{


				$programas = $this->programa_model->listarProgramas();
				$usuario['programas'] = $programas;
				

				mysqli_next_result($this->db->conn_id);
				$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
				$usuario['periodos'] = $periodos;
				$anioSeleccionado = "NULL";
				if (isset($periodos) && sizeof($periodos) > 0){
					if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
						$anioSeleccionado = $usuario["anio_seleccionado"];
						$usuario['anioSeleccionado'] = $anioSeleccionado;
					}else{
						$anioSeleccionado = $periodos[0]["anio"];
						$usuario['anioSeleccionado'] = $periodos[0]["anio"];
						$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
					}
				}

				#mysqli_next_result($this->db->conn_id);
				$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
				if($instituciones)
					$usuario["instituciones"] = $instituciones;


				mysqli_next_result($this->db->conn_id);
				$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
				if($cuentas)
					$usuario["cuentas"] = $cuentas;

				/*mysqli_next_result($this->db->conn_id);
				$marcos = $this->programa_model->listarMarcosUsuario("null", "null", "null", 1, 20, "null", $usuario["id_usuario"]);
				if($marcos)
					$usuario['marcos'] = $marcos;*/

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

	public function json_listarMarcos()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){

			$origen = "";

			$anio = "null";
			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1" && $this->input->post('anio') != ""){
				$anio = $this->input->post('anio');
				$this->session->set_userdata('anio_seleccionado', $anio);
			}
			
			if(!is_null($this->input->post('origen')) && $this->input->post('origen') != "" && $this->input->post('origen') == "asignarConvenios")
				$origen = $this->input->post('origen');

			$idInstitucion = "null";
			if(!is_null($this->input->post('idInstitucion')) && $this->input->post('idInstitucion') != "-1" && $this->input->post('idInstitucion') != "")
				$idInstitucion = $this->input->post('idInstitucion');

			$idPresupuesto = "null";
			if(!is_null($this->input->POST('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1" && $this->input->post('idPresupuesto') != "")
				$idPresupuesto = $this->input->POST('idPresupuesto');

			$idPrograma = "null";
			if(!is_null($this->input->POST('idPrograma')) && $this->input->post('idPrograma') != "-1" && $this->input->post('idPrograma') != "")
				$idPrograma = $this->input->POST('idPrograma');

			$filtro = "null";
			if (strlen(trim($this->input->post('search')['value'])) > 0) {
				$filtro = trim($this->input->post('search')['value']);
			}

			$pagina = round(($this->input->post('start') == 0 ? 1 : (($this->input->post('start') + $this->input->post('length')) / $this->input->post('length'))));
			
			$inicio = 0;
			if ($this->input->post('start') > 0 )
				$inicio = $this->input->post('start');

			$largo = 10;
			if ($this->input->post('length') > 0 )
				$largo = $this->input->post('length');

			//mysqli_next_result($this->db->conn_id);
			$marcos = $this->programa_model->listarMarcosUsuario($idInstitucion, $idPresupuesto, $anio, $idPrograma, $inicio,
			$largo , $filtro, $usuario["id_usuario"]);

			mysqli_next_result($this->db->conn_id);
			$cant = $this->programa_model->listarCantMarcosUsuario($idInstitucion, $idPresupuesto, $anio, $idPrograma, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$cant_filtro = $this->programa_model->cantMarcosUsuarioFiltro($idInstitucion, $idPresupuesto, $anio, $idPrograma, $filtro, $usuario["id_usuario"]);
			if($cant_filtro)
				$cant_filtro = $cant_filtro[0]['cantidad'];		

			$tabla = array();
			$no = $this->input->get('start');
			if ($marcos) {
				foreach ($marcos as $marco) {
					$row = array();

					$row[] = '<p class="texto-pequenio">'.$marco['id_grupo_marco'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['programa'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_cuenta'].' '.$marco['cuenta'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_institucion'].' '.$marco['institucion'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['fecha'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['marco_presupuesto'], 0, ",", ".").'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p>';

					if(strlen(trim($marco['ruta_archivo'])) > 1) { 
			        	$row[] = '<a id="view_'.$marco['id_grupo_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
			        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
		        		</a>';
					}else{
						$row[] = '';
					}

					if ($origen == "asignarConvenios") {
						$row[] = '
						<button href="#" aria-controls="tListaMarcosUsuario" data-id="'.$marco['id_grupo_marco'].'" data-programa="'.$marco['programa'].'" data-marco="'.$marco['marco_presupuesto'].'" data-restante="'.$marco['dif_rest'].'" data-codigo_cuenta="'.$marco['codigo_cuenta'].'" data-nombre_cuenta="'.$marco['cuenta'].'" data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-hospital="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-comuna="'.$marco['institucion'].'" data-id_institucion="'.$marco['id_institucion'].'" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>';
					}else{
						$row[] = '<a id="edit_'.$marco['id_grupo_marco'].'" class="edit" type="link" href="ModificarMarco/?idMarco='.$marco['id_grupo_marco'].'" data-id="'.$marco['id_grupo_marco'].'" data-programa="'.$marco['programa'].'">
			        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
		        		</a>
			        	<a id="trash_'.$marco['id_grupo_marco'].'" class="trash" href="#" data-id="'.$marco['id_grupo_marco'].'"  data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-programa="'.$marco['programa'].'" data-toggle="modal" data-target="#modalEliminarMarco">
			        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>
		        		</a>';
					}
					$tabla[] = $row;
				}
			}
			
			$output = array(
				'draw' => $this->input->post('draw'),
				"pagina" => $pagina,
				"length" => 20,
				'recordsTotal' => (int)$cant,
				'recordsFiltered' => $cant_filtro,
				'data' => $tabla
			);
			echo json_encode($output);
		}else
		{
			redirect('Inicio');
		}
	}

	public function json_listarMarcosUsuario()
	{	
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){

			$anio = "null";

			//$id_presupuesto = $this->input->post('idPresupuesto');

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "" && $this->input->post('anio') != "-1"){
				$anio = $this->input->post('anio');
				$this->session->set_userdata('anio_seleccionado', $anio);
			}

			$origen = "";
			
			if(!is_null($this->input->post('origen')) && $this->input->post('origen') != "" && $this->input->post('origen') == "asignarConvenios")
				$origen = $this->input->post('origen');

			$idInstitucion = "null";
			if(!is_null($this->input->post('idInstitucion')) && $this->input->post('idInstitucion') != "-1" && $this->input->post('idInstitucion') != "")
				$idInstitucion = $this->input->post('idInstitucion');

			$idPresupuesto = "null";
			if(!is_null($this->input->POST('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1" && $this->input->post('idPresupuesto') != "")
				$idPresupuesto = $this->input->POST('idPresupuesto');

			$idPrograma = "null";
			if(!is_null($this->input->POST('idPrograma')) && $this->input->post('idPrograma') != "-1" && $this->input->post('idPrograma') != "")
				$idPrograma = $this->input->POST('idPrograma');

			$filtro = "null";
			if (strlen(trim($this->input->post('search')['value'])) > 0) {
				$filtro = trim($this->input->post('search')['value']);
			}

			$pagina = round(($this->input->post('start') == 0 ? 1 : (($this->input->post('start') + $this->input->post('length')) / $this->input->post('length'))));
			
			$inicio = 0;
			if ($this->input->post('start') > 0 )
				$inicio = $this->input->post('start');

			$largo = 10;
			if ($this->input->post('length') > 0 )
				$largo = $this->input->post('length');


			//mysqli_next_result($this->db->conn_id);
			$marcos = $this->programa_model->listarMarcos($idInstitucion, $idPresupuesto, $anio, $idPrograma, $inicio,
			$largo , $filtro, $usuario["id_usuario"]);

			mysqli_next_result($this->db->conn_id);
			$cant = $this->programa_model->cantlistarMarcos($idInstitucion, $idPresupuesto, $anio, $idPrograma, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$cant_filtro = $this->programa_model->cantlistarMarcosFiltro($idInstitucion, $idPresupuesto, $anio, $idPrograma, $filtro, $usuario["id_usuario"]);
			if($cant_filtro)
				$cant_filtro = $cant_filtro[0]['cantidad'];		

			$tabla = array();
			$no = $this->input->get('start');
			if ($marcos) {
				foreach ($marcos as $marco) {
					$row = array();
					$row[] = '<p class="texto-pequenio">'.$marco['id_marco'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['programa'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_cuenta'].' '.$marco['cuenta'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_institucion'].' '.$marco['institucion'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['comuna'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['hospital'].'</p>';
					$row[] = '<p class="texto-pequenio">'.DateTime::createFromFormat('Y-m-d H:i:s', $marco['fecha'])->format('Y-m-d H:i:s').'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['marco'], 0, ",", ".").'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p>';

					if(strlen(trim($marco['ruta_archivo'])) > 1) { 
			        	$row[] = '<a id="view_'.$marco['id_grupo_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
			        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
		        		</a>';
					}else{
						$row[] = '';
					}
					$row[] = '
					<button href="#" aria-controls="tListaMarcosUsuario" data-id="'.$marco['id_marco'].'" data-programa="'.$marco['programa'].'" data-marco="'.$marco['marco'].'" data-restante="'.$marco['dif_rest'].'" data-codigo_cuenta="'.$marco['codigo_cuenta'].'" data-nombre_cuenta="'.$marco['cuenta'].'" data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-hospital="'.$marco['hospital'].' '.$marco['institucion'].'" data-comuna="'.$marco['comuna'].'" data-id_institucion="'.$marco['id_institucion'].'" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>';
					$tabla[] = $row;
				}
			}
			
			$output = array(
				'draw' => $this->input->post('draw'),
				"pagina" => $pagina,
				"length" => 20,
				'recordsTotal' => (int)$cant,
				'recordsFiltered' => $cant_filtro,
				'data' => $tabla
			);
			echo json_encode($output);
		}else
		{
			redirect('Inicio');
		}
	}

	public function json_listarMarcosUsuarioD()
	{	
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){

			$origen = "";
			$anio = "";

			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "" && $this->input->post('anio') != "-1"){
				$anio = $this->input->post('anio');
				$this->session->set_userdata('anio_seleccionado', $anio);
			}
			
			if(!is_null($this->input->post('origen')) && $this->input->post('origen') != "" && $this->input->post('origen') == "asignarConveniosD")
				$origen = $this->input->post('origen');

			$idInstitucion = "null";
			if(!is_null($this->input->post('idInstitucion')) && $this->input->post('idInstitucion') != "-1" && $this->input->post('idInstitucion') != "")
				$idInstitucion = $this->input->post('idInstitucion');

			$idPresupuesto = "null";
			if(!is_null($this->input->POST('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1" && $this->input->post('idPresupuesto') != "")
				$idPresupuesto = $this->input->POST('idPresupuesto');

			$idPrograma = "null";
			if(!is_null($this->input->POST('idPrograma')) && $this->input->post('idPrograma') != "-1" && $this->input->post('idPrograma') != "")
				$idPrograma = $this->input->POST('idPrograma');

			$filtro = "null";
			if (strlen(trim($this->input->post('search')['value'])) > 0) {
				$filtro = trim($this->input->post('search')['value']);
			}

			$pagina = round(($this->input->post('start') == 0 ? 1 : (($this->input->post('start') + $this->input->post('length')) / $this->input->post('length'))));
			
			$inicio = 0;
			if ($this->input->post('start') > 0 )
				$inicio = $this->input->post('start');

			$largo = 10;
			if ($this->input->post('length') > 0 )
				$largo = $this->input->post('length');


			//mysqli_next_result($this->db->conn_id);
			$marcos = $this->programa_model->listarMarcosSinDistribucion($idInstitucion, $anio, $idPrograma, $inicio,
			$largo , $filtro, $usuario["id_usuario"]);

			mysqli_next_result($this->db->conn_id);
			$cant = $this->programa_model->cantlistarMarcosSD($idInstitucion, $anio, $idPrograma, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$cant_filtro = $this->programa_model->cantlistarMarcosSDF($idInstitucion, $anio, $idPrograma, $filtro, $usuario["id_usuario"]);
			if($cant_filtro)
				$cant_filtro = $cant_filtro[0]['cantidad'];		

			$tabla = array();
			$no = $this->input->get('start');
			if ($marcos) {
				foreach ($marcos as $marco) {
					$row = array();
					$row[] = '<p class="texto-pequenio">'.$marco['id_grupo_marco'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['programa'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_cuenta'].' '.$marco['cuenta'].'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['codigo_institucion'].' '.$marco['institucion'].'</p>';
					$row[] = '<p class="texto-pequenio">'.DateTime::createFromFormat('Y-m-d H:i:s', $marco['fecha'])->format('d-m-Y H:i:s').'</p>';
					$row[] = '<p class="texto-pequenio">'.$marco['u_nombres'].' '.$marco['u_apellidos'].'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['marco'], 0, ",", ".").'</p>';
					$row[] = '<p class="texto-pequenio">'.number_format($marco['dif_rest'], 0, ",", ".").'</p>';

					if(strlen(trim($marco['ruta_archivo'])) > 1) { 
			        	$row[] = '<a id="view_'.$marco['id_grupo_marco'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$marco['ruta_archivo'].'">
			        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
		        		</a>';
					}else{
						$row[] = '';
					}
					$row[] = '
					<button href="#" aria-controls="tListaMarcosUsuario" data-id="'.$marco['id_grupo_marco'].'" data-programa="'.$marco['programa'].'" data-marco="'.$marco['marco'].'" data-restante="'.$marco['dif_rest'].'" data-id_cuenta="'.$marco['id_cuenta'].'" data-codigo_cuenta="'.$marco['codigo_cuenta'].'" data-nombre_cuenta="'.$marco['cuenta'].'" data-institucion="'.$marco['codigo_institucion'].' '.$marco['institucion'].'" data-id_institucion="'.$marco['id_institucion'].'" tabindex="0" class="btn btn-outline-dark seleccionMarcoD">Seleccionar</button>';
					$tabla[] = $row;
				}
			}
			
			$output = array(
				'draw' => $this->input->post('draw'),
				"pagina" => $pagina,
				"length" => 20,
				'recordsTotal' => (int)$cant,
				'recordsFiltered' => $cant_filtro,
				'data' => $tabla
			);
			echo json_encode($output);
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarConvenios()
	{
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario')){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$idInstitucion = "null";
				$idPrograma = "null";
				$idEstado = "null";

				if(!is_null($this->input->post('institucion')) && $this->input->post('institucion') != "-1"  && $this->input->post('institucion') != "")
					$idInstitucion = $this->input->post('institucion');

				if(!is_null($this->input->post('programa')) && $this->input->post('programa') != "-1"  && $this->input->post('programa') != "")
					$idPrograma = $this->input->post('programa');

				if(!is_null($this->input->post('estado')) && $this->input->post('estado') != "-1"  && $this->input->post('estado') != "")
					$idEstado = $this->input->post('estado');

				/*$convenios = $this->programa_model->listarConvenios($idInstitucion, $idPrograma, "null", $idEstado, $usuario["id_usuario"]);

				$table_convenios ='
				<table id="tListaConvenios" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
							<th scope="col" class="texto-pequenio text-center align-middle registro">N° de Resoluci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Establecimiento</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Estado</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro">Adjunto</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro">Revisar</th>';
					    	if (sizeof($convenios) > 0 && $convenios[0]['eliminar'] == "1") {
					    		$table_convenios .='<th scope="col" class="texto-pequenio text-center align-middle registro"></th>';
					    	}
						$table_convenios .='</tr>
					</thead>
					<tbody id="tbodyConvenios">';

		        if(isset($convenios) && sizeof($convenios) > 0)
				{								
					foreach ($convenios as $convenio) {
						$table_convenios .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['id_convenio'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['codigo'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['codigo_hospital'].' '.$convenio['hospital'].'</td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['comuna'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['programa'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['fecha'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.number_format($convenio['convenio'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro">'.($convenio['id_estado_convenio'] == '1' ? '<span class="badge badge-pill badge-success">Aprobado</span>' : (($convenio['id_estado_convenio'] == '3' ? '<span class="badge badge-pill badge-danger">Rechazado</span>' : '<span class="badge badge-pill badge-warning">Pendiente de Aprobacion</span>'))).'</td>
						        <td class="text-center align-middle registro botonTabla paginate_button">';

						        if(strlen(trim($convenio['ruta_archivo'])) > 1) {
									$table_convenios .= '<a id="view_'.$convenio['id_convenio'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$convenio['ruta_archivo'].'">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>';
						        }
					        	$table_convenios .= '</td>
					        	<td class="text-center align-middle registro botonTabla">
						        	<a id="view_'.$convenio['id_convenio'].'" class="view_convenio" href="#" data-id="'.$convenio['id_convenio'].'" data-hospital="'.$convenio['codigo_hospital'].' '.$convenio['hospital'].'" data-comuna="'.$convenio['comuna'].'" data-codigo="'.$convenio['codigo'].'" data-programa="'.$convenio['programa'].'" data-institucion="'.$convenio['codigo_institucion'].' '.$convenio['institucion'].'" data-fecha="'.$convenio['fecha'].'" data-usuario="'.$convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio'].'" data-marco="'.$convenio['marco'].'" data-marco_disponible="'.$convenio['dif_rest'].'" data-convenio="'.$convenio['convenio'].'" data-marco_restante="'.$convenio['dif_convenio'].'" data-pdf="'.base_url().'assets/files/'.$convenio['ruta_archivo'].'" data-nombre_archivo="'.$convenio['nombre_archivo'].'" data-fecha_revision="'.$convenio['fecha_revision'].'" data-observacion_revision="'.$convenio['observacion_revision'].'" data-id_estado_revision="'.$convenio['id_estado_convenio'].'" data-usuario_revision="'.$convenio['nombres_usu_revision'].' '.$convenio['apellidos_usu_revision'].'">
						        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
					        		</a>
					        	</td>';
					    	if (sizeof($convenios) > 0 && $convenios[0]['eliminar'] == "1") {
					        	 $table_convenios .='<td class="text-center align-middle registro botonTabla">
						        	<a id="trash_'.$convenio['id_convenio'].'" class="trash" href="#" data-id="'.$convenio['id_convenio'].'" data-comuna="'.$convenio['comuna'].'" data-toggle="modal" data-target="#modalEliminarConvenio">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
					        		</a>
					        	</td>';
					    	}
					    	$table_convenios .= '</tr>';
						
					}
				}
		        $table_convenios .='
		        	</tbody>
		        </table>';

				$datos = array('table_convenios' =>$table_convenios);
		        echo json_encode($datos);*/
			}else{
				$id_institucion_seleccionado = "null";
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				
				

				if($datos_usuario[0]["pf_analista"] == "0")
				{
					mysqli_next_result($this->db->conn_id);
					$instituciones =  $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
					$usuario["instituciones"] = $instituciones;
					//$usuario["idInstitucion"] = $instituciones[0]["id_institucion"];
					//$id_institucion_seleccionado = $instituciones[0]["id_institucion"];
				}

				mysqli_next_result($this->db->conn_id);
				$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
				$usuario['periodos'] = $periodos;
				$anioSeleccionado = "NULL";
				if (isset($periodos) && sizeof($periodos) > 0){
					if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
						$anioSeleccionado = $usuario["anio_seleccionado"];
						$usuario['anioSeleccionado'] = $anioSeleccionado;
					}else{
						$anioSeleccionado = $periodos[0]["anio"];
						$usuario['anioSeleccionado'] = $periodos[0]["anio"];
						$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
					}
				}

				#$id_institucion_seleccionado = "null";
				/*mysqli_next_result($this->db->conn_id);
				$convenios = $this->programa_model->listarConvenios($id_institucion_seleccionado, "null", "null", 1, $usuario["id_usuario"]);
				if($convenios)
					$usuario['convenios'] = $convenios;*/

				#mysqli_next_result($this->db->conn_id);
				$programas = $this->programa_model->listarProgramas();
				$usuario['programas'] = $programas;

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

	public function json_listarConvenios()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){

			$origen = "";

			$anio = "null";
			if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1" && $this->input->post('anio') != ""){
				$anio = $this->input->post('anio');
				$this->session->set_userdata('anio_seleccionado', $anio);
			}
			
			if(!is_null($this->input->post('origen')) && $this->input->post('origen') != "" && $this->input->post('origen') == "asignarConvenios")
				$origen = $this->input->post('origen');

			$idInstitucion = "null";
			if(!is_null($this->input->post('idInstitucion')) && $this->input->post('idInstitucion') != "-1" && $this->input->post('idInstitucion') != "")
				$idInstitucion = $this->input->post('idInstitucion');

			$idPresupuesto = "null";
			if(!is_null($this->input->POST('idPresupuesto')) && $this->input->post('idPresupuesto') != "-1" && $this->input->post('idPresupuesto') != "")
				$idPresupuesto = $this->input->POST('idPresupuesto');

			$idPrograma = "null";
			if(!is_null($this->input->POST('idPrograma')) && $this->input->post('idPrograma') != "-1" && $this->input->post('idPrograma') != "")
				$idPrograma = $this->input->POST('idPrograma');

			$fechaResolucion = "null";
			if(!is_null($this->input->POST('fechaResolucion')) && $this->input->post('fechaResolucion') != "-1" && $this->input->post('fechaResolucion') != "")
				$fechaResolucion = $this->input->POST('fechaResolucion');

			$fechaDesde = "null";
			if(!is_null($this->input->POST('fechaDesde')) && $this->input->post('fechaDesde') != "-1" && $this->input->post('fechaDesde') != "")
				$fechaDesde = $this->input->POST('fechaDesde');

			$fechaHasta = "null";
			if(!is_null($this->input->POST('fechaHasta')) && $this->input->post('fechaHasta') != "-1" && $this->input->post('fechaHasta') != "")
				$fechaHasta = $this->input->POST('fechaHasta');

			$idEstado = "null";
			if(!is_null($this->input->post('idEstado')) && $this->input->post('idEstado') != "-1"  && $this->input->post('idEstado') != "")
					$idEstado = $this->input->post('idEstado');

			$filtro = "null";
			if (strlen(trim($this->input->post('search')['value'])) > 0) {
				$filtro = trim($this->input->post('search')['value']);
			}

			$pagina = round(($this->input->post('start') == 0 ? 1 : (($this->input->post('start') + $this->input->post('length')) / $this->input->post('length'))));
			
			$inicio = 0;
			if ($this->input->post('start') > 0 )
				$inicio = $this->input->post('start');

			$largo = 10;
			if ($this->input->post('length') > 0 )
				$largo = $this->input->post('length');

			$convenios = $this->programa_model->listarConvenios($idInstitucion, $anio, $idPrograma, "null", $idEstado,  $fechaResolucion, $fechaDesde, $fechaHasta, $inicio,
			$largo , $filtro, $usuario["id_usuario"]);
			
			mysqli_next_result($this->db->conn_id);
			$cant = $this->programa_model->cantlistarConvenios($idInstitucion, $anio, $idPrograma, "null", $idEstado,  $fechaResolucion, $fechaDesde, $fechaHasta, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$cant_filtro = $this->programa_model->cantConvenioUsuarioFiltro($idInstitucion, $anio, $idPrograma, "null", $idEstado, $fechaResolucion, $fechaDesde, $fechaHasta, $filtro, $usuario["id_usuario"]);
			if($cant_filtro)
				$cant_filtro = $cant_filtro[0]['cantidad'];		

			$tabla = array();
			$no = $this->input->get('start');
			if ($convenios) {
				foreach ($convenios as $convenio) {
					$row = array();
					$row[] = '<p class="texto-pequenio">'.$convenio['id_convenio'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['institucion'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['codigo_hospital'].' '.$convenio['hospital'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['comuna'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['programa'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['codigo_cuenta'].' '.$convenio['cuenta'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['fecha'].'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio'].'</p>';
			        $row[] = '<p class="texto-pequenio">$ '.number_format($convenio['asignacion'], 0, ",", ".").'</p>';
			        $row[] = '<p class="texto-pequenio">$ '.number_format($convenio['convenio'], 0, ",", ".").'</p>';
			        $row[] = '<p class="texto-pequenio">'.$convenio['codigo'].'</p>';
			    	$row[] = '<p class="texto-pequenio">'.$convenio['fecha_resolucion'].'</p>';
			    	$row[] = ($convenio['id_estado_convenio'] == "1" ? '<span class="badge badge-pill badge-success">Aprobado</span>' : (($convenio['id_estado_convenio'] == "2" ? '<span class="badge badge-pill badge-danger">Rechazado</span>' : '<span class="badge badge-pill badge-warning">Pendiente de Aprobacion</span>')));
			        if(strlen(trim($convenio['ruta_archivo'])) > 1) {
				        $row[] = '<a id="view_'.$convenio['id_convenio'].'" class="view pdfMarco" href="#"  data-pdf="'.base_url().'assets/files/'.$convenio['ruta_archivo'].'">
				        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
			        		</a>';
			        }else{
			        	$row[] = '';
			        }
		        	$row[] = '<a id="view_'.$convenio['id_convenio'].'" class="view_convenio" href="#" data-id="'.$convenio['id_convenio'].'" data-hospital="'.$convenio['codigo_hospital'].' '.$convenio['hospital'].'" data-comuna="'.$convenio['comuna'].'" data-codigo="'.$convenio['codigo'].'" data-programa="'.$convenio['programa'].'" data-subtitulo="'.$convenio['codigo_cuenta'].' '.$convenio['cuenta'].'" data-institucion="'.$convenio['codigo_institucion'].' '.$convenio['institucion'].'" data-fecha="'.$convenio['fecha'].'" data-usuario="'.$convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio'].'" data-marco="'.$convenio['marco'].'" data-marco_disponible="'.$convenio['dif_rest'].'" data-convenio="'.$convenio['convenio'].'" data-marco_restante="'.$convenio['dif_convenio'].'" data-pdf="'.base_url().'assets/files/'.$convenio['ruta_archivo'].'" data-nombre_archivo="'.$convenio['nombre_archivo'].'" data-fecha_revision="'.$convenio['fecha_revision'].'" data-observacion_revision="'.$convenio['observacion_revision'].'" data-id_estado_revision="'.$convenio['id_estado_convenio'].'" data-usuario_revision="'.$convenio['nombres_usu_revision'].' '.$convenio['apellidos_usu_revision'].'"  data-fecha_resolucion="'.$convenio['fecha_resolucion'].'">
			        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
		        		</a>';
		        	
		        	if (sizeof($convenios) > 0 && $convenios[0]['eliminar'] == "1") { 
			        	$row[] = '<a id="trash_'.$convenio['id_convenio'].'" class="trash" href="#" data-id="'.$convenio['id_convenio'].'" data-comuna="'.$convenio['comuna'].'" data-toggle="modal" data-target="#modalEliminarConvenio">
			        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
		        		</a>';
		        	}else
		        	{
		        		$row[] = '';
		        	}
					$tabla[] = $row;
				}
			}
			
			$output = array(
				'draw' => $this->input->post('draw'),
				"pagina" => $pagina,
				"length" => 20,
				'recordsTotal' => (int)$cant,
				'recordsFiltered' => $cant_filtro,
				'data' => $tabla
			);
			echo json_encode($output);
		}else
		{
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

	public function eliminarConvenioVariante()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idConvenio = null;
			if($this->input->POST('idConvenio'))
				$idConvenio = $this->input->POST('idConvenio');
			$resultado = $this->programa_model->eliminarConvenioVariante($idConvenio, $usuario['id_usuario']);
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
			$marcos = $this->programa_model->listarMarcosUsuario("null", "null", "null", $usuario["id_usuario"]);
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

	public function asignarPresupuesto()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){

			$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
			$usuario['periodos'] = $periodos;
			$anioSeleccionado = "NULL";
			if (isset($periodos) && sizeof($periodos) > 0){
				if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
					$anioSeleccionado = $usuario["anio_seleccionado"];
					$usuario['anioSeleccionado'] = $anioSeleccionado;
				}else{
					$anioSeleccionado = $periodos[0]["anio"];
					$usuario['anioSeleccionado'] = $periodos[0]["anio"];
					$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
				}
			}
			
			if (isset($periodos) && sizeof($periodos) > 0){
				if (isset($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0){
					$anioSeleccionado = $usuario["anio_seleccionado"];
					$usuario['anioSeleccionado'] = $usuario["anio_seleccionado"];
				}
				
			}

			#var_dump($usuario);
			#mysqli_next_result($this->db->conn_id);
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
			$this->load->view('asignarPresupuesto', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function agregarPresupuesto()
	{	
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{	
			$programa = "null";
			$subtitulo = "null";
			$presupuesto = "0";
			$presupuesto6 = "0";
			$presupuesto3 = "0";
			$presupuesto4 = "0";
			$presupuesto5 = "0";
			$nombre = "null";
			$extension = "null";
			$peso = "null";
			$primero = false;
			$id_presupuesto = "null";
			$anio = "null";

			//$id_presupuesto = $this->input->post('idPresupuesto');

			if(!is_null($this->input->post('periodo')) && $this->input->post('periodo') != "" && $this->input->post('periodo') != "-1"){
				$anio = $this->input->post('periodo');
				$this->session->set_userdata('anio_seleccionado', $anio);
			}

			if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "")
				$programa = $this->input->post('idPrograma');
			
			if(!is_null($this->input->post('inputPresupuesto6')) && $this->input->post('inputPresupuesto6') != "")
				$presupuesto6 = $this->input->post('inputPresupuesto6');

			if(!is_null($this->input->post('inputPresupuesto3')) && $this->input->post('inputPresupuesto3') != "")
				$presupuesto3 = $this->input->post('inputPresupuesto3');

			if(!is_null($this->input->post('inputPresupuesto4')) && $this->input->post('inputPresupuesto4') != "")
				$presupuesto4 = $this->input->post('inputPresupuesto4');

			if(!is_null($this->input->post('inputPresupuesto5')) && $this->input->post('inputPresupuesto5') != "")
				$presupuesto5 = $this->input->post('inputPresupuesto5');


			//for ($i=0; $i < 4; $i++) {
				$resultado = null;
				$idPresupuesto = null;
				$cantArchivos = null;
				$nombreOriginal = null;
				$temp = null;
				$nuevoNombre = null;
				$archivo = null;
				$tmp = null;
				$extension = null;
				$config = null;
				//$presupuesto = (($i==0) ? $presupuesto6 : (($i==1) ? $presupuesto3 : (($i==2) ? $presupuesto4 : $presupuesto5)));
				//$subtitulo = (($i==0) ? 6 : (($i==1) ? 3 : (($i==2) ? 4 : 5)));

				$resultado = $this->programa_model->agregarPresupuesto($id_presupuesto, $anio, $programa, $presupuesto6, $presupuesto3, $presupuesto4, $presupuesto5, $usuario['id_usuario']);
				$primero = true;
				//var_dump($presupuesto6.$presupuesto3, $presupuesto4, $presupuesto5);
				//var_dump($resultado[0]['id_presupuesto']);
				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_presupuesto']))
				{
					$idPresupuesto = $resultado[0]['id_presupuesto'];
					//$cantArchivos = $resultado[0]['cant_archivos'];

					/*if($_FILES["archivoPresupuesto"]["name"] != "")
					{
						$nombreOriginal = $_FILES["archivoPresupuesto"]["name"];
						$temp = explode(".", $_FILES["archivoPresupuesto"]["name"]);
						$nuevoNombre =  $idPresupuesto. '_' .($cantArchivos + 1). '.' . end($temp);
						$config['upload_path'] = './assets/files/';
						$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
						$config['file_name'] = $nuevoNombre;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if(!$this->upload->do_upload('archivoPresupuesto'))
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
							$archivoAgregado = $this->programa_model->agregarArchivo("null", $idPresupuesto, "null", "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

							if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
							{
								$datos['Subtitulo'.$subtitulo]['mensaje'] = 'Se ha agregado exitosamente el Presupuesto. Se ha importado exitosamente el adjunto.';
								$datos['Subtitulo'.$subtitulo]['resultado'] = 1;
								$datos['Subtitulo'.$subtitulo]['idPresupuesto'] = $idPresupuesto;
							}
						}
					}else
					{*/
					$datos['mensaje'] = 'Se ha agregado exitosamente el Presupuesto.';
					$datos['resultado'] = 1;
					$datos['idPresupuesto'] = $idPresupuesto;
					//}
				}
			

			echo json_encode($datos);
			/*$programa = "null";
			$subtitulo = "null";
			$presupuesto = "null";
			$presupuesto6 = "null";
			$presupuesto3 = "null";
			$presupuesto4 = "null";
			$presupuesto5 = "null";
			$nombre = "null";
			$extension = "null";
			$peso = "null";
			$primero = false;


			if(!is_null($this->input->post('idPrograma')) && $this->input->post('idPrograma') != "-1")
				$programa = $this->input->post('idPrograma');

			/*if(!is_null($this->input->post('subtitulo')) && $this->input->post('subtitulo') != "-1")
				$subtitulo = $this->input->post('subtitulo');*/

			/*if(!is_null($this->input->post('inputPresupuesto6')) && $this->input->post('inputPresupuesto6') != "-1")
				$presupuesto6 = $this->input->post('inputPresupuesto6');

			if(!is_null($this->input->post('inputPresupuesto3')) && $this->input->post('inputPresupuesto3') != "-1")
				$presupuesto3 = $this->input->post('inputPresupuesto3');

			if(!is_null($this->input->post('inputPresupuesto4')) && $this->input->post('inputPresupuesto4') != "-1")
				$presupuesto4 = $this->input->post('inputPresupuesto4');

			if(!is_null($this->input->post('inputPresupuesto5')) && $this->input->post('inputPresupuesto5') != "-1")
				$presupuesto5 = $this->input->post('inputPresupuesto5');

			for ($i=0; $i < 4; $i++) {
				$resultado = null;
				$idPresupuesto = null;
				$cantArchivos = null;
				$nombreOriginal = null;
				$temp = null;
				$nuevoNombre = null;
				$archivo = null;
				$tmp = null;
				$extension = null;
				$config = null;
				$presupuesto = (($i==0) ? $presupuesto6 : (($i==1) ? $presupuesto3 : (($i==2) ? $presupuesto4 : $presupuesto5)));
				$subtitulo = (($i==0) ? 6 : (($i==1) ? 3 : (($i==2) ? 4 : 5)));
				
				if($presupuesto != "")
				{
					if ($primero)
						mysqli_next_result($this->db->conn_id);

					$resultado = $this->programa_model->agregarPresupuesto("null", $programa, $subtitulo, $presupuesto, $usuario['id_usuario']);
					$primero = true;

					if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_presupuesto']))
					{
						$idPresupuesto = $resultado[0]['id_presupuesto'];
						$cantArchivos = $resultado[0]['cant_archivos'];

						if($_FILES["archivoPresupuesto"]["name"] != "")
						{
							$nombreOriginal = $_FILES["archivoPresupuesto"]["name"];
							$temp = explode(".", $_FILES["archivoPresupuesto"]["name"]);
							$nuevoNombre =  $idPresupuesto. '_' .($cantArchivos + 1). '.' . end($temp);
							$config['upload_path'] = './assets/files/';
							$config['allowed_types'] = 'png|jpg|pdf|docx|xlsx|xls|jpeg';
							$config['file_name'] = $nuevoNombre;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							if(!$this->upload->do_upload('archivoPresupuesto'))
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
								$archivoAgregado = $this->programa_model->agregarArchivo("null", $idPresupuesto, "null", "null", $nombreOriginal, $nuevoNombre, $extension, $usuario['id_usuario']);

								if($archivoAgregado != null && sizeof($archivoAgregado[0]) >= 1 && is_numeric($archivoAgregado[0]['idArchivo']))
								{
									$datos['Subtitulo'.$subtitulo]['mensaje'] = 'Se ha agregado exitosamente el Presupuesto. Se ha importado exitosamente el adjunto.';
									$datos['Subtitulo'.$subtitulo]['resultado'] = 1;
									$datos['Subtitulo'.$subtitulo]['idPresupuesto'] = $idPresupuesto;
								}
							}
						}else
						{
							$datos['Subtitulo'.$subtitulo]['mensaje'] = 'Se ha agregado exitosamente el Presupuesto.';
							$datos['Subtitulo'.$subtitulo]['resultado'] = 1;
							$datos['Subtitulo'.$subtitulo]['idPresupuesto'] = $idPresupuesto;
						}
					}
				}
			}

			echo json_encode($datos);*/
		}
		else
		{
			redirect('Login');
		}
	}

	public function listarPresupuestos()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$anio = "null";
				if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1" && $this->input->post('anio') != ""){
					$anio = $this->input->post('anio');
					$this->session->set_userdata('anio_seleccionado', $anio);
				}

				$presupuestos = $this->programa_model->listarPresupuestos("null", $anio, $usuario["id_usuario"]);

				$table_presupuestos ='
				<table id="tListaPresupuestos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo 21</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo 22</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo 29</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo 24</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Restante Subtitulo 21</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Restante Subtitulo 22</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Restante Subtitulo 29</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Restante Subtitulo 24</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro">PDF</th>-->
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
						</tr>
					</thead>
					<tbody id="tbodyPresupuestos">
		        ';

		        if(isset($presupuestos) && sizeof($presupuestos) > 0)
				{								
					foreach ($presupuestos as $presupuesto) {
						$table_presupuestos .= '<tr>
								<th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['id_grupo_presupuesto'].'</th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['programa'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['presupuesto_6'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['presupuesto_3'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['presupuesto_5'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['presupuesto_4'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['dif_rest_6'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['dif_rest_3'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['dif_rest_5'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['dif_rest_4'], 0, ",", ".").'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'. DateTime::createFromFormat('Y-m-d', $presupuesto['fecha'])->format('d-m-Y').'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['u_nombres'].' '.$presupuesto['u_apellidos'].'</p></td>
					        	<td class="text-center align-middle registro botonTabla">
					        		<a id="edit_'.$presupuesto['id_grupo_presupuesto'].'" class="edit" type="link" href="ModificarPresupuesto/?idPresupuesto='.$presupuesto['id_grupo_presupuesto'].'" data-id="'.$presupuesto['id_grupo_presupuesto'].'" data-programa="'.$presupuesto['programa'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
						        	<a id="trash_'.$presupuesto['id_grupo_presupuesto'].'" class="trash" href="#" data-id="'.$presupuesto['id_grupo_presupuesto'].'" data-programa="'.$presupuesto['programa'].'" data-toggle="modal" data-target="#modalEliminarPresupuesto" data-placement="left">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="left" title="eliminar"></i>       		
					        		</a>
					        	</td>						        
					    	</tr>';
						
					}
				}else
				{
					$table_presupuestos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_presupuestos .='
		        	</tbody>
		        </table>';

				$datos = array('table_presupuestos' =>$table_presupuestos);
		        echo json_encode($datos);
			}else{
				$programas = $this->programa_model->listarProgramas();
				$usuario['programas'] = $programas;

				mysqli_next_result($this->db->conn_id);
				$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
				if($cuentas)
					$usuario["cuentas"] = $cuentas;

				mysqli_next_result($this->db->conn_id);
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);

				mysqli_next_result($this->db->conn_id);
				$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
				$usuario['periodos'] = $periodos;
				$anioSeleccionado = "NULL";
				if (isset($periodos) && sizeof($periodos) > 0){
					if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
						$anioSeleccionado = $usuario["anio_seleccionado"];
						$usuario['anioSeleccionado'] = $anioSeleccionado;
					}else{
						$anioSeleccionado = $periodos[0]["anio"];
						$usuario['anioSeleccionado'] = $periodos[0]["anio"];
						$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
					}
				}

				$usuario['modifica'] = $datos_usuario[0]["modifica"];

				#mysqli_next_result($this->db->conn_id);
				$presupuestos = $this->programa_model->listarPresupuestos("null", $anioSeleccionado, $usuario["id_usuario"]);
				if($presupuestos)
					$usuario['presupuestos'] = $presupuestos;
				

				$usuario['controller'] = 'programa';

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarPresupuestos', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function listarPresupuestosMarcos()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				
				$anio = "null";
				if(!is_null($this->input->post('anio')) && $this->input->post('anio') != "-1" && $this->input->post('anio') != ""){
					$anio = $this->input->post('anio');
					$this->session->set_userdata('anio_seleccionado', $anio);
				}

				$presupuestos = $this->programa_model->listarPresupuestosMarco($anio, "null", $usuario["id_usuario"]);

				$table_presupuestos ='
					<table id="tListaPresupuestos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Presupuesto</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
						</tr>
					</thead>
					<tbody id="tbodyPresupuestos">
		        ';

		        if(isset($presupuestos) && sizeof($presupuestos) > 0)
				{								
					foreach ($presupuestos as $presupuesto) {
						$table_presupuestos .= '<tr>
				        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['id_presupuesto'].'</th>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['programa'].'</p></td>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['codigo_cuenta'].' '.$presupuesto['cuenta'].'</p></td>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['presupuesto'], 0, ",", ".").'</p></td>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">$ '.number_format($presupuesto['dif_rest'], 0, ",", ".").'</p></td>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">'.DateTime::createFromFormat('Y-m-d', $presupuesto['fecha'])->format('d-m-Y').'</p></td>
				        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$presupuesto['u_nombres'].' '.$presupuesto['u_apellidos'].'</p></td>						        
				        <td class="text-center align-middle registro botonTabla paginate_button">
			        		<button href="#" aria-controls="tListaPresupuestos" data-id="'.$presupuesto['id_presupuesto'].'" data-programa="'.$presupuesto['programa'].'" data-presupuesto="'.$presupuesto['presupuesto'].'" data-restante="'.$presupuesto['dif_rest'].'" data-codigo_cuenta="'.$presupuesto['codigo_cuenta'].'" data-id_cuenta="'.$presupuesto['id_cuenta'].'" data-nombre_cuenta="'.$presupuesto['cuenta'].'" tabindex="0" class="btn btn-outline-dark seleccionPresupuesto">Seleccionar</button>
			        	</td>
			    		</tr>';
				
					}
				}/*else
				{
					$table_presupuestos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}*/

		        $table_presupuestos .='
		        	</tbody>
		        </table>';

				$datos = array('table_presupuestos' =>$table_presupuestos);
		        echo json_encode($datos);
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function eliminarPresupuesto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idPresupuesto = null;
			if($this->input->POST('idPresupuesto'))
				$idPresupuesto = $this->input->POST('idPresupuesto');
			$resultado = $this->programa_model->eliminarPresupuesto($idPresupuesto, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function aprobacionConvenio()
	{
		$usuario = $this->session->userdata();
		if($usuario["id_usuario"]){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$datos[] = array();
		     	unset($datos[0]);
				$estado = "null";
				$convenio = "null";
				$observacion = "null";

				if(!is_null($this->input->post('estado')) && $this->input->post('estado') != "-1" && $this->input->post('estado') != "")
					$estado = $this->input->post('estado');

				if(!is_null($this->input->post('convenio')) && $this->input->post('convenio') != "-1")
					$convenio = $this->input->post('convenio');

				if(!is_null($this->input->post('observacion')) && $this->input->post('observacion') != "-1")
					$observacion = $this->input->post('observacion');

				$resultado = $this->programa_model->revisionConvenio($convenio, $estado, $observacion, $usuario['id_usuario']);

				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['resultado']))
				{
					if (intval($resultado[0]['resultado']) >= 1) {
						$datos['mensaje'] = 'Se ha '.($estado == 1 ? 'Aprobado' : 'Rechazado').' exitosamente el Convenio, '.$resultado[0]['mensaje'];
					}else{
						$datos['mensaje'] = 'No se ha '.($estado == 1 ? 'Aprobado' : 'Rechazado').' el Convenio, '.$resultado[0]['mensaje'];
					}
					
					$datos['resultado'] = intval($resultado[0]['resultado']);
				}

		        echo json_encode($datos);

			}else{
				$institucion = "null";
				$programa = "null";
				$comuna = "null";
				$estado = "null";
				$filtro = "null";

				$periodos = $this->programa_model->listarPeriodos($usuario["id_usuario"]);
				$usuario['periodos'] = $periodos;
				$anioSeleccionado = "NULL";
				if (isset($periodos) && sizeof($periodos) > 0){
					if (isset($usuario["anio_seleccionado"]) && is_numeric($usuario["anio_seleccionado"]) && $usuario["anio_seleccionado"] > 0) {
						$anioSeleccionado = $usuario["anio_seleccionado"];
						$usuario['anioSeleccionado'] = $anioSeleccionado;
					}else{
						$anioSeleccionado = $periodos[0]["anio"];
						$usuario['anioSeleccionado'] = $periodos[0]["anio"];
						$this->session->set_userdata('anio_seleccionado', $anioSeleccionado);
					}
				}

				$programas = $this->programa_model->listarProgramas();
				$usuario['programas'] = $programas;
				
				mysqli_next_result($this->db->conn_id);
				$fechaResoluciones = $this->programa_model->listarFechaResolucionConv($institucion, $programa, $comuna, $estado, $filtro, $usuario["id_usuario"]);
				$usuario['fechaResoluciones'] = $fechaResoluciones;
				
				

				mysqli_next_result($this->db->conn_id);
				$instituciones = $this->institucion_model->listarInstitucionesUsu($usuario["id_usuario"]);
				if($instituciones)
					$usuario["instituciones"] = $instituciones;


				#mysqli_next_result($this->db->conn_id);
				#$cuentas = $this->cuenta_model->listarCuentasUsu($usuario["id_usuario"]);
				#if($cuentas)
				#	$usuario["cuentas"] = $cuentas;

				/*mysqli_next_result($this->db->conn_id);
				$convenios = $this->programa_model->listarConvenios("null", "null", "null", 2, $usuario["id_usuario"]);
				if($convenios)
					$usuario['convenios'] = $convenios;*/

				$usuario['controller'] = 'programa';
				$usuario['fechaResoluciones'] = $fechaResoluciones;
				//var_dump($fechaResoluciones);

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('aprobacionConvenio', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}


	public function exportarexcel(){
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$programa = "null";
			$estado = "null";

			if(!is_null($this->input->get('institucion')) && $this->input->get('institucion') != "-1" && is_numeric($this->input->get('institucion')) && (floatval($this->input->get('institucion')) > 0))
				$institucion = $this->input->get('institucion');

			if(!is_null($this->input->get('programa')) && $this->input->get('programa') != "-1" && is_numeric($this->input->get('programa')) && (floatval($this->input->get('programa')) > 0))
				$programa = $this->input->get('programa');

			if(!is_null($this->input->get('estado')) && $this->input->get('estado') != "-1" && is_numeric($this->input->get('estado')) && (floatval($this->input->get('estado')) > 0))
				$estado = $this->input->get('estado');

			$fechaDesde = "null";
			if(!is_null($this->input->get('fechaDesde')) && $this->input->get('fechaDesde') != "-1" && $this->input->get('fechaDesde') != "")
				$fechaDesde = $this->input->get('fechaDesde');

			$fechaHasta = "null";
			if(!is_null($this->input->get('fechaHasta')) && $this->input->get('fechaHasta') != "-1" && $this->input->get('fechaHasta') != "")
				$fechaHasta = $this->input->get('fechaHasta');

			$fechaResolucion = "null";
			if(!is_null($this->input->get('fechaResolucion')) && $this->input->get('fechaResolucion') != "-1" && $this->input->get('fechaResolucion') != "")
				$fechaResolucion = $this->input->get('fechaResolucion');


			$inicio = 0;
			$filtro = null;

			$cant = $this->programa_model->cantlistarConvenios($institucion, $programa, "null", $estado, $fechaResolucion, $fechaDesde, $fechaHasta, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$convenios = $this->programa_model->listarConvenios($institucion, $programa, "null", $estado, $fechaResolucion, $fechaDesde, $fechaHasta, $inicio,
			$cant , $filtro, $usuario["id_usuario"]);

			$this->excel->getActiveSheet()->setTitle('ListadoConvenios');
			
	        $contador = 7;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);

	        $this->excel->getActiveSheet()->getStyle('A7:M7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');

	        $this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			$this->excel->getActiveSheet()->mergeCells("A1:M5");

			$style = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	$styleTitulo = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	$this->excel->getActiveSheet()->getStyle('A1:M5')->applyFromArray($styleTitulo);
        	$this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Convenios Realizados');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:M7')->applyFromArray($style);

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
	        
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", '# ID');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Institución');
			$this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Establecimiento');
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Comuna');
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Programa');
			$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Subtitulo');
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha ingreso al sistema');
			$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Usuario');
			$this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Marco');
			$this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Convenio');
			$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'N° de Resolución');
			$this->excel->getActiveSheet()->setCellValue("L{$contador}", 'FechaResolucion');
			$this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Estado');
			

	        foreach($convenios as $convenio){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	           	$this->excel->getActiveSheet()->setCellValue("A{$contador}", $convenio['id_convenio']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $convenio['institucion']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $convenio['codigo_hospital'].' '.$convenio['hospital']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $convenio['comuna']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $convenio['programa']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $convenio['codigo_cuenta'].' '.$convenio['cuenta']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", DateTime::createFromFormat('Y-m-d H:i:s', $convenio['fecha'])->format('d-m-Y H:i:s'));
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']);
				//$this->excel->getActiveSheet()->setCellValue("J{$contador}", "$ ".number_format($convenio['convenio'], 0, ",", "."));
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $convenio['asignacion']);
				$this->excel->getActiveSheet()->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $convenio['convenio']);
				$this->excel->getActiveSheet()->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", $convenio['codigo']);
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $convenio['fecha_resolucion']);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", ($convenio['id_estado_convenio'] == "1" ? 'Aprobado' : (($convenio['id_estado_convenio'] == "2" ? 'Rechazado' : 'Pendiente de Aprobacion'))));
	        }

			$archivo = "listadoConveniosRealizados_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

	        ob_end_clean();
			ob_start();
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }

    public function exportarexcelMarco(){
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{
			$institucion = "null";
			$programa = "null";
			$estado = "null";
			$presupuesto = "null";

			if(!is_null($this->input->get('institucion')) && $this->input->get('institucion') != "-1" && is_numeric($this->input->get('institucion')) && (floatval($this->input->get('institucion')) > 0))
				$institucion = $this->input->get('institucion');

			if(!is_null($this->input->get('programa')) && $this->input->get('programa') != "-1" && is_numeric($this->input->get('programa')) && (floatval($this->input->get('programa')) > 0))
				$programa = $this->input->get('programa');

			$inicio = 0;
			$filtro = null;

			$cant = $this->programa_model->listarCantMarcosUsuario($institucion, $presupuesto, $programa, $usuario["id_usuario"]);
			if($cant)
				$cant = $cant[0]['cantidad'];

			mysqli_next_result($this->db->conn_id);
			$marcos = $this->programa_model->listarMarcosUsuario($institucion, $presupuesto, $programa, $inicio,
			$cant , $filtro, $usuario["id_usuario"]);

			$this->excel->getActiveSheet()->setTitle('ListadoMarcos');
			
	        $contador = 7;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);

	        $this->excel->getActiveSheet()->getStyle('A7:H7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');

	        $this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			$this->excel->getActiveSheet()->mergeCells("A1:H5");

			$style = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	$styleTitulo = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	$this->excel->getActiveSheet()->getStyle('A1:H5')->applyFromArray($styleTitulo);
        	$this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Marcos Realizados');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:H7')->applyFromArray($style);

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
	        
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", '# ID');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Programa');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Subtitulo');
			$this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Institución');
			$this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Fecha');
			$this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Usuario');
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Marco');
			$this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Monto Restante');

	        foreach($marcos as $marco){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	           	$this->excel->getActiveSheet()->setCellValue("A{$contador}", $marco['id_grupo_marco']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $marco['programa']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $marco['codigo_cuenta'].' '.$marco['cuenta']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $marco['codigo_institucion'].' '.$marco['institucion']);				
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", DateTime::createFromFormat('Y-m-d H:i:s', $marco['fecha'])->format('d-m-Y H:i:s'));
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $marco['u_nombres'].' '.$marco['u_apellidos']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $marco['marco_presupuesto']);
				$this->excel->getActiveSheet()->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $marco['dif_rest']);
				$this->excel->getActiveSheet()->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	        }

			$archivo = "listadoMarcosRealizados_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

	        ob_end_clean();
			ob_start();
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }

    public function exportarexcelPresupuesto(){
		$usuario = $this->session->userdata();
		$pagos = [];
		if($this->session->userdata('id_usuario'))
		{

			$presupuestos = $this->programa_model->listarPresupuestos("null", $usuario["id_usuario"]);

			$this->excel->getActiveSheet()->setTitle('ListadoPresupuestos');
			
	        $contador = 7;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

	        $this->excel->getActiveSheet()->getStyle('A7:L7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');

	        $this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			$this->excel->getActiveSheet()->mergeCells("A1:L5");

			$style = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	$styleTitulo = array('alignment' => array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	$this->excel->getActiveSheet()->getStyle('A1:L5')->applyFromArray($styleTitulo);
        	$this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Presupuestos Realizados');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:L7')->applyFromArray($style);

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
	        
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", '# ID');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Programa');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Subtitulo 21');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Subtitulo 22');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Subtitulo 29');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Subtitulo 24');
			$this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Restante Subtitulo 21');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Restante Subtitulo 22');
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Restante Subtitulo 29');
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Restante Subtitulo 24');
			$this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Fecha');
			$this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Usuario');

	        foreach($presupuestos as $presupuesto){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	           	$this->excel->getActiveSheet()->setCellValue("A{$contador}", $presupuesto['id_grupo_presupuesto']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $presupuesto['programa']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $presupuesto['presupuesto_6']);
				$this->excel->getActiveSheet()->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $presupuesto['presupuesto_3']);
				$this->excel->getActiveSheet()->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $presupuesto['presupuesto_5']);
				$this->excel->getActiveSheet()->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $presupuesto['presupuesto_3']);
				$this->excel->getActiveSheet()->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $presupuesto['dif_rest_6']);
				$this->excel->getActiveSheet()->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $presupuesto['dif_rest_3']);
				$this->excel->getActiveSheet()->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $presupuesto['dif_rest_5']);
				$this->excel->getActiveSheet()->getStyle("I{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $presupuesto['dif_rest_3']);
				$this->excel->getActiveSheet()->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", DateTime::createFromFormat('Y-m-d', $presupuesto['fecha'])->format('d-m-Y'));
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $presupuesto['u_nombres'].' '.$presupuesto['u_apellidos']);
	        }

			$archivo = "listadoPresupuestosRealizados_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

	        ob_end_clean();
			ob_start();
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }

}

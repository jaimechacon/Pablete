<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('perfil_model');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarUsuarios', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			//$data['message'] = 'Verifique su email y contrase&ntilde;a.';
			redirect('Inicio');
		}
	}

	public function listarUsuarios()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$usuarios = $this->usuario_model->buscarUsuario('', (int)$usuario["id_usuario"]);

				$table_usuarios ='
				<table id="tListaUsuarios" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Rut</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombres</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Apellidos</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Email</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Perfil</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Empresa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyUsuario">
		        ';

		        if(isset($usuarios) && sizeof($usuarios) > 0)
				{								
					foreach ($usuarios as $usuario) {
						$table_usuarios .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['id_usuario'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['cod_usuario'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['rut'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['nombres'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['apellidos'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['email'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['pf_nombre'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$usuario['empresa'].'</p></td>
						        <td class="text-center align-middle registro texto-pequenio botonTabla">
						        	<a id="trash_'.$usuario['id_usuario'].'" class="trash" href="#" data-id="'.$usuario['id_usuario'].'" data-nombre="'.$usuario['nombres'].'" data-apellido="'.$usuario['apellidos'].'" data-rut="'.$usuario['rut'].'" data-toggle="modal" data-target="#modalEliminarUsuario">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$usuario['id_usuario'].'" class="edit" type="link" href="ModificarUsuario/?idUsuario='.$usuario['id_usuario'].'" data-id="'.$usuario['id_usuario'].'" data-nombre="'.$usuario['nombres'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_usuarios .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_usuarios .='
		        	</tbody>
		        </table>';

				$datos = array('table_usuarios' =>$table_usuarios);
		        

		        echo json_encode($datos);

			}else{
				$usuarios = $this->usuario_model->buscarUsuario('', (int)$usuario["id_usuario"]);
				$usuario['usuarios'] = $usuarios;
				$usuario['controller'] = 'usuario';
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarUsuarios', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}

	public function buscarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$filtroUsuario = "";
			if($this->input->POST('usuario'))
				$filtroUsuario = $this->input->POST('usuario');
			echo json_encode($this->usuario_model->buscarUsuario($filtroUsuario, (int)$usuario["id_usuario"]));
		}
	}

	public function agregarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuario['titulo'] = 'Agregar Usuario';
			$usuario['controller'] = 'usuario';
			
			$perfiles =  $this->perfil_model->obtenerPerfiles($usuario["id_usuario"]);
			if($perfiles)
				$usuario['perfiles'] = $perfiles;

			mysqli_next_result($this->db->conn_id);


			$empresas =  $this->usuario_model->obtenerEmpresasUsu($usuario["id_usuario"]);
			if($empresas)
			{
				$usuario['empresas'] = $empresas;
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarUsuario', $usuario);
			$this->load->view('temp/footer', $usuario);
		}
	}

	public function guardarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if(!is_null($this->input->POST('nombres')))
			{
				if(!is_null($this->input->POST('apellidos')))
				{
					$rut = "null";
					if(!is_null($this->input->POST('rut')) && trim($this->input->POST('rut')) != "")
						$rut = trim($this->input->POST('rut'));

					$idEmpresa = "null";
					if(!is_null($this->input->POST('idEmpresa')) && trim($this->input->POST('idEmpresa')) != "")
						$idEmpresa = trim($this->input->POST('idEmpresa'));

					$nombres = "null";
					if(!is_null($this->input->POST('nombres')) && trim($this->input->POST('nombres')) != "")
						$nombres = trim($this->input->POST('nombres'));

					$apellidos = "null";
					if(!is_null($this->input->POST('apellidos')) && trim($this->input->POST('apellidos')) != "")
						$apellidos = trim($this->input->POST('apellidos'));
						
					$email = "null";
					if(!is_null($this->input->POST('email')) && trim($this->input->POST('email')) != "")
						$email = trim($this->input->POST('email'));

					$codUsuario = "null";
					if(!is_null($this->input->POST('codUsuario')) && trim($this->input->POST('codUsuario')) != "")
						$codUsuario = trim($this->input->POST('codUsuario'));

					$idPerfil = "null";
					if(!is_null($this->input->POST('idPerfil')) && trim($this->input->POST('idPerfil')) != "")
						$idPerfil = trim($this->input->POST('idPerfil'));

					$contabilizar = "null";
					if(!is_null($this->input->POST('contabilizar')) && trim($this->input->POST('contabilizar')) != "")
						$contabilizar = trim($this->input->POST('contabilizar'));

					$accion = 'agregado';
					
					$idUsuario = 'null';
					if(!is_null($this->input->POST('idUsuario')) && is_numeric($this->input->POST('idUsuario')))
					{
						$idUsuario = $this->input->POST('idUsuario');
						$accion = 'modificado';
					}

					$respuesta = 0;
					$mensaje = '';

					$resultado = $this->usuario_model->guardarUsuario($idUsuario, $rut, $idEmpresa, $nombres, $apellidos, $email, $codUsuario, $contabilizar, $idPerfil,  $usuario["id_usuario"]);

					if($resultado[0] > 0)
					{

						if($resultado[0]['idUsuario'])
						{
							if($idUsuario == 'null')
								$idUsuario = (int)$resultado[0]['idUsuario'];
							
							$respuesta = 1;
							$mensaje = 'Se ha '.$accion.' el usuario exitosamente.';
						}
					}else
					{
						if($resultado === 0)
						{
							$mensaje = 'Ha ocurrido un error al '.$accion.' la categor&iacute;a, la categor&iacute;a no se encuentra registrado.';
						}
					}
					$data['respuesta'] = $respuesta;
					$data['mensaje'] = $mensaje;
					echo json_encode($data);
				}
			}
		}
	}

	public function eliminarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idUsuario = null;
			if($this->input->POST('idUsuario'))
				$idUsuario = $this->input->POST('idUsuario');
			$resultado = $this->usuario_model->eliminarUsuario($idUsuario, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function modificarUsuario()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuario['titulo'] = 'Modificar Usuario';
			$usuario['controller'] = 'usuario';

			if($this->input->GET('idUsuario') && $this->input->GET('idUsuario'))
			{
				//mysqli_next_result($this->db->conn_id);
				$idUsuario = $this->input->GET('idUsuario');
				$usuarioSeleccionado =  $this->usuario_model->obtenerUsuario($idUsuario);
				$usuario['usuarioSeleccionado'] = $usuarioSeleccionado[0];

				mysqli_next_result($this->db->conn_id);
				$perfiles =  $this->perfil_model->obtenerPerfiles($usuario["id_usuario"]);
				if($perfiles)
					$usuario['perfiles'] = $perfiles;

				mysqli_next_result($this->db->conn_id);

				$empresas =  $this->usuario_model->obtenerEmpresasUsu($usuario["id_usuario"]);
				if($empresas)
				{
					$usuario['empresas'] = $empresas;
				}
			}

			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarUsuario', $usuario);
			$this->load->view('temp/footer');
		}
	}
	
}
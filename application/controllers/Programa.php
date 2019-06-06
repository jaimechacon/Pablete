<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('programa_model');

	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarPrograma', $usuario);
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
		if($usuario){
			$campanias = $this->usuario_model->listarProgramasUsu($usuario["id_usuario"]);
			$usuario['campanias'] = $campanias;
			mysqli_next_result($this->db->conn_id);
			$usuarios = $this->usuario_model->listarAnalistaUsu();
			$usuario['usuarios'] = $usuarios;
				
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
			//$campanias = $this->usuario_model->listarProgramasUsu($usuario["id_usuario"]);
			//$usuario['programa'] = $programa;
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
						<th scope="col" class="text-center align-middle registro"># ID</th>
					    <th scope="col" class="text-center align-middle registro">Nombre</th>
					    <th scope="col" class="text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="text-center align-middle registro">Forma de Pago</th>
					    <th scope="col" class="text-center align-middle registro"  style="width: 50px;"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
		        ';

		        if(isset($programas) && sizeof($programas) > 0)
				{								
					foreach ($programas as $programa) {
						$table_programas .= '<tr>
								<tr>
						        <th scope="row" class="text-center align-middle registro">'.$programa['id_programa'].'</th>
						        <td class="text-center align-middle registro">'.$programa['nombre'].'</td>
						        <td class="text-center align-middle registro">'.$programa['descripcion'].'</td>
						        <td class="text-center align-middle registro">'.$programa['forma_pago'].'</td>
						        <td class="text-right align-middle registro column_icon"  style="width: 50px;">
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
}

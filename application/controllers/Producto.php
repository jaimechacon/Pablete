<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('producto_model');
		$this->load->model('institucion_model');
		$this->load->model('cuenta_model');
		$this->load->model('hospital_model');
		$this->load->helper('form');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if($usuario){

			$productos = $this->producto_model->listarProductos();
				
			$usuario['productos'] = $productos;
			$usuario['controller'] = 'producto';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarProductos', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarProductos()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$productos = $this->producto_model->listarProductos();

				$table_productos ='
				<table id="tablaProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Unidad de Medida</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
		        ';

		        if(isset($productos) && sizeof($productos) > 0)
				{								
					foreach ($productos as $producto) {
						$table_productos .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['id_producto'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['codigo'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['nombre'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['descripcion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['unidad_medida'].'</p></td>
						        <td class="text-center align-middle registro texto-pequenio botonTabla">
						        	<a id="trash_'.$producto['id_producto'].'" class="trash" href="#" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_productos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_productos .='
		        	</tbody>
		        </table>';

				$datos = array('table_productos' =>$table_productos);
		        

		        echo json_encode($datos);

			}else{
				$productos = $this->producto_model->listarProductos();
				
				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarProductos', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}

	public function eliminarProducto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idProducto = null;
			if($this->input->POST('idProducto'))
				$idProducto = $this->input->POST('idProducto');
			$resultado = $this->producto_model->eliminarProducto($idProducto, $usuario['id_usuario']);
			$respuesta = 0;
			if($resultado > 0)
				$respuesta = 1;
			echo json_encode($respuesta);
		}
	}

	public function agregarProducto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$usuario['controller'] = 'producto';
			$usuario['titulo'] = 'Agregar Producto';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarProducto', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			redirect('Inicio');
		}
	}

	public function guardarProducto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$datos[] = array();
		     	unset($datos[0]);
				$codigo = "null";
				$nombre = "null";
				$unidadMedida = "null";
				$observacion = "null";
				$id_producto = "null";
				$accion = 'agregado';

				if(!is_null($this->input->post('codigo')) && $this->input->post('codigo') != "-1")
					$codigo = $this->input->post('codigo');

				if(!is_null($this->input->post('nombre')) && $this->input->post('nombre') != "-1")
					$nombre = $this->input->post('nombre');

				if(!is_null($this->input->post('observacion')) && $this->input->post('observacion') != "-1")
					$observacion = $this->input->post('observacion');

				if(!is_null($this->input->post('unidadMedida')) && $this->input->post('unidadMedida') != "-1")
					$unidadMedida = $this->input->post('unidadMedida');

				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1" && trim($this->input->post('idProducto')) <> "")
				{
					$id_producto = $this->input->post('idProducto');
					$accion = 'modificado';
				}

				$resultado = $this->producto_model->agregarProducto($id_producto, $codigo, $nombre, $observacion, $unidadMedida, $usuario['id_usuario']);

				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_producto']))
				{
					$datos['mensaje'] = 'Se ha '.$accion.' exitosamente el Producto.';
					$datos['resultado'] = 1;
				}
		        echo json_encode($datos);
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function modificarProducto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idProducto = "null";
			if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1")
				$idProducto = $this->input->get('idProducto');

			$resultado = $this->producto_model->obtenerProducto($idProducto);
			$usuario['titulo'] = 'Modificar Producto';
			$usuario['producto'] = $resultado[0];
			$usuario['controller'] = 'producto';
			
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('agregarProducto', $usuario);
			$this->load->view('temp/footer');
		}else
		{
			redirect('Inicio');
		}
	}

	public function agregarStock()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$datos[] = array();
		     	unset($datos[0]);
				$idStockProducto = "null";
				$stock = "null";
				$descripcion = "null";
				$numOrden = "null";
				$idProducto = "null";


				if(!is_null($this->input->post('idStockProducto')) && $this->input->post('idStockProducto') != "-1" && trim($this->input->post('idStockProducto')) != "")
					$idStockProducto = $this->input->post('idStockProducto');

				if(!is_null($this->input->post('inputCantProducto')) && $this->input->post('inputCantProducto') != "-1" && trim($this->input->post('inputCantProducto')) != "")
					$stock = $this->input->post('inputCantProducto');

				if(!is_null($this->input->post('inputDescripcion')) && $this->input->post('inputDescripcion') != "-1" && trim($this->input->post('inputDescripcion')) != "")
					$descripcion = $this->input->post('inputDescripcion');

				if(!is_null($this->input->post('inputOrdenCompra')) && $this->input->post('inputOrdenCompra') != "-1" && trim($this->input->post('inputOrdenCompra')) != "")
					$numOrden = $this->input->post('inputOrdenCompra');

				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1" && trim($this->input->post('idProducto')) != "")
					$idProducto = $this->input->post('idProducto');

				$resultado = $this->producto_model->agregarStockProducto($idStockProducto, $stock, $descripcion, $numOrden, $idProducto, $usuario['id_usuario']);

				if($resultado != null && sizeof($resultado[0]) >= 1 && is_numeric($resultado[0]['id_stock_producto']))
				{
					$datos['mensaje'] = 'Se ha agregado exitosamente el Stock del Producto.';
					$datos['resultado'] = 1;
				}else
				{
					$datos['mensaje'] = $resultado[0]["mensaje"];
					$datos['resultado'] = -1;
				}
		        echo json_encode($datos);
			}else{
				$resultado = $this->producto_model->listarProductos();
				$usuario['productos'] = $resultado;
				$usuario['controller'] = 'producto';
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('agregarStock', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function listadoStock()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$productos = $this->producto_model->listarProductos();

				$table_productos ='
				<table id="tablaProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Unidad de Medida</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
		        ';

		        if(isset($productos) && sizeof($productos) > 0)
				{								
					foreach ($productos as $producto) {
						$table_productos .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['id_producto'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['codigo'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['nombre'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['descripcion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['unidad_medida'].'</p></td>
						        <td class="text-center align-middle registro texto-pequenio botonTabla">
						        	<a id="trash_'.$producto['id_producto'].'" class="trash" href="#" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_productos .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_productos .='
		        	</tbody>
		        </table>';

				$datos = array('table_productos' =>$table_productos);
		        

		        echo json_encode($datos);

			}else{
				$productos = $this->producto_model->listarStockProductos();
				
				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listadoStock', $usuario);
				$this->load->view('temp/footer');
			}
		}
	}

	public function obtenerProducto()
	{
		$usuario = $this->session->userdata();
		if($usuario){
			$idProducto = "null";
			if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1")
				$idProducto = $this->input->post('idProducto');

			$resultado = $this->producto_model->obtenerProducto($idProducto);
			$datos = $resultado[0];
		    echo json_encode($datos);
		}else
		{
			redirect('Inicio');
		}
	}

}
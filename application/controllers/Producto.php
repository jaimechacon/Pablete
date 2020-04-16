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
		if($this->session->has_userdata('id_usuario')){

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
		if($this->session->has_userdata('id_usuario')){
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
		if($this->session->has_userdata('id_usuario')){
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
		if($this->session->has_userdata('id_usuario')){
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
		if($this->session->has_userdata('id_usuario')){
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
		if($this->session->has_userdata('id_usuario')){
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
		if($this->session->has_userdata('id_usuario')){
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

				if(!is_null($this->input->post('idProductoLS')) && $this->input->post('idProductoLS') != "-1" && trim($this->input->post('idProductoLS')) != "")
					$idProducto = $this->input->post('idProductoLS');

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
		if($this->session->has_userdata('id_usuario')){
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
						        	<!--<a id="trash_'.$producto['id_producto'].'" class="trash" href="#" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>-->
					        		<a id="search_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
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
				$idInstitucion = "null";
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				$es_hospital = false;
				if($datos_usuario[0]["pf_analista"] == "1"){
					$idInstitucion = $datos_usuario[0]["id_institucion"];
					$es_hospital = true;
				}

				mysqli_next_result($this->db->conn_id);
				$productos = $this->producto_model->listarStockProductos($idInstitucion);

				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				$usuario['es_hospital'] = $es_hospital;
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
		if($this->session->has_userdata('id_usuario')){
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

	public function ingresosStock()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){
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
						        <td class="text-center align-middle registro texto-pequenio botonTabla">'.
						        	/*<a id="trash_'.$producto['id_producto'].'" class="trash" href="#" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>*/
					        	'</td>
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
				$idProducto = "null";

				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1" && trim($this->input->get('idProducto')) != "")
					$idProducto = $this->input->get('idProducto');

				$productos = $this->producto_model->listarIngresosStock($idProducto);
				$usuario['idProducto'] = $idProducto;
				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('ingresosStock', $usuario);
				$this->load->view('temp/footer');
			}
		}
	}

	public function ingresosStockInstitucion()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){
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
						        <td class="text-center align-middle registro texto-pequenio botonTabla">'.
						        	/*<a id="trash_'.$producto['id_producto'].'" class="trash" href="#" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_'.$producto['id_producto'].'" class="edit" type="link" href="ModificarProducto/?idProducto='.$producto['id_producto'].'" data-id="'.$producto['id_producto'].'" data-nombre="'.$producto['nombre'].'">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>*/
					        	'</td>
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
				$idProducto = "null";
				$idInstitucion = "null";
				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1" && trim($this->input->get('idProducto')) != "")
					$idProducto = $this->input->get('idProducto');

				if(!is_null($this->input->get('idInstitucion')) && $this->input->get('idInstitucion') != "-1" && trim($this->input->get('idInstitucion')) != "")
					$idInstitucion = $this->input->get('idInstitucion');

				$productos = $this->producto_model->listarIngresosStockInstitucion($idProducto, $idInstitucion, $usuario['id_usuario']);
				$usuario['idProducto'] = $idProducto;
				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('ingresosStockInstitucion', $usuario);
				$this->load->view('temp/footer');
			}
		}
	}

	public function distribuirStock()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$resultado = null;
				$cantidad = "null";
				$idProducto = "null";
				$datos[] = array();
 				unset($datos[0]);
 				//var_dump($this->input->post());
				if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1")
					$cantidad = $this->input->post('cantidad');

				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1")
					$idProducto = $this->input->post('idProducto');
				if (is_numeric($cantidad) && (int)$cantidad > 0) {
					$cantidades = (int)$cantidad;

					for ($i=0; $i < $cantidades; $i++) {
						$idInstitucion = "null";
						$stock = "null";
						$numOrden = "null";
						$tipoDoc = "null";
						$observacion = "null";

						if (is_numeric($this->input->post('inputInstitucion'.$i)) && (floatval($this->input->post('inputInstitucion'.$i)) > 0))
							$idInstitucion = $this->input->post('inputInstitucion'.$i);

						if (is_numeric($this->input->post('inputStock'.$i)) && (floatval($this->input->post('inputStock'.$i)) > 0))
							$stock = $this->input->post('inputStock'.$i);

						if(!is_null($this->input->post('inputNOrden'.$i)) && $this->input->post('inputNOrden'.$i) != "")
							$numOrden = $this->input->post('inputNOrden'.$i);							

						if(!is_null($this->input->post('tipoDoc'.$i)) && $this->input->post('tipoDoc'.$i) != "")
							$tipoDoc = $this->input->post('tipoDoc'.$i);

						if(!is_null($this->input->post('textarea'.$i)) && $this->input->post('textarea'.$i) != "")
							$observacion = $this->input->post('textarea'.$i);

						if (is_numeric($stock) && $stock > 0)
						{
							$resultado = $this->producto_model->agregarDistribucion("null", $idInstitucion, $stock, $numOrden, $tipoDoc, $observacion, $idProducto, $usuario['id_usuario']);
							mysqli_next_result($this->db->conn_id);
						}
					}
				}

			if ($resultado && isset($resultado) && sizeof($resultado) > 0) {
				$id_distribucion = $resultado[0]['id_distribucion'];
				$datos['mensaje'] = 'Se han agregado exitosamente la distribucion de Stock.';
				$datos['resultado'] = 1;
				$datos['id_distribucion'] = $id_distribucion;

			}
				echo json_encode($datos);
			}else{
				$idProducto = "null";

				$id_usuario = $this->session->userdata('id_usuario');

				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1" && trim($this->input->get('idProducto')) != ""){
					$idProducto = $this->input->get('idProducto');
					$usuario["idProducto"] = $idProducto;

					$resultado = $this->producto_model->obtenerProducto($idProducto);
					$usuario['producto'] = $resultado[0];
					mysqli_next_result($this->db->conn_id);
				}
				
				$usuario['controller'] = 'producto';

				
				$resultado = $this->producto_model->listarProductosDisponibles();
				$usuario['productos'] = $resultado;

				mysqli_next_result($this->db->conn_id);
				$instituciones =  $this->institucion_model->listarInstitucionesUsuAPS($id_usuario);
				$usuario["instituciones"] = $instituciones;
				$usuario['cantidad'] = sizeof($instituciones);
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('distribuirStock', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarDistribucion()
	{
		$usuario = $this->session->userdata();
		$datos[] = array();
     	unset($datos[0]);
		if($this->session->has_userdata('id_usuario')){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$idProducto = "null";
				$idInstitucion = "null";
				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1")
					$idProducto = $this->input->post('idProducto');

			
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				
				if($datos_usuario[0]["pf_analista"] == "1"){
					$idInstitucion = $datos_usuario[0]["id_institucion"];
					mysqli_next_result($this->db->conn_id);
					$hospitales = $this->producto_model->listarDistribucionInstitucion($idProducto, $idInstitucion, $usuario['id_usuario']);
					$table_hospitales ='
					<table id="tListaDistribucionProductos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Abreviaci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Hospital</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock</th>
						    <!--<th scope="col" class="texto-pequenio text-center align-middle registro">Stock Disponible</th>
						    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
						</tr>
					</thead>
					<tbody id="tbodyProducto">';


					if(isset($hospitales) && sizeof($hospitales) > 0)
			        {
				        foreach ($hospitales as $hospital){
				        	$table_hospitales .='<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['id_hospital'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['abreviacion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['hospital'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['stock'].'</p></td>
						        <!--<td class="text-center align-middle registro"><p class="texto-pequenio">'.$hospital['dif_rest'].'</p></td>-->
						        <!--<td class="text-center align-middle registro botonTabla">
					        		<a id="edit_'.$hospital['id_hospital'].'" class="edit" type="link" href="'.base_url().'Producto/ingresosStock/?idProducto='.$idProducto.'&idInstitucion='.$hospital['id_institucion'].'" data-id="'.$idProducto.'" data-nombre="'.$hospital['nombre'].'">
						        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="revisar"></i>
					        		</a>';
					        		if ($hospital['dif_rest'] != "0") {
					        			$table_hospitales .='<a id="share_'.$hospital['id_hospital'].'" class="edit" type="link" href="'.base_url().'Producto/distribuirStockInstitucion'.(isset($idProducto) ? ('/?idProducto='.$idProducto.'&idInstitucion='.$hospital['id_institucion']) : '').'" data-id="'.$hospital['id_hospital'].'" data-nombre="'.$hospital['nombre'].'">
						        		<i data-feather="share-2" data-toggle="tooltip" data-placement="top" title="distribuir"></i>
					        		</a>';
					        		}
					        	$table_hospitales .='</td>-->
					    	</tr>';
				        }
			  		}else
					{
						$table_hospitales .= '<tr>
							<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
						  </tr>';
					}
					$table_hospitales .='
				        	</tbody>
				        </table>';
					$datos = array('table_instituciones' => $table_hospitales);
				}else{
					mysqli_next_result($this->db->conn_id);
					$instituciones = $this->producto_model->listarDistribucion($idProducto, $usuario['id_usuario']);
					$table_instituciones ='
					<table id="tListaDistribucionProductos" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Abreviaci&oacute;n</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Disponible</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
						</tr>
					</thead>
					<tbody id="tbodyProducto">
			        ';

			        if(isset($instituciones) && sizeof($instituciones) > 0)
					{								
						
				        foreach ($instituciones as $institucion){
							$table_instituciones .='<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$institucion['id_institucion'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$institucion['institucion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$institucion['abreviacion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$institucion['stock'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$institucion['dif_rest'].'</p></td>

						        <td class="text-center align-middle registro botonTabla">
					        		<a id="view_'.$institucion['id_institucion'].'" class="edit" type="link" href="'.base_url().'Producto/ingresosStockInstitucion/?idProducto='.$idProducto.'&idInstitucion='.$institucion['id_institucion'].'" data-id="'.$institucion['id_institucion'].'" data-nombre="'.$institucion['nombre'].'">
						        		<i data-feather="eye" data-toggle="tooltip" data-placement="top" title="bitacora"></i>
					        		</a>
					        	</td>

					    	</tr>';
				        }			  		
					}else
					{
						$table_instituciones .= '<tr>
								<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
							  </tr>';
					}

			        $table_instituciones .='
			        	</tbody>
			        </table>';

					$datos = array('table_instituciones' =>$table_instituciones);
				}
		        echo json_encode($datos);
			}else{
				$idProducto = "null";
				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1")
				{
					$idProducto = $this->input->get('idProducto');
					$usuario['idProducto'] = $idProducto;
				}

				$instituciones = $this->producto_model->listarDistribucion($idProducto, $usuario['id_usuario']);

				mysqli_next_result($this->db->conn_id);
				$productos = $this->producto_model->listarProductos();
				$usuario['productos'] = $productos;
				//var_dump($instituciones);
				$usuario['instituciones'] = $instituciones;
				$usuario['controller'] = 'producto';
				$usuario['idProducto'] = $idProducto;
				//var_dump($campanias);
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarDistribucion', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}


	public function listarDistribucionInstitucion()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){
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
				$idProducto = "null";
				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1")
				{
					$idProducto = $this->input->get('idProducto');
					$usuario['idProducto'] = $idProducto;
				}

				$idInstitucion = "null";
				if(!is_null($this->input->get('idInstitucion')) && $this->input->get('idInstitucion') != "-1")
				{
					$idInstitucion = $this->input->get('idInstitucion');
					$usuario['idInstitucion'] = $idInstitucion;
				}else
				{
					$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
					
					if($datos_usuario[0]["pf_analista"] == "1")
						$idInstitucion = $datos_usuario[0]["id_institucion"];

					mysqli_next_result($this->db->conn_id);
				}

				$hospitales = $this->producto_model->listarDistribucionInstitucion($idProducto, $idInstitucion, $usuario['id_usuario']);
				//var_dump($hospitales);
				//var_dump($this->input->get());

				mysqli_next_result($this->db->conn_id);
				$productos = $this->producto_model->listarProductos();
				$usuario['productos'] = $productos;
				$usuario['hospitales'] = $hospitales;
				$usuario['controller'] = 'producto';
				$usuario['idProducto'] = $idProducto;

				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarDistribucionInstitucion', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}

	public function distribuirStockInstitucion()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$resultado = null;
				$cantidad = "null";
				$idProducto = "null";
				$idInstitucion = "null";
				$datos[] = array();
 				unset($datos[0]);

				if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1")
					$cantidad = $this->input->post('cantidad');

				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1")
					$idProducto = $this->input->post('idProducto');
				if (is_numeric($cantidad) && (int)$cantidad > 0) {

					$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
					
					if($datos_usuario[0]["pf_analista"] == "1"){
						$idInstitucion = $datos_usuario[0]["id_institucion"];
						mysqli_next_result($this->db->conn_id);
					}

					$cantidades = (int)$cantidad;
					for ($i=0; $i < $cantidades; $i++) {
						$idHospital = "null";
						$stock = "null";
						if (is_numeric($this->input->post('inputHospital'.$i)) && (floatval($this->input->post('inputHospital'.$i)) > 0))
							$idHospital = $this->input->post('inputHospital'.$i);

						if (is_numeric($this->input->post('inputStock'.$i)) && (floatval($this->input->post('inputStock'.$i)) > 0))
							$stock = $this->input->post('inputStock'.$i);

						if (is_numeric($stock))
						{
							$resultado = $this->producto_model->agregarDistribucionInstitucion("null", $idInstitucion, $idHospital, $stock, $idProducto, $usuario['id_usuario']);
							mysqli_next_result($this->db->conn_id);
						}
					}
				}

				if ($resultado && isset($resultado) && sizeof($resultado) > 0) {
					$id_distribucion = $resultado[0]['id_distribucion_institucion'];
					$datos['mensaje'] = 'Se han agregado exitosamente la distribucion de Stock.';
					$datos['resultado'] = 1;
					$datos['id_distribucion'] = $id_distribucion;

				}
				echo json_encode($datos);
			}else{
				$idProducto = "null";
				$idInstitucion = "null";

				$id_usuario = $this->session->userdata('id_usuario');

				if(!is_null($this->input->get('idInstitucion')) && $this->input->get('idInstitucion') != "-1" && trim($this->input->get('idInstitucion')) != ""){
					$idInstitucion = $this->input->get('idInstitucion');
					$usuario["idInstitucion"] = $idInstitucion;
				}

				
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				$es_hospital = false;
				if($datos_usuario[0]["pf_analista"] == "1"){
					$idInstitucion = $datos_usuario[0]["id_institucion"];
					$es_hospital = true;
				}
				
				mysqli_next_result($this->db->conn_id);

				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1" && trim($this->input->get('idProducto')) != ""){
					$idProducto = $this->input->get('idProducto');
					$usuario["idProducto"] = $idProducto;
					$resultado = $this->producto_model->obtenerProductoInstitucion($idProducto, $idInstitucion);
					$usuario['producto'] = $resultado[0];
					mysqli_next_result($this->db->conn_id);
				}
				
				
				
				$resultado = $this->producto_model->listarProductosDisponibles();
				$usuario['productos'] = $resultado;

				mysqli_next_result($this->db->conn_id);
				$hospitales =  $this->hospital_model->listarHospitalesUsuStock($id_usuario, $idInstitucion);
				$usuario["hospitales"] = $hospitales;
				$usuario['cantidad'] = sizeof($hospitales);
				$usuario['controller'] = 'producto';
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('distribuirStockInstitucion', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function distribuirStockHospital()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$resultado = null;
				$cantidad = "null";
				$idProducto = "null";
				$idInstitucion = 1;
				$datos[] = array();
 				unset($datos[0]);

				if(!is_null($this->input->post('cantidad')) && $this->input->post('cantidad') != "-1")
					$cantidad = $this->input->post('cantidad');

				if(!is_null($this->input->post('idProducto')) && $this->input->post('idProducto') != "-1")
					$idProducto = $this->input->post('idProducto');

				if (is_numeric($cantidad) && (int)$cantidad > 0) {
					$cantidades = (int)$cantidad;
					for ($i=0; $i < $cantidades; $i++) {
						$idHospital = "null";
						$stock = "null";
						if (is_numeric($this->input->post('inputHospital'.$i)) && (floatval($this->input->post('inputHospital'.$i)) > 0))
							$idHospital = $this->input->post('inputHospital'.$i);

						if (is_numeric($this->input->post('inputStock'.$i)) && (floatval($this->input->post('inputStock'.$i)) > 0))
							$stock = $this->input->post('inputStock'.$i);

						if (is_numeric($stock))
						{
							$resultado = $this->producto_model->agregarDistribucionInstitucion("null", $idInstitucion, $idHospital, $stock, $idProducto, $usuario['id_usuario']);
							mysqli_next_result($this->db->conn_id);
						}
					}
				}

				if ($resultado && isset($resultado) && sizeof($resultado) > 0) {
					$id_distribucion = $resultado[0]['id_distribucion'];
					$datos['mensaje'] = 'Se han agregado exitosamente la distribucion de Stock.';
					$datos['resultado'] = 1;
					$datos['id_distribucion'] = $id_distribucion;

				}
				echo json_encode($datos);
			}else{

				$idProducto = "null";

				$id_usuario = $this->session->userdata('id_usuario');

				if(!is_null($this->input->get('idProducto')) && $this->input->get('idProducto') != "-1" && trim($this->input->get('idProducto')) != ""){
					$idProducto = $this->input->get('idProducto');
					$usuario["idProducto"] = $idProducto;

					$resultado = $this->producto_model->obtenerProducto($idProducto);
					$usuario['producto'] = $resultado[0];
					mysqli_next_result($this->db->conn_id);
				}
				
				$usuario['controller'] = 'producto';

				
				$resultado = $this->producto_model->listarProductosDisponibles();
				$usuario['productos'] = $resultado;

				mysqli_next_result($this->db->conn_id);
				$instituciones =  $this->institucion_model->listarInstitucionesUsuAPS($id_usuario);
				$usuario["instituciones"] = $instituciones;
				$usuario['cantidad'] = sizeof($instituciones);
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('distribuirStock', $usuario);
				$this->load->view('temp/footer');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function recepcionStock()
	{
		$usuario = $this->session->userdata();
		if($this->session->has_userdata('id_usuario')){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = "null";
				$estado = "null";
				$numOrden = "null";
				$cantRecepcion = "null";
				$tipoDoc = "null";
				$archivo = "null";
				$observacion = "null";

				if (is_numeric($this->input->post('id')) && (floatval($this->input->post('id')) > 0))
					$id = $this->input->post('id');

				if(!is_null($this->input->post('estado')) && $this->input->post('estado') != "-1")
					$estado = $this->input->post('estado');

				if(!is_null($this->input->post('numOrden')) && $this->input->post('numOrden') != "")
					$numOrden = $this->input->post('numOrden');

				if(!is_null($this->input->post('cantRecepcion')) && $this->input->post('cantRecepcion') != "-1")
					$cantRecepcion = $this->input->post('cantRecepcion');

				if(!is_null($this->input->post('tipoDoc')) && $this->input->post('tipoDoc') != "-1" && $this->input->post('tipoDoc') != "")
					$tipoDoc = $this->input->post('tipoDoc');

				if(!is_null($this->input->post('archivo')) && $this->input->post('archivo') != "-1" && $this->input->post('archivo') != "")
					$archivo = $this->input->post('archivo');

				if(!is_null($this->input->post('observacion')) && $this->input->post('observacion') != "-1" && $this->input->post('observacion') != "")
					$observacion = $this->input->post('observacion');

				$resultado = $this->producto_model->recepcionStock($id, $cantRecepcion, $estado, $numOrden, $observacion, $tipoDoc, $usuario['id_usuario']);

				$idProducto = "null";
				$idInstitucion = "null";
				mysqli_next_result($this->db->conn_id);
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				$es_hospital = false;
				if($datos_usuario[0]["pf_analista"] == "1"){
					$idInstitucion = $datos_usuario[0]["id_institucion"];
					$es_hospital = true;
				}

				mysqli_next_result($this->db->conn_id);
				$productos = $this->producto_model->listarRecepcionesPendientes($idProducto, $idInstitucion, $usuario['id_usuario']);
				

				$table_productos ='
				<table id="tListaStockProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre Producto</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Unidad de Medida</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Ingresado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Recepcionado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">N&#176; Orden</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Tipo Documento</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Observaci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha Recepci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario Recepci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Estado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Recepcionar Stock</th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
		        ';

		        if(isset($productos) && sizeof($productos) > 0)
				{								
					foreach ($productos as $producto) {
						$table_productos .= '<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['id_distribucion'].'</p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['codigo'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['nombre'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['descripcion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['unidad_medida'].'</p></td>

						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['institucion'].'</p></td>

						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['stock'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['stock_recep'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['fecha'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['u_nombres'].' '.$producto['u_apellidos'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['num_orden'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['tipo_documento'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['observacion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['fecha_recepcion'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['u_nombres_recep'].' '.$producto['u_apellidos_recep'].'</p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">'.$producto['estado_recepcion'].'</p></td>
						        <td class="text-center align-middle registro botonTabla">
							        <a class="view_recepcion" href="#" id="recepcion_'.$producto['id_distribucion'].'" data-id="'.$producto['id_distribucion'].'" data-codigo="'.$producto['codigo'].'" data-nombre="'.$producto['nombre'].'" data-descripcion="'.$producto['descripcion'].'" data-unidad_medida="'.$producto['unidad_medida'].'" data-institucion="'.$producto['institucion'].'" data-stock="'.$producto['stock'].'" data-stock_recep="'.$producto['stock_recep'].'" data-fecha="'.$producto['fecha'].'" data-usuario="'.$producto['u_nombres'].' '.$producto['u_apellidos'].'" data-fecha="'.$producto['fecha'].'" data-num_orden="'.$producto['num_orden'].'" data-tipo_documento="'.$producto['tipo_documento'].'" data-observacion="'.$producto['observacion'].'" data-fecha_recepcion="'.$producto['fecha_recepcion'].'" data-usuario_recep="'.$producto['u_nombres_recep'].' '.$producto['u_apellidos_recep'].'" data-estado_recepcion="'.$producto['estado_recepcion'].'"
							        >
					        			<i data-feather="check-square" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
				        			</a>
					        	</td>
					    	</tr>';
						
					}
				}else
				{
					$table_productos .= '<tr>
							<td class="text-center" colspan="17">No se encuentran datos registrados.</td>
						  </tr>';
				}

		        $table_productos .='
		        	</tbody>
		        </table>';

				$datos = array('table_productos' =>$table_productos);
		        

		        echo json_encode($datos);

			}else{
				$idProducto = "null";
				$idInstitucion = "null";
				$datos_usuario = $this->usuario_model->obtenerUsuario($usuario["id_usuario"]);
				$es_hospital = false;
				if($datos_usuario[0]["pf_analista"] == "1"){
					$idInstitucion = $datos_usuario[0]["id_institucion"];
					$es_hospital = true;
				}

				mysqli_next_result($this->db->conn_id);
				$productos = $this->producto_model->listarRecepcionesPendientes($idProducto, $idInstitucion, $usuario['id_usuario']);
				
				$usuario['es_hospital'] = $es_hospital;
				$usuario['productos'] = $productos;
				$usuario['controller'] = 'producto';
				
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('recepcionStock', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}
	}

}
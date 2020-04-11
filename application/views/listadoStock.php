<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Stock Productos
			</h3>
		</div>
	</div>
	<div id="agregarStockProducto" class="col-sm-6 text-right">
		<a href="agregarStock" class="btn btn-link"><i stop-color data-feather="plus"></i>Agregar Stock Producto</a>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaStockProductos">
			<table id="tListaStockProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Unidad de Medida</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Total</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Restante</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
			        <?php 
			        if(isset($productos))
			        {
				        foreach ($productos as $producto): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['id_producto']; ?></p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['codigo']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['unidad_medida']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['stock']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['dif_rest']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla">
						        	<a id="trash_<?php echo $producto['id_producto']; ?>" class="trash" href="#" data-id="<?php echo $producto['id_producto']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-toggle="modal" data-target="#modalEliminarProducto">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_<?php echo $producto['id_producto']; ?>" class="edit" type="link" href="ModificarProducto/?idProducto=<?php echo $producto['id_producto']; ?>" data-id="<?php echo $producto['id_producto']; ?>" data-nombre="<?php echo $producto['nombre']; ?>">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        		<!--<a id="view_<?php echo $producto['id_producto']; ?>" class="view" href="#">
						        		<i data-feather="search"  data-toggle="tooltip" data-placement="top" title="ver"></i>
					        		</a>-->
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}?>
			  </tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensajeProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p id="parrafoMP"></p>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalEliminarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<i class="plusTituloError mb-2" data-feather="trash-2"></i>
	        <h5 class="modal-title" id="tituloEP" name="tituloEP" data-idproducto="" data-nombreproducto="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoEP"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
	        <button id="eliminarProducto" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>

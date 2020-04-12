<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="list" ></i> Ingresos de Stock de Producto
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
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Ingresado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
					</tr>
				</thead>
				<tbody id="tbodyProducto">
			        <?php 
			        if(isset($productos))
			        {
				        foreach ($productos as $producto): ?>

				        	<?php if ($producto['nombre'] == "Total") {
			        		?>
								<tr>
							        <th scope="row" class="text-center align-middle registro" colspan="5">
							        	<p class="texto-pequenio"><?php echo $producto['nombre']; ?></p>
							        </th>
							        <th class="text-center align-middle registro" colspan="3">
							        	<p class="texto-pequenio"><?php echo $producto['stock']; ?></p>
							        </th>
						    	</tr>
							<?php	
							}else
							{?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['id_producto']; ?></p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['codigo']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['unidad_medida']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['stock']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['u_nombres'].' '.$producto['u_apellidos']; ?></p></td>
					    	</tr>
					    <?php } ?>
				  		<?php endforeach;
			  		}?>
			  </tbody>
			</table>
		</div>
	</div>
	<div id="botones" class="row mt-3 mb-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Producto/listadoStock">Volver</a>
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

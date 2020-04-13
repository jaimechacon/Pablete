<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Distribuci&oacute;n de Productos
			</h3>
		</div>
	</div>
	<div id="agregarDistribucionProducto" class="col-sm-6 text-right">
		<a href="<?php echo base_url().'Producto/distribuirStock'; ?>" class="btn btn-link"><i stop-color data-feather="plus"></i>Agregar Distribuci&oacute;n Producto</a>
	</div>
</div>
<div class="row pt-3 pl-3">
		<div class="form-group col-sm-6 pt-3">
			<label for="idProductoLD">Producto</label>
			<select id="idProductoLD" name="idProductoLD" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Producto">
		<?php
			if(isset($productos)) {
				foreach ($productos as $producto) {
					if(isset($idProducto) && (int)$producto['id_producto'] == $idProducto)
                    {
                    	echo '<option value="'.$producto['id_producto'].'" selected>'.$producto['codigo'].' '.$producto['nombre'].'</option>';
                    }else
                    {
                            echo '<option value="'.$producto['id_producto'].'">'.$producto['codigo'].' '.$producto['nombre'].'</option>';
                    }
				}
			}?>
			</select>
		</div>
	</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaDistribucionProductos">
			<table id="tListaDistribucionProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Abreviaci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Restante</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
			        <?php 
			        if(isset($instituciones))
			        {
				        foreach ($instituciones as $institucion): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $institucion['id_institucion']; ?></p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $institucion['institucion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $institucion['abreviacion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $institucion['stock']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $institucion['dif_rest']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla">
					        		<a id="edit_'.$institucion['id_institucion'].'" class="edit" type="link" href="<?php echo base_url().'Producto/ingresosStock/?idProducto='.$idProducto; ?>" data-id="<?php echo $idProducto; ?>" data-nombre="<?php echo $institucion['nombre']; ?>">
						        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="revisar"></i>
					        		</a>
					        		<?php 
					        		if ($institucion['dif_rest'] != "0") {?>
					        			<a id="share_'.$institucion['id_institucion'].'" class="edit" type="link" href="<?php echo base_url().'Producto/distribuirStock'.(isset($idProducto) ? ('/?idProducto='.$idProducto) : ''); ?>" data-id="<?php echo $institucion['id_institucion']; ?>" data-nombre="<?php echo $institucion['nombre']; ?>">
						        		<i data-feather="share-2" data-toggle="tooltip" data-placement="top" title="distribuir"></i>
					        		</a>
					        		<?php
					        		}
					        		?>
					        	</td>
					    	</tr>
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
	        <h5 class="modal-title" id="tituloEP" name="tituloEP" data-idinstitucion="" data-nombreinstitucion="" ></h5>
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

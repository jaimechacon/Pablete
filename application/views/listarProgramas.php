<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Programas
			</h3>
		</div>
	</div>
	<div id="agregarPrograma" class="col-sm-6 text-right">
		<a href="AgregarPrograma" class="btn btn-link"><i stop-color data-feather="plus"></i>Agregar Programa</a>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaProgramas">
			<table id="tablaProgramas" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="text-center align-middle registro"># ID</th>
					    <th scope="col" class="text-center align-middle registro">Nombre</th>
					    <th scope="col" class="text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="text-center align-middle registro">Forma de Pago</th>
					    <th scope="col" class="text-center align-middle registro" style="width: 50px;"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
			        <?php 
			        if(isset($programas))
			        {
				        foreach ($programas as $programa): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><?php echo $programa['id_programa']; ?></th>
						        <td class="text-center align-middle registro"><?php echo $programa['nombre']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $programa['descripcion']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $programa['forma_pago']; ?></td>
						        <td class="text-right align-middle registro column_icon"  style="width: 50px;">
						        	<a id="trash_<?php echo $programa['id_programa']; ?>" class="trash" href="#" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>" data-toggle="modal" data-target="#modalEliminarPrograma">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_<?php echo $programa['id_programa']; ?>" class="edit" type="link" href="ModificarPrograma/?idPrograma=<?php echo $programa['id_programa']; ?>" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        		<!--<a id="view_<?php echo $programa['id_programa']; ?>" class="view" href="#">
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
<div class="modal fade" id="modalMensajePrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<div class="modal fade" id="modalEliminarPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<i class="plusTituloError mb-2" data-feather="trash-2"></i>
	        <h5 class="modal-title" id="tituloEP" name="tituloEP" data-idprograma="" data-nombreprograma="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoEP"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
	        <button id="eliminarPrograma" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>

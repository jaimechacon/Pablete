<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Presupuestos
			</h3>
		</div>
	</div>
	<div id="agregarPresupuesto" class="col-sm-6 text-right">
		<a href="asignarPresupuesto" class="btn btn-link"><i stop-color data-feather="plus" class="pb-1"></i>Asignar Presupuesto</a>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaPresupuestos">
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
			        <?php 
			        if(isset($presupuestos))
			        {
				        foreach ($presupuestos as $presupuesto): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['id_grupo_presupuesto']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto_6'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto_3'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto_5'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto_4'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest_6'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest_3'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest_5'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest_4'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo  DateTime::createFromFormat('Y-m-d', $presupuesto['fecha'])->format('d-m-Y'); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['u_nombres'].' '.$presupuesto['u_apellidos']; ?></p></td>
						        <!--<td class="text-center align-middle registro botonTabla paginate_button">
					        		<?php /*if(strlen(trim($presupuesto['ruta_archivo'])) > 1) { ?>
							        	<a id="view_<?php echo $presupuesto['id_grupo_presupuesto']; ?>" class="view pdfPresupuesto" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$presupuesto['ruta_archivo']?>">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="right" title="ver"></i>
						        		</a>
						        	<?php }*/ ?>
					        	</td>-->
					        	<td class="text-center align-middle registro botonTabla">
					        		<a id="edit_<?php echo $presupuesto['id_grupo_presupuesto']; ?>" class="edit" type="link" href="ModificarPresupuesto/?idPresupuesto=<?php echo $presupuesto['id_grupo_presupuesto']; ?>" data-id="<?php echo $presupuesto['id_grupo_presupuesto']; ?>" data-programa="<?php echo $presupuesto['programa']; ?>">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
						        	<a id="trash_<?php echo $presupuesto['id_grupo_presupuesto']; ?>" class="trash" href="#" data-id="<?php echo $presupuesto['id_grupo_presupuesto']; ?>" data-programa="<?php echo $presupuesto['programa']; ?>" data-toggle="modal" data-target="#modalEliminarPresupuesto" data-placement="left">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="left" title="eliminar"></i>       		
					        		</a>
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
<div class="modal fade" id="modalMensajePresupuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<div class="modal fade" id="modalEliminarPresupuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	        <button id="eliminarPresupuesto" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>
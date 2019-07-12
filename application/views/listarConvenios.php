<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Convenios
			</h3>
		</div>
	</div>
	<!--<div id="filtros" class="col-sm-6">
		<div class="mt-1 ml-1 row">
			<label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Buscar</label>
			<div class="col-sm-10">			 
			  <input type="text" class="form-control form-control-sm" id="buscarCampania" placeholder="Busque por ( Nombre, Descripci&oacute;n, Abreviaci&oacute;n )">
			</div>
		</div>
	</div>-->
	<div id="agregarCampania" class="col-sm-6 text-right">
		<a href="asignarConvenios" class="btn btn-link"><i stop-color data-feather="plus" class="pb-1"></i>Asignar Convenio</a>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaConvenios">
			<table id="tListaConvenios" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">N° de Resoluci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">Adjunto</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
				    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
					</tr>
				</thead>
				<tbody id="tbodyConvenios">
			        <?php 
			        if(isset($convenios))
			        {
				        foreach ($convenios as $convenio): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['id_convenio']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['codigo']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['institucion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['comuna']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['convenio'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<?php if(strlen(trim($convenio['ruta_archivo'])) > 1) { ?>
							        	<a id="view_<?php echo $convenio['id_convenio']; ?>" class="view pdfMarco" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$convenio['ruta_archivo']?>">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>
						        	<?php } ?>
					        	</td>
					        	<td class="text-center align-middle registro botonTabla">
						        	<a id="trash_<?php echo $convenio['id_convenio']; ?>" class="trash" href="#" data-id="<?php echo $convenio['id_convenio']; ?>" data-comuna="<?php echo $convenio['comuna']; ?>" data-toggle="modal" data-target="#modalEliminarConvenio">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
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
<div class="modal fade" id="modalMensajeConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<div class="modal fade" id="modalEliminarConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	        <button id="eliminarConvenio" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>


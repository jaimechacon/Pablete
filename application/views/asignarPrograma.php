<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Programas
			</h3>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarMarco" class="" id="agregarMarco" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-5 pt-3">
			<label for="inputPrograma">Programa</label>
			<input type="text" class="form-control" id="idPrograma" minlength="1" placeholder="Seleccione un Programa" name="idPrograma" value="" hidden>
			<input type="text" class="form-control" id="inputPrograma" minlength="1" placeholder="Seleccione un Programa" name="inputPrograma" disabled>
			<!--<select id="idPrograma" class="custom-select custom-select-sm">
				<option value="-1">Seleccione un Programa</option>
				<?php
				/*if($programas)
				{
					foreach ($programas as $programa) {
						echo '<option value="'.$programa['id_programa'].'">'.$programa['nombre'].'</option>';
					}
				}*/
				?>
			</select>-->
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarPrograma" class="btn btn-link" type="button" id="btnBuscarPrograma"  data-toggle="modal" data-target="#modalBuscarPrograma" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Programa"></i>
					</button>
				</div>
			</div>
		</div>


		<div class="form-group col-sm-6 pt-3">
			<label for="idSubtitulo">Subtitulo</label>
			<select id="selectSubtitulos" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Subtitulo">
			  <?php
				if($cuentas)
				{
					foreach ($cuentas as $cuenta) {
						echo '<option value="'.$cuenta['id_cuenta'].'">'.$cuenta['nombre'].'</option>';
					}
				}
				?>
			</select>
			<!--
			<select id="idSubtitulo" class="custom-select">
				<option value="-1">Seleccione un Subtitulo</option>
				<?php
				/*if($cuentas)
				{
					foreach ($cuentas as $cuenta) {
						echo '<option value="'.$cuenta['id_cuenta'].'">'.$cuenta['nombre'].'</option>';
					}
				}*/
				?>
			</select>-->
		</div>

		<!--<div class="form-group col-sm-6 p-3">
			<label for="idInstitucion">Instituciones</label>

			<select id="selectInstituciones" class="selectpicker form-control" multiple data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Institucion" data-selected-text-format="count">
			  <?php
				/*if($instituciones)
				{
					foreach ($instituciones as $institucion) {
						echo '<option value="'.$institucion['id_institucion'].'">'.$institucion['nombre'].'</option>';
					}
				}*/
				?>
			</select>-->


	<!--		<select id="idInstitucion" class="custom-select custom-select-sm">
				<option value="-1">Seleccione una Institucion</option>
				<?php
				/*if($instituciones)
				{
					foreach ($instituciones as $institucion) {
						echo '<option value="'.$institucion['id_institucion'].'">'.$institucion['nombre'].'</option>';
					}
				}*/
				?>
			</select>-->
		<!--</div>-->
	</div>
	<div class="row pt-2 pl-3 ">
		<div class="form-group col-sm-6">
			<label for="idInstitucion">Institucion</label>
			<select id="idInstitucion" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Institucion">
			  <?php
				if($instituciones)
				{
					foreach ($instituciones as $institucion) {
						echo '<option value="'.$institucion['id_institucion'].'">'.$institucion['nombre'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="form-group col-sm-6">
			<label for="inputMarco">Marco Presupuestario</label>
			<input type="number" class="form-control" id="inputMarco" minlength="1" placeholder="Ingrese un Marco Presupuestario" name="inputMarco" />
		</div>		
	</div>
	<div class="row pt-2 pl-3 ">
		<div class="form-group col-sm-6 ">
			<label for="exampleFormControlFile1">Subir Documento</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoMarco" name="archivoMarco">
				<label class="custom-file-label" for="validatedCustomFile" id="lArchivoMarco">Seleccionar un Archivo...</label>
			</div>
	  	</div>
  	</div>
	<div id="botones" class="row mt-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Programa/ListarMarcos">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnAgregarMarco"  type="submit" class="btn btn-primary">Agregar Marco</button>
		</div>
	</div>
</form>

<!--<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaProgramas">
			<table id="tListaAsignaciones" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Forma de Pago</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
			        <?php 
			        /*if(isset($programas))
			        {
				        foreach ($programas as $programa): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['id_programa']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['forma_pago']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla">
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
			  		}*/?>
			  </tbody>
			</table>
		</div>
	</div>
</div>-->

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Programa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionPrograma">
			<table id="tListaProgramas" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Forma de Pago</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
			        <?php 
			        if(isset($programas))
			        {
				        foreach ($programas as $programa): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['id_programa']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['forma_pago']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<button href="#" aria-controls="tListaProgramas" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPrograma">Seleccionar</button>
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}?>
			  </tbody>
			</table>
		</div>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalMensajeMarco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="tituloM" name="tituloM" data-idprograma="" data-nombreprograma="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoM"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>

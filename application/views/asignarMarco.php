<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Marco Presupuestario
			</h3>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarMarco" class="" id="agregarMarco" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-5 pt-3">
			<label for="inputPresupuesto">Presupuesto</label>
			<input type="text" class="form-control" id="idPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="idPresupuesto" value="" data-restante="" hidden>
			<input type="text" class="form-control" id="inputPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="inputPresupuesto" disabled>
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarPresupuesto" class="btn btn-link" type="button" id="btnBuscarPresupuesto"  data-toggle="modal" data-target="#modalBuscarPresupuesto" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Presupuesto"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-6 mt-3">
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
	</div>
	<div class="row pt-2 pl-3 ">
		<div class="form-group col-sm-6">
			<label for="idDependencia">Dependencia</label>
			<select id="idDependencia" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Dependencia">
			  <?php
				if($dependencias)
				{
					foreach ($dependencias as $dependencia) {
						echo '<option value="'.$dependencia['id_dependencia'].'">'.$dependencia['clasificacion'].'</option>';
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

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarPresupuesto" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Presupuesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionPresupuesto">
			<table id="tListaPresupuestos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Presupuesto</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPresupuestos">
					<?php 
			        if(isset($presupuestos))
			        {
				        foreach ($presupuestos as $presupuesto): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['id_presupuesto']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['codigo_cuenta'].' '.$presupuesto['cuenta']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['u_nombres'].' '.$presupuesto['u_apellidos']; ?></p></td>						        
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<button href="#" aria-controls="tListaPresupuestos" data-id="<?php echo $presupuesto['id_presupuesto']; ?>" data-programa="<?php echo $presupuesto['programa']; ?>" data-presupuesto="<?php echo $presupuesto['presupuesto']; ?>" data-restante="<?php echo $presupuesto['dif_rest']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPresupuesto">Seleccionar</button>
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

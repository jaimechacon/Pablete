<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Convenios
			</h3>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarConvenio" class="" id="agregarConvenio" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-6 pt-3">
			<label for="inputResolucion">N° Resoluci&oacute;n</label>
			<input type="number" class="form-control" id="inputResolucion" name="inputResolucion" minlength="1" placeholder="Ingrese un Resoluci&oacute;n" />
		</div>
		<?php
			if(isset($instituciones))
			{?>
			<div class="form-group col-sm-6  pt-3">
				<label for="idInstitucionC">Institucion</label>
				<select id="idInstitucionC" name="idInstitucionC" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Institucion">
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
		<?php 
			}?>
		<div class="form-group col-sm-5 pt-3">
			<label for="inputMarco">Marco</label>
			<input type="text" class="form-control" id="idMarco" minlength="1" placeholder="Seleccione un Marco" name="idMarco" value="" hidden>
			<input type="text" class="form-control" id="inputMarco" minlength="1" placeholder="Seleccione un Marco" name="inputMarco" readonly>
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarMarco" class="btn btn-link" type="button" id="btnBuscarMarco"  data-toggle="modal" data-target="#modalBuscarMarco" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Marco"></i>
					</button>
				</div>
			</div>
		</div>


		<div class="form-group col-sm-6 pt-3">
			<label id="lComunasHospitales" for="selectComunas">Comunas</label>
			<select id="selectComunas" name="selectComunas" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Comuna">
			  <?php
				if($comunas)
				{
					foreach ($comunas as $comuna) {
						echo '<option value="'.$comuna['id_comuna'].'">'.$comuna['nombre'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<!--<div id="dComponentes" class="form-group col-sm-6 pt-3" hidden>
			<label id="lComponentes" for="selectComponentes">Componentes</label>
			<select id="selectComponentes" name="selectComponentes" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Componente">
			  <?php
				/*if($componentes)
				{
					foreach ($componentes as $componente) {
						echo '<option value="'.$componente['id_programa'].'">'.$componente['nombre'].'</option>';
					}
				}*/
				?>
			</select>
		</div>-->
		<div class="form-group col-sm-6 <?php echo (isset($instituciones) ? 'pt-3' : '')?>">
			<label for="inputConvenio">Convenio</label>
			<input type="number" class="form-control" id="inputConvenio" minlength="1" placeholder="Ingrese un Convenio" name="inputConvenio" />
		</div>
		<div class="form-group col-sm-6  <?php echo (isset($instituciones) ? 'pt-3' : '')?>">
			<label for="exampleFormControlFile1">Archivo de Resoluci&oacute;n de Convenio</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoConvenio" name="archivoConvenio" lang="es">
				<label class="custom-file-label" for="archivoConvenio" data-browse="Elegir" id="lArchivoConvenio">Seleccionar un Archivo...</label>
			</div>
	  	</div>
  	</div>
	<div id="botones" class="row mt-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Programa/listarConvenios">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnAgregarMarco"  type="submit" class="btn btn-primary">Agregar Convenio</button>
		</div>
	</div>
</form>

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarMarco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Marco</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionMarco">
			<table id="tListaProgramas" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Clasificación</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
			        <?php 
			        if(isset($marcos))
			        {
				        foreach ($marcos as $marco): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['id_marco']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['institucion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['codigo_cuenta'].' '.$marco['cuenta']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['clasificacion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($marco['marco'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($marco['dif_rest'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $marco['u_nombres'].' '.$marco['u_apellidos']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<button href="#" aria-controls="tListaMarcos" data-id="<?php echo $marco['id_marco']; ?>" data-nombre="<?php echo '$ '.number_format($marco['dif_rest'], 0, ",", ".").' restantes de '.$marco['programa']; ?>" data-restante="<?php echo $marco['dif_rest']; ?>" data-clasificacion="<?php echo $marco['clasificacion']; ?>" data-institucion="<?php echo $marco['id_institucion']; ?>" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>
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
	<div class="modal fade" id="modalMensajeConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

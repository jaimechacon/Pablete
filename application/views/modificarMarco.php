<?php
	$id_usuario=$this->session->userdata('id_usuario');
	
	if(!$id_usuario){
	  redirect('Login');
	}
	//var_dump(implode(",", $eacsEquipo));
?>
<div class="row">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="plus" ></i>Modificar Marco
			</h3>
		</div>
	</div>
	<div class="col-sm-12">
		<div id="filtros" class="mt-3 mr-3 ml-3">
			<form id="modificarMarco" action="modificarMarco" method="POST">
				<div class="row">
					<input type="text" class="form-control form-control-sm" id="inputIdMarco" name="inputIdMarco" value="<?php if(isset($marco['id_marco'])): echo $marco['id_marco']; endif; ?>" hidden>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputPresupuesto">Presupuesto</label>
						<input type="text" class="form-control  form-control-sm" id="inputPresupuesto" minlength="1" placeholder="" name="inputPresupuesto" value="<?php if(isset($marco['programa'])): echo $marco['programa'].' - '. $marco['dif_rest']; endif; ?>" readonly disabled>
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
				</div>
				<div class="row">

					<div class="form-group col-sm-5">
						<label for="inputNombre">Nombre Documento</label>
						<input type="text" class="form-control  form-control-sm" id="inputNombreArchivo" minlength="1" placeholder="" name="inputNombreArchivo" value="<?php if(isset($marco['nombre_archivo'])): echo $marco['nombre_archivo']; endif; ?>" readonly disabled>
					</div>
					<div class="col-sm-1 mt-4">
						<div class="row">
							<div class="col-sm-3 p-2">
								<a id="view_'<?php echo $marco['id_grupo_marco']; ?>" class="view pdfMarco" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$marco['ruta_archivo']; ?>">
							        <i stop-color data-feather="search" class="mb-2" data-toggle="tooltip" data-placement="top" title="Visualizar archivo"></i>		
				        		</a>
								<!--<button href="VerArchivo" class="btn btn-link" type="button" id="btnVerArchivo" style="padding-top: 7px;">
								</button>-->
							</div>
						</div>
					</div>

					<div class="form-group col-sm-6">
						<label for="archivoMarco">Subir Documento</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="archivoMarco" name="archivoMarco">
							<label class="custom-file-label" for="validatedCustomFile" id="lArchivoMarco">Seleccionar un nuevo Archivo...</label>
						</div>
				  	</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputPresupuesto">Institucion</label>
						<input type="text" class="form-control  form-control-sm" id="inputInstitucion" minlength="1" placeholder="" name="inputInstitucion" value="<?php if(isset($marco['institucion'])): echo $marco['institucion']; endif; ?>" readonly disabled>
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
					<div class="form-group col-sm-6">
						<label for="inputPresupuesto">Marco Presupuestario</label>
						<input type="text" class="form-control  form-control-sm" id="inputMarcoInstitucion" minlength="1" placeholder="Ingrese un Marco para la instituci&oacute;n <?php if(isset($marco['institucion'])): echo $marco['institucion']; endif; ?>" name="inputMarcoInstitucion" value="<?php if(isset($marco['marco'])): echo $marco['marco']; endif; ?>">
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
				</div>

				<div id="botones" class="row mt-3">
					<div class="col-sm-6 text-left">
						<a class="btn btn-link"  href="<?php echo base_url();?>Programa/ListarMarcos">Volver</a>
					</div>
					<div  class="col-sm-6 text-right">
					 	<button type="submit" class="btn btn-primary submit">Modificar</button>
					</div>
				</div>
			</form>		
		</div>
	</div>
</div>

<div id="loader" class="loader" hidden></div>

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
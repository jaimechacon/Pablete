<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Modificar Marco Presupuestario
			</h3>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Programa:</p>
							</div>
							<div class="col-sm-9">
								<h5><?php echo $marco[0]['programa']; ?></h5>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Subtitulo:</span>
							</div>
							<div class="col-sm-9">
								<h5><?php echo $marco[0]['codigo_cuenta'].' '.$marco[0]['cuenta']; ?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Presupuesto Restante:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="monto_restante" data-monto-restante="<?php echo $marco[0]['dif_rest']; ?>" data-monto-marco="<?php echo $marco[0]['asignacion']; ?>" class="text-success"><?php echo '$ '.number_format($marco[0]['dif_rest'], 0, ",", "."); ?></h3>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-12">
								<h5 id="mensajeError" class="text-danger"></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Marco Restante:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="monto_restante_marco" data-monto-restante="<?php echo $marco[0]['dif_rest_marco']; ?>" data-monto-marco="" class="text-success"><?php echo '$ '.number_format($marco[0]['dif_rest_marco'], 0, ",", "."); ?></h3>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-12">
								<h5 id="mensajeErrorMarco" class="text-danger"></h5>
							</div>
						</div>
					</div>
				</div>



			</div>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="modificarMarco" class="" id="modificarMarco" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-6 pt-3">
			<label for="inputPresupuesto">Presupuesto</label>
			<input type="text" class="form-control" id="idPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="idPresupuesto" value="<?php if(isset($marco[0]['id_grupo_presupuesto'])): echo $marco[0]['id_grupo_presupuesto']; endif; ?>" data-restante="<?php if(isset($marco[0]['dif_rest'])): echo $marco[0]['dif_rest']; endif; ?>" hidden />
			<input type="text" class="form-control" id="inputPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="inputPresupuesto" value="<?php if(isset($marco[0]['programa'])): echo $marco[0]['programa'].' - '.$marco[0]['dif_rest']; endif; ?>" readonly />
			<input type="number" class="form-control form-control-sm marcos" id="cantidad" name="cantidad" value="<?php echo $cantidad;?>" hidden/>
			<input type="number" class="form-control form-control-sm marcos" id="subtitulo" name="subtitulo" value="<?php echo $marco[0]['id_cuenta']; ?>" hidden/>

			<input type="text" class="form-control" id="inputIdMarco" minlength="1" placeholder="Ingrese un Marco" name="inputIdMarco" value="<?php if(isset($marco[0]['id_grupo_marco'])): echo $marco[0]['id_grupo_marco']; endif; ?>" hidden />
		</div>

		<div class="form-group col-sm-6 pt-3">
			<label for="exampleFormControlFile1">Subir Documento</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoMarcoModificar" name="archivoMarcoModificar" />
				<label class="custom-file-label" for="validatedCustomFile" id="lArchivoMarco">Seleccionar un Archivo...</label>
			</div>
	  	</div>
	</div>
  


  	<div class="row pt-2 pl-3 ">

  		<?php
			if(isset($instituciones))
			{?>
			<div class="form-group col-sm-6  pt-3">
				<label for="idInstitucionM">Institucion</label>
				<select id="idInstitucionM" name="idInstitucionM" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Institucion">
				  <?php
					if($instituciones)
					{
						foreach ($instituciones as $institucion) {
							if ($marco[0]['id_institucion'] == $institucion['id_institucion']) {
								echo '<option value="'.$institucion['id_institucion'].'" selected readonly disabled>'.$institucion['nombre'].'</option>';
							}
						}
					}
					?>
				</select>
			</div>
			<div id="divPresupuestoInstitucion" class="form-group col-sm-6 pt-3">
				<label for="idInstitucionM">Presupuesto Instituci&oacute;n</label>
				<input type="number" class="form-control form-control-sm" data-id="" id="inputPresupuestoInstitucionMarco" minlength="1" placeholder="Ingrese un Presupuesto para la Instituci&oacute;n" name="inputPresupuestoInstitucionMarco" value="<?php if(isset($marco[0]['asignacion'])): echo $marco[0]['asignacion']; endif; ?>" />
			</div>
		<?php 
			}?>
	</div>
	<div id="divComunasHospitales" class="row pt-2 pl-3 ">
		<?php

			if(isset($hospitales) && !is_null($hospitales))
			{	
				$cant = 0;
				foreach ($hospitales as $hospital) {
				?>

			<div class="form-group col-sm-6">
				<input class="form-control form-control-sm" type="text" placeholder="<?php echo $hospital['nombre']; ?>" readonly disabled> 
			</div>
			<div class="form-group col-sm-6">
				<input type="number" class="form-control form-control-sm marcos_instituciones" data-id="<?php echo $hospital['id_hospital']; ?>" id="inputMarco<?php echo $cant; ?>" minlength="1" placeholder="Ingrese un Marco para <?php echo $hospital['nombre']; ?>" name="inputMarco<?php echo $cant; ?>" value="<?php 
					if(array_search($hospital['id_hospital'], array_column($marco, 'id_hospital')) >= 0 && is_numeric(array_search($hospital['id_hospital'], array_column($marco, 'id_hospital'))))
						{
							echo $marco[array_search($hospital['id_hospital'], array_column($marco, 'id_hospital'))]['marco'];
						}
				?>"/>
				<input type="text" class="form-control" id="inputHospital<?php echo $cant; ?>" name="inputHospital<?php echo $cant; ?>" value="<?php echo $hospital['id_hospital']; ?>" hidden />

				<input type="text" class="form-control" id="inputIdMarco<?php echo $cant; ?>" minlength="1" placeholder="Ingrese un Marco" name="inputIdMarco<?php echo $cant; ?>" value="<?php 
					if(array_search($hospital['id_hospital'], array_column($marco, 'id_hospital')) >= 0 && is_numeric(array_search($hospital['id_hospital'], array_column($marco, 'id_hospital'))))
						{
							echo $marco[array_search($hospital['id_hospital'], array_column($marco, 'id_hospital'))]['id_marco'];
						}
					?>" hidden />
			</div>
			<?php
					$cant++;
				}
			}else
			{
				if(isset($comunas) && !is_null($comunas))
				{
					$cant = 0;
					foreach ($comunas as $comuna) {?>
						<div class="form-group col-sm-6">
							<input class="form-control form-control-sm" type="text" placeholder="<?php echo $comuna['nombre']; ?>" readonly disabled> 
						</div>
						<div class="form-group col-sm-6">
							<input type="number" class="form-control form-control-sm marcos_instituciones" data-id="<?php echo $comuna['id_comunas']; ?>" id="inputMarco<?php echo $cant; ?>" minlength="1" placeholder="Ingrese un Marco para <?php echo $comuna['nombre']; ?>" marco="inputMarco<?php echo $cant; ?>" value="<?php 
							if(array_search($comuna['id_comunas'], array_column($marco, 'id_comuna')) >= 0 && is_numeric(array_search($comuna['id_comunas'], array_column($marco, 'id_comuna'))))
								{
									echo $marco[array_search($comuna['id_comunas'], array_column($marco, 'id_comuna'))]['marco'];
								}
							?>" />
							<input type="text" class="form-control" id="inputComuna<?php echo $cant; ?>" name="inputComuna<?php echo $cant; ?>" value="<?php echo $comuna['id_comunas']; ?>" hidden />

							<input type="text" class="form-control" id="inputIdMarco<?php echo $cant; ?>" minlength="1" placeholder="Ingrese un Marco" name="inputIdMarco<?php echo $cant; ?>" value="<?php 
							if(array_search($comuna['id_comunas'], array_column($marco, 'id_comuna')) >= 0 && is_numeric(array_search($comuna['id_comunas'], array_column($marco, 'id_comuna'))))
								{
									echo $marco[array_search($comuna['id_comunas'], array_column($marco, 'id_comuna'))]['id_marco'];
								}
							?>" hidden />
						</div>
<?php
						$cant++;
					}
				}
			}
			?>
	</div>

	<!--</div>-->
	<hr class="my-3" hidden>
	<div class="row p-3" hidden>
		<div id="tArchivos" class="col-sm-12 p-3">
			<h3 class="mb-3">Hist&oacute;rico de Archivos </h3>
			<div class="table-responsive" id="tablaListaArchivosMarco">
				<table id="tListaArchivosMarco" class="table table-sm table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Ruta</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
						    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
						</tr>
					</thead>
					<tbody id="tbodyMarcos">
				        <?php 
				        if(isset($marcos))
				        {
					        foreach ($marcos as $marco): ?>
					  			<tr>
							        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $archivo['id_archivo']; ?></th>
							        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $archivo['nombre_original']; ?></p></td>
							        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $archivo['ruta']; ?></p></td>
							        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $archivo['fecha']; ?></p></td>
							        <td class="text-center align-middle registro botonTabla paginate_button">
						        		<?php if(strlen(trim($archivo['ruta'])) > 1) { ?>
								        	<a id="view_<?php echo $archivo['id_archivo']; ?>" class="view pdfMarco" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$archivo['ruta']?>">
								        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
							        		</a>
							        	<?php } ?>
						        	</td>
						    	</tr>
					  		<?php endforeach;
				  		}?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>


	<div id="botones" class="row mt-3 mb-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Programa/ListarMarcos">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnModificarMarco"  type="submit" class="btn btn-primary">Modificar Marco</button>
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
							//var_dump($presupuestos);
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
							        		<button href="#" aria-controls="tListaPresupuestos" data-id="<?php echo $marco[0]['id_presupuesto']; ?>" data-programa="<?php echo $marco[0]['programa']; ?>" data-presupuesto="<?php echo $marco[0]['presupuesto']; ?>" data-restante="<?php echo $marco[0]['dif_rest']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPresupuesto">Seleccionar</button>
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
	<div class="modal fade" id="modalMensajeModificarMarco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="tituloMM" name="tituloMM" data-idprograma="" data-nombreprograma="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoMM"></p>
	      </div>
	      <div class="modal-footer">
	        <button id="cerrarMM" type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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
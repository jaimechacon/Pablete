<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Convenio Sin Distribuci&oacute;n
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
								<h5 id="programa_presupuesto"></h5>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Subtitulo:</span>
							</div>
							<div class="col-sm-9">
								<h5  id="cuenta_presupuesto"></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Marco Disponible:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="monto_disponible" data-monto-restante="" data-monto-marco="" class="text-success"></h3>
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
								<h3 id="monto_restante" data-monto-restante="" data-monto-marco="" class="text-success"></h3>
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
				<div class="row ml-2">
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Instituci&oacute;n:</span>
							</div>
							<div class="col-sm-9">
								<h5  id="institucionD"></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarMarcoD" class="" id="agregarMarcoD" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-5 pt-3">
			<label for="inputMarcoD">Marco</label>
			<input type="text" class="form-control" id="idMarcoD" minlength="1" placeholder="Seleccione un Marco" name="idMarcoD" value="" hidden>
			<input type="text" class="form-control" id="inputMarcoD" minlength="1" placeholder="Seleccione un Marco" name="inputMarcoD" readonly>
			<input type="number" class="form-control form-control-sm marcos" id="cantidad" name="cantidad" value="" hidden/>
			<input type="number" class="form-control form-control-sm marcos" id="subtitulo" name="subtitulo" value="" hidden/>
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarMarcoD" class="btn btn-link" type="button" id="btnBuscarMarcoD" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Marco"></i>
					</button>
				</div>
			</div>
		</div>
		
		<!--<div class="form-group col-sm-6 pt-3">
			<label for="exampleFormControlFile1">Subir Documento</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoMarcoAsignar" name="archivoMarcoAsignar">
				<label class="custom-file-label" for="validatedCustomFile" id="lArchivoMarco">Seleccionar un Archivo...</label>
			</div>
	  	</div>-->
	</div>


  	<!--<<div class="row pt-2 pl-3 ">

  		<?php
			if(isset($instituciones))
			{?>
			<div class="form-group col-sm-6  pt-3">
				<label for="idInstitucionM">Institucion</label>
				<select id="idInstitucionM" name="idInstitucionM" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione una Institucion">
				  <?php
					/*if($instituciones)
					{
						foreach ($instituciones as $institucion) {
							echo '<option value="'.$institucion['id_institucion'].'">'.$institucion['nombre'].'</option>';
						}
					}*/
					?>
				</select>
			</div>
		<?php 
			}?>

			<div id="divPresupuestoInstitucion" class="form-group col-sm-6 pt-3">
				<label for="idInstitucionM">Presupuesto Instituci&oacute;n</label>
				<input type="number" class="form-control form-control-sm" data-id="" id="inputPresupuestoInstitucion" minlength="1" placeholder="Ingrese un Presupuesto para la Instituci&oacute;n" name="inputPresupuestoInstitucion" />
			</div>
	</div>-->

	<div id="divComunasHospitalesD" class="row pt-2 pl-3 pr-3">
	</div>
	<div id="botones" class="row mt-3 mb-3">
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
			<!--<table id="tListaPresupuestos" class="table table-sm table-hover table-bordered">
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
			        /*if(isset($presupuestos))
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
					        		<button href="#" aria-controls="tListaPresupuestos" data-id="<?php echo $presupuesto['id_presupuesto']; ?>" data-programa="<?php echo $presupuesto['programa']; ?>" data-presupuesto="<?php echo $presupuesto['presupuesto']; ?>" data-restante="<?php echo $presupuesto['dif_rest']; ?>" data-codigo_cuenta="<?php echo $presupuesto['codigo_cuenta']; ?>" data-nombre_cuenta="<?php echo $presupuesto['cuenta']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPresupuesto">Seleccionar</button>
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}*/?>
			  </tbody>
			</table>-->
		</div>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
      		<table id="tListaMarcosUsuario" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro">#</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">PDF</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyMarcos">
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

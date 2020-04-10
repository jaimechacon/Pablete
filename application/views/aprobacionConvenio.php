<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Convenios Pendientes
			</h3>
		</div>
	<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Instituci&oacute;n</span>
							</div>
							<div class="col-sm-9">
								<select id="institucionMarco" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($instituciones)
									{
										foreach ($instituciones as $institucion) {
											if(isset($idInstitucion) && (int)$institucion['id_institucion'] == $idInstitucion)
	                                        {
	                                                echo '<option value="'.$institucion['id_institucion'].'" selected>'.$institucion['nombre'].'</option>';
	                                        }else
	                                        {
	                                                echo '<option value="'.$institucion['id_institucion'].'">'.$institucion['nombre'].'</option>';
	                                        }
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Programas</span>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="idProgramaMarco" minlength="1" placeholder="Seleccione un Programa" name="idProgramaMarco" value="" hidden>
								<input type="text" class="form-control" id="inputProgramaMarco" minlength="1" placeholder="Seleccione un Programa" name="inputProgramaMarco" readonly>
							</div>
							<div class="col-sm-1">
								<div class="row">
									<div class="col-sm-3">
										<button href="QuitarProgramaMarco" class="btn btn-link" type="button" id="btnQuitarProgramaMarco" style="padding-top: 6px;" hidden>
											<i stop-color data-feather="x" class="mb-2" data-toggle="tooltip" data-placement="top" title="Quitar Seleccion de Programa"></i>
										</button>
										<button href="SeleccionarProgramaMarco" class="btn btn-link" type="button" id="btnBuscarProgramaMarco"  data-toggle="modal" data-target="#modalBuscarProgramaMarco" style="padding-top: 6px;">
											<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Programa"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<!--<div id="filtros" class="col-sm-6">
		<div class="mt-1 ml-1 row">
			<label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Buscar</label>
			<div class="col-sm-10">			 
			  <input type="text" class="form-control form-control-sm" id="buscarCampania" placeholder="Busque por ( Nombre, Descripci&oacute;n, Abreviaci&oacute;n )">
			</div>
		</div>
	</div>
	<div id="agregarCampania" class="col-sm-12 pt-3 text-right">
		<a href="asignarMarco" class="btn btn-link"><i stop-color data-feather="plus" class="pb-1"></i>Asignar Marco</a>
	</div>-->
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaConveniosPendientes">
			<table id="tListaConveniosPendientes" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<!--<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">N° de Resoluci&oacute;n</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Hospital</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco Disponible</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Marco Restante</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">Adjunto</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">Revisar</th>-->
				    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
					<!--</tr>-->
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
						<th scope="col" class="texto-pequenio text-center align-middle registro">N° de Resoluci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Instituci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Establecimiento</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Estado</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">Adjunto</th>
				    	<th scope="col" class="texto-pequenio text-center align-middle registro">Revisar</th>
				    	<?php  /*if(isset($convenios))
				        {
				        	if (sizeof($convenios) > 0 && $convenios[0]['eliminar'] == "1") { */?>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					    	<?php //} 

					    //}
					    ?>
				    	<!--<th scope="col" class="texto-pequenio text-center align-middle registro"></th>-->
					</tr>
				</thead>
				<tbody id="tbodyConvenios">
			        <?php 
			        /*if(isset($convenios))
			        {
				        foreach ($convenios as $convenio): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['id_convenio']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['codigo']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['institucion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['codigo_hospital'].' '.$convenio['hospital']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['comuna']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['marco'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['dif_rest'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['convenio'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['dif_convenio'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<?php if(strlen(trim($convenio['ruta_archivo'])) > 1) { ?>
							        	<a id="view_<?php echo $convenio['id_convenio']; ?>" class="view pdfMarco" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$convenio['ruta_archivo']?>">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>
						        	<?php } ?>
					        	</td>
					        	<td class="text-center align-middle registro botonTabla">
						        	<a id="view_<?php echo $convenio['id_convenio']; ?>" class="view_convenio" href="#" data-id="<?php echo $convenio['id_convenio']; ?>" data-hospital="<?php echo $convenio['codigo_hospital'].' '.$convenio['hospital']; ?>" data-comuna="<?php echo $convenio['comuna']; ?>" data-codigo="<?php echo $convenio['codigo']; ?>" data-programa="<?php echo $convenio['programa']; ?>" data-institucion="<?php echo $convenio['codigo_institucion'].' '.$convenio['institucion']; ?>" data-fecha="<?php echo $convenio['fecha']; ?>" data-usuario="<?php echo $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']; ?>" data-marco="<?php echo $convenio['marco']; ?>" data-marco_disponible="<?php echo $convenio['dif_rest']; ?>" data-convenio="<?php echo $convenio['convenio']; ?>" data-marco_restante="<?php echo $convenio['dif_convenio']; ?>" data-pdf="<?php echo base_url().'assets/files/'.$convenio['ruta_archivo']?>" data-nombre_archivo="<?php echo $convenio['nombre_archivo']; ?>">
						        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
					        		</a>
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}*/ ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalRevisarConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Aprobación de Convenio #<span id="numConvenio"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			N° Resolución:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="resolucionRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Programa:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="programaRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Subtitulo:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="subtituloRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Institucion:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="institucionRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Establecimiento:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="hospitalRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Comuna:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="comunaRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Marco:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="marcoRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Marco Disponible:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="marcoDisponibleRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Convenio:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="convenioRevision" class="text-success"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Marco Restante:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="marcoRestanteRevision" class="text-warning"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Nombre Adjunto:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="nombreArchivoRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Archivo:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<a id="pdfConvenioRevision" class="view pdfConvenioRevision" href="#"  data-pdf="">
      				<span>Ver Archivo </span>
	        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
        		</a>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Observaciones:
      		</div>
      	</div>
      	<div class="row mt-2">
      		<div class="col-sm-12">
      			<textarea class="form-control" id="observacionesRevision" placeholder="Ingrese una observacion" rows="3"></textarea>
      		</div>
      	</div>
      	<div class="row mt-4">
      		<div class="col-sm-12 col-md-6 text-left">
      			<button id="btnRechazarConvenio" type="button" class="btn btn-danger">Rechazar Convenio</button>
      		</div>
      		<div class="col-sm-12 col-md-6 text-right">
      			<button id="btnAprobarConvenio" type="button" class="btn btn-success">Aprobar Convenio</button>
      		</div>
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


	<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarProgramaMarco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Programa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionProgramaMarco">
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
					        		<button href="#" aria-controls="tListaProgramas" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>" tabindex="0" class="btn btn-outline-dark seleccionProgramaMarco">Seleccionar</button>
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

<div id="loader" class="loader" hidden></div>
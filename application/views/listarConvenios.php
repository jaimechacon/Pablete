<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-7 mt-3">
				<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Convenios
				</h3>
			</div>
			<div class="col-sm-5 text-right">
				<button id="btnExportarExcelC" type="button" class="btn btn-link">Exportar a CSV con filtros
					<i data-feather="download"></i>
				</button>

				<button id="btnExportarTodoExcelC" type="button" class="btn btn-link">Exportar todo a CSV
					<i  data-feather="download"></i>
				</button>
			</div>
		</div>

	<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">
				<?php
					if(isset($instituciones))
					{?>			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Instituci&oacute;n</span>
							</div>
							<div class="col-sm-9">
								<select id="institucionConvenio" class="custom-select custom-select-sm">
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
					<?php 
					}?>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Programas</span>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" id="idProgramaConvenio" minlength="1" placeholder="Seleccione un Programa" name="idProgramaConvenio" value="" hidden>
								<input type="text" class="form-control form-control-sm" id="inputProgramaConvenio" minlength="1" placeholder="Seleccione un Programa" name="inputProgramaConvenio" readonly>
							</div>
							<div class="col-sm-1">
								<div class="row">
									<div class="col-sm-3">
										<button href="QuitarProgramaConvenio" class="btn btn-link" type="button" id="btnQuitarProgramaConvenio" style="padding-top: 6px;" hidden>
											<i stop-color data-feather="x" class="mb-2" data-toggle="tooltip" data-placement="top" title="Quitar Seleccion de Programa"></i>
										</button>
										<button href="SeleccionarProgramaConvenio" class="btn btn-link" type="button" id="btnBuscarProgramaConvenio"  data-toggle="modal" data-target="#modalBuscarProgramaConvenio" style="padding-top: 6px;">
											<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Programa"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Estado</span>
							</div>
							<div class="col-sm-9">
								<select id="estadoConvenio" class="custom-select custom-select-sm">
									<option value="1" selected>Aprobados</option>
									<option value="2">Rechazados</option>
									<option value="3">Pendiente de Aprobaci&oacute;n</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Fecha Desde</span>
							</div>
							<div class="col-sm-9">
								<input type="date" id="fechaDesde" name="fechaDesde" class="form-control form-control-sm">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Fecha Hasta</span>
							</div>
							<div class="col-sm-9">
								<input type="date" id="fechaHasta" name="fechaHasta" class="form-control form-control-sm">
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
	</div>-->
	<div id="agregarCampania" class="col-sm-12 text-right">
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
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Establecimiento</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Comuna</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Convenio</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Estado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha Resoluci&oacute;n</th>
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
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['institucion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['codigo_hospital'].' '.$convenio['hospital']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['comuna']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($convenio['convenio'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro">
						        <?php 
						        	echo ($convenio['id_estado_convenio'] == "1" ? '<span class="badge badge-pill badge-success">Aprobado</span>' : (($convenio['id_estado_convenio'] == "2" ? '<span class="badge badge-pill badge-danger">Rechazado</span>' : '<span class="badge badge-pill badge-warning">Pendiente de Aprobacion</span>')));
						        ?>
						    	</td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<?php if(strlen(trim($convenio['ruta_archivo'])) > 1) { ?>
							        	<a id="view_<?php echo $convenio['id_convenio']; ?>" class="view pdfMarco" href="#"  data-pdf="<?php echo base_url().'assets/files/'.$convenio['ruta_archivo']?>">
							        		<i data-feather="file-text" data-toggle="tooltip" data-placement="top" title="ver"></i>
						        		</a>
						        	<?php } ?>
					        	</td>
					        	<td class="text-center align-middle registro botonTabla">
						        	<a id="view_<?php echo $convenio['id_convenio']; ?>" class="view_convenio" href="#" data-id="<?php echo $convenio['id_convenio']; ?>" data-hospital="<?php echo $convenio['codigo_hospital'].' '.$convenio['hospital']; ?>" data-comuna="<?php echo $convenio['comuna']; ?>" data-codigo="<?php echo $convenio['codigo']; ?>" data-programa="<?php echo $convenio['programa']; ?>" data-institucion="<?php echo $convenio['codigo_institucion'].' '.$convenio['institucion']; ?>" data-fecha="<?php echo $convenio['fecha']; ?>" data-usuario="<?php echo $convenio['nombres_usu_convenio'].' '.$convenio['apellidos_usu_convenio']; ?>" data-marco="<?php echo $convenio['marco']; ?>" data-marco_disponible="<?php echo $convenio['dif_rest']; ?>" data-convenio="<?php echo $convenio['convenio']; ?>" data-marco_restante="<?php echo $convenio['dif_convenio']; ?>" data-pdf="<?php echo base_url().'assets/files/'.$convenio['ruta_archivo']?>" data-nombre_archivo="<?php echo $convenio['nombre_archivo']; ?>" data-fecha_revision="<?php echo $convenio['fecha_revision']; ?>" data-observacion_revision="<?php echo $convenio['observacion_revision']; ?>" data-id_estado_revision="<?php echo $convenio['id_estado_convenio']; ?>" data-usuario_revision="<?php echo $convenio['nombres_usu_revision'].' '.$convenio['apellidos_usu_revision']; ?>">
						        		<i data-feather="search" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
					        		</a>
					        	</td>
					        	<?php if (sizeof($convenios) > 0 && $convenios[0]['eliminar'] == "1") { ?>
						        	<td class="text-center align-middle registro botonTabla">
							        	<a id="trash_<?php echo $convenio['id_convenio']; ?>" class="trash" href="#" data-id="<?php echo $convenio['id_convenio']; ?>" data-comuna="<?php echo $convenio['comuna']; ?>" data-toggle="modal" data-target="#modalEliminarConvenio">
							        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>       		
						        		</a>
						        	</td>
					        	<?php } ?>
					    	</tr>
				  		<?php endforeach;
			  		} */?>
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

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarProgramaConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Programa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionProgramaConvenio">
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
					        		<button href="#" aria-controls="tListaProgramas" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>" tabindex="0" class="btn btn-outline-dark seleccionProgramaConvenio">Seleccionar</button>
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

<!-- Modal Mensaje -->
<div class="modal fade" id="modalRevisarConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
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
      	<div class="row" id="divMarcoRestante">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Marco Restante:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="marcoRestanteRevision" class="text-warning"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Fecha Resoluci&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="fechaResolucion"></span>
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
      			Fecha Revisi&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="fechaRevision"></span>
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
      			Usuario Revisi&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="usuarioRevision"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Estado Revisi&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="estadoRevision" class="badge badge-pill"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Observaciones:
      		</div>
      	</div>
      	<div class="row mt-2">
      		<div class="col-sm-12">
      			<span id="observacionRevision"></span>
      		</div>
      	</div>
      	<!--<div class="row mt-4">
      		<div class="col-sm-12 col-md-6 text-left">
      			<button id="btnRechazarConvenio" type="button" class="btn btn-danger">Rechazar Convenio</button>
      		</div>
      		<div class="col-sm-12 col-md-6 text-right">
      			<button id="btnAprobarConvenio" type="button" class="btn btn-success">Aprobar Convenio</button>
      		</div>
      	</div>-->

      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="loader" class="loader" hidden></div>
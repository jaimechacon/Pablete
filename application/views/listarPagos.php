<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-7">
				<h3>Listado de Pagos Realizados</h3>
			</div>
			<div class="col-sm-5 text-right">
				<button id="btnExportarExcel" type="button" class="btn btn-link">Exportar a CSV
					<i style="margin-bottom: 5px;" data-feather="download"></i>
				</button>

				<button id="btnExportarTodoExcel" type="button" class="btn btn-link">Exportar todo a CSV
					<i style="margin-bottom: 5px;" data-feather="download"></i>
				</button>
				<!--<img  id="imgExportarExcel" src="<?php //echo base_url();?>assets/img/icons/excel.png" width="30" class="d-inline-block align-top" alt="">-->
			</div>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3 text-right">
								<span class="">Instituci&oacute;n</span>
							</div>
							<div class="col-sm-9">
								<select id="institucionPago" class="custom-select custom-select-sm">
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
							<div class="col-sm-3 text-right">
								<span class="">Area</span>
							</div>
							<div class="col-sm-9">
								<select id="hospitalPago" class="custom-select custom-select-sm">
								    <option value="-1">Todos</option>
									<?php 
									if($hospitales)
									{
										foreach ($hospitales as $hospital) {
											if(isset($idHospital) && (int)$hospital['id_hospital'] == $idHospital)
											{
                                                echo '<option value="'.$hospital['id_hospital'].'" selected>'.$hospital['nombre'].'</option>';
	                                        }else
	                                        {
                                                echo '<option value="'.$hospital['id_hospital'].'">'.$hospital['nombre'].'</option>';
	                                        }
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<div class="row">			
					<div class="<?php echo (sizeof($principales) > 1) ? 'col-sm-3' : 'col-sm-6'; ?>">
						<div class="row">
							<div class="col-sm-3 text-right">
								<span class="">Mes</span>
							</div>
							<div class="col-sm-9">
								<select id="mesPago" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if(isset($meses))
									{
										foreach ($meses as $mes) {
											if(isset($mesSeleccionado) && (int)$mes['idMes'] == $mesSeleccionado)
	                                        {
                                                echo '<option value="'.$mes['idMes'].'" selected>'.$mes['nombreMes'].'</option>';
	                                        }else
	                                        {
                                                echo '<option value="'.$mes['idMes'].'">'.$mes['nombreMes'].'</option>';
	                                        }
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="<?php echo (sizeof($principales) > 1) ? 'col-sm-3' : 'col-sm-6'; ?>">
						<div class="row">
							<div class="col-sm-3 text-right">
								<span class="">A&ntilde;o</span>
							</div>
							<div class="col-sm-9">
								<select id="anioPago" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if(isset($anios))
									{
										foreach ($anios as $anio) {
											if(isset($anioSeleccionado) && (int)$anio['idAnio'] == $anioSeleccionado)
	                                        {
	                                            echo '<option value="'.$anio['idAnio'].'" selected>'.$anio['nombreAnio'].'</option>';
	                                        }else
	                                        {
	                                            echo '<option value="'.$anio['idAnio'].'">'.$anio['nombreAnio'].'</option>';
	                                        }
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<?php 
						if (sizeof($principales) > 1) {
					?>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3 text-right">
								<span class="">Proveedor</span>
							</div>
							<div class="col-sm-9">
								<select id="principalPago" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($principales)
									{
										foreach ($principales as $principal) {
											if(isset($idPrincipal) && (int)$principal['id_principal'] == $idPrincipal)
	                                        {
	                                                echo '<option value="'.$principal['id_principal'].'" selected>'.$principal['nombre'].'</option>';
	                                        }else
	                                        {
	                                                echo '<option value="'.$principal['id_principal'].'">'.$principal['nombre'].'</option>';
	                                        }
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
				<?php }?>
				</div>
			</div>
			<!--<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						
					</div>
				</div>
			</div>-->
			<div class="col-sm-12 pt-3">
				<div id="tablaReporteResumen" class="row">
					<div class="col-sm-12">
						<!--<nav aria-label="Page navigation example">
						  <ul class="pagination">
						    <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
						    <li class="page-item"><a class="page-link" href="#">1</a></li>
						    <li class="page-item"><a class="page-link" href="#">2</a></li>
						    <li class="page-item"><a class="page-link" href="#">3</a></li>
						    <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
						  </ul>
						</nav>-->
						 <?php //echo $this->pagination->create_links(); ?>

						  <?php //if (isset($links)) { ?>
                		  <?php //echo $links; }?>
						<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Area Transaccional</th>
									<th class="text-center texto-pequenio" scope="col">Folio</th>
									<th class="text-center texto-pequenio" scope="col" >Tipo Operacion</th>
									<th class="text-center texto-pequenio" scope="col" >Fecha Generaci&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col" >Cuenta Contable</th>
									<th class="text-center texto-pequenio" scope="col" >Tipo Documento</th>
									<th class="text-center texto-pequenio" scope="col" >Nro. Documento</th>
									<th class="text-center texto-pequenio" scope="col" >Fecha Cumplimiento</th>
									<th class="text-center texto-pequenio" scope="col" >Combinaci&oacute;n Catalogo</th>
									<th class="text-center texto-pequenio" scope="col" >Principal</th>
									<th class="text-center texto-pequenio" scope="col" >Principal Relacionado</th>
									<th class="text-center texto-pequenio" scope="col" >Beneficiario</th>
									<th class="text-center texto-pequenio" scope="col" >Banco</th>
									<th class="text-center texto-pequenio" scope="col" >Cta. Corriente</th>
									<th class="text-center texto-pequenio" scope="col" >Medio Pago</th>
									<th class="text-center texto-pequenio" scope="col" >Tipo Medio Pago</th>
									<th class="text-center texto-pequenio" scope="col" >Nro. Documento Pago</th>
									<th class="text-center texto-pequenio" scope="col" >Fecha Emisi&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col" >Estado Documento</th>
									<th class="text-center texto-pequenio" scope="col" >Monto</th>
									<th class="text-center texto-pequenio" scope="col" >Moneda</th>
									<th class="text-center texto-pequenio" scope="col" >Tipo Cambio</th>
								</tr>
							</thead>
							<tbody id="tbodyReporteResumen">
								<?php	
								if(isset($pagos) && !isset($pagos["resultado"]))
								{								
									foreach ($pagos as $pago) {
								
										echo '<tr>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_area_transaccional'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['folio'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['tipo_operacion'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['fecha_generacion'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['cta_contable'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_tipo_documento'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nro_documento'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['fecha_cumplimiento'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['combinacion_catalogo'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_principal'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_principal_relacionado'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_beneficiario'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_banco'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['cta_corriente_banco'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['medio_pago'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nombre_tipo_medio_pago'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['nro_documento_pago'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['fecha_emision'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['estado_documento'].'</p></td>
											<td class="text-right" ><p class="texto-pequenio">'.'$ '.number_format($pago['monto'], 0, ",", ".").'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['moneda'].'</p></td>
											<td class="text-left"><p class="texto-pequenio">'.$pago['tipo_cambio'].'</p></td>
											</tr>';
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
<!-- Modal Detalle -->
	<div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<i class="plusTituloError mb-2" data-feather="search"></i>
	        <h5 class="modal-title" id="titulo" name="titulo" data-idequipo="" data-nombreequipo="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafo"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Atras</button>
	        <!--<button id="eliminarEquipo" type="button" class="btn btn-danger">Eliminar</button>-->
	      </div>
	    </div>
	  </div>
	</div>
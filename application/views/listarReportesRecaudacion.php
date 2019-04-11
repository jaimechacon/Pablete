<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<h3>Indicadores</h3>
			</div>
		</div>
		<hr class="my-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Instituci&oacute;n</span>
							</div>
							<div class="col-sm-9">
								<select id="institucionR" class="custom-select custom-select-sm">
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
								<span class="">Area</span>
							</div>
							<div class="col-sm-9">
								<select id="hospitalR" class="custom-select custom-select-sm">
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
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Mes</span>
							</div>
							<div class="col-sm-9">
								<select id="mesR" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($meses)
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
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">A&ntilde;o</span>
							</div>
							<div class="col-sm-9">
								<select id="anioR" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($anios)
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
				</div>
			</div>
			<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						I. Recaudaci&oacute;n de Ingresos (Vista en M$)
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div id="tablaReporteResumen" class="row">
					<div class="col-sm-12">
						<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Mes</th>
									<th class="text-center texto-pequenio" scope="col">A&ntilde;o</th>
									<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 7 y 8 ( $ )</th>
									<th class="text-center texto-pequenio" scope="col">Devengado Subt. 7 y 8 ( $ )</th>
									<th class="text-center texto-pequenio" scope="col">Porcentaje 70 % Subt. 7 y 8</th>
									<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 7 y 8</th>
									<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 12 ( $ )</th>
									<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 12 a&ntilde;o anterior ( $ )</th>
									<th class="text-center texto-pequenio" scope="col">Porcentaje 30 % 12. 12</th>
									<th class="text-center texto-pequenio" scope="col">Puntuaci&oacute;n Subt. 12</th>
								</tr>
							</thead>
							<tbody id="tbodyReporteResumen">
								<?php	
								if(isset($reporteResumenes) && !isset($reporteResumenes["resultado"]))
								{								
									foreach ($reporteResumenes as $reporteResumen) {
											echo '<tr>
													<td class="text-center"><p class="texto-pequenio">'.ucwords($reporteResumen['mes']).'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['anio'].'</p></td>
													<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_70'], 4, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['devengado_70'], 4, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_70'], 4, ",", ".").' %</p></td>
													<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_70'].'</p></td>
													<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_actual'], 4, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">$ '.number_format($reporteResumen['recaudado_30_anio_anterior'], 4, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.number_format($reporteResumen['porcentaje_30'], 4, ",", ".").' %</p></td>
													<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['puntuacion_30'].'</p></td>
													</tr>';
													/*<td class="text-center botonTabla">
														<!--<button type="button botonTabla" class="btn btn-link redireccionarAsignacion botonTabla" data-id="'.$reporteResumen["id_item"].'"><i data-feather="search" class="trash"></i></button>
														<a href="'.base_url().'Reporte/listarReportesAsignacion/?idItem='.$reporteResumen['id_item'].'" title="click para ver detalle del item"><i data-feather="search" class="trash"></i></a>-->
													</td>
													</tr>';*/
									}
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-12">
						<div id="chartContainer" style="width: 100%;"></div>
					</div>
					<!--<div class="col-sm-12">
						<table id="tReporteResumenGasto" class="table table-hover table-bordered table-sm">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Gastos</th>
									<th class="text-center texto-pequenio" scope="col">Ppto. Vigente</th>
									<th id="idAnioGasto" class="text-center texto-pequenio" scope="col">G. Dev.
									<?php //echo (isset($anioSeleccionado) ? $anioSeleccionado : "" ); ?></th>
								</tr>
							</thead>
							<tbody id="tbodyReporteResumenGasto">

								<?php
									/*if(isset($reporteResumenesGastos) && !isset($reporteResumenesGastos["resultado"]))
									{
										foreach ($reporteResumenesGastos as $reporteResumenGasto) {
											if($reporteResumenGasto['nombre'] == "Total" )
										{
											echo '<tr>
													<th class=""><p class="texto-pequenio">'.$reporteResumenGasto['nombre'].'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.'----'.'</p></th>
													<th class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado'], 0, ",", ".").'</p></th>'.
													'</tr>';
											}else{
												echo '<tr>
													<td class=""><p class="texto-pequenio">'.($reporteResumenGasto['codigo']." ".$reporteResumenGasto['nombre']).'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.'----'.'</p></td>
													<td class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado'], 0, ",", ".").'</p></td>'.
													/*<td class="text-center botonTabla">
														<button type="button botonTabla" class="btn btn-link redireccionarAsignacion botonTabla" data-id="'.$reporteResumenGasto["id_item"].'"><i data-feather="search" class="trash"></i></button>
														<!--<a href="'.base_url().'Reporte/listarReportesAsignacion/?idItem='.$reporteResumenGasto['id_item'].'" title="click para ver detalle del item"><i data-feather="search" class="trash"></i></a>-->
													</td>*/
											/*		'</tr>';
											}
										}
									}*/
								?>
							</tbody>
						</table>
					</div>-->
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
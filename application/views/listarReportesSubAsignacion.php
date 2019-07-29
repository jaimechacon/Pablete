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
				<h3>Consolidado de Situación Financiera</h3>
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
								<select id="institucionSubAsignacion" class="custom-select custom-select-sm">
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
								<select id="hospitalSubAsignacion" class="custom-select custom-select-sm">
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
			<div class="col-sm-12 pt-3">
				<div class="row">			
					<div class="col-sm-12 text-left">
						<p id="asignacionSeleccion" data-id="<?php echo $asignacionSeleccion["id_asignacion"]; ?>" data-nombre="<?php echo $asignacionSeleccion["nombre"]; ?>" data-codigo="<?php echo $asignacionSeleccion["codigo"]; ?>" data-idCuenta="<?php echo $idCuenta; ?>" data-idItem="<?php echo $idItem; ?>">Asignacion Seleccionada: <?php echo $asignacionSeleccion["codigo"].' '.$asignacionSeleccion["nombre"]; ?></p>
					</div>
				</div>
			</div>
			<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						I. Equilibrio Financiero (Vista en M$)
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div id="tablaReporteResumen" class="row">
					<div class="col-sm-12">
						<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Ingresos</th>
									<th class="text-center texto-pequenio" scope="col">Ppto. Vigente</th>
									<th class="text-center texto-pequenio" scope="col" >I. Rec. 2019</th>
									<th class="text-center texto-pequenio" scope="col">Ejec. %</th>
									<th class="text-center texto-pequenio" scope="col">I. Rec. 2018</th>
									<th class="text-center texto-pequenio" scope="col">Var 18-17</th>
									<th class="text-center texto-pequenio" scope="col">Det.</th>
								</tr>
							</thead>
							<tbody id="tbodyReporteResumen">

								<?php	
								if(isset($reporteResumenes) && !isset($reporteResumenes["resultado"]))
								{								
									foreach ($reporteResumenes as $reporteResumen) {
										if($reporteResumen['nombre'] == "Total" )
										{
											echo '<tr>
													<th class="text-left"><p class="texto-pequenio">'.$reporteResumen['nombre'].'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.'----'.'</p></th>
													<th class="text-right" ><p class="texto-pequenio">'.'$ '.number_format($reporteResumen['Recaudado_2019'], 0, ",", ".").'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.'----'.'</p></th>
													<th class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumen['Recaudado_2018_con_mult'], 0, ",", ".").'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.$reporteResumen['var_18_17'].'%</p></th>
													<th></th>
													</tr>';
										}else{
											echo '<tr>
													<td class="text-left"><p class="texto-pequenio">'.$reporteResumen['codigo'].' '.$reporteResumen['nombre'].'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.'----'.'</td>
													<td class="text-right" ><p class="texto-pequenio">'.'$ '.number_format($reporteResumen['Recaudado_2019'], 0, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.'----'.'</p></td>
													<td class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumen['Recaudado_2018_con_mult'], 0, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.$reporteResumen['var_18_17'].'%</p></td>
													<td class="text-center botonTabla">
														<button type="button botonTabla" class="btn btn-link redireccionarEspecifico botonTabla" data-id="'.$reporteResumen["id_sub_asignacion"].'"><i data-feather="search" class="trash"></i></button>
														<!--<a href="'.base_url().'Reporte/listarReportesEspecifico/?idSubAsignacion='.$reporteResumen['id_sub_asignacion'].'" title="click para ver detalle de subasignacion"><i data-feather="search" class="trash"></i></a>-->
													</td>
													</tr>';
										}
									}
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-12">
						<table id="tReporteResumenGasto" class="table table-hover table-bordered table-sm">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Gastos</th>
									<th class="text-center texto-pequenio" scope="col">Ppto. Vigente</th>
									<th class="text-center texto-pequenio" scope="col">G. Dev. 2019</th>
									<th class="text-center texto-pequenio" scope="col">Ejec. %</th>
									<th class="text-center texto-pequenio" scope="col">G. Dev. 2018</th>
									<th class="text-center texto-pequenio" scope="col">Var 18-17</th>
									<th class="text-center texto-pequenio" scope="col">Det.</th>
								</tr>
							</thead>
							<tbody id="tbodyReporteResumenGasto">

								<?php
									if(isset($reporteResumenesGastos) && !isset($reporteResumenesGastos["resultado"]))
									{
										foreach ($reporteResumenesGastos as $reporteResumenGasto) {
											if($reporteResumenGasto['nombre'] == "Total" )
										{
											echo '<tr>
													<th class=""><p class="texto-pequenio">'.$reporteResumenGasto['nombre'].'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.'----'.'</p></th>
													<th class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado_2019'], 0, ",", ".").'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.'----'.'</p></th>
													<th class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado_2018_con_mult'], 0, ",", ".").'</p></th>
													<th class="text-center"><p class="texto-pequenio">'.$reporteResumenGasto['var_18_17'].'%</p></th>
													<th></th>
													</tr>';
											}else{
												echo '<tr>
													<td class=""><p class="texto-pequenio">'.($reporteResumenGasto['codigo']." ".$reporteResumenGasto['nombre']).'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.'----'.'</p></td>
													<td class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado_2019'], 0, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.'----'.'</p></td>
													<td class="text-right"><p class="texto-pequenio">'.'$ '.number_format($reporteResumenGasto['Recaudado_2018_con_mult'], 0, ",", ".").'</p></td>
													<td class="text-center"><p class="texto-pequenio">'.$reporteResumenGasto['var_18_17'].'%</p></td>
													<td class="text-center botonTabla">
														<button type="button botonTabla" class="btn btn-link redireccionarEspecifico botonTabla" data-id="'.$reporteResumenGasto["id_sub_asignacion"].'"><i data-feather="search" class="trash"></i></button>
														<!--<a href="'.base_url().'Reporte/listarReportesEspecifico/?idSubAsignacion='.$reporteResumenGasto['id_sub_asignacion'].'" title="click para ver detalle de subasignacion"><i data-feather="search" class="trash"></i></a>-->
													</td>
													</tr>';
											}
										}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>				
			</div>
			<div id="botones" class="row m-3">
				<button type="button" class="btn btn-link redireccionarAsignacion" data-id="<?php echo $asignacionSeleccion["id_asignacion"]; ?>"><i data-feather="chevron-left" class="trash"></i> Volver</button>
				
					<!--<a class="btn btn-link"  href="<?php echo base_url();?>Reporte/listarReportes">Volver</a>-->
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
	      	<button type="button" class="btn btn-link redireccionarAsignacion" data-id="<?php echo $asignacionSeleccion["id_asignacion"]; ?>"><i data-feather="chevron-left" class="trash"></i> Volver</button>
	        <!--<button type="button" class="btn btn-primary" data-dismiss="modal">Atras</button>-->
	        <!--<button id="eliminarEquipo" type="button" class="btn btn-danger">Eliminar</button>-->
	      </div>
	    </div>
	  </div>
	</div>
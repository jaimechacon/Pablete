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
				<h3 id="tituloLista" data-id="">Antig&uuml;edad de la Deuda por Instituci&oacute;n</h3>
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
			<!--<div class="col-sm-12">	
				<div class="row">
				<?php 
					if(isset($instituciones))
					{
				?>		
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Instituci&oacute;n</span>
							</div>
							<div class="col-sm-9">
								<select id="institucionPD" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									/*if($instituciones)
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
								<select id="hospitalPD" class="custom-select custom-select-sm">
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
									}*/
									?>
								</select>
							</div>
						</div>
					</div>-->

					<div class="col-sm-6 mt-2">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Tipo de Documento</span>
							</div>
							<div class="col-sm-9">
								<select id="tipo_documentoPD" class="custom-select custom-select-sm">
								    <option value="-1">Todos</option>
									<?php 
									if($tipos_documentos)
									{
										foreach ($tipos_documentos as $tipo_documento) {
											if($tipo_documento['tipo_documento'] == $tipo_documento_seleccionado)
											{
                                                echo '<option value="'.$tipo_documento['tipo_documento'].'" selected>'.$tipo_documento['tipo_documento'].'</option>';
	                                        }else
	                                        {
                                                echo '<option value="'.$tipo_documento['tipo_documento'].'">'.$tipo_documento['tipo_documento'].'</option>';
	                                        }											
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<?php 
					}else
					{ ?>
						<!--<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-2">
									<span class="">Area</span>
								</div>
								<div class="col-sm-9">
									<select id="tipo_documentoPD" class="custom-select custom-select-sm">
									    <option value="-1">Todos</option>
										<?php 
										/*if($hospitales)
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
										}*/
										?>
									</select>
								</div>
							</div>
						</div>-->
						<div class="col-sm-6 mt-2">
							<div class="row">
								<div class="col-sm-3">
									<span class="">Tipo de Documento</span>
								</div>
								<div class="col-sm-9">
									<select id="hospitalPD" class="custom-select custom-select-sm">
									    <option value="-1">Todos</option>
										<?php 
										if($tipos_documentos)
										{
											foreach ($tipos_documentos as $tipo_documento) {
												if($tipo_documento['tipo_documento'] == $tipo_documento_seleccionado)
												{
	                                                echo '<option value="'.$tipo_documento['tipo_documento'].'" selected>'.$tipo_documento['tipo_documento'].'</option>';
		                                        }else
		                                        {
	                                                echo '<option value="'.$tipo_documento['tipo_documento'].'">'.$tipo_documento['tipo_documento'].'</option>';
		                                        }											
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>

					<?php
						}
					?>
				</div>
			</div>
			<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						I. Listado de Antig&uuml;edad de la Deuda (Vista en M$)
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12 table-responsive" id="tablaListaPagosDevengado">
						<table id="tListaPagosDevengado" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Servicio de Salud</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Hasta 45 d&iacute;as</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Entre 46 y 60</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Entre 61 y 90</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Entre 91 y 120</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Entre 121 y 150</th>
									<th class="text-center texto-pequenio" scope="col">Deuda Entre 151 y m&aacute;s d&iacute;as</th>
									<th class="text-center texto-pequenio" scope="col">Monto Hasta 30 d&iacute;as de Aprobaci&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col">Cant. Hasta 30 d&iacute;as de Aprobaci&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col">Monto Entre 30 d&iacute;as y m&aacute;s de Aprobaci&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col">Cant. Hasta 30 d&iacute;as y m&aacute;s de Aprobaci&oacute;n</th>
									<th class="text-center texto-pequenio" scope="col">Ver</th>
								</tr>
							</thead>
							<tbody id="tbodyPagosDevengado">

								<?php
								//var_dump($reporteResumenes);
								if(isset($listaPagos) && sizeof($listaPagos) > 0)
								{								
									foreach ($listaPagos as $pago) {
										echo '<tr>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['institucion'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												<td class="text-center"><p class="texto-pequenio"></p></td>
												
												<td class="text-center"><p class="texto-pequenio">$ '.number_format($pago['monto_30'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['cant_30'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">$ '.number_format($pago['monto_mayor_30'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['cant_mayor_30'], 0, ",", ".").'</p></td>
												<td class="text-center botonTabla">
													<button type="button" class="btn btn-link redireccionarHospitalPD botonTabla" data-id="'.$pago["id_institucion"].'" data-toggle="tooltip" title="click para ver detalle de institucion"><i data-feather="search" class="trash"></i></button>
												</td>
												</tr>';
									}
								}else
								{
									echo '<tr>
											<td class="text-center" colspan="9">No se encuentran datos registrados.</td>
										  </tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>				
			</div>
			<div id="botones" class="row m-3">
				<div class="col-sm-6 text-left">
					<button id="btnVolver" type="button" class="btn btn-link" hidden>Volver</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
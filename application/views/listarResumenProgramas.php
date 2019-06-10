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
				<h3>Informe de Remesa y Convenios</h3>
			</div>
			<div class="col-sm-5 text-right">
				<!--<button id="btnExportarExcel" type="button" class="btn btn-link">Exportar a CSV
					<i style="margin-bottom: 5px;" data-feather="download"></i>
				</button>

				<button id="btnExportarTodoExcel" type="button" class="btn btn-link">Exportar todo a CSV
					<i style="margin-bottom: 5px;" data-feather="download"></i>
				</button>-->
				<!--<img  id="imgExportarExcel" src="<?php //echo base_url();?>assets/img/icons/excel.png" width="30" class="d-inline-block align-top" alt="">-->
			</div>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12">	
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
								<select id="institucionRR" class="custom-select custom-select-sm">
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
						}
					?>	
					

				</div>
			</div>
			<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						I. Resumen Consolidado (cifra en pesos $)
					</div>
				</div>
			</div>


			<div class="col-sm-12 pb-3">
				<div class="row">
					<div class="col-sm-12 table-responsive" id="tablaListaResumenConsolidado">
						<table id="tListaResumenConsolidado" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Programa</th>
									<th class="text-center texto-pequenio" scope="col">Marco Presupuestario</th>
									<th class="text-center texto-pequenio" scope="col">Convenio</th>
									<th class="text-center texto-pequenio" scope="col">Convenio vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>							
								</tr>
							</thead>
							<tbody id="tbodyResumenConsolidado">

								<?php
								//var_dump($listaPagos);
								if(isset($listaPagos[0]) && sizeof($listaPagos[0]) > 0)
								{								
									//foreach ($listaPagos as $pago) {
										/*if($pago["id_institucion"] == $idInstitucion)
										{
											if ($pago['nombre_institucion'] == "Total") {
											echo '<tr>
												<th class="text-center"><p class="texto-pequenio">CONSOLIDADO</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['marco_presupuestario'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['convenios'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.
												($pago['marco_presupuestario'] > 0 ? 
													number_format((($pago['convenios']/$pago['marco_presupuestario'])*100), 1, ",", ".")
												: 0)
												.' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['transferencias'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.
												($pago['convenios'] > 0 ? 
													number_format((($pago['transferencias']/$pago['convenios'])*100), 1, ",", ".")
												: 0)
												.' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.
												(($pago['marco_presupuestario'] > 0 ? 
													(($pago['convenios']/$pago['marco_presupuestario'])*100)
												: 0) > 0 ?
												number_format((($pago['convenios'] > 0 ? 
													(($pago['transferencias']/$pago['convenios'])*100)
												: 0)/($pago['marco_presupuestario'] > 0 ? 
													(($pago['convenios']/$pago['marco_presupuestario'])*100)
												: 0))*100, 1, ",", ".")
												:0)
												.' %</p></th>'
												.'</tr>';
											
										}else
										{*/
											echo '<tr>
												<th class="text-center"><p class="texto-pequenio">CONSOLIDADO APS MUNICIPAL</p></th>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['marco'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['convenio'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['convenio_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['transferencia'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['trans_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[0]['trans_convenio'], 1, ",", ".").' %</p></td>
												</tr>'.

												'<tr>
												<th class="text-center"><p class="texto-pequenio">CONSOLIDADO APS ESTABLECIMIENTOS DEPENDIENTES</p></th>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['marco'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['convenio'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['convenio_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['transferencia'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['trans_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[1]['trans_convenio'], 1, ",", ".").' %</p></td>
												</tr>'
												.'<tr>
												<th class="text-center"><p class="texto-pequenio">CONSOLIDADO</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['marco'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['convenio'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['convenio_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['transferencia'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['trans_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($listaPagos[2]['trans_convenio'], 1, ",", ".").' %</p></th>
												</tr>';
										//	}	
										//}									
								//	}
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



			<div class="col-md-6 col-sm-12">
				<div class="row">
					<div class="col-sm-12 table-responsive" id="tablaListaResumenAPS">
						<table id="tListaResumenAPS" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Programa</th>
									<th class="text-center texto-pequenio" scope="col">Marco Presupuestario</th>
									<th class="text-center texto-pequenio" scope="col">Convenio</th>
									<th class="text-center texto-pequenio" scope="col">Convenio vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>							
								</tr>
							</thead>
							<tbody id="tbodyListaResumenAPS">

								<?php
								//var_dump($listaPagosAPS);
								if(isset($listaPagosAPS) && sizeof($listaPagosAPS) > 0)
								{								
									foreach ($listaPagosAPS as $pago) {

										if ($pago['nombre'] == "Total") {
											echo '<tr>
												<th class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre'], 0, 30)).'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['marco'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['transferencia'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_convenio'], 1, ",", ".").' %</p></th>
												</tr>';
											
										}else
										{
											echo '<tr>
												<td class="text-center"><p class="texto-pequenio">'.$pago['nombre'].'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['marco'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['transferencia'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_convenio'], 1, ",", ".").' %</p></td>
												</tr>';
										}										
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


			<div class="col-md-6 col-sm-12">
				<div class="row">
					<div class="col-sm-12 table-responsive" id="tablaListaResumenAPSSS">
						<table id="tListaResumenAPSSS" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Programa</th>
									<th class="text-center texto-pequenio" scope="col">Marco Presupuestario</th>
									<th class="text-center texto-pequenio" scope="col">Convenio</th>
									<th class="text-center texto-pequenio" scope="col">Convenio vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>
									<th class="text-center texto-pequenio" scope="col">Transferencias vs Marco</th>							
								</tr>
							</thead>
							<tbody id="tbodyListaResumenAPSSS">

								<?php
								//var_dump($listaPagosAPS);
								if(isset($listaPagosAPSSS) && sizeof($listaPagosAPSSS) > 0)
								{								
									foreach ($listaPagosAPSSS as $pago) {

										if ($pago['nombre'] == "Total") {
											echo '<tr>
												<th class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre'], 0, 30)).'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['marco'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['transferencia'], 0, ",", ".").'</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_marco'], 1, ",", ".").' %</p></th>
												<th class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_convenio'], 1, ",", ".").' %</p></th>
												</tr>';
											
										}else
										{
											echo '<tr>
												<td class="text-center"><p class="texto-pequenio">'.$pago['nombre'].'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['marco'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['convenio_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['transferencia'], 0, ",", ".").'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_marco'], 1, ",", ".").' %</p></td>
												<td class="text-center"><p class="texto-pequenio">'.number_format($pago['trans_convenio'], 1, ",", ".").' %</p></td>
												</tr>';
										}										
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

		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
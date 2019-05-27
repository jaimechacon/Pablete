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
				<h3>Listado Pagos Tesorer&iacute;a por Área</h3>
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
								<select id="institucionPT" class="custom-select custom-select-sm">
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
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Area</span>
							</div>
							<div class="col-sm-9">
								<select id="hospitalPT" class="custom-select custom-select-sm">
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
			<div class="col-sm-12 pt-3 pb-3">
				<div class="card">
					<div class="card-header">
						I. Listado de Pagos Tesorer&iacute;a (Vista en M$)
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div id="tablaListaPagosTesoreria" class="row">
					<div class="col-sm-12">
						<table id="tListaPagosTesoreria" class="table table-sm table-hover table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="text-center texto-pequenio" scope="col">Servicio de Salud</th>
									<th class="text-center texto-pequenio" scope="col">Area</th>
									<th class="text-center texto-pequenio" scope="col">Rut Beneficiario</th>
									<th class="text-center texto-pequenio" scope="col">Nombre Beneficiario</th>
									<th class="text-center texto-pequenio" scope="col">Rut Proveedor</th>
									<th class="text-center texto-pequenio" scope="col">Nombre Proveedor</th>
									<th class="text-center texto-pequenio" scope="col" >Numero de Documento</th>
									<th class="text-center texto-pequenio" scope="col">Numero Cuenta de Pago</th>
									<th class="text-center texto-pequenio" scope="col">Monto ( $ )</th>								
								</tr>
							</thead>
							<tbody id="tbodyPagosTesoreria">

								<?php	
								//var_dump($reporteResumenes);
								if(isset($listaPagos) && sizeof($listaPagos) > 0)
								{								
									foreach ($listaPagos as $pago) {
										echo '<tr>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_institucion'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['rut_beneficiario'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_beneficiario'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['rut_proveedor'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['nombre_proveedor'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['numero_documento'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">'.(substr($pago['numero_cuenta_pago'], 0, 30)).'</p></td>
												<td class="text-center"><p class="texto-pequenio">$ '.number_format($pago['monto_pago'], 0, ",", ".").'</p></td>
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
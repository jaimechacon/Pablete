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
				<h3>Informe Resumen Consolidado</h3>
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
								<select id="institucionGRR" class="custom-select custom-select-sm">
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
						I. Gr&aacute;fico Consolidado por Instituci&oacute;n (cifra en pesos $)
					</div>
				</div>
			</div>


			<div class="col-sm-12 pb-3">
				<div id="chartContainer" style="height: 370px; width: 100%;"></div>			
			</div>

		
		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
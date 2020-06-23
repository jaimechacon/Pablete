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
				<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Lista de Reporte PERC
				</h3>
			</div>
		</div>

		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">
				<?php
					if(isset($anios))
					{?>			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">A&ntilde;os</span>
							</div>
							<div class="col-sm-9">
								<select id="aniosPERC" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($anios)
									{
										foreach ($anios as $anio) {
											if(isset($anio) && (int)$anio == $anioSeleccionado)
	                                        {
	                                                echo '<option value="'.$anio.'" selected>'.$anio.'</option>';
	                                        }else
	                                        {
	                                                echo '<option value="'.$anio.'">'.$anio.'</option>';
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
								<span class="">Mes</span>
							</div>
							<div class="col-sm-9">
								<select id="mesPERC" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
								   	<option value="1">Enero</option>
								   	<option value="2">Febrero</option>
								   	<option value="3">Marzo</option>
								   	<option value="4">Abril</option>
								   	<option value="5">Mayo</option>
								   	<option value="6">Junio</option>
								   	<option value="7">Julio</option>
								   	<option value="8">Agosto</option>
								   	<option value="9">Septiembre</option>
								   	<option value="10">Octubre</option>
								   	<option value="11">Nomviembre</option>
								   	<option value="12">Diciembre</option>
							   	</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<div class="row ml-2">			
					<?php
					if(isset($anios))
					{?>			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Entidades</span>
							</div>
							<div class="col-sm-9">
								<select id="entidadesPERC" class="custom-select custom-select-sm">
								   	<option value="-1">Todos</option>
									<?php 
									if($entidades)
									{
										foreach ($entidades as $entidad) {
											
											if(isset($entidad) && (int)$entidad == $entidadSeleccionado)
	                                        {
	                                                echo '<option value="'.$entidad['id'].'" selected>'.$entidad['description'].'</option>';
	                                        }else
	                                        {
	                                                echo '<option value="'.$entidad['id'].'">'.$entidad['description'].'</option>';
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
				</div>
			</div>
			<div class="col-sm-12 mt-3">
				<div class="row ml-2">
					<div class="col-sm-6 text-center">
						<button id="btnExportarExcelPERC" type="button" class="btn btn-link">Exportar a CSV Centro Costos
							<i data-feather="download"></i>
						</button>
					</div>
					<div class="col-sm-6 text-center">
						<button id="btnExportarIndirectExcelPERC" type="button" class="btn btn-link">Exportar a CSV Centro Costos Indirectos
							<i data-feather="download"></i>
						</button>
					</div>
			</div>
		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
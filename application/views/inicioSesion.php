<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>

<div class="col-sm-12 mt-3">
	<div class="row">
		<h4>Bienvenido <?php echo $u_nombres.' '.$u_apellidos; ?></h4>
	</div>
	<div class="row mt-3">
		<h4>Usted es un <?php echo $perfil['perfil'];//echo $perfil; ?></h4>
	</div>	
	<div id="chartContainer2" style="height: 400px; width: 100%;"></div>
	
	<button class="btn invisible" id="backButton"><i data-feather="chevron-left"></i> Volver</button>
	<div id="chartContainer3" style="height: 100%; width: 100%;"></div>
	<div id="chartContainer" style="height: 100%; width: 100%;"></div>

</div>

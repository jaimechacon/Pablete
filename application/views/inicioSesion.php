<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>

<div class="col-sm-12 mt-3">
	<div class="row">
		<h4>Bienvenido <?php echo $u_nombres.' '.$u_apellidos.' usted es un '.$perfil['perfil']; ?></h4>
	</div>
	<div class="row mt-3 text-left">
		<div class="col-sm-12 col-md-6">
			<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		</div>
	</div>
</div>

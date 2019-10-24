<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Marco Presupuestario
			</h3>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Programa:</p>
							</div>
							<div class="col-sm-9">
								<h5 id="programa_presupuesto"></h5>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Subtitulo:</span>
							</div>
							<div class="col-sm-9">
								<h5  id="cuenta_presupuesto"></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Marco Restante:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="monto_restante" data-monto-restante="" data-monto-marco="" class="text-success"></h3>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-12">
								<h5 id="mensajeError" class="text-danger"></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarMarco" class="" id="agregarMarco" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-5 pt-3">
			<label for="inputPresupuesto">Presupuesto</label>
			<input type="text" class="form-control" id="idPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="idPresupuesto" value="" data-restante="" hidden>
			<input type="text" class="form-control" id="inputPresupuesto" minlength="1" placeholder="Seleccione un Presupuesto" name="inputPresupuesto" readonly>
			<input type="number" class="form-control form-control-sm marcos" hidden id="instituciones" name="instituciones" value="<?php echo sizeof($instituciones); ?>" />
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarPresupuesto" class="btn btn-link" type="button" id="btnBuscarPresupuesto" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Presupuesto"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-6 pt-3">
			<label for="exampleFormControlFile1">Subir Documento</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoMarco" name="archivoMarco">
				<label class="custom-file-label" for="validatedCustomFile" id="lArchivoMarco">Seleccionar un Archivo...</label>
			</div>
	  	</div>
	</div>


  	<div class="row pt-2 pl-3 ">
		<?php
		$primero = true;
		//var_dump(sizeof($instituciones));
		for ($i=0; $i < sizeof($instituciones); $i++) {
		//foreach ($instituciones as $institucion) {
		?>				
			<div class="form-group col-sm-6">
				<input class="form-control form-control-sm" type="text" placeholder="<?php echo $instituciones[$i]['nombre'] ?>" readonly disabled>
			</div>
			<div class="form-group col-sm-6">
				<input type="number" class="form-control form-control-sm marcos_institucion" data-id="<?php echo $instituciones[$i]['id_institucion']; ?>" id="inputMarco<?php echo $i; ?>" minlength="1" placeholder="Ingrese un Marco para <?php echo $instituciones[$i]['nombre'] ?>" name="inputMarco<?php echo $i; ?>" />
				<input type="text" class="form-control" id="inputInstitucion<?php echo $i; ?>" name="inputInstitucion<?php echo $i; ?>" value="<?php echo $instituciones[$i]['id_institucion']; ?>" hidden>
			</div>
		<?php
			
		}
		?>
	</div>


	<div id="botones" class="row mt-3 mb-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Programa/ListarMarcos">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnAgregarMarco"  type="submit" class="btn btn-primary">Agregar Marco</button>
		</div>
	</div>
</form>

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarPresupuesto" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Presupuesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionPresupuesto">
			<!--<table id="tListaPresupuestos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Presupuesto</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPresupuestos">
					<?php 
					//var_dump($presupuestos);
			        /*if(isset($presupuestos))
			        {
				        foreach ($presupuestos as $presupuesto): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['id_presupuesto']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['programa']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['codigo_cuenta'].' '.$presupuesto['cuenta']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['presupuesto'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio">$ <?php echo number_format($presupuesto['dif_rest'], 0, ",", "."); ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $presupuesto['u_nombres'].' '.$presupuesto['u_apellidos']; ?></p></td>						        
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<button href="#" aria-controls="tListaPresupuestos" data-id="<?php echo $presupuesto['id_presupuesto']; ?>" data-programa="<?php echo $presupuesto['programa']; ?>" data-presupuesto="<?php echo $presupuesto['presupuesto']; ?>" data-restante="<?php echo $presupuesto['dif_rest']; ?>" data-codigo_cuenta="<?php echo $presupuesto['codigo_cuenta']; ?>" data-nombre_cuenta="<?php echo $presupuesto['cuenta']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPresupuesto">Seleccionar</button>
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}*/?>
			  </tbody>
			</table>-->
		</div>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalMensajeMarco" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="tituloM" name="tituloM" data-idprograma="" data-nombreprograma="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoM"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>

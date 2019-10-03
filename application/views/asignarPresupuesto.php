<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignación de Presupuesto
			</h3>
		</div>
	</div>
</div>
<form method="post" accept-charset="utf-8" action="agregarPresupuesto" class="" id="agregarPresupuesto" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-5 pt-3">
			<label for="inputPrograma">Programa</label>
			<input type="text" class="form-control" id="idPrograma" minlength="1" placeholder="Seleccione un Programa" name="idPrograma" value="" hidden>
			<input type="text" class="form-control" id="inputPrograma" minlength="1" placeholder="Seleccione un Programa" name="inputPrograma" readonly>
		</div>
		<div class="col-sm-1 mt-5">
			<div class="row">
				<div class="col-sm-3">
					<button href="SeleccionarProgramaP" class="btn btn-link" type="button" id="btnBuscarPrograma"  data-toggle="modal" data-target="#modalBuscarPrograma" style="padding-top: 6px;">
						<i stop-color data-feather="plus" class="mb-2" data-toggle="tooltip" data-placement="top" title="Seleccionar un Programa"></i>
					</button>
				</div>
			</div>
		</div>

			<!--<div class="form-group col-sm-6 mt-3">
			<label for="archivoPresupuesto">Subir Documento</label>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="archivoPresupuesto" name="archivoPresupuesto">
				<label class="custom-file-label" for="validatedCustomFile" id="lArchivoPresupuesto">Seleccionar un Archivo...</label>
			</div>
	  	</div>-->
		<!--<div class="form-group col-sm-6 pt-3">
			<label for="idSubtitulo">Subtitulo</label>
			<select id="selectSubtitulos" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Subtitulo">
			  <?php
				/*if($cuentas)
				{
					foreach ($cuentas as $cuenta) {
						if($cuenta['id_cuenta'] == "6" || $cuenta['id_cuenta'] == "3" || $cuenta['id_cuenta'] == "4" || $cuenta['id_cuenta'] == "5")
						{
							echo '<option value="'.$cuenta['id_cuenta'].'">'.$cuenta['nombre'].'</option>';
						}
					}
				}*/
				?>
			</select>
		</div>-->
	</div>

	<div class="row pt-2 pl-3 ">
		<?php
		$primero = true;
		foreach ($cuentas as $cuenta) {
			if($cuenta['id_cuenta'] == "6" || $cuenta['id_cuenta'] == "3" || $cuenta['id_cuenta'] == "4" || $cuenta['id_cuenta'] == "5")
			{
				if($primero)
				{?>
					<div class="form-group col-sm-6">
						<label>Subtitulos</label>
						<input class="form-control" type="text" placeholder="<?php echo $cuenta['nombre'] ?>" readonly disabled>
					</div>
					<div class="form-group col-sm-6">
						<label for="input<?php echo $cuenta['id_cuenta']; ?>">Presupuestos</label>
						<input type="number" class="form-control" id="inputPresupuesto<?php echo $cuenta['id_cuenta']; ?>" minlength="1" placeholder="Ingrese un Presupuesto para <?php echo $cuenta['nombre'] ?>" name="inputPresupuesto<?php echo $cuenta['id_cuenta']; ?>" />
					</div>

				<?php	$primero = false;
				}else
				{?>
					<div class="form-group col-sm-6">
						<input class="form-control" type="text" placeholder="<?php echo $cuenta['nombre'] ?>" readonly disabled>
					</div>
					<div class="form-group col-sm-6">
						<input type="number" class="form-control" id="inputPresupuesto<?php echo $cuenta['id_cuenta']; ?>" minlength="1" placeholder="Ingrese un Presupuesto para <?php echo $cuenta['nombre'] ?>" name="inputPresupuesto<?php echo $cuenta['id_cuenta']; ?>" />
					</div>
				<?php
				}
			}
		}
		?>
  	</div>
	<div id="botones" class="row mt-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Programa/ListarPresupuestos">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnAgregarPresupuesto"  type="submit" class="btn btn-primary">Agregar Presupuesto</button>
		</div>
	</div>
</form>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalBuscarPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Selecciona un Programa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="table-responsive" id="listaSeleccionPrograma">
			<table id="tListaProgramas" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Forma de Pago</th>
					    	<th scope="col" class="texto-pequenio text-center align-middle registro"></th>
					</tr>
				</thead>
				<tbody id="tbodyPrograma">
			        <?php
			        if(isset($programas))
			        {
				        foreach ($programas as $programa): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['id_programa']; ?></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $programa['forma_pago']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla paginate_button">
					        		<button href="#" aria-controls="tListaProgramas" data-id="<?php echo $programa['id_programa']; ?>" data-nombre="<?php echo $programa['nombre']; ?>" tabindex="0" class="btn btn-outline-dark seleccionPrograma">Seleccionar</button>
					        	</td>
					    	</tr>
				  		<?php endforeach;
			  		}?>
			  </tbody>
			</table>
		</div>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="loader" class="loader" hidden></div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalMensajePresupuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

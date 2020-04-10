<?php
	$id_usuario=$this->session->userdata('id_usuario');
	
	if(!$id_usuario){
	  redirect('Login');
	}
	//var_dump(implode(",", $eacsEquipo));
?>
<div class="row">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="plus" ></i><?php echo $titulo;?>
			</h3>
		</div>
	</div>
	<div class="col-sm-12">
		<div id="filtros" class="mt-3 mr-3 ml-3">
			<form id="agregarProducto" action="agregarProducto" method="POST">
				<div class="row">
					<input type="text" class="form-control form-control-sm" id="inputIdProducto" name="inputIdProducto" value="<?php if(isset($producto['id_producto'])): echo $producto['id_producto']; endif; ?>" hidden>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputCodigo">C&oacute;digo</label>
						<input type="text" class="form-control  form-control-sm" id="inputCodigo" minlength="1" placeholder="Ingrese un c&oacute;digo al Producto" name="inputCodigo" value="<?php if(isset($producto['codigo'])): echo $producto['codigo']; endif; ?>">
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
					<div class="form-group col-sm-6">
						<label for="inputNombre">Nombre</label>
						<input type="text" class="form-control  form-control-sm" id="inputNombre" minlength="1" placeholder="Ingrese un nombre al Producto" name="inputNombre" value="<?php if(isset($producto['nombre'])): echo $producto['nombre']; endif; ?>">
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputUnidadMedida">Unidad de Medida</label>
						<input type="text" class="form-control  form-control-sm" id="inputUnidadMedida" minlength="1" placeholder="Ingrese un nombre al Producto" name="inputUnidadMedida" value="<?php if(isset($producto['unidad_medida'])): echo $producto['unidad_medida']; endif; ?>">
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
					<div class="form-group col-sm-6">
						<label for="inputObservaciones">Descripci&oacute;n</label>
						<textarea class="form-control form-control-sm block" placeholder="Ingrese una Descripci&oacute;n" id="inputObservaciones" name="inputObservaciones" rows="2"><?php if(isset($producto['descripcion'])): echo $producto['descripcion']; endif; ?></textarea>
					</div>
				</div>
				
				<div id="botones" class="row m-3">
					<div class="col-sm-6 text-left">
						<a class="btn btn-link"  href="<?php echo base_url();?>Producto/ListarProductos">Volver</a>
					</div>
					<div  class="col-sm-6 text-right">
					 	<button type="submit" class="btn btn-primary submit"><?php echo $titulo;?></button>
					</div>
				</div>
			</form>		
		</div>
	</div>
</div>

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensajeProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloM" name="tituloM" data-idproducto="" data-nombreproducto="" ></h5>
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
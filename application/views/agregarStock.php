<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Asignar Stock Producto
			</h3>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">	
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Producto:</p>
							</div>
							<div class="col-sm-9">
								<h5 id="Producto"></h5>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-3">
								<span class="">Cantidad Total:</span>
							</div>
							<div class="col-sm-9">
								<h5  id="cantidad_disponible"></h5>
							</div>
						</div>
					</div>		
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-3">
								<p>Cantidad Restante:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="cantidad_restante" data-cant-restante="" data-cant-total="" class="text-success"></h3>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
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
<form method="post" accept-charset="utf-8" action="agregarStock" class="" id="agregarStock" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-6 pt-3">
			<label for="idProducto">Productos</label>
			<select id="idProducto" name="idProducto" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Producto">
		<?php
			if(isset($productos)) {?>
				  <?php
					if($productos)
					{
						foreach ($productos as $producto) {
							echo '<option value="'.$producto['id_producto'].'">'.$producto['codigo'].' '.$producto['nombre'].'</option>';
						}
					}
					?>
		<?php }?>
			</select>
		</div>
		<div class="form-group col-sm-6 pt-3">
			<label for="inputCantProducto">Cantidad</label>
			<input type="number" class="form-control form-control-sm" data-id="" id="inputCantProducto" minlength="1" placeholder="Ingrese una Cantudad para el producto" name="inputCantProducto" />
	  	</div>
	</div>


  	<div class="row pt-2 pl-3 ">
		<div id="divOrdenCompra" class="form-group col-sm-6 pt-3">
			<label for="inputOrdenCompra">Orden de Compra</label>
			<input type="text" class="form-control form-control-sm" data-id="" id="inputOrdenCompra" minlength="1" placeholder="Ingrese un n&uacute;mero de Orden de Compra" name="inputOrdenCompra" />
		</div>
		<div id="divInputDescripcion" class="form-group col-sm-6 pt-3">
			<label for="inputDescripcion">Descripci&oacute;n</label>
			<textarea class="form-control form-control-sm block" placeholder="Ingrese una Descripci&oacute;n (opcional)" id="inputDescripcion" name="inputDescripcion" rows="2"><?php if(isset($programa['descripcion'])): echo $programa['descripcion']; endif; ?></textarea>
		</div>
	</div>
	<div id="divComunasHospitales" class="row pt-2 pl-3 ">
	</div>
	<div id="botones" class="row mt-3 mb-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Producto/listadoStock">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnAgregarMarco"  type="submit" class="btn btn-primary">Agregar Stock</button>
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

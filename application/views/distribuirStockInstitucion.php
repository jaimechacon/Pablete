<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row pt-3">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3 class="pl-3"><i class="plusTitulo mb-2" data-feather="list" ></i> Distribuir Stock de Producto
			</h3>
		</div>
		<hr class="my-3">
		<div class="row">
			<div class="col-sm-12 mt-3">
				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Stock Total:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="cantidad_disponible" data-monto-total="<?php 
										if(isset($producto))
											echo $producto['stock'];
									?>" data-monto-marco="" class="text-success">
									<?php 
										if(isset($producto))
											echo number_format($producto['stock'], 0, ",", ".");
									?>
								</h3>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-12">
								<!--<h5 id="mensajeError" class="text-danger"></h5>-->
							</div>
						</div>
					</div>
				</div>

				<div class="row ml-2">			
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-3">
								<p>Stock Disponible:</p>
							</div>
							<div class="col-sm-9">
								<h3 id="cantidad_restante" data-cantidad-restante="<?php 
										if(isset($producto))
											echo $producto['dif_rest'];
									?>" data-monto-marco="" class="text-success">
									<?php 
										if(isset($producto))
											echo number_format($producto['dif_rest'], 0, ",", ".");
									?>
								</h3>
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
<form method="post" accept-charset="utf-8" action="distribuirStockInstitucion" class="" id="distribuirStockInstitucion" enctype="multipart/form-data">
	<div class="row pt-3 pl-3">
		<div class="form-group col-sm-6 pt-3">
			<input type="number" class="form-control form-control-sm stocks" id="cantidad" name="cantidad" value="<?php echo $cantidad;?>" hidden/>
			<label for="idProducto">Productos</label>
			<select id="idProducto" name="idProducto" class="selectpicker" data-actions-box="true" data-width="100%" data-live-search="true" title="Seleccione un Producto"
			<?php echo (isset($idProducto)) ? 'disabled' : ''; ?>
			>
		<?php
			if(isset($productos)) {?>
				  <?php
					if($productos)
					{
						foreach ($productos as $producto) {
							if(isset($idProducto) && (int)$producto['id_producto'] == $idProducto)
                            {
                            	echo '<option value="'.$producto['id_producto'].'" selected>'.$producto['codigo'].' '.$producto['nombre'].'</option>';
                            }else
                            {
                                    echo '<option value="'.$producto['id_producto'].'">'.$producto['codigo'].' '.$producto['nombre'].'</option>';
                            }
						}
					}
					?>
		<?php }?>
			</select>
		</div>


	</div>


  	<div class="row pt-2 pl-3 ">

  		<?php
			if(isset($hospitales))
			{
				if($hospitales)
				{
					for ($i=0; $i < sizeof($hospitales); $i++) { 
						
					//foreach ($hospitales as $institucion) {?>
					<div class="form-group col-sm-6">
						<input class="form-control form-control-sm" type="text" placeholder="<?php echo $hospitales[$i]['nombre']; ?>" readonly disabled>
					</div>
					<div class="form-group col-sm-6">
						<input type="number" class="form-control form-control-sm stock_hospital" data-id="<?php echo $hospitales[$i]['id_institucion']; ?>" id="inputStock<?php echo $i; ?>" minlength="1" placeholder="Ingrese un Stock para <?php echo $hospitales[$i]['nombre']; ?>" name="inputStock<?php echo $i; ?>" />
						<input type="text" class="form-control" id="inputHospital<?php echo $i; ?>" name="inputHospital<?php echo $i; ?>" value="<?php echo $hospitales[$i]['id_institucion']; ?>" hidden />
					</div>
				<?php }
				}
			}?>
	</div>
	<div id="botones" class="row mt-3 mb-3">
		<div class="col-sm-6 text-left pl-4">
			<a class="btn btn-link"  href="<?php echo base_url();?>Producto/listarDistribucion<?php echo (isset($idProducto) ? '/?idProducto='.$idProducto : '' );//.(isset($idInstitucion) ? '&idInstitucion='.$idInstitucion : '' ); ?>">Volver</a>
		</div>
		<div  class="col-sm-6 text-right">
		 	<button id="btnDistribuirStockHospital"  type="submit" class="btn btn-primary">Distribuir Stock</button>
		</div>
	</div>
</form>

<div id="loader" class="loader" hidden></div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

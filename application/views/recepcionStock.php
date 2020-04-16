<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row pt-3">
	<div class="col-sm-6">
		<div id="titulo" class="mt-3">
			<h3><i class="plusTitulo mb-2" data-feather="list" ></i> Recepciones de Stock Pendientes
			</h3>
		</div>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive" id="tablaListaProductos">
			<table id="tListaStockProductos" class="table table-sm table-hover table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Codigo</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Nombre Producto</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Descripci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Unidad de Medida</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Ingresado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Stock Recepcionado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">N&#176; Orden</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Tipo Documento</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Observaci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha Recepci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario Recepci&oacute;n</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Estado</th>
					    <th scope="col" class="texto-pequenio text-center align-middle registro">Recepcionar Stock</th>
					</tr>
				</thead>
				<tbody id="tbodyProducto">
			        <?php 
			        if(isset($productos))
			        {
				        foreach ($productos as $producto): ?>

				        	<?php if ($producto['nombre'] == "Total") {
			        		?>
								<tr>
							        <th scope="row" class="text-center align-middle registro" colspan="5">
							        	<p class="texto-pequenio"><?php echo $producto['nombre']; ?></p>
							        </th>
							        <th class="text-center align-middle registro" colspan="3">
							        	<p class="texto-pequenio"><?php echo $producto['stock']; ?></p>
							        </th>
						    	</tr>
							<?php	
							}else
							{?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['id_distribucion']; ?></p></th>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['codigo']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['nombre']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['descripcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['unidad_medida']; ?></p></td>

						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['institucion']; ?></p></td>

						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['stock']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['stock_recep']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['fecha']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['u_nombres'].' '.$producto['u_apellidos']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['num_orden']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['tipo_documento']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['observacion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['fecha_recepcion']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['u_nombres_recep'].' '.$producto['u_apellidos_recep']; ?></p></td>
						        <td class="text-center align-middle registro"><p class="texto-pequenio"><?php echo $producto['estado_recepcion']; ?></p></td>
						        <td class="text-center align-middle registro botonTabla">
							        <a class="view_recepcion" href="#" id="recepcion_<?php echo $producto['id_distribucion']; ?>" data-id="<?php echo $producto['id_distribucion']; ?>" data-codigo="<?php echo $producto['codigo']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-descripcion="<?php echo $producto['descripcion']; ?>" data-unidad_medida="<?php echo $producto['unidad_medida']; ?>" data-institucion="<?php echo $producto['institucion']; ?>" data-stock="<?php echo $producto['stock']; ?>" data-stock_recep="<?php echo $producto['stock_recep']; ?>" data-fecha="<?php echo $producto['fecha']; ?>" data-usuario="<?php echo $producto['u_nombres'].' '.$producto['u_apellidos']; ?>" data-fecha="<?php echo $producto['fecha']; ?>" data-num_orden="<?php echo $producto['num_orden']; ?>" data-tipo_documento="<?php echo $producto['tipo_documento']; ?>" data-observacion="<?php echo $producto['observacion']; ?>" data-fecha_recepcion="<?php echo $producto['fecha_recepcion']; ?>" data-usuario_recep="<?php echo $producto['u_nombres_recep'].' '.$producto['u_apellidos_recep']; ?>" data-estado_recepcion="<?php echo $producto['estado_recepcion']; ?>"
							        >
					        			<i data-feather="check-square" data-toggle="tooltip" data-placement="top" title="Revisar"></i>       		
				        			</a>
					        	</td>
					    	</tr>
					    <?php } ?>
				  		<?php endforeach;
			  		}?>
			  </tbody>
			</table>
		</div>
	</div>
</div>

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensajeProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p id="parrafoMP"></p>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalRevisarConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMP">Recepci&oacute;n de Productos<span id="numConvenio"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			N° Distribuci&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="id_distribucion"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Codigo Producto:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="codigoProducto"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Producto:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="nombreProducto"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Descripci&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="descripcionProducto"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Unidad de Medida:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="unidadProducto"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Institucion:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="institucionRecepcion"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Stock Despachado:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="stockDespachado" class="text-success"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Fecha:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="fechaDespacho"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Usuario:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="usuarioDespacho"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			N&#176; Orden:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="numOrden"></span>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Tipo Documento:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="tipoDoc"></span>
      		</div>
      	</div>
  		<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Observaci&oacute;n:
      		</div>
      		<div class="col-sm-12 col-md-6">
      			<span id="observacion"></span>
      		</div>
      	</div>

      	<input type="number" class="form-control form-control-sm" id="inputDistribucion" minlength="1" name="inputDistribucion" value="" hidden>

      	<div class="row mt-4">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Estado:
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-12 text-left">
      			<select id="selectEstados" class="form-control form-control-sm" name="selectEstados" >
					<option value="">Seleccione un Estado</option>
				   	<option value="1">Recepcionado</option>
				   	<option value="2">Recepcionado Parcial</option>
					<option value="3">Rechazado</option>
				</select>
      		</div>
      	</div>

      	<div class="row">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			N&#176; Documento:
      		</div>
      		<div class="col-sm-12 col-md-12 text-left">
      			<input type="number" class="form-control form-control-sm" data-id="" id="inputNumOrden" minlength="1" placeholder="Ingrese un N&uacute;mero de Documento" name="inputNumOrden" />
      		</div>
      	</div>

      	<div id="dCantRecep" class="row" hidden>
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Cantidad Recepcionada:
      		</div>
      		<div class="col-sm-12 col-md-12 text-left">
      			<input type="number" class="form-control form-control-sm" data-id="" id="inputCantRecepcion" minlength="1" placeholder="Ingrese la cantidad Recepcionada" name="inputCantRecepcion" />
      		</div>
      	</div>

      	<div class="row mt-2">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Tipo Documento:
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-sm-12 col-md-12 text-left">
      			<select id="selectTipoDoc" class="form-control form-control-sm" name="selectTipoDoc" >
					<option value="">Seleccione un Estado</option>
				   	<option value="Guia de Despacho">Guia de Despacho</option>
				   	<option value="Otro">Otro</option>
				</select>
      		</div>
      	</div>
      	<div class="row pt-2">
			<div class="col-sm-12 col-md-12 font-weight-bold">
      			Adjunto:
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="archivoRecepcion" name="archivoMarcoAsignar">
					<label class="custom-file-label" for="validatedCustomFile" id="lArchivoRecepcion">Seleccionar un Archivo...</label>
				</div>
			</div>
	  	</div>
      	
      	<div class="row mt-3">
      		<div class="col-sm-12 col-md-6 font-weight-bold">
      			Observaciones:
      		</div>
      	</div>
      	<div class="row mt-2">
      		<div class="col-sm-12">
      			<textarea class="form-control" id="observacionesRecepcion" placeholder="Ingrese una observacion" rows="3"></textarea>
      		</div>
      	</div>
      	<div class="row mt-4">
      		<div class="col-sm-12 col-md-12 text-right">
      			<button id="btnGuardarRecepcion" type="button" class="btn btn-success">Guardar Recepci&oacute;n</button>
      		</div>
      	</div>

      </div>
      <div class="modal-footer">
        <button id="btnCerrarMP" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

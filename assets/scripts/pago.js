 $(document).ready(function() {

 	$("#institucionPago").change(function() {
		/*institucion = $("#institucion").val();
		var baseurl = window.origin + '/minsal/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospital").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospital").append(row);
	        }
      	}
    	});*/
		listarReportes();
	});


 	$("#hospitalPago").change(function() {
		listarReportes();
	});

	$("#mesPago").change(function() {
		listarReportes();
	});

	$("#anioPago").change(function() {
		listarReportes();
	});

	$('#principalPago').on('change',function(e){
    	listarReportes();
	});

  	function listarReportes()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionPago").val();
	    hospital = $("#hospitalPago").val();
	    mes = $("#mesPago").val();
	    anio = $("#anioPago").val();
		proveedor = $('#principalPago').val();

	    var baseurl = window.origin + '/Pago/listarPagosFiltrados';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, mes: mes, anio: anio, proveedor: proveedor },
		success: function(data) {
	        if (data)
	        {
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_area_transaccional'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['folio'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['tipo_operacion'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['fecha_generacion'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['cta_contable'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_tipo_documento'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nro_documento'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['fecha_cumplimiento'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['combinacion_catalogo'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_principal'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_principal_relacionado'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_beneficiario'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_banco'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['cta_corriente_banco'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['medio_pago'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nombre_tipo_medio_pago'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['nro_documento_pago'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['fecha_emision'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['estado_documento'],'</p></td>');
					row = row.concat('\n<td class="text-right"><p class="texto-pequenio">','$ ',formatNumber(data[i]['monto']),'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['moneda'],'</p></td>');
					row = row.concat('\n<td class="text-left"><p class="texto-pequenio">',data[i]['tipo_cambio'],'</p></td>');
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }		
		        feather.replace()
					loader.setAttribute('hidden', '');
	        }
      	}
    	});
  	};

  	

	function formatNumber (n) {
		n = String(n).replace(/\D/g, "");
	  return n === '' ? n : Number(n).toLocaleString();
	}

	Number.addEventListener('keyup', (e) => {
		const element = e.target;
		const value = element.value;
	  element.value = formatNumber(value);
	});
});


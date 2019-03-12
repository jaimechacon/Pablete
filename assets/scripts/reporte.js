 $(document).ready(function() {

 	$("#institucion").change(function() {
		institucion = $("#institucion").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
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
    	});
		listarReportes();
		listarReporteResumenGrafico();
		cargarGraficos();
	});

	$("#institucionItem").change(function() {
		institucion = $("#institucionItem").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalItem").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalItem").append(row);
				listarReportesItem();
	        }
      	}
    	});		
	});

	$("#institucionAsignacion").change(function() {
		institucion = $("#institucionAsignacion").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalAsignacion").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalAsignacion").append(row);
				listarReportesAsignacion();
	        }
      	}
    	});
	});

	$("#institucionSubAsignacion").change(function() {
		institucion = $("#institucionSubAsignacion").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalSubAsignacion").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalSubAsignacion").append(row);
				listarReportesSubAsignacion();
	        }
      	}
    	});    	
	});

	$("#institucionEspecifico").change(function() {
		institucion = $("#institucionEspecifico").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalEspecifico").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalEspecifico").append(row);
				listarReportesEspecifico();
	        }
      	}
    	});    	
	});

	$("#institucionFecha").change(function() {
		institucion = $("#institucionFecha").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalFecha").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalFecha").append(row);
				listarReportesFecha();
	        }
      	}
    	});    	
	});

	$("#institucionEF").change(function() {
		institucion = $("#institucionEF").val();
		var baseurl = window.origin + '/Reporte/listarHospitalesInstitucion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion },
		success: function(data) {
	        if (data)
	        {			
				$("#hospitalEF").empty();
				var row = '<option value="-1">Todos</option>';
				for (var i = 0; i < data.length; i++) {
					row = row.concat('\n<option value="',data[i]["id_hospital"],'">',data[i]["nombre"], '</option>');
				}
				$("#hospitalEF").append(row);
				listarReportesEquilibrioFinanciero();
				cargarGraficosEF();
	        }
      	}
    	});    	
	});

 	$("#hospital").change(function() {
		listarReportes();
		listarReporteResumenGrafico();
		cargarGraficos();
	});

	$("#hospitalItem").change(function() {
		listarReportesItem();
	});

	$("#hospitalAsignacion").change(function() {
		listarReportesAsignacion();
	});

	$("#hospitalSubAsignacion").change(function() {
		listarReportesSubAsignacion();
	});

	$("#hospitalEspecifico").change(function() {
		listarReportesEspecifico();
	});

	$("#hospitalFecha").change(function() {
		listarReportesFecha();
	});

	$("#hospitalEF").change(function() {
		listarReportesEquilibrioFinanciero();
		cargarGraficosEF();
	});

	$("#cuenta").change(function() {
		listarReportes();
	});

	$("#mes").change(function() {
		listarReportesFecha();
	});

	$("#anio").change(function() {
		listarReportesFecha();
	});

	$('#inflactor').on('change',function(e){
    	listarReportesFecha();
	});

	$("#mesEF").change(function() {
		listarReportesEquilibrioFinanciero();
		cargarGraficosEF();
	});

	$("#anioEF").change(function() {
		listarReportesEquilibrioFinanciero();
		cargarGraficosEF();
	});


 	function listarReportes()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucion").val();
	    hospital = $("#hospital").val();
	    cuenta = $("#cuenta").val();
	    item = $("#item").val();

	    var baseurl = window.origin + '/Reporte/listarReporteResumen';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['ppto_vigente']),'</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['ejec'],'%</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
			            row = row.concat('\n<th class="text-center table-active"></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">');
		            	row = row.concat((data[i]['codigo'] + ' ' + data[i]['nombre']));
		            	row = row.concat('</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['ppto_vigente']),'</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['ejec'],'%</p></td>');
			            row = row.concat('\n <td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
			            row = row.concat('\n<td class="text-center botonTabla">');
			            row = row.concat('\n<button type="button" class="btn btn-link redireccionarItem botonTabla" data-id="',data[i]["id_cuenta"],'" data-toggle="tooltip" title="click para ver detalle de cuenta">');
			            row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
						//row = row.concat('\n<a href="listarReportesItem/?idCuenta=',data[i]['id_cuenta'],'" title="click para ver detalle de cuenta"><i data-feather="search" class="trash"></i></a>');
						row = row.concat('\n</td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }


		        institucion = $("#institucion").val();
			    hospital = $("#hospital").val();
			    cuenta = $("#cuenta").val();
			    item = $("#item").val();

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['ppto_vigente']),'</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['ejec'],'%</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
					            row = row.concat('\n<th class="text-center table-active"></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">');
				            	row = row.concat((data[i]['codigo'] + ' ' + data[i]['nombre']));
				            	row = row.concat('</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['ppto_vigente']),'</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['ejec'],'%</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
					            row = row.concat('\n<td class="text-center botonTabla">');
					            row = row.concat('\n<button type="button" class="btn btn-link redireccionarItem botonTabla" data-id="',data[i]["id_cuenta"],'" data-toggle="tooltip" title="click para ver detalle de cuenta">');
					            row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
								//row = row.concat('\n<a href="listarReportesItem/?idCuenta=',data[i]['id_cuenta'],'" title="click para ver detalle de cuenta"><i data-feather="search" class="trash"></i></a>');
								row = row.concat('\n</td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }


				        institucion = $("#institucion").val();
					    hospital = $("#hospital").val();
					    cuenta = $("#cuenta").val();
					    item = $("#item").val();

				    	var baseurl = window.origin + '/Reporte/listarReporteResumenTipo';
					    jQuery.ajax({
						type: "POST",
						url: baseurl,
						dataType: 'json',
						data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
						success: function(data) {
					        if (data)
					        {			
					        	$("#tbodyReporteResumenTipo").empty();
								for (var i = 0; i < data.length; i++){
						            var row = '';
						            row = row.concat('<tr>');
						            if(data[i]['nombre'] == 'Total')
						            {
						            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['abreviacion'],'</p></th>');
							            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['presupuesto']),'</p></th>');
							            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['recaudado']),'</p></th>');
							            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var'],'%</p></th>');
							            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
						            }else{
							            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['abreviacion'],'</p></td>');
							            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['presupuesto']),'</p></td>');
							            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['recaudado']),'</p></td>');
							            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var'],'%</p></td>');
							            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
						        	}
						            row = row.concat('\n</tr>');
						          $("#tbodyReporteResumenTipo").append(row);
						        }


						        institucion = $("#institucion").val();
							    hospital = $("#hospital").val();
							    cuenta = $("#cuenta").val();
							    item = $("#item").val();

						    	var baseurl = window.origin + '/Reporte/listarReporteResumenTipoGasto';
							    jQuery.ajax({
								type: "POST",
								url: baseurl,
								dataType: 'json',
								data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
								success: function(data) {
							        if (data)
							        {			
							        	$("#tbodyReporteResumenGastoTipo").empty();
										for (var i = 0; i < data.length; i++){
								            var row = '';
								            row = row.concat('<tr>');
								            if(data[i]['nombre'] == 'Total')
								            {
								            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['abreviacion'],'</p></th>');
									            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['recaudado']),'</p></th>');
									            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['devengado']),'</p></th>');
									            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['por_percibir']),'</p></th>');
								            }else{
									            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['abreviacion'],'</p></td>');
									            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['recaudado']),'</p></td>');
									            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['devengado']),'</p></td>');
									            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['por_percibir']),'</p></td>');
								        	}
								            row = row.concat('\n</tr>');
								          $("#tbodyReporteResumenGastoTipo").append(row);
								        }

								        feather.replace()
				      					loader.setAttribute('hidden', '');
		      						}
						      	}
							    });
	      					}
				      	}
					    });
			        }
		      	}
		    	});
	        }
      	}
    	});

  	};

  	function listarReportesItem()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionItem").val();
	    hospital = $("#hospitalItem").val();
	    cuentaSeleccion = $(document.getElementById('cuentaSeleccion'));
		cuenta = cuentaSeleccion.data('id');
	    item = -1;//$("#item").val();

	    var baseurl = window.origin + '/Reporte/listarReporteResumenItem';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
			            row = row.concat('\n<th class="text-center table-active"></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n <td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
			            row = row.concat('\n<td class="text-center botonTabla">');
			            row = row.concat('\n<button type="button" class="btn btn-link redireccionarAsignacion botonTabla" data-id="',data[i]["id_item"],'" data-toggle="tooltip" title="click para ver detalle de item">');
					    row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
						//row = row.concat('\n<a href="listarReportesAsignacion/?idItem=',data[i]['id_item'],'" title="click para ver detalle de item"><i data-feather="search" class="trash"></i></a>');
						row = row.concat('\n</td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }


		        institucion = $("#institucionItem").val();
			    hospital = $("#hospitalItem").val();
			    cuentaSeleccion = $(document.getElementById('cuentaSeleccion'));
				cuenta = cuentaSeleccion.data('id');
			    item = -1;//$("#item").val();

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenItemGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
					            row = row.concat('\n<th class="text-center table-active"></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
					            row = row.concat('\n<td class="text-center botonTabla">');
					            row = row.concat('\n<button type="button" class="btn btn-link redireccionarAsignacion botonTabla" data-id="',data[i]["id_item"],'" data-toggle="tooltip" title="click para ver detalle de item">');
					    		row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
								//row = row.concat('\n<a href="listarReportesAsignacion/?idItem=',data[i]['id_item'],'" title="click para ver detalle de item"><i data-feather="search" class="trash"></i></a>');
								row = row.concat('\n</td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }
				        feather.replace()
      					loader.setAttribute('hidden', '');
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};

  	function listarReportesAsignacion()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionAsignacion").val();
	    hospital = $("#hospitalAsignacion").val();
	    itemSeleccion = $(document.getElementById('itemSeleccion'));
	    cuenta = itemSeleccion.data('idcuenta');
		item = itemSeleccion.data('id');

	    var baseurl = window.origin + '/Reporte/listarReporteResumenAsignacion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
			            row = row.concat('\n<th class="text-center table-active"></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n <td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
			            row = row.concat('\n<td class="text-center botonTabla">');
			            row = row.concat('\n<button type="button" class="btn btn-link redireccionarSubAsignacion botonTabla" data-id="',data[i]["id_asignacion"],'" data-toggle="tooltip" title="click para ver detalle de de asignaci&oacute;n">');
					    row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
						//row = row.concat('\n<a href="listarReportesSubAsignacion/?idAsignacion=',data[i]['id_asignacion'],'" title="click para ver detalle de asignaci&oacute;n"><i data-feather="search" class="trash"></i></a>');
						row = row.concat('\n</td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }


		        institucion = $("#institucionAsignacion").val();
			    hospital = $("#hospitalAsignacion").val();
			    itemSeleccion = $(document.getElementById('itemSeleccion'));
			    cuenta = itemSeleccion.data('idcuenta');
				item = itemSeleccion.data('id');

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenAsignacionGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
					            row = row.concat('\n<th class="text-center table-active"></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
					            row = row.concat('\n<td class="text-center botonTabla">');
								row = row.concat('\n<button type="button" class="btn btn-link redireccionarSubAsignacion botonTabla" data-id="',data[i]["id_asignacion"],'" data-toggle="tooltip" title="click para ver detalle de de asignaci&oacute;n">');
					    		row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
								//row = row.concat('\n<a href="listarReportesSubAsignacion/?idAsignacion=',data[i]['id_asignacion'],'" title="click para ver detalle de asignacion"><i data-feather="search" class="trash"></i></a>');
								row = row.concat('\n</td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }
				        feather.replace()
      					loader.setAttribute('hidden', '');
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};

  	function listarReportesSubAsignacion()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionSubAsignacion").val();
	    hospital = $("#hospitalSubAsignacion").val();
	    asignacionSeleccion = $(document.getElementById('asignacionSeleccion'));
	    cuenta = asignacionSeleccion.data('idcuenta');
	    item = asignacionSeleccion.data('iditem');
		asignacion = asignacionSeleccion.data('id');
	    //item = -1;//$("#item").val();

	    var baseurl = window.origin + '/Reporte/listarReporteResumenSubAsignacion';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, item: item, asignacion: asignacion},
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
			            row = row.concat('\n<th class="text-center table-active"></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n <td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
			            row = row.concat('\n<td class="text-center botonTabla">');
						row = row.concat('\n<button type="button" class="btn btn-link redireccionarEspecifico botonTabla" data-id="',data[i]["id_sub_asignacion"],'" data-toggle="tooltip" title="click para ver detalle de de sub asignaci&oacute;n">');
			    		row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
						//row = row.concat('\n<a href="listarReportesEspecifico/?idSubAsignacion=',data[i]['id_sub_asignacion'],'" title="click para ver detalle de Sub Asignaci&oacute;n"><i data-feather="search" class="trash"></i></a>');
						row = row.concat('\n</td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }


		        institucion = $("#institucionSubAsignacion").val();
			    hospital = $("#hospitalSubAsignacion").val();
			    asignacionSeleccion = $(document.getElementById('asignacionSeleccion'));
			    cuenta = asignacionSeleccion.data('idcuenta');
			    item = asignacionSeleccion.data('iditem');
				asignacion = asignacionSeleccion.data('id');

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenSubAsignacionGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item, asignacion: asignacion },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
					            row = row.concat('\n<th class="text-center table-active"></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
					            row = row.concat('\n<td class="text-center botonTabla">');
					            row = row.concat('\n<button type="button" class="btn btn-link redireccionarEspecifico botonTabla" data-id="',data[i]["id_sub_asignacion"],'" data-toggle="tooltip" title="click para ver detalle de de sub asignaci&oacute;n">');
			    				row = row.concat('\n<i data-feather="search" class="trash"></i></button>');
								//row = row.concat('\n<a href="listarReportesEspecifico/?idSubAsignacion=',data[i]['id_sub_asignacion'],'" title="click para ver detalle de Sub asignaci&oacute;n"><i data-feather="search" class="trash"></i></a>');
								row = row.concat('\n</td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }
				        feather.replace()
      					loader.setAttribute('hidden', '');
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};


	function listarReportesEspecifico()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionEspecifico").val();
	    hospital = $("#hospitalEspecifico").val();
	    subasignacionSeleccion = $(document.getElementById('subasignacionSeleccion'));
	    cuenta = subasignacionSeleccion.data('idcuenta');
	    item = subasignacionSeleccion.data('iditem');
	    asignacion = subasignacionSeleccion.data('idasignacion');
	    subAsignacion = subasignacionSeleccion.data('id');

	    var baseurl = window.origin + '/Reporte/listarReporteResumenEspecifico';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, item: item, asignacion: asignacion, subAsignacion: subAsignacion},
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
			            //row = row.concat('\n<th class="text-center table-active"></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n <td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
			            //row = row.concat('\n<td class="text-center">');
						//row = row.concat('\n<a href="listarReportesEspecifico/?idSubAsignacion=',data[i]['id_sub_asignacion'],'" title="click para ver detalle de Sub Asignaci&oacute;n"><i data-feather="search" class="trash"></i></a>');
						//row = row.concat('\n</td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		        }


		        institucion = $("#institucionEspecifico").val();
			    hospital = $("#hospitalEspecifico").val();
			    subasignacionSeleccion = $(document.getElementById('subasignacionSeleccion'));
			    cuenta = subasignacionSeleccion.data('idcuenta');
			    item = subasignacionSeleccion.data('iditem');
			    asignacion = subasignacionSeleccion.data('idasignacion');
			    subAsignacion = subasignacionSeleccion.data('id');

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenEspecificoGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, item: item, asignacion: asignacion, subAsignacion: subAsignacion },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></th>');
					            //row = row.concat('\n<th class="text-center table-active"></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado_2017_con_mult']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var_18_17'],'%</p></td>');
					            //row = row.concat('\n<td class="text-center">');
								//row = row.concat('\n<a href="listarReportesEspecifico/?idSubAsignacion=',data[i]['id_sub_asignacion'],'" title="click para ver detalle de Sub asignaci&oacute;n"><i data-feather="search" class="trash"></i></a>');
								//row = row.concat('\n</td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }
				        feather.replace()
      					loader.setAttribute('hidden', '');
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};

  	function listarReportesFecha()
  	{ 	
 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionFecha").val();
	    hospital = $("#hospitalFecha").val();
		cuenta = -1;
	    item = -1;
	    mes = $("#mes").val();
	    anio = $("#anio").val();
		inflactor = ($('#inflactor').val().length == 0 ? -1 : $('#inflactor').val());

	    var baseurl = window.origin + '/Reporte/listarReporteResumenFecha';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, mes: mes, anio: anio, inflactor: inflactor },
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nombre'] == 'Total')
		            {
		            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
			            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado']),'</p></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado']),'</p></td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		          $('#idAnio').text("I. Rec. " + anio);
		          $('#idAnioGasto').text("G. Dev. " + anio);
		        }


		        institucion = $("#institucionFecha").val();
			    hospital = $("#hospitalFecha").val();
				cuenta = -1;
			    item = -1;
			    mes = $("#mes").val();
			    anio = $("#anio").val();
			    inflactor = ($('#inflactor').val().length == 0 ? -1 : $('#inflactor').val());

		    	var baseurl = window.origin + '/Reporte/listarReporteResumenFechaGasto';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, cuenta: cuenta, mes: mes, anio: anio, inflactor: inflactor },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumenGasto").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nombre'] == 'Total')
				            {
				            	row = row.concat('\n<th class="table-active"><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-center table-active"><p class="texto-pequenio">','----','</p></th>');
					            row = row.concat('\n<th class="text-right table-active"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado']),'</p></th>');
				            }else{
					            row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['codigo'],' ', data[i]['nombre'],'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">','----','</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['Recaudado']),'</p></td>');
				        	}
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumenGasto").append(row);
				        }
				        feather.replace()
      					loader.setAttribute('hidden', '');
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};

  	function listarReportesEquilibrioFinanciero()
  	{ 	

 		var loader = document.getElementById("loader");
	    loader.removeAttribute('hidden');
	    institucion = $("#institucionEF").val();
	    hospital = $("#hospitalEF").val();
		cuenta = -1;
	    item = -1;
	    mes = $("#mesEF").val();
	    anio = $("#anioEF").val();
		
	    var baseurl = window.origin + '/Reporte/listarReportesEquilibrioFinancieroFiltro';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, mes: mes, anio: anio},
		success: function(data) {
	        if (data)
	        {
				$("#tbodyReporteResumen").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">', data[i]['nombreMes'].charAt(0).toUpperCase(), data[i]['nombreMes'].slice(1) ,'</p></td>');    
		            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['anio'],'</p></td>');    
					row = row.concat('\n<td class="text-center"><p class="texto-pequenio">$ ',formatNumber(data[i]['gastos']),'</p></td>');
					row = row.concat('\n<td class="text-center"><p class="texto-pequenio">$ ',formatNumber(data[i]['ingresos']),'</p></td>');
	            	row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['cumplimiento'],'</p></td>');
	            	row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['puntuacion'],'</p></td>');
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumen").append(row);
		          //$('#idAnio').text("I. Rec. " + anio);
		          //$('#idAnioGasto').text("G. Dev. " + anio);
		        }
		        loader.setAttribute('hidden', '');
	        }
      	}
    	});
  	};

  	function listarReporteResumenGrafico()
  	{
	    institucion = $("#institucion").val();
	    hospital = $("#hospital").val();
	    tipo = 1;
	  

	    var baseurl = window.origin + '/Reporte/listarReporteResumenGrafico';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, tipo: tipo },
		success: function(data) {
	        if (data)
	        {			
				$("#tbodyReporteResumenGrafico").empty();
				for (var i = 0; i < data.length; i++){
		            var row = '';
		            row = row.concat('<tr>');
		            if(data[i]['nivel'] == '1')
		            {
		            	row = row.concat('\n<th class=""><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
			            row = row.concat('\n<th class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2017']),'</p></th>');
			            row = row.concat('\n<th class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2018']),'</p></th>');
			            row = row.concat('\n<th class="text-center"><p class="texto-pequenio">',data[i]['var'],'%</p></th>');
		            }else{
		            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['nombreAsignacion'],'</p></th>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2017']),'</p></td>');
			            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2018']),'</p></td>');
			            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var'],'%</p></td>');
		            }
		            row = row.concat('\n<tr>');
		          $("#tbodyReporteResumenGrafico").append(row);
		        }


		        institucion = $("#institucion").val();
	    		hospital = $("#hospital").val();
	    		tipo = 2;

			    var baseurl = window.origin + '/Reporte/listarReporteResumenGrafico';
			    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, tipo: tipo },
				success: function(data) {
			        if (data)
			        {			
						$("#tbodyReporteResumen22").empty();
						for (var i = 0; i < data.length; i++){
				            var row = '';
				            row = row.concat('<tr>');
				            if(data[i]['nivel'] == '1')
				            {
				            	row = row.concat('\n<th class=""><p class="texto-pequenio">',data[i]['nombre'],'</p></th>');
					            row = row.concat('\n<th class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2017']),'</p></th>');
					            row = row.concat('\n<th class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2018']),'</p></th>');
					            row = row.concat('\n<th class="text-center"><p class="texto-pequenio">',data[i]['var'],'%</p></th>');
				            }else{
				            	row = row.concat('\n<td class=""><p class="texto-pequenio">',data[i]['nombreAsignacion'],'</p></th>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2017']),'</p></td>');
					            row = row.concat('\n<td class="text-right"><p class="texto-pequenio">$ ',formatNumber(data[i]['total_2018']),'</p></td>');
					            row = row.concat('\n<td class="text-center"><p class="texto-pequenio">',data[i]['var'],'%</p></td>');
				            }
				            row = row.concat('\n</tr>');
				          $("#tbodyReporteResumen22").append(row);
				        }
			        }
		      	}
		    	});
	        }
      	}
    	});
  	};

  	$('#tReporteResumen,#tReporteResumenGasto,#botones').on('click', '.redireccionarSubtitulo', function(e) {
  	//$('.redireccionarSubtitulo').on('click', function(e) {
  		var loader = document.getElementById("loader");
    	loader.removeAttribute('hidden');
    	//var idCuenta = e.currentTarget.dataset.id;

    	idInstitucion = "";
    	idArea = "";
    	idCuenta = "";

    	if (e.currentTarget.className.indexOf('botonTabla', 0) > 0) {
	    	var url = window.location.href.split("?")[0].replace("ListarReportes", "ListarReportesItem");
	    	idInstitucion = $("#institucion").val();
	    	idArea = $("#hospital").val();
	    	idCuenta = e.currentTarget.dataset.id;
		}else
    	{
    		var url = window.location.href.split("?")[0].replace("ListarReportesItem", "ListarReportes");
    		idInstitucion = $("#institucionItem").val();
	    	idArea = $("#hospitalItem").val();
		}

	    if(idInstitucion > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idInstitucion=', idInstitucion);
	    	else
	    		url = url.concat('?idInstitucion=', idInstitucion);

	    if(idArea > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idArea=', idArea);
	    	else
	    		url = url.concat('?idArea=', idArea);

	    if(idCuenta != "")
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idCuenta=', idCuenta);
	    	else
	    		url = url.concat('?idCuenta=', idCuenta);   

	    window.location.href = url;
	});

	$('#tReporteResumen,#tReporteResumenGasto,#botones').on('click', '.redireccionarItem', function(e) {
  	//$('.redireccionarItem').click(function() {
  		var loader = document.getElementById("loader");
    	loader.removeAttribute('hidden');
    	var idCuenta = "";
    	var idInstitucion = "";
    	var idArea = "";

    	if (e.currentTarget.className.indexOf('botonTabla', 0) > 0) {
    		var url = window.location.href.split("?")[0].replace("ListarReportes", "ListarReportesItem");
    		idInstitucion = $("#institucion").val();
    		idArea = $("#hospital").val();
    		idCuenta = e.currentTarget.dataset.id;    		
    	}else
    	{
    		var url = window.location.href.split("?")[0].replace("ListarReportesAsignacion", "ListarReportesItem");
    		idInstitucion = $("#institucionAsignacion").val();
    		idArea = $("#hospitalAsignacion").val();
    		idCuenta = $('#itemSeleccion').data('idcuenta');
		}

	    if(idInstitucion > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idInstitucion=', idInstitucion);
	    	else
	    		url = url.concat('?idInstitucion=', idInstitucion);

	    if(idArea > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idArea=', idArea);
	    	else
	    		url = url.concat('?idArea=', idArea);

	    if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idCuenta=', idCuenta);
	    	else
	    		url = url.concat('?idCuenta=', idCuenta);

	    window.location.href = url;
	});

	$('#tReporteResumen,#tReporteResumenGasto,#botones').on('click', '.redireccionarAsignacion', function(e) {
  	//$('.redireccionarAsignacion').on('click', function(e) {
  		var loader = document.getElementById("loader");
    	loader.removeAttribute('hidden');

    	var idInstitucion = "";
    	var idArea = "";
    	var idCuenta = "";
    	var idItem = "";

    	if (e.currentTarget.className.indexOf('botonTabla', 0) > 0) {
    		var url = window.location.href.split("?")[0].replace("ListarReportesItem", "ListarReportesAsignacion");
    		idInstitucion = $("#institucionItem").val();
	    	idArea = $("#hospitalItem").val();
	    	idCuenta = $("#cuentaSeleccion").data('id');
	    	idItem = (e.currentTarget.dataset.id == "" ? null : e.currentTarget.dataset.id);
    	}else
    	{
    		var url = window.location.href.split("?")[0].replace("ListarReportesSubAsignacion", "ListarReportesAsignacion");
    		idInstitucion = $("#institucionSubAsignacion").val();
	    	idArea = $("#hospitalSubAsignacion").val();
	    	idCuenta = $("#asignacionSeleccion").data('idcuenta');
	    	idItem = $("#asignacionSeleccion").data('iditem');
    	}

	    if(idInstitucion > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idInstitucion=', idInstitucion);
	    	else
	    		url = url.concat('?idInstitucion=', idInstitucion);

	    if(idArea > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idArea=', idArea);
	    	else
	    		url = url.concat('?idArea=', idArea);

    	if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idCuenta=', idCuenta);
    	else
    		url = url.concat('?idCuenta=', idCuenta);

    	
    	if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idItem=', idItem);
    	else
    		url = url.concat('?idItem=', idItem);

	    window.location.href = url;
	});

	$('#tReporteResumen,#tReporteResumenGasto,#botones').on('click', '.redireccionarSubAsignacion', function(e) {
	//$('.redireccionarSubAsignacion').on('click', function(e) {
  		var loader = document.getElementById("loader");
    	loader.removeAttribute('hidden');
    	
    	var idInstitucion = "";
    	var idArea = "";
    	var idCuenta = "";
    	var idItem = "";
    	var idAsignacion = "";

    	if (e.currentTarget.className.indexOf('botonTabla', 0) > 0) {
    		var url = window.location.href.split("?")[0].replace("ListarReportesAsignacion", "ListarReportesSubAsignacion");
    		idInstitucion = $("#institucionAsignacion").val();
	    	idArea = $("#hospitalAsignacion").val();
	    	idCuenta = $("#itemSeleccion").data('idcuenta');
	    	idItem = $("#itemSeleccion").data('id');
	    	idAsignacion = e.currentTarget.dataset.id;
    	}else
    	{
		    var url = window.location.href.split("?")[0].replace("ListarReportesEspecifico", "ListarReportesSubAsignacion");
		    idInstitucion = $("#institucionEspecifico").val();
	    	idArea = $("#hospitalEspecifico").val();
	    	idCuenta = $("#subasignacionSeleccion").data('idcuenta');
	    	idItem = $("#subasignacionSeleccion").data('iditem');
	    	idAsignacion = $("#subasignacionSeleccion").data('idasignacion');
		}

	    if(idInstitucion > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idInstitucion=', idInstitucion);
	    	else
	    		url = url.concat('?idInstitucion=', idInstitucion);

	    if(idArea > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idArea=', idArea);
	    	else
	    		url = url.concat('?idArea=', idArea);
	    
	    if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idCuenta=', idCuenta);
    	else
    		url = url.concat('?idCuenta=', idCuenta);

	    if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idItem=', idItem);
    	else
    		url = url.concat('?idItem=', idItem);

    	if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idAsignacion=', idAsignacion);
    	else
    		url = url.concat('?idAsignacion=', idAsignacion);

	    window.location.href = url;
	});

	$('#tReporteResumen,#tReporteResumenGasto,#botones').on('click', '.redireccionarEspecifico', function(e) {
	//$('.redireccionarEspecifico').on('click', function(e) {
  		var loader = document.getElementById("loader");
    	loader.removeAttribute('hidden');
    	var idInstitucion = $("#institucionSubAsignacion").val();
    	var idArea = $("#hospitalSubAsignacion").val();
    	var idCuenta = $("#asignacionSeleccion").data('idcuenta');
    	var idItem = $("#asignacionSeleccion").data('iditem');
    	var idAsignacion = $("#asignacionSeleccion").data('id');
    	var idSubAsignacion = e.currentTarget.dataset.id;

    	var url = window.location.href.split("?")[0].replace("ListarReportesSubAsignacion", "ListarReportesEspecifico");

	    if(idInstitucion > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idInstitucion=', idInstitucion);
	    	else
	    		url = url.concat('?idInstitucion=', idInstitucion);

	    if(idArea > 0)
	    	if (url.indexOf('?', 0) > 0)
	    		url = url.concat('&idArea=', idArea);
	    	else
	    		url = url.concat('?idArea=', idArea);

	    if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idCuenta=', idCuenta);
    	else
    		url = url.concat('?idCuenta=', idCuenta);

	    if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idItem=', idItem);
    	else
    		url = url.concat('?idItem=', idItem);

    	if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idAsignacion=', idAsignacion);
    	else
    		url = url.concat('?idAsignacion=', idAsignacion);

    	if (url.indexOf('?', 0) > 0)
    		url = url.concat('&idSubAsignacion=', idSubAsignacion);
    	else
    		url = url.concat('?idSubAsignacion=', idSubAsignacion);

	    window.location.href = url;
	});

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


window.onload = function () {
	if(window.location.pathname.split('/')[2].toLowerCase() == 'ListarReportes'.toLowerCase())
	{
		cargarGraficos();
	}

	if(window.location.pathname.split('/')[2].toLowerCase() == 'listarReportesEquilibrioFinanciero'.toLowerCase())
	{
		cargarGraficosEF();
	}
}



	function cargarGraficosEF(){
		 institucion = $("#institucionEF").val();
	    hospital = $("#hospitalEF").val();
		cuenta = -1;
	    item = -1;
	    mes = $("#mesEF").val();
	    anio = $("#anioEF").val();
		var dataPoints_2017 = [];
		var dataPoints_2018 = [];

	    var baseurl = window.origin + '/Reporte/listarReportesEquilibrioFinancieroFiltro';
	    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, mes: mes, anio: anio},
		success: function(data) {
	        if (data)
	        {
				var dataPointsGeneral1 = [];
				var dataPoints11 = [];
				var dataPoints12 = [];

	        	var anio1 = data[0]["anio"];
	        	var pon_2017 = data[0]['2017'];
	        	var pon_2018 = data[0]['2018'];
				for (var i = 0; i < data.length; i++) {
					if(anio1 != data[i]["anio"] || (i + 1) == data.length){
						var legend = '';
						if(anio1 == '2017')
							legend = parseFloat(pon_2017).toFixed(4);
						else
							legend = parseFloat(pon_2018).toFixed(4);
						dataPoints12.push({
							type: "spline",
							showInLegend: true,
							//yValueFormatString: "##.00mn",
							name: anio.concat(' - ', legend),
							dataPoints: dataPoints11
						});

						dataPointsGeneral1.push(dataPoints12[0]);
						dataPoints11 = [];
						dataPoints12 = [];
						anio1 = data[i]["anio"];
						dataPoints11.push({
							label: data[i]['nombreMes'],
							y: parseFloat(data[i]['cumplimiento'])
						});

					}else{
						dataPoints11.push({
							label: data[i]['nombreMes'],
							y: parseFloat(data[i]['cumplimiento'])
						});
					}
				}

	        	/*for (var i = 0; i < data.length; i++) {

					if(data[i]["anio"] == 2017)
					{
						dataPoints_2017.push({
						label: data[i]["nombreMes"],
						y: parseFloat(data[i]["puntuacion"]),
						anio: data[i]["anio"]
						});
					}

					if(data[i]["anio"] == 2018)
					{
						dataPoints_2018.push({
						label: data[i]["nombreMes"],
						y: parseFloat(data[i]["puntuacion"]),
						anio: data[i]["anio"]
						});
					}
				}*/

				var chart = new CanvasJS.Chart("chartContainer", {
					theme:"light2",
					animationEnabled: true,
					title:{
						text: "Equilibrio Financiero"
					},
					axisY :{
						includeZero: false,
						title: "Puntuacion"
						//suffix: "mn"
					},
					toolTip: {
						shared: "true"
					},
					legend:{
						cursor:"pointer",
						itemclick : toggleDataSeries
					},
					data: dataPointsGeneral1
				});

				 /*var chart = new CanvasJS.Chart("chartContainer", {
					animationEnabled: true,
					title:{
						text: "Subt. 21"
					},
					axisY: {
						title: "Vista por M$",
						titleFontColor: "#4F81BC",
						lineColor: "#4F81BC",
						labelFontColor: "#4F81BC",
						tickColor: "#4F81BC",
						//labelFormatter: "#,###,,.##M",
						valueFormatString: "$#,###,,.##M"
					},
					axisY2: {
						title: "Vista por M$",
						titleFontColor: "#C0504E",
						lineColor: "#C0504E",
						labelFontColor: "#C0504E",
						tickColor: "#C0504E",
						//labelFormatter: "#,###,,.##M",
						valueFormatString: "$#,###,,.##M"
					},	
					toolTip: {
						shared: true
					},
					legend: {
						cursor:"pointer",
						itemclick: toggleDataSeries
					},
					data: [{
						type: "spline",
						name: "2017 Subt. 21",
						legendText: "2017 Subt. 21",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #4F81BC;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPoints_2017
					},
					{
						type: "spline",	
						name: "2018 Subt. 21",
						axisYType: "secondary",
						legendText: "2018 Subt. 21",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #C0504E;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPoints_2018
					}]
				});
				*/
		        
		       
			chart.render();

			function toggleDataSeries(e){
				if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				}
				else{
					e.dataSeries.visible = true;
				}
				chart.render();
			}
	        }
      	}
    	});
	}




	function cargarGraficos(){

		var institucion = $("#institucion").val();
		var hospital = $("#hospital").val();
		var cuenta = -1;//$("#asignacionSeleccion").data('idcuenta');
		var tipo = 1;

		var baseurl = window.origin + '/Reporte/listarReporteGrafico';
		var dataPointsSub21_2017 = [];
		var dataPointsSub21_2018 = [];
		var dataPointsSub22_2017 = [];
		var dataPointsSub22_2018 = [];
		jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'json',
		data: {institucion: institucion, hospital: hospital, cuenta: cuenta, tipo :tipo},
		success: function(data) {
			if(data)
			{
				for (var i = 0; i < data.length; i++) {

					if(data[i]["subt"] == "subt1")
					{
						if(data[i]["anio"] == 2017)
						{
							dataPointsSub21_2017.push({
							label: data[i]["nombreMes"],
							y: parseFloat(data[i]["total"]),
							anio: data[i]["anio"]
							});
						}

						if(data[i]["anio"] == 2018)
						{
							dataPointsSub21_2018.push({
							label: data[i]["nombreMes"],
							y: parseFloat(data[i]["total"]),
							anio: data[i]["anio"]
							});
						}
					}else{
						if(data[i]["anio"] == 2017)
						{
							dataPointsSub22_2017.push({
							label: data[i]["nombreMes"],
							y: parseFloat(data[i]["total"]),
							anio: data[i]["anio"]
							});
						}

						if(data[i]["anio"] == 2018)
						{
							dataPointsSub22_2018.push({
							label: data[i]["nombreMes"],
							y: parseFloat(data[i]["total"]),
							anio: data[i]["anio"]
							});
						}
					}
				}

				    var chart = new CanvasJS.Chart("chartContainer", {
					animationEnabled: true,
					title:{
						text: "Subt. 21"
					},
					axisY: {
						title: "Vista por M$",
						titleFontColor: "#4F81BC",
						lineColor: "#4F81BC",
						labelFontColor: "#4F81BC",
						tickColor: "#4F81BC",
						//labelFormatter: "#,###,,.##M",
						valueFormatString: "$#,###,,.##M"
					},
					axisY2: {
						title: "Vista por M$",
						titleFontColor: "#C0504E",
						lineColor: "#C0504E",
						labelFontColor: "#C0504E",
						tickColor: "#C0504E",
						//labelFormatter: "#,###,,.##M",
						valueFormatString: "$#,###,,.##M"
					},	
					toolTip: {
						shared: true
					},
					legend: {
						cursor:"pointer",
						itemclick: toggleDataSeries
					},
					data: [{
						type: "column",
						name: "2017 Subt. 21",
						legendText: "2017 Subt. 21",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #4F81BC;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPointsSub21_2017
					},
					{
						type: "column",	
						name: "2018 Subt. 21",
						axisYType: "secondary",
						legendText: "2018 Subt. 21",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #C0504E;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPointsSub21_2018
					}]
				});


				
				var chart2 = new CanvasJS.Chart("chartContainer2", {
					animationEnabled: true,
					title:{
						text: "Subt. 22"
					},
					axisY: {
						title: "Vista por M$",
						titleFontColor: "#4F81BC",
						lineColor: "#4F81BC",
						labelFontColor: "#4F81BC",
						tickColor: "#4F81BC",
						valueFormatString: "$#,###,,.##M"
					},
					axisY2: {
						title: "Vista por M$",
						titleFontColor: "#C0504E",
						lineColor: "#C0504E",
						labelFontColor: "#C0504E",
						tickColor: "#C0504E",
						valueFormatString: "$#,###,,.##M"
					},	
					toolTip: {
						shared: true
					},
					legend: {
						cursor:"pointer",
						itemclick: toggleDataSeries
					},
					data: [{
						type: "column",
						name: "2017 Subt. 22",
						legendText: "2017 Subt. 22",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #4F81BC;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPointsSub22_2017
					},
					{
						type: "column",	
						name: "2018 Subt. 22",
						axisYType: "secondary",
						legendText: "2018 Subt. 22",
						showInLegend: true,
						indexLabel: "${y}",
						//indexLabelFontWeight: "bold",
						indexLabelPlacement: "inside",
						indexLabelOrientation: "vertical",
						indexLabelFontColor: "#ffffff",
						indexLabelFontSize: 11,
						toolTipContent: "<span style='\"'color: #C0504E;'\"'>{anio}:<strong>${y}</strong></span>",
						dataPoints: dataPointsSub22_2018
					}]
				});


				var baseurlGraficoProduccion = window.origin + '/Reporte/listarReporteResumenGraficoProduccion';
				var dataPointsGrafico1 = [];
				var dataPointsGrafico2 = [];
				var dataPointsGrafico3 = [];
				var dataPointsGrafico4 = [];
				var dataPointsGrafico5 = [];
				var dataPointsGrafico6 = [];

				var dataPointsGeneral1 = [];
				var dataPoints11 = [];
				var dataPoints12 = [];

				var dataPointsGeneral2 = [];
				var dataPoints21 = [];
				var dataPoints22 = [];

				var dataPointsGeneral3 = [];
				var dataPoints31 = [];
				var dataPoints32 = [];

				var dataPointsGeneral4 = [];
				var dataPoints41 = [];
				var dataPoints42 = [];

				var dataPointsGeneral5 = [];
				var dataPoints51 = [];
				var dataPoints52 = [];

				var dataPointsGeneral6 = [];
				var dataPoints61 = [];
				var dataPoints62 = [];

				jQuery.ajax({
				type: "POST",
				url: baseurlGraficoProduccion,
				dataType: 'json',
				data: {institucion: institucion, hospital: hospital, grupo :"-1"},
				success: function(data) {
					if(data)
					{
						for (var i = 0; i < data.length; i++) {
							var id_grupo_prestacion = data[i]["id_grupo_prestacion"];
							switch(id_grupo_prestacion) {
		  						case "1":
		  							dataPointsGrafico1.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto: parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;
		  						case "2":
		  							dataPointsGrafico2.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto:  parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;
		  						case "3":
		  							dataPointsGrafico3.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto:  parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;
		  						case "4":
									dataPointsGrafico5.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto: parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;
		  						case "5":
		  							dataPointsGrafico4.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto: parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;
		  						case "6":
		  							dataPointsGrafico6.push({
										anio: data[i]['anio'],
										mes: data[i]['mes'],
										nombreMes: data[i]['nombreMes'],
										monto: parseFloat(data[i]['monto']),
										id_grupo_prestacion: data[i]['id_grupo_prestacion'],
										nombre_grupo: data[i]['nombre_grupo']
									});
		  						break;

		  					}
						}

						var anio1 = dataPointsGrafico1[0]["anio"];
						var row1 = "";
						$("#tbody1").empty();
						row1 = row1.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico1[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico1.length; i++) {

							if(anio1 != dataPointsGrafico1[i]["anio"] || (i + 1) == dataPointsGrafico1.length){
								var row1 = row1.concat('</tr>');
								$("#tbody1").append(row1);
								var row1 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico1[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico1[i]['monto']),'</p></td>');
								dataPoints12.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio1,
									dataPoints: dataPoints11
								});

								dataPointsGeneral1.push(dataPoints12[0]);
								dataPoints11 = [];
								dataPoints12 = [];
								anio1 = dataPointsGrafico1[i]["anio"];
								dataPoints11.push({
									label: dataPointsGrafico1[i]['nombreMes'],
									y: dataPointsGrafico1[i]['monto']
								});

							}else{
								row1 = row1.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico1[i]["monto"]),'</p></td>');
								dataPoints11.push({
									label: dataPointsGrafico1[i]['nombreMes'],
									y: dataPointsGrafico1[i]['monto']
								});
							}
						}

						var anio2 = dataPointsGrafico2[0]["anio"];
						var row2 = "";
						$("#tbody2").empty();
						row2 = row2.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico2[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico2.length; i++) {
							if(anio2 != dataPointsGrafico2[i]["anio"] || (i + 1) == dataPointsGrafico2.length){
								var row2 = row2.concat('</tr>');
								$("#tbody2").append(row2);
								var row2 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico2[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico2[i]['monto']),'</p></td>');
								dataPoints22.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio2,
									dataPoints: dataPoints21
								});
								dataPointsGeneral2.push(dataPoints22[0]);
								dataPoints21 = [];
								dataPoints22 = [];
								anio2 = dataPointsGrafico2[i]["anio"];
								dataPoints21.push({
									label: dataPointsGrafico2[i]['nombreMes'],
									y: dataPointsGrafico2[i]['monto']
								});
							}else{
								row2 = row2.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico2[i]["monto"]),'</p></td>');
								dataPoints21.push({
									label: dataPointsGrafico2[i]['nombreMes'],
									y: dataPointsGrafico2[i]['monto']
								});
							}
						}

						var anio3 = dataPointsGrafico3[0]["anio"];
						var row3 = "";
						$("#tbody3").empty();
						row3 = row3.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico3[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico3.length; i++) {
							if(anio3 != dataPointsGrafico3[i]["anio"] || (i + 1) == dataPointsGrafico3.length){
								var row3 = row3.concat('</tr>');
								$("#tbody3").append(row3);
								var row3 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico3[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico3[i]['monto']),'</p></td>');
								dataPoints32.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio3,
									dataPoints: dataPoints31
								});
								dataPointsGeneral3.push(dataPoints32[0]);
								dataPoints31 = [];
								dataPoints32 = [];
								anio3 = dataPointsGrafico3[i]["anio"];
								dataPoints31.push({
									label: dataPointsGrafico3[i]['nombreMes'],
									y: dataPointsGrafico3[i]['monto']
								});
							}else{
								row3 = row3.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico3[i]["monto"]),'</p></td>');
								dataPoints31.push({
									label: dataPointsGrafico3[i]['nombreMes'],
									y: dataPointsGrafico3[i]['monto']
								});
							}
						}

						var anio4 = dataPointsGrafico4[0]["anio"];
						var row4 = "";
						$("#tbody4").empty();
						row4 = row4.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico4[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico4.length; i++) {
							if(anio4 != dataPointsGrafico4[i]["anio"] || (i + 1) == dataPointsGrafico4.length){
								var row4 = row4.concat('</tr>');
								$("#tbody4").append(row4);
								var row4 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico4[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico4[i]['monto']),'</p></td>');
								dataPoints42.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio4,
									dataPoints: dataPoints41
								});
								dataPointsGeneral4.push(dataPoints42[0]);
								dataPoints41 = [];
								dataPoints42 = [];
								anio4 = dataPointsGrafico4[i]["anio"];
								dataPoints41.push({
									label: dataPointsGrafico4[i]['nombreMes'],
									y: dataPointsGrafico4[i]['monto']
								});
							}else{
								row4 = row4.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico4[i]["monto"]),'</p></td>');
								dataPoints41.push({
									label: dataPointsGrafico4[i]['nombreMes'],
									y: dataPointsGrafico4[i]['monto']
								});
							}
						}

						var anio5 = dataPointsGrafico5[0]["anio"];
						var row5 = "";
						$("#tbody5").empty();
						row5 = row5.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico5[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico5.length; i++) {
							if(anio5 != dataPointsGrafico5[i]["anio"] || (i + 1) == dataPointsGrafico5.length){
								var row5 = row5.concat('</tr>');
								$("#tbody5").append(row5);
								var row5 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico5[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico5[i]['monto']),'</p></td>');
								dataPoints52.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio5,
									dataPoints: dataPoints51
								});
								dataPointsGeneral5.push(dataPoints52[0]);
								dataPoints51 = [];
								dataPoints52 = [];
								anio5 = dataPointsGrafico5[i]["anio"];
								dataPoints51.push({
									label: dataPointsGrafico5[i]['nombreMes'],
									y: dataPointsGrafico5[i]['monto']
								});
							}else{
								row5 = row5.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico5[i]["monto"]),'</p></td>');
								dataPoints51.push({
									label: dataPointsGrafico5[i]['nombreMes'],
									y: dataPointsGrafico5[i]['monto']
								});
							}
						}

						var anio6 = dataPointsGrafico6[0]["anio"];
						var row6 = "";
						$("#tbody6").empty();
						row6 = row6.concat('<tr>\n<td scope="row"><p class="texto-pequenio-grafico">',dataPointsGrafico6[0]["anio"],'</p></td>');
						for (var i = 0; i < dataPointsGrafico6.length; i++) {
							if(anio6 != dataPointsGrafico6[i]["anio"] || (i + 1) == dataPointsGrafico6.length){
								var row6 = row6.concat('</tr>');
								$("#tbody6").append(row6);
								var row6 = '<tr>\n<td scope="row"><p class="texto-pequenio-grafico">'.concat(dataPointsGrafico6[i]["anio"],'</p></td>', '<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico6[i]['monto']),'</p></td>');
								dataPoints62.push({
									type: "spline",
									showInLegend: true,
									//yValueFormatString: "##.00mn",
									name: anio6,
									dataPoints: dataPoints61
								});
								dataPointsGeneral6.push(dataPoints62[0]);
								dataPoints61 = [];
								dataPoints62 = [];
								anio6 = dataPointsGrafico6[i]["anio"];
								dataPoints61.push({
									label: dataPointsGrafico6[i]['nombreMes'],
									y: dataPointsGrafico6[i]['monto']
								});
							}else{
								row6 = row6.concat('\n<td scope="row"><p class="texto-pequenio-grafico">', formatNumber(dataPointsGrafico6[i]["monto"]),'</p></td>');
								dataPoints61.push({
									label: dataPointsGrafico6[i]['nombreMes'],
									y: dataPointsGrafico6[i]['monto']
								});
							}
						}

						var chart3 = new CanvasJS.Chart("chartContainer3", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico1[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral1
						});

						var chart4 = new CanvasJS.Chart("chartContainer4", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico2[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral2
						});

						var chart5 = new CanvasJS.Chart("chartContainer5", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico3[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral3
						});

						var chart6 = new CanvasJS.Chart("chartContainer6", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico4[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral4
						});

						var chart7 = new CanvasJS.Chart("chartContainer7", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico5[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral5
						});

						var chart8 = new CanvasJS.Chart("chartContainer8", {
							theme:"light2",
							animationEnabled: true,
							title:{
								text: dataPointsGrafico6[0]["nombre_grupo"]
							},
							axisY :{
								includeZero: false,
								title: "Cantidades"//,
								//suffix: "mn"
							},
							toolTip: {
								shared: "true"
							},
							legend:{
								cursor:"pointer",
								itemclick : toggleDataSeries
							},
							data: dataPointsGeneral6
						});


					}

					chart.render();
					chart2.render();
					chart3.render();
					chart4.render();
					chart5.render();
					chart6.render();
					chart7.render();
					chart8.render();

						
					function toggleDataSeries(e) {
						if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
							e.dataSeries.visible = false;
						}
						else {
							e.dataSeries.visible = true;
						}
						chart.render();
						chart2.render();
						chart3.render();
						chart4.render();
						chart5.render();
						chart6.render();
						chart7.render();
						chart8.render();
					}

				}
				});

				function toggleDataSeries(e) {
					if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
						e.dataSeries.visible = false;
					}
					else {
						e.dataSeries.visible = true;
					}
					chart.render();
					chart2.render();
					chart3.render();
					chart4.render();
					chart5.render();
					chart6.render();
					chart7.render();
					chart8.render();
				}
				
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

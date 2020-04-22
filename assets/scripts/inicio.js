window.onload = function() {


	var baseurl = window.origin + '/Inicio/listarConveniosGrafico';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    //data: {idPrograma: idPrograma},
    success: function(data) {
		if (data)
		{
            if (data.resultado && data.resultado == "1") {
            	var titulo = "Estado de Convenios del año ".concat(data.estadosConvenios[0].anio);

            	var chart = new CanvasJS.Chart("chartContainer", {
				theme: "light2", // "light1", "light2", "dark1", "dark2"
				exportEnabled: true,
				animationEnabled: true,
				title: {
					text: titulo
				},
				data: [{
					type: "pie",
					startAngle: 25,
					toolTipContent: "<b>{label}</b>: {y}",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - {y}",
					dataPoints: [
						{ y: parseFloat(data.estadosConvenios[0].cant_aprobados), label: "Aprobados", color: "green"},
						{ y: parseFloat(data.estadosConvenios[0].rechazados), label: "Rechazados", color: "red"},
						{ y: parseFloat(data.estadosConvenios[0].pendientes_aprobacion), label: "Pendientes de Aprobacion", color: "orange" }
					]
				}]
			});
			chart.render();
            }
       	}
            
    }
    });

}
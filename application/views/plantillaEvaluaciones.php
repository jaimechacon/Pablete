<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=" utf-8"="">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Sistema de Reportes Minsal</title>

		<!-- Core CSS - Include with every page -->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
		<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">-->
		<link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico">
		<!--<link href="/assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />-->
		<link href="http://www.divpre.info//assets/css/style.css" rel="stylesheet">
		<!--<link href="/assets/css/main-style.css" rel="stylesheet" />-->
	</head>
	<body>
		<div class="container-full">
			<div class="row pt-3">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<h3>Indicadores</h3>
						</div>
					</div>
					<hr class="my-4">
					<div class="row">
						
						
						<div class="col-sm-12 pt-3 pb-3">
							<div class="card">
								<div class="card-header">
									I. Recaudación de Ingresos (Vista en M$)
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div id="tablaReporteResumen" class="row">
								<div class="col-sm-12">
									<table id="tReporteResumen" class="table table-sm table-hover table-bordered">
										<thead class="thead-dark">
											<tr>
												<th class="text-center texto-pequenio" scope="col">Mes</th>
												<th class="text-center texto-pequenio" scope="col">Año</th>
												<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 7 y 8 ( $ )</th>
												<th class="text-center texto-pequenio" scope="col">Devengado Subt. 7 y 8 ( $ )</th>
												<th class="text-center texto-pequenio" scope="col">Porcentaje 70 % Subt. 7 y 8</th>
												<th class="text-center texto-pequenio" scope="col">Puntuación Subt. 7 y 8</th>
												<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 ( $ )</th>
												<th class="text-center texto-pequenio" scope="col">Recaudado Subt. 15 año anterior ( $ )</th>
												<th class="text-center texto-pequenio" scope="col">Porcentaje 70 % Subt. 15</th>
												<th class="text-center texto-pequenio" scope="col">Puntuación Subt. 15</th>
											</tr>
										</thead>										
										<tbody id="tbodyReporteResumen">
											<tr>
												<td class="text-center"><p class="texto-pequenio">1</p></td>
												<td class="text-center"><p class="texto-pequenio">2019</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 7.763.380,9150</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 20.957.396,3050</p></td>
												<td class="text-center"><p class="texto-pequenio">37,0436 %</p></td>
												<td class="text-center"><p class="texto-pequenio">0</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 5.817.492,3610</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 8.025.343,8270</p></td>
												<td class="text-center"><p class="texto-pequenio">-27,5110 %</p></td>
												<td class="text-center"><p class="texto-pequenio">0</p></td>
											</tr>
											<tr>
												<td class="text-center"><p class="texto-pequenio">2</p></td>
												<td class="text-center"><p class="texto-pequenio">2019</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 7.721.398,7290</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 17.718.257,4170</p></td>
												<td class="text-center"><p class="texto-pequenio">43,5788 %</p></td>
												<td class="text-center"><p class="texto-pequenio">0</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 10.215.948,7520</p></td>
												<td class="text-center"><p class="texto-pequenio">$ 14.667.297,5720</p></td>
												<td class="text-center"><p class="texto-pequenio">-30,3488 %</p></td>
												<td class="text-center"><p class="texto-pequenio">0</p></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>				
						</div>
					</div>
				</div>
			</div>
		</div>		
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="http://www.divpre.info/assets/scripts/index.js"></script>
		<script src="http://www.divpre.info/assets/scripts/reporte.js"></script>	    
		<script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.js"></script>
		<script src="https://unpkg.com/feather-icons@4.7.3/dist/feather.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
		<span style="position: absolute; left: 0px; top: -20000px; padding: 0px; margin: 0px; border: none; white-space: pre; line-height: normal; font-family: &quot;Trebuchet MS&quot;, Helvetica, sans-serif; font-size: 20px; font-weight: normal; display: none;">Mpgyi</span>
	</body>
</html>
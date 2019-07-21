 $(document).ready(function() {

  $('#selectSubtitulos').selectpicker();
  $('#idInstitucion').selectpicker();
  $('#idInstitucionC').selectpicker();
  $('#idInstitucionP').selectpicker();
  $('#selectComunas').selectpicker();
  $('#selectCuota').selectpicker();  

  $('#idInstitucionC').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    var idInstitucion = $(e.currentTarget).val();
    var baseurl = window.origin + '/Programa/listarMarcosUsuario';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {institucion: idInstitucion},
    success: function(data) {
      if (data) {

        var table = $('#tListaProgramas').DataTable();
        table.destroy();
        
        $("#listaSeleccionMarco").empty();
        var row = '';
        row = row.concat('\n<table id="tListaProgramas" class="table table-sm table-hover table-bordered">',
        '\n<thead class="thead-dark">',
          '\n<tr>',
            '\n<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Dependencia</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro"></th>',
          '\n</tr>',
        '\n</thead>',
        '\n<tbody id="tbodyPrograma">');

        for (var i = 0; i < data.marcos.length; i++){
                row = row.concat('\n<tr>');
                  row = row.concat('\n<th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['id_marco'],'</th>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['institucion'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['programa'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['codigo_cuenta'], ' ',data.marcos[i]['cuenta'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['clasificacion'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['marco']),'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['dif_rest']),'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro botonTabla paginate_button">');
                  row = row.concat('\n<button href="#" aria-controls="tListaMarcos" data-id="',data.marcos[i]['id_marco'],'" data-nombre="$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['dif_rest']),' restantes de ',data.marcos[i]['programa'],'" data-restante="',data.marcos[i]['dif_rest'],'" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>');
                  row = row.concat('\n</td>');
                row = row.concat('\n</tr>');
        }
        row = row.concat('\n</tbody>');
        row = row.concat('\n</table>');
        $('#listaSeleccionMarco').html(row);
        $('#inputMarco').val('');
        $("#selectComunas").empty();
        var options = '';
        for (var i = 0; i < data.comunas.length; i++) {
          options = options.concat('\n<option value="',data.comunas[i]["id_comuna"],'">',data.comunas[i]["nombre"], '</option>');
        }
        $("#selectComunas").append(options);
        $('#selectComunas').selectpicker();
        $('#selectComunas').selectpicker('refresh');


        $('#tListaProgramas').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });
      }
      
    }
    });

  });

 $('#idInstitucionP').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    obtenerFiltrosTransferencias(1);
  });

 $('#idInstitucionP').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    obtenerFiltrosTransferencias(2);
  });

 $('#listaSeleccionProgramaP').on('click', '.seleccionPrograma', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idPrograma = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('nombre');
     $('#inputProgramaP').val(nombrePrograma);
     $('#idProgramaP').val(idPrograma);
     $('#modalBuscarPrograma').modal('hide');
     obtenerFiltrosTransferencias(3);
  });

 /*$('#listaSeleccionConvenioP').on('click', '.seleccionConvenio', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idPrograma = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('nombre');
     $('#inputConvenioP').val(nombrePrograma);
     $('#idConvenioP').val(idPrograma);
     $('#modalBuscarConvenio').modal('hide');
     obtenerFiltrosTransferencias(4);
  });*/



 function obtenerFiltrosTransferencias(origen)
 {
    var idInstitucion = document.getElementById('idInstitucionP').value;
    var idComuna = document.getElementById('selectComunasP').value;
    var idPrograma = document.getElementById('idProgramaP').value;
    var idConvenio = document.getElementById('idConvenioP').value;

    var baseurl = window.origin + '/Programa/obtenerFiltrosTransferencias';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {institucion: idInstitucion, idComuna: idComuna, idPrograma: idPrograma},
    success: function(data) {
      if (data) {

        var table = $('#tListaProgramas').DataTable();
        table.destroy();
        
        $("#listaSeleccionMarco").empty();
        var row = '';
        row = row.concat('\n<table id="tListaProgramas" class="table table-sm table-hover table-bordered">',
        '\n<thead class="thead-dark">',
          '\n<tr>',
            '\n<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Institucion</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Programa</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Subtitulo</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Dependencia</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Marco</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro">Monto Restante</th>',
              '\n<th scope="col" class="texto-pequenio text-center align-middle registro"></th>',
          '\n</tr>',
        '\n</thead>',
        '\n<tbody id="tbodyPrograma">');

        for (var i = 0; i < data.marcos.length; i++){
                row = row.concat('\n<tr>');
                  row = row.concat('\n<th scope="row" class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['id_marco'],'</th>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['institucion'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['programa'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['codigo_cuenta'], ' ',data.marcos[i]['cuenta'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">',data.marcos[i]['clasificacion'],'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['marco']),'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro"><p class="texto-pequenio">$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['dif_rest']),'</p></td>');
                  row = row.concat('\n<td class="text-center align-middle registro botonTabla paginate_button">');
                  row = row.concat('\n<button href="#" aria-controls="tListaMarcos" data-id="',data.marcos[i]['id_marco'],'" data-nombre="$ ',Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.marcos[i]['dif_rest']),' restantes de ',data.marcos[i]['programa'],'" data-restante="',data.marcos[i]['dif_rest'],'" tabindex="0" class="btn btn-outline-dark seleccionMarco">Seleccionar</button>');
                  row = row.concat('\n</td>');
                row = row.concat('\n</tr>');
        }
        row = row.concat('\n</tbody>');
        row = row.concat('\n</table>');
        $('#listaSeleccionMarco').html(row);

        $("#selectComunas").empty();
        var options = '';
        for (var i = 0; i < data.comunas.length; i++) {
          options = options.concat('\n<option value="',data.comunas[i]["id_comuna"],'">',data.comunas[i]["nombre"], '</option>');
        }
        $("#selectComunas").append(options);
        $('#selectComunas').selectpicker();
        $('#selectComunas').selectpicker('refresh');


        $('#tListaProgramas').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });
      }
      
    }
    });
 }


  $('#archivoMarco').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
      if (fileName.trim().length == 0)
        $(this).next('.custom-file-label').html('Seleccionar un Archivo...');

  });

  $('#archivoPresupuesto').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
      if (fileName.trim().length == 0)
        $(this).next('.custom-file-label').html('Seleccionar un Archivo...');

  });

  $('#archivoConvenio').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
      if (fileName.trim().length == 0)
        $(this).next('.custom-file-label').html('Seleccionar un Archivo...');

  });

  $("#agregarMarco").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    ignore: ":hidden:not(.selectpicker)",
    errorPlacement: function( span, element ) {
      if(element[0].className === "selectpicker invalid") {
        element.parent().append(span);
      } else {
        span.insertAfter(element);
      }
    },
    //ignore: ":hidden:not(.selectpicker)",
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
      if(element.className == "selectpicker is-invalid")
      {
        $(element.parentElement.children[1]).addClass('form-control');
        $(element.parentElement.children[1]).addClass('is-invalid');
        $(element).removeClass("is-invalid");
        $(element).addClass('invalid');
      }
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
      if(element.className == "selectpicker invalid")
      {
        $(element.parentElement.children[1]).removeClass('form-control');
        $(element.parentElement.children[1]).removeClass('is-invalid');
      }
    },
    rules: {
      inputMarco: {
        required: true,
        number: true,
        min: 1,
        max: function(){ return parseInt(document.getElementById('idPresupuesto').dataset.restante); }
      },
      inputPresupuesto: {
        required: true,
        minlength: 1
      },
      idInstitucion: {
        required: true
      },
      idDependencia: {
        required: true
      },
    },
    messages:{
      inputMarco: {
        required: "Ingrese un Marco Presupuestario.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Marco Presupuestario mayor a 0.",
        max:  function(){ return ("El Marco Presupuestario no debe ser mayor que $ ").concat(Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(parseInt(document.getElementById('idPresupuesto').dataset.restante)), ".") }
      },
      inputPresupuesto: {
        required: "Seleccione un Presupuesto.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres."
      },
      idInstitucion: {
        required: "Seleccione una Institución."
      },
      idDependencia: {
        required: "Seleccione una Clasificación."
      },
    }     
  });

  $("#agregarPresupuesto").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    ignore: ":hidden:not(.selectpicker)",
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
    rules: {
      inputPrograma: {
        required: true,
        minlength: 1
      },
      inputPresupuesto6: {
        required: function(element){ return (!$('#inputPresupuesto6').val() && !$('#inputPresupuesto3').val() && !$('#inputPresupuesto4').val() && !$('#inputPresupuesto5').val()); },
        number: true,
        min: 1
      },
      inputPresupuesto3: {
        required: function(element){ return (!$('#inputPresupuesto6').val() && !$('#inputPresupuesto3').val() && !$('#inputPresupuesto4').val() && !$('#inputPresupuesto5').val()); },
        number: true,
        min: 1
      },
      inputPresupuesto4: {
        required: function(element){ return (!$('#inputPresupuesto6').val() && !$('#inputPresupuesto3').val() && !$('#inputPresupuesto4').val() && !$('#inputPresupuesto5').val()); },
        number: true,
        min: 1
      },
      inputPresupuesto5: {
        required: function(element){ return (!$('#inputPresupuesto6').val() && !$('#inputPresupuesto3').val() && !$('#inputPresupuesto4').val() && !$('#inputPresupuesto5').val()); },
        number: true,
        min: 1
      },
    },
    messages:{
      inputPrograma: {
        required: "Seleccione un Programa para el Presupuestario.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres."
      },
      inputPresupuesto6: {
        required: "Ingrese un Presupuesto.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Presupuesto mayor a 0." 
      },
      inputPresupuesto3: {
        required: "Ingrese un Presupuesto.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Presupuesto mayor a 0." 
      },
      inputPresupuesto4: {
        required: "Ingrese un Presupuesto.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Presupuesto mayor a 0." 
      },
      inputPresupuesto5: {
        required: "Ingrese un Presupuesto.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Presupuesto mayor a 0." 
      },
    }
  });

  $("#agregarConvenio").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
     ignore: ":hidden:not(.selectpicker)",
    errorPlacement: function( span, element ) {
      if(element[0].className === "selectpicker invalid") {
        element.parent().append(span);
      } else {
        span.insertAfter(element);
      }
    },
    //ignore: ":hidden:not(.selectpicker)",
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
      if(element.className == "selectpicker is-invalid" || element.className == "selectpicker invalid is-invalid")
      {
        $(element.parentElement.children[1]).addClass('form-control');
        $(element.parentElement.children[1]).removeClass('is-invalid');
        $(element.parentElement.children[1]).addClass('is-invalid');
        $(element).removeClass("is-invalid");
        $(element).addClass('invalid');
      }
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
      if(element.className == "selectpicker invalid")
      {
        $(element.parentElement.children[1]).removeClass('form-control');
        $(element.parentElement.children[1]).removeClass('is-invalid');
        $(element.parentElement.children[1]).removeClass('invalid');
      }
    },
    rules: {
      inputConvenio: {
        required: true,
        number: true,
        min: 1,
        max: function(){ return parseInt(document.getElementById('idMarco').dataset.restante); }
      },
      idInstitucionC: {
        required: true
      },
      inputMarco:{
        required: true
      },
      selectComunas: {
        required: true
      },
      inputResolucion: {
        required: true
      }
    },
    messages:{
      inputConvenio: {
        required: "Ingrese un Convenio.",
        number: "Ingrese un valor numérico.",
        min: "Ingrese un Convenio mayor a 0.",
        max:  function(){ return ("El Convenio no debe ser mayor que $ ").concat(Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(parseInt(document.getElementById('idMarco').dataset.restante)), ".") } 
      },
      idInstitucionC: {
        required: "Seleccione una Institución."
      },
      inputMarco:{
        required: "Seleccione un Marco Presupuestario."
      },
      selectComunas: {
        required: function(){ return ($('#selectComunas').attr("title").concat(".")); }
      },
      inputResolucion: {
        required: "Ingrese un N° de Resoluci&oacute;n."
      },
    }
  });

  $("#agregarMarco").on("submit", function(e){
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarMarco").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      e.preventDefault();
      var f = $(this);
      var form = document.getElementById("agregarMarco");
      var archivo = document.getElementById('archivoMarco').files[0];
      var institucion = $('#idInstitucion').val();
      var dependencia = $('#idDependencia').val();
      var formData = new FormData(form);

      var marco = document.getElementById('inputMarco').value;
      

     /* if(!$.isNumeric(marco) && parseFloat(marco) <= 0)
      {
        $('#tituloM').empty();
        $("#parrafoM").empty();
        $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
        $("#parrafoM").append('Debe ingresar un Marco Presupuestario mayor a 0;');

        $('#modalMensajeMarco').modal({
            show: true
          });
      }

      if (true) {}*/

      //formData.append("archivo", archivo, archivo.name);
      formData.append("institucion", institucion);
      formData.append("dependencia", dependencia);

      jQuery.ajax({
      type: form.getAttribute('method'),
      url: form.getAttribute('action'),
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function(data) {
        if (data.resultado && data.resultado == "1") {
          document.getElementById("agregarMarco").reset();
          $(document.getElementById('idInstitucion')).selectpicker('refresh');
          $(document.getElementById('selectSubtitulos')).selectpicker('refresh');
          $(document.getElementById('archivoMarco')).next('.custom-file-label').html('Seleccionar un Archivo...');
          
          $('#tituloM').empty();
          $("#parrafoM").empty();
          $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoM").append(data.mensaje);
          loader.setAttribute('hidden', '');


          $('#modalMensajeMarco').modal({
              show: true
            });

          feather.replace()
        }
        
      }
      });
      // ... resto del código de mi ejercicio
    }else
    {
      loader.setAttribute('hidden', '');
    }
  });

  $("#agregarPresupuesto").on("submit", function(e){
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarPresupuesto").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      e.preventDefault();
      var f = $(this);
      var form = document.getElementById("agregarPresupuesto");
      var archivo = document.getElementById('archivoPresupuesto').files[0];
      //var subtitulo = $('#selectSubtitulos').val();
      var formData = new FormData(form);

      //formData.append("archivo", archivo, archivo.name);
      //formData.append("subtitulo", subtitulo);

      jQuery.ajax({
      type: form.getAttribute('method'),
      url: form.getAttribute('action'),
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function(data) {
        if (data['Subtitulo6'] != null && data['Subtitulo6'].resultado || data['Subtitulo3'] != null && data['Subtitulo3'].resultado == "1" || data['Subtitulo4'] != null && data['Subtitulo4'].resultado || data['Subtitulo5'] != null && data['Subtitulo5'].resultado == "1") { 
          document.getElementById("agregarPresupuesto").reset();
          $(document.getElementById('selectSubtitulos')).selectpicker('refresh');
          $(document.getElementById('archivoPresupuesto')).next('.custom-file-label').html('Seleccionar un Archivo...');
          
          $('#tituloM').empty();
          $("#parrafoM").empty();
          $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoM").append('Se han agregado exitosamente los Presupuestos.');
          loader.setAttribute('hidden', '');
          $('#modalMensajePresupuesto').modal({
              show: true
            });

          feather.replace()
        }else{
          $('#tituloM').empty();
          $("#parrafoM").empty();
          $("#tituloM").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoM").append('Ha ocurrido un error al agregar los Presupuestos. Favor intente nuevamente.');
          loader.setAttribute('hidden', '');
          $('#modalMensajePresupuesto').modal({
              show: true
            });

          feather.replace()
        }
        
      }
      });
      // ... resto del código de mi ejercicio
    }else
    {
      loader.setAttribute('hidden', '');
    }
  });

$("#agregarConvenio").on("submit", function(e){
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarConvenio").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      e.preventDefault();
      var f = $(this);
      var form = document.getElementById("agregarConvenio");
      var archivo = document.getElementById('archivoConvenio').files[0];
      var comuna = $('#selectComunas').val();
      var formData = new FormData(form);

      //formData.append("archivo", archivo, archivo.name);
      formData.append("comuna", comuna);

      jQuery.ajax({
      type: form.getAttribute('method'),
      url: form.getAttribute('action'),
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function(data) {
        if (data.resultado && data.resultado == "1") {
          document.getElementById("agregarConvenio").reset();
          $(document.getElementById('selectComunas')).selectpicker('refresh');
          $(document.getElementById('idInstitucionC')).selectpicker('refresh');
          $(document.getElementById('archivoConvenio')).next('.custom-file-label').html('Seleccionar un Archivo...');
          
          $('#tituloM').empty();
          $("#parrafoM").empty();
          $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoM").append(data.mensaje);
          loader.setAttribute('hidden', '');
          $('#modalMensajeConvenio').modal({
              show: true
            });

          feather.replace()
        }
      }
      });
      // ... resto del código de mi ejercicio
      }else
      {
        loader.setAttribute('hidden', '');
      }
  });


  $('#sbtnAgregarMarco').click(function(e){
      var programa = $('#idPrograma').val();
      var institucion = $('#idInstitucion').val();
      var marco = $('#inputMarco').val();
      var archivo = document.getElementById('archivoMarco').files[0];

      var baseurl = window.origin + '/Programa/agregarMarco';

      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {programa: programa, institucion: institucion, marco: marco, archivo: archivo},
      success: function(data) {
        if (data)
        {
          if(data == '1')
          {
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
            $("#parrafoMP").append('Se ha eliminado exitosamente la Programa.');
            $('#modalEliminarPrograma').modal('hide');
            $('#modalMensajePrograma').modal({
              show: true
            });
            listarProgramas();
          }else{
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMP").append('Ha ocurrido un error al intentar la Programa.');
            $('#modalEliminarPrograma').modal('hide');
            $('#modalMensajePrograma').modal({
              show: true
            });
            listarProgramas();
          }
          feather.replace()
          $('[data-toggle="tooltip"]').tooltip()
        }
      }
      });
  });

  $("#agregarPrograma").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
    rules: {
      inputNombre: {
        required: true,
        minlength: 1,
        maxlength: 100
      },
      inputObservaciones: {
        maxlength: 100
      },
    },
    messages:{
      inputNombre: {
        required: "Se requiere un Nombre de Programa.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputObservaciones: {
        maxlength: "Se requiere no mas de {0} caracteres."
      },
    }
  });

  $('#modalEliminarPrograma').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idPrograma = $(e.relatedTarget).data('id');
    var nombrePrograma = $(e.relatedTarget).data('nombre');
    //populate the textbox
    $("#tituloEP").text('Eliminar Programa N° ' + idPrograma);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar la  Programa N° ' + idPrograma + ', "' + nombrePrograma + '"?');

    $("#tituloEP").removeData("idprograma");
    $("#tituloEP").attr("data-idprograma", idPrograma);
    //$("#tituloEE").removeData("nombreequipo");
    //$("#tituloEE").attr("data-nombreEquipo", nombreEquipo);
  });

  $('#modalEliminarConvenio').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idConvenio = $(e.relatedTarget).data('id');
    var comuna = $(e.relatedTarget).data('comuna');
    //populate the textbox
    $("#tituloEP").text('Eliminar Convenio N° ' + idConvenio);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar el Convenio N° ' + idConvenio + 'de la comuna: "' + comuna + '"?');

    $("#tituloEP").removeData("idconvenio");
    $("#tituloEP").attr("data-idconvenio", idConvenio);
  });

  $('#modalEliminarMarco').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idMarco = $(e.relatedTarget).data('id');
    var institucion = $(e.relatedTarget).data('institucion');
    var programa = $(e.relatedTarget).data('programa');
    //populate the textbox
    $("#tituloEP").text('Eliminar Marco N° ' + idMarco);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar el Marco N° ' + idMarco + ' de la institucion: "' + institucion + '", programa: "' + programa + '"?');

    $("#tituloEP").removeData("idmarco");
    $("#tituloEP").attr("data-idmarco", idMarco);
  });

   $('#modalEliminarPresupuesto').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idPresupuesto = $(e.relatedTarget).data('id');
    var programa = $(e.relatedTarget).data('programa');
    //populate the textbox
    $("#tituloEP").text('Eliminar Presupuesto N° ' + idPresupuesto);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar el Presupuesto N° ' + idPresupuesto + ' del  programa: "' + programa + '"?');

    $("#tituloEP").removeData("idpresupuesto");
    $("#tituloEP").attr("data-idpresupuesto", idPresupuesto);
  });

  $('#modalBuscarPrograma').on('show.bs.modal', function (event) {

    var table = $('#tListaProgramas').DataTable();
    table.destroy();
    /*$('#tListaProgramas').DataTable( {
                "search": {
                  "search": ""
                }
            } );*/
     $('#tListaProgramas').dataTable({
        searching: true,
        paging:         true,
        ordering:       true,
        info:           true,
        columnDefs: [
          { targets: 'no-sort', orderable: false }
        ],
        //bDestroy:       true,
         
        "oLanguage": {
            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
            "sZeroRecords": "No se encontraron registros",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sSearch":        "Buscar:",
            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        lengthMenu: [[10, 20], [10, 20]]
    });
  });

  $('#modalBuscarMarco').on('show.bs.modal', function (event) {

    var table = $('#tListaMarcos').DataTable();
    table.destroy();
    $('#tListaMarcos').DataTable( {
                "search": {
                  "search": ""
                }
            } );
  });

  $('#eliminarPrograma').click(function(e){
    idPrograma = $('#tituloEP').data('idprograma');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Programa/eliminarPrograma';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idPrograma: idPrograma},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente la Programa.');
          $('#modalEliminarPrograma').modal('hide');
           listarProgramas();
          $('#modalMensajePrograma').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar la Programa.');
          $('#modalEliminarPrograma').modal('hide');
          listarProgramas();
          $('#modalMensajePrograma').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $('#buscarPrograma').on('change',function(e){
     filtroPrograma = $('#buscarPrograma').val();

     if(filtroPrograma.length = 0)
        filtroPrograma = "";
    listarProgramas(filtroPrograma);
  });

  $('#eliminarConvenio').click(function(e){
    idConvenio = $('#tituloEP').data('idconvenio');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Programa/eliminarConvenio';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idConvenio: idConvenio},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente el Convenio.');
          $('#modalEliminarConvenio').modal('hide');
          listarConvenios();
          $('#modalMensajeConvenio').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar eliminar el Convenio.');
          $('#modalEliminarConvenio').modal('hide');
          listarConvenios();
          $('#modalMensajeConvenio').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $('#eliminarMarco').click(function(e){
    idMarco = $('#tituloEP').data('idmarco');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Programa/eliminarMarco';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idMarco: idMarco},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente el Marco.');
          $('#modalEliminarMarco').modal('hide');
          listarMarcos();
          $('#modalMensajeMarco').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar eliminar el Marco.');
          $('#modalEliminarMarco').modal('hide');
          listarMarcos();
          $('#modalMensajeMarco').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $('#eliminarPresupuesto').click(function(e){
    idPresupuesto = $('#tituloEP').data('idpresupuesto');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Programa/eliminarPresupuesto';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idPresupuesto: idPresupuesto},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente el Presupuesto.');
          $('#modalEliminarPresupuesto').modal('hide');
          listarPresupuestos();
          $('#modalMensajePresupuesto').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar eliminar el Presupuesto.');
          $('#modalEliminarPresupuesto').modal('hide');
          listarPresupuestos();
          $('#modalMensajePresupuesto').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $('#buscarPrograma').on('change',function(e){
     filtroPrograma = $('#buscarPrograma').val();

     if(filtroPrograma.length = 0)
        filtroPrograma = "";
    listarProgramas(filtroPrograma);
  });

  /*$(".seleccionPrograma").on('click', function(e) {
    var idPrograma = $(e.relatedTarget).data('data-id');
    alert(idPrograma);
  });
*/
  $('#listaSeleccionPrograma').on('click', '.seleccionPrograma', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idPrograma = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('nombre');
     $('#idPrograma').val(idPrograma);
     $('#inputPrograma').val(nombrePrograma);
     $('#idPrograma').val(idPrograma);
     $('#modalBuscarPrograma').modal('hide')
  });

   $('#listaSeleccionPresupuesto').on('click', '.seleccionPresupuesto', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idPresupuesto = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('programa');
     var monto_restante = $(e.currentTarget).data('restante');
     var presupuesto = $(e.currentTarget).data('restante');
     $('#inputPresupuesto').val(nombrePrograma + ' - $ ' + Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(presupuesto));
     $('#idPresupuesto').val(idPresupuesto);
     var inputPresupuesto = document.getElementById('idPresupuesto');
     inputPresupuesto.dataset.restante = monto_restante;
     $('#modalBuscarPresupuesto').modal('hide')
  });

  

   $('#listaSeleccionMarco').on('click', '.seleccionMarco', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idMarco = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('nombre');
     var clasificacion = $(e.currentTarget).data('clasificacion');
     var monto_restante = $(e.currentTarget).data('restante');
     var marco = $(e.currentTarget).data('restante');
     var institucion = $(e.currentTarget).data('institucion');
     
     //$('#inputPresupuesto').val(nombrePrograma + ' - $ ' + Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(presupuesto));
     //$('#idPresupuesto').val(idPresupuesto);
     var inputMarco = document.getElementById('idMarco');
     inputMarco.dataset.restante = monto_restante;

     $('#idMarco').val(idMarco);
     $('#inputMarco').val(nombrePrograma);
     $('#idMarco').val(idMarco);
     $('#modalBuscarMarco').modal('hide');

      var baseurl = (window.origin + '/Programa/listarComunasMarco');
      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {marco: idMarco, clasificacion: clasificacion, institucion: institucion},
      success: function(data) {
        if (data)
        {     
          $("#selectComunas").empty();
          var row = '';
          if(clasificacion == "PRAPS")
          {
            $('#lComunasHospitales').text('Comunas');
            $('#selectComunas').attr("placeholder", "Seleccione una Comuna");
            $('#selectComunas').attr("title", "Seleccione una Comuna");
            $('#selectComunas').selectpicker({title: 'Seleccione una Comuna'});
            for (var i = 0; i < data['comunas'].length; i++) {
              row = row.concat('\n<option value="',data['comunas'][i]["id_comuna"],'">',data['comunas'][i]["nombre"], '</option>');
            }
          }else{
            $('#lComunasHospitales').text('Hospitales');
            $('#selectComunas').attr("placeholder", "Seleccione un Hospital");
            $('#selectComunas').attr("title", "Seleccione un Hospital");
            $('#selectComunas').selectpicker({title: 'Seleccione un Hospital'});
            for (var i = 0; i < data['hospitales'].length; i++) {
              row = row.concat('\n<option value="',data['hospitales'][i]["id_hospital"],'">',data['hospitales'][i]["nombre"], '</option>');
            }
          }
          /*if(data['componentes'])
          {
            var dComponentes = document.getElementById('dComponentes');
            dComponentes.removeAttribute('hidden');

            var rowComponente = '';
            $("#selectComponentes").empty();
            for (var i = 0; i < data['componentes'].length; i++) {
              rowComponente = rowComponente.concat('\n<option value="',data['componentes'][i]["id_programa"],'">',data['componentes'][i]["nombre"], '</option>');
            }
            $("#selectComponentes").empty();
            $("#selectComponentes").append(rowComponente);
            $('#selectComponentes').selectpicker('refresh');
          }else{
            var dComponentes = document.getElementById('dComponentes');
            dComponentes.removeAttribute('hidden');
            dComponentes.setAttribute('hidden', '');
            $("#selectComponentes").empty();
            $('#selectComponentes').selectpicker('refresh');
          }*/
          $("#selectComunas").append(row);
          $('#selectComunas').selectpicker('refresh');
        }
      }
    });
  });

  $("#agregarPrograma").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarPrograma").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      event.preventDefault();
      var codigo = $('#inputCodigo').val();
      var nombre = $('#inputNombre').val();
      var observacion = $('#inputObservaciones').val();
      var idFormaPago = $('#formaPago').val();

      var idPrograma = null;
      if($("#inputIdPrograma").val())
        idPrograma = $('#inputIdPrograma').val();

      var baseurl = (window.origin + '/Programa/guardarPrograma');
      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {idPrograma: idPrograma, codigo: codigo, nombre: nombre, observacion: observacion, idFormaPago: idFormaPago },
      success: function(data) {
        if (data)
        {
          //data = JSON.parse(data);
          if(data['resultado'] == '1')
          {
            $(document.getElementById('formaPago')).selectpicker('refresh');
            $('#tituloM').empty();
            $("#parrafoM").empty();
            $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
            $("#parrafoM").append(data['mensaje']);
            if(!$("#inputIdPrograma").val())
            {
              $("#agregarPrograma")[0].reset();
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajePrograma').modal({
              show: true
            });
            feather.replace()
          }else{
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMP").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajePrograma').modal({
              show: true
            });
          }
          feather.replace()
          $('[data-toggle="tooltip"]').tooltip()
        }
      }
      });
    }else
    {
      loader.setAttribute('hidden', '');
    }
  });

  function listarProgramas()
  {
    var baseurl = window.origin + '/Programa/listarProgramas';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    //data: {},
    success: function(data) {
    if (data)
    {
        var myJSON= JSON.stringify(data);
        myJSON = JSON.parse(myJSON);
        $('#tablaListaProgramas').html(myJSON.table_programas);
        feather.replace()
        $('#tablaProgramas').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });

        feather.replace();
        $('[data-toggle="tooltip"]').tooltip();

          //loader.setAttribute('hidden', '');
      }
    }
    });
  }

  function listarConvenios()
  {
    var baseurl = window.origin + '/Programa/listarConvenios';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    //data: {},
    success: function(data) {
    if (data)
    {
        var myJSON= JSON.stringify(data);
        myJSON = JSON.parse(myJSON);
        $('#tablaListaConvenios').html(myJSON.table_convenios);
        feather.replace()
        $('#tListaConvenios').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });

        feather.replace();
        $('[data-toggle="tooltip"]').tooltip();

          //loader.setAttribute('hidden', '');
      }
    }
    });
  }


  function listarMarcos()
  {
    var baseurl = window.origin + '/Programa/listarMarcos';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    //data: {},
    success: function(data) {
    if (data)
    {
        var myJSON= JSON.stringify(data);
        myJSON = JSON.parse(myJSON);
        $('#tablaListaMarcos').html(myJSON.table_marcos);
        feather.replace()
        $('#tListaMarcos').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });

        feather.replace();
        $('[data-toggle="tooltip"]').tooltip();

          //loader.setAttribute('hidden', '');
      }
    }
    });
  }

  function listarPresupuestos()
  {
    var baseurl = window.origin + '/Programa/listarPresupuestos';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    //data: {},
    success: function(data) {
    if (data)
    {
        var myJSON= JSON.stringify(data);
        myJSON = JSON.parse(myJSON);
        $('#tablaListaPresupuestos').html(myJSON.table_presupuestos);
        feather.replace()
        $('#tListaPresupuestos').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip();

          //loader.setAttribute('hidden', '');
      }
    }
    });
  }

  $('#listaSeleccionMarco').on('click', '.pdfMarco', function(e) {
    var ruta = $(e.currentTarget).data('pdf');
    openPDF(ruta);
  });

  $('#tablaListaMarcos').on('click', '.pdfMarco', function(e) {
    var ruta = $(e.currentTarget).data('pdf');
    openPDF(ruta);
  });

  $('#tablaListaConvenios').on('click', '.pdfMarco', function(e) {
    var ruta = $(e.currentTarget).data('pdf');
    openPDF(ruta);
  });

  $('#tablaListaPresupuestos').on('click', '.pdfPresupuesto', function(e) {
    var ruta = $(e.currentTarget).data('pdf');
    openPDF(ruta);
  });

  function openPDF(pdf){
    window.open(pdf);
    return false;
  }



});

window.onload = function () {
  $('[data-toggle="tooltip"]').tooltip();
  feather.replace()
   $('#tListaProgramas').dataTable({
        searching: true,
        paging:         true,
        ordering:       true,
        info:           true,
        columnDefs: [
          { targets: 'no-sort', orderable: false }
        ],
        //bDestroy:       true,
         
        "oLanguage": {
            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
            "sZeroRecords": "No se encontraron registros",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sSearch":        "Buscar:",
            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        lengthMenu: [[10, 20], [10, 20]]
    });

    $('#tListaConvenios').dataTable({
        searching: true,
        paging:         true,
        ordering:       true,
        info:           true,
        columnDefs: [
          { targets: 'no-sort', orderable: false }
        ],
        //bDestroy:       true,
         
        "oLanguage": {
            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
            "sZeroRecords": "No se encontraron registros",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sSearch":        "Buscar:",
            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        lengthMenu: [[10, 20], [10, 20]]
    });

    $('#tListaMarcos').dataTable({
        searching: true,
        paging:         true,
        ordering:       true,
        info:           true,
        columnDefs: [
          { targets: 'no-sort', orderable: false }
        ],
        //bDestroy:       true,
         
        "oLanguage": {
            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
            "sZeroRecords": "No se encontraron registros",
            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sSearch":        "Buscar:",
            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            }
        },
        lengthMenu: [[10, 20], [10, 20]]
    });

     $('#tListaPresupuestos').dataTable({
            searching: true,
            paging:         true,
            ordering:       true,
            info:           true,
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            //bDestroy:       true,
             
            "oLanguage": {
                "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
                "sZeroRecords": "No se encontraron registros",
                "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
                "sSearch":        "Buscar:",
                "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                }
            },
            lengthMenu: [[10, 20], [10, 20]]
        });
 }
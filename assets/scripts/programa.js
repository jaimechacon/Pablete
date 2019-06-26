 $(document).ready(function() {

  $('#selectSubtitulos').selectpicker();
  $('#idInstitucion').selectpicker();  

  $('#selectComunas').selectpicker();

  $('#archivoMarco').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
      if (fileName.trim().length == 0)
        $(this).next('.custom-file-label').html('Seleccionar un Archivo...');

  });

  $("#agregarMarco").on("submit", function(e){
      e.preventDefault();
      var f = $(this);
      var form = document.getElementById("agregarMarco");
      var archivo = document.getElementById('archivoMarco').files[0];
      var institucion = $('#idInstitucion').val();
      var subtitulo = $('#selectSubtitulos').val();
      var formData = new FormData(form);

      //formData.append("archivo", archivo, archivo.name);
      formData.append("institucion", institucion);

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



          $('#modalMensajeMarco').modal({
              show: true
            });

          feather.replace()
        }

        var mensaje = data;
      }
      });
      // ... resto del código de mi ejercicio
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

  $('#modalMensajePrograma').on('show.bs.modal', function(e) {
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

  $('#modalBuscarPrograma').on('show.bs.modal', function (event) {

    var table = $('#tListaProgramas').DataTable();
    table.destroy();
    $('#tListaProgramas').DataTable( {
                "search": {
                  "search": ""
                }
            } );
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

   $('#listaSeleccionMarco').on('click', '.seleccionMarco', function(e) {
  //$(".seleccionPrograma").on('click', function(e) {
     var idMarco = $(e.currentTarget).data('id');
     var nombrePrograma = $(e.currentTarget).data('nombre');
     $('#idMarco').val(idMarco);
     $('#inputMarco').val(nombrePrograma);
     $('#idMarco').val(idMarco);
     $('#modalBuscarMarco').modal('hide')
  });

  $("#agregarPrograma").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarPrograma").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      event.preventDefault();

      var baseurl = (window.origin + '/gestion_calidad/Programa/guardarPrograma');
      var nombrePrograma = $('#inputNombre').val();
      var observacionesPrograma = $('#inputObservaciones').val();
      var idPrograma = null;
      if($("#inputIdPrograma").val())
        idPrograma = $('#inputIdPrograma').val();

      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {idPrograma: idPrograma, nombrePrograma: nombrePrograma, observacionesPrograma: observacionesPrograma },
      success: function(data) {
        if (data)
        {
          //data = JSON.parse(data);
          if(data['respuesta'] == '1')
          {
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
            $("#parrafoMP").append(data['mensaje']);
            if(!$("#inputIdPrograma").val())
            {
              $("#agregarPrograma")[0].reset();
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajePrograma').modal({
              show: true
            });
          }else{
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMP").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajeEquipo').modal({
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
        $('#tablaProgramas').dataTable({
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
 }
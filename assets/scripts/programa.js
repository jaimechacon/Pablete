 $(document).ready(function() {

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

  $('#eliminarPrograma').click(function(e){
    idPrograma = $('#tituloEP').data('idprograma');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/minsal/Programa/eliminarPrograma';

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
    var baseurl = window.origin + '/minsal/Programa/listarProgramas';
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
  feather.replace();
  $('[data-toggle="tooltip"]').tooltip();
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
 }
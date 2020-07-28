$(document).ready(function() {

  $('[data-toggle="tooltip"]').tooltip();
  feather.replace()

  $('#modalEliminarUsuario').on('show.bs.modal', function(e) {
    var idUsuario = $(e.relatedTarget).data('id');
    var rut = $(e.relatedTarget).data('rut');
    var nombreUsuario = ($(e.relatedTarget).data('nombre') + " " + $(e.relatedTarget).data('apellido')).trim();
    $("#tituloEP").text('Eliminar Usuario N° ' + idUsuario);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar el usuario rut ' + rut + ', "' + nombreUsuario + '"?');
    $("#tituloEP").removeData("idusuario");
    $("#tituloEP").attr("data-idusuario", idUsuario);
  });

  $('#eliminarUsuario').click(function(e){
    idUsuario = $('#tituloEP').data('idusuario');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Usuario/eliminarUsuario';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idUsuario: idUsuario},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente el Usuario.');
          $('#modalEliminarUsuario').modal('hide');
           listarUsuarios();
          $('#modalMensajeUsuario').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar el Usuario.');
          $('#modalEliminarUsuario').modal('hide');
          listarUsuarios();
          $('#modalMensajeUsuario').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $("#agregarUsuario").validate({
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
      inputEmail: {
        required: true,
        email: true,
        minlength: 1,
        maxlength: 100
      },
    },
    messages:{
      inputNombre: {
        required: "Se requiere un Nombre.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputEmail: {
        required: "Se requiere un Nombre.",
        email: "Ingrse un Email v&aacute;lido.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
    }
  });

  $("#agregarUsuario").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarUsuario").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      event.preventDefault();
      var rut = $('#inputRut').val();
      var idEmpresa = $('#selectEmpresa').val();
      var nombres = $('#inputNombres').val();
      var apellidos = $('#inputApellidos').val();
      var email = $('#inputEmail').val();
      var codUsuario = $('#inputCodUsuario').val();
      var idPerfil = $('#selectPerfil').val();

      var idUsuario = null;
      if($("#inputIdUsuario").val())
        idPrograma = $('#inputIdUsuario').val();

      var baseurl = (window.origin + '/Usuario/guardarUsuario');
      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {idUsuario: idUsuario, rut: rut, nombres: nombres, apellidos: apellidos, idFormaPago: idFormaPago },
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
            if(!$("#inputIdUsuario").val())
            {
              $("#agregarUsuario")[0].reset();
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajeUsuario').modal({
              show: true
            });
            feather.replace()
          }else{
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMP").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajeUsuario').modal({
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

});

function listarUsuarios()
{
  var baseurl = window.origin + '/Usuario/listarUsuarios';
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
      $('#tablaListaUsuarios').html(myJSON.table_usuarios);
      feather.replace()
      $('#tListaUsuarios').dataTable({
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
    }
  }
  });
}

window.onload = function () {

  $('#tListaUsuarios').dataTable({
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

  $('[data-toggle="tooltip"]').tooltip();
  feather.replace()
}
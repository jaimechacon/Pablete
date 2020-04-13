 $(document).ready(function() {
/*
  $('#selectSubtitulos').selectpicker();
  $('#idInstitucion').selectpicker();
  $('#idInstitucionM').selectpicker();
  $('#idInstitucionC').selectpicker();
  $('#idInstitucionP').selectpicker();
  $('#selectComunas').selectpicker();
  $('#selectCuota').selectpicker();
*/

  $('#tListaProductos').dataTable({
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

  $('#tListaStockProductos').dataTable({
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

  $('#modalEliminarProducto').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idProducto = $(e.relatedTarget).data('id');
    var nombreProducto = $(e.relatedTarget).data('nombre');
    //populate the textbox
    $("#tituloEP").text('Eliminar Producto N° ' + idProducto);
    $("#parrafoEP").text('¿Estás seguro que deseas eliminar la  Producto N° ' + idProducto + ', "' + nombreProducto + '"?');

    $("#tituloEP").removeData("idproducto");
    $("#tituloEP").attr("data-idproducto", idProducto);
    //$("#tituloEE").removeData("nombreequipo");
    //$("#tituloEE").attr("data-nombreEquipo", nombreEquipo);
  });

  $('#eliminarProducto').click(function(e){
    idProducto = $('#tituloEP').data('idproducto');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/Producto/eliminarProducto';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idProducto: idProducto},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMP").append('Se ha eliminado exitosamente la Producto.');
          $('#modalEliminarProducto').modal('hide');
           listarProductos();
          $('#modalMensajeProducto').modal({
            show: true
          });
        }else{
          $('#tituloMP').empty();
          $("#parrafoMP").empty();
          $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMP").append('Ha ocurrido un error al intentar la Producto.');
          $('#modalEliminarProducto').modal('hide');
          listarProductos();
          $('#modalMensajeProducto').modal({
            show: true
          });
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $("#agregarProducto").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
    rules: {
      inputCodigo: {
        required: true,
        minlength: 1,
        maxlength: 50
      },
      inputNombre: {
        required: true,
        minlength: 1,
        maxlength: 100
      },
      inputUnidadMedida: {
        required: true,
        minlength: 1,
        maxlength: 50
      },
      inputObservaciones: {
        maxlength: 100
      },
    },
    messages:{
      inputCodigo: {
        required: "Se requiere un Codigo de Producto.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputNombre: {
        required: "Se requiere un Nombre de Producto.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputUnidadMedida: {
        required: "Se requiere una Unidad de Medida de Producto.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputObservaciones: {
        maxlength: "Se requiere no mas de {0} caracteres."
      },
    }
  });

  $("#agregarProducto").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarProducto").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      event.preventDefault();
      var codigo = $('#inputCodigo').val();
      var nombre = $('#inputNombre').val();
      var observacion = $('#inputObservaciones').val();
      var unidadMedida = $('#inputUnidadMedida').val();

      var idProducto = null;
      if($("#inputIdProducto").val())
        idProducto = $('#inputIdProducto').val();

      var baseurl = (window.origin + '/Producto/guardarProducto');
      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {idProducto: idProducto, codigo: codigo, nombre: nombre, observacion: observacion, unidadMedida: unidadMedida },
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
            if(!$("#inputIdProducto").val())
            {
              $("#agregarProducto")[0].reset();
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajeProducto').modal({
              show: true
            });
            feather.replace()
          }else{
            $('#tituloMP').empty();
            $("#parrafoMP").empty();
            $("#tituloMP").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMP").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajeProducto').modal({
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

  $("#agregarStock").validate({
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
      idProducto: {
        required: true,
        minlength: 1,
        maxlength: 50
      },
      inputCantPresupuesto: {
        required: true,
        minlength: 1,
        maxlength: 100
      },
      inputOrdenCompra: {
        maxlength: 50
      },
      inputDescripcion: {
        maxlength: 100
      },
    },
    messages:{
      idProducto: {
        required: "Seleccione un Producto.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputCantPresupuesto: {
        required: "Se requiere una Cantidad de stock.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputOrdenCompra: {
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputDescripcion: {
        maxlength: "Se requiere no mas de {0} caracteres."
      },
    }
  });

  $("#agregarStock").on("submit", function(e){
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    var validacion = $("#agregarStock").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      e.preventDefault();
      var f = $(this);
      var form = document.getElementById("agregarStock");
      var formData = new FormData(form);

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
          document.getElementById("agregarStock").reset();
          $(document.getElementById('idProducto')).selectpicker('refresh');
          document.getElementById('cantidad_disponible').textContent = "";
          document.getElementById('cantidad_restante').textContent = "";
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
    }else
    {
      loader.setAttribute('hidden', '');
    }
    feather.replace();
  });

  

  $('#idProducto').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    var idProducto = $(e.currentTarget).val();
    var baseurl = window.origin + '/Producto/obtenerProducto';
    
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idProducto: idProducto},
    success: function(data) {
      if (data) {
        document.getElementById("distribuirStock").reset();
        document.getElementById('cantidad_disponible').textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.stock);
        document.getElementById('mensajeError').textContent = "";
        var cant_restante = document.getElementById('cantidad_restante');
        cant_restante.classList.remove('text-danger');
        cant_restante.classList.add('text-success');
        cant_restante.textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.dif_rest);
        cant_restante.dataset.cantidadRestante = data.dif_rest;
        loader.setAttribute('hidden', '');
      }
      
    }
    });
  });

  $('#idProductoLS').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    var idProducto = $(e.currentTarget).val();
    var baseurl = window.origin + '/Producto/obtenerProducto';
    
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idProducto: idProducto},
    success: function(data) {
      if (data) {
        document.getElementById('cantidad_disponible').textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.stock);
        document.getElementById('mensajeError').textContent = "";
        var cant_restante = document.getElementById('cantidad_restante');
        cant_restante.classList.remove('text-danger');
        cant_restante.classList.add('text-success');
        cant_restante.textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(data.dif_rest);
        cant_restante.dataset.cantidadRestante = data.dif_rest;
        loader.setAttribute('hidden', '');
      }
      
    }
    });
  });

  $('.stock_institucion').on('change',function(){
      var cant_restante = document.getElementById('cantidad_restante');

      var stocks = document.getElementsByClassName('stock_institucion');
      var suma = 0;

      var cantidad_restante = parseInt(cant_restante.dataset.cantidadRestante);

      if (isNaN(cantidad_restante) || cantidad_restante == "")
        cantidad_restante = 0;

      var diferencia = 0;
      for (var i = 0; i < stocks.length; i ++) {
        var cant = 0;
        if ($.isNumeric(stocks[i].value)) {
          cant = parseInt(stocks[i].value);  
          suma = (suma + cant);
        }
      }

      if (isNaN(suma) || suma == "")
        suma = 0;
      else{
        if ($.isNumeric(suma)) {
          suma = parseInt(suma);  
        }
      }
      
      diferencia = (cantidad_restante - suma);

      if(diferencia < 0)
      {
        mensaje = "El Stock de instituciones no debe superar el Stock restante.";
        document.getElementById('mensajeError').textContent = mensaje;
        cant_restante.classList.remove('text-success');
        cant_restante.classList.add('text-danger');
        cant_restante.textContent =  Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(diferencia);
      }else{
        mensaje = "";
        document.getElementById('mensajeError').textContent = mensaje;
        cant_restante.classList.remove('text-danger');
        cant_restante.classList.add('text-success');
        cant_restante.textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(diferencia);
      }
  });


  $("#distribuirStock").on("submit", function(e){
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    var validacion = $("#distribuirStock").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      e.preventDefault();
      var cant_restante = document.getElementById('cantidad_restante');
      var stocks = document.getElementsByClassName('stock_institucion');
      var suma = 0;

      var cantidad_restante = parseInt(cant_restante.dataset.cantidadRestante);

      if (isNaN(cantidad_restante) || cantidad_restante == "")
        cantidad_restante = 0;

      var diferencia = 0;
      for (var i = 0; i < stocks.length; i ++) {
        var cant = 0;
        if ($.isNumeric(stocks[i].value)) {
          cant = parseInt(stocks[i].value);
          suma = (suma + cant);
        }
      }

      if (isNaN(suma) || suma == "")
        suma = 0;
      else{
        if ($.isNumeric(suma)) {
          suma = parseInt(suma);  
        }
      }
      
      diferencia = (cantidad_restante - suma);

      if(diferencia < 0)
      {
        mensaje = "El Stock de instituciones no debe superar el Stock restante.";
        document.getElementById('mensajeError').textContent = mensaje;
        cant_restante.classList.remove('text-success');
        cant_restante.classList.add('text-danger');
        cant_restante.textContent =  Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(diferencia);
         loader.setAttribute('hidden', '');
      }else{

        mensaje = "";
        document.getElementById('mensajeError').textContent = mensaje;
        cant_restante.classList.remove('text-danger');
        cant_restante.classList.add('text-success');
        cant_restante.textContent = Intl.NumberFormat("de-DE", {minimumFractionDigits: 0}).format(diferencia);

          var f = $(this);
          var form = document.getElementById("distribuirStock");
          var formData = new FormData(form);

          var idProducto = document.getElementById('idProducto').value;
          formData.append("idProducto", idProducto);
          /*for (var i=0;i<cantidad.value;i++) {
            marco = 0;
            nombre = "";
            nombre = "inputMarco".concat(i);
            marco = document.getElementById(nombre).value;
            formData.append(nombre, marco);
          }*/

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
              //$(document.getElementById('archivoMarcoModificar')).next('.custom-file-label').html('Seleccionar un nuevo Archivo...');
              $('#tituloM').empty();
              $("#parrafoM").empty();
              $("#tituloM").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
              $("#parrafoM").append(data.mensaje);
              loader.setAttribute('hidden', '');

              $('#modalMensaje').modal({
                  show: true
                });

              feather.replace()
            }
          }
          });
      }
    }else
    {
      loader.setAttribute('hidden', '');
    }
  });

});

function listarProductos()
{
var baseurl = window.origin + '/Producto/listarProductos';
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
  $('#tablaListaProductos').html(myJSON.table_productos);
  feather.replace()
  $('#tablaProductos').dataTable({
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



window.onload = function () {
  $('[data-toggle="tooltip"]').tooltip();
  feather.replace()
   
 }
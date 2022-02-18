var tabla;
var valorRespuesta;

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    mostrarform_LetrasCartera(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioDetalleLetras").on("submit", function (e) {
        guardaryeditar_DetalleLetras(e);
    })

    $.post("../ajax/persona.php?op=SelectPersona", function (r) {
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');
    });

}

//Función limpiar
function limpiar() {
    $("#idpersona").val("");
    $("#idletra").val("");
    $("#totalRenovacion").val("");
    $("#id_cliente").val("");
    $("#id_cliente").selectpicker('refresh');
    $("#numeroletra").val("");
    $("#numerofactura").val("");
    $("#lugargiro").val(0);
    $("#lugargiro").selectpicker('refresh');
    $("#fechaemision").val("");
    $("#fechavencimiento").val("");
    $("#tipoMoneda").val(0);
    $("#tipoMoneda").selectpicker('refresh');
    $("#totalletra").val("");
    $("#condicion").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#divcondicion").hide();
        $("#divListadoDetalleLetra").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#divListadoDetalleLetra").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
    mostrarform_LetrasCartera(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
            {
                url: '../ajax/letrasCartera.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[1, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/letrasCartera.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

//MOSTRAR FRM LETRA-CARTERA(CABECERA)
function mostrar(idletra) {
    idLetraActualizaNU = idletra;
    $.post("../ajax/letrasCartera.php?op=mostrar", { idletra: idletra }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#btnGuardar").prop("disabled", true);
        $("#id_cliente").val(data.idcliente);
        $("#id_cliente").selectpicker('refresh');
        $("#tipoletra").val(data.tipo_letra);
        $("#numeroletra").val(data.num_letra);
        $("#numerofactura").val(data.num_factura);
        $("#lugargiro").val(data.lugar_giro);
        $("#lugargiro").selectpicker('refresh');
        $("#fechaemision").val(data.fecha_emi);
        $("#fechavencimiento").val(data.fecha_ven);
        $("#tipoMoneda").val(data.moneda);
        $("#tipoMoneda").selectpicker('refresh');
        $("#totalletra").val(data.total);
        $("#condicion").show();
        $("#condicion").val(data.condicion == 1 ? "PENDIENTE" : "PAGADO");
        $("#totalPagoRealizado").val(data.pagorealizado);
        $("#totalPagoPendiente").val(data.pagopendiente);

        listar_DetalleLetra(idletra);
        $("#divListadoDetalleLetra").show();
    })
}

function pagoLetra(idletra, nombreCliente) {
    mostrarform_LetrasCartera(true);
    $("#nombreDetalle").val(nombreCliente);
    $("#idLetraDetalle").val(idletra);
    ObtieneDeudaPendiente(idletra);
}

function ObtieneDeudaPendiente(id) {
    $.ajax({
        url: "../ajax/letrasCartera.php?op=obtieneDeudaPendiente",
        type: "POST",
        data: { "idletra": id },
        success: function (data) {
            data = JSON.parse(data);
            $("#deudapendiente").val(data.total);
        }
    });
}

function mostrarform_LetrasCartera(flag) {
    limpiar_LetrasCartera();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistrosDetalleLetras").show();
        $("#btnGuardarLetraPago").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistrosDetalleLetras").hide();
        $("#btnagregar").show();
    }
}

function limpiar_LetrasCartera() {
    $("#id").val("");
    $("#idLetraDetalle").val("");
    $("#montoidLetra").val("");
    $("#nombreDetalle").val("");
    $("#numeroRecibo").val("");
    $("#numeroOperacion").val("");
    $("#descripcion").val("");
    $("#fechapago").val("");
    $("#montopagoDetalle").val("");
}

//Función cancelarform
function cancelarform_LetraPago() {
    mostrarform_LetrasCartera(false);
}

//Función para guardar o editar
function guardaryeditar_DetalleLetras(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento

    if (parseFloat($("#montopagoDetalle").val()) <= parseFloat($("#deudapendiente").val())) {
        $("#btnGuardarLetraPago").prop("disabled", true);
        var formData = new FormData($("#formularioDetalleLetras")[0]);

        $.ajax({
            url: "../ajax/detalleLetrasCartera.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (datos) {
                valorRespuesta = datos;
            }
        });

        //ACTUALIZA ESTADO
        if (valorRespuesta == 1 && (parseFloat($("#montopagoDetalle").val()) == parseFloat($("#deudapendiente").val()))) {
            $.ajax({
                url: "../ajax/letrasCartera.php?op=actualizarEstado",
                type: "POST",
                data: { "idletra": $("#idLetraDetalle").val(), "condicion": '2' },
                success: function (datos) {
                    bootbox.alert(datos);
                }
            });
        } else if (valorRespuesta == 1) {
            bootbox.alert("Datos registrados correctamente");
        }
        // MUESTRA-CARGA-LIMPIA FRM
        mostrarform_LetrasCartera(false);
        tabla.ajax.reload();
    } else {
        alert("EL MONTO DE PAGO ES MAYOR A LA DEUDA PENDIENTE");
    }
}


//Función Listar
function listar_DetalleLetra(id) {
    try {
        //adddlert("Welcome guest!");
        tabla2 = $('#tbllistadoDetalleLetra').dataTable(
            {
                "aProcessing": true,//Activamos el procesamiento del datatables
                "aServerSide": true,//Paginación y filtrado realizados por el servidor
                "searching": false,
                "bPaginate": false,
                "paging": false,
                "info": false,
                dom: 'Bfrtip',//Definimos los elementos del control de tabla                
                buttons: [],
                "ajax":
                {
                    url: '../ajax/detalleLetrasCartera.php?op=listar&id=' + id,
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5,//Paginación
                "order": [[0, "desc"]]//Ordenar (columna,orden)
            }).DataTable();
        //
    }
    catch (err) {
        console.log(err.message);
    }
}


init();
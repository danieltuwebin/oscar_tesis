var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    mostrarform_LetrasBco(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioDetalleLetras").on("submit", function (e) {
        guardaryeditar_Amortizacion(e);
    })

    $.post("../ajax/persona.php?op=SelectPersona", function (r) {
        $("#id_cliente").html(r);
        console.log(r);
        $('#id_cliente').selectpicker('refresh');
    });

}

//Función limpiar
function limpiar() {
    $("#idpersona").val("");
    $("#idletra").val("");
    $("#id_cliente").val("");
    $("#id_cliente").selectpicker('refresh');
    $("#tipoletra").val(0);
    $("#tipoletra").selectpicker('refresh');
    $("#numeroletra").val("");
    $("#numerofactura").val("");
    $("#lugargiro").val(0);
    $("#lugargiro").selectpicker('refresh');
    $("#fechaemision").val("");
    $("#fechavencimiento").val("");
    $("#numerounico").val("");
    $("#tipoMoneda").val(0);
    $("#tipoMoneda").selectpicker('refresh');
    $("#totalletra").val("");
    $("#condicion").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        console.log(flag);
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#divcondicion").hide();
    }
    else {
        console.log(flag);
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
    mostrarform_LetrasBco(false);
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
                url: '../ajax/letras.php?op=listar',
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
}

//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    console.log(formData);

    $.ajax({
        url: "../ajax/letras.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            console.log(datos);
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idletra) {
    //alert(idamortizacion);
    $.post("../ajax/letras.php?op=mostrar", { idletra: idletra }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        console.log('--- ' + data);
        $("#id_cliente").val(data.idcliente);
        $("#id_cliente").selectpicker('refresh');
        $("#tipoletra").val(data.tipo_letra);
        $("#tipoletra").selectpicker('refresh');
        $("#numeroletra").val(data.num_letra);
        $("#numerofactura").val(data.num_factura);
        $("#lugargiro").val(data.lugar_giro);
        $("#lugargiro").selectpicker('refresh');
        $("#fechaemision").val(data.fecha_emi);
        $("#fechavencimiento").val(data.fecha_ven);
        $("#numerounico").val(data.num_unico);
        $("#tipoMoneda").val(data.moneda);
        $("#tipoMoneda").selectpicker('refresh');
        $("#totalletra").val(data.total);
        $("#condicion").show();
        $("#condicion").val(data.condicion == 1 ? "PENDIENTE" : "OTRO");
    })
}

// PARA AGREGAR PAGO AMORTIZACION
function detalleLetra(idletra, tipoLetra) {
    mostrarform_LetrasBco(true)
    $("#idLetraDetalle").val(idletra);
    if (tipoLetra == 1) {
        $("#DivPagoLetra").show();
        $("#DivRenovacion").hide();
        $("#DivProtesto").hide();
        $("#EiquetaPago").show();
        $("#montopagoDetalle").show();
        $("#EiquetaPago").html('Total Pago');
    } else if (tipoLetra == 2) {
        $("#DivPagoLetra").hide();
        $("#DivRenovacion").show();
        $("#DivProtesto").hide();
        $("#EiquetaPago").show();
        $("#montopagoDetalle").show();
        $("#EiquetaPago").html('Total Renovacion');
    } else if (tipoLetra == 3) {
        $("#DivPagoLetra").hide();
        $("#DivRenovacion").hide();
        $("#DivProtesto").show();
        $("#EiquetaPago").hide();
        $("#montopagoDetalle").hide();
    }


    //$("#nombreDetalle").val(nombreCliente);
    //$("#idamortizacion").val(idamortizacion);
    //obtenerPendientePagoAmortizacion(idamortizacion);
}

function mostrarform_LetrasBco(flag) {
    limpiar_LetrasBco();
    if (flag) {
        console.log(flag);
        $("#listadoregistros").hide();
        $("#formularioregistrosDetalleLetras").show();
        $("#btnGuardarLetraPago").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        console.log(flag);
        $("#listadoregistros").show();
        $("#formularioregistrosDetalleLetras").hide();
        $("#btnagregar").show();
    }
}

function limpiar_LetrasBco() {
    $("#id").val("");
    $("#idLetraDetalle").val("");
    $("#montoidLetra").val("");
    $("#nombreDetalle").val("");
    $("#numerorPago").val("");
    $("#fechapago").val("");
    $("#fecharenovacion").val("");
    $("#fechavencimiento").val("");
    $("#fechaprotesto").val("");
    $("#comisionprotesto").val("");
    $("#montopagoDetalle").val("");
}

//Función cancelarform
function cancelarform_LetraPago() {
    mostrarform_LetrasBco(false);
}

//Función para guardar o editar
function guardaryeditar_Amortizacion(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    if (parseFloat($("#montopagoDetalle").val()) <= parseFloat($("#montopendienteamortizacionDetalle").val())) {

        $("#btnGuardarLetraBanco").prop("disabled", true);
        var formData = new FormData($("#formularioLetraBanco")[0]);

        $.ajax({
            url: "../ajax/pagoAmortizacion.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                bootbox.alert(datos);
                //mostrarform(false);
                //tabla.ajax.reload();
            }
        });

        var formData2 = new FormData($("#formulario")[0]);
        if (parseFloat($("#montopagoDetalle").val()) == parseFloat($("#montopendienteamortizacionDetalle").val())) {
            console.log('aqui igualdad');
            $.ajax({
                url: "../ajax/amortizacion.php?op=actualizarEstado",
                type: "POST",
                //data: {idamortizacion : idamortizacion},
                data: formData2,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log(datos);
                    /*
                    bootbox.alert(datos);
                    mostrarform(false);
                    tabla.ajax.reload();
                    */
                }
            });

        }
        mostrarform_PagoAmortizacion(false);
        tabla.ajax.reload();
        limpiar_PagoAmortizacion();
    } else {
        alert("EL MONTO DE PAGO SUPERA LA DEUDA PENDIENTE");
    }
}

function obtenerPendientePagoAmortizacion(idamortizacionDetalle) {

    //alert(idamortizacionDetalle);
    $.ajax({
        url: "../ajax/pagoAmortizacion.php?op=obtenerPendientePagoAmortizacion",
        type: "POST",
        data: { idamortizacionDetalle: idamortizacionDetalle },
        beforeSend: function () {
            console.log('data');
            //console.log(data);
        },
        success: function (datos) {
            console.log(datos);
            data = JSON.parse(datos);
            console.log(data);
            $("#montopendienteamortizacionDetalle").val(data.total_pago);
        }
    });
}



//Función para eliminar registros
/*
function eliminar(idpersona) {
    bootbox.confirm("¿Está Seguro de eliminar al Cliente?", function (result) {
        if (result) {
            $.post("../ajax/persona.php?op=eliminar", { idpersona: idpersona }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}
*/


init();
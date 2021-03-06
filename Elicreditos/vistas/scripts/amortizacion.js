var tabla;
var tabla2;
var tipovista = "";

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    mostrarform_PagoAmortizacion(false);

    //alert($(location).attr('href'));
    var link = $(location).attr('href');
    tipovista = link.substring(link.length - 24, link.length);
    $("#tipovista").val(tipovista);

    if(tipovista== 'amortizacionConsulta.php'){
        listarView();
    }else{
        listar();
    }
    
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioAmortizaciones").on("submit", function (e) {
        guardaryeditar_Amortizacion(e);
    })

    $.post("../ajax/persona.php?op=SelectPersona", function (r) {
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');
    });

    $.post("../ajax/tipoDocumento.php?op=SelectTipoDocumento", function (r) {
        $("#documento").html(r);
        $('#documento').selectpicker('refresh');
    });

}

//Función limpiar
function limpiar() {
    $("#idpersona").val("");
    $("#tipo_persona").val("");
    $("#id_cliente").val("");
    $("#documento").val("");
    $("#numerodoc").val("");
    $("#fechaemision").val("");
    $("#fechavencimiento").val("");
    $("#tipoMoneda").val("");
    $("#totaldeuda").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();

        $("#lblcondicion").hide();
        $("#condicion").hide();
        $("#lbltotaldeudaPendiente").hide();
        $("#totaldeudaPendiente").hide();
        $("#divListadoPagoAmortizacion").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();

        $("#lblcondicion").show();
        $("#condicion").show();
        $("#lbltotaldeudaPendiente").show();
        $("#totaldeudaPendiente").show();
        $("#divListadoPagoAmortizacion").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
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
                url: '../ajax/amortizacion.php?op=listar',
                type: "get",
                async: "false",
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

//Función Listar View
function listarView() {
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
                url: '../ajax/amortizacion.php?op=listarView',
                type: "get",
                async: "false",
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
        url: "../ajax/amortizacion.php?op=guardaryeditar",
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

function mostrar(idamortizacion) {
    //alert(idamortizacion);
    $.post("../ajax/amortizacion.php?op=mostrar", { idamortizacion: idamortizacion }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#btnGuardar").prop("disabled", true);
        $("#id_cliente").val(data.idcliente);
        $("#id_cliente").selectpicker('refresh');
        $("#documento").val(data.tipo_doc);
        $("#documento").selectpicker('refresh');
        $("#numerodoc").val(data.num_doc);
        $("#fechaemision").val(data.fecha_emi);
        $("#fechavencimiento").val(data.fecha_ven);
        $("#tipoMoneda").val(data.moneda);
        $("#totaldeuda").val(data.total);
        $("#condicion").show();
        $("#condicion").val(data.condicion == 1 ? "PENDIENTE" : "PAGADO");
        $("#pagorealizado").val(data.pagorealizado);
        $("#totaldeudaPendiente").val(data.pagopendiente);

        listar_PagoAmortizacion(idamortizacion);
        $("#lblcondicion").show();
        $("#condicion").show();
        $("#lbltotaldeudaPendiente").show();
        $("#totaldeudaPendiente").show();
        $("#divListadoPagoAmortizacion").show();
    })
}

// PARA AGREGAR PAGO AMORTIZACION

function amortizar(idamortizacion, nombreCliente) {
    mostrarform_PagoAmortizacion(true)
    $("#idamortizacionDetalle").val(idamortizacion);
    $("#nombreDetalle").val(nombreCliente);
    $("#idamortizacion").val(idamortizacion);
    obtenerPendientePagoAmortizacion(idamortizacion);
}

function mostrarform_PagoAmortizacion(flag) {
    limpiar_PagoAmortizacion();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistrosAmortizaciones").show();
        $("#btnGuardarPagoAmortizacion").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistrosAmortizaciones").hide();
        $("#btnagregar").show();
    }
}

function limpiar_PagoAmortizacion() {
    $("#idamortizacionDetalle").val("");
    $("#montopendienteamortizacionDetalle").val("");
    $("#nombreDetalle").val("");
    $("#numeroreciboDetalle").val("");
    $("#numerooperacionDetalle").val("");
    $("#descripcionDetalle").val("");
    $("#fechapagoDetalle").val("");
    $("#montopagoDetalle").val("");
}

//Función cancelarform
function cancelarform_PagoAmortizacion() {
    mostrarform_PagoAmortizacion(false);
}

//Función para guardar o editar
function guardaryeditar_Amortizacion(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    if (parseFloat($("#montopagoDetalle").val()) <= parseFloat($("#montopendienteamortizacionDetalle").val())) {

        $("#btnGuardarPagoAmortizacion").prop("disabled", true);
        var formData = new FormData($("#formularioAmortizaciones")[0]);

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
        $("#montopagoDetalle").focus();
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

            //console.log(data);
        },
        success: function (datos) {
            data = JSON.parse(datos);
            $("#montopendienteamortizacionDetalle").val(data.total_pago);
            $("#totaldeudaPendienteA").val(data.total_pago);
        }
    });
}

//Función Listar
function listar_PagoAmortizacion(id) {

    try {
        //adddlert("Welcome guest!");
        tabla2 = $('#tbllistadoPagoAmortizacion').dataTable(
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
                    url: '../ajax/pagoAmortizacion.php?op=listar&id=' + id,
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
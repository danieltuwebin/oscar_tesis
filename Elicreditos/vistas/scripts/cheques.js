var tabla;
var tabla2;
var tipovista = "";

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    mostrarform_PagoCheque(false);

    var link = $(location).attr('href');
    tipovista = link.substring(link.length - 19, link.length);
    $("#tipovista").val(tipovista);

    if (tipovista == 'chequesConsulta.php') {
        listarView();
    } else {
        listar();
    }

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioregistrosPagoCheque").on("submit", function (e) {
        guardaryeditar_PagoCheque(e);
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
    $("#idCheque").val("");
    $("#id_cliente").val("");
    $("#id_cliente").selectpicker('refresh');
    $("#tipocheque").val("");
    $("#tipocheque").selectpicker('refresh');
    $("#banco").val("");
    $("#banco").selectpicker('refresh');
    $("#tipodocumento").val("");
    $("#tipodocumento").selectpicker('refresh');
    $("#numerodocumento").val("");
    $("#fechaemision").val("");
    $("#fechavencimiento").val("");
    $("#tipoMoneda").val("");
    $("#tipoMoneda").selectpicker('refresh');
    $("#monto").val("");
    $("#imagen").val("");
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
    mostrarform_PagoCheque(false);
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
                url: '../ajax/cheques.php?op=listar',
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

//Función Listar
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
                url: '../ajax/cheques.php?op=listarView',
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
    console.log(formData);

    $.ajax({
        url: "../ajax/cheques.php?op=guardaryeditar",
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

function mostrar(idcheque) {
    $.post("../ajax/cheques.php?op=mostrar", { idcheque: idcheque }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        console.log('--- ' + data);
        $("#id_cliente").val(data.idcliente);
        $("#id_cliente").selectpicker('refresh');
        $("#tipocheque").val(data.tipo_cheque);
        $("#tipocheque").selectpicker('refresh');
        $("#banco").val(data.bco_cheque);
        $("#banco").selectpicker('refresh');
        $("#tipodocumento").val(data.doc_pago);
        $("#tipodocumento").selectpicker('refresh');
        $("#numerodocumento").val(data.num_docpago);
        $("#fechaemision").val(data.fecha_emi);
        $("#fechavencimiento").val(data.fecha_ven);
        $("#tipoMoneda").val(data.moneda);
        $("#tipoMoneda").selectpicker('refresh');
        $("#monto").val(data.monto);
        $("#condicion").show();
        $("#condicion").val(data.condicion == 1 ? "PENDIENTE" : "OTRO");

        listar_PagoCheque(idcheque);
    })
}


function pagoCheque(idCheque, nombreCliente) {
    mostrarform_PagoCheque(true)
    $("#idCheque").val(idCheque);
    $("#nombreDetalle").val(nombreCliente);
    obtenerPendientePagosCheque(idCheque);
}

function mostrarform_PagoCheque(flag) {
    limpiar_PagoCheque();
    if (flag) {
        console.log(flag);
        $("#listadoregistros").hide();
        $("#formularioregistrosPagoCheque").show();
        $("#btnGuardarPagoCheque").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else {
        console.log(flag);
        $("#listadoregistros").show();
        $("#formularioregistrosPagoCheque").hide();
        $("#btnagregar").show();
    }
}

function limpiar_PagoCheque() {
    $("#idCheq").val("");
    $("#idPagoCheque").val("");
    $("#montoidCheque").val("");
    $("#nombreDetalle").val("");
    $("#numeroPago").val("");
    $("#fechapago").val("");
    $("#montopagoDetalle").val("");
}

//Función cancelarform
function cancelarform_PagoCheque() {
    mostrarform_PagoCheque(false);
}

//Función para guardar o editar
function guardaryeditar_PagoCheque(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    console.log(parseFloat($("#montopagoDetalle").val()));
    console.log(parseFloat($("#pagopendiente").val()));
    if (parseFloat($("#montopagoDetalle").val()) <= parseFloat($("#pagopendiente").val())) {

        $("#btnGuardarPagoCheque").prop("disabled", true);
        var formData = new FormData($("#formularioPagoCheque")[0]);

        $.ajax({
            url: "../ajax/pagoCheque.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (datos) {
                bootbox.alert(datos);
                //$("#montopagoDetalle").val()
                //mostrarform(false);
                //tabla.ajax.reload();
                $("#idcheque").val($("#idCheque").val());
                console.log($("#idcheque").val());
            }
        });

        var formData2 = new FormData($("#formulario")[0]);
        console.log(formData2);
        if (parseFloat($("#montopagoDetalle").val()) == parseFloat($("#pagopendiente").val())) {
            console.log('aqui igualdad');

            // Build the data object.
            const data = {};
            formData2.forEach((value, key) => (data[key] = value));
            // Log the data.
            console.log(data);

            $.ajax({
                url: "../ajax/cheques.php?op=actualizarEstado",
                type: "POST",
                //data: {idamortizacion : idamortizacion},
                data: formData2,
                contentType: false,
                processData: false,
                success: function (datos) {
                    console.log(datos);
                    $("#idcheque").val('');
                    /*
                    bootbox.alert(datos);
                    mostrarform(false);
                    tabla.ajax.reload();
                    */
                }
            });

        }
        mostrarform_PagoCheque(false);
        tabla.ajax.reload();
        limpiar_PagoCheque();
    } else {
        alert("EL MONTO DE PAGO SUPERA LA DEUDA PENDIENTE");
    }
}

function obtenerPendientePagosCheque(idCheque) {

    $.ajax({
        url: "../ajax/pagoCheque.php?op=obtenerPendientePagosCheque",
        type: "POST",
        data: { idCheque: idCheque },
        beforeSend: function () {
            console.log('data');
            //console.log(data);
        },
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);
            $("#pagorealizado").val(data.pagorealizado);
            $("#pagopendiente").val(data.pagopendiente);

            console.log($("#pagorealizado").val());
            console.log($("#pagopendiente").val());
            $("#deudapendiente").val(data.pagopendiente);

        }
    });
}

//Función Listar
function listar_PagoCheque(id) {
    try {
        //adddlert("Welcome guest!");
        tabla2 = $('#tbllistadoPagoCheque').dataTable(
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
                    url: '../ajax/pagoCheque.php?op=listar&id=' + id,
                    type: "get",
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                },
                "bDestroy": true,
                "iDisplayLength": 5,//Paginación
                "order": [[0, "asc"]]//Ordenar (columna,orden)
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
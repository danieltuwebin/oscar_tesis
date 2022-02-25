var tabla;
var tabla2;
var valorRespuesta = "";
var idLetraActualizaNU = "";
var tipovista = "";

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    mostrarform_LetrasBco(false);

    var link = $(location).attr('href');
    tipovista = link.substring(link.length - 21, link.length);
    $("#tipovista").val(tipovista);

    if(tipovista== 'letrasbcoConsulta.php'){
        listarView();
    }else{
        listar();
    }

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioDetalleLetras").on("submit", function (e) {
        guardaryeditar_DetalleLetras(e);
    })

    $.post("../ajax/persona.php?op=SelectPersona", function (r) {
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');

        $("#nombreDetalle").html(r);
        $('#nombreDetalle').selectpicker('refresh');
    });

}

//Función limpiar
function limpiar() {
    $("#idpersona").val("");
    $("#idletra").val("");
    $("#totalRenovacion").val("");
    $("#id_cliente").val("");
    $("#id_cliente").selectpicker('refresh');
    //$("#tipoletra").val("");
    //$("#tipoletra").selectpicker('refresh');
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
        $("#btnAgregarNumeroUnico").hide();
        $("#divcondicion").hide();
        $("#divListadoDetalleLetra").hide();
    }
    else {
        console.log(flag);
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
                url: '../ajax/letras.php?op=listarView',
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
    idLetraActualizaNU = idletra;
    $.post("../ajax/letras.php?op=mostrar", { idletra: idletra }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#btnGuardar").prop("disabled", true);
        $("#btnAgregarNumeroUnico").show();
        console.log('--- ' + data);
        $("#id_cliente").val(data.idcliente);
        $("#id_cliente").selectpicker('refresh');
        $("#totalRenovacion").val(data.totalRenovacion);
        $("#tipoletra").val(data.tipo_letra);
        //$("#tipoletra").selectpicker('refresh');
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

        listar_DetalleLetra(idletra);
        $("#divListadoDetalleLetra").show();
    })
}

// PARA AGREGAR PAGO AMORTIZACION
function detalleLetra(idletra, tipoLetra, monto, idcliente) {
    mostrarform_LetrasBco(true)
    $("#idLetraDetalle").val(idletra);
    if (tipoLetra == 1) {
        //$("#DivPeudaPendiente").hide();
        $("#DivPeudaPendiente").css("display", "none");
        $("#DivTotalPago").css("display", "block");
        $("#DivPagoLetra").show();
        $("#DivRenovacion").hide();
        $("#DivProtesto").hide();
        $("#EiquetaPago").show();
        //$("#montopagoDetalle").show();
        $("#montopagoDetalle").css("display", "block");
        $("#EiquetaPago").html('Total Pago');
        $("#montoidLetra").val(monto);
        $("#montopagoDetalle").val(monto);
        $("#montopagoDetalle").prop('disabled', true);
        $("#tipoLetraDetalle").val(tipoLetra);
        $("#nombreDetalle").val(idcliente);
        $("#nombreDetalle").selectpicker('refresh');
    } else if (tipoLetra == 2) {
        //$("#DivPeudaPendiente").show();
        $("#DivPeudaPendiente").css("display", "block");
        $("#DivTotalPago").css("display", "block");
        $("#DivPagoLetra").hide();
        $("#DivRenovacion").show();
        $("#DivProtesto").hide();
        $("#EiquetaPago").show();
        //$("#montopagoDetalle").show();
        $("#montopagoDetalle").css("display", "block");
        $("#montopagoDetalle").prop('disabled', false);
        $("#EiquetaPago").html('Total Renovacion');
        $("#montoidLetra").val(monto);
        $("#tipoLetraDetalle").val(tipoLetra);
        $("#nombreDetalle").val(idcliente);
        $("#nombreDetalle").selectpicker('refresh');
        ObtieneDeudaPendiente(idletra);
    } else if (tipoLetra == 3) {
        //$("#DivPeudaPendiente").show();
        $("#DivPeudaPendiente").css("display", "block");
        $("#DivTotalPago").css("display", "none");
        $("#DivPagoLetra").hide();
        $("#DivRenovacion").hide();
        $("#DivProtesto").show();
        $("#EiquetaPago").hide();
        //$("#montopagoDetalle").hide();
        $("#montopagoDetalle").css("display", "none");
        $("#montoidLetra").val(monto);
        $("#tipoLetraDetalle").val(tipoLetra);
        $("#nombreDetalle").val(idcliente);
        $("#nombreDetalle").selectpicker('refresh');
    }
}

function ObtieneDeudaPendiente(id) {
    $.ajax({
        url: "../ajax/letras.php?op=obtieneDeudaPendiente",
        type: "POST",
        data: { "idletra": id },
        success: function (data) {
            data = JSON.parse(data);
            $("#deudaPendiente").val(data.total);
        }
    });
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
    $("#numeroPago").val("");
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
function guardaryeditar_DetalleLetras(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento

    // PARA EL PAGO LETRA
    if ($("#tipoLetraDetalle").val() == '1') {
        if (parseFloat($("#montoidLetra").val()) == parseFloat($("#montopagoDetalle").val()) && $("#tipoLetraDetalle").val() == '1') {
            $("#btnGuardarLetraPago").prop("disabled", true);
            var formData = new FormData($("#formularioDetalleLetras")[0]);

            // GRB DETALLE-LETRA
            $.ajax({
                url: "../ajax/detalleLetras.php?op=guardaryeditar",
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
            if (valorRespuesta == 1) {
                $.ajax({
                    url: "../ajax/letras.php?op=actualizarEstado",
                    type: "POST",
                    data: { "idletra": $("#idLetraDetalle").val(), "condicion": '4' },
                    success: function (datos) {
                        bootbox.alert(datos);
                    }
                });
            }

            // MUESTRA-CARGA-LIMPIA FRM
            mostrarform_LetrasBco(false);
            tabla.ajax.reload();
        } else {
            alert("EL MONTO DE PAGO ES DIFERENTE AL TOTAL DE LA LETRA");
        }
    }

    // PARA EL PAGO RENOVACION
    if ($("#tipoLetraDetalle").val() == '2') {

        // OBTIENE (totalRenovacion)
        $.ajax({
            url: "../ajax/letras.php?op=mostrar",
            type: "POST",
            data: { "idletra": $("#idLetraDetalle").val() },
            async: false,
            success: function (data) {
                data = JSON.parse(data);
                console.log('--- ' + data.totalRenovacion);
                $("#totalRenovacion").val(data.totalRenovacion);
            }
        });

        console.log($("#montopagoDetalle").val());
        console.log($("#totalRenovacion").val());
        console.log($("#tipoLetraDetalle").val());

        // GRB DETALLE-LETRA
        if ((parseFloat($("#montopagoDetalle").val()) <= parseFloat($("#totalRenovacion").val())) && $("#tipoLetraDetalle").val() == '2') {
            //if (parseFloat($("#montoidLetra").val()) >= (parseFloat($("#montopagoDetalle").val()) + parseFloat($("#totalRenovacion").val())) && $("#tipoLetraDetalle").val() == '2') {
            $("#btnGuardarLetraPago").prop("disabled", true);
            var formData = new FormData($("#formularioDetalleLetras")[0]);
            $.ajax({
                url: "../ajax/detalleLetras.php?op=guardaryeditar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                async: false,
                success: function (datos) {
                    valorRespuesta = datos;
                }
            });

            //ACTUALIZA ESTADO PAGADO
            if (valorRespuesta == 1 && (parseFloat($("#montopagoDetalle").val()) == parseFloat($("#totalRenovacion").val()))) {
                //if (valorRespuesta == 1 && parseFloat($("#montoidLetra").val()) == (parseFloat($("#montopagoDetalle").val()) + parseFloat($("#totalRenovacion").val()))) {
                $.ajax({
                    url: "../ajax/letras.php?op=actualizarEstado",
                    type: "POST",
                    data: { "idletra": $("#idLetraDetalle").val(), "condicion": '4' },
                    success: function (datos) {
                        bootbox.alert(datos);
                    }
                });
                //ACTUALIZA ESTADO RENOVACION
            } else if (valorRespuesta == 1) {
                $.ajax({
                    url: "../ajax/letras.php?op=actualizarEstado",
                    type: "POST",
                    data: { "idletra": $("#idLetraDetalle").val(), "condicion": '2' },
                    success: function (datos) {
                        bootbox.alert(datos);
                    }
                });
            }

            // MUESTRA-CARGA-LIMPIA FRM
            mostrarform_LetrasBco(false);
            tabla.ajax.reload();

        } else {
            alert("EL MONTO DE PAGO ES DIFERENTE AL TOTAL O UNA FRACCION DE LA LETRA");
        }
    }

    // PARA EL PAGO RENOVACION
    if ($("#tipoLetraDetalle").val() == '3') {

        // GRB DETALLE-LETRA
        $("#btnGuardarLetraPago").prop("disabled", true);
        var formData = new FormData($("#formularioDetalleLetras")[0]);
        $.ajax({
            url: "../ajax/detalleLetras.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            async: false,
            success: function (datos) {
                valorRespuesta = datos;
            }
        });

        //ACTUALIZA ESTADO PROTESTO
        if (valorRespuesta == 1) {
            $.ajax({
                url: "../ajax/letras.php?op=actualizarEstado",
                type: "POST",
                data: { "idletra": $("#idLetraDetalle").val(), "condicion": '3' },
                success: function (datos) {
                    bootbox.alert(datos);
                }
            });
        }

        // MUESTRA-CARGA-LIMPIA FRM
        mostrarform_LetrasBco(false);
        tabla.ajax.reload();

    }
}

function MuestraFrmNumUnico() {
}

$("#btnAgregarNumeroUnico").click(function () {
    let numero = prompt("Ingrese el número Unico", "");
    if (numero != null) {
        $.ajax({
            url: "../ajax/letras.php?op=actualizarNumeroUnico",
            type: "POST",
            data: { "idletra": idLetraActualizaNU, "numerounico": numero },
            success: function (datos) {
                bootbox.alert(datos);
                mostrarform(false);
                tabla.ajax.reload();
            }
        });
    } else {
        alert("No ingreso un numero valido");
    }
    /*
    var bool=confirm("Esta seguro de agregar el numero Unico para la Letra ?");
    if(bool){
      alert("se elimino correctamente");
    }else{
      alert("cancelo la solicitud");
    }
    */
});



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
                    url: '../ajax/detalleLetras.php?op=listar&id=' + id,
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
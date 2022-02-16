# oscar_tesis
PY para la tesis de Oscar Ramos

-- rama MAESTRA o master es la principal

-- Ruta 
http://186.64.116.55/~slvzone/oscar/vistas/login.html

-- test 09022022 desde PC



******************* controles de [[ letrasbco.php ]] *************************

formularioregistrosDetalleLetras
formularioDetalleLetras

id
idLetraDetalle
montoidLetra
nombreDetalle
numerorPago
fechapago
fecharenovacion
fechavencimiento
fechaprotesto
comisionprotesto
montopagoDetalle

btnGuardarLetraPago
cancelarform_LetraPago

DivPagoLetra
DivRenovacion
DivProtesto
EiquetaPago


***************************************************************************



--- REUNION 10-02-22
EN LETRAS AL BANCO - AGREGAR LA OPCION PARA AGREGAR EL NUMERO UNICO 
-- NO CAMBIA EL ESTADO CUANDO SE AGREGA EL NUMERO UNICO

--> CUANDO SE REALIZADO UN PAGO LETRA SE AGREGA POR EL TOTAL DE LA LETRA Y EL ESTADO CAMBIA A PAGADO
    DESPUES DE GRABAR EL PAGO LOS BOTONES DE PAGO NO SE DEBEN MOSTRAR
--> CUANDO SE REALIZO UNA RENOVACION ESTA PUEDE SER POR UN MONTO INFERIOR O IGUAL AL TOTAL 
    SI ES MENOR SE MANTIENE SE CAMBIA EL ESTADO A RENOVADO
    SI ES POR EL TOTAL O EL MONTO MAS LOS ANTERIORES SUMAN EL TOTAL SE CAMBIA EL ESTADO A PAGADO
    * SI UNA CUOTA DE LETRA VENCE SE PUEDE AGREGAR UN PROTESTO EL CUAL SUMA AL TOTAL DE LA CABECERA - Y EL ESTADO SE CAMBIA A PROTESTO
    *** OPCIONAL VER EL MONTO PENDIENTE DE PAGAR

-- EL EL FORMULARIO LETRAS BANCO SOLO DEBE IR TIPO DE LETRA BANCO --> OK


------------------------*****
FORMULARIO LETRAS CARTERA
--> MISMA BD (CREADO LETRAS_CARTERA)
--> MISMA INTERFAZ
--> EL PAGO DE LETRA A CARTERA ES IGUAL AL (FMR LETRA-BANCO / PAGO LETRA)
--> PUEDEN HACERCE VARIOS PAGOS
--> SI SE PAGA LA TOTALIDAD CAMBIA A ESTADO PAGADO
--> MOSTRAR EL HISTORIAL



******** OPCIONAL DEUDA PENDIENTE


--------------------------**

EN CHUQUE QUE PERMITA VER IMAGEN

<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['Consultas'] == 1) {
?>

    <STYLE type="text/css">
      input {
        text-transform: uppercase;
      }
    </STYLE>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Consulta Cheques&nbsp;
                  <!--<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>-->
                  <!--<a target="_blank" href="../reportes/rptclientes.php">
                     <button class="btn btn bg-blue"><i class="fa fa-file"></i>Reporte</button>
                    </a>-->
                </h1>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Tipo Cheque</th>
                    <th>Banco</th>
                    <th>tipo Doc.</th>
                    <th>Numero Doc.</th>
                    <th>Fec. Emisión</th>
                    <th>Fec. Vencimiento</th>
                    <th>Moneda</th>
                    <th>Monto</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Tipo Cheque</th>
                    <th>Banco</th>
                    <th>tipo Doc.</th>
                    <th>Numero Doc.</th>
                    <th>Fec. Emisión</th>
                    <th>Fec. Vencimiento</th>
                    <th>Moneda</th>
                    <th>Monto</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="idpersona" id="idpersona">
                    <input type="hidden" name="idcheque" id="idcheque">
                    <label>Nombre de Cliente(*):</label>
                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" maxlength="100">
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Cheque(*):</label>
                    <select name="tipocheque" id="tipocheque" class="form-control selectpicker">
                      <option value="">Seleccione Tipo de Cheque</option>
                      <option value="TIPO 1">TIPO 1</option>
                      <option value="TIPO 2">TIPO 2</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Banco(*):</label>
                    <select name="banco" id="banco" class="form-control selectpicker">
                      <option value="">Seleccione Banco</option>
                      <option value="BBVA">BBVA</option>
                      <option value="BCP">BCP</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Documento(*):</label>
                    <select name="tipodocumento" id="tipodocumento" class="form-control selectpicker">
                      <option value="">Seleccione Tipo Documento</option>
                      <option value="DOCUMENTO 1">DOCUMENTO 1</option>
                      <option value="DOCUMENTO 2">DOCUMENTO 2</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Número Documento:</label>
                    <input type="text" class="form-control" name="numerodocumento" id="numerodocumento" maxlength="20">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Emisión(*):</label>
                    <input class="form-control" type="date" name="fechaemision" id="fechaemision" maxlength="100">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Vencimiento(*):</label>
                    <input class="form-control" type="date" name="fechavencimiento" id="fechavencimiento" maxlength="100">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Tipo Moneda(*):</label>
                    <select name="tipoMoneda" id="tipoMoneda" class="form-control selectpicker">
                      <option value="">Seleccione Tipo de Moneda</option>
                      <option value="SOLES">SOLES</option>
                      <option value="DOLAR">DOLAR</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Monto:</label>
                    <input type="text" class="form-control" name="monto" id="monto" maxlength="70">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen">
                    <input type="hidden" name="imagenactual" id="imagenactual">
                    <img src="" width="150px" height="100px" id="imagenmuestra">
                  </div>

                  <div id="divcondicion" class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Condición:</label>
                    <input type="text" class="form-control" name="condicion" id="condicion" readonly>
                  </div>

                  <div id="divListadoPagoCheque" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel-body table-responsive" id="listadoregistrosPagoCheque">
                      <table id="tbllistadoPagoCheque" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Id</th>
                          <th>Nro. Pago</th>
                          <th>Fecha pago</th>
                          <th>Monto</th>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>


                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>

              <!-- INICIO FRM DETALLE LETRAS -->
              <div class="panel-body" style="height: 400px;" id="formularioregistrosPagoCheque">
                <form name="formularioPagoCheque" id="formularioPagoCheque" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="idCheque" id="idCheque">
                    <input type="hidden" name="idPagoCheque" id="idPagoCheque">
                    <input type="hidden" name="montoidCheque" id="montoidCheque">
                    <input type="hidden" name="pagorealizado" id="pagorealizado">
                    <input type="hidden" name="pagopendiente" id="pagopendiente">
                    <label>Nombre de Cliente:</label>
                    <input type="text" id="nombreDetalle" name="nombreDetalle" class="form-control" readonly>
                  </div>

                  <div id="DivPagoLetra">
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                      <label>Numero Pago(*):</label>
                      <input type="text" id="numeroPago" name="numeroPago" class="form-control">
                    </div>

                    <div class="form-group col-lg-3 col-md-6 col-xs-12">
                      <label for="">Fecha Pago(*):</label>
                      <input class="form-control" type="date" name="fechapago" id="fechapago">
                    </div>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="EiquetaPago">Total Pago(*):</label>
                    <input type="text" class="form-control" name="montopagoDetalle" id="montopagoDetalle">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="EiquetaPago">Deuda Pendiente:</label>
                    <input type="text" class="form-control" name="deudapendiente" id="deudapendiente" readonly>
                  </div>               

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardarPagoCheque"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform_PagoCheque()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>
              <!-- FIN FRM AMORTIZACIONES -->

              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
  <?php
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/cheques.js"></script>

<?php
}
ob_end_flush();
?>
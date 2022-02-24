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
                <h1 class="box-title">Letras Cartera&nbsp;
                  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
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
                    <th>Tipo Letra</th>
                    <th>Numero Letra</th>
                    <th>Numero Factura</th>
                    <th>Lugar Giro</th>
                    <th>Fec. Emisión</th>
                    <th>Fec. Vencimiento</th>
                    <th>Moneda</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Tipo Letra</th>
                    <th>Numero Letra</th>
                    <th>Numero Factura</th>
                    <th>Lugar Giro</th>
                    <th>Fec. Emisión</th>
                    <th>Fec. Vencimiento</th>
                    <th>Moneda</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 800px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="idpersona" id="idpersona">
                    <input type="hidden" name="idletra" id="idletra">
                    <input type="hidden" name="totalPagoRealizado" id="totalPagoRealizado">
                    <input type="hidden" name="totalPagoPendiente" id="totalPagoPendiente">
                    <label>Nombre de Cliente(*):</label>
                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" maxlength="100">
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Letra(*):</label>
                    <input type="text" class="form-control" name="tipoletra" id="tipoletra" maxlength="20" value="LETRA CARTERA" readonly>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Número Letra:</label>
                    <input type="text" class="form-control" name="numeroletra" id="numeroletra" maxlength="20">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Número Factura:</label>
                    <input type="text" class="form-control" name="numerofactura" id="numerofactura" maxlength="20">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Lugar Giro(*):</label>
                    <select name="lugargiro" id="lugargiro" class="form-control selectpicker">
                      <option value="">Seleccione lugar giro</option>
                      <option value="LIMA">LIMA</option>
                      <option value="PROVINCIA">PROVINCIA</option>
                    </select>
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
                    <label>Total Letra:</label>
                    <input type="text" class="form-control" name="totalletra" id="totalletra" maxlength="70">
                  </div>

                  <div id="divcondicion" class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Condición:</label>
                    <input type="text" class="form-control" name="condicion" id="condicion" readonly>
                  </div>

                  <div id="divListadoDetalleLetra" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel-body table-responsive" id="listadoregistrosDetalleLetra">
                      <table id="tbllistadoDetalleLetra" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Id</th>
                          <th>Tipo Letra</th>
                          <th>Nro. Recibo</th>
                          <th>Nro. Operación</th>
                          <th>Descripción</th>
                          <th>F. Pago</th>
                          <th>Total Pago</th>
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
              <div class="panel-body" style="height: 400px;" id="formularioregistrosDetalleLetras">
                <form name="formularioDetalleLetras" id="formularioDetalleLetras" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="idLetraDetalle" id="idLetraDetalle">
                    <input type="hidden" name="montoidLetra" id="montoidLetra">
                    <label>Nombre de Cliente:</label>
                    <input type="text" id="nombreDetalle" name="nombreDetalle" class="form-control" readonly>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Numero Recibo(*):</label>
                    <input type="text" id="numeroRecibo" name="numeroRecibo" class="form-control">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Numero Operación(*):</label>
                    <input type="text" id="numeroOperacion" name="numeroOperacion" class="form-control">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Descripción(*):</label>
                    <input type="text" id="descripcion" name="descripcion" class="form-control">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Pago(*):</label>
                    <input class="form-control" type="date" name="fechapago" id="fechapago">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="EiquetaPago">Total Pago(*):</label>
                    <input type="text" class="form-control" name="montopagoDetalle" id="montopagoDetalle">
                  </div>

                  <div id="divDeudaPendiente" class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Deuda Pendiente:</label>
                    <input type="text" class="form-control" name="deudapendiente" id="deudapendiente" readonly>
                  </div>                  

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardarLetraPago"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn btn-danger" onclick="cancelarform_LetraPago()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
  <script type="text/javascript" src="scripts/letrascartera.js"></script>

<?php
}
ob_end_flush();
?>
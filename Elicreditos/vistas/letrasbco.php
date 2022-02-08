<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['ventas'] == 1) {
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Letras Banco&nbsp;
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
                    <th>Num. Unico</th>
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
                    <th>Num. Unico</th>
                    <th>Moneda</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="idpersona" id="idpersona">
                    <input type="hidden" name="idletra" id="idletra">
                    <label>Nombre de Cliente(*):</label>
                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" maxlength="100">
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Tipo Letra(*):</label>
                    <select name="tipoletra" id="tipoletra" class="form-control select-picker">
                      <option value="">Seleccione Tipo de Letra</option>
                      <option value="LETRA CARTERA">LETRA CARTERA</option>
                      <option value="LETRA BANCO">LETRA BANCO</option>
                    </select>
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
                    <select name="lugargiro" id="lugargiro" class="form-control select-picker">
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

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Numero Unico:</label>
                    <input type="text" class="form-control" name="numerounico" id="numerounico" maxlength="70">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Tipo Moneda(*):</label>
                    <select name="tipoMoneda" id="tipoMoneda" class="form-control select-picker">
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

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>

              <!-- INICIO FRM AMORTIZACIONES -->
              <div class="panel-body" style="height: 400px;" id="formularioregistrosAmortizaciones">
                <form name="formularioAmortizaciones" id="formularioAmortizaciones" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="idamortizacionPago" id="idamortizacionPago">
                    <input type="hidden" name="idamortizacionDetalle" id="idamortizacionDetalle">
                    <input type="hidden" name="montopendienteamortizacionDetalle" id="montopendienteamortizacionDetalle">
                    <label>Nombre de Cliente:</label>
                    <input type="text" id="nombreDetalle" name="nombreDetalle" class="form-control" readonly>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Numero Recibo(*):</label>
                    <input type="text" id="numeroreciboDetalle" name="numeroreciboDetalle" class="form-control">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Numero Operación(*):</label>
                    <input type="text" id="numerooperacionDetalle" name="numerooperacionDetalle" class="form-control">
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Descripción(*):</label>
                    <input type="textarea" id="descripcionDetalle" name="descripcionDetalle" rows="2" class="form-control">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Pago(*):</label>
                    <input class="form-control" type="date" name="fechapagoDetalle" id="fechapagoDetalle">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Monto Pago(*):</label>
                    <input type="text" class="form-control" name="montopagoDetalle" id="montopagoDetalle">
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardarPagoAmortizacion"><i class="fa fa-save"></i> Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform_PagoAmortizacion()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
  <script type="text/javascript" src="scripts/letrasbco.js"></script>

<?php
}
ob_end_flush();
?>
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
                <h1 class="box-title">Consulta Amortización&nbsp;
                  <!--<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>-->
                  <!--<a target="_blank" href="../reportes/rptclientes.php">
                     <button class="btn btn bg-blue"><i class="fa fa-file"></i>Reporte</button>
                    </a>-->
                </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Documento</th>
                    <th>Numero Doc.</th>
                    <th>Fecha Emisión</th>
                    <th>Fecha Vencimiento</th>
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
                    <th>Documento</th>
                    <th>Numero Doc.</th>
                    <th>Fecha Emisión</th>
                    <th>Fecha Vencimiento</th>
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
                    <input type="hidden" name="tipo_persona" id="tipo_persona">
                    <input type="hidden" name="idamortizacion" id="idamortizacion">
                    <input type="hidden" name="pagorealizado" id="pagorealizado">
                    <input type="hidden" name="tipovista" id="tipovista">
                    <label>Nombre de Cliente(*):</label>
                    <select id="id_cliente" name="id_cliente" class="form-control selectpicker" data-live-search="true" maxlength="100">
                    </select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Documento(*):</label>
                    <select id="documento" name="documento" class="form-control selectpicker" data-live-search="true" required>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Número Documento:</label>
                    <input type="text" class="form-control" name="numerodoc" id="numerodoc" maxlength="20" placeholder="Documento">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Emisión(*):</label>
                    <input class="form-control" type="date" name="fechaemision" id="fechaemision" maxlength="100" placeholder="fechainicio">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-xs-12">
                    <label for="">Fecha Vencimiento(*):</label>
                    <input class="form-control" type="date" name="fechavencimiento" id="fechavencimiento" maxlength="100" placeholder="fechainicio">
                  </div>

                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Tipo Moneda(*):</label>
                    <select name="tipoMoneda" id="tipoMoneda" class="form-control select-picker">
                      <option value="">Seleccione Tipo de Moneda</option>
                      <option value="SOLES">SOLES</option>
                      <option value="DOLAR">DOLAR</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label>Total Deuda:</label>
                    <input type="text" class="form-control" name="totaldeuda" id="totaldeuda" maxlength="70" placeholder="TOTAL DEUDA">
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="lbltotaldeudaPendiente">Total Deuda Pendiente:</label>
                    <input type="text" class="form-control" name="totaldeudaPendiente" id="totaldeudaPendiente" readonly>
                  </div>

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="lblcondicion">Condición:</label>
                    <input type="text" class="form-control" name="condicion" id="condicion" readonly>
                  </div>

                  <div id="divListadoPagoAmortizacion" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel-body table-responsive" id="listadoregistrosPagoAmortizacion">
                      <table id="tbllistadoPagoAmortizacion" class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                          <th>Id</th>
                          <th>Nro. Recibo</th>
                          <th>Nro. Operación</th>
                          <th>Descripción</th>
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

                  <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <label id="lbltotaldeudaPendiente">Deuda Pendiente:</label>
                    <input type="text" class="form-control" name="totaldeudaPendienteA" id="totaldeudaPendienteA" readonly>
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
  <script type="text/javascript" src="scripts/amortizacion.js?v=1"></script>

<?php
}
ob_end_flush();
?>
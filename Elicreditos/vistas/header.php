<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Comercializadora Elidi E.I.R.L.</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/favicon.ico">

  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

</head>

<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="wrapper">

    <header class="main-header bg-blue">

      <!-- Logo -->
      <a href="index2" class="logo bg-blue">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini bg-blue sky"><b>Elidi</b>Cobranzas</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Cobranza Elidi</b></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top bg-blue" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle bg-blue" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu ">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu ">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image " alt="User Image">
                <span class="hidden-xs "> <?php echo $_SESSION['nombre']; ?> </span>
              </a>
              <ul class="dropdown-menu ">
                <!-- User image -->
                <li class="user-header bg-blue">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    Empresa Comercializadora elidi E.I.R.L.
                    <small> Calidad y Garantia </small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer bg-aqua">

                  <div class="pull-ri3ght ">
                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat bg-red">Cerrar Cesión</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"></li>

          <?php
          if ($_SESSION['escritorio'] == 1) {
            echo '<li>
              <a href="escritorio.php">
                <i class="fa fa-television"></i> <span>Escritorio</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Cuentas Por Cobrar </span>
                <span class="label label-primary pull-right bg-green"><i class="fa fa-money"></i></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="cliente.php"><i class="fa fa-plus-circle"></i> Clientes</a></li>
                <li><a href="amortizacion.php"><i class="fa fa-plus-circle"></i> Cobro de Amortizaciones</a></li>
                <li><a href="letrasbco.php"><i class="fa fa-plus-circle"></i> Letras Al Banco</a></li>
                <li><a href="letrascartera.php"><i class="fa fa-plus-circle"></i> Letras en Cartera </a></li>
                <li><a href="cheques.php"><i class="fa fa-plus-circle"></i>Cheques</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-question"></i>
                <span> Consultas de Cobranza </span>
                <span class="label label-primary pull-right bg-green"><i class="fa fa-question"></i></i></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="cliente.php"><i class="fa fa-plus-circle"></i> Clientes</a></li>
                <li><a href="amortizacion.php"><i class="fa fa-plus-circle"></i> Cobro de Amortizaciones</a></li>
                <li><a href="letrasbco.php"><i class="fa fa-plus-circle"></i> Letras Al Banco</a></li>
                <li><a href="letrascartera.php"><i class="fa fa-plus-circle"></i> Letras en Cartera </a></li>
                <li><a href="cheques.php"><i class="fa fa-plus-circle"></i>Cheques</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['acceso'] == 1) {
            echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-key"></i> 
                <span>Acceso</span>
                <span class="label label-primary pull-right bg-green"><i class="fa fa-key"></i></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="usuario.php"><i class="fa fa-user"></i> Usuarios</a></li>
                <li><a href="permiso.php"><i class="fa fa-unlock"></i> Permisos</a></li>                
              </ul>
            </li>';
          }
          ?>

          <?php
          /*
          if (isset($_SESSION['consultav'])) {
            if ($_SESSION['consultav'] == 1) {
              echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="ventasfechacliente.php"><i class="fa fa-plus-circle"></i> Consulta Ventas</a></li>                
              </ul>
            </li>';
            }
          }
          */
          ?>

          <?php
          /* if ($_SESSION['configuracion'] == 1) { ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Configuración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="perfil-empresa.php"><i class="fa fa-circle-o"></i> Perfil</a></li>
              </ul>
            </li>
          <?php } */
          ?>

          <li>
            <a href="#">
              <i class="fa fa-plus-square"></i> <span>Ayuda</span>
              <small class="label pull-right bg-red">PDF</small>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
              <small class="label pull-right bg-yellow">PS</small>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
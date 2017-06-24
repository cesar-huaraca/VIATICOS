<?php

session_start();
if(empty($_SESSION['dni'])) { 
        header('Location: login.html');
    }




// Primero definimos la conexión a la base de datos
define('HOST_DB', 'localhost');  //Nombre del host, nomalmente localhost
define('USER_DB', 'root');       //Usuario de la bbdd
define('PASS_DB', '');           //Contraseña de la bbdd
define('NAME_DB', 'db_viaticos'); //Nombre de la bbdd

// Definimos la conexión
function conectar(){
    global $conexion;  //Definición global para poder utilizar en todo el contexto
    $conexion = @mysql_connect(HOST_DB, USER_DB, PASS_DB)
    or die ('NO SE HA PODIDO CONECTAR AL MOTOR DE LA BASE DE DATOS');
    mysql_select_db(NAME_DB)
    or die ('NO SE ENCUENTRA LA BASE DE DATOS ' . NAME_DB);
}
function desconectar(){
    global $conexion;
    mysql_close($conexion);
}

conectar();
// Si hay información para buscar, abrimos la conexión

mysql_set_charset('utf8');  // mostramos la información en utf-8
$busqueda = isset($_POST['dni']);
echo $busqueda;


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MINSA - Sistema de Viáticos</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Titulo de la web -->
                <a class="navbar-brand" href="index.php">Ministerio de Salud - Sistema de Viáticos</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <ul class="dropdown-menu dropdown-messages">  
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                     <ul class="dropdown-menu dropdown-tasks">
                        <li class="divider"></li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <ul class="dropdown-menu dropdown-alerts">
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Impresión<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="rpt_sol.html">Solicitud</a>
                                </li>
                                <li>
                                    <a href="rpt_pla.html">Planilla</a>
                                </li>
                                <li>
                                    <a href="rpt_ret.html">Retención</a>
                                </li>                              
                                <li>
                                    <a href="rpt_ren.html">Rendición</a>
                                </li>                              
                                <li>
                                    <a href="rpt_dja.html">Declaración Jurada</a>
                                </li>                                    
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="user_01.php"><i class="fa fa-table fa-fw"></i> Nueva Solicitud</a>
                        </li>
                        <li>
                            <a href="user_04.html"><i class="fa fa-edit fa-fw"></i> Rendición</a>
                        </li>
                        <li>
                            <a href="user_05.html"><i class="fa fa-edit fa-fw"></i> Declaración Jurada</a>
                        </li>                        

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <!-- CONTENIDO DE LA PAGINA WEB EN SI ... AQUI SE PONDRA TODO DE LA WEB -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bienvenidos al Sistema de Viáticos del Ministerio de Salud</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="wizard-header">
                        <h3 class="wizard-title"></h3>
                        <p class="category"></p>
                        <P></P>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                    <B>Area Usuaria</B>
                                    <P></P>
                                        Nro. de Solicitudes sin  <b>RENDIR</b>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>DNI</th>
                                                    <th>Expediente</th>
                                                    <th>Solicitud</th>
                                                    <th>Meta</th>
                                                    <th>Nro. SIAF</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $sql = "SELECT * FROM planilla WHERE dni='$busqueda' and estado ='Por Rendir' ";

                                            $cexp = "";
                                            $cnso = "";
                                            $dter = "";
                                            $siaf = "";
                                            $cdni = "";

                                            $resultado = @mysql_query($sql,$enlace);
                                            //$result = mysql_query($sql); //Ejecución de la consulta
                                                  if (@mysql_num_rows($resultado) > 0){ 
                                                     // Se recoge el número de resultados
                                                     // Se almacenan las cadenas de resultado
                                                     while($fila1 = @mysql_fetch_assoc($resultado)){ 
                                                        $cdni = $fila1['dni'];
                                                        $cexp = $fila1['nro_exp'];
                                                        $cnso = $fila1['nro_spl'];
                                                        $dter = $fila1['meta'];
                                                        $siaf = $fila1['nro_siaf'];
                                             ?>
                                                <tr class="odd gradeA">
                                                    <td><?php echo $cdni; ?></td>
                                                    <td><?php echo $cexp; ?></td>
                                                    <td><b style="color:blue"><?php echo $cnso; ?></b></td>
                                                    <td><?php echo $dter; ?></td>
                                                    <td><?php echo $siaf; ?></td>
                                                </tr>
                                                <?php 
                                                  }
                                                 }
                                                 ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>

</body>

</html>

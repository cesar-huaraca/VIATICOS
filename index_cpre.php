<?php
session_start();
$db="db_viaticos";
$server="localhost";
$db_user="root";
$db_psw="";

$enlace=@mysql_connect($server,$db_user,$db_psw);

if (!$enlace) 
{
    die('No se pudo conectar - Error 1: ' . mysql_error());
}
else 
{
    echo "</br>";

$conn_bd=@mysql_select_db('db_viaticos', $enlace);
if (!$conn_bd)
{
    die("Error 2  : No hay base de DATOS" . mysql_error());
}   
}
// Si hay información para buscar, abrimos la conexión

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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <a class="navbar-brand" href="index_cpre.php">Ministerio de Salud - Sistema de Viáticos</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
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
                        <li>
                            <a href="index_cpre.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Actualizar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="act_cpre.html">Actualizacion</a>
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
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
                    <div class="col-lg-10">
                        <h3 class="page-header">Bienvenidos al Sistema de Viáticos del Ministerio de Salud</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                    <!-- <div class="wizard-header"> -->
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="panel panel-default">
                                    <h3 class="wizard-title"></h3>
                                        Revisión de datos y cerrar Rendición - <B>CONTROL PREVIO.</B><p></p>
                                    <!-- <div class="panel-heading"> -->
                                    <div class="card card-plain">
                                        <div class="card-header" data-background-color="purple">                                                
                                           <align="center"> Nro. de Solicitudes <b>POR RENDIR...</b>
                                        </div>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Término</th>
                                                    <th>DNI</th>
                                                    <th>Expediente</th>
                                                    <th>Solicitud</th>
                                                    <th>Estado</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                mysql_set_charset('utf8');  // mostramos la información en utf-8
                                            
                                            $sql = "SELECT * FROM planilla WHERE estado ='Por Rendir' order by Fec_ter, nro_spl ";

                                            $cexp = "";
                                            $cnso = "";
                                            $dter = "";
                                            $cdni = "";
                                            $dttr = "";


                                            $resultado = @mysql_query($sql,$enlace);
                                            //$result = mysql_query($sql); //Ejecución de la consulta
                                                  if (@mysql_num_rows($resultado) > 0){ 
                                                     // Se recoge el número de resultados
                                                     // Se almacenan las cadenas de resultado
                                                     while($fila1 = @mysql_fetch_assoc($resultado)){ 
                                                        $dttr = $fila1['fec_ter'];
                                                        $cdni = $fila1['dni'];
                                                        $cexp = $fila1['nro_exp'];
                                                        $cnso = $fila1['nro_spl'];
                                                        $dter = $fila1['estado'];
                                             ?>
                                                <tr class="odd gradeA">
                                                    <td><?php echo $dttr; ?></td>
                                                    <td><?php echo $cdni; ?></td>
                                                    <td><?php echo $cexp; ?></td>
                                                    <td><b style="color:blue"><?php echo $cnso; ?></b></td>
                                                    <td><?php echo $dter; ?></td>
                                                    
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
                    <!-- </div> -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

</body>
</html>

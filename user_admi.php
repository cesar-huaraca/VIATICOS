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
}
$conn_bd=@mysql_select_db('db_viaticos', $enlace);
if (!$conn_bd)
{
    die("Error 2  : No hay base de DATOS" . mysql_error());
}   
// Si hay información para buscar, abrimos la conexión
@mysql_set_charset('utf8');  // mostramos la información en utf-8

$busqueda = $_POST['sol'];

if($_POST){
  $busqueda = $_POST['sol'];  
}

 
if (empty($busqueda)){
    $texto = 'Búsqueda sin resultados';
}
else
    {
      
      //Consulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar   '%" .$busqueda. "%' "
      
    $sql = "SELECT a.*, b.* FROM planilla A, personal B WHERE a.dni=b.dni and a.nro_spl = $busqueda LIMIT 1 ";

    $result = mysql_query($sql,$enlace); //Ejecución de la consulta
      //Si hay resultados...
    $row = mysql_fetch_array($result);
    $code = $row['dni'];
    $price = $row['nro_exp'];
    $name = $row['nro_spl'];
    $nomb = $row['ape_nom'];
    $meta = $row['meta'];
    $siaf = $row['nro_siaf'];
    $pago = $row['comprobante'];
    }

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
                <a class="navbar-brand" href="index_admi.php">Ministerio de Salud - Sistema de Viáticos</a>
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
                            <a href="index_cpre.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Actualizar<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="act_admi.html">Actualizacion</a>
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
                    <div class="col-lg-12">
                        <h1 class="page-header">Bienvenidos al Sistema de Viáticos del Ministerio de Salud</h1>

                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="wizard-header">
                        <h3 class="wizard-title"></h3>
                        <p class="category"><B>Opciones para Administrar el sistema.</p></B>
                        <P></P>
                        <p></p>
                        <p></p>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <B> Datos del Comisionado </B>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Documento de Identidad</th>
                                                    <th>Nro Expediente</th>
                                                    <th>Nro Solicitud</th>
                                                    <th>Apellidos y Nombres</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="odd gradeX">
                                                    <td><?php echo $code ?></td>
                                                    <td><?php echo $price ?></td>
                                                    <td><?php echo $name ?></td>
                                                    <td><?php echo $nomb ?></td>
                                                </tr>
                                            </tbody>    
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

 
                        
                       <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <B> RENDICIÓN del Comisionado por item</B>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Solicitud</th>
                                                    <th>Fecha</th>
                                                    <th>Tipo Documento</th>
                                                    <th>Nro. Documento</th>
                                                    <th>Razón Social</th>
                                                    <th>Concepto</th>
                                                    <th>Clasificador</th>
                                                    <th>Importe</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $sql_ren = "SELECT a.*, b.*, sum(a.importe) FROM planilla a, rendiciones b WHERE a.estado='Rendido' and a.nro_spl=b.nro_spl GROUP by a.nro_spl order by a.nro_spl";
                                            $varios = @mysql_query($sql_ren,$enlace); //Ejecución de la consulta
                                            if (@mysql_num_rows($varios) > 0){ 
                                                while($row1 = @mysql_fetch_assoc($varios)){ 
                                                    $code = $row1['nro_spl'];
                                                    $dfec = $row1['fecha'];
                                                    $tdoc = $row1['tipo_doc'];
                                                    $ndoc = $row1['Nro_doc'];
                                                    $razo = $row1['razon'];
                                                    $conc = $row1['concepto'];
                                                    $clas = $row1['clasif'];
                                                    $impo = $row1['importe'];
                                                    $esta = $row1['estado'];
                                                    $impo2 = $row1['sum(importe)'];
                                            ?>

                                            <tr class="odd gradeX">
                                                <td align="center"><?php echo $code ?></td>
                                                <td FONT="ARIAL" SIZE='6'><?php echo $dfec ?></td>
                                                <td align="center"><?php echo $tdoc ?></td>
                                                <td><?php echo $ndoc ?></td>
                                                <td><?php echo $razo ?></td>
                                                <td><?php echo $conc ?></td>
                                                <td><?php echo $clas ?></td>
                                                <td align="right"><?php echo $impo ?></td>
                                                <td><?php echo $esta ?></td>
                                                <td align="right"><?php echo $impo2 ?></td>
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

                     <div class="row">
                            <div class="col-lg-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <B>RENDICIÓN del Comisionado por TOTAL DEL DIA </B>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Importe Total día</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_rd = "SELECT fecha, sum(importe) FROM rendiciones WHERE nro_spl = $busqueda GROUP BY fecha ORDER BY fecha";
                                            $svar = @mysql_query($sql_rd,$enlace); //Ejecución de la consulta
                                            if (@mysql_num_rows($varios) > 0){ 
                                                while($row2 = @mysql_fetch_assoc($svar)){ 
                                                    $dfec1 = $row2['fecha'];
                                                    $impo1 = $row2['sum(importe)'];
                                            ?>

                                            <tr class="odd gradeX">
                                                <td><?php echo $dfec1 ?></td>
                                                <td align="right"><?php echo $impo1 ?></td>
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

                     <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <B>RENDICIÓN del Comisionado por TOTAL DE CLASIFICADOR </B>
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Clasificador</th>
                                                    <th>Importe Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_rd1 = "SELECT clasif, sum(importe) FROM rendiciones WHERE nro_spl = $busqueda GROUP BY clasif ORDER BY clasif";
                                            $svar = @mysql_query($sql_rd1,$enlace); //Ejecución de la consulta
                                            if (@mysql_num_rows($varios) > 0){ 
                                                while($row3 = @mysql_fetch_assoc($svar)){ 
                                                    $dfec2 = $row3['clasif'];
                                                    $impo2 = $row3['sum(importe)'];
                                            ?>

                                            <tr class="odd gradeX">
                                                <td><?php echo $dfec2 ?></td>
                                                <td align="right"><?php echo $impo2 ?></td>
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


         <p></p>
            <div class="col-sm-4 col-sm-offset-1">
                <form role="form" action="vupdate3.php" method="post">
                    <input type="hidden" class="form-control" name="spl" value='<?php echo $busqueda ?>' >
                    <input type="submit" class="btn btn-lg btn-success btn-block" name="rendir" value="Finalizar Rendición">
                </form>
            </div>
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
<?php
session_start();
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
    @mysql_select_db(NAME_DB)
    or die ('NO SE ENCUENTRA LA BASE DE DATOS ' . NAME_DB);
}
function desconectar(){
    global $conexion;
    mysql_close($conexion);
}


conectar();
// Si hay información para buscar, abrimos la conexión
mysql_set_charset('utf8');  // mostramos la información en utf-8
//Variable que contendrá el resultado de la búsqueda
$texto = '';
//Variable que contendrá el número de resgistros encontrados
$registros = '';

$busqueda=$_SESSION['dni'];


if($_POST){   
  $busqueda = $_POST['dni'];
  $_SESSION['dni'] = $busqueda;
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

    <style type="text/css">
        
        .cabecera{
            background-color: #888;
            color: #fff;
            font-family: arial;
            font-size: 14px;
            font-weight: bolder;
        }
        .data{
            color: 000;
            font-family: arial;
            font-size: 12px;
            font-weight: bolder;
            background-color: #e9e9e9;

        }
    </style>

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
                <a class="navbar-brand" href="index.html">Ministerio de Salud - Sistema de Viáticos</a>
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
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
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
                            <a href="lista_sol.php"><i class="fa fa-edit fa-fw"></i> Lista de Solicitud</a>
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
                        
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="wizard-header">
                        <h3 class="wizard-title">Lista de Solicitudes</h3>
                    </div>
                    <table width="100%" cellspacing="5" cellpadding="5">
                        <tr>
                            <td class="cabecera">Nro. Sol.</td>
                            <td class="cabecera">Motivo</td>
                            <td class="cabecera">Ciudad de Inicio</td>
                            <td class="cabecera">Ciudad de Destino</td>
                            <td class="cabecera">Fecha de Inicio</td>
                            <td class="cabecera">Fecha de Fin</td>
                            <td class="cabecera">Editar</td>
                        </tr>
                        
                            
                        

<?php 
$sql = "SELECT dni,nro_exp,fec_emi,nro_spl,nro_siaf,des_iti,motivo,dpto_1,prov_1,dist_1,dpto_2,prov_2,dist_2,fec_ini,fec_ter,nro_dia,nro_hor,hor_ini,hor_ter,meta,mon_pas,mon_via,medio,observacion,estado,comprobante FROM planilla WHERE estado = 'Por Rendir' ORDER BY nro_spl DESC ";

$result = mysql_query($sql); //Ejecución de la consulta
      if (mysql_num_rows($result) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila = mysql_fetch_assoc($result)){ 
            
            $dni= $fila['dni'];
            $nro_exp= $fila['nro_exp'];
            $fec_emi= $fila['fec_emi'];
            $nro_spl= $fila['nro_spl'];
            $nro_siaf= $fila['nro_siaf'];
            $des_iti= $fila['des_iti'];
            $motivo= $fila['motivo'];
            $dpto_1= $fila['dpto_1'];
            $prov_1= $fila['prov_1'];
            $dist_1= $fila['dist_1'];
            $dpto_2= $fila['dpto_2'];
            $prov_2= $fila['prov_2'];
            $dist_2= $fila['dist_2'];
            $fec_ini= $fila['fec_ini'];
            $fec_ter= $fila['fec_ter'];
            $nro_dia= $fila['nro_dia'];
            $nro_hor= $fila['nro_hor'];
            $hor_ini= $fila['hor_ini'];
            $hor_ter= $fila['hor_ter'];
            $meta= $fila['meta'];
            $mon_pas= $fila['mon_pas'];
            $mon_via= $fila['mon_via'];
            $medio= $fila['medio'];
            $observacion= $fila['observacion'];
            $estado= $fila['estado'];
            $comprobante= $fila['comprobante'];
           
         
 ?>
                        <tr>
                        <td class="data"><?php echo $nro_spl; ?></td>
                        <td class="data"><?php echo $motivo; ?></td>
                        <td class="data"><?php echo $dpto_1.' - '.$prov_1.' - '.$dist_1; ?></td>
                        <td class="data"><?php echo $dpto_2.' - '.$prov_2.' - '.$dist_2; ?></td>
                        <td class="data"><?php echo $fec_ini.' '.$hor_ini; ?></td>
                        <td class="data"><?php echo $fec_ter.' '.$hor_ter; ?></td>
                        <td class="data"><img src="img/edit.png" onclick="editar('<?php echo $nro_spl; ?>')"></td>
                        </tr>
 <?php 
}
     }
  ?>
                    
                    </table>
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


<script type="text/javascript">
function editar(nro){

   
    window.open('editar_sol.php?id='+nro, "mywindow", "location=1,status=1,scrollbars=1,  width=795,height=950");

}
   
</script>


</body>
</html>
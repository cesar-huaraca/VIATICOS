<?php

session_start([
	'cookie_lifetime' => 86400,
	'read_and_close' => true,
	]);
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
    @mysql_close($conexion);
}
$nrosol = trim($_REQUEST['sol']);
//Variable que contendrá el resultado de la búsqueda
$texto = '';
//Variable que contendrá el número de resgistros encontrados
$registros = '';
$sol='';

if($_POST){
    $busqueda = trim($_POST['sol']);
    $entero = 0;
    $_SESSION['sol'] = $_POST['sol'];
    $c_dni = isset($_SESSION['dni']);
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

    <style type="text/css">
        .tabla{
            width: 100%;
            border: 1px solid #000;
            background-color: #eee;
        }
    </style>

    <script languaje=javascript type=text/javascript>
    function pulsar(e){
    	tecla = (document.all) ? e.keyCode :e.which;
    	return (tecla!=13);
    }	
    </script>
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
                            <a href="user_01.html"><i class="fa fa-table fa-fw"></i> Nueva Solicitud</a>
                        </li>
                        <li>
                            <a href="user_01.html"><i class="fa fa-table fa-fw"></i> Lista de Solicitudes</a>
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
                        Rendición de Cuentas por Comisión de Servicios (Anexo 04)
                        <P></P>
                        <?php
						// Resultado, número de registros y contenido.
						//echo $registros;
						//echo $texto; 
						?>
                        <span style="color: red;">* Recuerda Verificar Los Datos antes de Guardar</span>
                    </div>
                </div>
                <!-- /.row -->
                <label><?php 
                //echo $_SESSION['sol']; 
                //echo $_SESSION['dni']; 
                //echo $_SESSION['ape_nom']; 
                ?> </label>
                <!-- <p class="btn btn-simple btn-primary btn-lg"><b>Recuerda registrar bien los items antes de grabar...</b></p><P>.<P>. -->
               
                               
                        <table width="100%" cellspacing="5" cellpadding="5">
                                <tr>
                                    <td>
                                        <label>Fecha</label>
                                        <input class="form-control" placeholder="Fecha" name="fec" id="fec" type="date" onkeypress="return pulsar(event)" autofocus>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <label>Concepto</label>
                                        <select class="form-control" name="concepto" id="concepto">
                                        <option value="">- Concepto -</option>
                                        <option value='Alimentacion'>Alimentacion</option>
                                        <option value='Movilidad'>Movilidad Local</option>
                                    </select> 
                                    </td>
                                
                                <tr>
                                    <td>
                                        <label>Tipo de Clasificador de Gasto</label>
                                        <input type="text" disabled="disabled" class="form-control" name="v_tipo" id="v_tipo">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <label>Importe S/.</label>
                                        <input class="form-control" placeholder="Importe" name="importe" id="importe" type="text" onkeypress="return pulsar(event)">
                                        <input type="hidden" name="nro" id="nro" value='<?php echo $_SESSION['sol']; ?>' >
                                        <input type="hidden" name="opcion" id="opcion" value='grabar' >

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label>Observacion</label>
                                        <input type="text" class="form-control" name="observacion" id="observacion">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    <center>
                                    <button class="btn btn-finish btn-fill btn-success btn-wd" id="grabar">Grabar Item</button> 
                                    <a href="formatodj.php?sol=<?php echo $_SESSION['sol']; ?>" target="_blank" class="btn btn-finish btn-fill btn-success btn-wd">IMPRIMIR DECLARACION JURADA</a>   
                                    </center>
                                    
                                    <td>
                                </tr>
                        </table>
                    <br>
                    <br>
                    <br>
                <div id="tabla" class="tabla"></div>             
               
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
    
$("#grabar").click(function(){
    var fec= $('#fec').val();
    var concepto= $('#concepto').val();
    var v_tipo= $('#v_tipo').val();
    var importe= $('#importe').val();
    var nro= $('#nro').val();
    var opcion= $('#opcion').val();

        $.ajax({
             type: "POST",
                url: "graba_dj.php",
                data: 
                {
                "fec": fec,
                "concepto": concepto,
                "v_tipo": v_tipo,
                "importe": importe,
                "nro": nro,
                "opcion": opcion,
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){                                                    
                        $('#fec').val('');
                        $('#concepto').val('');
                        $('#v_tipo').val('');
                        $('#importe').val('');
                        
                  }
              });
  });

function actualiza(){
    $("#tabla").load("tab_dj.php?sol=<?php echo $nrosol ?>");
  }
setInterval( "actualiza()", 1000 );

$("#concepto").change(function(){
    var con=$("#concepto").val();

    if (con=="Movilidad") {
        $("#v_tipo").val('2.3.2.1.2.1');
    }
    else if (con=="Alimentacion") {
        $("#v_tipo").val('2.3.2.1.2.2');
    }
    else if (con=="") {
        $("#v_tipo").val('- Escoja un Concepto -');
    }
});
</script>


</script>

</body>

</html>

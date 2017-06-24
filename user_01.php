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
$sql = "SELECT * FROM personal WHERE dni = '$busqueda' ";

$result = mysql_query($sql); //Ejecución de la consulta
      if (mysql_num_rows($result) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila = mysql_fetch_assoc($result)){ 
            //$texto .= $fila['dni'] . '<br />';
            $can = $fila['ape_nom'];
            $dni1 = $fila['dni'];
            $_SESSION['ape_nom'] = $can;     
            $_SESSION['dni'] = $dni1; 
         }
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
                        <h1 class="page-header">Generación de la Solicitud - Planilla - Retención</h1>

                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="wizard-header">
                        <h3 class="wizard-title">INGRESA TUS DATOS</h3>
                        <p class="category">Esta información ayudará a crear los formatos de Solicitud, Planilla y Retención.</p>
                        <p class="btn btn-simple btn-primary btn-lg"><b>Recuerda revisar bien los datos suministrados antes de grabar...</b></p><P>.<P>.
                    </div>
                    <form action="insertarv.php" method="post">
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>COMISIONADO : </label>
                                <label><?php echo strtoupper($_SESSION['ape_nom']); echo ' - Dni : '. $dni1; ?></label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>Nro. Expediente</label>
                                <input type="text" class="form-control" id="InputExp" placeholder="Ingrese expediente...  12-123456-123 " name="nroexp">
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>Destino - Itinerario</label>
                                <input type="text" class="form-control" id="destino" placeholder="Lima - ..... - Lima " name="itinerario">
                            </div>
                            <div class="form-group">
                                <label>Motivo del viaje</label>
                                <input type="text" class="form-control" id="motivo" placeholder=" " name="motivo">
                            </div>     
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Fecha Inicio<small> (requerido)</small></label>
                                <input name="Fecha_I" type="date" required class="form-control" placeholder="dd/mm/yy">
                                <label>Fecha Termino<small> (requerido)</small></label>
                                <input name="Fecha_T" type="date" required class="form-control" placeholder="dd/mm/yy">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Hora Inicio<small> (requerido)</small></label>
                                <input name="Hora_I" type="time" required class="form-control" placeholder="hh:mm...">
                                <label>Hora Termino<small> (requerido)</small></label>
                                <input name="Hora_T" type="time" required class="form-control" placeholder="hh:mm...">
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Medio Transporte</label>
                                <select class="form-control" name="medio">
                                    <option disabled="" selected="">- Medio -</option>
                                    <option>Terrestre</option>
                                    <option>Aereo</option>
                                    <option>Otros</option>
                                    <option>Ninguno</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-sm-offset-1"">
                            <div class="form-group">
                                <label></label>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Departamento" name="dpt1">  -->
                                <div class="col-sm-6 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>DESDE</label>
                                        <select class="form-control" name="dpt1" id="dpt1">
                                            <option disabled="" selected="">- Departamento -</option>
<?php 
    $sql12 = "SELECT * FROM ubdepartamento";

$result12 = mysql_query($sql12); 
      if (mysql_num_rows($result12) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila12 = mysql_fetch_assoc($result12)){
            $iddepa = $fila12['idDepa'];
            $depar= $fila12['departamento'];

 ?>
        <option value="<?php echo $iddepa ?>"><?php echo $depar; ?></option>

<?php }} ?>



                                        </select>
                                    </div>
                                </div>
                                 <select class="form-control" name="prov1" id="prov1">
                                     <option value="">--PROVINCIA--</option>
                                 </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Provincia" name="prov1"> -->
                                <p></p>
                                <select class="form-control" name="dist1" id="dist1">
                                    <option value="">--DISTRITO--</option>
                                </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Distrito" name="dist1"> -->
                                <label></label><p></p>
                               <div class="col-sm-6 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>HASTA</label>
                                        <select class="form-control" name="dpt2" id="dpt2">
                                            <option disabled="" selected="">- Departamento -</option>
<?php 
    $sql13 = "SELECT * FROM ubdepartamento";

$result13 = mysql_query($sql13); 
      if (mysql_num_rows($result13) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila13 = mysql_fetch_assoc($result13)){
            $iddepa1 = $fila13['idDepa'];
            $depar1= $fila13['departamento'];

 ?>
        <option value="<?php echo $iddepa1; ?>"><?php echo $depar1; ?></option>

<?php }} ?>

                                        </select>
                                    </div>
                                </div>
                                <select class="form-control" name="prov2" id="prov2">
                                    <option value="">--PROVINCIA--</option>
                                </select>

                                <!-- <input type="text" class="form-control" id="moti" placeholder="Provincia" name="prov2"> -->

                                <p></p>
                                <select class="form-control" name="dist2" id="dist2">
                                    <option value="">--DISTRITO--</option>
                                </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Distrito" name="dist2"> -->
                            </div>
                        </div>               
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Costo Pasajes - Clasificador 2.3.2.1.2.1</label>
                                <input type="text" class="form-control" id="pasaje" placeholder="0.00" name="pasajes">
                                <input type="hidden"  id="dni1" name="dni1" value="<?php echo $dni1; ?>">
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Meta</label>
                                <input type="text" class="form-control" id="meta" placeholder="Formato : 0000" name="meta">
                            </div>
                        </div>                        
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Grabar '/>
                            </div>
                        </div>
                    </form>   <!-- Fin del FORM -->
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
    
$("#dpt1").change(function(){

    var iddepa=$("#dpt1").val();

        $.ajax({
             type: "POST",
                url: "proceso.php",
                data: 
                {
                "id": iddepa,
                "opcion": 'provincia',
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){
                       $("#prov1").html(data);
                  }
              });

})

$("#prov1").change(function(){

    var iddepa=$("#prov1").val();

        $.ajax({
             type: "POST",
                url: "proceso.php",
                data: 
                {
                "id": iddepa,
                "opcion": 'distrito',
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){
                       $("#dist1").html(data);
                  }
              });

})
   

$("#dpt2").change(function(){

    var iddepa=$("#dpt2").val();

        $.ajax({
             type: "POST",
                url: "proceso.php",
                data: 
                {
                "id": iddepa,
                "opcion": 'provincia',
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){
                       $("#prov2").html(data);
                  }
              });

})

$("#prov2").change(function(){

    var iddepa=$("#prov2").val();

        $.ajax({
             type: "POST",
                url: "proceso.php",
                data: 
                {
                "id": iddepa,
                "opcion": 'distrito',
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){
                       $("#dist2").html(data);
                  }
              });

})
   
</script>


</body>
</html>
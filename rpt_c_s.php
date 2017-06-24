<?php
// Primero definimos la conexión a la base de datos
define('HOST_DB', 'localhost');  //Nombre del host, nomalmente localhost
define('USER_DB', 'root');       //Usuario de la bbdd
define('PASS_DB', '');           //Contraseña de la bbdd
define('NAME_DB', 'db_viaticos'); //Nombre de la bbdd

// Definimos la conexión
function conectar(){
    global $conexion;  //Definición global para poder utilizar en todo el contexto
    $conexion = mysql_connect(HOST_DB, USER_DB, PASS_DB)
    or die ('NO SE HA PODIDO CONECTAR AL MOTOR DE LA BASE DE DATOS');
    mysql_select_db(NAME_DB)
    or die ('NO SE ENCUENTRA LA BASE DE DATOS ' . NAME_DB);
}
function desconectar(){
    global $conexion;
    mysql_close($conexion);
}

//Variable que contendrá el resultado de la búsqueda
$texto = '';
//Variable que contendrá el número de resgistros encontrados
$registros = '';

if($_POST){
    
  $busqueda = trim($_POST['buscar']);
    //$busqueda = trim($_GET['buscar']);
  

  $entero = 0;
  
  if (empty($busqueda)){
      $texto = 'Búsqueda sin resultados';
  }else{
      // Si hay información para buscar, abrimos la conexión
      conectar();
      mysql_set_charset('utf8');  // mostramos la información en utf-8
      
      //Contulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar
      
      //$sql = "SELECT * FROM planilla WHERE nro_spl LIKE '%" .$busqueda. "%' ORDER BY nro_spl";
      
      $sql = "SELECT A.*, B.ape_nom, B.con_lab, B.uni_org, B.banco, B.nro_cta, B.email, B.cargo FROM planilla A, personal B WHERE A.dni=B.dni and nro_spl LIKE '%" .$busqueda. "%' ";

      $resultado = mysql_query($sql); //Ejecución de la consulta
      //Si hay resultados...
      if (mysql_num_rows($resultado) > 0){ 
         // Se recoge el número de resultados
         //$registros = '<p>Se ubicó ' . mysql_num_rows($resultado) . ' registros con lo solicitado</p>';
         // Se almacenan las cadenas de resultado
         while($fila = mysql_fetch_assoc($resultado)){ 
            //$texto .= $fila['dni'] . '<br />';

            $texto .= '
            <p>


            <table class="table">
                <thead class="text-primary">
                <th>  </th>
                <th>  </th>
                </thead>
                <tbody>
                    <tr>
                        <td> 
                        <img src="img/logo.jpg"
                        </td>
                        <td> 
                        Fecha: <script>DameLaFecha()</script><br>
                        Hora: <script>DameLaHora()</script><br>
                        </td>
                    </tr>                                        
                </tbody>
            </table>    

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <center><u><strong><h2 class="title">SOLICITUD DE COMISION DE SERVICIOS</h2></strong></u></center>
                        <center><p class="category">(Anexo N° 1)</p></center>
                    </div>
            <div class="card-content table-responsive">

            <table class="table">
                <thead class="text-primary">
                <th>  </th>
                <th>  </th>
                </thead>
                <tbody>
                    <tr>
                        <td> <strong> NRO. EXPEDIENTE : </strong> </td>
                        <td> ' . $fila['nro_exp'] . ' </td>
                    </tr>
                    <tr>
                        <td> <strong> NRO. SOLICITUD : </strong> </td>
                        <td> ' . $fila['nro_spl'] . ' </td>
                    </tr>                        
 
                </tbody>
            </table>    
</div>
</div>
</div>
</div>
</div>
</div>




<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                                    <u><strong><h4 class="title">DATOS DEL COMISIONADO</h4></strong></u>
                                    <p class="category"></p>
                    </div>
            <div class="card-content table-responsive">

            <table class="table">
                <thead class="text-primary">
                <th>  </th>
                <th>  </th>
                </thead>
                <tbody>
                    <tr>
                        <td> <strong> NOMBRES Y APELLIDOS : </strong> </td>
                        <td> ' . $fila['ape_nom'] . ' </td>
                    </tr>
                    <tr>
                        <td> <strong> DNI : </strong> </td>
                        <td> ' . $fila['dni'] . ' </td>
                    </tr>                        
                    <tr>
                        <td> <strong> CARGO : </strong> </td>
                        <td> ' . $fila['cargo'] . ' </td>
                    </tr>                                            
                    <tr>
                        <td> <strong> CONDICION LABORAL : </strong> </td>
                        <td> ' . $fila['con_lab'] . ' </td>
                    </tr>                     
                    <tr>
                        <td> <strong> UNIDAD ORGANICA : </strong> </td>
                        <td> ' . $fila['uni_org'] . ' </td>
                    </tr>
                    <tr>
                        <td> <strong> DESTINO - ITINERARIO: </strong> </td>
                        <td> ' . $fila['des_iti'] . ' </td>
                    </tr>                                                     
                </tbody>
            </table>    
</div>
</div>
</div>
</div>
</div>
</div>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                                    <u><strong><h4 class="title">FECHA COMISION</h4></strong></u>
                                    <p class="category"></p>
                    </div>
            <div class="card-content table-responsive">

            <table class="table">
                <thead class="text-primary">
                <th>  </th>
                <th>  </th>
                </thead>
                <tbody>
                    <tr>
                        <td> <strong> FECHA INICIO : </strong> 
                         ' . $fila['fec_ini'] . ' </td>
                        <td> <strong> FECHA TERMINO : </strong> 
                         ' . $fila['fec_ter'] . ' </td>
                    </tr>                    
                    <tr>
                        <td> <strong> HORA INICIO : </strong> 
                         ' . $fila['hor_ini'] . ' </td>
                        <td> <strong> HORA TERMINO : </strong> 
                         ' . $fila['hor_ter'] . ' </td>
                    </tr>                                                            
                    <tr>
                        <td> <strong> TIPO DE TRANSPORTE : </strong> 
                         ' . $fila['medio'] . ' </td>
                        <td> <strong> MOTIVO DE VIAJE : </strong> 
                         ' . $fila['motivo'] . ' </td>
                    </tr>                                                                                
                </tbody>
            </table>    
</div>
</div>
</div>
</div>
</div>
</div>

            <i>La rendición de viáticos al interior del país se efectúa de los <strong>diez (10) días hábiles de culminada la comisión de servicios</strong>; de conformidad a lo establecido en el <br> 
            Decreto Supremo N° 007-2013-EF; y la rendición de viáticos al Exterior del país se efectúa dentro de los <strong>quince (15) días calendario de culminada la comisión de<br>
            servicios</strong>; de conformidad a lo establecido en la Ley N° 27619, ley que regula la autorización de viajes al exterior de servidores y funcionarios públicos.<br><br>
             Si vencido dicho plazo incumpliera con la norma precisada, el que suscribe, será posible de medidas disciplinarias aplicables de acuerdo a lo establecido en la<br>
             Normatividad vigente.
            </i>
            </p><p>.</p>
            <p>.</p>
            <p>.</p>
            


            <table class="table">
                <thead class="text-primary">
                <th>  </th>
                <th>  </th>
                </thead>
                <tbody>
                    <tr>
                        <td>  ___________________________________<br>
                          Firma del Comisionado
                        </td>
                    
                    
                        <td>  ___________________________________<br>
                          Firma del Jefe de Area
                        </td>
                    </tr>                                        
                </tbody>
            </table>    


            ';

             }
      
      }else{
               $texto = "NO HAY RESULTADOS EN LA BBDD"; 
      }
      // Cerramos la conexión (por seguridad, no dejar conexiones abiertas)
      mysql_close($conexion);
  }
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head> 
<meta charset='utf-8'>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Viaticos - MINSA</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

<script Language="JavaScript"> 
function DameLaFecha() { 
    var hora = new Date() 
    var hrs = hora.getHours(); 
    var min = hora.getMinutes(); 
    var hoy = new Date(); 
    var m = new Array(); 
    var d = new Array() 
    var an= hoy.getYear(); 
    m[0]="Enero"; m[1]="Febrero"; m[2]="Marzo"; 
    m[3]="Abril"; m[4]="Mayo"; m[5]="Junio"; 
    m[6]="Julio"; m[7]="Agosto"; m[8]="Septiembre"; 
    m[9]="Octubre"; m[10]="Noviembre"; m[11]="Diciembre"; 
    document.write(hoy.getDate() +" "); 
    document.write(m[hoy.getMonth()]);
    document.write(an.getYear()); 
} 
</script>

<Script Language="JavaScript"> 
function DameLaHora() { 
var hora = new Date() 
var hrs = hora.getHours(); 
var min = hora.getMinutes(); 
var hoy = new Date(); 
document.write(hrs+":"+min); 
} 
</Script>


</head> 
<body>
<!-- <h1> <a href="" title="" target="_self"></a></h1>  -->
<form id="buscador" name="buscador" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
    <input id="buscar" name="buscar" type="search" placeholder="Buscar aquí..." autofocus >
    <input type="submit" name="buscador" class="boton peque aceptar" value="buscar">
</form>
<?php 
// Resultado, número de registros y contenido.
echo $registros;
echo $texto; 
?>
</body>
    <!--   Core JS Files   -->
    <script src="assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/material.min.js" type="text/javascript"></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Material Dashboard javascript methods -->
    <script src="assets/js/material-dashboard.js"></script>

    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>
</html>
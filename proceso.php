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

mysql_set_charset('utf8');  

$opcion=$_REQUEST['opcion'];


switch ($opcion) {
    case 'provincia':

        $html='<option value="">--PROVINCIA--</option>';
        $idDepa=$_REQUEST['id'];
        $sql = "SELECT idProv,provincia FROM ubprovincia where idDepa=".$idDepa;
        $result = mysql_query($sql); 
        if (mysql_num_rows($result) > 0){ 
        while($fila = mysql_fetch_assoc($result)){ 
            $idProv = $fila['idProv'];
            $provincia = $fila['provincia'];
            $html.='<option value="'.$idProv.'">'.$provincia.'</option>';
            }
        }
        echo $html;
        break;
    case 'distrito':

        $html='<option value="">--DISTRITO--</option>';
        $idProv=$_REQUEST['id'];
        $sql = "SELECT idDist,distrito FROM ubdistrito where idProv=".$idProv;
        $result = mysql_query($sql); 
        if (mysql_num_rows($result) > 0){ 
        while($fila = mysql_fetch_assoc($result)){ 
            $idDist = $fila['idDist'];
            $distrito = $fila['distrito'];
            $html.='<option value="'.$idDist.'">'.$distrito.'</option>';
            }
        }
        echo $html;
        break;
    default:
      
        break;
}




?>


<?php
	
$c_1= $_POST['dni'];
$c_2= $_POST['meta'];
$c_3= $_POST['siaf'];
$c_4= $_POST['spl'];

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
     
      //Consulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar   '%" .$busqueda. "%' "

	@mysql_query("SET NAMES 'utf8'");      
    $sql = "UPDATE planilla 
    		SET meta = '$c_2', 
    			nro_siaf = '$c_3'
    		WHERE nro_spl = '$c_4' ";

    $resultado = @mysql_query($sql,$enlace); //Ejecución de la consulta
    require('index_ppto.php');
?>
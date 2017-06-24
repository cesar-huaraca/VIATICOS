<?php

session_start();

$db="db_viaticos";
$server="localhost";
$db_user="root";
$db_psw="";

$enlace=mysql_connect($server,$db_user,$db_psw);

if (!$enlace) 
{
    die('No se pudo conectar - Error 1: ' . mysql_error());
}
else 
{
	echo "</br>";

$conn_bd=mysql_select_db('db_viaticos', $enlace);
if (!$conn_bd)
{
	die("Error 2  : No hay base de DATOS" . mysql_error());
}	


// Recibo los POST y elimino las etiquetas que puedan existir
	//$c_spl	= $_POST['nro'];
	$fecha= $_POST['fec'];
	$tipo	= $_POST['tdoc'];
	$ndoc	= $_POST['ndoc'];
	$c_raz	= $_POST['razsoc'];
	$conce	= $_POST['concepto'];
	$c_cla	= $_POST['v_tipo'];
	$import	= $_POST['importe'];
	$c_acci = "";
	$c_spl = $_SESSION['nrosol'];

session_write_close();
//

// Grabación en la tabla planilla

	@mysql_query("SET NAMES 'utf8'");
	
	$_grabar_sql = "INSERT INTO rendiciones (nro_spl, fecha, tipo_doc, Nro_doc, razon, concepto, clasif, importe, acciones ) VALUES 
	('$c_spl', '$fecha', '$tipo', '$ndoc', '$c_raz', '$conce', '$c_cla', '$import','$c_acci' )"; 

	mysql_query($_grabar_sql,$enlace);

	echo mysql_error();
	print '<script language="JavaScript">';
	print 'alert("Item Grabado...");';
	print '</script>';

	require("ren_user.php");
}
?>
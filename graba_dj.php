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

$opcion= $_REQUEST['opcion'];

switch ($opcion) {
	case 'grabar':
		$fec= $_REQUEST['fec'];
		$concepto= $_REQUEST['concepto'];
		$v_tipo= $_REQUEST['v_tipo'];
		$importe= $_REQUEST['importe'];
		$nro= $_REQUEST['nro'];

		@mysql_query("SET NAMES 'utf8'");
		$_grabar_sql = "INSERT INTO decjurada (nro_spl, fecha, concepto, clasif, importe, acciones ) VALUES 
		('".$nro."', '".$fec."','".$concepto."', '".$v_tipo."', '".$importe."','".$nro."' )"; 
		mysql_query($_grabar_sql,$enlace);
		echo mysql_error();

	break;
	case 'elimina':
		$id= $_REQUEST['id'];

		@mysql_query("SET NAMES 'utf8'");
		$_grabar_sql = "DELETE FROM decjurada WHERE id_dj=".$id; 
		mysql_query($_grabar_sql,$enlace);
		echo mysql_error();
	break;

	case 'listar':

		$id= $_REQUEST['id'];

		@mysql_query("SET NAMES 'utf8'");
		$_grabar_sql = "SELECT * FROM decjurada where id_dj=".$id;
		$resultado = @mysql_query($_grabar_sql,$enlace); //Ejecución de la consulta
      //Si hay resultados...

      if (@mysql_num_rows($resultado) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila = @mysql_fetch_assoc($resultado)){ 
          $nro_spl=$fila['nro_spl'];
          $fecha=$fila['fecha'];
          $concepto=$fila['concepto'];
          $clasif=$fila['clasif'];
          $importe=$fila['importe'];
          $acciones=$fila['acciones'];
          $observacion=$fila['observacion'];
          $id_rendicion=$fila['id_rendicion'];
      }}

		echo $nro_spl."|".$fecha."|".$tipo_doc."|".$Nro_doc."|".$razon."|".$concepto."|".$clasif."|".$importe;
		
	break;
	default:
		# code...
	break;
}

	
		
}
?>
<?php

$dni="";
$nroexp="";
$citin="";
$db="db_viaticos";
$server="localhost";
$db_user="root";
$db_psw="";
$totald=0;
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
	//pagina 1
	$id	= $_POST['id'];
	$c_dni	= $_POST['dni1'];
	$nro_exp= $_POST['nroexp'];

	//pagina 2
	$c_itin	= $_POST['itinerario'];
	$c_moti	= $_POST['motivo'];
	//pagina 3
	$d_fi	= $_POST['Fecha_I'];
	$d_ft	= $_POST['Fecha_T'];
	$c_hi	= $_POST['Hora_I'];
	$c_ht	= $_POST['Hora_T'];
	$c_medio= $_POST['medio'];
	//pagina 4
	$c_dpto1= $_POST['dpt1'];
	$c_prov1= $_POST['prov1'];
	$c_dist1= $_POST['dist1'];
	$c_dpto2= $_POST['dpt2'];
	$c_prov2= $_POST['prov2'];
	$c_dist2= $_POST['dist2'];
	$n_mopas= $_POST['pasajes'];
	$n_meta = $_POST['meta'];

	mysql_set_charset('utf8');  // mostramos la información en utf-8

	$sdpto1 = "SELECT idDepa,departamento FROM ubdepartamento where idDepa='".$c_dpto1."'"; 
	$rdpto1 = mysql_query($sdpto1);
	if (mysql_num_rows($rdpto1) > 0){ 
         while($fdpto1 = mysql_fetch_assoc($rdpto1)){ 
         	$c_dpto1 = $fdpto1['departamento'];
         }
     }
    $sdpto2 = "SELECT idDepa,departamento FROM ubdepartamento where idDepa='".$c_dpto2."'"; 
	$rdpto2 = mysql_query($sdpto2);
	if (mysql_num_rows($rdpto2) > 0){ 
         while($fdpto2 = mysql_fetch_assoc($rdpto2)){ 
         	$c_dpto2 = $fdpto2['departamento'];
         }
     }
    $sprov1 = "SELECT idProv,provincia FROM ubprovincia where idProv='".$c_prov1."'"; 
	$rprov1 = mysql_query($sprov1);
	if (mysql_num_rows($rprov1) > 0){ 
         while($fprov1 = mysql_fetch_assoc($rprov1)){ 
         	$c_prov1 = $fprov1['provincia'];
         }
     }
    $sprov2 = "SELECT idProv,provincia FROM ubprovincia where idProv='".$c_prov2."'"; 
	$rprov2 = mysql_query($sprov2);
	if (mysql_num_rows($rprov2) > 0){ 
         while($fprov2 = mysql_fetch_assoc($rprov2)){ 
         	$c_prov2 = $fprov2['provincia'];
         }
     }
    $sdist1 = "SELECT idDist,distrito FROM ubdistrito where idDist='".$c_dist1."'"; 
	$rdist1 = mysql_query($sdist1);
	if (mysql_num_rows($rdist1) > 0){ 
         while($fdist1 = mysql_fetch_assoc($rdist1)){ 
         	$c_dist1 = $fdist1['distrito'];
         }
     }
     $sdist2 = "SELECT idDist,distrito FROM ubdistrito where idDist='".$c_dist2."'"; 
	$rdist2 = mysql_query($sdist2);
	if (mysql_num_rows($rdist2) > 0){ 
         while($fdist2 = mysql_fetch_assoc($rdist2)){ 
         	$c_dist2 = $fdist2['distrito'];
         }
     }
          
      $sqlcc = "select hour(TIMEDIFF(cast(concat('".$d_fi."',' ','".$c_hi."') as datetime),cast(concat('".$d_ft."',' ','".$c_ht."') as datetime))) horas";

      $resultadocc = mysql_query($sqlcc); //Ejecución de la consulta

      if (mysql_num_rows($resultadocc) > 0){ 
         // Se almacenan las cadenas de resultado
         while($filacc = mysql_fetch_assoc($resultadocc)){ 
         	$ho = $filacc['horas'];
         }
     }
	$d=intval($ho/24);
	$h=$ho%24;

	if ($h<4) {
		$d1=$d;
	}
	elseif ($h>4) {
		$d1=$d+1;
	}

	$d_fec_emi=date('Y-m-d');

      mysql_set_charset('utf8');  // mostramos la información en utf-8
          
      $sql = "SELECT * FROM personal B WHERE dni = $c_dni ";

      $resultado = mysql_query($sql); //Ejecución de la consulta

      if (mysql_num_rows($resultado) > 0){ 
         while($fila = mysql_fetch_assoc($resultado)){ 
         	$clab = $fila['con_lab'];
         }
     }
     if ($clab = 'CAS') {
     	      $sql1 = "SELECT * FROM destinos WHERE destino LIKE '$c_dpto2' ";

		      $result = @mysql_query($sql1); //Ejecución de la consulta

		      if (@mysql_num_rows($result) > 0){ 
		         while($fila1 = mysql_fetch_assoc($result)){
			     		$nvtrab	= $fila1['v_trab'];
			     		$totald = $d1* $nvtrab ;
		     		}		     
     		}
     }	
     else {
     		$sql1 = "SELECT * FROM destinos WHERE destino LIKE '$c_dpto2' ";

		      $result = @mysql_query($sql1); //Ejecución de la consulta
		      //Si hay resultados...

		      if (@mysql_num_rows($result) > 0){ 
		         while($fila1 = mysql_fetch_assoc($result)){
			     		$nvtrab	= $fila1['v_fun'];
			     		$totald = $d1* $nvtrab ;
		     		}		     
     		}
     	}	

	@mysql_query("SET NAMES 'utf8'");
	
	$_grabar_sql = "

	UPDATE planilla SET dni='$c_dni',fec_emi='$d_fec_emi',nro_exp='$nro_exp',des_iti='$c_itin',motivo='$c_moti',fec_ini='$d_fi',fec_ter='$d_ft',hor_ini='$c_hi',hor_ter='$c_ht',medio='$c_medio',	dpto_1='$c_dpto1',prov_1='$c_prov1',dist_1='$c_dist1',dpto_2='$c_dpto2',prov_2='$c_prov2',dist_2='$c_dist2',mon_pas='$n_mopas',nro_dia='$d',nro_hor='$ho',estado='Por Rendir',mon_via='$totald',	meta='$n_meta'WHERE nro_spl=".$id; 

	mysql_query($_grabar_sql,$enlace);
	
}
?>

<html>
<head>
	<title></title>
</head>
<body>
<center>
	<h1 style="color:blue;">EL REGISTRO SE ACTUALIZO CORRECTAMENTE</h1>
</center>

<script type="text/javascript">
	window.close();
</script>
</body>
</html>








































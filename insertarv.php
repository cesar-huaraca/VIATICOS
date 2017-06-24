
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


// Recibo los POST y elimino las etiquetas que puedan existir
	//pagina 1
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
      //Si hay resultados...

      if (mysql_num_rows($resultadocc) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($filacc = mysql_fetch_assoc($resultadocc)){ 
            //$texto .= $fila['dni'] . '<br />';
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

//
      mysql_set_charset('utf8');  // mostramos la información en utf-8
          
      $sql = "SELECT * FROM personal B WHERE dni = $c_dni ";

      $resultado = mysql_query($sql); //Ejecución de la consulta
      //Si hay resultados...

      if (mysql_num_rows($resultado) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila = mysql_fetch_assoc($resultado)){ 
            //$texto .= $fila['dni'] . '<br />';
         	$clab = $fila['con_lab'];
         }
     }
     if ($clab = 'CAS') {
     	      $sql1 = "SELECT * FROM destinos WHERE destino LIKE '$c_dpto2' ";

		      $result = @mysql_query($sql1); //Ejecución de la consulta
		      //Si hay resultados...

		      if (@mysql_num_rows($result) > 0){ 
		         // Se recoge el número de resultados
		         // Se almacenan las cadenas de resultado
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
		         // Se recoge el número de resultados
		         // Se almacenan las cadenas de resultado
		         while($fila1 = mysql_fetch_assoc($result)){
			     		$nvtrab	= $fila1['v_fun'];
			     		$totald = $d1* $nvtrab ;
		     		}		     
     		}
     	}	

//echo $sql1;
// Grabación en la tabla planilla

	@mysql_query("SET NAMES 'utf8'");
	
	$_grabar_sql = "INSERT INTO planilla 
	(dni, fec_emi, nro_exp, des_iti, motivo, fec_ini, fec_ter, hor_ini, hor_ter, medio, dpto_1, prov_1, dist_1, dpto_2, prov_2, dist_2, mon_pas, nro_dia,nro_hor, estado, mon_via, meta ) VALUES 
	('$c_dni', '$d_fec_emi', '$nro_exp', '$c_itin', '$c_moti', '$d_fi', '$d_ft', '$c_hi','$c_ht', '$c_medio', '$c_dpto1', '$c_prov1', '$c_dist1', '$c_dpto2', '$c_prov2', '$c_dist2', '$n_mopas', '$d','$ho', 'Por Rendir', '$totald', '$n_meta' )"; 

	//echo $_grabar_sql;

	mysql_query($_grabar_sql,$enlace);

	$rs = mysql_query("SELECT @@identity AS nro_spl");
	if ($row = mysql_fetch_row($rs)) {
		$id = trim($row[0]);
	}
	echo "<b><Font size=4 color='teal'> NOTA : EL NUMERO DE SOLICITUD PARA SU POSTERIOR BUSQUEDA, MODIFICACION Y/O IMPRESION ES : </b>"; 
	echo $id;
	echo "</font>";

 $_SESSION['dni']=$c_dni;
header('Location: user_01.php');

echo mysql_error();

}
?>
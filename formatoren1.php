<?php
require_once("dompdf/dompdf_config.inc.php");

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
 
conectar();
$n=$_REQUEST['sol'];  

mysql_set_charset('utf8');  // mostramos la información en utf-8
		          
		      $sql1 = "SELECT
						p.nro_exp,
						pe.ape_nom,
						p.dni,
						pe.cargo,
						pe.uni_org,
						p.des_iti,
						p.fec_ini,
						p.hor_ini,
						p.fec_ter,
						p.hor_ter,
						p.mon_pas,
						CASE pe.con_lab WHEN 'FUNCIONARIO' THEN d.v_fun ELSE d.v_trab END importe
						FROM planilla p 
						INNER JOIN personal pe ON p.dni=pe.dni
						INNER JOIN destinos d ON d.destino=p.dpto_2
						where p.nro_spl=".$n;

		      $resultado1 = @mysql_query($sql1); //Ejecución de la consulta
		      //Si hay resultados...

		      if (@mysql_num_rows($resultado1) > 0){ 
		         // Se recoge el número de resultados
		         // Se almacenan las cadenas de resultado
		         while($fila1 = @mysql_fetch_assoc($resultado1)){ 
		         
					$nro_exp=$fila1['nro_exp'];
					$ape_nom=$fila1['ape_nom'];
					$dni=$fila1['dni'];
					$cargo=$fila1['cargo'];
					$uni_org=$fila1['uni_org'];
					$des_iti=$fila1['des_iti'];
					$fec_ini=$fila1['fec_ini'];
					$hor_ini=$fila1['hor_ini'];
					$fec_ter=$fila1['fec_ter'];
					$hor_ter=$fila1['hor_ter'];
					$mon_pas=$fila1['mon_pas'];
					$importe1=$fila1['importe'];

}}



$text='';

$text.='
<html>
<head>
<style type="text/css">
  .titulo{
    background-color: #555;
    color: #fff;
    font-size: 14px;
    font-family: arial;
    font-weight: bolder;
    text-align: center;
  }

.datos{
    background-color: #ccc;
    color: #000;
    font-size: 14px;
    font-family: arial;
    font-weight: bolder;
    text-align: center;
  }
 .tit{
 	font-size: 18px;
    font-family: arial;
    font-weight: bolder;
    text-align: center;
 }
  .subtit{
 	font-size: 14px;
    font-family: arial;
    font-weight: bolder;
    text-align: center;
 }
 .text_negrta{
 	font-size: 12px;
    font-family: arial;
    font-weight: bolder;
 }
 .text{
 	font-size: 12px;
    font-family: arial;
 }
</style>
</head>
<body>

<table width="100%">
	
		<tr>
			<td><img src="img/logo.jpg" style="width:280px"></td>
			<td>
			<span>Fecha: &nbsp;</span><span>23/05/2017</span> <br>
			<span>hora: &nbsp;&nbsp;&nbsp;</span><span>18:59</span>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="tit">RENDICION DE CUENTAS POR COMISION DE SERVICIOS</td>
		</tr>
		<tr>
			
			<td colspan="2" class="subtit">(Anexo N&deg; 04)</td>
			
		</tr>
		<tr>
			
			<td colspan="2" class="text_negrta" style="text-align: right;">N&deg; Doc.:'.$nro_exp.'</td>
			
		</tr>
		
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td class="text_negrta" colspan="2" width="30%">NOMBRES Y APELLIDOS:</td>
						<td colspan="3" class="text">'.$ape_nom.'</td>
					</tr>
					<tr>
						<td class="text_negrta" colspan="2">DNI:</td>
						<td colspan="3" class="text">'.$dni.'</td>
					</tr>
					<tr>
						<td class="text_negrta" colspan="2">CARGO:</td>
						<td colspan="3" class="text">'.$cargo.'</td>
					</tr>
					<tr>
						<td class="text_negrta" colspan="2">UNIDAD ORGANICA:</td>
						<td colspan="3" class="text">'.$uni_org.'</td>
					</tr>
					<tr>
						<td class="text_negrta" colspan="2">LUGAR DE LA COMISION:</td>
						<td colspan="3" class="text">'.$des_iti.'</td>
					</tr>
					<tr>
						<td class="text_negrta" rowspan="2">FECHA COMISION:</td>
						<td class="text_negrta">Inicio</td>
						<td class="text"> '.$fec_ini.'</td>
						<td class="text_negrta" width="10%">Hora:</td>
						<td class="text">'.$hor_ini.'</td>
					</tr>
					<tr>
						
						<td class="text_negrta">T&eacute;rmino</td>
						<td class="text">'.$fec_ter.'</td>
						<td class="text_negrta">Hora:</td>
						<td class="text">'.$hor_ter.'</td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td class="text_negrta">COMPROBANTE DE PAGO:</td>
						<td class="text">&nbsp;</td>
						<td class="text_negrta">REG. SIAF:</td>
						<td class="text">&nbsp;</td>
						<td class="text_negrta">IMPORTE ASIGNADO (S/.)</td>
						<td class="text">'.$importe1.'</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">ACCIONES RELEVANTES DE LA COMISION DE SERVICIOS:</td>
			
		</tr>
		<tr>
		<td colspan="2">

			<table width="80%" align="center">
			  <tr>
			    <td class="titulo">Fecha</td>
			    <td class="titulo">Tipo Doc.</td>
			    <td class="titulo">Nro. Doc.</td>
			    <td class="titulo" width="20%">Razon</td>
			    <td class="titulo" width="20%">Concepto</td>
			    <td class="titulo">Clasificador <br>de gasto</td>
			    <td class="titulo">Importe</td>
		
			  </tr>';
		     
		     $total=0;

		      mysql_set_charset('utf8');  // mostramos la información en utf-8
		      $sql = "SELECT * FROM rendiciones where nro_spl=".$n;
		      $resultado = @mysql_query($sql); //Ejecución de la consulta
		      if (@mysql_num_rows($resultado) > 0){ 
		         // Se recoge el número de resultados
		         // Se almacenan las cadenas de resultado
		         while($fila = @mysql_fetch_assoc($resultado)){ 
		          $nro_spl=$fila['nro_spl'];
		          $fecha=$fila['fecha'];
		          $tipo_doc=$fila['tipo_doc'];
		          $Nro_doc=$fila['Nro_doc'];
		          $razon=$fila['razon'];
		          $concepto=$fila['concepto'];
		          $clasif=$fila['clasif'];
		          $importe=$fila['importe'];
		          $acciones=$fila['acciones'];
		          $observacion=$fila['observacion'];
		          $id_rendicion=$fila['id_rendicion'];
		          $total=$total+$importe;

		   $text.='
		   <tr>
		     <td class="datos">'.date_format(date_create($fecha),"d/m/Y").'</td>
		     <td class="datos">'.$tipo_doc.'</td>
		     <td class="datos">'.$Nro_doc.'</td>
		     <td class="datos">'.$razon.'</td>
		     <td class="datos">'.$concepto.'</td>
		     <td class="datos">'.$clasif.'</td>
		     <td class="datos">'.$importe.'</td>
		     
		   </tr>';

		  }}
		  $saldo=$importe1-$total;

		  $text.='
		 <tr>
		 	<td colspan="5"></td>
		 	<td class="titulo">Subtotal</td>
		 	<td class="datos">'.$total.'</td>
		 </tr>
		 <tr>
		 	<td colspan="5"></td>
		 	<td class="titulo">Gastos por Declaración <br>Jurada (Anexo 4) (S/.)</td>
		 	<td class="datos">0</td>
		 </tr>
		 <tr>
		 	<td colspan="5" rowspan="4">
		 		<table width="80%" align="center">  
		 			<tr>
		 				<td class="titulo">Clasificador</td>
		 				<td class="titulo">Asignado</td>
		 				<td class="titulo">Ejecutado</td>
		 				<td class="titulo">Saldo</td>
		 			</tr>
		 			<tr>
		 				<td class="datos">2.3.2.1.2.1</td>
		 				<td class="datos"></td>
		 				<td class="datos"></td>
		 				<td class="datos">0.00</td>
		 			</tr>
		 			<tr>
		 				<td class="datos">2.3.2.1.2.2</td>
		 				<td class="datos"></td>
		 				<td class="datos"></td>
		 				<td class="datos">0.00</td>
		 			</tr>
		 			<tr>
		 				<td class="titulo">Total S/.</td>
		 				<td class="titulo">0.00</td>
		 				<td class="titulo">0.00</td>
		 				<td class="titulo">0.00</td>
		 			</tr>
		 		</table>
		 	</td>
		 	<td class="titulo">TOTAL RENDIDO (S/.)</td>
		 	<td class="datos">'.$total.'</td>
		 </tr>
		 <tr>
		 	<td colspan="2"></td>
		 </tr>
		 <tr>
		 	<td class="titulo">SALDO (S/.)</td>
		 	<td class="datos">'.$saldo.'</td>
		 </tr>
 		 <tr>
		 	<td colspan="2"></td>
		 </tr>
			</table>
		</td>
	</tr>
</table>';

$dompdf = new DOMPDF();
$dompdf->load_html($text);
$dompdf->render();
$dompdf->stream("ejemplo-basico.pdf", array('Attachment' => 0));

 ?>
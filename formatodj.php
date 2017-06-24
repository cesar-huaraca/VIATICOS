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
 .texto{
 	font-size: 12px;
    font-family: arial;
    text-align:justify;
 }
</style>
</head>
<body>

<table width="100%">
	
		<tr>
			<td height="150px"><img src="img/logo.jpg" style="width:280px"></td>
			<td>
			<span>Fecha: &nbsp;</span><span>23/05/2017</span> <br>
			<span>hora: &nbsp;&nbsp;&nbsp;</span><span>18:59</span>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" class="tit">DECLARACION JURADA</td>
		</tr>
		<tr>
			
			<td colspan="2" class="subtit">(Anexo N&deg; 5)</td>
			
		</tr>
		<tr>
			
			<td colspan="2" class="text_negrta" style="text-align: right;">N&deg; Doc.:'.$nro_exp.'</td>
			
		</tr>
		
		<tr>
			<td colspan="2" >
				<table width="100%" cellpadding="5px" cellspacing="5px">
					<tr>
						<td class="text_negrta" width="30%">NOMBRES Y APELLIDOS:</td>
						<td class="text">'.$ape_nom.'</td>
					</tr>
					<tr>
						<td class="text_negrta">DNI:</td>
						<td class="text">'.$dni.'</td>
					</tr>
					<tr>
						<td class="text_negrta">CARGO:</td>
						<td class="text">'.$cargo.'</td>
					</tr>
					<tr>
						<td class="text_negrta">UNIDAD ORGANICA:</td>
						<td class="text">'.$uni_org.'</td>
					</tr>
					<tr>
						<td class="text_negrta">LUGAR DE LA COMISION:</td>
						<td class="text">'.$des_iti.'</td>
					</tr>
					<tr>
						<td class="text_negrta">FECHA COMISION:</td>
						<td class="text"> '.$fec_ini.' - '.$fec_ter.'</td>
					</tr>
					
				</table>	
			</td>
		</tr>

		<tr>
			<td colspan="2" height="100px">
				<div class="texto">En  aprobación a lo dispuesto  en el artículo 71º de la Resolución Directoral Nº 002-2007-EF/77.15  Directiva de Tesorería para el año 2007; declaro haber efctuado gastos por los conceptos que se detallan a continuación, 
durante la comisión de servicios realizada, de los cuales no me ha sido posible obtener comprobantes de pago reconocidos y emitidos de conformidad con lo establecido por la SUNAT.										
En concordancia con el Decreto Supremo Nº 007-2013-EF no podrá exceder del 30% del importe asignado para viáticos (alimentación, hospedaje y movilidad).
					</div>
			</td>
		</tr>
		<tr>
		<td colspan="2">

			<table width="80%" align="center">
			  <tr>
			    <td class="titulo">Fecha</td>
			    <td class="titulo" width="20%">Concepto</td>
			    <td class="titulo">Clasificador <br>de gasto</td>
			    <td class="titulo">Importe</td>
		
			  </tr>';
		     
		     $total=0;

		      mysql_set_charset('utf8');  // mostramos la información en utf-8
		      $sql = "SELECT * FROM decjurada where nro_spl=".$n;
		      $resultado = @mysql_query($sql); //Ejecución de la consulta
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
		          $id_rendicion=$fila['id_dj'];
		          $total=$total+$importe;

		   $text.='
		   <tr>
		     <td class="datos">'.date_format(date_create($fecha),"d/m/Y").'</td>
		     <td class="datos">'.$concepto.'</td>
		     <td class="datos">'.$clasif.'</td>
		     <td class="datos">'.$importe.'</td>
		     
		   </tr>';

		  }}
		  

		  $text.='
		 <tr>
		 	<td colspan="2"></td>
		 	<td class="titulo">Total (S/.)</td>
		 	<td class="datos">'.$total.'</td>
		 </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="50px">
			<div class="texto">Firmo el presente documento que tiene el carácter de Declaración Jurada para los efectos legales correspondientes.</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="50px">

		</td>
		</tr>
	<tr>
		<td>
		</td>
		
		<td style="vertical-align: top;">
			<div style="border-top:1px solid #000;"><center>Firma Comisionado</center></div>
		</td>
	</tr>
</table>';

$dompdf = new DOMPDF();
$dompdf->load_html($text);
$dompdf->render();
$dompdf->stream("ejemplo-basico.pdf", array('Attachment' => 0));

//echo $text;
 ?>
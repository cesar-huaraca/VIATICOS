<?php

require('fpdf.php');

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

$busqueda = $_POST['sol'];

if($_POST){
    
  $busqueda = $_POST['sol'];

  
}
  $entero = 0;
  
  if (empty($busqueda)){
      $texto = 'Búsqueda sin resultados';
    }
  else
    {
      
      //Consulta para la base de datos, se utiliza un comparador LIKE para acceder a todo lo que contenga la cadena a buscar   '%" .$busqueda. "%' "
      
   $sql = "SELECT a.*, b.* FROM planilla A, personal B WHERE a.dni=b.dni and a.nro_spl = $busqueda LIMIT 1 ";

      $result = mysql_query($sql); //Ejecución de la consulta
      //Si hay resultados...
    }



//Creamos un nuevo archivo pdf 
$pdf=new FPDF();

//Deshabilitamos automatico el page break
$pdf->SetAutoPageBreak(false);

//Primera página
$pdf->AddPage();

//seteo inicial y posicion axis por pagina
$y_axis_initial = 70;

//Impresion de columnas
$pdf->SetY(35);
$pdf->SetFont('Arial','B',14);
$pdf->SetX(15); 
$pdf->write(10,'                               SOLICITUD DE COMISION DE SERVICIOS');

$pdf->SetY(45);
$pdf->SetFont('Arial','',9);
$pdf->SetX(70); 
$pdf->SetY(40);
$pdf->write(10,'                                                                                                Anexo Nro. 01');


//initialize counter
$i = 0;

//Set maximum rows per page
$max = 20;

//Set Row Height
$row_height = 6;

$y_axis = $y_axis_initial + $row_height;

$pdf->Image('logo.jpg', 1, 10, 80,20);

while($row = mysql_fetch_array($result))
{
    //If the current row is the last one, create new page and print column title
    if ($i == $max)
    {
        $pdf->AddPage();

        //print column titles for the current page
        $pdf->SetY($y_axis_initial);
        $pdf->write(10,'SOLICITUD DE COMISION DE SERVICIOS');

        
        //Go to next row
        $y_axis = $y_axis_initial + $row_height;
        
        //Set $i variable to 0 (first row)
        $i = 0;
    }

    $code = utf8_decode($row['dni']);
    $price = utf8_decode($row['nro_exp']);
    $name = utf8_decode($row['nro_spl']);
    $nomb = utf8_decode($row['ape_nom']);
    $ban  = utf8_decode($row['banco']);
    $cta  = utf8_decode($row['nro_cta']);
    $carg = utf8_decode($row['cargo']);
    $clab = utf8_decode($row['con_lab']);
    $uorg = utf8_decode($row['uni_org']);
    $diti = utf8_decode($row['des_iti']);
    $fini = utf8_decode($row['fec_ini']);
    $fter = utf8_decode($row['fec_ter']);
    $hini = utf8_decode($row['hor_ini']);
    $hter = utf8_decode($row['hor_ter']);
    $tran = utf8_decode($row['medio']);
    $moti = utf8_decode($row['motivo']);

//armando el cuerpo de la impresion de la solicitud
    $pdf->SetFont('Arial','',9);
    $pdf->SetX(20); 
    $pdf->SetY(50);
    $pdf->write(10,'Nro. Expediente: ');
    $pdf->write(10,$price);
    $pdf->SetX(140);
    $pdf->write(10,'Nro. Solicitud: ');
    $pdf->write(10,$name);

    $pdf->SetFont('Arial','BU',11);
    $pdf->SetX(30); 
    $pdf->SetY(60);
    $pdf->write(10,'DATOS DEL COMISIONADO');

    $pdf->SetFont('Arial','',9);
    $pdf->SetX(30); 
    
    $pdf->SetY(70);
    $pdf->write(10,'NOMBRE Y APELLIDOS : ');
    $pdf->SetX(70);
    $pdf->write(10,$nomb);
    $pdf->SetFont('Arial','',9);
    
    $pdf->SetY(75);
    $pdf->write(10,'DNI : ');
    $pdf->SetX(70);
    $pdf->write(10,$code);
    
    $pdf->SetY(80);
    $pdf->write(10,'CARGO : ');
    $pdf->SetX(70);
    $pdf->write(10,$carg);
    
    $pdf->SetY(85);
    $pdf->write(10,'CONDICION LABORAL : ');
    $pdf->SetX(70);
    $pdf->write(10,$clab);
    
    $pdf->SetY(90);
    $pdf->write(10,'UNIDAD ORGANICA : ');
    $pdf->SetX(70);
    $pdf->write(10,$uorg);

    $pdf->SetY(95);
    $pdf->write(10,'DESTINO - ITINERARIO : ');
    $pdf->SetX(70);
    $pdf->write(10,$diti);

    $pdf->SetFont('Arial','BU',11);
    $pdf->SetX(30); 
    $pdf->SetY(110);
    $pdf->write(10,'FECHA DE COMISION');

    $pdf->SetFont('Arial','',9);
    $pdf->SetY(120);
    $pdf->write(10,'FECHA INICIO : ');
    $pdf->SetX(70);
    $pdf->write(10,$fini);

    $pdf->SetY(125);
    $pdf->write(10,'FECHA TERMINO : ');
    $pdf->SetX(70);
    $pdf->write(10,$fter);

    $pdf->SetFont('Arial','',9);
    $pdf->SetY(130);
    $pdf->write(10,'HORA INICIO : ');
    $pdf->SetX(70);
    $pdf->write(10,$hini);

    $pdf->SetY(135);
    $pdf->write(10,'HORA TERMINO : ');
    $pdf->SetX(70);
    $pdf->write(10,$hter);

    $pdf->SetY(140);
    $pdf->write(10,'TIPO DE TRANSPORTE : ');
    $pdf->SetX(70);
    $pdf->write(10,$tran);

    $pdf->SetY(145);
    $pdf->write(10,'MOTIVO DE VIAJE : ');
    $pdf->SetX(70);
    $pdf->write(10,$moti);

    $data[1]="La rendicion de viaticos al interior del pais se efectua de los diez (10) dias habiles de culminada la comision de";
    $data[2]="servicios; de conformidad a lo establecido en el Decreto Supremo N. 007-2013-EF; y la rendicion de viaticos al";
    $data[3]="Exterior del pais se efectua dentro de los quince (15) dias calendario de culminada la comision de servicios; de " ;
    $data[4]="conformidad a lo establecido en la Ley N. 27619, ley que regula la autorizacion de viajes al exterior de servidores"; 
    $data[5]="y funcionarios publicos." ;
    $data[6]="Si vencido dicho plazo incumplira con la norma precisada, el que suscribe, sera posible de las medidas disciplinarias ";
    $data[7]="aplicables de acuerdo a lo establecido en la Normatividad vigente." ;
    $data[8]="                ___________________________________             __________________________________" ;
    $data[9]="                        Firma Comisionado                                                         V.B. Jefe Inmediato" ;

    $pdf->SetFont('Arial','I',9);
    $pdf->SetY(160);
    $pdf->SetX(10);
    $pdf->write(10,$data[1]);    
    $pdf->SetY(165);
    $pdf->write(10,$data[2]);    
    $pdf->SetY(170);
    $pdf->write(10,$data[3]);    
    $pdf->SetY(175);
    $pdf->write(10,$data[4]);    
    $pdf->SetY(180);
    $pdf->write(10,$data[5]);        
    $pdf->SetY(190);
    $pdf->write(10,$data[6]);        
    $pdf->SetY(195);
    $pdf->write(10,$data[7]);            
    $pdf->SetY(225);
    $pdf->write(10,$data[8]);    
    $pdf->SetY(230);
    $pdf->write(10,$data[9]);    

    //Ir a la siguiente linea o registro
    $y_axis = $y_axis_initial + $row_height;
    $i = $i + 1;
}

desconectar();

//envia archivo
$pdf->Output();

?>
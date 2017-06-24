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
$pdf->SetX(45); 
$pdf->write(10,'PLANILLA DE VIATICOS POR COMISION DE SERVICIOS');

$pdf->SetY(45);
$pdf->SetFont('Arial','',9);
$pdf->SetX(70); 
$pdf->SetY(40);
$pdf->write(10,'                                                                                                Anexo Nro. 02');

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
    $meta = utf8_decode($row['meta']);
    $mvia = utf8_decode($row['mon_via']);
    $mpas = utf8_decode($row['mon_pas']);
    $ndia = utf8_decode($row['nro_dia']);
    $nhor = utf8_decode($row['nro_hor']);
    $dpt1 = utf8_decode($row['dpto_1']);
    $dpt2 = utf8_decode($row['dpto_2']);
    $pro1 = utf8_decode($row['prov_1']);
    $pro2 = utf8_decode($row['prov_2']);
    $dis1 = utf8_decode($row['dist_1']);
    $dis2 = utf8_decode($row['dist_2']);


    $mgen = $row['mon_via'] + $row['mon_pas'];

//armando el cuerpo de la impresion de la solicitud
    $pdf->SetFont('Arial','',9);
    $pdf->SetY(50);
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
    $pdf->write(10,'BANCO: ');
    $pdf->SetX(70);
    $pdf->write(10,$ban);

    $pdf->SetY(95);
    $pdf->write(10,'Nro. CUENTA: ');
    $pdf->SetX(70);
    $pdf->write(10,$cta);    

    $pdf->SetY(100);
    $pdf->write(10,'UNIDAD ORGANICA : ');
    $pdf->SetX(70);
    $pdf->write(10,$uorg);



    $pdf->SetFont('Arial','BU',11);
    $pdf->SetX(30); 
    $pdf->SetY(110);
    $pdf->write(10,'DATOS DE LA COMISION');

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

    $pdf->SetFont('Arial','BU',12);
    $pdf->SetX(30); $pdf->SetY(165);
    $pdf->write(10,'PRESUPUESTO DE LA COMISION');

    $pdf->SetFont('Arial','',9);
    $pdf->SetX(35); $pdf->SetY(175);
    $pdf->Cell(20,6,'META',1,0,'C',0);
    $pdf->Cell(50,6,'CONCEPTO',1,0,'C',0);
    $pdf->Cell(70,6,'CLASIFICADOR DE GASTO',1,0,'C',0);
    $pdf->Cell(40,6,'MONTO (S/.)',1,0,'C',0);

    $pdf->SetX(35); $pdf->SetY(175);
    $pdf->Cell(20,28,$meta,1,0,'C',0);
    $pdf->SetX(30); 
    $pdf->Cell(50,28,'Viaticos',1,0,'L',0);
    $pdf->Cell(70,28,'2.3.2.1.2.2',1,0,'C',0);
    $pdf->Cell(40,28,$mvia,1,0,'R',0);

    $pdf->SetX(30); $pdf->SetY(180);
    $pdf->Cell(20,28,'    ',0,0,'C',0);    
    $pdf->Cell(50,28,'Nro. dia      : '.$ndia,0,0,'L',0);
    $pdf->Cell(70,28,'2.3.2.1.2.1',0,0,'C',0);
    $pdf->Cell(40,28,$mpas,0,0,'R',0);

    $pdf->SetX(30); $pdf->SetY(185);
    $pdf->Cell(20,28,'    ',0,0,'C',0);    
  
    $pdf->Cell(50,28,'Fraccion Horas: '.$nhor, 0,0,'L',0);
    $pdf->Cell(70,28,'TOTAL (S/.)',0,0,'C',0);
    $pdf->Cell(40,28,$mgen,0,0,'R',0);


    $pdf->SetFont('Arial','',9);
    $pdf->SetX(35); $pdf->SetY(210);
    $pdf->Cell(75,6,'DESDE',1,0,'C',0);
    $pdf->Cell(75,6,'HASTA',1,0,'C',0);
    
    $pdf->SetFont('Arial','',8);
    $pdf->SetX(35); $pdf->SetY(215);
    $pdf->Cell(25,8,'DPTO',0,0,'C',0);
    $pdf->Cell(25,8,'PROV.',0,0,'C',0);    
    $pdf->Cell(25,8,'DISTRITO',0,0,'C',0);    
    $pdf->SetX(85); 
    $pdf->Cell(25,8,'DPTO',0,0,'C',0);
    $pdf->Cell(25,8,'PROV.',0,0,'C',0);    
    $pdf->Cell(25,8,'DISTRITO',0,0,'C',0);    

    $pdf->SetY(220);
    $pdf->Cell(25,8,$dpt1,0,0,'C',0);
    $pdf->Cell(25,8,$pro1,0,0,'C',0);    
    $pdf->Cell(25,8,$dis1,0,0,'C',0);    
    $pdf->SetX(85); 
    $pdf->Cell(25,8,$dpt2,0,0,'C',0);
    $pdf->Cell(25,8,$pro2,0,0,'C',0);    
    $pdf->Cell(25,8,$dis2,0,0,'C',0);    


     $data[8]="                ___________________________________             __________________________________" ;
     $data[9]="                        Firma Comisionado                                                         V.B. Jefe Inmediato" ;

     //$data[10]=date('d/m/Y');
     //$data[11]=date('h:i:s');
     //$data[11]=date('l jS \of F Y h:i:s A');

     $pdf->SetFont('Arial','I',9);
     $pdf->SetY(250); $pdf->write(10,$data[8]);    
     $pdf->SetY(255); $pdf->write(10,$data[9]);    
     //$pdf->SetY(270); $pdf->write(10,$data[10]);    
     //$pdf->SetY(275); $pdf->write(10,$data[11]);    

    //Ir a la siguiente linea o registro
    $y_axis = $y_axis_initial + $row_height;
    $i = $i + 1;
}

desconectar();

//envia archivo
$pdf->Output();
?>
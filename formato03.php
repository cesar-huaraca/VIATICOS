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
$pdf->SetFont('Arial','B',12);
$pdf->SetY(35);
$pdf->SetX(20); 
$pdf->write(10,'AUTORIZACION DE RETENCION DE HABERES POR VIATICOS NO RENDIDOS Y/O');
$pdf->SetY(40);
$pdf->SetX(15); 
$pdf->write(10,'PASAJES AEREOS NO REPROGRAMABLES Y NO UTILIZADOS EN LA FECHA PREVISTA');
$pdf->SetFont('Arial','',9);
$pdf->SetY(45);
$pdf->SetX(90); 
$pdf->write(10,'Anexo Nro. 03');

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
        $pdf->write(10,'AUTORIZACION DE RETENCION DE HABERES POR VIATICOS NO RENDIDOS Y/O');
        // $pdf->SetX(15);
        // $pdf->Cell(20,30,'DNI',1,0,'L',1);
        // $pdf->Cell(30,30,'NRO_EXP',1,0,'C',1);
        // $pdf->Cell(50,30,'NRO. SOLICITUD',1,0,'L',1);
        // $pdf->Cell(80,30,'COMISIONADO',1,0,'L',1);
        
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
    $pdf->SetX(140);
    $pdf->SetY(60);
    $pdf->write(10,'Nro. Solicitud: ');
    $pdf->write(10,$name);


    $pdf->SetFont('Arial','',11);
    $pdf->SetX(20); 
    $pdf->SetY(75);
    $pdf->write(10,'Dependencia: ');
    $pdf->write(10,$uorg);

    $pdf->SetX(20); 
    $pdf->SetY(85);
    $pdf->write(10,'Comision: ');
    $pdf->write(10,$moti);    




    $data[1]="Yo,  ";
    $pdf->SetFont('Arial','B',9);
    $data[2]=$nomb;
    $pdf->SetFont('Arial','',9);
    $data[3]=" identificado con DNI Nro." ;
    $pdf->SetFont('Arial','B',9);
    $data[4]=$code; 
    $pdf->SetFont('Arial','',9);
    $data[5]=" servidor del " ;

    $data[6]="Ministerio de Salud, autorizo de manera expresa para que se efectue la RETENCION de mis haberes, honorarios o ";
    $data[7]="retribucion que pudiera percibir hasta por el monto total del viatico y pasajes recibido, en el caso de no efectuar" ;
    $data[8]="oportunamente la rendicion de gastos o subsanar, en el plazo maximo de diez (10) dias habiles desde la conclusion" ;
    $data[9]="de la comision de servicios o no haber devuelto los saldos no utilizados." ;
    $data[10]="La presente autorizacion se realiza en salvaguarda de los intereses del Estado, y sin prejuicio de las responsabilidades" ;
    $data[11]="administrativas, civiles y/o penales que pudiera resultar del procedimiento disciplinario a que diera lugar el" ;    
    $data[12]="incumplimiento de la rendicion de cuentas." ;    


    $data[13]="                ___________________________________  " ;
    $data[14]="                               Firma Comisionado            " ;
    $data[15]="Lima, _________________________" ;


    $pdf->SetFont('Arial','',9);
    $pdf->SetY(100);
    $pdf->SetX(10);
    $pdf->write(10,$data[1]);    
    $pdf->write(10,$data[2]);    
    $pdf->write(10,$data[3]);    
    $pdf->write(10,$data[4]);    
    $pdf->write(10,$data[5]);        
    $pdf->SetY(105);
    $pdf->write(10,$data[6]);        
    $pdf->SetY(110);
    $pdf->write(10,$data[7]);            
    $pdf->SetY(115);
    $pdf->write(10,$data[8]);            
    $pdf->SetY(120);
    $pdf->write(10,$data[9]); 
    $pdf->SetY(135);
    $pdf->write(10,$data[10]); 
    $pdf->SetY(140);
    $pdf->write(10,$data[11]); 
    $pdf->SetY(145);
    $pdf->write(10,$data[12]); 


    $pdf->SetY(170);
    $pdf->write(30,$data[15]);    
    $pdf->SetY(205);
    $pdf->write(30,$data[13]);    
    $pdf->SetY(210);
    $pdf->write(30,$data[14]);    

    //Ir a la siguiente linea o registro
    $y_axis = $y_axis_initial + $row_height;
    $i = $i + 1;
}

desconectar();

//envia archivo
$pdf->Output();
?>
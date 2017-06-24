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
}
// Si hay información para buscar, abrimos la conexión

	$c_1= $_POST['dni'];
	$c_2= $_POST['password'];
	$c_3= $_POST['v_tipo'];


    mysql_set_charset('utf8');  // mostramos la información en utf-8
                                            
    $sql = "SELECT * FROM personal WHERE dni='$c_1' ";

    $cdni = "";

    $resultado = @mysql_query($sql,$enlace);
    //$result = mysql_query($sql); //Ejecución de la consulta
    if (@mysql_num_rows($resultado) > 0){ 
      	// Se recoge el número de resultados
       	// Se almacenan las cadenas de resultado
     	while($fila1 = @mysql_fetch_assoc($resultado)){ 
            $cdni = $fila1['dni'];
            $stat = $fila1['status'];

             //header('user_01.php');
            $_SESSION['dni']=$c_1;
              header('Location: user_01.php');
        }
    }

//if ($c_3=='Area Usuaria' and $stat == 'A')
//{
	//require('user_01.php');
	//require('index.php');
	 //header('user_01.php');
/*}	

if ($c_3=='Control Previo' and $stat == 'C')
{
	require('index_cpre.php');
}

if ($c_3=='Tesoreria' and $stat == 'T')
{
	require('index_teso.php');
}

if ($c_3=='Presupuesto' and $stat == 'P')
{
	require('index_ppto.php');
}

if ($c_3=='Administrador' and $stat == 'X')
{
	require('index_admi.php');
}*/

/*else
	{
		echo '<h1>';
		echo '<b style="color:blue"	>';
		echo 'Usuario NO AUTORIZADO...';			
		echo '</b>';
		echo '</h1>';
		echo '<h2>';
		echo '<p></p>';
		echo '<b style="color:red">';
		ECHO '  Usuario o clave ERRONEA...';
		echo '</b>';
		echo '</h2>';
	}
*/
?>
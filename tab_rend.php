<?php

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

$n=$_REQUEST['sol'];  


?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
  .titulo{
    background-color: #555;
    color: #fff;
    font-size: 14px;
    font-family: arial;
    font-weight: bolder;
    padding: 10px;
    text-align: center;
    border: 5px solid #eee;
  }

.datos{
    background-color: #ccc;
    color: #000;
    font-size: 14px;
    font-family: arial;
    font-weight: bolder;
    padding: 10px;
    text-align: center;
    border: 5px solid #eee;
  }
</style>
</head>
<body>

<table cellpadding="20" cellspacing="20" align="center">
  <tr>
    <td class="titulo">Fecha</td>
    <td class="titulo">Tipo Doc.</td>
    <td class="titulo">Nro. Doc.</td>
    <td class="titulo">RUC.</td>
    <td class="titulo">Razon</td>
    <td class="titulo">Concepto</td>
    <td class="titulo">Importe</td>
    <td class="titulo">Opciones</td>
  </tr>
  <?php 
      
      conectar();
      mysql_set_charset('utf8');  // mostramos la información en utf-8
          
      $sql = "SELECT * FROM rendiciones where nro_spl=".$n;

      $resultado = @mysql_query($sql); //Ejecución de la consulta
      //Si hay resultados...

      if (@mysql_num_rows($resultado) > 0){ 
         // Se recoge el número de resultados
         // Se almacenan las cadenas de resultado
         while($fila = @mysql_fetch_assoc($resultado)){ 
          $nro_spl=$fila['nro_spl'];
          $fecha=$fila['fecha'];
          $tipo_doc=$fila['tipo_doc'];
          $Nro_doc=$fila['Nro_doc'];
          $razon=$fila['razon'];
          $ruc=$fila['ruc'];
          $concepto=$fila['concepto'];
          $clasif=$fila['clasif'];
          $importe=$fila['importe'];
          $acciones=$fila['acciones'];
          $observacion=$fila['observacion'];
          $id_rendicion=$fila['id_rendicion'];

   ?>
   <tr>
     <td class="datos"><?php echo date_format(date_create($fecha),"d/m/Y"); ?></td>
     <td class="datos"><?php echo $tipo_doc; ?></td>
     <td class="datos"><?php echo $Nro_doc; ?></td>
     <td class="datos"><?php echo $ruc; ?></td>
     <td class="datos"><?php echo $razon; ?></td>
     <td class="datos"><?php echo $concepto; ?></td>
     <td class="datos"><?php echo $importe; ?></td>
     <td class="datos">
     <img src="img/delete.png" onclick="elimina('<?php echo $id_rendicion ?>')">
     </td>
   </tr>

<?php 
  }}
 ?>
</table>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function elimina(id) {
   $.ajax({
             type: "POST",
                url: "graba_ren.php",
                data: 
                {
                "id": id,
                "opcion": 'elimina',
                },
                dataType: "html",
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){
                        
                  }
              });
}
  </script>
</body>
</html>

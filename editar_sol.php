<?php
session_start();
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

$id=$_REQUEST['id'];

$sql = "SELECT dni, nro_exp, fec_emi, nro_spl, nro_siaf, des_iti, motivo, dpt1.idDepa dep1, dpto_1, pro1.idProv p1, prov_1, dist1.idDist d1, dist_1, dpt2.idDepa dep2, dpto_2, pro2.idProv p2, prov_2, dist2.idDist d2, dist_2, fec_ini, fec_ter, nro_dia, nro_hor, hor_ini, hor_ter, meta, mon_pas, mon_via, medio, observacion, estado, comprobante 
FROM planilla p 
INNER JOIN ubdepartamento dpt1 on p.dpto_1=dpt1.departamento 
INNER JOIN ubdepartamento dpt2 on p.dpto_2=dpt2.departamento 
INNER JOIN ubprovincia pro1 on p.prov_1=pro1.provincia AND dpt1.idDepa=pro1.idDepa
INNER JOIN ubprovincia pro2 on p.prov_2=pro2.provincia AND dpt2.idDepa=pro2.idDepa
INNER JOIN ubdistrito dist1 on p.dist_1=dist1.distrito AND pro1.idProv=dist1.idProv
INNER JOIN ubdistrito dist2 on p.dist_2=dist2.distrito AND pro2.idProv=dist2.idProv
WHERE p.nro_spl=".$id." LIMIT 1";

$result = mysql_query($sql); 
      if (mysql_num_rows($result) > 0){ 
         while($fila = mysql_fetch_assoc($result)){ 
            
            $dni= $fila['dni'];
            $nro_exp= $fila['nro_exp'];
            $fec_emi= $fila['fec_emi'];
            $nro_spl= $fila['nro_spl'];
            $nro_siaf= $fila['nro_siaf'];
            $des_iti= $fila['des_iti'];
            $motivo= $fila['motivo'];
            $dpto_1= $fila['dpto_1'];
            $d1= $fila['dep1'];            
            $prov_1= $fila['prov_1'];
            $p1= $fila['p1'];
            $dist_1= $fila['dist_1'];
            $di1= $fila['d1'];
            $dpto_2= $fila['dpto_2'];
            $d2= $fila['dep2'];
            $prov_2= $fila['prov_2'];
            $p2= $fila['p2'];
            $dist_2= $fila['dist_2'];
            $di2= $fila['d2'];
            $fec_ini= $fila['fec_ini'];
            $fec_ter= $fila['fec_ter'];
            $nro_dia= $fila['nro_dia'];
            $nro_hor= $fila['nro_hor'];
            $hor_ini= $fila['hor_ini'];
            $hor_ter= $fila['hor_ter'];
            $meta= $fila['meta'];
            $mon_pas= $fila['mon_pas'];
            $mon_via= $fila['mon_via'];
            $medio= $fila['medio'];
            $observacion= $fila['observacion'];
            $estado= $fila['estado'];
            $comprobante= $fila['comprobante'];
                    

                       
}
     }
  ?>

<!DOCTYPE html>
   <html>
   <head>
       <title></title>
       <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   </head>
   <body>
   <form action="act_v.php" method="post">
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>COMISIONADO : </label>
                                <label><?php echo strtoupper($_SESSION['ape_nom']); echo ' - Dni : '. $dni; ?></label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>Nro. Expediente</label>
                                <input type="text" class="form-control" id="InputExp" placeholder="Ingrese expediente...  12-123456-123 " name="nroexp" value="<?php echo $nro_exp; ?>">
                                <input type="hidden" name="id" name="id" value="<?php echo $id; ?>">
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <div class="form-group">
                                <label>Destino - Itinerario</label>
                                <input type="text" class="form-control" id="destino" placeholder="Lima - ..... - Lima " name="itinerario" value="<?php echo $des_iti; ?>">
                            </div>
                            <div class="form-group">
                                <label>Motivo del viaje</label>
                                <input type="text" class="form-control" id="motivo" placeholder=" " name="motivo" value="<?php echo $motivo; ?>">
                            </div>     
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Fecha Inicio<small> (requerido)</small></label>
                                <input name="Fecha_I" type="date" required class="form-control" placeholder="dd/mm/yy" value="<?php echo $fec_ini; ?>">
                                <label>Fecha Termino<small> (requerido)</small></label>
                                <input name="Fecha_T" type="date" required class="form-control" placeholder="dd/mm/yy" value="<?php echo $fec_ter; ?>">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Hora Inicio<small> (requerido)</small></label>
                                <input name="Hora_I" type="time" required class="form-control" placeholder="hh:mm..." value="<?php echo $hor_ini; ?>">
                                <label>Hora Termino<small> (requerido)</small></label>
                                <input name="Hora_T" type="time" required class="form-control" placeholder="hh:mm..." value="<?php echo $hor_ter; ?>">
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Medio Transporte</label>
                                <select class="form-control" name="medio" id="medio">
                                    <option value="">- Medio -</option>
                                    <option value="Terrestre">Terrestre</option>
                                    <option value="Aereo">Aereo</option>
                                    <option value="Otros">Otros</option>
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-sm-offset-1"">
                            <div class="form-group">
                                <label></label>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Departamento" name="dpt1">  -->
                                <div class="col-sm-6 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>DESDE</label>
                                        <select class="form-control" name="dpt1" id="dpt1">
                                            <option disabled="" selected="">- Departamento -</option>
                                            <?php 
                                                $sql12 = "SELECT * FROM ubdepartamento";

                                            $result12 = mysql_query($sql12); 
                                                  if (mysql_num_rows($result12) > 0){ 
                                                     // Se recoge el número de resultados
                                                     // Se almacenan las cadenas de resultado
                                                     while($fila12 = mysql_fetch_assoc($result12)){
                                                        $iddepa = $fila12['idDepa'];
                                                        $depar= $fila12['departamento'];
                                             ?>
                                                    <option value="<?php echo $iddepa ?>"><?php echo $depar; ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                                 <select class="form-control" name="prov1" id="prov1">
                                     <option value="">--PROVINCIA--</option>
                                     <?php 
                                            $sql123 = "SELECT idProv,provincia FROM ubprovincia where idDepa=".$d1;

                                            $result123 = mysql_query($sql123); 
                                                  if (mysql_num_rows($result123) > 0){ 
                                                     while($fila123 = mysql_fetch_assoc($result123)){
                                                        $idProv = $fila123['idProv'];
                                                        $provincia= $fila123['provincia'];
                                             ?>
                                                    <option value="<?php echo $idProv; ?>"><?php echo $provincia; ?></option>
                                            <?php }} ?>
                                 </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Provincia" name="prov1"> -->
                                <p></p>
                                <select class="form-control" name="dist1" id="dist1">
                                    <option value="">--DISTRITO--</option>
                                    <?php 
                                            $sql1234 = "SELECT idDist,distrito FROM ubdistrito where idProv=".$p1;
                                            $result1234 = mysql_query($sql1234); 
                                                  if (mysql_num_rows($result1234) > 0){ 
                                                     while($fila1234 = mysql_fetch_assoc($result1234)){
                                                        $idDist = $fila1234['idDist'];
                                                        $distrito= $fila1234['distrito'];
                                             ?>
                                                    <option value="<?php echo $idDist; ?>"><?php echo $distrito; ?></option>
                                            <?php }} ?>
                                </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Distrito" name="dist1"> -->
                                <label></label><p></p>
                               <div class="col-sm-6 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>HASTA</label>
                                        <select class="form-control" name="dpt2" id="dpt2">
                                            <option disabled="" selected="">- Departamento -</option>
                                            <?php 
                                                $sql13 = "SELECT * FROM ubdepartamento";
                                                $result13 = mysql_query($sql13); 
                                                  if (mysql_num_rows($result13) > 0){ 
                                                     // Se recoge el número de resultados
                                                     // Se almacenan las cadenas de resultado
                                                     while($fila13 = mysql_fetch_assoc($result13)){
                                                        $iddepa1 = $fila13['idDepa'];
                                                        $depar1= $fila13['departamento'];
                                             ?>
                                                    <option value="<?php echo $iddepa1; ?>"><?php echo $depar1; ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                                <select class="form-control" name="prov2" id="prov2">
                                    <option value="">--PROVINCIA--</option>
                                     <?php 
                                            $sq123 = "SELECT idProv,provincia FROM ubprovincia where idDepa=".$d2;

                                            $resul123 = mysql_query($sq123); 
                                                  if (mysql_num_rows($resul123) > 0){ 
                                                     while($fil123 = mysql_fetch_assoc($resul123)){
                                                        $idProv2 = $fil123['idProv'];
                                                        $provincia2= $fil123['provincia'];
                                             ?>
                                                    <option value="<?php echo $idProv2; ?>"><?php echo $provincia2; ?></option>
                                            <?php }} ?>
                                </select>

                                <!-- <input type="text" class="form-control" id="moti" placeholder="Provincia" name="prov2"> -->

                                <p></p>
                                <select class="form-control" name="dist2" id="dist2">
                                    <option value="">--DISTRITO--</option>
                                    <?php 
                                            $sq1234 = "SELECT idDist,distrito FROM ubdistrito where idProv=".$p2;
                                            $resul1234 = mysql_query($sq1234); 
                                                  if (mysql_num_rows($resul1234) > 0){ 
                                                     while($fil1234 = mysql_fetch_assoc($resul1234)){
                                                        $idDist2 = $fil1234['idDist'];
                                                        $distrito2= $fil1234['distrito'];
                                             ?>
                                                    <option value="<?php echo $idDist2; ?>"><?php echo $distrito2; ?></option>
                                            <?php }} ?>
                                </select>
                                <!-- <input type="text" class="form-control" id="moti" placeholder="Distrito" name="dist2"> -->
                            </div>
                        </div>               
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Costo Pasajes - Clasificador 2.3.2.1.2.1</label>
                                <input type="text" class="form-control" id="pasaje" placeholder="0.00" name="pasajes" value="<?php echo $mon_pas; ?>">
                                <input type="hidden"  id="dni1" name="dni1" value="<?php echo $dni; ?>">
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1">
                            <div class="form-group">
                                <label>Meta</label>
                                <input type="text" class="form-control" id="meta" placeholder="Formato : 0000" name="meta" value="<?php echo $meta; ?>">
                            </div>
                        </div>                        
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Grabar '/>
                            </div>
                        </div>
                    </form>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>

    <script type="text/javascript">
    
    
    $("#medio").val('<?php echo $medio ?>');
    $("#dpt1").val('<?php echo $d1; ?>');
    $("#prov1").val('<?php echo $p1; ?>');
    $("#dist1").val('<?php echo $di1; ?>');

    $("#dpt2").val('<?php echo $d2; ?>');
    $("#prov2").val('<?php echo $p2; ?>');
    $("#dist2").val('<?php echo $di2; ?>');

    $("#dpt1").change(function(){

        var iddepa=$("#dpt1").val();

            $.ajax({
                 type: "POST",
                    url: "proceso.php",
                    data: 
                    {
                    "id": iddepa,
                    "opcion": 'provincia',
                    },
                    dataType: "html",
                    error: function(){
                          alert("error petición ajax");
                    },
                    success: function(data){
                           $("#prov1").html(data);
                      }
                  });
    })
    $("#prov1").change(function(){

        var iddepa=$("#prov1").val();

            $.ajax({
                 type: "POST",
                    url: "proceso.php",
                    data: 
                    {
                    "id": iddepa,
                    "opcion": 'distrito',
                    },
                    dataType: "html",
                    error: function(){
                          alert("error petición ajax");
                    },
                    success: function(data){
                           $("#dist1").html(data);
                      }
                  });
    })
    $("#dpt2").change(function(){

        var iddepa=$("#dpt2").val();

            $.ajax({
                 type: "POST",
                    url: "proceso.php",
                    data: 
                    {
                    "id": iddepa,
                    "opcion": 'provincia',
                    },
                    dataType: "html",
                    error: function(){
                          alert("error petición ajax");
                    },
                    success: function(data){
                           $("#prov2").html(data);
                      }
                  });
    })
    $("#prov2").change(function(){

        var iddepa=$("#prov2").val();

            $.ajax({
                 type: "POST",
                    url: "proceso.php",
                    data: 
                    {
                    "id": iddepa,
                    "opcion": 'distrito',
                    },
                    dataType: "html",
                    error: function(){
                          alert("error petición ajax");
                    },
                    success: function(data){
                           $("#dist2").html(data);
                      }
                  });
    })


    </script>

   </body>
   </html>   
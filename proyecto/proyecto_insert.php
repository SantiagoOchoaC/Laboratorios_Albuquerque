<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$codigo = $_POST["codigo"];
$fecha = $_POST["fecha"];
$valor = $_POST["valor"];
$receptor = isset($_POST["mi_receptor"]) && $_POST["mi_receptor"] !== "" ? $_POST["mi_receptor"] : "NULL";
$ejecutor = isset($_POST["mi_ejecutor"]) && $_POST["mi_ejecutor"] !== "" ? $_POST["mi_ejecutor"] : "NULL";

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `mantenimiento`(`codigo`,`fecha`, `valor`, `mi_receptor`, `mi_ejecutor`) VALUES ('$codigo', '$fecha', '$valor', $receptor, $ejecutor)";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: proyecto.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);
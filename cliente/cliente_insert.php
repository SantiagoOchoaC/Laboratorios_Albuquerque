<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$cedula = $_POST["cedula"];
$nombre = $_POST["nombre"];
$especialidad = $_POST["especialidad"];
$mi_contrato = isset($_POST["mi_contrato"]) && $_POST["mi_contrato"] !== "" ? $_POST["mi_contrato"] : "NULL";

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO `quimico`(`cedula`,`nombre`, `especialidad`,`mi_contrato`) VALUES ('$cedula', '$nombre', '$especialidad',$mi_contrato)";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: cliente.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);
<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Mecánicos con contrato, ≥2 reparaciones y nunca receptores</h1>

<p class="mt-3">
    Químicos que tienen contrato
    asociado, que han ejecutado al menos dos mantenimientos y que
    nunca han sido solicitantes.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
$query = "SELECT q.*
	  FROM quimico q
	  JOIN mantenimiento m ON q.cedula = m.mi_ejecutor
	  WHERE q.mi_contrato IS NOT NULL
  	  AND q.cedula NOT IN (
      		SELECT mi_receptor
      		FROM mantenimiento
      		WHERE mi_receptor IS NOT NULL
  	  )
	  GROUP BY q.cedula, q.nombre, q.especialidad, q.mi_contrato
	  HAVING COUNT(m.codigo) >= 2;
	  ";

// Ejecutar la consulta
$resultadoC2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC2 and $resultadoC2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Cédula</th>
                <th scope="col" class="text-center">Nombre</th>
		<th scope="col" class="text-center">Especialidad</th>
		<th scope="col" class="text-center">Contrato</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["cedula"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
		<td class="text-center"><?= $fila["especialidad"]; ?></td>
		<td class="text-center"><?= $fila["mi_contrato"]; ?></td>
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
else:
?>

<div class="alert alert-danger text-center mt-5">
    No se encontraron resultados para esta consulta
</div>

<?php
endif;

include "../includes/footer.php";
?>
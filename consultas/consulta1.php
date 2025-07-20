<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">3 Mantenimientos más caros sin químico ejecutor</h1>

<p class="mt-3">
    Debe mostrar los datos de los tres mantenimientos de mayor valor
    que no tienen químico ejecutor (en caso de empates, usted decide como
    proceder). Se debe mostrar para cada uno de estos tres mantenimientos los datos
    correspondientes del químico receptor.
</p>

<?php
// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
$query = "SELECT codigo,fecha,valor,cedula,nombre,especialidad,mi_contrato FROM mantenimiento, quimico WHERE quimico.cedula = mantenimiento.mi_receptor AND mantenimiento.mi_ejecutor IS NULL ORDER BY valor DESC LIMIT 3;";

// Ejecutar la consulta
$resultadoC1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<?php
// Verificar si llegan datos
if($resultadoC1 and $resultadoC1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código</th>
                <th scope="col" class="text-center">Fecha</th>
                <th scope="col" class="text-center">Valor</th>
                <th scope="col" class="text-center">Receptor</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Especialidad</th>
                <th scope="col" class="text-center">Contrato</th>
            
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoC1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha"]; ?></td>
                <td class="text-center">$<?= $fila["valor"]; ?></td>
                <td class="text-center">C.C. <?= $fila["cedula"]; ?></td>
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
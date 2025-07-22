<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Mantenimientos fuera de contrato por mecánico asociado</h1>

<p class="mt-3">
    Esta búsqueda recibe el código de un contrato y muestra todos los mantenimientos
    ejecutados por el mecánico asociado a dicho contrato pero siempre y cuando la
    fecha de dichas reparaciones esté por fuera del intervalo de fechas de dicho contrato.
</p>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda1.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="numero" class="form-label">Código de contrato</label>
            <input type="number" class="form-control" id="numero" name="numero" required>
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer eata verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    // Recibir el código de contrato del formulario
    $numero = $_POST["numero"];

    $query = "SELECT m.codigo, m.fecha, m.valor, m.mi_receptor, m.mi_ejecutor
                FROM mantenimiento m
                INNER JOIN quimico q ON m.mi_ejecutor = q.cedula
                INNER JOIN contrato c ON q.mi_contrato = c.codigo
                WHERE c.codigo = '$numero'
                AND (m.fecha < c.fecha_inicio OR m.fecha > c.fecha_fin);";

    // Ejecutar la consulta
    $resultadoB1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB1 and $resultadoB1->num_rows > 0):
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
                <th scope="col" class="text-center">Solicitante</th>
                <th scope="col" class="text-center">Ejecutor</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha"]; ?></td>
                <td class="text-center">$<?= $fila["valor"]; ?></td>
                <td class="text-center">C.C. <?= $fila["mi_receptor"]; ?></td>
                <td class="text-center">C.C. <?= $fila["mi_ejecutor"]; ?></td>
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
endif;

include "../includes/footer.php";
?>
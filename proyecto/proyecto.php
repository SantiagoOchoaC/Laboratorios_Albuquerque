<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Entidad análoga a REPARACION (MANTENIMIENTO)</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="proyecto_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="codigo" name="codigo" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" class="form-control" id="valor" name="valor" required>
        </div>
        
        <!-- Consultar la lista de quimicos y desplegarlos -->
        <div class="mb-3">
            <label for="mi_receptor" class="form-label">Solicitante</label>
            <select name="mi_receptor" id="mi_receptor" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../cliente/cliente_select.php");
                
                // Verificar si llegan datos
                if($resultadoCliente):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoCliente as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["cedula"]; ?>"><?= $fila["nombre"]; ?> - C.C. <?= $fila["cedula"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="mi_ejecutor" class="form-label">Ejecutor</label>
            <select name="mi_ejecutor" id="mi_ejecutor" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../cliente/cliente_select.php");
                
                // Verificar si llegan datos
                if($resultadoCliente):
                    
                    // Iterar sobre los registros que llegaron
                    foreach ($resultadoCliente as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["cedula"]; ?>"><?= $fila["nombre"]; ?> - C.C. <?= $fila["cedula"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("proyecto_select.php");
            
// Verificar si llegan datos
if($resultadoProyecto and $resultadoProyecto->num_rows > 0):
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
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoProyecto as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha"]; ?></td>
                <td class="text-center">$<?= $fila["valor"]; ?></td>
                <td class="text-center">C.C. <?= $fila["mi_receptor"]; ?></td>
                <td class="text-center">C.C. <?= $fila["mi_ejecutor"]; ?></td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="proyecto_delete.php" method="post">
                        <input hidden type="text" name="codigoEliminar" value="<?= $fila["codigo"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>
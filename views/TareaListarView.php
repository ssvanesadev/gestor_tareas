<?php include_once("common/cabecera.php"); ?>
<body>
    <h1>Listado de tareas</h1>
    <table>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (isset($tareas) && is_array($tareas) && count($tareas) > 0) {
            foreach ($tareas as $tarea) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($tarea->getTitulo()) ?></td>
                    <td><?php echo htmlspecialchars($tarea->getDescripcion()) ?></td>
                    <td><?php echo $tarea->getCompletada() ? 'Completada' : 'Pendiente' ?></td>
                    <td>
                        <a href="index.php?controlador=TareaController&accion=editar&id=<?php echo $tarea->getId() ?>">Editar</a>
                        |
                        <a href="index.php?controlador=TareaController&accion=borrar&id=<?php echo $tarea->getId() ?>" 
                           onclick="return confirm('¿Estás seguro?')">Borrar</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4">No hay tareas disponibles</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <br>
    <a href="index.php?controlador=TareaController&accion=nuevo">Nueva Tarea</a>
    
    <?php include_once("common/pie.php"); ?>
</body>
</html>
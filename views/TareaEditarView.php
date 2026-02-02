<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); ?>

<!-- Vista para editar una tarea -->

<body>
<h2>Editar Tarea</h2>
	
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="TareaController">
		<input type="hidden" name="accion" value="editar">
		<input type="hidden" name="id" value="<?php echo $tarea->getId(); ?>">

		<?php echo isset($errores["titulo"]) ? "*" : "" ?>
		<label for="titulo">Título</label>
		<input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($tarea->getTitulo()); ?>">
		<br>

		<?php echo isset($errores["descripcion"]) ? "*" : "" ?>
		<label for="descripcion">Descripción</label>
		<textarea name="descripcion" id="descripcion" rows="4" cols="50"><?php echo htmlspecialchars($tarea->getDescripcion()); ?></textarea>
		<br>

		<?php echo isset($errores["completada"]) ? "*" : "" ?>
		<label for="completada">Estado</label>
		<select name="completada" id="completada">
			<option value="0" <?php echo ($tarea->getCompletada() == 0) ? 'selected' : '' ?>>Pendiente</option>
			<option value="1" <?php echo ($tarea->getCompletada() == 1) ? 'selected' : '' ?>>Completada</option>
		</select>
		<br>
		<br>

		<input type="submit" name="submit" value="Actualizar">
		<a href="index.php?controlador=TareaController&accion=listar">Cancelar</a>
	</form>
	<br>

	<?php
	// Si hay errores los mostramos.
	if (isset($errores) && !empty($errores)):
		echo "<div style='color: red;'>";
		foreach ($errores as $key => $error):
			echo $error . "<br>";
		endforeach;
		echo "</div>";
	endif;
	?>

	<!-- Incluimos el pie de la página -->
	<?php include_once("common/pie.php"); ?>
</body>

</html>
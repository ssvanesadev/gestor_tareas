<!-- Incluimos la cabecera -->
<?php include_once("common/cabecera.php"); ?>

<!-- Vista para crear una nueva tarea -->

<body>
	<h2>Nueva Tarea</h2>
	
	<form action="index.php" method="post">
		<input type="hidden" name="controlador" value="TareaController">
		<input type="hidden" name="accion" value="nuevo">

		<?php echo isset($errores["titulo"]) ? "*" : "" ?>
		<label for="titulo">Título</label>
		<input type="text" name="titulo" id="titulo" value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : '' ?>">
		<br>

		<?php echo isset($errores["descripcion"]) ? "*" : "" ?>
		<label for="descripcion">Descripción</label>
		<textarea name="descripcion" id="descripcion" rows="4" cols="50"><?php echo isset($_POST['descripcion']) ? htmlspecialchars($_POST['descripcion']) : '' ?></textarea>
		<br>

		<?php echo isset($errores["completada"]) ? "*" : "" ?>
		<label for="completada">Estado</label>
		<select name="completada" id="completada">
			<option value="0" selected>Pendiente</option>
			<option value="1">Completada</option>
		</select>
		<br>
		<br>

		<input type="submit" name="submit" value="Crear Tarea">
		<a href="index.php?controlador=TareaController&accion=listar">Cancelar</a>
	</form>
	<br>

	<?php
	// Si hay errores se muestran
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
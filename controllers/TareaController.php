<?php
// Controlador para el modelo TareaModel (puede haber más controladores en la aplicación)
// Un controlador no tiene porque estar asociado a un objeto del modelo
class TareaController {
    // Atributo con el motor de plantillas del microframework
    protected $view;

    // Constructor. Únicamente instancia un objeto View y lo asigna al atributo
    function __construct() {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
    }

    // Método del controlador para listar las tareas almacenadas
    public function listar() {
        //Incluye el modelo que corresponde
        require_once 'models/TareaModel.php';

        //Creamos una instancia de nuestro "modelo"
        $tareas = new TareaModel();

        //Le pedimos al modelo todos los tareas
        $listado = $tareas->getAll();

        //Pasamos a la vista toda la información que se desea representar
        $data['tareas'] = $listado;

        // Finalmente presentamos nuestra plantilla 
        // Llamamos al método "show" de la clase View, que es el motor de plantillas
        // Genera la vista de respuesta a partir de la plantilla y de los datos
        $this->view->show("TareaListarView.php", $data);
    }

    // Método del controlador para crear una nueva tarea
    public function nuevo() {
        require_once 'models/TareaModel.php';
        $tarea = new TareaModel();

        $errores = array();

        if (isset($_REQUEST['submit'])) {
            // Validaciones
            if (!isset($_REQUEST['titulo']) || empty($_REQUEST['titulo']))
                $errores['titulo'] = "* Debes indicar un título.";

            // Si no hay errores, guardar en BD
            if (empty($errores)) {
                $tarea->setTitulo($_REQUEST['titulo']);
                $tarea->setDescripcion($_REQUEST['descripcion'] ?? '');
                $tarea->setCompletada($_REQUEST['completada'] ?? 0);
                $tarea->save();

                header("Location: index.php?controlador=TareaController&accion=listar");
                exit();
            }
        }

        $this->view->show("TareaNuevoView.php", array('errores' => $errores));
    }

    // Método que procesa la petición para editar un tarea
public function editar() {
    require_once 'models/TareaModel.php';
    $tareas = new TareaModel();

    // Recuperar la tarea con el ID recibido
    $tarea = $tareas->getById($_REQUEST['id']);

    if ($tarea == null) {
        $this->view->show("errorView.php", array('error' => 'No existe la tarea'));
        return;
    }

    $errores = array();

    // Si se ha pulsado el botón de actualizar
    if (isset($_REQUEST['submit'])) {
        // Validaciones
        if (!isset($_REQUEST['titulo']) || empty($_REQUEST['titulo']))
            $errores['titulo'] = "*Es obligatorio el título.";

        // Si no hay errores actualizamos en la BD
        if (empty($errores)) {
            $tarea->setTitulo($_REQUEST['titulo']);
            $tarea->setDescripcion($_REQUEST['descripcion'] ?? '');
            $tarea->setCompletada($_REQUEST['completada'] ?? 0);
            $tarea->save();

            header("Location: index.php?controlador=TareaController&accion=listar");
            exit();
        }
    }

    // Si no se ha pulsado el botón de actualizar se carga la vista para editar
    $this->view->show("TareaEditarView.php", array('tarea' => $tarea, 'errores' => $errores));
}

    // Método para borrar un tarea 
    public function borrar() {
        //Incluye el modelo que corresponde
        require_once 'models/TareaModel.php';

        //Creamos una instancia de nuestro "modelo"
        $tareas = new TareaModel();

        // Recupera el tarea con el código recibido por GET o por POST
        $tarea = $tareas->getById($_REQUEST['id']);

        if ($tarea == null) {
            $this->view->show("errorView.php", array('error' => 'No existe el código'));
        } else {
            // Si existe lo elimina de la base de datos y vuelve al inicio de la aplicación
            $tarea->delete();
            header("Location: index.php?controlador=TareaController&accion=listar");
            exit();
        }
    }
}
?>
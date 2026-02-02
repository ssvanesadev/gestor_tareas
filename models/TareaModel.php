<?php

// Clase del modelo para trabajar con objetos tarea que se almacenan en BD en la tabla tareas
class TareaModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto tarea que coinciden con los campos de la tabla tareas
    private $id;
    private $titulo;
    private $descripcion;
    private $completada;

    // Constructor que utiliza el patrón Singleton para tener una única instancia de la conexión a BD
    public function __construct()
    {
        //Traemos la única instancia de PDO
        $this->db = SPDO::singleton();
    }

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getCompletada()
    {
        return $this->completada;
    }
    public function setCompletada($completada)
    {
        $this->completada = $completada;
    }

    // Método para obtener todos los registros de la tabla tareas
    // Devuelve un array de objetos de la clase TareaModel
    public function getAll()
    {
        //realizamos la consulta de todos los tareas
        $consulta = $this->db->prepare('SELECT * FROM tareas');
        $consulta->execute();
        
        // OJO!! El fetchAll() funcionará correctamente siempre que el nombre
        // de los atributos de la clase coincida con los campos de la tabla
        $resultado = $consulta->fetchAll(PDO::FETCH_CLASS, "TareaModel");

        //devolvemos la colección para que la vista la presente.
        return $resultado;
    }

    // Método que devuelve (si existe en BD) un objeto TareaModel con un código determinado
    public function getById($id)
    {
        $gsent = $this->db->prepare('SELECT * FROM tareas WHERE id = ?');
        $gsent->bindParam(1, $id, PDO::PARAM_INT);
        $gsent->execute();

        $gsent->setFetchMode(PDO::FETCH_CLASS, "TareaModel");
        $resultado = $gsent->fetch();

        return $resultado;
    }

    // Método que almacena en BD un objeto TareaModel
    // Si tiene ya código actualiza el registro y si no tiene lo inserta
    public function save()
    {
        if (!isset($this->id) || empty($this->id)) {
            // INSERT - Nueva tarea
            $consulta = $this->db->prepare('INSERT INTO tareas(titulo, descripcion, completada) VALUES (?, ?, ?)');
            $consulta->bindParam(1, $this->titulo);
            $consulta->bindParam(2, $this->descripcion);
            $consulta->bindParam(3, $this->completada, PDO::PARAM_INT);
            $consulta->execute();
            
            // Obtener el ID generado automáticamente
            $this->id = $this->db->lastInsertId();
        } else {
            // UPDATE - Actualizar tarea existente
            $consulta = $this->db->prepare('UPDATE tareas SET titulo=?, descripcion=?, completada=? WHERE id=?');
            $consulta->bindParam(1, $this->titulo);
            $consulta->bindParam(2, $this->descripcion);
            $consulta->bindParam(3, $this->completada, PDO::PARAM_INT);
            $consulta->bindParam(4, $this->id, PDO::PARAM_INT);
            $consulta->execute();
        }
    }

    // Método que elimina el tareaModel de la BD
    public function delete()
    {
        $consulta = $this->db->prepare('DELETE FROM tareas WHERE id=?');
        $consulta->bindParam(1, $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }
}
?>
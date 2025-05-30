<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $db;

    public function __construct() //Este es el constructor de la clase.
    {
        $this->db = Database::connect(); //Inicializa la propiedad $db con una conexión a la base de datos utilizando el método estático connect de la clase Database.
    }

    //Método getAll(): Devuelve todos los usuarios.
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, description FROM categories"); //Ejecuta la consulta SQL y devuelve todos los resultados como un array asociativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //Devuelve todos los resultados como un array asociativo.
    }

    //Método create(): Crea una nueva categoría en la base de datos.
    public function create($name, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)"); //Prepara una consulta SQL para insertar un nuevo usuario en la base de datos.
        return $stmt->execute([$name, $description]); //Ejecuta la consulta SQL con los parámetros proporcionados.
    }

}
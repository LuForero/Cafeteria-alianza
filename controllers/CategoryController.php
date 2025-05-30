<?php
require_once __DIR__ . '/../models/Category.php'; // Requiere el modelo producto para interactuar con la base de datos.

class CategoryController
{

    private $categoryModel; // declara la propiedad, variable

    public function __construct() //contructor de la clase
    {
        $this->categoryModel = new Category;
    }
    public function index() //
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/categories/index.php';
    }

    public function create()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        include __DIR__ . '/../views/categories/create.php'; // incluir la vista de create
    }

    public function store($name, $description) //crear un registro
    {
        $errors = []; // Declara un array para almacenar errores de validación.

        if (empty($name)) { // Si el nombre está vacío
            $errors[] = "El nombre de la categoría es obligatoria."; // Agrega un mensaje de error al array.
        }

        if (empty($description)) { // Si la referencia está vacía
            $errors[] = "La descripción de la categoría es obligatoria."; // Agrega un mensaje de error al array
        }
        if (count($errors) > 0) { // Si hay errores de validación
            $oldData = ['name' => $name, 'description' => $description]; // Guarda los datos ingresados en un array para volver a mostrarlos en el formulario.
            include __DIR__ . '/../views/categories/create.php'; // Incluye la vista para mostrar el formulario de creación de un nuevo usuario con los datos ingresados.
        } else {
            $categoryModel = new Category(); // Crea una instancia del modelo producto para interactuar con la base de datos.
            $categoryModel->create($name, $description);

            header("Location: index.php?controller=category&action=index&success=1"); // Redirige a la lista de usuarios con un mensaje de éxito.
            exit;
        }
    }
}

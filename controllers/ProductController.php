<?php
require_once __DIR__ . '/../models/Product.php'; // Requiere el modelo producto para interactuar con la base de datos.
require_once __DIR__ . '/../models/Category.php'; // Requiere el modelo producto para interactuar con la base de datos.

class ProductController
{

    private $productModel; // declara la propiedad, variable

    public function __construct() //contructor de la clase
    {
        $this->productModel = new Product;
    }

    public function index() //
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $products = $this->productModel->getAll(); //accedemos a productos
        require_once __DIR__ . '/../views/products/index.php'; // llamando la vista de productos
    }

    public function create()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAll(); // Cargar categorías desde la base de datos

        $errors = [];
        $oldData = [];
        include __DIR__ . '/../views/products/create.php'; // incluir la vista de create
    }

    public function store($name, $reference, $price, $weight, $category_id, $stock) //crear un registro
    {
        $errors = []; // Declara un array para almacenar errores de validación.

        if (empty($name)) { // Si el nombre está vacío
            $errors[] = "El nombre es obligatorio."; // Agrega un mensaje de error al array.
        }

        if (empty($reference)) { // Si la referenciaestá vacío
            $errors[] = "La referencia es obligatoria."; // Agrega un mensaje de error al array
        }

        if (empty($price)) { // Si el peso está vacía
            $errors[] = "El precio es obligatorio."; // Agrega un mensaje de error al array.
        }

        if (empty($weight)) { // Si el rol está vacío
            $errors[] = "El peso es obligatorio."; // Agrega un mensaje de error al array.
        }

        if (empty($category_id)) { // Si la categoría está vacío
            $errors[] = "La categoría es obligatorio."; // Agrega un mensaje de error al array.
        }

        if (empty($stock)) { // Si el stock está vacío
            $errors[] = "El stock es obligatorio."; // Agrega un mensaje de error al array.
        }

        if (count($errors) > 0) { // Si hay errores de validación
            $oldData = ['name' => $name, 'reference' => $reference, 'price' => $price, 'weight' => $weight, 'stock' => $stock]; // Guarda los datos ingresados en un array para volver a mostrarlos en el formulario.
            include __DIR__ . '/../views/products/create.php'; // Incluye la vista para mostrar el formulario de creación de un nuevo usuario con los datos ingresados.
        } else {
            $productModel = new Product(); // Crea una instancia del modelo producto para interactuar con la base de datos.
            $productModel->create($name, $reference, $price, $weight, $category_id, $stock);

            header("Location: index.php?controller=product&action=index&success=1"); // Redirige a la lista de usuarios con un mensaje de éxito.
            exit;
        }
    }

    // Método edit(): Muestra el formulario para editar un producto existente.
    public function edit($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $productModel = new Product(); // Instancia del modelo Product
        $product = $productModel->find($id); // Busca el producto por su ID

        if (!$product) {
            die("Producto no encontrado.");
        }

        $categories = $productModel->getCategories(); // Obtiene todas las categorías

        include __DIR__ . '/../views/products/edit.php'; // Carga la vista de edición
    }

    // Procesa la actualización del producto
    public function update($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $errors = [];

        $name = $_POST['name'] ?? '';
        $reference = $_POST['reference'] ?? '';
        $price = $_POST['price'] ?? '';
        $weight = $_POST['weight'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $stock = $_POST['stock'] ?? '';

        // Validaciones
        if (empty($name)) $errors[] = "El nombre es obligatorio.";
        if (empty($reference)) $errors[] = "La referencia es obligatoria.";
        if (!is_numeric($price)) $errors[] = "El precio debe ser numérico.";
        if (!is_numeric($weight)) $errors[] = "El peso debe ser numérico.";
        if (!is_numeric($category_id)) $errors[] = "Seleccione una categoría válida.";
        if (!is_numeric($stock)) $errors[] = "El stock debe ser un número.";

        $productModel = new Product(); // ✅ Instanciar modelo antes de usarlo
        $categories = $productModel->getCategories(); // ✅ Obtener categorías después de instanciar

        if (!empty($errors)) {
            $product = compact('id', 'name', 'reference', 'price', 'weight', 'category_id', 'stock');
            include __DIR__ . '/../views/products/edit.php';
            return;
        }

        $productModel->update($id, $name, $reference, $price, $weight, $category_id, $stock);

        header("Location: index.php?controller=product&action=index&updated=true");
        exit;
    }
}
<?php
require_once __DIR__ . '/../config/database.php'; //conectamos con la base de datos

class Product // clase producto
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll() //traer todo 
    {
        $stmt = $this->db->query("SELECT products.id, products.name, products.reference, products.price, products.weight, products.category_id, products.stock, products.created_at, categories.name 
        AS category_name 
        FROM products 
        LEFT JOIN categories 
        ON products.category_id = categories.id 
        ORDER BY products.id DESC"); //union de dos tablas con el JOIN, 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $reference, $price, $weight, $category_id, $stock) //crear un registro
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, reference, price, weight, category_id, stock) VALUES (?, ?, ?, ?, ?, ?)"); //parametros que se reciben en la dase de datos (?) va a cada campo de ref
        return $stmt->execute([$name, $reference, $price, $weight, $category_id, $stock]);
    }
}

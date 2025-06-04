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

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    //Método find(): Busca un usuario por su ID.
    public function update($id, $name, $reference, $price, $weight, $category_id, $stock)
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, reference = ?, price = ?, weight = ?, category_id = ?, stock = ? WHERE id = ?");
        return $stmt->execute([$name, $reference, $price, $weight, $category_id, $stock, $id]);
    }
    public function getCategories()
    {
        $stmt = $this->db->query("SELECT id, name FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function increaseStock($product_id, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        return $stmt->execute([$quantity, $product_id]);
    }
}

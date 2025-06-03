<?php
require_once __DIR__ . '/../config/database.php';

class Sale
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createSale($product_id, $quantity)
    {
        try {
            $stmt = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $stock = $stmt->fetchColumn();

            if ($stock === false) return "Producto no encontrado.";
            if ($stock < $quantity) return "No hay suficiente stock disponible.";

            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO sales (product_id, quantity, sale_date) VALUES (?, ?, NOW())");
            $stmt->execute([$product_id, $quantity]);

            $stmt = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$quantity, $product_id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return "Error al registrar la venta.";
        }
    }

    public function getAll()
    {
        $sql = "SELECT s.*, p.name as product_name
            FROM sales s
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

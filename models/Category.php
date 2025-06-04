<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Obtener todas las categorías
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, description FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva categoría
    public function create($name, $description)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }

    // Buscar una categoría por ID
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar una categoría
    public function update($id, $name, $description)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }

    // Eliminar una categoría
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

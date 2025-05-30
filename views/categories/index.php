<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>
<h2>Listado de Categorías</h2>
<a href="index.php?controller=category&action=create" class="btn btn-success mb-2">Nueva Categoría</a>

<?php if (isset($_GET['success'])): ?><!-- Si se ha registrado una nueva categoría, se muestra un mensaje de éxito -->
    <div class="alert alert-success">Categoría registrada correctamente.</div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Categoría actualizada.</div>
<?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">Categoría eliminada.</div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td><?= htmlspecialchars($category['description']) ?></td>
                <td>
                    <a href="index.php?controller=category&action=edit&id=<?= $category['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?controller=category&action=delete&id=<?= $category['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
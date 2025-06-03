<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>
<h2>Listado de Categorías</h2>
<a href="index.php?controller=category&action=create" class="link-light link-opacity-60-hover btn btn-success mb-2 text-white" style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)">Nueva Categoría</a>

<?php if (isset($_GET['success'])): ?><!-- Si se ha registrado una nueva categoría, se muestra un mensaje de éxito -->
    <div class="alert alert-success">Categoría registrada correctamente.</div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Categoría actualizada.</div>
<?php elseif (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">Categoría eliminada.</div>
<?php endif; ?>
<div class="table-responsive shadow rounded">
    <table class="table table-hover table-striped align-middle text-center">
        <thead class="table-dark">
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
                        <div class="d-flex justify-content-center gap-2">
                            <a href="index.php?controller=category&action=edit&id=<?= $category['id'] ?>" class="link-dark link-opacity-60-hover btn btn-warning btn-sm text-white" style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)">Editar</a>
                            <a href="index.php?controller=category&action=delete&id=<?= $category['id'] ?>"
                                class="link-dark link-opacity-60-hover btn btn-danger btn-sm text-white" style="box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.36)"
                                onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                Eliminar
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
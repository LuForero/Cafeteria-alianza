<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<h2>Editar Producto</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?controller=product&action=update&id=<?= $product['id'] ?>">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control"
            value="<?= htmlspecialchars($product['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Referencia</label>
        <input type="text" name="reference" class="form-control"
            value="<?= htmlspecialchars($product['reference']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" name="price" class="form-control"
            value="<?= htmlspecialchars($product['price']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Peso</label>
        <input type="number" step="0.01" name="weight" class="form-control"
            value="<?= htmlspecialchars($product['weight']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="category_id" class="form-control" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control"
            value="<?= htmlspecialchars($product['stock']) ?>" required>
    </div>

    <button class="btn btn-primary">Actualizar Producto</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
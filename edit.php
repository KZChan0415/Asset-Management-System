<?php
require 'connect_db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    if ($quantity < 0) {
        $error = "Quantity cannot be negative.";
    } else {
        $sql = "UPDATE assets SET item_name = ?, category = ?, quantity = ?, status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$item_name, $category, $quantity, $status, $id])) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Error updating asset.";
        }
    }
}

$sql = "SELECT * FROM assets WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$asset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$asset) {
    die("Asset not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Asset</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="index.php" class="text-decoration-none text-secondary">
                <i class="bi bi-arrow-left me-1"></i> Cancel
            </a>
            <span class="badge bg-light text-secondary border">ID: #<?= $asset['id'] ?></span>
        </div>

        <div class="card overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-4 text-dark">Edit Asset</h3>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form method="post" action="edit.php?id=<?= $asset['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">ITEM NAME</label>
                        <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($asset['item_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">CATEGORY</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($asset['category']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">QUANTITY</label>
                        <input type="number" name="quantity" class="form-control" value="<?= $asset['quantity'] ?>" min="0" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">STATUS</label>
                        <select name="status" class="form-select">
                            <option value="In Stock" <?= $asset['status'] == 'In Stock' ? 'selected' : '' ?>>In Stock</option>
                            <option value="Low Stock" <?= $asset['status'] == 'Low Stock' ? 'selected' : '' ?>>Low Stock</option>
                            <option value="Out of Stock" <?= $asset['status'] == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
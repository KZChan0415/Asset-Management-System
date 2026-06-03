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
    $quantity = (int)$_POST['quantity'];
   
if ($quantity === 0) {
        $status = 'Out of Stock';
    } elseif ($quantity <= 10) {
        $status = 'Low Stock';
    } else {
        $status = 'In Stock';
    }

    if ($quantity < 0) {
        $error = "Quantity cannot be negative.";
    } else {
        $sql = "UPDATE assets SET item_name = ?, category = ?, quantity = ?, status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$item_name, $category, $quantity, $status, $id])) {
            $_SESSION['success'] = "Asset updated successfully.";
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
    <nav class="navbar bg-white shadow-sm mb-4 border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="index.php">
                <div class="bg-primary text-white rounded p-2 me-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                    <i class="bi bi-box-seam-fill fs-5"></i>
                </div>
                <span class="fs-4 fw-bolder text-dark" style="letter-spacing: -0.5px;">CPL<span class="text-primary">Assets</span></span>
            </a>
            
            <div class="d-flex align-items-center text-secondary">
                <i class="bi bi-person-circle fs-4"></i>
            </div>
        </div>
    </nav>

    <div class="container mt-3" style="max-width: 600px;">
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
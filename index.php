<?php
require 'connect_db.php';

$stmt = $pdo->query('SELECT * FROM assets');
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPL Assets</title>
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
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.002);
            transition: all 0.2s ease-in-out;
        }
        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 6px;
        }
        .btn-action {
            border-radius: 8px;
            padding: 0.35rem 0.6rem;
            background-color: transparent;
            border: 1px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        .btn-action.text-primary:hover {
            background-color: rgba(13, 110, 253, 0.1);
            border-color: rgba(13, 110, 253, 0.2);
            transform: translateY(-2px); 
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.1);
        }
        .btn-action.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            transform: translateY(-2px); 
            box-shadow: 0 4px 6px rgba(220, 53, 69, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-dark fw-bold mb-0">Asset Dashboard</h2>
                <p class="text-muted mb-0">Manage your e-commerce inventory</p>
            </div>
            <a href="add.php" class="btn btn-primary shadow-sm rounded-pill px-4 fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Add Asset
            </a>
        </div>
        
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold px-4 py-3">ID</th>
                            <th class="fw-semibold py-3">Item Name</th>
                            <th class="fw-semibold py-3">Category</th>
                            <th class="fw-semibold py-3">Qty</th>
                            <th class="fw-semibold py-3">Status</th>
                            <th class="fw-semibold py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td class="px-4 text-muted">#<?= $asset['id'] ?></td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($asset['item_name']) ?></td>
                            <td>
                                <span class="text-secondary">
                                    <i class="bi bi-tag me-1"></i><?= htmlspecialchars($asset['category']) ?: 'Uncategorized' ?>
                                </span>
                            </td>
                            <td><?= $asset['quantity'] ?></td>
                            <td>
                                <?php 
                                    if ($asset['status'] == 'In Stock') {
                                        echo '<span class="badge bg-success bg-opacity-10 text-success border border-success"><i class="bi bi-check-circle me-1"></i>In Stock</span>';
                                    } elseif ($asset['status'] == 'Low Stock') {
                                        echo '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning"><i class="bi bi-exclamation-triangle me-1"></i>Low Stock</span>';
                                    } else {
                                        echo '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>';
                                    }
                                ?>
                            </td>
                           <td class="text-end px-4">
                                <a href="edit.php?id=<?= $asset['id'] ?>" class="btn btn-action text-primary me-2" title="Edit Asset">
                                    <i class="bi bi-pen-fill fs-5"></i>
                                </a>
                                <a href="delete.php?id=<?= $asset['id'] ?>" class="btn btn-action text-danger" title="Delete Asset" onclick="return confirm('Are you sure you want to delete <?= htmlspecialchars($asset['item_name']) ?>?');">
                                    <i class="bi bi-trash3-fill fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
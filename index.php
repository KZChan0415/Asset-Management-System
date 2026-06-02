<?php
require 'connect_db.php';

$stmt = $pdo->query('SELECT * FROM assets');
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_assets = $pdo->query('SELECT COUNT(*) FROM assets')->fetchColumn();
$in_stock = $pdo->query("SELECT COUNT(*) FROM assets WHERE status = 'In Stock'")->fetchColumn();
$low_stock = $pdo->query("SELECT COUNT(*) FROM assets WHERE status = 'Low Stock'")->fetchColumn();
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

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 border-start border-success border-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-white p-3 border-start border-primary border-4">
                    <div class="text-secondary small fw-bold text-uppercase">Total Items</div>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= $total_assets ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-3 border-start border-success border-4">
                    <div class="text-secondary small fw-bold text-uppercase">In Stock</div>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= $in_stock ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white p-3 border-start border-warning border-4">
                    <div class="text-secondary small fw-bold text-uppercase">Low Stock</div>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= $low_stock ?></h3>
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="input-group shadow-sm rounded">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search assets by name...">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select shadow-sm">
                    <option value="">Filter by Status</option>
                    <option value="In Stock">In Stock</option>
                    <option value="Low Stock">Low Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold px-4 py-3 bg-primary text-white">ID</th>
                            <th class="fw-semibold py-3 bg-primary text-white">Item Name</th>
                            <th class="fw-semibold py-3 bg-primary text-white">Category</th>
                            <th class="fw-semibold py-3 bg-primary text-white">Qty</th>
                            <th class="fw-semibold py-3 bg-primary text-white">Status</th>
                            <th class="fw-semibold py-3 text-end px-4 bg-primary text-white">Actions</th>
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
                                <a href="javascript:void(0);" data-href="delete.php?id=<?= $asset['id'] ?>" class="btn btn-action text-danger delete-btn" title="Delete Asset">
                                    <i class="bi bi-trash3-fill fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                <h5 class="fw-semibold text-dark">No inventory items found</h5>
                                <p class="text-muted small">Your database is empty. Click the button below to provision your first asset record.</p>
                                <a href="add.php" class="btn btn-outline-primary btn-sm rounded-pill px-3 mt-2">
                                    <i class="bi bi-plus-lg me-1"></i> Add First Asset
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                })
            });
        });
    </script>
</body>
</html>
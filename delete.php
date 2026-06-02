<?php
require 'connect_db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM assets WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$id])) {
        $_SESSION['success'] = "Asset deleted successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting asset.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
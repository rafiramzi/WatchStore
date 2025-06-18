<?php
include("../db.php");

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
} else {
    die("No product ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Watch Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            margin: 0;
            height: 100%;
            padding: 20px;
        }
        .product-container {
            max-width: 800px;
            display: flex;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product-image {
            float: left;
            width: 300px;
            margin-right: 20px;
        }
        .product-details {
            overflow: hidden;
        }
        .product-name {
            font-size: 28px;
            font-weight: bold;
        }
        .product-price {
            color: #28a745;
            font-size: 24px;
            margin: 10px 0;
        }
        .product-description {
            font-size: 16px;
            line-height: 1.6;
        }
        .back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>

<div class="product-container">
    <img class="product-image" src="https://placehold.co/300x300?text=<?= urlencode($product['name']) ?>" alt="Product Image" />
    
    <div class="product-details">
        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
        <div class="product-price">$<?= htmlspecialchars($product['price']) ?></div>
        <div class="product-description"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
    </div>
</div>
    <a class="back-link" href="/">← Back to store</a>

</body>
</html>

<?php
include("db.php"); // Connects to database with `products` table
session_start();

$searchQuery = $_GET['search'] ?? '';

// 🔥 INTENTIONALLY VULNERABLE SQL (for testing with sqlmap)
$sql = ($searchQuery !== '')
    ? "SELECT * FROM products WHERE name LIKE '%$searchQuery%'"
    : "SELECT * FROM products";

// Execute query
$result = $conn->query($sql);

// Handle query failure gracefully
if (!$result) {
    die("<strong>SQL Error:</strong> " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Watch Store Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            margin: 10px 0;
            padding: 8px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main {
            flex: 1;
            padding: 20px 40px;
        }

        .search-bar {
            margin-bottom: 30px;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .search-bar button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            margin-left: 10px;
            cursor: pointer;
        }

        .search-result {
            margin-top: 20px;
            font-size: 18px;
        }

        .xss-box {
            background-color: #fff3cd;
            padding: 10px 15px;
            border: 1px solid #ffeeba;
            border-radius: 6px;
            margin-top: 10px;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .product-card h3 {
            margin: 10px 0 5px;
        }

        .product-card p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>WatchStore</h2>
    <a href="#">Cart</a>
    <a href="#">Ongoing</a>
    <a href="#">Accounts (<?php 
        session_start(); 
        echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; 
    ?>)</a>
    <a href="#">Address</a>
    <a href="#">Cards</a>
    <a href="#">Logout</a>
</div>


<div class="main">
    <form class="search-bar" method="GET">
        <input type="text" name="search" placeholder="Search watches..." value="<?= htmlspecialchars($searchQuery) ?>" />
        <button type="submit">Search</button>
    </form>

    <?php if ($searchQuery !== ''): ?>
        <div class="search-result">
            <strong>You searched for:</strong>
            <div class="xss-box">
                <?= $_GET['search'] ?> <!-- 🔥 XSS Vulnerable output -->
            </div>
        </div>
    <?php endif; ?>


    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="https://placehold.co/150x150?text=<?= urlencode($row['name']) ?>" alt="Watch Image">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p>$<?= htmlspecialchars($row['price']) ?></p>
                <p><small><?= htmlspecialchars($row['description']) ?></small></p>
                <button onclick="location.href='product/product.php?id=<?= $row['id'] ?>'">Buy</button>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>

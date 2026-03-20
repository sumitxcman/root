<?php

  // Sabhi tarah ke errors dikhane ke liye
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
// Error reporting on karein taaki exact galti dikhe agar ab bhi error aaye
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../include/load.php';
checkLogin();

// Database query
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();

include '../partials/head.php';
?>

<body>

<?php include '../partials/sidebar.php'; ?>

<div class="content">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h1>Manage Products</h1>

        <a href="add.php"
           style="background:green;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;">
           + Add Product
        </a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" width="100%" style="margin-top:20px;">
        
        <thead>
            <tr style="background:#eee;">
                <th width="120">Image</th>
                <th>Name</th>
                <th>Price</th>
                <th width="150">Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php if(count($products) > 0): ?>
            
            <?php foreach ($products as $p): ?>
            <tr>
                <td align="center">
                    <?php if(!empty($p['image'])): ?>
                        <img 
                            src="../assets/uploads/<?php echo htmlspecialchars($p['image']); ?>"
                            width="80"
                            height="80"
                            style="object-fit:cover;border-radius:8px;border:1px solid #ccc;">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>

                <td><?php echo htmlspecialchars($p['name']); ?></td>

                <td>$<?php echo htmlspecialchars($p['price']); ?></td>

                <td>
                    <a href="edit.php?id=<?php echo $p['id']; ?>">Edit</a> |
                    <a href="#"
                       onclick="deleteItem(<?php echo $p['id']; ?>,'products')"
                       style="color:red;">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="4" align="center">No Products Found</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</div>

<script src="../assets/js/app.js"></script>

</body>
</html>
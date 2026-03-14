
<?php
require '../include/load.php';
checkLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

   
    
    
    $targetDir = "../assets/uploads/";
    
   
    $fileName = time() . "_" . basename($_FILES["image"]["name"]); 
    $targetFile = $targetDir . $fileName;
    $uploadOk = true;

    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        $error = "File is not an image.";
        $uploadOk = false;
    }

    
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            
            try {
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $desc, $price, $fileName]); // Note: We save $fileName, not the file itself
                redirect('index.php');
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}

include '../partials/head.php';
?>

<body>
    <?php include '../partials/sidebar.php'; ?>
    <div class="content">
        <h2>Add New Product</h2>
        <?php if($error): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            
            <label>Product Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Price ($):</label><br>
            <input type="number" step="0.01" name="price" required><br><br>

            <label>Description:</label><br>
            <textarea name="description"></textarea><br><br>

            <label>Product Image:</label><br>
            <input type="file" name="image" required><br><br>

            <button type="submit">Upload Product</button>
        </form>
    </div>
</body>

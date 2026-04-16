<?php
require_once __DIR__ . '/../include/load.php'; 
if (function_exists('check_login')) check_login();

if ($_SESSION['role'] !== 'admin') {
    die("Access Denied");
}

$error = "";
$success = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found!");
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // Check if new image uploaded
    $image_name = $product['image'];
    if (!empty($_FILES["product_image"]["name"])) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
        if (in_array($file_extension, $allowed_extensions)) {
            $check = @getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check !== false) {
                $target_dir = "../assets/uploads/";
                $new_image_name = time() . "_" . uniqid() . "." . $file_extension;
                $target_file = $target_dir . $new_image_name;
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    $image_name = $new_image_name; // update memory
                }
            }
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=?, category=? WHERE id=?");
    if($stmt->execute([$name, $desc, $price, $image_name, $category, $id])) {
        $success = "Product updated successfully!";
        // Refresh product data
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $error = "Failed to update product.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | MY SHOP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }
        .main-content { width: 100%; max-width: 1200px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; }
        .lux-card { background: #0f172a; border-radius: 24px; padding: 30px; border: 1px solid rgba(255,255,255,0.05); }
        .lux-input { width: 100%; background: #0f172a; border: 1px solid #334155; border-radius: 12px; padding: 14px; color: white; outline: none; transition: 0.3s; }
        .lux-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="antialiased">

    <div class="main-content p-10">
        <form method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
            <header class="mb-10 flex justify-between items-center bg-[#1e293b] p-6 rounded-[2rem] border border-slate-800 shadow-xl">
                <div class="flex items-center gap-6">
                    <img src="../assets/uploads/<?= htmlspecialchars($product['image']) ?>" class="w-16 h-16 rounded-2xl object-cover bg-slate-900 border border-slate-700">
                    <div>
                        <h2 class="text-2xl font-black text-white uppercase tracking-tighter">Edit Product</h2>
                        <p class="text-slate-400 text-xs mt-1">Editing ID: #<?= str_pad($id, 4, '0', STR_PAD_LEFT) ?></p>
                    </div>
                </div>
                <button type="submit" name="update_product" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-all shadow-xl shadow-purple-600/20 flex items-center gap-2">
                    <iconify-icon icon="solar:diskette-bold"></iconify-icon> Save Changes
                </button>
            </header>

            <?php if($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl mb-6 text-sm font-bold"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 rounded-xl mb-6 text-sm font-bold"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="lux-card space-y-6">
                        <h3 class="font-bold text-xl text-white flex items-center gap-2">
                            <iconify-icon icon="solar:document-text-bold" class="text-purple-500"></iconify-icon> Product Details
                        </h3>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Product Title</label>
                            <input type="text" name="name" class="lux-input" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Description</label>
                            <textarea name="description" class="lux-input" rows="5" required><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="lux-card space-y-6">
                        <h3 class="font-bold text-xl text-white flex items-center gap-2">
                            <iconify-icon icon="solar:tag-price-bold" class="text-emerald-500"></iconify-icon> Pricing & Media
                        </h3>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Category</label>
                            <input type="text" name="category" class="lux-input" value="<?= htmlspecialchars($product['category'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Price (₹)</label>
                            <input type="number" name="price" class="lux-input text-emerald-400 font-black text-lg" value="<?= htmlspecialchars($product['price']) ?>" required>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Replace Image (Optional)</label>
                            <label class="block border-2 border-dashed border-slate-700 bg-[#0f172a] p-8 rounded-2xl text-center hover:border-purple-500 hover:bg-[#1e293b] cursor-pointer transition-all group">
                                <iconify-icon icon="solar:gallery-send-bold-duotone" class="text-4xl text-slate-500 group-hover:text-purple-500 mb-2 transition-colors"></iconify-icon>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Click to Upload New</p>
                                <input type="file" name="product_image" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
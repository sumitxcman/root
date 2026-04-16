<?php
require_once __DIR__ . '/../include/load.php'; 
if (function_exists('check_login')) check_login();

if ($_SESSION['role'] !== 'admin') {
    die("Access Denied");
}

$error = "";
$success = "";

// Handle product addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $file_extension = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));
    
    if (in_array($file_extension, $allowed_extensions)) {
        $check = @getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $target_dir = "../assets/uploads/";
            if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $image_name = time() . "_" . uniqid() . "." . $file_extension;
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
                if($stmt->execute([$name, $desc, $price, $image_name, $category])) {
                    $success = "Product published successfully!";
                } else {
                    $error = "Failed to add product to database.";
                }
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid image file.";
        }
    } else {
        $error = "Invalid extension.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product | MY SHOP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0b1121; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background-color: #111827; position: fixed; left: 0; top: 0; border-right: 1px solid #1e293b; z-index: 100; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; }
        .lux-card { background: #1e293b; border-radius: 24px; padding: 30px; border: 1px solid rgba(255,255,255,0.05); }
        .lux-input { width: 100%; background: #0f172a; border: 1px solid #334155; border-radius: 12px; padding: 14px; color: white; outline: none; transition: 0.3s; }
        .lux-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="flex overflow-x-hidden">

    <aside class="sidebar p-6 flex flex-col">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                <iconify-icon icon="solar:shop-bold-duotone" class="text-2xl text-white"></iconify-icon>
            </div>
            <h1 class="text-white text-xl font-black tracking-tighter uppercase">MY SHOP</h1>
        </div>
        <nav class="space-y-4">
            <a href="../dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <iconify-icon icon="solar:widget-5-bold-duotone" class="text-xl"></iconify-icon> Dashboard
            </a>
            <a href="index.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <iconify-icon icon="solar:box-bold-duotone" class="text-xl"></iconify-icon> View Catalog
            </a>
            <a href="add.php" class="flex items-center gap-3 px-4 py-3 bg-blue-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20 transition-all">
                <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon> Add Product
            </a>
        </nav>
    </aside>

    <div class="main-content p-10">
        <form method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
            <header class="mb-10 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Add New Product</h2>
                    <p class="text-slate-400 text-sm mt-1">Publish a premium item to your catalog.</p>
                </div>
                <button type="submit" name="add_product" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-all shadow-xl shadow-blue-600/20 flex items-center gap-2">
                    <iconify-icon icon="solar:upload-bold"></iconify-icon> Publish Product
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
                            <iconify-icon icon="solar:document-text-bold" class="text-blue-500"></iconify-icon> Product Details
                        </h3>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Product Title</label>
                            <input type="text" name="name" class="lux-input" placeholder="e.g. Rolex Cosmograph Daytona" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Description</label>
                            <textarea name="description" class="lux-input" rows="5" placeholder="Detailed product specifications..." required></textarea>
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
                            <input type="text" name="category" class="lux-input" placeholder="e.g. Watches">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Price (₹)</label>
                            <input type="number" name="price" class="lux-input text-emerald-400 font-black text-lg" placeholder="0.00" required>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest pl-1 block mb-2">Product Image</label>
                            <label class="block border-2 border-dashed border-slate-700 bg-[#0f172a] p-8 rounded-2xl text-center hover:border-blue-500 hover:bg-[#1e293b] cursor-pointer transition-all group">
                                <iconify-icon icon="solar:gallery-send-bold-duotone" class="text-4xl text-slate-500 group-hover:text-blue-500 mb-2 transition-colors"></iconify-icon>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Click to Upload</p>
                                <input type="file" name="product_image" class="hidden" required accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
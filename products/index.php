<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database include (Path fix: products folder se bahar nikalne ke liye ../)
include_once '../include/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

// 3. Form Submission Logic (New Product Add karne ke liye)
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
            $image_name = time() . "_" . uniqid() . "." . $file_extension;
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $desc, $price, $image_name, $category]);
                header("Location: index.php?success=1");
                exit();
            }
        }
    }
}

// 4. Products Fetch logic
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - My Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: #94a3b8; margin: 0; }
        .sidebar { width: 260px; height: 100vh; background-color: #111827; position: fixed; left: 0; top: 0; border-right: 1px solid #1e293b; z-index: 100; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; }
        .sidebar-link.active { background: #0ea5e9; color: white !important; box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.2); }
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
        <nav class="space-y-6">
            <a href="../dashboard.php" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-400 hover:text-white transition-all">
                <iconify-icon icon="solar:widget-5-bold-duotone" class="text-xl"></iconify-icon>
                Dashboard
            </a>
            <div class="space-y-2">
                <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Store Management</p>
                <a href="index.php" class="sidebar-link active flex items-center justify-between px-4 py-2.5 text-white rounded-xl text-sm border border-slate-700/30">
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="solar:box-bold-duotone" class="text-lg"></iconify-icon> Catalog
                    </div>
                </a>
            </div>
        </nav>
    </aside>

    <main class="main-content p-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase">Inventory Catalog</h1>
                <p class="text-sm text-slate-500 mt-1">Total Items: <span class="text-blue-400 font-bold"><?= count($products) ?></span></p>
            </div>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-600/20 transition-all">
                <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
                Add Product
            </button>
        </div>

        <div class="bg-[#111827] rounded-[2rem] border border-slate-800 shadow-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1e293b]/30 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 border-b border-slate-800">
                        <th class="p-6">Thumbnail</th>
                        <th class="p-6">Product Information</th>
                        <th class="p-6">Category</th>
                        <th class="p-6 text-center">Price</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $prod): 
                            // CORRECT PATH: assets/uploads
                            $imgPath = "../assets/uploads/" . ($prod['image'] ?: 'default.png');
                        ?>
                        <tr class="hover:bg-white/[0.02] transition-all group">
                            <td class="p-6">
                                <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-slate-700 overflow-hidden shadow-lg">
                                    <img src="<?= $imgPath ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-all duration-500" 
                                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($prod['name']) ?>&background=1e293b&color=3b82f6'">
                                </div>
                            </td>
                            <td class="p-6">
                                <p class="text-white font-bold text-sm"><?= htmlspecialchars($prod['name']) ?></p>
                                <p class="text-[10px] text-slate-500 mt-1 line-clamp-1"><?= htmlspecialchars($prod['description'] ?: 'No description.') ?></p>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                    <?= htmlspecialchars($prod['category'] ?? 'General') ?>
                                </span>
                            </td>
                            <td class="p-6 text-center font-bold text-white">
                                ₹<?= number_format((float)$prod['price']) ?>
                            </td>
                            <td class="p-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-500/10 text-blue-500 hover:bg-blue-600 hover:text-white transition-all">
                                        <iconify-icon icon="solar:pen-bold" class="text-xl"></iconify-icon>
                                    </button>
                                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white transition-all">
                                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-xl"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="p-20 text-center text-slate-600 italic">No products available in the database.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-[200] p-4 backdrop-blur-sm">
        <div class="bg-[#111827] border border-slate-800 w-full max-w-lg rounded-[2.5rem] p-10 relative shadow-2xl">
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-500 hover:text-white transition-colors">
                <iconify-icon icon="solar:close-circle-bold" class="text-3xl"></iconify-icon>
            </button>
            
            <h3 class="text-2xl font-black text-white mb-8 uppercase tracking-tighter">New Product</h3>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-5">
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-500 mb-2 block tracking-widest">Product Name</label>
                    <input type="text" name="name" required class="w-full bg-[#0f172a] border border-slate-800 rounded-2xl p-4 text-white outline-none focus:border-blue-500 transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-500 mb-2 block tracking-widest">Price (₹)</label>
                        <input type="number" name="price" required class="w-full bg-[#0f172a] border border-slate-800 rounded-2xl p-4 text-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-500 mb-2 block tracking-widest">Category</label>
                        <input type="text" name="category" class="w-full bg-[#0f172a] border border-slate-800 rounded-2xl p-4 text-white outline-none focus:border-blue-500">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-500 mb-2 block tracking-widest">Upload Image</label>
                    <input type="file" name="product_image" required class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>
                <button type="submit" name="add_product" class="w-full bg-blue-600 text-white font-black py-5 rounded-2xl mt-4 shadow-xl shadow-blue-600/20 hover:bg-blue-700 transition-all uppercase tracking-widest">Add to Catalog</button>
            </form>
        </div>
    </div>

</body>
</html>
<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Error reporting (Production mein isay off rakhte hain)
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    include '../include/config.php'; 
    include '../include/db.php'; 
    include '../include/auth.php';

    // Current logged-in user ka data nikalna
    $user_id = $_SESSION['user_id'] ?? 0;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Agar user nahi mila toh empty array set karein taake error na aaye
    if (!$user) {
        $user = ['fullname' => '', 'phone' => '', 'email' => '', 'image' => 'default.png'];
    }

    $title = 'System Settings';
?>

<?php include '../partials/header.php'; ?>

<body class="bg-[#0f172a] font-sans text-white antialiased">
    <div class="flex min-h-screen">
        
        <?php include '../partials/sidebar.php'; ?>

        <main class="flex-1 ml-72 bg-[#0f172a]">
            <div class="flex justify-between items-center p-6 border-b border-slate-800 bg-[#1e293b]/20">
                <h1 class="text-xl font-bold tracking-tight text-white uppercase italic">System Configuration</h1>
                <div class="flex items-center gap-2 text-[10px] text-slate-500 font-black uppercase tracking-widest">
                    <iconify-icon icon="solar:settings-minimalistic-bold-duotone"></iconify-icon>
                    <span>Terminal</span>
                    <span>/</span>
                    <span class="text-blue-500">Settings</span>
                </div>
            </div>

            <div class="max-w-5xl mx-auto p-10">
                <div class="grid grid-cols-12 gap-10">
                    
                    <div class="col-span-12 lg:col-span-7">
                        <div class="bg-[#1e293b]/40 border border-slate-800 rounded-xl p-8 shadow-2xl">
                            <h2 class="text-sm font-black uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                Profile Information
                            </h2>
                            
                            <form action="process_settings.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                                <input type="hidden" name="action" value="update_profile">

                                <div class="flex items-center gap-6 pb-6 border-b border-slate-800/50">
                                    <div class="relative group">
                                        <div class="w-20 h-20 rounded-full bg-slate-800 border-2 border-slate-700 overflow-hidden">
                                            <img id="preview" src="../assets/images/users/<?= $user['image'] ?: 'default.png' ?>" class="w-full h-full object-cover">
                                        </div>
                                        <label class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity rounded-full">
                                            <iconify-icon icon="solar:camera-add-bold" class="text-xl"></iconify-icon>
                                            <input type="file" name="profile_img" class="hidden" onchange="previewImage(event)">
                                        </label>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-bold uppercase tracking-widest">Profile Photo</h3>
                                        <p class="text-[10px] text-slate-500 mt-1 uppercase">Recommended: 250x250px</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6 pt-4">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Display Name</label>
                                        <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" 
                                            class="bg-[#0f172a] border border-slate-800 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all">
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Phone Line</label>
                                        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                                            class="bg-[#0f172a] border border-slate-800 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Email Address</label>
                                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                        class="bg-[#0f172a] border border-slate-800 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all">
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] uppercase tracking-[0.2em] py-4 rounded-lg shadow-lg shadow-blue-900/20 transition-all">
                                    Sync Profile Data
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>
            </div>
        </main>
    </div>
</body>
</html>
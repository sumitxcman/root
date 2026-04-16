<?php 
    session_start();
    include '../include/config.php'; 
    include '../include/db.php'; 
    include '../include/auth.php';

    // URL se ID lena
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $user_data = null;

    if ($id) {
        // Database se user ka purana data nikalna
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        $user_data = $stmt->fetch();
    }

    if (!$user_data) {
        die("User not found!");
    }

    $title = 'Edit User';
?>

<?php include '../partials/header.php'; ?>

<body class="bg-[#0f172a] font-sans text-white antialiased">
    <div class="flex min-h-screen">
        
        <?php include '../partials/sidebar.php'; ?>

        <main class="flex-1 ml-72 bg-[#0f172a]">
            <div class="flex justify-between items-center p-6 border-b border-slate-800 bg-[#1e293b]/20">
                <h1 class="text-xl font-bold tracking-tight">Edit User</h1>
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <iconify-icon icon="solar:home-smile-angle-outline"></iconify-icon>
                    <span>Dashboard</span>
                    <span>-</span>
                    <span class="text-blue-500">Edit User</span>
                </div>
            </div>

            <div class="max-w-4xl mx-auto p-10">
                <div class="bg-[#1e293b]/40 border border-slate-800 rounded-xl p-10 shadow-xl">
                    
                    <form action="update_user.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                        <input type="hidden" name="user_id" value="<?= $user_data['id'] ?>">

                        <div class="flex flex-col items-center mb-10">
                            <label class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-4">Current Profile Image</label>
                            <div class="relative group">
                                <div class="w-36 h-36 rounded-full bg-slate-700 border-4 border-slate-800 overflow-hidden flex items-center justify-center relative shadow-2xl">
                                    <?php 
                                        $img_path = !empty($user_data['image']) ? "../assets/images/users/".$user_data['image'] : "https://via.placeholder.com/150";
                                    ?>
                                    <img id="preview" src="<?= $img_path ?>" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                        <iconify-icon icon="solar:pen-new-square-linear" class="text-3xl text-white"></iconify-icon>
                                    </div>
                                </div>
                                <input type="file" name="profile_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                            </div>
                            <p class="text-[10px] text-slate-500 mt-3 uppercase tracking-tighter">Click image to change</p>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Full Name *</label>
                                <input type="text" name="fullname" value="<?= htmlspecialchars($user_data['fullname']) ?>" required
                                    class="bg-[#0f172a] border border-slate-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email *</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" required
                                    class="bg-[#0f172a] border border-slate-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Phone</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user_data['phone']) ?>"
                                    class="bg-[#0f172a] border border-slate-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Department *</label>
                                <select name="department" required
                                    class="bg-[#0f172a] border border-slate-700 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all text-slate-300">
                                    <option value="IT" <?= $user_data['department'] == 'IT' ? 'selected' : '' ?>>IT Department</option>
                                    <option value="Sales" <?= $user_data['department'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
                                    <option value="Marketing" <?= $user_data['department'] == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <a href="users-list.php" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white text-center font-bold py-4 rounded-lg transition-all uppercase tracking-widest text-xs">
                                Cancel
                            </a>
                            <button type="submit" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg shadow-lg shadow-blue-900/20 transition-all uppercase tracking-widest text-xs">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
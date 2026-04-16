<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<aside class="w-64 h-screen bg-[#0f172a] text-gray-400 fixed left-0 top-0 z-50 flex flex-col border-r border-slate-800/50 shadow-2xl" 
       x-data="{ openUsers: false, openAuth: false }">
    
    <div class="p-8">
        <h1 class="text-white text-2xl font-black tracking-tighter uppercase italic">MY SHOP</h1>
    </div>

    <nav class="flex-1 px-4 space-y-4 overflow-y-auto custom-scrollbar">
        
        <div class="px-2">
            <a href="index.php?page=dashboard" 
               class="flex items-center gap-3 <?php echo (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'bg-[#0ea5e9] text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:bg-slate-800/40 hover:text-white'; ?> px-5 py-3.5 rounded-2xl font-bold transition-all hover:scale-[1.02]">
                <iconify-icon icon="solar:widget-5-bold-duotone" class="text-2xl"></iconify-icon>
                <span class="text-sm">Dashboard Overview</span>
            </a>
        </div>

        <div class="space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 px-5 mb-4">Store Management</p>
            
            <a href="index.php?page=catalog" class="flex items-center gap-3 text-slate-400 px-5 py-3.5 rounded-2xl hover:bg-slate-800/40 hover:text-white transition-all group">
                <iconify-icon icon="solar:folder-with-files-bold-duotone" class="text-xl group-hover:text-blue-400"></iconify-icon>
                <span class="font-medium text-sm">Catalog</span>
            </a>

            <div class="px-2">
                <button @click="openUsers = !openUsers" 
                        :class="openUsers ? 'bg-[#3b82f6] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/40'"
                        class="w-full flex items-center justify-between px-5 py-3.5 rounded-2xl transition-all group">
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="solar:users-group-rounded-bold" class="text-xl"></iconify-icon>
                        <span class="font-semibold text-sm">Users</span>
                    </div>
                    <iconify-icon :icon="openUsers ? 'solar:alt-arrow-up-linear' : 'solar:alt-arrow-down-linear'" class="text-[10px]"></iconify-icon>
                </button>
                
                <div x-show="openUsers" x-transition class="mt-2 ml-6 space-y-2 border-l border-slate-700/50 pl-4">
                    <a href="index.php?page=users-list" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Users List
                    </a>
                    <a href="index.php?page=users-grid" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span> Users Grid
                    </a>
                    <a href="index.php?page=add-user" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Add User
                    </a>
                    <a href="index.php?page=profile" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span> View Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 px-5 mb-4">Application</p>
            
            <div class="px-2">
                <button @click="openAuth = !openAuth" 
                        :class="openAuth ? 'bg-[#3b82f6] text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/40'"
                        class="w-full flex items-center justify-between px-5 py-3.5 rounded-2xl transition-all group">
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="solar:lock-password-bold" class="text-xl"></iconify-icon>
                        <span class="font-semibold text-sm">Authentication</span>
                    </div>
                    <iconify-icon :icon="openAuth ? 'solar:alt-arrow-up-linear' : 'solar:alt-arrow-down-linear'" class="text-[10px]"></iconify-icon>
                </button>
                
                <div x-show="openAuth" x-transition class="mt-2 ml-6 space-y-2 border-l border-slate-700/50 pl-4">
                    <a href="sign-in.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Sign In
                    </a>
                    <a href="sign-up.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span> Sign Up
                    </a>
                    <a href="forgot-password.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Forgot Password
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 px-5 mb-4">Support</p>
            <a href="index.php?page=faq" class="flex items-center gap-3 text-slate-400 px-5 py-3.5 rounded-2xl hover:bg-slate-800/40 hover:text-white transition-all">
                <iconify-icon icon="solar:question-circle-linear" class="text-xl"></iconify-icon>
                <span class="font-medium text-sm">FAQs.</span>
            </a>
            <a href="index.php?page=404" class="flex items-center gap-3 text-slate-400 px-5 py-3.5 rounded-2xl hover:bg-slate-800/40 hover:text-white transition-all">
                <iconify-icon icon="solar:sad-circle-linear" class="text-xl"></iconify-icon>
                <span class="font-medium text-sm">404</span>
            </a>
            <a href="index.php?page=terms" class="flex items-center gap-3 text-slate-400 px-5 py-3.5 rounded-2xl hover:bg-slate-800/40 hover:text-white transition-all">
                <iconify-icon icon="solar:info-circle-linear" class="text-xl"></iconify-icon>
                <span class="font-medium text-sm">Terms & Conditions</span>
            </a>
        </div>
    </nav>

    <div class="p-6 border-t border-slate-800/50">
        <a href="logout.php" class="flex items-center gap-3 px-5 py-4 text-red-400 bg-red-400/5 hover:bg-red-400 hover:text-white rounded-2xl transition-all group font-bold">
            <iconify-icon icon="solar:logout-3-bold-duotone" class="text-xl group-hover:translate-x-1 transition-transform"></iconify-icon>
            <span class="text-sm">Logout</span>
        </a>
    </div>
</aside>
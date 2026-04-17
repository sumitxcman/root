<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'include/load.php';
    $title = 'Terms & Conditions - Modest Mission';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; }
        .glass-header { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid #1e293b; }
        .lux-card { background: #0f172a; border: 1px solid #1e293b; border-radius: 2rem; padding: 3rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        h1, h2, h3 { color: white; font-weight: 800; }
        p { margin-bottom: 1.5rem; line-height: 1.8; }
        .accent-line { width: 40px; height: 4px; background: #3b82f6; border-radius: 2px; margin-bottom: 2rem; }
    </style>
</head>
<body class="antialiased min-h-screen">

    <header class="glass-header sticky top-0 z-50 h-[80px] flex items-center px-12 justify-between">
        <a href="index.php" class="text-white text-2xl font-black italic tracking-tighter">MODEST MISSION</a>
        <a href="dashboard.php" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition">Back to Dashboard</a>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-20">
        <div class="lux-card">
            <h1 class="text-5xl tracking-tighter mb-4">Terms & Conditions</h1>
            <div class="accent-line"></div>
            
            <section class="mb-12">
                <h2 class="text-2xl mb-4">1. Acceptance of Terms</h2>
                <p>By accessing and using this application, you agree to be bound by these Terms and Conditions. Our services are provided to you conditioned on your acceptance without modification of the terms, conditions, and notices contained herein.</p>
            </section>

            <section class="mb-12">
                <h2 class="text-2xl mb-4">2. User Accounts</h2>
                <p>When you create an account with us, you must provide information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>
                <p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>
            </section>

            <section class="mb-12">
                <h2 class="text-2xl mb-4">3. Premium Goods & Shipping</h2>
                <p>All items sold on Modest Mission are guaranteed authentic. Shipping is performed via ultra-premium logistics partners. We are not responsible for delays caused by customs or international trade regulations beyond our control.</p>
            </section>

            <section class="mb-12">
                <h2 class="text-2xl mb-4">4. Privacy Policy</h2>
                <p>Your privacy is of the utmost importance to us. Please refer to our Privacy Policy to understand how we collect, use, and share your personal information. We implement military-grade encryption for all sensitive user data.</p>
            </section>

            <div class="border-t border-slate-800 pt-10 text-center">
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Last Updated: October 2025</p>
            </div>
        </div>
    </main>

</body>
</html>

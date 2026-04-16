<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/include/load.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frequently Asked Questions | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Outfit', sans-serif; }
        .glass-header { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid #1e293b; }
        .faq-card { background: #0f172a; border: 1px solid #1e293b; border-radius: 16px; cursor: pointer; transition: 0.3s; }
        .faq-card:hover { border-color: #3b82f6; }
        .faq-answer { display: none; padding-top: 16px; color: #94a3b8; font-size: 14px; line-height: 1.6; border-top: 1px solid #1e293b; margin-top: 16px; }
        .faq-card.open .faq-answer { display: block; }
        .faq-card.open { border-color: #3b82f6; box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.2); }
        .faq-card.open .icon-toggle { transform: rotate(180deg); color: #3b82f6; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="glass-header sticky top-0 z-50 h-[80px] flex items-center px-8 justify-between">
        <a href="index.php" class="text-white text-2xl font-black italic">MY SHOP <span class="not-italic text-sm text-blue-500 align-top ml-1">Support</span></a>
        <a href="dashboard.php" class="text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition">Dashboard Console</a>
    </header>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-20 relative">
        <!-- Glow Effect -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>

        <div class="text-center mb-16">
            <h1 class="text-5xl font-black text-white tracking-tighter mb-4">How can we help?</h1>
            <p class="text-slate-400 text-lg">Browse our premium support knowledge base.</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ List -->
            <div class="faq-card p-6" onclick="this.classList.toggle('open')">
                <div class="flex justify-between items-center">
                    <h3 class="text-white font-bold text-lg">What are your shipping methods?</h3>
                    <iconify-icon icon="solar:alt-arrow-down-bold" class="text-slate-500 icon-toggle transition-transform"></iconify-icon>
                </div>
                <div class="faq-answer">
                    We offer fully insured, overnight shipping worldwide via our premium courier partners (FedEx Priority & DHL Express). Tracking is dynamically synced to your dashboard within hours of checkout.
                </div>
            </div>

            <div class="faq-card p-6" onclick="this.classList.toggle('open')">
                <div class="flex justify-between items-center">
                    <h3 class="text-white font-bold text-lg">Is my payment information secure?</h3>
                    <iconify-icon icon="solar:alt-arrow-down-bold" class="text-slate-500 icon-toggle transition-transform"></iconify-icon>
                </div>
                <div class="faq-answer">
                    Absolutely. MY SHOP implements AES-256 military-grade encryption alongside Stripe's certified PCI Service Provider Level 1 architecture. Your raw card details never touch our servers.
                </div>
            </div>

            <div class="faq-card p-6" onclick="this.classList.toggle('open')">
                <div class="flex justify-between items-center">
                    <h3 class="text-white font-bold text-lg">What is your refund policy?</h3>
                    <iconify-icon icon="solar:alt-arrow-down-bold" class="text-slate-500 icon-toggle transition-transform"></iconify-icon>
                </div>
                <div class="faq-answer">
                    Given the luxury nature of our goods, refunds are evaluated on a strict case-by-case basis. Items must be returned unworn and with all original cryptographic authenticity certificates.
                </div>
            </div>

        </div>

        <div class="mt-16 text-center">
            <p class="text-sm text-slate-500">Still have questions?</p>
            <a href="chat.php" class="inline-flex items-center gap-2 text-blue-400 font-bold hover:text-white mt-2 transition">
                Talk to Support <iconify-icon icon="solar:arrow-right-line-duotone"></iconify-icon>
            </a>
        </div>
    </main>
</body>
</html>

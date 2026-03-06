<?php
require_once '../include/load.php';
checkLogin(); 


$check_specific = $pdo->query("SELECT COUNT(*) FROM users WHERE email LIKE '%@myshop.com'")->fetchColumn();

if ($check_specific < 5) { 
    $new_users = [
        ['name' => 'vivek', 'email' => 'vivek@myshop.com'],
        ['name' => 'Rohit', 'email' => 'Rohit@myshop.com'],
        ['name' => 'Pankaj', 'email' => 'Pankaj@myshop.com'],
        ['name' => 'Priya', 'email' => 'Priya@myshop.com'],
        ['name' => 'Fatima', 'email' => 'fatima@myshop.com']
    ];
    
    $stmt_add = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    foreach ($new_users as $u) {
        $pass = password_hash('password123', PASSWORD_DEFAULT);
        $stmt_add->execute([strtolower($u['name']), $u['email'], $pass, 'user']);
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id !== 1) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php?msg=User deleted successfully");
        exit;
    }
}


$users = $pdo->query("SELECT id, username, email, role FROM users ORDER BY id DESC")->fetchAll();

include '../partials/header.php'; 
?>

<div style="display: flex; min-height: 100vh; background: #f4f7f6; font-family: sans-serif;">
    <?php include '../partials/sidebar.php'; ?>

    <div style="flex: 1; padding: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: #333; font-weight: 700;">User Management</h2>
            <div style="color: #666; font-size: 14px; background: #fff; padding: 8px 20px; border-radius: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid #eee;">
                Total Active Users: <b style="color: #4834d4;"><?= count($users) ?></b>
            </div>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <div style="background: #d1ecf1; color: #0c5460; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #0c5460;">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>

        <div style="background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #eee;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #1a1a1a; color: white;">
                        <th style="padding: 18px 15px;">ID</th>
                        <th style="padding: 18px 15px;">Username</th>
                        <th style="padding: 18px 15px;">Email Address</th>
                        <th style="padding: 18px 15px;">Role</th>
                        <th style="padding: 18px 15px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: 0.3s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                        <td style="padding: 15px; color: #888;">#<?= $user['id'] ?></td>
                        <td style="padding: 15px; font-weight: 600; color: #2d3436;"><?= htmlspecialchars($user['username']) ?></td>
                        <td style="padding: 15px; color: #636e72;"><?= htmlspecialchars($user['email']) ?></td>
                        <td style="padding: 15px;">
                            <span style="background: <?= ($user['role']=='admin') ? '#ffeaa7' : '#dfe6e9' ?>; color: <?= ($user['role']=='admin') ? '#d63031' : '#2d3436' ?>; padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: right;">
                            <a href="edit.php?id=<?= $user['id'] ?>" style="color: #0984e3; text-decoration: none; font-size: 13px; font-weight: 600; margin-right: 15px;">Edit</a>
                            <?php if($user['id'] != 1): ?>
                                <a href="index.php?delete=<?= $user['id'] ?>" 
                                   onclick="return confirm('Kya aap waqai is user ko hatana chahte hain?')" 
                                   style="color: #d63031; text-decoration: none; font-size: 13px; font-weight: 600;">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
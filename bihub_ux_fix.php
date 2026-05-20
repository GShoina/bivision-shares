<?php
// bihub UX fixes:
// 1. forgot.php: timer 1500->5000, redirect 2000->7000
// 2. db.php: success message include spam note
// 3. forgot.php: show/hide toggle on reset password
// 4. single-cards.php: show/hide toggle on login password
// 5. Read header.php nav to find "შესვლა" button

$base = 'C:/wamp/www/wp-content/themes/qlik/';

// ==================
// PATCH 1: forgot.php timing + toggle
// ==================
$path1 = $base . 'auth/forgot.php';
$c1 = file_get_contents($path1);
$orig1 = strlen($c1);

$n = 0;
$c1 = str_replace('timer: 1500', 'timer: 5000', $c1, $n);
echo "P1a timer: $n\n";

$n = 0;
$c1 = str_replace('}, 2000);', '}, 7000);', $c1, $n);
echo "P1b redirect: $n\n";

// Show/hide toggle on reset password field
$old_pwd = '<input type="password" class="col-12 my-1" placeholder="პაროლი" required name="password">';
$new_pwd = <<<'EOT'
<div class="col-12 my-1 px-0" style="position:relative;"><input type="password" id="bh_pwd_reset" style="width:100%;box-sizing:border-box;padding-right:40px;" placeholder="პაროლი" required name="password"><span onclick="var f=document.getElementById('bh_pwd_reset');f.type=f.type==='password'?'text':'password';this.textContent=f.type==='password'?'👁':'🔒';" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:18px;user-select:none;opacity:0.6;" title="ჩვენება">👁</span></div>
EOT;
$n = 0;
$c1 = str_replace($old_pwd, $new_pwd, $c1, $n);
echo "P1c pwd toggle: $n\n";

copy($path1, $path1 . '.bak_' . date('Ymd_His'));
file_put_contents($path1, $c1);
echo "P1 written ($orig1 -> " . strlen($c1) . " bytes)\n\n";

// ==================
// PATCH 2: db.php — forgot_pass success message
// ==================
$path2 = $base . 'auth/config/db.php';
$c2 = file_get_contents($path2);
$orig2 = strlen($c2);

$old_msg = '$message = "პაროლის შესაცვლელად მიყევით ელ-ფოსტაზე გამოგზავნილ ბმულს.";';
$new_msg = '$message = "ბმული გამოგზავნილია. შეამოწმეთ სპამი!";';
$n = 0;
$c2 = str_replace($old_msg, $new_msg, $c2, $n);
echo "P2 message: $n\n";

if ($n > 0) {
    copy($path2, $path2 . '.bak_' . date('Ymd_His'));
    file_put_contents($path2, $c2);
    echo "P2 written ($orig2 -> " . strlen($c2) . " bytes)\n\n";
} else {
    echo "P2 no match — searching actual line:\n";
    foreach (explode("\n", $c2) as $i => $line) {
        if (strpos($line, 'message') !== false && (strpos($line, 'ელ-ფოსტა') !== false || strpos($line, 'გამოგზავნ') !== false)) {
            echo ($i+1) . ": " . trim($line) . "\n";
        }
    }
    echo "\n";
}

// ==================
// PATCH 3: single-cards.php — login form password toggle
// ==================
$path3 = $base . 'single-cards.php';
$c3 = file_get_contents($path3);
$orig3 = strlen($c3);

$old_login = '<input type="password" class="col-12 col-xl-12 m-1" placeholder="პაროლი" required name="password">';
$new_login = <<<'EOT'
<div class="col-12 col-xl-12 m-1 px-0" style="position:relative;"><input type="password" id="bh_pwd_login" style="width:100%;box-sizing:border-box;padding-right:40px;" placeholder="პაროლი" required name="password"><span onclick="var f=document.getElementById('bh_pwd_login');f.type=f.type==='password'?'text':'password';this.textContent=f.type==='password'?'👁':'🔒';" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:18px;user-select:none;opacity:0.6;" title="ჩვენება">👁</span></div>
EOT;
$n = 0;
$c3 = str_replace($old_login, $new_login, $c3, $n);
echo "P3 login toggle: $n\n";

if ($n > 0) {
    copy($path3, $path3 . '.bak_' . date('Ymd_His'));
    file_put_contents($path3, $c3);
    echo "P3 written ($orig3 -> " . strlen($c3) . " bytes)\n\n";
} else {
    echo "P3 no match — actual password lines:\n";
    foreach (explode("\n", $c3) as $i => $line) {
        if (strpos($line, 'type="password"') !== false) {
            echo ($i+1) . ": " . trim($line) . "\n";
        }
    }
    echo "\n";
}

// ==================
// INFO: Find "შესვლა" link in theme (nav/header)
// ==================
echo "=== INVESTIGATING შესვლა BUTTON ===\n";

// Check header.php
$header_path = $base . 'header.php';
if (file_exists($header_path)) {
    $header = file_get_contents($header_path);
    echo "header.php size: " . strlen($header) . "\n";
    // Find lines with "შესვლა" or "wp-login" or "register-me"
    foreach (explode("\n", $header) as $i => $line) {
        if (strpos($line, 'wp-login') !== false || strpos($line, 'wp-admin') !== false ||
            strpos($line, 'შესვლა') !== false || strpos($line, 'register-me') !== false ||
            strpos($line, 'login') !== false) {
            echo ($i+1) . ": " . trim($line) . "\n";
        }
    }
} else {
    echo "header.php not found at $header_path\n";
}

echo "\n=== DB MENU CHECK ===\n";
$conn = new mysqli('localhost', 'root', 'Xq7#mK2pRv!9nBwL', 'qlik_wp');
if (!$conn->connect_error) {
    // Find menu items with login-related URLs
    $r = $conn->query("SELECT p.ID, p.post_title, pm.meta_value as url FROM wp_posts p
        JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_menu_item_url'
        WHERE p.post_type = 'nav_menu_item'
        AND (p.post_title LIKE '%შესვლა%' OR pm.meta_value LIKE '%login%' OR pm.meta_value LIKE '%register%' OR p.post_title LIKE '%login%')
        LIMIT 20");
    if ($r && $r->num_rows > 0) {
        while ($row = $r->fetch_assoc()) {
            echo "ID={$row['ID']} title='{$row['post_title']}' url='{$row['url']}'\n";
        }
    } else {
        echo "No direct menu matches. Listing all menu items:\n";
        $r2 = $conn->query("SELECT p.ID, p.post_title,
            MAX(CASE WHEN pm.meta_key='_menu_item_url' THEN pm.meta_value END) as url,
            MAX(CASE WHEN pm.meta_key='_menu_item_object_id' THEN pm.meta_value END) as obj_id,
            MAX(CASE WHEN pm.meta_key='_menu_item_object' THEN pm.meta_value END) as obj_type
            FROM wp_posts p
            JOIN wp_postmeta pm ON p.ID = pm.post_id
            WHERE p.post_type = 'nav_menu_item' AND p.post_status = 'publish'
            GROUP BY p.ID
            ORDER BY p.menu_order
            LIMIT 30");
        if ($r2) {
            while ($row = $r2->fetch_assoc()) {
                echo "ID={$row['ID']} '{$row['post_title']}' type={$row['obj_type']} url='{$row['url']}'\n";
            }
        }
    }
    $conn->close();
}

echo "\nDONE\n";

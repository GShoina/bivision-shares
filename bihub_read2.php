<?php
$base = 'C:/wamp/www/wp-content/themes/qlik/';

// Read single-cards.php context around both password fields
$c3 = file_get_contents($base . 'single-cards.php');
echo "=== single-cards.php pos=4388 context (4300-4600) ===\n";
echo substr($c3, 4300, 300) . "\n\n";

echo "=== single-cards.php pos=6885 context (6800-7100) ===\n";
echo substr($c3, 6800, 300) . "\n\n";

// Check forgot.php redirect timeout
$c1 = file_get_contents($base . 'auth/forgot.php');
$pos = strpos($c1, 'setTimeout');
if ($pos !== false) {
    echo "=== forgot.php setTimeout context ===\n";
    echo substr($c1, $pos, 150) . "\n\n";
}

// Search for "შესვლა" in all theme PHP files
echo "=== Searching for შესვლა in theme files ===\n";
$files = glob($base . '*.php');
foreach ($files as $f) {
    $content = file_get_contents($f);
    if (strpos($content, 'შესვლა') !== false) {
        echo "FILE: $f\n";
        foreach (explode("\n", $content) as $i => $line) {
            if (strpos($line, 'შესვლა') !== false) {
                echo ($i+1) . ": " . trim($line) . "\n";
            }
        }
        echo "\n";
    }
}
// Also check register-me page template
$reg_path = $base . 'page-register-me.php';
if (file_exists($reg_path)) {
    echo "=== page-register-me.php snippets ===\n";
    $reg = file_get_contents($reg_path);
    foreach (explode("\n", $reg) as $i => $line) {
        if (strpos($line, 'შესვლა') !== false || strpos($line, 'login') !== false || strpos($line, 'wp-login') !== false) {
            echo ($i+1) . ": " . trim($line) . "\n";
        }
    }
}

// Check WP menu with proper charset
echo "\n=== WP Menu items (UTF-8) ===\n";
$conn = new mysqli('localhost', 'root', 'Xq7#mK2pRv!9nBwL', 'qlik_wp');
$conn->set_charset('utf8');
$r = $conn->query("SELECT p.ID, p.post_title,
    MAX(CASE WHEN pm.meta_key='_menu_item_url' THEN pm.meta_value END) as url,
    MAX(CASE WHEN pm.meta_key='_menu_item_object' THEN pm.meta_value END) as obj_type
    FROM wp_posts p
    JOIN wp_postmeta pm ON p.ID = pm.post_id
    WHERE p.post_type = 'nav_menu_item' AND p.post_status = 'publish'
    GROUP BY p.ID ORDER BY p.menu_order LIMIT 30");
while ($row = $r->fetch_assoc()) {
    echo "ID={$row['ID']} '{$row['post_title']}' type={$row['obj_type']} url='{$row['url']}'\n";
}
$conn->close();

#!/usr/bin/env python3
import winrm, sys

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
php = b"""<?php
$base = 'C:/wamp/www/wp-content/themes/qlik/';
// Check front-page.php
foreach (['front-page.php','home.php','index.php'] as $f) {
    $path = $base . $f;
    if (file_exists($path)) {
        $c = file_get_contents($path);
        echo "=== $f (" . strlen($c) . " bytes) ===\\n";
        // Show lines with bihub-v10, index, or html includes
        foreach (explode("\\n", $c) as $i => $line) {
            if (strpos($line,'v10') !== false || strpos($line,'index') !== false || strpos($line,'html') !== false || strpos($line,'include') !== false || strpos($line,'file_get') !== false) {
                echo ($i+1) . ": " . trim($line) . "\\n";
            }
        }
        echo "\\n";
    }
}
// Check if there's a bihub-v10.html or similar at WP root
$root = 'C:/wamp/www/';
foreach (glob($root . '*.html') as $f) {
    echo "HTML at root: $f (" . filesize($f) . " bytes)\\n";
}
// Check WP front page setting
$conn = new mysqli('localhost', 'root', 'Xq7#mK2pRv!9nBwL', 'qlik_wp');
$conn->set_charset('utf8');
$r = $conn->query("SELECT option_name, option_value FROM wp_options WHERE option_name IN ('show_on_front','page_on_front','page_for_posts')");
while ($row = $r->fetch_assoc()) echo $row['option_name'] . " = " . $row['option_value'] . "\\n";
$conn->close();
"""
b64 = __import__('base64').b64encode(php).decode()
ps = f'[System.IO.File]::WriteAllBytes("C:\\\\wamp\\\\www\\\\chk.php",[System.Convert]::FromBase64String("{b64}"))'
session.run_ps(ps)
r2 = session.run_ps(f'& "{PHP_BIN}" "C:\\wamp\\www\\chk.php" 2>&1')
sys.stdout.buffer.write(r2.std_out)
session.run_ps('Remove-Item "C:\\wamp\\www\\chk.php"')

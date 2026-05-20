<?php
$base = 'C:/wamp/www/wp-content/themes/qlik/';

// Debug forgot.php
$content = file_get_contents($base . 'auth/forgot.php');
echo "forgot.php size: " . strlen($content) . "\n";

// Check for timer
$pos = strpos($content, 'timer:');
echo "strpos('timer:'): " . var_export($pos, true) . "\n";
$pos2 = strpos($content, 'timer: 1500');
echo "strpos('timer: 1500'): " . var_export($pos2, true) . "\n";
$pos3 = strpos($content, '1500');
echo "strpos('1500'): " . var_export($pos3, true) . "\n";

if ($pos !== false) {
    // Show 30 bytes around timer
    $start = max(0, $pos - 5);
    $chunk = substr($content, $start, 50);
    echo "Context: " . bin2hex($chunk) . "\n";
    echo "Text: [" . $chunk . "]\n";
}

// Check for }, 2000
$pos4 = strpos($content, '2000');
echo "strpos('2000'): " . var_export($pos4, true) . "\n";

// Check for Georgian password placeholder
$pos5 = strpos($content, 'type="password"');
echo "strpos password field: " . var_export($pos5, true) . "\n";
if ($pos5 !== false) {
    echo "password field: [" . substr($content, $pos5, 100) . "]\n";
}

// Show first 200 bytes in hex to check encoding/BOM
echo "\nFirst 100 bytes hex: " . bin2hex(substr($content, 0, 100)) . "\n";

echo "\n--- single-cards.php ---\n";
$c3 = file_get_contents($base . 'single-cards.php');
echo "size: " . strlen($c3) . "\n";
// Check all password fields
$offset = 0;
while (($p = strpos($c3, 'type="password"', $offset)) !== false) {
    echo "pos=$p: [" . substr($c3, $p, 120) . "]\n\n";
    $offset = $p + 1;
}

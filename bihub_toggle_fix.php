<?php
// Fix remaining password field in single-cards.php (has required="" variant)
$path = 'C:/wamp/www/wp-content/themes/qlik/single-cards.php';
$c = file_get_contents($path);
$orig = strlen($c);

$old = '<input type="password" class="col-12 col-xl-12 m-1" placeholder="პაროლი" required="" name="password">';
$new = '<div class="col-12 col-xl-12 m-1 px-0" style="position:relative;"><input type="password" id="bh_pwd_login2" style="width:100%;box-sizing:border-box;padding-right:40px;" placeholder="პაროლი" required name="password"><span onclick="var f=document.getElementById(\'bh_pwd_login2\');f.type=f.type===\'password\'?\'text\':\'password\';this.textContent=f.type===\'password\'?\'👁\':\'🔒\';" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:18px;user-select:none;opacity:0.6;" title="ჩვენება">👁</span></div>';

$n = 0;
$c = str_replace($old, $new, $c, $n);
echo "toggle fix: $n replacements\n";

if ($n > 0) {
    copy($path, $path . '.bak_' . date('Ymd_His'));
    file_put_contents($path, $c);
    echo "written OK ($orig -> " . strlen($c) . " bytes)\n";
} else {
    echo "no match. Checking actual field:\n";
    $offset = 0;
    while (($p = strpos($c, 'type="password"', $offset)) !== false) {
        echo "pos=$p: [" . substr($c, $p, 150) . "]\n\n";
        $offset = $p + 1;
    }
}

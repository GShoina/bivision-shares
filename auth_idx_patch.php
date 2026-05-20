<?php
$path = 'C:/wamp/www/wp-content/themes/qlik/auth/index.php';
$c = file_get_contents($path);
$orig = strlen($c);

$eye = "\xf0\x9f\x91\x81";
$lock = "\xf0\x9f\x94\x92";
$ka_pwd = "\xe1\x83\x9e\xe1\x83\x90\xe1\x83\xa0\xe1\x83\x9d\xe1\x83\x9a\xe1\x83\x98";

$old = '<input type="password" class="col-12 col-xl-12 m-1" placeholder="' . $ka_pwd . '" required name="password">';

$new  = '<div style="position:relative;">';
$new .= '<input type="password" id="bh_pwd_idx" class="col-12 col-xl-12 m-1" placeholder="' . $ka_pwd . '" required name="password" style="padding-right:40px;box-sizing:border-box;width:100%;">';
$new .= '<span onclick="var f=document.getElementById(\'bh_pwd_idx\');f.type=f.type===\'password\'?\'text\':\'password\';this.textContent=f.type===\'password\'?\'' . $eye . '\':\'' . $lock . '\';" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:18px;user-select:none;opacity:0.6;" title="show">' . $eye . '</span>';
$new .= '</div>';

$n = 0;
$c = str_replace($old, $new, $c, $n);
echo "Replacements: $n\n";
if ($n > 0) {
    copy($path, $path . '.bak_' . date('Ymd_His'));
    file_put_contents($path, $c);
    echo "Written OK ($orig -> " . strlen($c) . " bytes)\n";
} else {
    echo "No match! Context:\n";
    $p = strpos($c, 'type="password"');
    if ($p !== false) echo substr($c, $p - 10, 200) . "\n";
}

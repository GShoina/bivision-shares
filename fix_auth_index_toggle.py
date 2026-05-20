#!/usr/bin/env python3
"""Add password show/hide toggle to auth/index.php login form."""
import winrm, sys, base64

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'

# Write PHP as actual UTF-8 bytes — no escape sequences in the PHP source
php_src = '''<?php
$path = 'C:/wamp/www/wp-content/themes/qlik/auth/index.php';
$c = file_get_contents($path);
$orig = strlen($c);

$old = '<input type="password" class="col-12 col-xl-12 m-1" placeholder="პაროლი" required name="password">';
$new = '<div style="position:relative;display:flex;align-items:center;"><input type="password" id="bh_pwd_idx" class="col-12 col-xl-12 m-1" placeholder="პაროლი" required name="password" style="padding-right:40px;box-sizing:border-box;width:100%;"><span onclick="var f=document.getElementById(\'bh_pwd_idx\');f.type=f.type===\'password\'?\'text\':\'password\';this.textContent=f.type===\'password\'?\'\xf0\x9f\x91\x81\':\'\\ud83d\\udd12\';" style="position:absolute;right:10px;cursor:pointer;font-size:18px;user-select:none;opacity:0.6;">\xf0\x9f\x91\x81</span></div>';

$n = 0;
$c = str_replace($old, $new, $c, $n);
echo "Replacements: $n\\n";
if ($n > 0) {
    copy($path, $path . '.bak_' . date('Ymd_His'));
    file_put_contents($path, $c);
    echo "Written OK ($orig -> " . strlen($c) . " bytes)\\n";
} else {
    echo "No match! Checking raw:\\n";
    $p = strpos($c, 'type="password"');
    if ($p !== false) echo "Context: [" . substr($c, $p-10, 200) . "]\\n";
}
'''

# Encode Georgian Unicode + emoji to actual UTF-8 bytes
php_bytes = php_src.encode('utf-8')
b64 = base64.b64encode(php_bytes).decode()
ps = f'[System.IO.File]::WriteAllBytes("C:\\\\wamp\\\\www\\\\fix_idx.php",[System.Convert]::FromBase64String("{b64}"))'
session.run_ps(ps)
r = session.run_ps(f'& "{PHP_BIN}" "C:\\wamp\\www\\fix_idx.php" 2>&1')
sys.stdout.buffer.write(r.std_out)
session.run_ps('Remove-Item "C:\\wamp\\www\\fix_idx.php" -ErrorAction SilentlyContinue')

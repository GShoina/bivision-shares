#!/usr/bin/env python3
import winrm, sys, base64

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)

php = b"""<?php
$path = 'C:/wamp/www/wp-content/themes/qlik/auth/index.php';
$c = file_get_contents($path);
echo $c;
echo "\\n\\n=== SIZE: " . strlen($c) . " ===\\n";
"""
b64 = base64.b64encode(php).decode()
session.run_ps(f'[System.IO.File]::WriteAllBytes("C:\\\\wamp\\\\www\\\\chk5.php",[System.Convert]::FromBase64String("{b64}"))')
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
r = session.run_ps(f'& "{PHP_BIN}" "C:\\wamp\\www\\chk5.php" 2>&1')
sys.stdout.buffer.write(r.std_out)
session.run_ps('Remove-Item "C:\\wamp\\www\\chk5.php" -ErrorAction SilentlyContinue')

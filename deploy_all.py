#!/usr/bin/env python3
"""Deploy bihub_toggle_fix.php + bihub-v10.html to server."""
import winrm, sys

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=60,
    operation_timeout_sec=55,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
BASE_RAW = 'https://raw.githubusercontent.com/GShoina/bivision-shares/main/'

def run_ps(cmd):
    r = session.run_ps(cmd)
    if r.status_code != 0:
        sys.exit("Error: " + r.std_err.decode()[:300])
    return r

# 1. Deploy + run toggle fix on single-cards.php
print("=== Toggle fix on single-cards.php ===")
run_ps(f'Invoke-WebRequest -Uri "{BASE_RAW}bihub_toggle_fix.php" -OutFile "C:\\wamp\\www\\bihub_toggle_fix.php" -UseBasicParsing')
r2 = session.run_ps(f'& "{PHP_BIN}" "C:\\wamp\\www\\bihub_toggle_fix.php" 2>&1')
sys.stdout.buffer.write(r2.std_out)
sys.stdout.buffer.write(b'\n')
run_ps('Remove-Item "C:\\wamp\\www\\bihub_toggle_fix.php" -ErrorAction SilentlyContinue')

# 2. Update v10-preview.html with fixed wp-login links
print("\n=== Deploy bihub-v10.html -> v10-preview.html ===")
run_ps(f'Invoke-WebRequest -Uri "{BASE_RAW}bihub-v10.html" -OutFile "C:\\wamp\\www\\v10-preview.html" -UseBasicParsing')
print("v10-preview.html updated OK")

print("\nDone")

#!/usr/bin/env python3
"""Deploy auth_idx_patch.php to server and run it."""
import winrm, sys, base64

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
BASE_RAW = 'https://raw.githubusercontent.com/GShoina/bivision-shares/main/'

def run_ps(cmd):
    r = session.run_ps(cmd)
    if r.status_code != 0:
        sys.exit("Error: " + r.std_err.decode()[:300])
    return r

print("=== Deploying auth_idx_patch.php ===")
run_ps(f'Invoke-WebRequest -Uri "{BASE_RAW}auth_idx_patch.php" -OutFile "C:\\wamp\\www\\auth_idx_patch.php" -UseBasicParsing')
r = session.run_ps(f'& "{PHP_BIN}" "C:\\wamp\\www\\auth_idx_patch.php" 2>&1')
sys.stdout.buffer.write(r.std_out)
run_ps('Remove-Item "C:\\wamp\\www\\auth_idx_patch.php" -ErrorAction SilentlyContinue')
print("\nDone")

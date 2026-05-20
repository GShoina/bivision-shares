#!/usr/bin/env python3
import winrm, sys

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=60,
    operation_timeout_sec=55,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
RAW = 'https://raw.githubusercontent.com/GShoina/bivision-shares/main/bihub_debug.php'
REMOTE = r'C:\wamp\www\bihub_debug.php'

r = session.run_ps(f'Invoke-WebRequest -Uri "{RAW}" -OutFile "{REMOTE}" -UseBasicParsing')
if r.status_code != 0:
    print("DL error:", r.std_err.decode()[:200]); sys.exit(1)

r2 = session.run_ps(f'& "{PHP_BIN}" "{REMOTE}" 2>&1')
sys.stdout.buffer.write(r2.std_out)
if r2.std_err:
    sys.stdout.buffer.write(b'\nSTDERR: ' + r2.std_err[:300])
session.run_ps(f'Remove-Item "{REMOTE}" -ErrorAction SilentlyContinue')

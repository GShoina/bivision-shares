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
RAW = 'https://raw.githubusercontent.com/GShoina/bivision-shares/main/bihub_read2.php'
REMOTE = r'C:\wamp\www\bihub_read2.php'

r = session.run_ps(f'Invoke-WebRequest -Uri "{RAW}" -OutFile "{REMOTE}" -UseBasicParsing')
if r.status_code != 0:
    sys.exit("DL error: " + r.std_err.decode()[:200])

r2 = session.run_ps(f'& "{PHP_BIN}" "{REMOTE}" 2>&1')
out = r2.std_out.decode('utf-8', errors='replace')

with open(r'C:\Users\gela.shonia\bivision-shares\read2_out.txt', 'w', encoding='utf-8') as f:
    f.write(out)
print("Written to read2_out.txt")
print(f"Output: {len(out)} bytes")
session.run_ps(f'Remove-Item "{REMOTE}" -ErrorAction SilentlyContinue')

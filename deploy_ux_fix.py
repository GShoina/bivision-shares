#!/usr/bin/env python3
import winrm, base64, sys

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=60,
    operation_timeout_sec=55,
)
PHP_BIN = r'C:\wamp\bin\php\php5.6.40\php.exe'
LOCAL = r'C:\Users\gela.shonia\bivision-shares\bihub_ux_fix.php'
REMOTE = r'C:\wamp\www\bihub_ux_fix.php'

with open(LOCAL, 'rb') as f:
    data = f.read()
b64 = base64.b64encode(data).decode()
print(f"Uploading {len(data)} bytes...")
r = session.run_ps(f'[System.IO.File]::WriteAllBytes("{REMOTE}", [System.Convert]::FromBase64String("{b64}"))')
if r.status_code != 0:
    print("Upload error:", r.std_err.decode()[:300])
    sys.exit(1)
print("Uploaded OK")

r2 = session.run_ps(f'& "{PHP_BIN}" "{REMOTE}" 2>&1')
out = r2.std_out.decode('utf-8', errors='replace')
print(out)
if r2.std_err:
    print("STDERR:", r2.std_err.decode('utf-8', errors='replace')[:300])

session.run_ps(f'Remove-Item "{REMOTE}" -ErrorAction SilentlyContinue')
print("Done")

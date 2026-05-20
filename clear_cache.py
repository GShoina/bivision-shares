#!/usr/bin/env python3
import winrm, sys

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)

r = session.run_ps('Remove-Item -Path "C:\\wamp\\www\\wp-content\\cache\\*" -Recurse -Force -ErrorAction SilentlyContinue; Write-Host "Cache cleared OK"')
print(r.std_out.decode())
if r.std_err:
    print("ERR:", r.std_err.decode()[:200])

#!/usr/bin/env python3
"""Create site.webmanifest on bihub.ge to fix 404."""
import winrm, sys, base64

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)

manifest = b"""{
  "name": "bihub",
  "short_name": "bihub",
  "description": "Business and public data analytics hub",
  "start_url": "/",
  "display": "browser",
  "background_color": "#ffffff",
  "theme_color": "#1a3353",
  "icons": [
    { "src": "/favicon.ico", "sizes": "48x48", "type": "image/x-icon" }
  ]
}"""

b64 = base64.b64encode(manifest).decode()
ps = f'[System.IO.File]::WriteAllBytes("C:\\\\wamp\\\\www\\\\site.webmanifest",[System.Convert]::FromBase64String("{b64}"))'
r = session.run_ps(ps)
if r.status_code == 0:
    print("site.webmanifest created OK")
else:
    print("Error:", r.std_err.decode()[:200])

# Verify
r2 = session.run_ps('Get-Item "C:\\wamp\\www\\site.webmanifest" | Select-Object Name,Length')
sys.stdout.buffer.write(r2.std_out)

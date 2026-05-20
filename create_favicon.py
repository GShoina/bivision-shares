#!/usr/bin/env python3
"""Create favicon.svg on bihub.ge server."""
import winrm, sys, base64

session = winrm.Session(
    'http://185.229.111.201:5985/wsman',
    auth=('.\\administrator', 'x!m@E%hIPVjm:H@'),
    transport='ntlm',
    read_timeout_sec=30,
    operation_timeout_sec=25,
)

# Simple bihub favicon — dark navy bg, green bars (matches bihub logo)
svg = b"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
  <rect width="32" height="32" rx="4" fill="#1a3353"/>
  <rect x="4" y="18" width="4" height="10" rx="1" fill="#00A651"/>
  <rect x="10" y="12" width="4" height="16" rx="1" fill="#00A651"/>
  <rect x="16" y="8" width="4" height="20" rx="1" fill="#00A651"/>
  <rect x="22" y="14" width="4" height="14" rx="1" fill="#00A651"/>
</svg>"""

b64 = base64.b64encode(svg).decode()
ps = f'[System.IO.File]::WriteAllBytes("C:\\\\wamp\\\\www\\\\favicon.svg",[System.Convert]::FromBase64String("{b64}"))'
r = session.run_ps(ps)
if r.status_code == 0:
    print("favicon.svg created OK")
r2 = session.run_ps('Get-Item "C:\\wamp\\www\\favicon.svg" | Select-Object Name,Length')
sys.stdout.buffer.write(r2.std_out)

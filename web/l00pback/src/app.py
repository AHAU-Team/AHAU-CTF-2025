from flask import Flask, request, Response, abort
import subprocess
import shlex
from urllib.parse import urlparse
import socket
import ipaddress

app = Flask(__name__)

@app.get("/")
def index():
    return {"ok": True, "msg": "up"}, 200

@app.get("/fetch")
def fetch():
    url = request.args.get("url", "").strip()
    if not url:
        return {"error": "missing url parameter"}, 400

    try:
        parsed = urlparse(url)
        ip = socket.gethostbyname(parsed.hostname)
        ip_obj = ipaddress.ip_address(ip)
        if ip_obj.is_loopback:
            proc = subprocess.run(
                ["curl", "-sS", "--max-time", "10", url],
                capture_output=True,
                text=True,
                timeout=12
            )
    except subprocess.TimeoutExpired:
        return {"error": "timeout"}, 504
    except Exception as e:
        return {"error": f"exec error: {e}"}, 500

    status = 200 if proc.returncode == 0 else 502
    return Response(proc.stdout or proc.stderr, status=status, mimetype="text/plain")

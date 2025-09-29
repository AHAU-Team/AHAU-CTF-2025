<?php
// ctf_grep.php
// WARNING: intentionally vulnerable for CTF use. Run only in isolated environments (Docker).
session_start();

/**
 * Configuración
 */
$UPLOAD_ROOT = __DIR__ . '/uploads';
$MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB por archivo
$ALLOWED_MIMES = ['text/plain', 'text/x-log', 'text/markdown', 'text/x-markdown', 'application/octet-stream'];
$ALLOWED_EXT = ['txt','log','md']; // extensiones permitidas (pero permitimos también sin extensión)

/**
 * Robust directory creation + manejo de errores (silencioso)
 */
if (!is_dir($UPLOAD_ROOT)) {
    $created = @mkdir($UPLOAD_ROOT, 0755, true);
    if ($created === false) {
        $GLOBALS['upload_dir_error'] = "Server cannot create uploads directory. Check filesystem permissions.";
    } else {
        @chmod($UPLOAD_ROOT, 0755);
    }
}

$sessdir = $UPLOAD_ROOT . '/' . session_id();
if (!is_dir($sessdir)) {
    $created = @mkdir($sessdir, 0755, true);
    if ($created === false) {
        $GLOBALS['upload_dir_error'] = "Server cannot create session upload directory. Using fallback.";
        $sessdir = sys_get_temp_dir() . '/ctf_upload_fallback_' . session_id();
        if (!is_dir($sessdir)) { @mkdir($sessdir, 0755, true); }
    } else {
        @chmod($sessdir, 0755);
    }
}

/**
 * List uploaded files safely
 */
$files = [];
if (is_dir($sessdir) && is_readable($sessdir)) {
    $sc = @scandir($sessdir);
    if ($sc !== false) {
        $files = array_values(array_diff($sc, ['.','..']));
    } else {
        $files = [];
    }
} else {
    $files = [];
}

/**
 * Helpers
 */
function preserve_name($name) {
    $b = basename($name);
    $b = preg_replace('/[^\P{C}\n\r\t]+/u', '', $b);
    $b = preg_replace('/[\s]+/', ' ', $b);
    $b = trim($b);
    if ($b === '') $b = 'upload.bin';
    return $b;
}

/**
 * Upload handling
 */
$upload_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file']) && isset($_FILES['file']['error'])) {
    $f = $_FILES['file'];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        $upload_msg = "Error de carga de archivo (código " . intval($f['error']) . ").";
    } else {
        if ($f['size'] > $MAX_FILE_SIZE) {
            $upload_msg = "Archivo demasiado grande (max 2 MB).";
        } else {
            // Basic mime check (not perfect)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $f['tmp_name']);
            finfo_close($finfo);
            $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));

            $has_ext = ($ext !== '');
            $allowed_by_ext = $has_ext && in_array($ext, $ALLOWED_EXT);
            $allowed_by_mime = in_array($mime, $ALLOWED_MIMES);

            if (!($allowed_by_ext || $allowed_by_mime || (!$has_ext && $allowed_by_mime))) {
                $upload_msg = "Tipo de archivo no permitido. Unicamente se aceptan: " . implode(',', $ALLOWED_EXT) . ".";
            } else {
                // Intentionally preserve leading '-' in name (vulnerable behavior)
                $safeName = preserve_name($f['name']);
                $target = $sessdir . '/' . $safeName;
                if (move_uploaded_file($f['tmp_name'], $target)) {
                    chmod($target, 0644);
                    $upload_msg = "Subido como: " . htmlspecialchars($safeName);
                    // refresh file list
                    $sc = @scandir($sessdir);
                    if ($sc !== false) $files = array_values(array_diff($sc, ['.','..']));
                } else {
                    $upload_msg = "Error al subir el archivo.";
                }
            }
        }
    }
}

$search_out = null;
$search_err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $pattern = trim($_POST['pattern'] ?? '');
    if ($pattern === '') {
        $search_err = "Palabra vacía.";
    } else {
        $escaped_pattern = escapeshellarg($pattern);
        $cmd = 'cd ' . escapeshellarg($sessdir) . ' && /bin/grep -n -i ' . $escaped_pattern . ' * 2>&1';
        $output = [];
        $rc = 0;
        @exec($cmd, $output, $rc);
        $search_out = implode("\n", $output);
        if ($rc !== 0 && empty($search_out)) {
            $search_err = "Sin resultados.";
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>HFC Grepeador</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  :root {
    --bg:#0b1220;
    --panel:#071018;
    --muted:#9aa6a0;
    --accent:#10b981; /* green */
    --accent-weak: rgba(16,185,129,0.12);
    --card:#071018;
    --glass: rgba(255,255,255,0.03);
  }
  *{box-sizing:border-box}
  body{margin:0;font-family:Inter,system-ui,Arial;background:linear-gradient(180deg,var(--bg) 0%, #041018 100%);color:#dbe7df}
  .wrap{max-width:980px;margin:28px auto;padding:20px}
  .card{background:linear-gradient(180deg, rgba(8,16,20,0.6), rgba(4,8,12,0.6));border-radius:12px;padding:20px;border:1px solid rgba(16,185,129,0.06);box-shadow: 0 8px 30px rgba(2,6,23,0.6)}
  header{display:flex;align-items:center;gap:12px}
  header img{width:36px;height:36px;border-radius:6px}
  header h1{margin:0;font-size:20px;color:#e6f7ef}
  .muted{color:var(--muted);font-size:13px;margin-top:6px}
  form{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
  input[type=text], input[type=file]{padding:10px;border-radius:8px;border:1px solid rgba(255,255,255,0.04);background:var(--panel);color:#dbe7df;flex:1}
  input::placeholder{color:rgba(219,231,239,0.25)}
  button{background:linear-gradient(180deg,var(--accent),#059669);border:none;color:#011214;padding:10px 12px;border-radius:8px;cursor:pointer;font-weight:700}
  .box{margin-top:12px;padding:12px;border-radius:10px;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));border:1px solid rgba(255,255,255,0.02)}
  pre{white-space:pre-wrap;word-break:break-word;background:#021013;color:#dff7eb;padding:12px;border-radius:8px;border:1px solid rgba(16,185,129,0.06)}
  .files{display:flex;gap:8px;flex-wrap:wrap;margin-top:8px}
  .file-pill{padding:6px 10px;border-radius:999px;background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.08);font-size:13px;color:#dff7eb}
  .msg{margin-top:10px;padding:10px;border-radius:8px;background:var(--glass);color:var(--muted);font-size:13px}
  .warn{margin-top:12px;padding:10px;border-radius:8px;background:linear-gradient(90deg,#1a2b22,#071718);border-left:4px solid rgba(255,165,85,0.14);color:#ffcfa5}
  footer{margin-top:18px;text-align:center;color:rgba(219,231,239,0.3);font-size:13px}
  @media(max-width:640px){form{flex-direction:column} button{width:100%}}
</style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <header>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7EoOXd1RglOf8evpn2MfLhyQ4mxb1KVEEbg&s" alt="logo">
        <div>
          <h1>Grepeador</h1>
          <div class="muted">Almacena tus archivos aqui y busca cómodamente palabras en cualquiera de ellos</div>
        </div>
      </header>

      <section style="margin-top:14px">
        <form method="post" enctype="multipart/form-data">
          <input type="file" name="file" accept=".txt,.log,.md,text/plain">
          <button type="submit">Subir</button>
        </form>

        <?php if (!empty($upload_msg)): ?>
          <div class="box"><?= htmlspecialchars($upload_msg) ?></div>
        <?php endif; ?>

        <div class="muted" style="margin-top:10px">Archivos cargados:</div>
        <div class="files">
          <?php foreach ($files as $f): ?>
            <div class="file-pill"><?= htmlspecialchars($f) ?></div>
          <?php endforeach; ?>
          <?php if (count($files) === 0): ?>
            <div class="muted">-- Sin archivos --</div>
          <?php endif; ?>
        </div>
      </section>

      <section style="margin-top:18px">
        <form method="post">
          <input type="text" name="pattern" placeholder="Introduce la palabra que deseas consultar" value="<?= isset($_POST['pattern']) ? htmlspecialchars($_POST['pattern']) : '' ?>">
          <button type="submit" name="search">Buscar</button>
        </form>

        <?php if ($search_err): ?>
          <div class="msg"><?= htmlspecialchars($search_err) ?></div>
        <?php endif; ?>

        <?php if ($search_out !== null): ?>
          <div class="box" style="margin-top:12px">
            <strong style="color:#dff7eb">Coincidencias</strong>
            <pre><?= htmlspecialchars($search_out) ?></pre>
          </div>
        <?php endif; ?>
      </section>

    </div>

<!-- Pablo te deje el backup de la
función de busqueda que funciona
/index.php.bak -->

    <footer>Hackers Fight Club &copy;</footer>
  </div>
</body>
</html>

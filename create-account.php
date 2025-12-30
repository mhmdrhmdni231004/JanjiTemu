<?php
session_start();
include("connection.php");

// Harus datang dari signup.php (step 1)
if (!isset($_SESSION['personal'])) {
    header("Location: signup.php");
    exit;
}

// Ambil data personal dari session
$fname   = $_SESSION['personal']['fname']   ?? '';
$lname   = $_SESSION['personal']['lname']   ?? '';
$address = $_SESSION['personal']['address'] ?? '';
$nik     = $_SESSION['personal']['nik']     ?? '';
$dob     = $_SESSION['personal']['dob']     ?? '';

$name  = trim($fname . " " . $lname);
$error = "";

// Proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email       = trim($_POST['newemail'] ?? '');
    $tele        = trim($_POST['tele'] ?? '');
    $newpassword = $_POST['newpassword'] ?? '';
    $cpassword   = $_POST['cpassword'] ?? '';

    // Validasi dasar
    if ($email === '' || $newpassword === '' || $cpassword === '') {
        $error = "Email dan password wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif ($newpassword !== $cpassword) {
        $error = "Konfirmasi password tidak sama.";
    } elseif ($tele !== '' && !preg_match('/^0[0-9]{9,12}$/', $tele)) {
        $error = "Nomor HP tidak valid. Contoh: 081234567890";
    } else {

        // 1) Cek email sudah terdaftar di webuser atau belum
        $stmtCek = $database->prepare("SELECT 1 FROM webuser WHERE email = ? LIMIT 1");
        if (!$stmtCek) {
            $error = "Query cek email gagal: " . $database->error;
        } else {
            $stmtCek->bind_param("s", $email);
            $stmtCek->execute();
            $resCek = $stmtCek->get_result();

            if ($resCek->num_rows > 0) {
                $error = "Email sudah terdaftar. Silakan login.";
            } else {

                // 2) Insert ke patient (PASSWORD BIASA / TANPA HASH)
                $stmtP = $database->prepare(
                    "INSERT INTO patient (pemail, pname, ppassword, paddress, pnic, pdob, ptel)
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );

                if (!$stmtP) {
                    $error = "Query insert patient gagal: " . $database->error;
                } else {
                    $stmtP->bind_param("sssssss", $email, $name, $newpassword, $address, $nik, $dob, $tele);

                    if (!$stmtP->execute()) {
                        $error = "Gagal membuat akun (patient): " . $database->error;
                    } else {

                        // 3) Insert ke webuser
                        $stmtW = $database->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 'p')");
                        if (!$stmtW) {
                            $error = "Query insert webuser gagal: " . $database->error;
                        } else {
                            $stmtW->bind_param("s", $email);

                            if (!$stmtW->execute()) {
                                $error = "Gagal membuat akun (webuser): " . $database->error;
                            } else {
                                // 4) Login otomatis
                                $_SESSION["user"]     = $email;
                                $_SESSION["usertype"] = "p";
                                $_SESSION["username"] = $fname;

                                header("Location: patient/index.php");
                                exit;
                            }

                            $stmtW->close();
                        }
                    }

                    $stmtP->close();
                }
            }

            $stmtCek->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Akun | JanjiTemu+</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    :root{
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --line:#e5e7eb;
      --primary:#1e40af;
      --primary-dark:#1e3a8a;
      --radius:16px;
      --shadow:0 20px 45px rgba(2,12,27,.12);
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      min-height:100vh;
      font-family:'Poppins',sans-serif;
      background:linear-gradient(135deg,#e9efff,#f7faff);
      display:flex;
      align-items:center;
      justify-content:center;
      padding:20px;
    }
    .wrap{width:100%; max-width:480px;}
    .card{
      background:var(--card);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:34px;
      animation:fadeUp .45s ease;
    }
    @keyframes fadeUp{
      from{opacity:0; transform:translateY(12px)}
      to{opacity:1; transform:translateY(0)}
    }
    .top{display:flex; align-items:center; gap:12px; margin-bottom:10px;}
    .top i{font-size:22px; color:var(--primary)}
    .top h1{margin:0; font-size:22px; font-weight:700; color:var(--text)}
    .subtitle{margin:0 0 18px; color:var(--muted); font-size:14px}

    .mini{
      background:#f1f5ff;
      border:1px solid #dbe6ff;
      padding:10px 12px;
      border-radius:12px;
      font-size:13px;
      color:#1f2a44;
      margin-bottom:18px;
    }
    .mini b{color:var(--primary)}

    .group{margin-bottom:16px}
    .label{display:block; font-size:13px; font-weight:600; color:var(--text); margin-bottom:6px}
    .input-wrap{position:relative}
    .input-wrap .icon{
      position:absolute; left:14px; top:50%;
      transform:translateY(-50%);
      color:#94a3b8; font-size:14px;
    }
    .input{
      width:100%;
      padding:12px 14px 12px 42px;
      border:1px solid var(--line);
      border-radius:12px;
      font-size:14px;
      outline:none;
      transition:.25s;
    }
    .input:focus{
      border-color:var(--primary);
      box-shadow:0 0 0 3px rgba(30,64,175,.15);
    }
    .toggle{
      position:absolute; right:12px; top:50%;
      transform:translateY(-50%);
      cursor:pointer;
      color:#94a3b8;
      font-size:14px;
    }

    .alert{
      margin:14px 0 0;
      padding:12px 14px;
      border-radius:12px;
      font-size:13px;
      text-align:center;
    }
    .alert.error{background:#fff1f2; border:1px solid #fecdd3; color:#be123c}

    .actions{display:flex; gap:12px; margin-top:20px}
    .btn{
      flex:1;
      border:none;
      border-radius:12px;
      padding:12px 14px;
      font-weight:700;
      font-size:14px;
      cursor:pointer;
      transition:.25s;
    }
    .btn-secondary{background:#f1f5f9; color:#0f172a}
    .btn-secondary:hover{background:#e5e7eb}
    .btn-primary{
      background:linear-gradient(135deg,var(--primary),var(--primary-dark));
      color:#fff;
    }
    .btn-primary:hover{transform:translateY(-1px); opacity:.97}

    .footer{margin-top:18px; text-align:center; font-size:13px; color:var(--muted)}
    .footer a{color:var(--primary); text-decoration:none; font-weight:700}
    .footer a:hover{text-decoration:underline}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="top">
        <i class="fa-solid fa-user-plus"></i>
        <h1>Buat Akun</h1>
      </div>
      <p class="subtitle">Langkah terakhir untuk menyelesaikan pendaftaran</p>

      <div class="mini">
        Data: <b><?php echo htmlspecialchars($name); ?></b> • NIK: <b><?php echo htmlspecialchars($nik); ?></b>
      </div>

      <form method="POST">
        <div class="group">
          <label class="label">Email</label>
          <div class="input-wrap">
            <i class="fa-solid fa-envelope icon"></i>
            <input class="input" type="email" name="newemail" placeholder="email@example.com" required>
          </div>
        </div>

        <div class="group">
          <label class="label">Nomor HP</label>
          <div class="input-wrap">
            <i class="fa-solid fa-phone icon"></i>
            <input class="input" type="tel" name="tele" placeholder="081234567890">
          </div>
        </div>

        <div class="group">
          <label class="label">Password</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock icon"></i>
            <input class="input" type="password" id="p1" name="newpassword" placeholder="Buat password" required>
            <i class="fa-solid fa-eye toggle" onclick="togglePass('p1', this)"></i>
          </div>
        </div>

        <div class="group">
          <label class="label">Konfirmasi Password</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock icon"></i>
            <input class="input" type="password" id="p2" name="cpassword" placeholder="Ulangi password" required>
            <i class="fa-solid fa-eye toggle" onclick="togglePass('p2', this)"></i>
          </div>
        </div>

        <?php if (!empty($error)) : ?>
          <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="actions">
          <button type="reset" class="btn btn-secondary">Ulangi</button>
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
      </form>

      <div class="footer">
        Sudah punya akun? <a href="login.php">Masuk di sini</a>
      </div>
    </div>
  </div>

<script>
  function togglePass(id, el){
    const inp = document.getElementById(id);
    if(inp.type === "password"){
      inp.type = "text";
      el.classList.replace("fa-eye","fa-eye-slash");
    }else{
      inp.type = "password";
      el.classList.replace("fa-eye-slash","fa-eye");
    }
  }
</script>
</body>
</html>

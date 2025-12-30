<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
    <title>Masuk | JanjiTemu</title>
</head>
<body>
    <?php
    session_start();
    $_SESSION["user"] = "";
    $_SESSION["usertype"] = "";
    date_default_timezone_set('Asia/Jakarta');
    $date = date('Y-m-d');
    $_SESSION["date"] = $date;
    
    include("connection.php");

    if($_POST) {
        $email = $_POST['useremail'];
        $password = $_POST['userpassword'];
        
        $error = '<label for="promter" class="form-label"></label>';

        $result = $database->query("SELECT * FROM webuser WHERE email='$email'");
        if($result->num_rows == 1) {
            $utype = $result->fetch_assoc()['usertype'];
            if ($utype == 'p') {
                $checker = $database->query("SELECT * FROM patient WHERE pemail='$email' AND ppassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'p';
                    header('location: patient/index.php');
                } else {
                    $error = '<label for="promter" class="form-label error-msg">Kredensial salah: Email atau password tidak valid</label>';
                }
            } elseif($utype == 'a') {
                $checker = $database->query("SELECT * FROM admin WHERE aemail='$email' AND apassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('location: admin/index.php');
                } else {
                    $error = '<label for="promter" class="form-label error-msg">Kredensial salah: Email atau password tidak valid</label>';
                }
            } elseif($utype == 'd') {
                $checker = $database->query("SELECT * FROM doctor WHERE docemail='$email' AND docpassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('location: doctor/index.php');
                } else {
                    $error = '<label for="promter" class="form-label error-msg">Kredensial salah: Email atau password tidak valid</label>';
                }
            }
        } else {
            $error = '<label for="promter" class="form-label error-msg">Tidak ditemukan akun dengan email tersebut</label>';
        }
    } else {
        $error = '<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>

    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <h1>Selamat Datang di <span>JanjiTemu Klinik Pratama Kencana Pamulang</span></h1>
                <p>Partner terpercaya dalam manajemen kesehatan. Masuk untuk mengakses layanan kesehatan personal.</p>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-user-md"></i>
                        <span>Dokter Berpengalaman</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Janji Temu Mudah</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Data Terproteksi</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="login-right">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>Selamat Datang Kembali!</h2>
                    <p>Masuk dengan detail akun Anda untuk melanjutkan</p>
                </div>
                
                <form action="" method="POST" class="login-form">
                    <div class="form-group">
                        <label for="useremail">Alamat Email</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="useremail" name="useremail" placeholder="Masukkan alamat email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="userpassword">Password</label>
                        <div class="input-with-icon">
                    
                            <input type="password" id="userpassword" name="userpassword" placeholder="Masukkan password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="forgot-password">Lupa password?</a>
                    </div>
                    
                    <?php echo $error ?>
                    
                    <button type="submit" class="login-button">
                        <span>Masuk</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <div class="divider">
                        <span>atau</span>
                    </div>
                    
                    <div class="social-login">
                        <button type="button" class="social-button google">
                            <i class="fab fa-google"></i> Masuk dengan Google
                        </button>
                        <button type="button" class="social-button facebook">
                            <i class="fab fa-facebook-f"></i> Masuk dengan Facebook
                        </button>
                    </div>
                    
                    <div class="signup-link">
                        Belum punya akun? <a href="signup.php">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('userpassword');
            const eyeIcon = document.querySelector('.toggle-password');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
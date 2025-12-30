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
    <link rel="stylesheet" href="css/signup.css">
    <title>Daftar | JanjiTemu+</title>
</head>
<body>
    <?php
    session_start();
    $_SESSION["user"]="";
    $_SESSION["usertype"]="";

    date_default_timezone_set('Asia/Jakarta');
    $date = date('Y-m-d');
    $_SESSION["date"]=$date;

    if($_POST){
        $_SESSION["personal"]=array(
            'fname'=>$_POST['fname'],
            'lname'=>$_POST['lname'],
            'address'=>$_POST['address'],
            'nik'=>$_POST['nik'],
            'dob'=>$_POST['dob']
        );
        header("location: create-account.php");
    }
    ?>

    <div class="signup-container">
        <div class="signup-left">
            <div class="signup-left-content">
                <h1>Bergabung dengan <span>Klinik Pratama Kencana+</span></h1>
                <p>Buat akun Anda untuk mengakses layanan kesehatan personal dan kelola rekam medis Anda di satu tempat yang aman.</p>
                <div class="benefits">
                    <div class="benefit-item">
                        <i class="fas fa-heartbeat"></i>
                        <span>Pelacakan Kesehatan Personal</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-clock"></i>
                        <span>Akses 24/7 ke Rekam Medis</span>
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Aman & Privasi Terjaga</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="signup-right">
            <div class="signup-form-container">
                <div class="signup-header">
                    <h2>Buat Akun Anda</h2>
                    <p>Isi data pribadi Anda untuk memulai</p>
                </div>
                
                <form action="" method="POST" class="signup-form">
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="fname">Nama Depan</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="fname" name="fname" placeholder="Masukkan nama depan" required>
                            </div>
                        </div>
                        <div class="form-group half-width">
                            <label for="lname">Nama Belakang</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="lname" name="lname" placeholder="Masukkan nama belakang" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat Lengkap</label>
                        <div class="input-with-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="address" name="address" placeholder="Masukkan alamat lengkap" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nik">Nomor NIK</label>
                        <div class="input-with-icon">
                            <i class="fas fa-id-card"></i>
                            <input type="text" id="nik" name="nik" placeholder="Masukkan nomor NIK" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="dob">Tanggal Lahir</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar-day"></i>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="reset" class="secondary-button">
                            <i class="fas fa-redo"></i> Ulangi
                        </button>
                        <button type="submit" class="primary-button">
                            <span>Lanjutkan</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    
                    <div class="login-link">
                        Sudah punya akun? <a href="login.php">Masuk disini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Untuk tampilan date input yang lebih baik
        document.getElementById('dob').addEventListener('focus', function() {
            this.type = 'date';
        });
        
        document.getElementById('dob').addEventListener('blur', function() {
            if(!this.value) this.type = 'text';
        });

        // Validasi NIK (16 digit angka)
        document.getElementById('nik').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>
</body>
</html>
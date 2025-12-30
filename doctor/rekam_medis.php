<?php
include("../connection.php");
session_start();

// Check session and user type
if(!isset($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}

if($_SESSION['usertype'] != 'd') {
    header("location: ../login.php");
    exit();
}

$useremail = $_SESSION["user"];

// Get doctor info
$userrow = $database->query("SELECT * FROM doctor WHERE docemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["docid"];
$username = $userfetch["docname"];

// Handle POST requests
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle rekam medis form submission
    if(isset($_POST['nama_pasien'])) {
        $nama_pasien = $_POST['nama_pasien'];
        $keluhan = $_POST['keluhan'];
        $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
        $diagnosis = $_POST['diagnosis'];
        $resep_obat = $_POST['resep_obat'];
        $tindakan = isset($_POST['tindakan']) ? $_POST['tindakan'] : '';

        $sql = "INSERT INTO rekam_medis (nama_pasien, keluhan, tanggal_kunjungan, diagnosis, resep_obat) 
                VALUES ('$nama_pasien', '$keluhan', '$tanggal_kunjungan', '$diagnosis', '$resep_obat')";

        if($database->query($sql) === TRUE) {
            echo "<script>alert('Data rekam medis berhasil disimpan.'); window.location.href='rekam_medis.php';</script>";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $database->error;
        }
    }
    
    // Handle search form submission
    if(isset($_POST["search"])) {
        $keyword = $_POST["search12"];
        $sqlmain = "SELECT * FROM rekam_medis WHERE 
                   nama_pasien='$keyword' OR 
                   nama_pasien LIKE '$keyword%' OR 
                   nama_pasien LIKE '%$keyword' OR 
                   nama_pasien LIKE '%$keyword%'";
        $selecttype = "Hasil Pencarian";
        $current = "Hasil pencarian untuk: $keyword";
    }
    
    // Handle filter form submission
    if(isset($_POST["filter"])) {
        $sqlmain = "SELECT * FROM rekam_medis";
        $selecttype = "Semua";
        $current = "Semua Rekam Medis";
    }
} else {
    // Default query - semua rekam medis
    $sqlmain = "SELECT * FROM rekam_medis";
    $selecttype = "Semua";
    $current = "Semua Rekam Medis";
}

$result = $database->query($sqlmain);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Rekam Medis</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <div class="container">
        <button id="menuToggle" class="menu-toggle-btn">&#9776; Menu</button>
        <div class="menu" id="sidebarMenu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row">
    <td class="menu-btn">
        <a href="index.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/dashboard-hover.svg" class="menu-icon" alt="Dashboard">
            <span class="menu-text">Dashboard</span>
        </a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn">
        <a href="appointment.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/book-hover.svg" class="menu-icon" alt="Appointments">
            <span class="menu-text">My Appointments</span>
        </a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn">
        <a href="schedule.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/session-iceblue.svg" class="menu-icon" alt="Sessions">
            <span class="menu-text">My Sessions</span>
        </a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn">
        <a href="patient.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/patients-hover.svg" class="menu-icon" alt="Patients">
            <span class="menu-text">My Patients</span>
        </a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn menu-active">
        <a href="rekam_medis.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/medical-blue.svg" class="menu-icon" alt="Rekam Medis">
            <span class="menu-text">Rekam Medis</span>
        </a>
    </td>
</tr>
<tr class="menu-row">
    <td class="menu-btn">
        <a href="settings.php" class="non-style-link-menu menu-link">
            <img src="../img/icons/settings-iceblue.svg" class="menu-icon" alt="Settings">
            <span class="menu-text">Settings</span>
        </a>
    </td>
</tr>
                
            </table>
        </div>
        
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <!-- Form Search -->
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="Search Nama Pasien" list="patient">&nbsp;&nbsp;
                            
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query("SELECT DISTINCT nama_pasien FROM rekam_medis");
                                while($row = $list11->fetch_assoc()) {
                                    echo "<option value='".$row['nama_pasien']."'>";
                                }
                                echo '</datalist>';
                            ?>
                           
                            <input type="submit" value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php echo date('Y-m-d'); ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
               
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            <?php echo $selecttype." Rekam Medis (".$result->num_rows.")"; ?>
                        </p>
                        <button class="btn btn-primary my-3" onclick="document.getElementById('modalForm').style.display='block'">
                            Tambah Data Rekam Medis
                        </button>
                    </td>   
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;">
                        <center>
                            <!-- Form Filter -->
                            <form action="" method="post">
                            <table class="filter-container" border="0">
                                <tr>
                                    <td style="text-align: right;">
                                        Tampilkan: &nbsp;
                                    </td>
                                    <td width="30%">
                                        <select name="showonly" class="box filter-container-items" style="width:90%; height: 37px; margin: 0;">
                                            <option value="" disabled selected hidden><?php echo $current ?></option>
                                            <option value="all">Semua</option>
                                        </select>
                                    </td>
                                    <td width="12%">
                                        <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin:0; width:100%">
                                    </td>
                                </tr>
                            </table>
                            </form>
                        </center>
                    </td>
                </tr>
                
                <!-- Tabel hasil rekam medis -->
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">ID</th>
                                            <th class="table-headin">Nama Pasien</th>
                                            <th class="table-headin">Keluhan</th>
                                            <th class="table-headin">Diagnosis</th>
                                            <th class="table-headin">Tanggal Kunjungan</th>
                                            <th class="table-headin">Resep Obat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) { 
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['nama_pasien'] ?></td>
                                            <td><?= $row['keluhan'] ?></td>
                                            <td><?= $row['diagnosis'] ?></td>
                                            <td><?= $row['tanggal_kunjungan'] ?></td>
                                            <td><?= $row['resep_obat'] ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data rekam medis</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td> 
                </tr>       
            </table>
        </div>
    </div>

    <!-- Modal form untuk tambah rekam medis -->
    <div id="modalForm" class="overlay" style="display:none;">
        <div class="popup">
            <center>
                <a class="close" onclick="document.getElementById('modalForm').style.display='none'">&times;</a>
                <div class="content">
                    <h2>Tambah Rekam Medis</h2>
                </div>
                <div style="display: flex; justify-content: center;">
                    <form action="" method="POST">
                        <table class="sub-table scrolldown add-doc-form-container" style="width:90%;" border="0">
                            <tr><td class="label-td">Nama Pasien:</td></tr>
                            <tr><td class="label-td"><input type="text" name="nama_pasien" class="input-text" required></td></tr>

                            <tr><td class="label-td">Keluhan:</td></tr>
                            <tr><td class="label-td"><input type="text" name="keluhan" class="input-text" required></td></tr>

                            <tr><td class="label-td">Tanggal Kunjungan:</td></tr>
                            <tr><td class="label-td"><input type="date" name="tanggal_kunjungan" class="input-text" required></td></tr>

                            <tr><td class="label-td">Diagnosis:</td></tr>
                            <tr><td class="label-td"><input type="text" name="diagnosis" class="input-text" required></td></tr>

                            <tr><td class="label-td">Resep Obat:</td></tr>
                            <tr><td class="label-td"><input type="text" name="resep_obat" class="input-text"></td></tr>

                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Simpan" class="login-btn btn-primary btn" style="margin-top:15px;">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </center>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.getElementById("menuToggle");
        const sidebarMenu = document.getElementById("sidebarMenu");
        const overlay = document.getElementById("overlay");

        menuToggle.addEventListener("click", function () {
            sidebarMenu.classList.add("active");
            overlay.classList.add("active");
        });

        overlay.addEventListener("click", function () {
            sidebarMenu.classList.remove("active");
            overlay.classList.remove("active");
        });
    });
</script>
</body>
</html>
<?php
include 'koneksi.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];
    $foto = $_FILES['foto']['name'];
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto);
       
        $query = "INSERT INTO wisatareligi (nama, email, pesan, foto) VALUES ('$nama', '$email', '$pesan', '$foto')";

        if (mysqli_query($conn, $query)) {
            echo "Data berhasil disimpan!";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }


mysqli_close($conn);
?>

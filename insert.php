<?php
// Koneksi ke database
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];
    $foto = '';

    // Cek apakah ada file yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Folder tempat file akan diunggah
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar sebenarnya adalah gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File yang diunggah bukan gambar.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["foto"]["size"] > 500000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Hanya izinkan format tertentu
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk diset ke 0 oleh kesalahan
        if ($uploadOk == 0) {
            echo "Maaf, file Anda tidak diunggah.";
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto = basename($_FILES["foto"]["name"]); // Simpan nama file
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        }
    }

    // Simpan data ke database
    $stmt = $conn->prepare("INSERT INTO wisatareligi (Nama, Email, Pesan, Foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $pesan, $foto);

    if ($stmt->execute()) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Kesalahan: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

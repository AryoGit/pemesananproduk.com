<?php
// PHP untuk mengelola logika pemesanan produk dan pengiriman email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mengimpor PHPMailer
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = $_POST["product"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $quantity = $_POST["quantity"];
    
    // Validasi input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($name) || empty($address) || !is_numeric($quantity) || $quantity < 1) {
        echo "Harap isi semua bidang dengan benar.";
        exit;
    }

    // Proses pemesanan (misalnya, penyimpanan ke database)
    // Anda dapat menambahkan logika penyimpanan ke database di sini

    // Mengirim email ke Gmail
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aryo3242@gmail.com'; // Ganti dengan email Gmail Anda
        $mail->Password = 'konfirmasi'; // Ganti dengan kata sandi email Gmail Anda
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set pengirim dan penerima email
        $mail->setFrom('aryo3242@gmail.com', 'Nama Anda');
        $mail->addAddress('aryo3242@gmail.com', 'Nama Penerima');

        // Isi email
        $mail->isHTML(true);
        $mail->Subject = 'Pemesanan Produk';
        $mail->Body = "Terima kasih, $name!<br>Pesanan Anda untuk $product sejumlah $quantity telah diterima.<br>Alamat pengiriman: $address";

        $mail->send();
        echo 'Pesan telah berhasil dikirim.';
    } catch (Exception $e) {
        echo 'Pesan tidak dapat dikirim: ', $mail->ErrorInfo;
    }
}
?>

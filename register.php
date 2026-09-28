<?php
require_once __DIR__ . '/config.php';

$pesan = '';
$tipe = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi'] ?? '';

    if ($nama === '' || $whatsapp === '' || $email === '' || $password === '' || $konfirmasi === '') {

        $pesan = 'Semua kolom wajib diisi.';
        $tipe = 'error';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $pesan = 'Format email tidak valid.';
        $tipe = 'error';

    } elseif (strlen($password) < 6) {

        $pesan = 'Password minimal 6 karakter.';
        $tipe = 'error';

    } elseif ($password !== $konfirmasi) {

        $pesan = 'Konfirmasi password tidak sama.';
        $tipe = 'error';

    } else {

        $cek = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $cek->execute([$email]);

        if ($cek->fetch()) {

            $pesan = 'Email sudah terdaftar.';
            $tipe = 'error';

        } else {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users 
                (nama, whatsapp, email, password)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([
                $nama,
                $whatsapp,
                $email,
                $passwordHash
            ]);

            header('Location: login_user.php?registered=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi - AMS Barbershop</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: #1b1b1b;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,.5);
        }

        .logo {
            text-align: center;
            font-size: 38px;
            font-weight: bold;
            letter-spacing: 5px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #aaa;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 13px 15px;
            background: #111;
            color: white;
            border: 1px solid #444;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: white;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: white;
            color: #111;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #ddd;
        }

        .pesan {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .error {
            background: #4a1f1f;
            color: #ffb3b3;
        }

        .login {
            text-align: center;
            margin-top: 22px;
            color: #aaa;
        }

        .login a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .home {
            text-align: center;
            margin-top: 15px;
        }

        .home a {
            color: #888;
            text-decoration: none;
            font-size: 14px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="logo">AMS</div>

    <div class="subtitle">
        Registrasi Pelanggan
    </div>

    <?php if ($pesan !== ''): ?>

        <div class="pesan <?= htmlspecialchars($tipe) ?>">
            <?= htmlspecialchars($pesan) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label>Nama Lengkap</label>

            <input
                type="text"
                name="nama"
                placeholder="Masukkan nama lengkap"
                value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Nomor WhatsApp</label>

            <input
                type="text"
                name="whatsapp"
                placeholder="Contoh: 081234567890"
                value="<?= htmlspecialchars($_POST['whatsapp'] ?? '') ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Minimal 6 karakter"
                required
            >

        </div>

        <div class="form-group">

            <label>Konfirmasi Password</label>

            <input
                type="password"
                name="konfirmasi"
                placeholder="Ulangi password"
                required
            >

        </div>

        <button type="submit" class="btn">
            Daftar Sekarang
        </button>

    </form>

    <div class="login">

        Sudah punya akun?

        <a href="login_user.php">
            Login User
        </a>

    </div>

    <div class="home">

        <a href="index.php">
            ← Kembali ke Beranda
        </a>

    </div>

</div>

</body>

</html>
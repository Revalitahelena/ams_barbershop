<?php
require_once __DIR__ . '/config.php';

$pesan = '';
$tipe = '';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_GET['registered'])) {
    $pesan = 'Registrasi berhasil. Silakan login.';
    $tipe = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {

        $pesan = 'Email dan password wajib diisi.';
        $tipe = 'error';

    } else {

        $stmt = $pdo->prepare("
            SELECT id, nama, whatsapp, email, password
            FROM users
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_whatsapp'] = $user['whatsapp'];

            header('Location: index.php');
            exit;

        } else {

            $pesan = 'Email atau password salah.';
            $tipe = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login User - AMS Barbershop</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 430px;
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
        }

        .subtitle {
            text-align: center;
            color: #aaa;
            margin: 8px 0 30px;
        }

        .pesan {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: #4a1f1f;
            color: #ffb3b3;
        }

        .success {
            background: #1f4a2a;
            color: #b7ffca;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 13px;
            background: #111;
            color: white;
            border: 1px solid #444;
            border-radius: 8px;
            outline: none;
        }

        input:focus {
            border-color: white;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: white;
            color: #111;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #ddd;
        }

        .register {
            text-align: center;
            margin-top: 22px;
            color: #aaa;
        }

        .register a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .home {
            text-align: center;
            margin-top: 15px;
        }

        .home a {
            color: #888;
            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="logo">AMS</div>

    <div class="subtitle">
        Login Pelanggan
    </div>

    <?php if ($pesan !== ''): ?>

        <div class="pesan <?= htmlspecialchars($tipe) ?>">
            <?= htmlspecialchars($pesan) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Masukkan email"
                required
            >

        </div>

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

        </div>

        <button type="submit" class="btn">
            Login User
        </button>

    </form>

    <div class="register">

        Belum punya akun?

        <a href="register.php">
            Daftar Sekarang
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
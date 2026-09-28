<?php
require_once __DIR__ . '/config.php';
if(isset($_SESSION['admin_id'])){header('Location: admin/dashboard.php');exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username=trim($_POST['username']??'');
    $password=$_POST['password']??'';
    $stmt=$pdo->prepare("SELECT * FROM admins WHERE username=? LIMIT 1");
    $stmt->execute([$username]);
    $admin=$stmt->fetch();
    if($admin && password_verify($password,$admin['password'])){
        $_SESSION['admin_id']=$admin['id'];
        $_SESSION['admin_nama']=$admin['nama'];
        header('Location: admin/dashboard.php');exit;
    }
    $error='Username atau password salah.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login Admin - AMS</title><style>
body{margin:0;background:#111;color:#eee;font-family:Arial;display:grid;place-items:center;min-height:100vh}.box{width:min(400px,90%);padding:30px;border:1px solid #51452b;background:#191919}
input{width:100%;box-sizing:border-box;padding:12px;margin:7px 0 15px;background:#111;color:#fff;border:1px solid #51452b}button{padding:12px;width:100%;background:#c9a84c;border:0}a{color:#c9a84c}
</style></head><body><div class="box"><h1>AMS Admin</h1>
<?php if($error):?><p style="color:#e06b6b"><?=htmlspecialchars($error)?></p><?php endif;?>
<form method="post"><label>Username</label><input name="username" required><label>Password</label><input type="password" name="password" required><button>LOGIN</button></form>
<p><a href="../index.php">← Kembali ke website</a></p></div></body></html>

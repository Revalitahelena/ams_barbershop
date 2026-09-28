<?php
require_once __DIR__.'/../includes/auth.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id']??0);$status=$_POST['status']??'pending';
 $allowed=['pending','confirmed','done','cancelled'];
 if(in_array($status,$allowed,true)){ $st=$pdo->prepare("UPDATE bookings SET status=? WHERE id=?");$st->execute([$status,$id]); }
 header('Location: bookings.php');exit;
}
$rows=$pdo->query("SELECT * FROM bookings ORDER BY id DESC")->fetchAll();
$pageTitle='Manajemen Booking';$activeMenu='bookings';require __DIR__.'/includes/layout_top.php';
?>
<div class="panel"><div class="table-wrap"><table><thead><tr><th>ID</th><th>Nama</th><th>WhatsApp</th><th>Layanan</th><th>Barber</th><th>Tanggal</th><th>Jam</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr>
<td><?=htmlspecialchars($r['id'])?></td><td><?=htmlspecialchars($r['nama'])?></td><td><?=htmlspecialchars($r['whatsapp'])?></td><td><?=htmlspecialchars($r['layanan'])?></td><td><?=htmlspecialchars($r['barber'])?></td><td><?=htmlspecialchars($r['tanggal'])?></td><td><?=htmlspecialchars($r['jam'])?></td><td><?=htmlspecialchars($r['status'])?></td>
<td><form method="post" class="actions"><input type="hidden" name="id" value="<?=$r['id']?>"><select name="status"><option>pending</option><option>confirmed</option><option>done</option><option>cancelled</option></select><button>Update</button></form></td>
</tr><?php endforeach; ?></tbody></table></div></div>
<?php require __DIR__.'/includes/layout_bottom.php'; ?>

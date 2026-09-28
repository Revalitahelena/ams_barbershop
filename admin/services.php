<?php
require_once __DIR__.'/../includes/auth.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $action=$_POST['action']??'';$id=(int)($_POST['id']??0);
 if($action==='delete'){$s=$pdo->prepare("DELETE FROM services WHERE id=?");$s->execute([$id]);}
 if($action==='save'){$nama=trim($_POST['nama']??'');$harga=(int)($_POST['harga']??0);$deskripsi=trim($_POST['deskripsi']??'');$foto=trim($_POST['foto']??'');if($id){$s=$pdo->prepare("UPDATE services SET nama=?,harga=?,deskripsi=?,foto=? WHERE id=?");$s->execute([$nama,$harga,$deskripsi,$foto,$id]);}else{$s=$pdo->prepare("INSERT INTO services(nama,harga,deskripsi,foto) VALUES(?,?,?,?)");$s->execute([$nama,$harga,$deskripsi,$foto]);}}
 header('Location: services.php');exit;
}
$edit=null;if(isset($_GET['edit'])){$s=$pdo->prepare("SELECT * FROM services WHERE id=?");$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
$rows=$pdo->query("SELECT * FROM services ORDER BY id ASC")->fetchAll();$pageTitle='Manajemen Layanan';$activeMenu='services';require __DIR__.'/includes/layout_top.php';
?>
<div class="panel"><form method="post" class="form-grid"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=htmlspecialchars($edit['id']??0)?>">
<div><label>Nama</label><input name="nama" required value="<?=htmlspecialchars($edit['nama']??'')?>"></div><div><label>Harga</label><input type="number" name="harga" required value="<?=htmlspecialchars($edit['harga']??0)?>"></div>
<div class="full"><label>Deskripsi</label><textarea name="deskripsi"><?=htmlspecialchars($edit['deskripsi']??'')?></textarea></div><div class="full"><label>URL Foto</label><input name="foto" value="<?=htmlspecialchars($edit['foto']??'')?>"></div>
<div class="full"><button><?= $edit?'Update':'Tambah' ?></button></div></form></div>
<div class="panel"><div class="table-wrap"><table><tr><th>Nama</th><th>Harga</th><th>Deskripsi</th><th>Aksi</th></tr>
<?php foreach($rows as $r):?><tr><td><?=htmlspecialchars($r['nama'])?></td><td>Rp <?=number_format($r['harga'],0,',','.')?></td><td><?=htmlspecialchars($r['deskripsi'])?></td><td><a class="btn" href="?edit=<?=$r['id']?>">Edit</a><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$r['id']?>"><button>Hapus</button></form></td></tr><?php endforeach;?></table></div></div>
<?php require __DIR__.'/includes/layout_bottom.php'; ?>

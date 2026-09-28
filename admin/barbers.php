<?php
require_once __DIR__ . '/../includes/auth.php';
 
$message = '';
$editItem = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $stmt = $pdo->prepare("DELETE FROM barbers WHERE id = ?");
    $stmt->execute([(int) $_POST['id']]);
    $message = 'Barber berhasil dihapus.';
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save') {
    $id      = (int) ($_POST['id'] ?? 0);
    $nama    = trim($_POST['nama'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $foto    = trim($_POST['foto'] ?? '');
    $skills  = trim($_POST['skills'] ?? '');
    $urutan  = (int) ($_POST['urutan'] ?? 0);
    $status  = $_POST['status'] === 'nonaktif' ? 'nonaktif' : 'aktif';
 
    if ($nama === '' || $foto === '') {
        $message = 'Nama dan URL foto wajib diisi.';
    } elseif ($id > 0) {
        $stmt = $pdo->prepare("UPDATE barbers SET nama=?, jabatan=?, foto=?, skills=?, urutan=?, status=? WHERE id=?");
        $stmt->execute([$nama, $jabatan, $foto, $skills, $urutan, $status, $id]);
        $message = 'Data barber berhasil diperbarui.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO barbers (nama, jabatan, foto, skills, urutan, status) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nama, $jabatan, $foto, $skills, $urutan, $status]);
        $message = 'Barber baru berhasil ditambahkan.';
    }
}
 
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM barbers WHERE id = ?");
    $stmt->execute([(int) $_GET['edit']]);
    $editItem = $stmt->fetch();
}
 
$barbers = $pdo->query("SELECT * FROM barbers ORDER BY urutan ASC, id ASC")->fetchAll();
 
$pageTitle = 'Manajemen Barber';
$activeMenu = 'barbers';
require __DIR__ . '/includes/layout_top.php';
?>
 
<?php if ($message): ?>
  <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
 
<div class="panel">
  <div class="panel-head"><h2><?= $editItem ? 'Edit Barber' : 'Tambah Barber Baru' ?></h2></div>
  <div class="panel-body">
    <form method="POST">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= $editItem['id'] ?? 0 ?>">
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Nama</label>
          <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($editItem['nama'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Jabatan</label>
          <input type="text" name="jabatan" class="form-control" placeholder="Senior Barber" value="<?= htmlspecialchars($editItem['jabatan'] ?? '') ?>">
        </div>
        <div class="form-group full">
          <label class="form-label">URL Foto</label>
          <input type="text" name="foto" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($editItem['foto'] ?? '') ?>" required>
        </div>
        <div class="form-group full">
          <label class="form-label">Skills (pisahkan dengan koma)</label>
          <input type="text" name="skills" class="form-control" placeholder="Fade, Classic Cut, Beard Art" value="<?= htmlspecialchars($editItem['skills'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label class="form-label">Urutan Tampil</label>
          <input type="number" name="urutan" class="form-control" value="<?= htmlspecialchars($editItem['urutan'] ?? 0) ?>">
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-control">
            <option value="aktif" <?= ($editItem['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="nonaktif" <?= ($editItem['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-solid"><?= $editItem ? 'Simpan Perubahan' : 'Tambah Barber' ?></button>
      <?php if ($editItem): ?><a href="barbers.php" class="btn">Batal</a><?php endif; ?>
    </form>
  </div>
</div>
 
<div class="panel">
  <div class="panel-head"><h2>Daftar Barber (<?= count($barbers) ?>)</h2></div>
  <div class="panel-body">
    <?php if (!$barbers): ?>
      <div class="empty-state">Belum ada barber.</div>
    <?php else: ?>
    <div class="card-grid">
      <?php foreach ($barbers as $b): ?>
      <div class="item-card">
        <img src="<?= htmlspecialchars($b['foto']) ?>" alt="<?= htmlspecialchars($b['nama']) ?>">
        <div class="item-card-body">
          <h3><?= htmlspecialchars($b['nama']) ?></h3>
          <div class="muted" style="font-size:12px;"><?= htmlspecialchars($b['jabatan']) ?></div>
          <div class="muted" style="font-size:11.5px;margin-top:4px;"><span class="badge badge-<?= $b['status'] === 'aktif' ? 'confirmed' : 'cancelled' ?>"><?= ucfirst($b['status']) ?></span></div>
          <div class="item-card-actions">
            <a href="barbers.php?edit=<?= $b['id'] ?>" class="btn btn-sm">Edit</a>
            <form method="POST" onsubmit="return confirm('Hapus barber ini?');">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $b['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>
 
<?php require __DIR__ . '/includes/layout_bottom.php'; ?>
 
<?php
if(!isset($pageTitle)) $pageTitle='AMS Admin';
if(!isset($activeMenu)) $activeMenu='';
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=htmlspecialchars($pageTitle)?> - AMS</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>body{margin:0;background:#111;color:#eee;font-family:Arial}.admin-wrap{display:flex;min-height:100vh}.side{width:230px;background:#181818;padding:25px;box-sizing:border-box}.side a{display:block;padding:12px;color:#bbb;text-decoration:none}.side a.active,.side a:hover{color:#c9a84c}.main{flex:1;padding:30px;overflow:auto}.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px}.btn{padding:8px 14px;border:1px solid #c9a84c;color:#c9a84c;text-decoration:none;background:transparent}.table-wrap{overflow:auto}.panel{background:#191919;padding:20px;margin-bottom:20px;border:1px solid #39301f}table{width:100%;border-collapse:collapse}th,td{padding:11px;border-bottom:1px solid #333;text-align:left}input,select,textarea{box-sizing:border-box;background:#111;color:#eee;border:1px solid #51452b;padding:10px;width:100%}.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.full{grid-column:1/-1}.actions{display:flex;gap:7px}@media(max-width:800px){.side{width:170px}.form-grid{grid-template-columns:1fr}.full{grid-column:auto}}</style>
</head><body><div class="admin-wrap"><aside class="side"><h2>AMS</h2>
<a class="<?= $activeMenu==='dashboard'?'active':''?>" href="dashboard.php">Dashboard</a>
<a class="<?= $activeMenu==='bookings'?'active':''?>" href="bookings.php">Bookings</a>
<a class="<?= $activeMenu==='services'?'active':''?>" href="services.php">Services</a>
<a class="<?= $activeMenu==='barbers'?'active':''?>" href="barbers.php">Barbers</a>
<a href="../index.php">Website</a><a href="../logout.php">Logout</a></aside><main class="main">
<div class="top"><h1><?=htmlspecialchars($pageTitle)?></h1><span><?=htmlspecialchars($_SESSION['admin_nama']??'Admin')?></span></div>

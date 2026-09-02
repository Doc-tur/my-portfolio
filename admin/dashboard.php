<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$projects=(int)$conn->query("SELECT COUNT(*) c FROM projects")->fetch_assoc()['c'];
$skills=(int)$conn->query("SELECT COUNT(*) c FROM skills")->fetch_assoc()['c'];
$messages=(int)$conn->query("SELECT COUNT(*) c FROM messages")->fetch_assoc()['c'];
$unread=(int)$conn->query("SELECT COUNT(*) c FROM messages WHERE is_read=0")->fetch_assoc()['c'];
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | CMS Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark admin-nav">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php">Emiabata Mukhtar</a>
        <div>
            <span class="text-secondary me-3">Hi, <?=e($_SESSION['admin_name'])?></span>
            <a href="../auth/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="section-kicker">CMS</span>
            <h1>Dashboard</h1>
        </div>
        <a href="add_project.php" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Project
        </a>
    </div>
    <div class="row g-4 mb-5">
        <?php foreach([['Projects',$projects,'bi-grid'],['Skills',$skills,'bi-lightning'],['Messages',$messages,'bi-envelope'],['Unread',$unread,'bi-bell']] as $x): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="metric-card">
                    <i class="bi <?=$x[2]?>"></i>
                    <div>
                        <strong><?=$x[1]?></strong>
                        <span><?=$x[0]?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="admin-links">
        <a href="projects.php"><i class="bi bi-grid"></i> Manage Projects</a>
        <a href="messages.php"><i class="bi bi-envelope"></i> Messages</a>
        <a href="profile.php"><i class="bi bi-person"></i> Profile</a>
        <a href="../projects.php" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Portfolio</a>
    </div>
</div>
</body>
</html>

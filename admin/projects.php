<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$projects=$conn->query("SELECT * FROM projects ORDER BY created_at DESC");
$msg=flash('success');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Projects</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="dashboard.php" class="text-secondary">← Dashboard</a>
                <h1 class="mt-2">Projects</h1>
            </div>
            <a href="add_project.php" class="btn btn-accent align-self-center">+ Add Project</a>
        </div>
        <?php if($msg): ?>
            <div class="alert alert-success"><?=e($msg)?></div>
        <?php endif; ?>
        <div class="table-responsive admin-table">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p=$projects->fetch_assoc()): ?>
                        <tr>
                            <td><?=e($p['title'])?></td>
                            <td><?=e($p['category'])?></td>
                            <td><?=$p['featured']?'Yes':'No'?></td>
                            <td><?=e(date('M d, Y',strtotime($p['created_at'])))?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-light" href="edit_project.php?id=<?=$p['id']?>">Edit</a>
                                <a onclick="return confirm('Delete this project?')" class="btn btn-sm btn-outline-danger" href="delete_project.php?id=<?=$p['id']?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

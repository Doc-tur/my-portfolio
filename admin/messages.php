<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

if(isset($_GET['read'])){
  $id=(int)$_GET['read'];
  $st=$conn->prepare("UPDATE messages SET is_read=1 WHERE id=?");
  $st->bind_param("i",$id);$st->execute();
}

if(isset($_GET['delete'])){
  $id=(int)$_GET['delete'];
  $st=$conn->prepare("DELETE FROM messages WHERE id=?");
  $st->bind_param("i",$id);
  $st->execute();
  header('Location: messages.php');
  exit;
}
$messages=$conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Messages</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="dashboard.php" class="text-secondary">← Dashboard</a>
        <h1 class="mt-3">Messages</h1>
        <div class="table-responsive admin-table mt-4">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($m=$messages->fetch_assoc()): ?>
                    <tr>
                        <td><?=e($m['name'])?></td>
                        <td><?=e($m['email'])?></td>
                        <td><?=e($m['subject'])?></td>
                        <td><?=e(mb_strimwidth($m['message'],0,90,'...'))?></td>
                        <td><?=e(date('M d, Y',strtotime($m['created_at'])))?></td>
                        <td>
                            <?php if(!$m['is_read']): ?>
                                <a class="btn btn-sm btn-outline-light" href="?read=<?=$m['id']?>">Read</a>
                            <?php endif; ?>
                            <a onclick="return confirm('Delete message?')" class="btn btn-sm btn-outline-danger" href="?delete=<?=$m['id']?>">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

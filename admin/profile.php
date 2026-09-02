<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$id=(int)$_SESSION['admin_id']; 
$st=$conn->prepare("SELECT * FROM admins WHERE id=?");
$st->bind_param("i",$id);
$st->execute();
$admin=$st->get_result()->fetch_assoc();
$msg='';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']);
  $email=trim($_POST['email']);
  $password=$_POST['password']??'';
  if($password){
    $hash=password_hash($password,PASSWORD_DEFAULT);
    $st=$conn->prepare("UPDATE admins SET name=?,email=?,password=? WHERE id=?");
    $st->bind_param("sssi",$name,$email,$hash,$id);
  } else {
    $st=$conn->prepare("UPDATE admins SET name=?,email=? WHERE id=?");
    $st->bind_param("ssi",$name,$email,$id);
  }
  $st->execute();
  $_SESSION['admin_name']=$name;
  $msg='Profile updated successfully.';
  $admin['name']=$name;
  $admin['email']=$email;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="dashboard.php" class="text-secondary">← Dashboard</a>
        <h1 class="mt-3">Admin Profile</h1>
        <?php if($msg): ?>
            <div class="alert alert-success"><?=e($msg)?></div>
        <?php endif; ?>
        <form method="post" class="admin-form mt-4" style="max-width:700px">
            <label>Name</label>
            <input name="name" class="form-control mb-3" value="<?=e($admin['name'])?>" required>
            <label>Email</label>
            <input type="email" name="email" class="form-control mb-3" value="<?=e($admin['email'])?>" required>
            <label>New Password <small>(leave blank to keep current)</small></label>
            <input type="password" name="password" class="form-control mb-3" minlength="6">
            <button class="btn btn-accent">Update Profile</button>
        </form>
    </div>
</body>
</html>

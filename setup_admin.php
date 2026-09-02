<?php
require_once 'includes/db.php';
$message=''; $error='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');
    $email=trim($_POST['email']??'');
    $password=$_POST['password']??'';
    
    if(!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<6){$error='Enter a name, valid email and password of at least 6 characters.';}
    else{$hash=password_hash($password,PASSWORD_DEFAULT);
    $st=$conn->prepare("INSERT INTO admins(name,email,password) VALUES(?,?,?)");$st->bind_param("sss",$name,$email,$hash);
    if($st->execute())$message='Admin created. Delete setup_admin.php now, then login.';
    else$error='Could not create admin. The email may already exist.';}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Create Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
<div class="auth-card">
    <h2>Create Admin</h2>
    <p class="text-secondary">Run this once after importing the database.</p>
    <?php if($message): ?>
    <div class="alert alert-success"><?=e($message)?></div>
    <a class="btn btn-accent w-100" href="auth/login.php">Go to Login</a>
    <?php endif;?>
    <?php if($error): ?>
    <div class="alert alert-danger"><?=e($error)?></div>
    <?php endif;?>
    <form method="post">
        <input name="name" class="form-control mb-3" placeholder="Your name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Admin email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" minlength="6" required>
        <button class="btn btn-accent w-100">Create Admin</button>
    </form>
</div>
</body>
</html>

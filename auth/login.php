<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php';

if(isLoggedIn()){
    header('Location: ../admin/dashboard.php'); 
    exit;
}

$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']??''); 
    $password=$_POST['password']??'';
    $st=$conn->prepare("SELECT * FROM admins WHERE email=? LIMIT 1"); $st->bind_param("s",$email); 
    $st->execute(); 
    $admin=$st->get_result()->fetch_assoc();
    if($admin && password_verify($password,$admin['password'])){
        session_regenerate_id(true); 
        $_SESSION['admin_id']=$admin['id']; 
        $_SESSION['admin_name']=$admin['name']; 
        
        header('Location: ../admin/dashboard.php'); 
        exit;
    }
    $error='Invalid email or password.';
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-card">
        <h2>Admin Login</h2>
        <p class="text-secondary">Manage your portfolio projects.</p>
        <?php if($error): ?>
            <div class="alert alert-danger"><?=e($error)?></div>
        <?php endif; ?>
        <form method="post">
            <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
            <button class="btn btn-accent w-100">Sign In</button>
        </form>
        <a class="small d-block mt-3 text-center text-secondary" href="../index.php">← Back to portfolio</a>
    </div>
</body>
</html>

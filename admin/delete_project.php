<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$id=(int)($_GET['id']??0); 
$st=$conn->prepare("DELETE FROM projects WHERE id=?"); 
$st->bind_param("i",$id); 
$st->execute(); 
flash('success','Project deleted.'); 

header('Location: projects.php'); 
exit;

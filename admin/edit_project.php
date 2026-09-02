<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$id=(int)($_GET['id']??0); 
$st=$conn->prepare("SELECT * FROM projects WHERE id=?"); 
$st->bind_param("i",$id); 
$st->execute(); 
$p=$st->get_result()->fetch_assoc(); 
if(!$p) die('Project not found.');

$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']??''); 
    $category=trim($_POST['category']??''); 
    $description=trim($_POST['description']??''); 
    $tech=trim($_POST['technologies']??''); 
    $url=trim($_POST['website_url']??''); 
    $github=trim($_POST['github_url']??''); 
    $featured=isset($_POST['featured'])?1:0;
    $image=$p['image']; 
    if(isset($_FILES['image']) && $_FILES['image']['error']!==UPLOAD_ERR_NO_FILE){
        $new=uploadProjectImage($_FILES['image']); 
        if($new===false)$error='Invalid image.'; 
        else $image=$new;
    }
    if(!$error && $title&&$category&&$description){$st=$conn->prepare("UPDATE projects SET title=?,category=?,description=?,technologies=?,image=?,website_url=?,github_url=?,featured=? WHERE id=?");$st->bind_param("sssssssii",$title,$category,$description,$tech,$image,$url,$github,$featured,$id);$st->execute();flash('success','Project updated successfully.');
    
    header('Location: projects.php');
    exit;
    }

    if(!$title||!$category||!$description)$error='Required fields are missing.';
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Edit Project</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="projects.php" class="text-secondary">← Projects</a>
        <h1 class="mt-3">Edit Project</h1>
        <?php if($error): ?>
            <div class="alert alert-danger"><?=e($error)?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="admin-form mt-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label>Project Title</label>
                    <input name="title" class="form-control" value="<?=e($p['title'])?>" required>
                </div>
                <div class="col-md-4">
                    <label>Category</label>
                    <input name="category" class="form-control" value="<?=e($p['category'])?>" required>
                </div>
                <div class="col-12">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="form-control" required><?=e($p['description'])?></textarea>
                </div>
                <div class="col-12">
                    <label>Technologies</label>
                    <input name="technologies" class="form-control" value="<?=e($p['technologies'])?>">
                </div>
                <div class="col-md-6">
                    <label>Live Website URL</label>
                    <input type="url" name="website_url" class="form-control" value="<?=e($p['website_url'])?>">
                </div>
                <div class="col-md-6">
                    <label>GitHub URL</label>
                    <input type="url" name="github_url" class="form-control" value="<?=e($p['github_url'])?>">
                </div>
                <div class="col-md-8">
                    <label>Replace Screenshot</label>
                    <input type="file" name("image") accept=".jpg,.jpeg,.png,.webp" class("form-control")>>
                </div>
                <div class("col-md-4 d-flex align-items-end")>>
                    <div class("form-check mb-2")>>
                        <input class("form-check-input") type("checkbox") name("featured") id("featured") <?=$p['featured']?'checked':''?>>
                        <label for("featured")>Featured</label>
                    </div>
                </div>
                <div class("col-12")>>
                    <button class("btn btn-accent btn-lg")>Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

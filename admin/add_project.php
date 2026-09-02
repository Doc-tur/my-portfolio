<?php
require_once '../includes/db.php'; 
require_once '../includes/functions.php'; 
requireAdmin();

$error='';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']??''); 
    $category=trim($_POST['category']??''); 
    $description=trim($_POST['description']??''); 
    $tech=trim($_POST['technologies']??''); 
    $url=trim($_POST['website_url']??''); 
    $github=trim($_POST['github_url']??''); 
    $featured=isset($_POST['featured'])?1:0;
    $slug=slugify($title).'-'.bin2hex(random_bytes(3)); 
    $image=uploadProjectImage($_FILES['image']??null);

    if($image===false) $error='Invalid image. Use JPG, JPEG, PNG or WEBP under 5MB.';
    elseif(!$title||!$category||!$description) $error='Title, category and description are required.';
    else { 
        $st=$conn->prepare("INSERT INTO projects(title,slug,category,description,technologies,image,website_url,github_url,featured) 
        VALUES(?,?,?,?,?,?,?,?,?)"); 

        $st->bind_param("ssssssssi",$title,$slug,$category,$description,$tech,$image,$url,$github,$featured); 
        $st->execute(); flash('success','Project added successfully.'); 
        
        header('Location: projects.php'); 
        
        exit; 
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Emiabata Mukhtar O. | Add Project</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <a href="projects.php" class="text-secondary">← Projects</a>
        <h1 class="mt-3">Add Project</h1>
        <?php if($error): ?>
            <div class="alert alert-danger"><?=e($error)?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="admin-form mt-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label>Project Title</label>
                    <input name="title" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Category</label>
                    <input name="category" class="form-control" placeholder="E-Commerce" required>
                </div>
                <div class="col-12">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="form-control" required></textarea>
                </div>
                <div class="col-12">
                    <label>Technologies <small>(comma separated)</small></label>
                    <input name="technologies" class="form-control" placeholder="PHP, MySQL, Bootstrap, JavaScript">
                </div>
                <div class="col-md-6">
                    <label>Live Website URL</label>
                    <input type="url" name="website_url" class="form-control" placeholder="https://...">
                </div>
                <div class="col-md-6">
                    <label>GitHub URL</label>
                    <input type="url" name="github_url" class="form-control" placeholder="https://github.com/...">
                </div>
                <div class="col-md-8">
                    <label>Screenshot</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="featured" id="featured">
                        <label class="form-check-label" for="featured">Featured project</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

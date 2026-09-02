<?php
require_once 'includes/db.php'; 
require_once 'includes/functions.php';

$slug=$_GET['slug']??''; 
$stmt=$conn->prepare("SELECT * FROM projects WHERE slug=? LIMIT 1"); $stmt->bind_param("s",$slug); 
$stmt->execute(); 
$project=$stmt->get_result()->fetch_assoc();

if(!$project){
  http_response_code(404); 
  die("Project not found.");
}
$pageTitle=$project['title']; 

include 'includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <span class="section-kicker"><?=e($project['category'])?></span>
    <h1><?=e($project['title'])?></h1>
  </div>
</section>

<section class="section-pad">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-7">
        <?php if($project['image']): ?>
          <img class="project-detail-img" src="<?=e($project['image'])?>" alt="<?=e($project['title'])?>">
        <?php else: ?>
          <div class="project-detail-placeholder">
            <i class="bi bi-window"></i>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-5">
        <h2>About this project</h2>
        <p class="text-secondary"><?=nl2br(e($project['description']))?></p>
        <h6 class="mt-4">Technologies</h6>
        <div class="tech-list">
          <?php foreach(array_filter(array_map('trim',explode(',',$project['technologies']))) as $tech): ?>
            <span><?=e($tech)?></span>
          <?php endforeach; ?>
        </div>
        <div class="d-flex gap-2 mt-4">
          <?php if($project['website_url']): ?>
            <a target="_blank" rel="noopener" href="<?=e($project['website_url'])?>" class="btn btn-accent">Live Website <i class="bi bi-box-arrow-up-right"></i></a>
          <?php endif; ?>
          <?php if($project['github_url']): ?>
            <a target="_blank" rel="noopener" href="<?=e($project['github_url'])?>" class="btn btn-outline-light">GitHub <i class="bi bi-github"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>

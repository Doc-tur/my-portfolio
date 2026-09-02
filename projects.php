<?php
require_once 'includes/db.php'; 
require_once 'includes/functions.php';

$pageTitle='Projects';
$categories=[]; 
$catRes=$conn->query("SELECT DISTINCT category FROM projects ORDER BY category"); 

while($c=$catRes->fetch_assoc()) $categories[]=$c['category'];
$q=trim($_GET['q'] ?? ''); 
$cat=trim($_GET['category'] ?? '');

$sql="SELECT * FROM projects WHERE 1"; 
$types=''; 
$params=[];

if($q!==''){ 
  $sql.=" AND (title LIKE CONCAT('%',?,'%') OR description LIKE CONCAT('%',?,'%') OR technologies LIKE CONCAT('%',?,'%'))"; 
  $types='sss'; 
  $params=[$q,$q,$q]; 
}

if($cat!==''){ 
  $sql.=" AND category=?"; 
  $types.='s'; 
  $params[]=$cat; 
}

$sql.=" ORDER BY featured DESC, created_at DESC";
$stmt=$conn->prepare($sql); 
if($types) $stmt->bind_param($types,...$params); 
$stmt->execute(); $projects=$stmt->get_result();

include 'includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <span class="section-kicker">MY WORK</span>
    <h1>Websites I've Created</h1>
    <p class="text-secondary">A collection of websites and web applications built with different technologies.</p>
  </div>
</section>

<section class="section-pad">
  <div class="container">
    <form class="filter-bar row g-2 mb-5">
      <div class="col-lg-6">
        <input name="q" value="<?=e($q)?>" class="form-control" placeholder="Search projects...">
      </div>
      <div class="col-lg-4">
        <select name="category" class="form-select">
          <option value="">All categories</option>
          <?php foreach($categories as $c): ?>
          <option <?= $cat===$c?'selected':'' ?>><?=e($c)?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-lg-2">
        <button class="btn btn-accent w-100">Search</button>
      </div>
    </form>
    <div class="row g-4">
    <?php while($p=$projects->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="project-card h-100">
        <?php if($p['image']): ?>
        <img src="<?=e($p['image'])?>" alt="<?=e($p['title'])?>">
        <?php else: ?>
        <div class="project-placeholder">
          <i class="bi bi-window"></i>
        </div>
        <?php endif; ?>
        <div class="p-4">
          <div class="d-flex justify-content-between">
            <span class="project-category"><?=e($p['category'])?></span>
            <?php if($p['featured']): ?>
              <i class="bi bi-star-fill text-warning"></i>
              <?php endif; ?>
            </div>
            <h4 class="mt-2"><?=e($p['title'])?></h4>
            <p class="text-secondary"><?=e(mb_strimwidth($p['description'],0,120,'...'))?></p>
            <a href="project.php?slug=<?=urlencode($p['slug'])?>" class="text-accent">View Details <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>

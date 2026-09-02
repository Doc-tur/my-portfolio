<?php
require_once 'includes/db.php'; 
require_once 'includes/functions.php';

$pageTitle='Skills'; 
$skills=$conn->query("SELECT * FROM skills ORDER BY percentage DESC");

include 'includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <span class="section-kicker">MY TOOLKIT</span>
    <h1>Skills & Technologies</h1>
    <p class="text-secondary">Technologies I use to design, build and maintain websites.</p>
  </div>
</section>

<section class="section-pad">
  <div class="container">
    <div class="row g-4">
    <?php while($s=$skills->fetch_assoc()): ?>
      <div class="col-md-6">
        <div class="skill-card">
          <div class="d-flex justify-content-between align-items-center">
            <h5><i class="bi <?= e($s['icon']) ?> text-accent me-2"></i><?= e($s['name']) ?></h5>
            <span><?= (int)$s['percentage'] ?>%</span>
          </div>
          <div class="progress mt-3">
            <div class="progress-bar" style="width:<?= (int)$s['percentage'] ?>%">
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>

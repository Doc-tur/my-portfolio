<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
$pageTitle = 'Home';
$featured = $conn->query("SELECT * FROM projects WHERE featured=1 ORDER BY created_at DESC LIMIT 3");
include 'includes/header.php';
?>

<section class="hero">
<div class="container">
<div class="row align-items-center g-5">
<div class="col-lg-7">
<span class="badge-soft"><i class="bi bi-code-slash"></i> Website Developer & Full-Stack Web Developer</span>
<h1 class="display-4 fw-bold mt-3">Emiabata Mukhtar O.<br><span class="gradient-text">Website Developer & Full-Stack Web Developer</span></h1>
<p class="lead text-secondary mt-3">I'm Emiabata Mukhtar Olakunbi, a Website Developer & Full-Stack Web Developer focused on responsive interfaces, dynamic PHP/MySQL systems and professional business websites.</p>
<div class="d-flex flex-wrap gap-3 mt-4">
<a href="projects.php" class="btn btn-accent btn-lg">View My Projects <i class="bi bi-arrow-right"></i></a>
<a href="contact.php" class="btn btn-outline-light btn-lg">Let's Work Together</a>
</div>
<div class="stats row mt-5 g-3">
<div class="col-4"><strong>20+</strong><span>Projects</span></div>
<div class="col-4"><strong>7+</strong><span>Technologies</span></div>
<div class="col-4"><strong>100%</strong><span>Responsive</span></div>
</div>
</div>
<div class="col-lg-5 text-center">
<div class="hero-avatar">
  <img src="doc-pics.jpg" alt="Emiabata Mukhtar Olakunbi">
</div>
</div>
</div>
</div>
</section>

<section class="section-pad">
<div class="container">
<div class="section-heading"><span>Selected Work</span><h2>Featured Projects</h2></div>
<div class="row g-4">
<?php if ($featured && $featured->num_rows): while($p = $featured->fetch_assoc()): ?>
<div class="col-md-6 col-lg-4">
<div class="project-card h-100">
<?php if ($p['image']): ?><img src="<?= e($p['image']) ?>" alt="<?= e($p['title']) ?>"><?php else: ?><div class="project-placeholder"><i class="bi bi-window"></i></div><?php endif; ?>
<div class="p-4"><span class="project-category"><?= e($p['category']) ?></span><h4 class="mt-2"><?= e($p['title']) ?></h4><p class="text-secondary"><?= e($p['description']) ?></p><a href="project.php?slug=<?= urlencode($p['slug']) ?>" class="stretched-link text-accent">View project <i class="bi bi-arrow-up-right"></i></a></div>
</div>
</div>
<?php endwhile; else: ?>
<div class="col-12"><div class="empty-state">Your featured projects will appear here after you add them from the admin dashboard.</div></div>
<?php endif; ?>
</div>
</div>
</section>
<?php include 'includes/footer.php'; ?>

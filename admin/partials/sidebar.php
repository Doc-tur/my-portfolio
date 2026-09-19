<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="admin-sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon">
            <img src="doc-pics.jpg" alt="">
        </div>

        <div>
            <h5>Emiabata</h5>
            <small>Portfolio CMS</small>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-menu">

        <p class="sidebar-label">MAIN</p>

        <a href="dashboard.php"
           class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="projects.php"
           class="<?= in_array($currentPage, ['projects.php', 'add_project.php', 'edit_project.php']) ? 'active' : '' ?>">
            <i class="bi bi-folder-fill"></i>
            <span>Projects</span>
        </a>

        <a href="messages.php"
           class="<?= $currentPage === 'messages.php' ? 'active' : '' ?>">
            <i class="bi bi-envelope-fill"></i>
            <span>Messages</span>
        </a>

        <p class="sidebar-label">ACCOUNT</p>

        <a href="profile.php"
           class="<?= $currentPage === 'profile.php' ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

        <a href="../index.php" target="_blank">
            <i class="bi bi-globe2"></i>
            <span>View Website</span>
        </a>

    </div>

    <!-- Bottom -->
    <div class="sidebar-bottom">

        <a href="../auth/logout.php" class="logout-link">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

    </div>

</aside>
<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Dashboard';

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$projects = (int) $conn
    ->query("SELECT COUNT(*) c FROM projects")
    ->fetch_assoc()['c'];

$skills = (int) $conn
    ->query("SELECT COUNT(*) c FROM skills")
    ->fetch_assoc()['c'];

$messages = (int) $conn
    ->query("SELECT COUNT(*) c FROM messages")
    ->fetch_assoc()['c'];

$unread = (int) $conn
    ->query("SELECT COUNT(*) c FROM messages WHERE is_read=0")
    ->fetch_assoc()['c'];


/*
|--------------------------------------------------------------------------
| Admin Header + Sidebar
|--------------------------------------------------------------------------
*/

include 'partials/header.php';

?>

<!-- Dashboard Content -->
<div class="container-fluid dashboard-page">

    <!-- Page Header -->
    <div class="dashboard-header">

        <div>
            <span class="dashboard-eyebrow">
                <i class="bi bi-grid-1x2-fill"></i>
                CMS Overview
            </span>

            <h1>
                Dashboard
            </h1>

            <p>
                Manage your portfolio, projects and messages from one place.
            </p>
        </div>

        <div class="dashboard-header-action">
            <a href="add_project.php" class="btn btn-accent">
                <i class="bi bi-plus-lg"></i>
                Add Project
            </a>
        </div>

    </div>


    <!-- Statistics -->
    <div class="row g-4 dashboard-stats">

        <!-- Projects -->
        <div class="col-sm-6 col-xl-3">

            <div class="metric-card">

                <div class="metric-top">
                    <div class="metric-icon">
                        <i class="bi bi-folder-fill"></i>
                    </div>

                    <span class="metric-label">
                        Portfolio
                    </span>
                </div>

                <div class="metric-content">
                    <strong><?= $projects ?></strong>
                    <span>Projects</span>
                </div>

                <div class="metric-footer">
                    <i class="bi bi-arrow-up-right"></i>
                    <span>Manage your work</span>
                </div>

            </div>

        </div>


        <!-- Skills -->
        <div class="col-sm-6 col-xl-3">

            <div class="metric-card">

                <div class="metric-top">
                    <div class="metric-icon">
                        <i class="bi bi-lightning-fill"></i>
                    </div>

                    <span class="metric-label">
                        Expertise
                    </span>
                </div>

                <div class="metric-content">
                    <strong><?= $skills ?></strong>
                    <span>Skills</span>
                </div>

                <div class="metric-footer">
                    <i class="bi bi-stars"></i>
                    <span>Your technologies</span>
                </div>

            </div>

        </div>


        <!-- Messages -->
        <div class="col-sm-6 col-xl-3">

            <div class="metric-card">

                <div class="metric-top">
                    <div class="metric-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>

                    <span class="metric-label">
                        Communication
                    </span>
                </div>

                <div class="metric-content">
                    <strong><?= $messages ?></strong>
                    <span>Messages</span>
                </div>

                <div class="metric-footer">
                    <i class="bi bi-chat-left-text"></i>
                    <span>Visitor messages</span>
                </div>

            </div>

        </div>


        <!-- Unread -->
        <div class="col-sm-6 col-xl-3">

            <div class="metric-card unread-card">

                <div class="metric-top">
                    <div class="metric-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>

                    <?php if ($unread > 0): ?>
                        <span class="metric-badge">
                            New
                        </span>
                    <?php else: ?>
                        <span class="metric-label">
                            Inbox
                        </span>
                    <?php endif; ?>
                </div>

                <div class="metric-content">
                    <strong><?= $unread ?></strong>
                    <span>Unread Messages</span>
                </div>

                <div class="metric-footer">
                    <i class="bi bi-envelope-open"></i>
                    <span>
                        <?= $unread > 0 ? 'Needs your attention' : 'All caught up' ?>
                    </span>
                </div>

            </div>

        </div>

    </div>


    <!-- Main Dashboard Area -->
    <div class="row g-4 dashboard-main">

        <!-- Quick Actions -->
        <div class="col-xl-8">

            <div class="admin-card dashboard-actions-card">

                <div class="card-heading">

                    <div>
                        <span class="card-eyebrow">
                            <i class="bi bi-lightning-charge-fill"></i>
                            Shortcuts
                        </span>

                        <h4>
                            Quick Actions
                        </h4>

                        <p>
                            Quickly access the most important areas of your portfolio CMS.
                        </p>
                    </div>

                    <div class="card-heading-icon">
                        <i class="bi bi-command"></i>
                    </div>

                </div>


                <div class="row g-3">

                    <!-- Manage Projects -->
                    <div class="col-md-6">

                        <a href="projects.php" class="quick-action">

                            <div class="quick-action-icon">
                                <i class="bi bi-folder-fill"></i>
                            </div>

                            <div class="quick-action-content">
                                <strong>
                                    Manage Projects
                                </strong>

                                <small>
                                    Add, edit or delete your projects
                                </small>
                            </div>

                            <span class="quick-action-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </a>

                    </div>


                    <!-- Add Project -->
                    <div class="col-md-6">

                        <a href="add_project.php" class="quick-action">

                            <div class="quick-action-icon">
                                <i class="bi bi-plus-circle-fill"></i>
                            </div>

                            <div class="quick-action-content">
                                <strong>
                                    Add Project
                                </strong>

                                <small>
                                    Upload a new project to your portfolio
                                </small>
                            </div>

                            <span class="quick-action-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </a>

                    </div>


                    <!-- Messages -->
                    <div class="col-md-6">

                        <a href="messages.php" class="quick-action">

                            <div class="quick-action-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>

                            <div class="quick-action-content">
                                <strong>
                                    Messages
                                </strong>

                                <small>
                                    View messages from your visitors
                                </small>
                            </div>

                            <span class="quick-action-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </a>

                    </div>


                    <!-- Profile -->
                    <div class="col-md-6">

                        <a href="profile.php" class="quick-action">

                            <div class="quick-action-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>

                            <div class="quick-action-content">
                                <strong>
                                    Admin Profile
                                </strong>

                                <small>
                                    Manage your account information
                                </small>
                            </div>

                            <span class="quick-action-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </a>

                    </div>

                </div>

            </div>

        </div>


        <!-- Portfolio Preview -->
        <div class="col-xl-4">

            <div class="admin-card portfolio-card">

                <div class="portfolio-card-glow"></div>

                <div class="portfolio-icon">
                    <i class="bi bi-globe2"></i>
                </div>

                <span class="card-eyebrow">
                    <i class="bi bi-broadcast"></i>
                    Live Website
                </span>

                <h4>
                    Your Portfolio
                </h4>

                <p>
                    View your public portfolio and see how your website looks to visitors.
                </p>

                <div class="portfolio-status">
                    <span class="status-dot"></span>
                    Website Available
                </div>

                <a
                    href="../index.php"
                    target="_blank"
                    class="btn btn-accent w-100"
                >
                    <i class="bi bi-box-arrow-up-right"></i>
                    View Website
                </a>

            </div>

        </div>

    </div>


    <!-- Bottom Information -->
    <div class="row g-4 mt-1">

        <div class="col-12">

            <div class="admin-card dashboard-info-card">

                <div class="dashboard-info-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="dashboard-info-content">

                    <strong>
                        Portfolio CMS
                    </strong>

                    <p>
                        Your website content is managed from this dashboard.
                        Keep your projects, profile and messages up to date.
                    </p>

                </div>

                <a href="../index.php" target="_blank" class="dashboard-info-link">
                    Visit Website
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

        </div>

    </div>

</div>


<?php

include 'partials/footer.php';

?>

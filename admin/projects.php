<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Projects';

/* Get all projects */
$projects = $conn->query("
    SELECT *
    FROM projects
    ORDER BY created_at DESC
");

/* Flash messages */
$success = flash('success');
$error = flash('error');

include 'partials/header.php';
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <span class="text-uppercase small text-secondary">
                Portfolio
            </span>

            <h1 class="mt-1 mb-0">
                Projects
            </h1>

            <p class="text-secondary mb-0 mt-1">
                Manage the projects displayed on your portfolio website.
            </p>
        </div>

        <a href="add_project.php" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i>
            Add Project
        </a>

    </div>


    <!-- Flash Messages -->

    <?php if ($success): ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            <?= e($success) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <?= e($error) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>


    <!-- Project Summary -->

    <?php
    $projectCount = $projects ? $projects->num_rows : 0;

    $featuredCount = 0;

    if ($projects && $projects->num_rows > 0) {
        $projects->data_seek(0);

        while ($row = $projects->fetch_assoc()) {
            if ((int)$row['featured'] === 1) {
                $featuredCount++;
            }
        }

        $projects->data_seek(0);
    }
    ?>


    <div class="row g-4 mb-4">

        <!-- Total Projects -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card">

                <div class="metric-icon">
                    <i class="bi bi-folder-fill"></i>
                </div>

                <div>
                    <strong><?= $projectCount ?></strong>
                    <span>Total Projects</span>
                </div>

            </div>

        </div>


        <!-- Featured Projects -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card">

                <div class="metric-icon">
                    <i class="bi bi-star-fill"></i>
                </div>

                <div>
                    <strong><?= $featuredCount ?></strong>
                    <span>Featured Projects</span>
                </div>

            </div>

        </div>

    </div>


    <!-- Projects Table -->

    <div class="admin-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    All Projects
                </h4>

                <p class="text-secondary mb-0">
                    Your complete project portfolio.
                </p>
            </div>

            <a
                href="add_project.php"
                class="btn btn-sm btn-accent"
            >
                <i class="bi bi-plus-lg me-1"></i>
                New Project
            </a>

        </div>


        <?php if ($projects && $projects->num_rows > 0): ?>

            <div class="table-responsive admin-table">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Project</th>

                            <th>Category</th>

                            <th>Technologies</th>

                            <th>Featured</th>

                            <th>Created</th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php while ($p = $projects->fetch_assoc()): ?>

                            <tr>

                                <!-- Project -->

                                <td>

                                    <div class="project-table-item">

                                        <?php if (!empty($p['image'])): ?>

                                            <img
                                                src="../<?= e($p['image']) ?>"
                                                alt="<?= e($p['title']) ?>"
                                                class="project-table-image"
                                            >

                                        <?php else: ?>

                                            <div class="project-table-icon">
                                                <i class="bi bi-folder-fill"></i>
                                            </div>

                                        <?php endif; ?>


                                        <div>

                                            <strong class="project-table-title">
                                                <?= e($p['title']) ?>
                                            </strong>

                                            <?php if (!empty($p['slug'])): ?>

                                                <small>
                                                    /<?= e($p['slug']) ?>
                                                </small>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <!-- Category -->

                                <td>

                                    <span class="project-category">
                                        <?= e($p['category']) ?>
                                    </span>

                                </td>


                                <!-- Technologies -->

                                <td>

                                    <?php if (!empty($p['technologies'])): ?>

                                        <span class="project-technologies">
                                            <?= e(mb_strimwidth($p['technologies'], 0, 55, '...')) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="text-secondary">
                                            Not specified
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- Featured -->

                                <td>

                                    <?php if ((int)$p['featured'] === 1): ?>

                                        <span class="project-status featured">
                                            <i class="bi bi-star-fill"></i>
                                            Featured
                                        </span>

                                    <?php else: ?>

                                        <span class="project-status">
                                            <i class="bi bi-circle"></i>
                                            Regular
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- Created -->

                                <td>

                                    <span class="project-date">
                                        <i class="bi bi-calendar3 me-1"></i>

                                        <?= e(
                                            date(
                                                'M d, Y',
                                                strtotime($p['created_at'])
                                            )
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Actions -->

                                <td>

                                    <div class="project-actions">

                                        <a
                                            href="edit_project.php?id=<?= (int)$p['id'] ?>"
                                            class="btn btn-sm btn-outline-light"
                                            title="Edit project"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="action-text">
                                                Edit
                                            </span>
                                        </a>


                                        <a
                                            href="delete_project.php?id=<?= (int)$p['id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete project"
                                            onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.')"
                                        >
                                            <i class="bi bi-trash3"></i>
                                            <span class="action-text">
                                                Delete
                                            </span>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>


        <?php else: ?>

            <!-- Empty State -->

            <div class="projects-empty">

                <div class="empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h4>
                    No Projects Yet
                </h4>

                <p>
                    You haven't added any projects to your portfolio.
                    Start by adding your first project.
                </p>

                <a
                    href="add_project.php"
                    class="btn btn-accent"
                >
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Your First Project
                </a>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php include 'partials/footer.php'; ?>
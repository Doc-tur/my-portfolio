<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Add Project';

$error = '';

/*
|--------------------------------------------------------------------------
| Handle Project Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['title'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech        = trim($_POST['technologies'] ?? '');
    $url         = trim($_POST['website_url'] ?? '');
    $github      = trim($_POST['github_url'] ?? '');
    $featured    = isset($_POST['featured']) ? 1 : 0;

    $slug = slugify($title) . '-' . bin2hex(random_bytes(3));

    $image = uploadProjectImage($_FILES['image'] ?? null);

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($image === false) {

        $error = 'Invalid image. Use JPG, JPEG, PNG or WEBP under 5MB.';

    } elseif (!$title || !$category || !$description) {

        $error = 'Title, category and description are required.';

    } else {

        /*
        |--------------------------------------------------------------------------
        | Insert Project
        |--------------------------------------------------------------------------
        */

        $st = $conn->prepare("
            INSERT INTO projects
            (
                title,
                slug,
                category,
                description,
                technologies,
                image,
                website_url,
                github_url,
                featured
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $st->bind_param(
            "ssssssssi",
            $title,
            $slug,
            $category,
            $description,
            $tech,
            $image,
            $url,
            $github,
            $featured
        );

        if ($st->execute()) {

            flash('success', 'Project added successfully.');

            header('Location: projects.php');
            exit;

        } else {

            $error = 'Unable to add project. Please try again.';

        }

        $st->close();
    }
}

/*
|--------------------------------------------------------------------------
| Admin Header + Sidebar
|--------------------------------------------------------------------------
*/

include 'partials/header.php';

?>


<!-- Page Header -->

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <span class="text-uppercase small text-secondary">
                Projects
            </span>

            <h1 class="mt-1 mb-0">
                Add Project
            </h1>

        </div>

        <a href="projects.php" class="btn btn-outline-light">

            <i class="bi bi-arrow-left"></i>

            Back to Projects

        </a>

    </div>


    <!-- Error Message -->

    <?php if ($error): ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <?= e($error) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- Project Form -->

    <div class="admin-card">

        <div class="mb-4">

            <h4 class="mb-1">
                Project Information
            </h4>

            <p class="text-secondary mb-0">
                Add a new project to your portfolio.
            </p>

        </div>


        <form
            method="post"
            enctype="multipart/form-data"
            class="admin-form"
        >

            <div class="row g-4">


                <!-- Project Title -->

                <div class="col-lg-8">

                    <label for="title" class="form-label">
                        Project Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        placeholder="e.g. Remmzy Store"
                        value="<?= e($_POST['title'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- Category -->

                <div class="col-lg-4">

                    <label for="category" class="form-label">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        id="category"
                        class="form-control"
                        placeholder="E-Commerce"
                        value="<?= e($_POST['category'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- Description -->

                <div class="col-12">

                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="6"
                        class="form-control"
                        placeholder="Describe the project..."
                        required
                    ><?= e($_POST['description'] ?? '') ?></textarea>

                </div>


                <!-- Technologies -->

                <div class="col-12">

                    <label for="technologies" class="form-label">

                        Technologies

                        <small class="text-secondary">
                            (comma separated)
                        </small>

                    </label>

                    <input
                        type="text"
                        name="technologies"
                        id="technologies"
                        class="form-control"
                        placeholder="PHP, MySQL, Bootstrap, JavaScript"
                        value="<?= e($_POST['technologies'] ?? '') ?>"
                    >

                </div>


                <!-- Website URL -->

                <div class="col-lg-6">

                    <label for="website_url" class="form-label">

                        Live Website URL

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-globe2"></i>
                        </span>

                        <input
                            type="url"
                            name="website_url"
                            id="website_url"
                            class="form-control"
                            placeholder="https://example.com"
                            value="<?= e($_POST['website_url'] ?? '') ?>"
                        >

                    </div>

                </div>


                <!-- GitHub URL -->

                <div class="col-lg-6">

                    <label for="github_url" class="form-label">

                        GitHub URL

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-github"></i>
                        </span>

                        <input
                            type="url"
                            name="github_url"
                            id="github_url"
                            class="form-control"
                            placeholder="https://github.com/username/project"
                            value="<?= e($_POST['github_url'] ?? '') ?>"
                        >

                    </div>

                </div>


                <!-- Screenshot -->

                <div class="col-lg-8">

                    <label for="image" class="form-label">

                        Project Screenshot

                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="form-control"
                    >

                    <small class="text-secondary">
                        JPG, JPEG, PNG or WEBP. Maximum size: 5MB.
                    </small>

                </div>


                <!-- Featured -->

                <div class="col-lg-4">

                    <div class="featured-box">

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="featured"
                                id="featured"
                                <?= isset($_POST['featured']) ? 'checked' : '' ?>
                            >

                            <label
                                class="form-check-label"
                                for="featured"
                            >

                                <strong>
                                    Featured Project
                                </strong>

                                <small>
                                    Show this project on the homepage.
                                </small>

                            </label>

                        </div>

                    </div>

                </div>


                <!-- Buttons -->

                <div class="col-12">

                    <hr class="my-2">

                    <div class="d-flex flex-wrap gap-3 justify-content-end">

                        <a
                            href="projects.php"
                            class="btn btn-outline-light"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn btn-accent"
                        >

                            <i class="bi bi-check-lg"></i>

                            Add Project

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


<?php

include 'partials/footer.php';

?>

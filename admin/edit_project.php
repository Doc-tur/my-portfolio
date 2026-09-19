<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Edit Project';

$error = '';

/*
|--------------------------------------------------------------------------
| Get Project
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET['id'] ?? 0);

$st = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$st->bind_param("i", $id);
$st->execute();

$p = $st->get_result()->fetch_assoc();

$st->close();

if (!$p) {
    die('Project not found.');
}


/*
|--------------------------------------------------------------------------
| Update Project
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

    // Keep existing image
    $image = $p['image'];

    /*
    |--------------------------------------------------------------------------
    | Validate Required Fields
    |--------------------------------------------------------------------------
    */

    if (!$title || !$category || !$description) {

        $error = 'Title, category and description are required.';

    } else {

        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            $new = uploadProjectImage($_FILES['image']);

            if ($new === false) {

                $error = 'Invalid image. Use JPG, JPEG, PNG or WEBP under 5MB.';

            } else {

                $image = $new;

            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Update Database
    |--------------------------------------------------------------------------
    */

    if (!$error) {

        $st = $conn->prepare("
            UPDATE projects SET
                title = ?,
                category = ?,
                description = ?,
                technologies = ?,
                image = ?,
                website_url = ?,
                github_url = ?,
                featured = ?
            WHERE id = ?
        ");

        $st->bind_param(
            "sssssssii",
            $title,
            $category,
            $description,
            $tech,
            $image,
            $url,
            $github,
            $featured,
            $id
        );

        if ($st->execute()) {

            flash(
                'success',
                'Project updated successfully.'
            );

            $st->close();

            header('Location: projects.php');
            exit;

        } else {

            $error = 'Unable to update project. Please try again.';

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


<div class="container-fluid">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <span class="text-uppercase small text-secondary">
                Projects
            </span>

            <h1 class="mt-1 mb-0">
                Edit Project
            </h1>

        </div>

        <a
            href="projects.php"
            class="btn btn-outline-light"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Projects
        </a>

    </div>


    <!-- Error Message -->

    <?php if ($error): ?>

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            <?= e($error) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- Edit Form -->

    <div class="admin-card">

        <div class="mb-4">

            <h4 class="mb-1">
                Edit Project Information
            </h4>

            <p class="text-secondary mb-0">
                Update the information displayed on your portfolio.
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

                    <label
                        for="title"
                        class="form-label"
                    >
                        Project Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="<?= e($p['title']) ?>"
                        required
                    >

                </div>


                <!-- Category -->

                <div class="col-lg-4">

                    <label
                        for="category"
                        class="form-label"
                    >
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        id="category"
                        class="form-control"
                        value="<?= e($p['category']) ?>"
                        required
                    >

                </div>


                <!-- Description -->

                <div class="col-12">

                    <label
                        for="description"
                        class="form-label"
                    >
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="6"
                        class="form-control"
                        required
                    ><?= e($p['description']) ?></textarea>

                </div>


                <!-- Technologies -->

                <div class="col-12">

                    <label
                        for="technologies"
                        class="form-label"
                    >

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
                        value="<?= e($p['technologies']) ?>"
                        placeholder="PHP, MySQL, Bootstrap, JavaScript"
                    >

                </div>


                <!-- Website URL -->

                <div class="col-lg-6">

                    <label
                        for="website_url"
                        class="form-label"
                    >
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
                            value="<?= e($p['website_url']) ?>"
                            placeholder="https://example.com"
                        >

                    </div>

                </div>


                <!-- GitHub URL -->

                <div class="col-lg-6">

                    <label
                        for="github_url"
                        class="form-label"
                    >
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
                            value="<?= e($p['github_url']) ?>"
                            placeholder="https://github.com/username/project"
                        >

                    </div>

                </div>


                <!-- Current Screenshot -->

                <?php if (!empty($p['image'])): ?>

                    <div class="col-lg-4">

                        <label class="form-label">
                            Current Screenshot
                        </label>

                        <div class="current-project-image">

                            <img
                                src="<?= e($p['image']) ?>"
                                alt="<?= e($p['title']) ?>"
                            >

                        </div>

                    </div>

                <?php endif; ?>


                <!-- Replace Screenshot -->

                <div
                    class="<?= !empty($p['image']) ? 'col-lg-8' : 'col-lg-8' ?>"
                >

                    <label
                        for="image"
                        class="form-label"
                    >
                        Replace Screenshot
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="form-control"
                    >

                    <small class="text-secondary">
                        Leave empty to keep the current image.
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
                                <?= $p['featured'] ? 'checked' : '' ?>
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

                            Save Changes

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

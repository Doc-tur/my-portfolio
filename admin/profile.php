<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Profile';

$id = (int) $_SESSION['admin_id'];

/* Get admin information */
$st = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$st->bind_param("i", $id);
$st->execute();
$admin = $st->get_result()->fetch_assoc();
$st->close();

if (!$admin) {
    flash('error', 'Admin profile not found.');
    header('Location: dashboard.php');
    exit;
}

/* Update profile */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    /* Basic validation */
    if ($name === '' || $email === '') {

        flash('error', 'Name and email are required.');

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        flash('error', 'Please enter a valid email address.');

    } elseif ($password !== '' && strlen($password) < 6) {

        flash('error', 'Password must be at least 6 characters.');

    } else {

        /* Update with new password */
        if ($password !== '') {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $st = $conn->prepare("
                UPDATE admins
                SET name = ?, email = ?, password = ?
                WHERE id = ?
            ");

            $st->bind_param(
                "sssi",
                $name,
                $email,
                $hash,
                $id
            );

        } else {

            /* Update without changing password */
            $st = $conn->prepare("
                UPDATE admins
                SET name = ?, email = ?
                WHERE id = ?
            ");

            $st->bind_param(
                "ssi",
                $name,
                $email,
                $id
            );
        }

        if ($st->execute()) {

            /* Update session name */
            $_SESSION['admin_name'] = $name;

            flash('success', 'Profile updated successfully.');

            $st->close();

            header('Location: profile.php');
            exit;

        } else {

            flash('error', 'Unable to update your profile.');

            $st->close();
        }
    }
}

include 'partials/header.php';
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <span class="text-uppercase small text-secondary">
                Account
            </span>

            <h1 class="mt-1 mb-0">
                Admin Profile
            </h1>

            <p class="text-secondary mb-0 mt-1">
                Manage your administrator account information.
            </p>
        </div>

        <a href="dashboard.php" class="btn btn-outline-light">
            <i class="bi bi-arrow-left me-1"></i>
            Dashboard
        </a>

    </div>


    <!-- Flash Messages -->

    <?php $success = flash('success'); ?>

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


    <?php $error = flash('error'); ?>

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


    <div class="row g-4">

        <!-- Profile Information -->

        <div class="col-lg-8">

            <div class="admin-card">

                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="profile-large-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div>
                        <h4 class="mb-1">
                            Profile Information
                        </h4>

                        <p class="text-secondary mb-0">
                            Update your name, email address and password.
                        </p>
                    </div>

                </div>


                <form method="post" class="admin-form">

                    <!-- Name -->

                    <div class="mb-4">

                        <label class="form-label">
                            Full Name
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?= e($admin['name']) ?>"
                                placeholder="Enter your name"
                                required
                            >

                        </div>

                    </div>


                    <!-- Email -->

                    <div class="mb-4">

                        <label class="form-label">
                            Email Address
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= e($admin['email']) ?>"
                                placeholder="Enter your email"
                                required
                            >

                        </div>

                    </div>


                    <hr class="my-4">


                    <!-- Password -->

                    <div class="mb-4">

                        <label class="form-label">
                            New Password
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter a new password"
                                minlength="6"
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary password-toggle"
                                onclick="togglePassword()"
                            >
                                <i class="bi bi-eye" id="passwordIcon"></i>
                            </button>

                        </div>

                        <small class="text-secondary">
                            Leave blank if you do not want to change your password.
                            Minimum 6 characters.
                        </small>

                    </div>


                    <!-- Submit -->

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-accent px-4"
                        >
                            <i class="bi bi-check-circle me-1"></i>
                            Update Profile
                        </button>

                        <a
                            href="dashboard.php"
                            class="btn btn-outline-light"
                        >
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>


        <!-- Account Summary -->

        <div class="col-lg-4">

            <div class="admin-card profile-summary">

                <div class="profile-summary-icon">
                    <i class="bi bi-person-circle"></i>
                </div>

                <h4 class="mt-3">
                    Administrator
                </h4>

                <p class="text-secondary">
                    <?= e($admin['name']) ?>
                </p>


                <div class="profile-info-item">

                    <span>
                        <i class="bi bi-envelope"></i>
                        Email
                    </span>

                    <strong>
                        <?= e($admin['email']) ?>
                    </strong>

                </div>


                <div class="profile-info-item">

                    <span>
                        <i class="bi bi-shield-check"></i>
                        Role
                    </span>

                    <strong>
                        Administrator
                    </strong>

                </div>


                <div class="profile-info-item">

                    <span>
                        <i class="bi bi-shield-lock"></i>
                        Account
                    </span>

                    <strong class="text-success">
                        Active
                    </strong>

                </div>


                <div class="profile-security mt-4">

                    <i class="bi bi-lock-fill"></i>

                    <div>

                        <strong>
                            Account Security
                        </strong>

                        <small>
                            Your password is securely encrypted using
                            PHP password hashing.
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
function togglePassword() {

    const password = document.getElementById('password');
    const icon = document.getElementById('passwordIcon');

    if (password.type === 'password') {

        password.type = 'text';

        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');

    } else {

        password.type = 'password';

        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');

    }
}
</script>

<?php include 'partials/footer.php'; ?>
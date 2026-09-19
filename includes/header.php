<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Developer Portfolio';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | Emiabata Mukhtar Olakunbi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top nav-glass">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            <span class="brand-dot"></span> 
            Emiabata Mukhtar Olakunbi
        </a>

        <button 
            class="navbar-toggler" 
            data-bs-toggle="collapse" 
            data-bs-target="#mainNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="skills.php">
                        Skills
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="projects.php">
                        Projects
                    </a>
                </li>

                <!-- Admin Login -->
                <li class="nav-item">
                    <a class="nav-link" href="auth/login.php">
                        <i class="bi bi-person-lock"></i>
                        Admin Login
                    </a>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link btn btn-accent px-3 ms-lg-2" href="contact.php">
                        Contact
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<main>

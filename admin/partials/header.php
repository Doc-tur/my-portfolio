<?php
require_once __DIR__ . '/../../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? 'Admin Dashboard';
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($pageTitle) ?> | Emiabata Mukhtar</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body>

<div class="admin-wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="admin-main">

        <!-- Topbar -->
        <header class="admin-topbar">

            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h4><?= e($pageTitle) ?></h4>
                <small>Welcome back, Admin</small>
            </div>

            <div class="admin-user">

                <div class="admin-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="admin-user-info">
                    <strong>Admin</strong>
                    <small>Administrator</small>
                </div>

            </div>

        </header>

        <main class="admin-content">
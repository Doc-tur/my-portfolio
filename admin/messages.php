<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';

requireAdmin();

$pageTitle = 'Messages';

/*
|--------------------------------------------------------------------------
| Mark Message as Read
|--------------------------------------------------------------------------
*/

if (isset($_GET['read'])) {

    $id = (int) $_GET['read'];

    $st = $conn->prepare(
        "UPDATE messages SET is_read = 1 WHERE id = ?"
    );

    $st->bind_param("i", $id);
    $st->execute();
    $st->close();

    header('Location: messages.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Delete Message
|--------------------------------------------------------------------------
*/

if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $st = $conn->prepare(
        "DELETE FROM messages WHERE id = ?"
    );

    $st->bind_param("i", $id);
    $st->execute();
    $st->close();

    flash('success', 'Message deleted successfully.');

    header('Location: messages.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Get Messages
|--------------------------------------------------------------------------
*/

$messages = $conn->query("
    SELECT *
    FROM messages
    ORDER BY created_at DESC
");


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
                Communication
            </span>

            <h1 class="mt-1 mb-0">
                Messages
            </h1>

        </div>

        <a
            href="dashboard.php"
            class="btn btn-outline-light"
        >
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>


    <!-- Success Message -->

    <?php $success = flash('success'); ?>

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= e($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>


    <!-- Messages Card -->

    <div class="admin-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="mb-1">
                    Visitor Messages
                </h4>

                <p class="text-secondary mb-0">
                    Messages submitted through your contact form.
                </p>

            </div>

            <div class="message-count">

                <i class="bi bi-envelope-fill"></i>

                <?= $messages ? $messages->num_rows : 0 ?>

            </div>

        </div>


        <?php if ($messages && $messages->num_rows > 0): ?>


            <!-- Messages Table -->

            <div class="table-responsive admin-table">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Visitor</th>

                            <th>Subject</th>

                            <th>Message</th>

                            <th>Date</th>

                            <th>Status</th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php while ($m = $messages->fetch_assoc()): ?>

                            <tr class="<?= !$m['is_read'] ? 'unread-message' : '' ?>">


                                <!-- Visitor -->

                                <td>

                                    <div class="message-person">

                                        <div class="message-avatar">

                                            <?= strtoupper(
                                                substr(
                                                    e($m['name']),
                                                    0,
                                                    1
                                                )
                                            ) ?>

                                        </div>

                                        <div>

                                            <strong>
                                                <?= e($m['name']) ?>
                                            </strong>

                                            <small>
                                                <?= e($m['email']) ?>
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                <!-- Subject -->

                                <td>

                                    <span class="message-subject">

                                        <?= e($m['subject']) ?>

                                    </span>

                                </td>


                                <!-- Message -->

                                <td>

                                    <span class="message-preview">

                                        <?= e(
                                            mb_strimwidth(
                                                $m['message'],
                                                0,
                                                90,
                                                '...'
                                            )
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Date -->

                                <td>

                                    <span class="message-date">

                                        <?= e(
                                            date(
                                                'M d, Y',
                                                strtotime($m['created_at'])
                                            )
                                        ) ?>

                                    </span>

                                </td>


                                <!-- Status -->

                                <td>

                                    <?php if (!$m['is_read']): ?>

                                        <span class="message-status unread">

                                            <i class="bi bi-circle-fill"></i>
                                            Unread

                                        </span>

                                    <?php else: ?>

                                        <span class="message-status read">

                                            <i class="bi bi-check-circle-fill"></i>
                                            Read

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- Actions -->

                                <td>

                                    <div class="message-actions">

                                        <?php if (!$m['is_read']): ?>

                                            <a
                                                href="?read=<?= $m['id'] ?>"
                                                class="btn btn-sm btn-outline-light"
                                                title="Mark as read"
                                            >

                                                <i class="bi bi-check2"></i>

                                                Read

                                            </a>

                                        <?php endif; ?>


                                        <a
                                            href="?delete=<?= $m['id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this message?')"
                                            title="Delete message"
                                        >

                                            <i class="bi bi-trash"></i>

                                            Delete

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

            <div class="messages-empty">

                <div class="empty-icon">

                    <i class="bi bi-envelope-open"></i>

                </div>

                <h4>
                    No Messages Yet
                </h4>

                <p>
                    Messages from visitors will appear here when
                    someone contacts you through your portfolio.
                </p>

                <a
                    href="../contact.php"
                    target="_blank"
                    class="btn btn-accent"
                >

                    <i class="bi bi-eye"></i>

                    View Contact Page

                </a>

            </div>


        <?php endif; ?>

    </div>

</div>


<?php

include 'partials/footer.php';

?>

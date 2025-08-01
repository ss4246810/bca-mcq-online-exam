<?php
session_start();
include '../db_config.php';
include 'admin_nav.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle subject status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject'], $_POST['action'])) {
    $subject = $_POST['subject'];
    $is_enabled = ($_POST['action'] === 'enable') ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO exam_status (subject, is_enabled)
                            VALUES (?, ?) ON DUPLICATE KEY UPDATE is_enabled = VALUES(is_enabled)");
    $stmt->bind_param("si", $subject, $is_enabled);
    $stmt->execute();
    $stmt->close();
    $message = "✅ Updated status for <strong>" . htmlspecialchars($subject) . "</strong>.";
}

// Get all subjects from questions table
$subjects = [];
$result = $conn->query("SELECT DISTINCT subject FROM questions ORDER BY subject ASC");
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row['subject'];
}

// Get current status
$status = [];
$result = $conn->query("SELECT subject, is_enabled FROM exam_status");
while ($row = $result->fetch_assoc()) {
    $status[$row['subject']] = $row['is_enabled'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Exam Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            /* margin: 0;
            padding: 30px; */
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .message {
            background: #d1e7dd;
            color: #0f5132;
            padding: 10px 15px;
            border-left: 4px solid #198754;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background: #1e3581;
            color: white;
        }

        .enabled {
            color: green;
            font-weight: bold;
        }

        .disabled {
            color: red;
            font-weight: bold;
        }

        .btn {
            padding: 6px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-enable {
            background-color: #28a745;
            color: white;
        }

        .btn-disable {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🛠 Admin Exam Control Panel</h2>

        <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject):
                    $enabled = $status[$subject] ?? 0; ?>
                    <tr>
                        <td><?= htmlspecialchars($subject) ?></td>
                        <td class="<?= $enabled ? 'enabled' : 'disabled' ?>">
                            <?= $enabled ? 'Enabled' : 'Disabled' ?>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="subject" value="<?= htmlspecialchars($subject) ?>">
                                <?php if ($enabled): ?>
                                    <input type="hidden" name="action" value="disable">
                                    <button type="submit" class="btn btn-disable">Disable</button>
                                <?php else: ?>
                                    <input type="hidden" name="action" value="enable">
                                    <button type="submit" class="btn btn-enable">Enable</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

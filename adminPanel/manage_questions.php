<?php
session_start();
include '../db_config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Parameters
$search = $_GET['search'] ?? '';
$subject_filter = $_GET['subject'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Subject list for filter dropdown
$subjects_result = $conn->query("SELECT DISTINCT subject FROM questions");

// Build query
$query = "SELECT * FROM questions WHERE 1";
$params = [];

if ($search !== '') {
    $query .= " AND (question LIKE ? OR subject LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($subject_filter !== '') {
    $query .= " AND subject = ?";
    $params[] = $subject_filter;
}

$query .= " LIMIT $limit OFFSET $offset";

$stmt = $conn->prepare($query);

if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$results = $stmt->get_result();

// For pagination count
$count_query = "SELECT COUNT(*) FROM questions WHERE 1";
$count_params = [];

if ($search !== '') {
    $count_query .= " AND (question LIKE ? OR subject LIKE ?)";
    $count_params[] = "%$search%";
    $count_params[] = "%$search%";
}

if ($subject_filter !== '') {
    $count_query .= " AND subject = ?";
    $count_params[] = $subject_filter;
}

$count_stmt = $conn->prepare($count_query);

if ($count_params) {
    $count_types = str_repeat('s', count($count_params));
    $count_stmt->bind_param($count_types, ...$count_params);
}
$count_stmt->execute();
$count_stmt->bind_result($total);
$count_stmt->fetch();
$count_stmt->close();

$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Questions</title>
    <!-- <link rel="stylesheet" href="admin_styles.css"> -->
     <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f8;
        margin: 0;
        padding: 0;
    }

    h2 {
        background-color: #343a40;
        color: white;
        padding: 20px;
        margin: 0;
        text-align: center;
    }

    form {
        max-width: 800px;
        margin: 20px auto;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }

    form input[type="text"],
    form select {
        padding: 10px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
        flex: -1 1 250px;
    }

    form button {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    form button:hover {
        background-color: #0056b3;
    }

    table {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    table th,
    table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    table th {
        background-color: #007bff;
        color: white;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Pagination */
    div[style*="margin-top: 20px"] {
        text-align: center;
        margin-top: 30px;
    }

    div[style*="margin-top: 20px"] a {
        display: inline-block;
        margin: 0 5px;
        padding: 8px 12px;
        border-radius: 5px;
        background-color: #e9ecef;
        color: #333;
        font-weight: normal;
        transition: all 0.3s ease;
    }

    div[style*="margin-top: 20px"] a:hover {
        background-color: #007bff;
        color: white;
    }

    div[style*="margin-top: 20px"] a[style*="font-weight:bold"] {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    @media (max-width: 600px) {
        form {
            flex-direction: column;
            align-items: stretch;
        }

        table th,
        table td {
            font-size: 14px;
        }
    }
</style>

</head>
 <?php include 'admin_nav.php'; ?>
<body>

<h2>Manage MCQ Questions</h2>

<form method="get" style="margin-bottom: 20px;">
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search question or subject">
    <select name="subject">
        <option value="">All Subjects</option>
        <?php while ($row = $subjects_result->fetch_assoc()): ?>
            <option value="<?= $row['subject'] ?>" <?= $subject_filter == $row['subject'] ? 'selected' : '' ?>>
                <?= $row['subject'] ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Search / Filter</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Subject</th>
        <th>Question</th>
        <th>Correct</th>
        <th>Actions</th>
    </tr>
    <?php while ($q = $results->fetch_assoc()): ?>
        <tr>
            <td><?= $q['id'] ?></td>
            <td><?= htmlspecialchars($q['subject']) ?></td>
            <td><?= htmlspecialchars($q['question']) ?></td>
            <td><?= htmlspecialchars($q['correct_option']) ?></td>
            <td>
                <a href="edit_question.php?id=<?= $q['id'] ?>">Edit</a> |
                <a href="delete_question.php?id=<?= $q['id'] ?>" onclick="return confirm('Delete this question?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Pagination -->
<div style="margin-top: 20px;">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?search=<?= urlencode($search) ?>&subject=<?= urlencode($subject_filter) ?>&page=<?= $i ?>"
           style="<?= $i == $page ? 'font-weight:bold' : '' ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

</body>
</html>

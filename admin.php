<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once("database.php");

// Admin prüfen
$user_id = $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT `role` FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($row['role'] !== 'admin') {
        header("Location: login.php");
        exit();
    }
} else {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Alle User abrufen
$users = [];
$query = "SELECT id, username, email, `role`, cookies FROM users";
$result = mysqli_query($conn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Alle Events abrufen
$events = [];
$query = "SELECT id, title, is_active FROM events ORDER BY id ASC";
$result = mysqli_query($conn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>
</head>
<body>

<h2>Admin Panel – Users</h2>
<form action="update_role.php" method="post">
<table>
    <thead>
        <tr>
            <th>Role</th>
            <th>Username</th>
            <th>Email</th>
            <th>Cookies</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <select name="role[<?= $user['id'] ?>]">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['cookies']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<button type="submit">Save User Roles</button>
</form>

<h2>Admin Panel – Events</h2>
<form action="update_events.php" method="post">
<table>
    <thead>
        <tr>
            <th>Event Title</th>
            <th>Active?</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= htmlspecialchars($event['title']) ?></td>
            <td>
                <input type="checkbox" name="is_active[<?= $event['id'] ?>]" value="1" <?= $event['is_active'] ? 'checked' : '' ?>/>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<button type="submit">Update Events</button>
</form>

<a href="user.php" style="color:#9c8809;">Back to My Cookie</a>

</body>
</html>

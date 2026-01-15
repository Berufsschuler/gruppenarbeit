<?php
session_start();
require_once("database.php");

// Admin prüfen
$user_id = $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT role FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
if (!$row || $row['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Alle Events auf 0 setzen
$resetStmt = mysqli_prepare($conn, "UPDATE events SET is_active = 0");
mysqli_stmt_execute($resetStmt);

// Jetzt nur die angehakten Checkboxen aktivieren
if (isset($_POST['is_active']) && is_array($_POST['is_active'])) {
    $stmt = mysqli_prepare($conn, "UPDATE events SET is_active = 1 WHERE id = ?");
    foreach ($_POST['is_active'] as $event_id => $val) {
        $event_id = intval($event_id);
        mysqli_stmt_bind_param($stmt, "i", $event_id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: admin.php");
exit();
?>
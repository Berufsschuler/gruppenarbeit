<?php
session_start();
require_once("database.php");

// Admin check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

// Alle Rollen aus dem Formular aktualisieren
if (isset($_POST['role']) && is_array($_POST['role'])) {
    foreach ($_POST['role'] as $id => $role) {
        $id = intval($id);
        $role = $role === 'admin' ? 'admin' : 'user';
        $stmt = mysqli_prepare($conn, "UPDATE users SET role = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $role, $id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: admin.php");
exit();

<?php
session_start();
require_once("database.php");

if (!isset($_SESSION["user_id"])) {
    die("Nicht eingeloggt");
}

$user_id = $_SESSION["user_id"];

/* --- Cookies erhöhen --- */
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "UPDATE users SET cookies = cookies + 1 WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

/* --- Counter auslesen --- */
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT cookies FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

echo "Counter: " . $row["cookies"];

mysqli_stmt_close($stmt);
?>

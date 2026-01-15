<?php
session_start();
require_once("database.php");

if (!isset($_SESSION["user_id"])) {
    die("Nicht eingeloggt");
}

$user_id = $_SESSION["user_id"];

/* --- Cookies erhöhen --- */

$plusAmount = 1;

$eventQuery = "SELECT COUNT(*) AS active FROM events WHERE title = 'Double Cookies Day' AND is_active = 1";
$result = mysqli_query($conn, $eventQuery);
$row = mysqli_fetch_assoc($result);

if ($row['active'] > 0) {
    $plusAmount = 2; // Event aktiv → 2 Cookies pro Klick
}

$stmt = mysqli_prepare($conn, "UPDATE users SET cookies = cookies + ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ii", $plusAmount, $user_id);
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

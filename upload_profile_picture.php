<?php
session_start();
require_once("database.php");

if (!isset($_SESSION["user_id"])) {
    exit();
}

$user_id = $_SESSION["user_id"];

/* Altes Bild holen */
$stmt = mysqli_prepare($conn, "SELECT profile_picture FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute(statement: $stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$old_picture = $row['profile_picture'] ?? null;

/* Datei prüfen */
if (!isset($_FILES["profile_picture"])) {
    exit();
}

$file = $_FILES["profile_picture"];
$ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

if (!in_array($ext, ["jpg", "jpeg", "png"])) {
    exit();
}

/* Neues Bild speichern */
$newName = $user_id . "_" . time() . "." . $ext;
$path = "server_img/" . $newName;

move_uploaded_file($file["tmp_name"], $path);

/* Altes Bild löschen */
if ($old_picture && file_exists("server_img/" . $old_picture)) {
    unlink("server_img/" . $old_picture);
}

/* DB updaten */
$stmt = mysqli_prepare($conn, "UPDATE users SET profile_picture = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "si", $newName, $user_id);
mysqli_stmt_execute($stmt);

echo $newName;

<?php
session_start();

// Session prüfen
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// DB-Verbindung
require_once("database.php");

// User aus der DB holen
$user_id = $_SESSION["user_id"];
$stmt = mysqli_prepare($conn, "SELECT username, email, `role` FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username']; // Username statt full_name
    $role = $row['role'];         // hier holen wir die Rolle dynamisch
} else {
    // Ungültige Session → Logout erzwingen
    session_destroy();
    header("Location: login.php");
    exit();
}

?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Competitive Cookie Clicker</title>
    <link rel="stylesheet" href="style_user.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap"
      rel="stylesheet"
    />
  </head>
<body>
      <header>
        <div class="hname">
          <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
        </div>

        <?php if($role === 'admin'): ?>
            <a href="admin.php"><button>Admin Panel</button></a>
        <?php endif; ?>

        <div class="login_icon_container">
          <div class="login_icon"></div>
        </div>
        
      </header>

    <div>
        
      <div id="mainCookie">
      <div id="mainCookiepng"></div>
      <div id="mainCookieCounter">Counter: </div>
      </div>

    </div>



    <footer class="main-footer">
      <div class="fname">
        <h1><c style="color: #9c8809">CCookie </c>Clicker</h1>
      </div>
      <div id="creators">Made by: Aleksandar Tesinic & Paul Heigl</div>
      <div class="ficon">
        <div class="fpicture"></div>
      </div>
    </footer>
    <script src="call_update_perClick.js"></script>
</body>
</html>
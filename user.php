<?php
session_start();

// Session prüfen
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
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

// Cookie Count
$count = isset($_COOKIE['cookieCount']) ? intval($_COOKIE['cookieCount']) : 0;
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


        <p class="menu_icon">☰</p> 
      </header>

    <div>
        
      <div id="mainCookie">
      <div id="tryCookie" style="width:300px; height:300px; background-image:url('./img/cookie_1.png'); background-size:cover; cursor:pointer;"></div>
      <div id="tryCookieCounter" style="font-size:30px;">Counter: <?php echo $count; ?></div>
      </div>

      <div id="mainThree">
      <div class="leaderboard-section">
      <h1 id="ClimbUpTheLadder">CLIMB UP THE&nbsp;<span style="color:#9c8809">LADDER!</span></h1>

        <div class="leaderboard">
          <div class="entry">
            <span class="rank">1</span>
            <span class="name">SteelFort</span>
            <span class="points">245 270 Cookies</span>
          </div>

          <div class="entry highlight">
            <span class="rank">2</span>
            <span class="name">Nagrarok</span>
            <span class="points">221 564 Cookies</span>
            <span class="rank-arrow">▲</span>
          </div>

          <div class="entry">
            <span class="rank">3</span>
            <span class="name">MissRubis</span>
            <span class="points">201 054 Cookies</span>
          </div>

          <div class="entry">
            <span class="rank">4</span>
            <span class="name">RaptorTwo</span>
            <span class="points">180 874 Cookies</span>
          </div>
          </div>
        </div>
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
    <script src="cookieClickTest.js"></script>
</body>
</html>
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
    $role = $row['role'];
} else {
    // Ungültige Session => Logout erzwingen
    session_destroy();
    header("Location: login.php");
    exit();
}

//Cookies anzahl kontrollieren:
$stmt = mysqli_prepare($conn, "SELECT cookies FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$my_cookies = $row['cookies'];


//Position finden
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS rank FROM users WHERE cookies > ?");
mysqli_stmt_bind_param($stmt, "i", $my_cookies);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$my_position = $row['rank'] + 1;



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

    <div id="mySidepanel" class="sidepanel">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"></a>
      <a onclick="openExplorer()">Change Profile Picture</a>
      <a href="logout.php">Logout</a>
      <input type="file" id="fileInput" accept=".jpg,.jpeg,.png" style="display:none">
    </div>

    <script>
    
    function openExplorer() {
      document.getElementById("fileInput").click();
    }

    document.getElementById("fileInput").addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;

      const imageURL = URL.createObjectURL(file);

      const previewDiv = document.getElementById("login_icon");
      previewDiv.style.backgroundImage = `url('${imageURL})')`;
    })

    </script>


    <div class="login_icon_container">
      <div id="login_icon" onclick="changeNav()"></div>
    </div>
    
    <script>
      let open = false;
      function changeNav() {
        if(open == false){
          document.getElementById("mySidepanel").style.width = "465px";
          open = true;
        } else {
          document.getElementById("mySidepanel").style.width = "0px";
          open = false;
        }
      }
    </script>

  </header>


  <?php
    // Leaderboard-Daten holen
    $leaderboard = [];
    $stmt = mysqli_prepare($conn, "SELECT username, cookies FROM users ORDER BY cookies DESC");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while($row = mysqli_fetch_assoc($result)) {
        $leaderboard[] = $row;
    }
  ?>

  <div id="leaderboard">
    <h2>🍪 Leaderboard 🍪</h2>
    
    <div id="leaderboardLadder">
      <?php foreach($leaderboard as $index => $user): ?>
        <div class="leaderboard_element">
          <?= ($index + 1) ?>. <?= htmlspecialchars($user['username']) ?> | <?= $user['cookies'] ?> 🍪
        </div>
      <?php endforeach; ?>
    </div>

    <div id="leaderboardPosition">
      <p>Your Position: <?= $my_position ?>.</p>
    </div>
  </div>
  

    <div>
        
      <div id="mainCookie">
      <div id="mainCookiepng"></div>
      <div id="mainCookieCounter">Counter: <?= $my_cookies?></div>
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

      <a href="impressum.html" style="color:white">IMPRESSUM</a>

    </footer>
    <script src="call_update_perClick.js"></script>
</body>
</html>
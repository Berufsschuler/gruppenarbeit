
<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}
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
        <div class="hicon">
          <div class="hpicture"></div>
        </div>
      </header>
      
      <div>☰</div>

      <div id="mainCookie">
      <div id="tryCookie" style="width:300px; height:300px; background-image:url('./img/cookie_1.png'); background-size:cover; cursor:pointer;"></div>
      <div id="tryCookieCounter" style="font-size:30px;">Counter: <?php echo $count; ?></div>
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